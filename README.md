# ArchiAgent 🏛️🤖

**ArchiAgent** adalah Micro-CRM berbasis AI Agent yang dirancang khusus untuk membantu freelance arsitek dalam mengelola proyek, klien, dan pembuatan tagihan (invoice) secara otomatis melalui antarmuka *chat* interaktif. 

Aplikasi ini dibangun sebagai proyek UAS Semester 4, menggabungkan kekuatan Laravel 11, Livewire v3, Tailwind CSS, dan integrasi Artificial Intelligence (AI) menggunakan DeepSeek-V4-Pro via Featherless.ai.

![ArchiAgent Preview](https://via.placeholder.com/800x400.png?text=ArchiAgent+-+AI+Invoice+Assistant) <!-- Silakan ganti dengan screenshot aplikasi Anda -->

---

## ✨ Fitur Utama

### 1. 🤖 AI Chat Assistant (Function Calling)
- Interaksi natural menggunakan Bahasa Indonesia.
- **Sliding Window Memory**: AI mengingat konteks percakapan (hingga 20 pesan terakhir).
- **Auto Data Extraction**: AI otomatis mengekstrak informasi penting dari percakapan (Nama Klien, Proyek, No Invoice, Termin, Persentase, dan Nominal) berkat fitur *Function Calling*.

### 2. ⚡ Livewire v3 Chat Workspace
- UI/UX modern dengan desain *Glassmorphism* dan mode gelap (Dark Theme).
- **Real-time Feedback**: Animasi *typing indicator* dan proses *loading* asinkron tanpa reload halaman.
- **Visual Confirmation Card**: Menampilkan ringkasan draf invoice hasil ekstraksi AI sebelum disimpan ke database.

### 3. 📄 Blueprint-Style PDF Export
- Menghasilkan PDF invoice dengan nilai estetika tinggi bergaya *Monospace Minimalist* khas arsitek.
- Kustomisasi warna aksen, logo studio, dan detail rekening (*Payment Terms*) melalui tabel `invoice_settings`.
- Menggunakan `barryvdh/laravel-dompdf` dengan struktur HTML murni dan *inline CSS* agar hasil render stabil.

### 4. 🗄️ Relasional Database Management
- Struktur database rapi menggunakan Eloquent ORM: `Users`, `InvoiceSettings`, `Clients`, `Projects`, dan `Invoices`.
- Sistem fallback otomatis (Pembuatan record Client & Project otomatis jika belum ada di database).

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Livewire v3, Tailwind CSS, Alpine.js (bawaan Livewire)
- **Database**: MySQL
- **AI Integration**: Featherless.ai (Model: `deepseek-ai/DeepSeek-V4-Pro`)
- **PDF Generator**: barryvdh/laravel-dompdf
- **HTTP Client**: Guzzle (Laravel HTTP Client)

---

## 🚀 Panduan Instalasi

### 1. Prasyarat
- PHP >= 8.2 (Ekstensi: `zip`, `dom`, `gd`)
- Composer
- MySQL (XAMPP / Laragon / dsb)

### 2. Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/wmaulanaaishq/Archids-AI.git
cd Archids-AI

# 2. Install dependensi PHP
composer install

# 3. Setup file environment
cp .env.example .env

# 4. Generate Application Key
php artisan key:generate
```

### 3. Konfigurasi `.env`
Buka file `.env` dan atur koneksi database serta kredensial API AI:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=archiagent_db # Pastikan database ini sudah dibuat
DB_USERNAME=root
DB_PASSWORD=

# Featherless.ai API (OpenAI Compatible)
OPENAI_API_KEY=your_featherless_api_key_here
OPENAI_BASE_URL=https://api.featherless.ai/v1
OPENAI_REQUEST_TIMEOUT=60

# ArchiAI Custom Settings
ARCHIAI_MODEL=deepseek-ai/DeepSeek-V4-Pro
ARCHIAI_MAX_HISTORY=20
```

### 4. Jalankan Migrasi & Seeding Dummy User
```bash
php artisan migrate

# (Opsional) Buat user demo untuk testing
mysql -u root archiagent_db -e "INSERT INTO users (id, name, email, password, created_at, updated_at) VALUES (1, 'Arsitek Demo', 'demo@archiagent.test', 'password', NOW(), NOW());"
```

### 5. Jalankan Server Development
```bash
php artisan serve
```
Aplikasi dapat diakses di `http://127.0.0.1:8000`.

---

## 🏗️ Struktur Proyek (Fase Pengembangan)

Pengembangan aplikasi ini dibagi menjadi 4 fase utama:
1. **Fase 1**: Setup Database, Migrations (5 tabel dengan cascade delete), dan Eloquent Models.
2. **Fase 2**: Implementasi `ArchiAIService` menggunakan HTTP Client ke Featherless.ai, integrasi *Sliding Window Memory*, dan *Function Calling*.
3. **Fase 3**: Pembuatan UI/UX dengan komponen `ChatWorkspace` Livewire v3 dan Tailwind CSS.
4. **Fase 4**: Pembuatan fitur cetak PDF (*Monospace Minimalist*) menggunakan DomPDF dengan konfigurasi dari `InvoiceController`.
