# Archids AI 🏛️🤖

**Archids AI** adalah inovasi Micro-CRM (Customer Relationship Management) berbasis *AI Agent* yang dirancang secara spesifik untuk memecahkan masalah administrasi para arsitek *freelance* dan studio desain. Aplikasi ini mengotomatiskan manajemen klien, proyek, dan penciptaan tagihan (invoice) menggunakan antarmuka *chat* natural layaknya asisten virtual pribadi, serta dilengkapi kemampuan "membaca" dokumen RAB proyek Anda.

Dibangun sebagai proyek akhir dengan mengimplementasikan metode **Rapid Application Development (RAD)**, sistem ini menggunakan tumpukan teknologi modern yang sangat efisien: **Laravel 12**, **Livewire v3**, **Tailwind CSS**, **ChromaDB** (Vector Database), **AIML API**, dan **Generative AI (DeepSeek-V4-Pro via Featherless.ai)**.

![Archids AI Preview](public/backgroud_asset/landingpage.png) *(Preview Aplikasi Archids AI)*

---

## 🌟 Mengapa Archids AI Berbeda?

Sebagian besar CRM arsitek berupa *form-based* (pengisian formulir manual). **Archids AI menggunakan pendekatan *Conversational Interface***. Arsitek cukup "mengobrol" dengan AI menggunakan bahasa sehari-hari. 

AI akan langsung memahami konteks obrolan, mengekstrak data persis ke dalam format JSON *(Function Calling)*, menampilkannya sebagai Kartu Konfirmasi visual, menyimpannya ke *Database* relasional, dan seketika mencetaknya dalam bentuk dokumen **PDF Blueprint-Style**.

Selain itu, Archids AI dibekali fitur **RAG (Retrieval-Augmented Generation)**. Anda dapat mengunggah file PDF (misal dokumen spesifikasi bangunan atau RAB), dan AI dapat mengingat serta menganalisis isi dokumen tersebut untuk membantu Anda dalam mengambil keputusan.

---

## ✨ Fitur Utama & Arsitektur Sistem

### 1. 🤖 AI Chat Assistant Terintegrasi (Function Calling)
- **Model Mutakhir**: Menggunakan `DeepSeek-V4-Pro` dari endpoint Featherless.ai untuk pemahaman konteks tingkat tinggi.
- **Extended Sliding Window Memory**: Mampu mengingat hingga **150 pesan terakhir**, memastikan konteks obrolan jangka panjang tidak hilang tanpa melewati batas *context window* 32k token.
- **Structured Data Extraction**: Memanfaatkan instruksi *Function Calling* (`prepare_invoice_draft`) yang memaksa AI merespons dengan JSON murni untuk membentuk tagihan otomatis.

### 2. 📚 Sistem RAG & Vector Database (PdfRagService)
- **PDF Parsing & Chunking**: Dokumen PDF otomatis diekstrak dan dipecah menjadi potongan teks (chunking) yang efisien.
- **Vektor Embeddings**: Menggunakan **AIML API** untuk menerjemahkan teks menjadi representasi vektor numerik tingkat tinggi.
- **ChromaDB**: Hasil vektor disimpan di dalam Chroma Database. Ketika user bertanya, sistem mencari konteks dokumen paling relevan (Vector Search) sebelum mengirimkannya ke LLM, mencegah AI berhalusinasi.

### 3. ⚡ Livewire v3 Modular UI Components
- **Modular Design**: Antarmuka dipisah menjadi komponen Blade yang dapat digunakan ulang (Reusable Components) seperti `x-chat.sidebar`, `x-chat.message-bubble`, `x-chat.invoice-draft`, dan `x-chat.input-area` (Prinsip Clean Architecture).
- **Context-Aware Header & Sidebar**: Manajemen multi-proyek dinamis di sidebar tanpa perpindahan halaman (SPA feel).
- **Asynchronous Processing**: Indikator mengetik animasi (typing indicator) dan pembekuan tombol saat AI memproses tanpa reload halaman.

### 4. 📄 Blueprint-Style PDF Generation
- Rendering PDF menggunakan `barryvdh/laravel-dompdf`.
- Desain *Monospace Minimalist* dengan susunan tabel HTML solid untuk menghindari masalah rendering layout CSS modern pada konversi PDF.

### 5. 🗄️ Relasional Database Management (MySQL)
Sistem menggunakan Eloquent ORM Laravel dengan integritas referensial kuat (*Cascade Deletion*):
- `users`, `clients`, `projects`, `invoices`: Manajemen CRM hierarkis.
- `chat_logs`: Perekaman riwayat obrolan AI yang persisten.
- `project_documents`: Pelacakan dokumen PDF yang terunggah dan terindeks di ChromaDB.

---

## 🛠️ Tech Stack & Ekosistem

| Lapisan | Teknologi | Penjelasan |
|---|---|---|
| **Backend Framework** | **Laravel 12 (PHP 8.2+)** | Framework PHP modern dan kuat. |
| **Frontend UI/UX** | **Livewire v3 & Tailwind CSS** | Interaktivitas real-time *Asynchronous* dengan Blade templating. |
| **Relational DB** | **MySQL** | Kuat dan tangguh untuk data finansial dan relasi CRM. |
| **Vector DB** | **ChromaDB** | Database khusus penyimpanan vektor untuk pencarian konteks dokumen (RAG). |
| **LLM Inference** | **Featherless.ai (DeepSeek-V4-Pro)** | Mesin kognitif utama untuk percakapan dan *Function Calling*. |
| **Embeddings** | **AIML API** | Mengonversi chunking dokumen PDF menjadi vektor semantik. |

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat Sistem
- PHP >= 8.2 (Ekstensi `zip`, `dom`, `gd`, `fileinfo` aktif)
- Composer & NPM
- MySQL Database Engine
- Python (Opsional jika ingin menjalankan ekstensi tertentu)

### 2. Instalasi Dependensi
```bash
git clone https://github.com/wmaulanaaishq/Archids-AI.git
cd Archids-AI
composer install
npm install && npm run build
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi:
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan `.env` Anda dengan kredensial database dan API:
```env
DB_DATABASE=archiagent_db
DB_USERNAME=root
DB_PASSWORD=

OPENAI_API_KEY=your_featherless_api_key_here
OPENAI_BASE_URL=https://api.featherless.ai/v1

ARCHIAI_MODEL=deepseek-ai/DeepSeek-V4-Pro
ARCHIAI_MAX_HISTORY=150

CHROMA_HOST=api.trychroma.com
CHROMA_API_KEY=your_chroma_api_key_here
CHROMA_TENANT=your_tenant_id
CHROMA_DATABASE=archidsAI

AIMLAPI_KEY=your_aiml_api_key_here
```

### 4. Migrasi Database & Seeding
```bash
php artisan migrate
```

### 5. Jalankan Aplikasi
```bash
php artisan serve
```
Akses di browser Anda: `http://127.0.0.1:8000`
