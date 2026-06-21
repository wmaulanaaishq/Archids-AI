<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChromaDBService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $tenant;
    protected string $database;

    public function __construct()
    {
        $host = env('CHROMA_HOST', 'api.trychroma.com');
        $this->tenant = env('CHROMA_TENANT', '');
        $this->database = env('CHROMA_DATABASE', '');
        
        // Use v2 API paths for Cloud
        $this->baseUrl = "https://{$host}/api/v2/tenants/{$this->tenant}/databases/{$this->database}";
        
        $this->apiKey = env('CHROMA_API_KEY', '');
    }

    protected function client()
    {
        return Http::withHeaders([
            'x-chroma-token' => $this->apiKey,
        ])->baseUrl($this->baseUrl);
    }

    /**
     * Get or create a collection
     */
    public function getOrCreateCollection(string $name)
    {
        // Try to get existing collections
        $response = $this->client()->get('/collections');
        
        if ($response->successful()) {
            $data = $response->json();
            $collections = isset($data['value']) ? $data['value'] : $data;
            
            // In ChromaDB Cloud, sometimes the response is directly the array, sometimes paginated.
            // Assuming array here.
            foreach ($collections as $collection) {
                if (isset($collection['name']) && $collection['name'] === $name) {
                    return $collection['id'];
                }
            }
        }

        // Create if not found
        $createResponse = $this->client()->post("/collections", [
            'name' => $name,
            'metadata' => ['description' => 'ArchiAgent Document Chunks']
        ]);

        if ($createResponse->successful()) {
            return $createResponse->json()['id'];
        }

        Log::error('ChromaDB Error creating collection', [
            'response' => $createResponse->json(),
            'status' => $createResponse->status()
        ]);
        throw new \Exception('Failed to create ChromaDB collection');
    }

    /**
     * Add documents and embeddings to collection
     */
    public function addDocuments(string $collectionId, array $ids, array $embeddings, array $documents, array $metadatas)
    {
        $response = $this->client()->post("/collections/{$collectionId}/add", [
            'ids' => $ids,
            'embeddings' => $embeddings,
            'documents' => $documents,
            'metadatas' => $metadatas,
        ]);

        if (!$response->successful()) {
            Log::error('ChromaDB Error adding documents', [
                'response' => $response->json(),
                'status' => $response->status()
            ]);
            throw new \Exception('Failed to add documents to ChromaDB');
        }

        return true;
    }

    /**
     * Query documents
     */
    public function query(string $collectionId, array $queryEmbeddings, int $nResults = 3, ?array $where = null)
    {
        $payload = [
            'query_embeddings' => $queryEmbeddings,
            'n_results' => $nResults,
        ];

        if ($where !== null) {
            $payload['where'] = $where;
        }

        $response = $this->client()->post("/collections/{$collectionId}/query", $payload);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('ChromaDB Error querying', [
            'response' => $response->json(),
            'status' => $response->status()
        ]);
        throw new \Exception('Failed to query ChromaDB');
    }
}
