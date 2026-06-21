<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PdfRagService
{
    protected ChromaDBService $chromaDB;
    protected string $collectionName = 'archids_documents';

    public function __construct(ChromaDBService $chromaDB)
    {
        $this->chromaDB = $chromaDB;
    }

    /**
     * Parse PDF file, chunk text, and store in ChromaDB
     */
    public function processPdf(string $filePath, string $originalName, ?int $projectId): bool
    {
        try {
            // 1. Ekstrak Teks dari PDF
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();
            $text = preg_replace('/\s+/', ' ', $text);

            if (empty(trim($text))) {
                Log::warning("PDF was empty or unreadable: {$originalName}");
                return false;
            }

            // 2. Potong-potong teks (Chunking)
            $chunks = $this->chunkText($text, 1000, 200);

            // 3. Get or Create Collection di ChromaDB
            $collectionId = $this->chromaDB->getOrCreateCollection($this->collectionName);

            $ids = [];
            $embeddings = [];
            $documents = [];
            $metadatas = [];

            foreach ($chunks as $index => $chunk) {
                // Generate ID unik untuk setiap chunk
                $chunkId = md5($originalName . $index . time());
                $ids[] = $chunkId;
                
                // Hasilkan vektor embedding via API eksternal (misal OpenAI)
                $embeddings[] = $this->getEmbedding($chunk);
                
                $documents[] = $chunk;
                
                $metadatas[] = [
                    'source' => $originalName,
                    'chunk_index' => $index,
                    'project_id' => $projectId ?? 0,
                ];
            }

            // 4. Masukkan dokumen ke ChromaDB
            $this->chromaDB->addDocuments($collectionId, $ids, $embeddings, $documents, $metadatas);

            return true;
        } catch (\Exception $e) {
            Log::error('PdfRagService processing Error', [
                'file' => $originalName,
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Memotong teks menjadi array chunks
     */
    public function chunkText(string $text, int $chunkSize = 1000, int $overlap = 200): array
    {
        $chunks = [];
        $length = strlen($text);
        $i = 0;

        while ($i < $length) {
            $chunk = substr($text, $i, $chunkSize);
            $chunks[] = $chunk;
            $i += ($chunkSize - $overlap);
        }

        return $chunks;
    }

    public function getEmbedding(string $text): array
    {
        $apiKey = env('AIMLAPI_KEY', '890271b32e960a1bf58709fcd926d431');
        $baseUrl = env('AIMLAPI_BASE_URL', 'https://api.aimlapi.com/v1');

        $client = \OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri($baseUrl)
            ->make();

        $response = $client->embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => $text,
        ]);

        return $response->embeddings[0]->embedding;
    }

    /**
     * Search for relevant context in ChromaDB
     */
    public function searchRelevantContext(string $query, ?int $projectId, int $limit = 3): string
    {
        try {
            $collectionId = $this->chromaDB->getOrCreateCollection($this->collectionName);
            $queryEmbedding = $this->getEmbedding($query);
            $where = $projectId ? ['project_id' => $projectId] : null;
            
            $searchResult = $this->chromaDB->query($collectionId, [$queryEmbedding], $limit, $where);
            
            if (!empty($searchResult['documents'][0])) {
                $ragContext = "\nREFERENSI DATA DARI DOKUMEN PDF (Gunakan informasi ini untuk menjawab pertanyaan atau mengekstrak data jika relevan):\n";
                foreach ($searchResult['documents'][0] as $index => $docText) {
                    $ragContext .= "--- Bagian " . ($index + 1) . " ---\n" . $docText . "\n";
                }
                return $ragContext;
            }
        } catch (\Exception $e) {
            Log::warning("ChromaDB Query Failed: " . $e->getMessage());
        }
        
        return '';
    }
}
