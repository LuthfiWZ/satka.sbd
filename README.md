# Aplikasi Edukasi Satwa Indonesia

Aplikasi ini adalah sistem edukasi tentang satwa Indonesia yang dibangun dengan PHP dan MySQL. Sistem ini menyediakan fungsi CRUD (Create, Read, Update, Delete) untuk mengelola data satwa, kategori, game, quiz, dan pengguna. Aplikasi ini dirancang untuk membantu edukasi tentang keanekaragaman hayati Indonesia melalui permainan dan kuis interaktif.

## Deskripsi

Aplikasi ini menyediakan beberapa modul utama untuk mengelola berbagai aspek sistem:
- **GAME**: Manajemen permainan edukasi
- **KATEGORI**: Pengelompokan satwa berdasarkan kategori
- **QUIZ**: Kuis edukasi tentang satwa
- **SATWA**: Informasi tentang berbagai jenis satwa
- **SATWA_KATEGORI**: Relasi antara satwa dan kategori
- **USERS**: Manajemen pengguna dan poin

Semua endpoint mengembalikan respons dalam format JSON.

## Struktur Tabel

Berikut adalah struktur tabel dalam database `satka_db`:

### Tabel `game`
| Kolom       | Tipe Data | Deskripsi                    |
|-------------|-----------|------------------------------|
| id          | INT       | Primary Key, Auto Increment  |
| nama_game   | VARCHAR   | Nama permainan               |
| deskripsi   | TEXT      | Deskripsi permainan          |
| tipe_game   | VARCHAR   | Jenis permainan              |
| url_game    | VARCHAR   | URL permainan                |

### Tabel `kategori`
| Kolom           | Tipe Data | Deskripsi                    |
|-----------------|-----------|------------------------------|
| id              | INT       | Primary Key, Auto Increment  |
| nama_kategori   | VARCHAR   | Nama kategori satwa          |
| deskripsi       | TEXT      | Deskripsi kategori           |

### Tabel `quiz`
| Kolom               | Tipe Data | Deskripsi                    |
|---------------------|-----------|------------------------------|
| id                  | INT       | Primary Key, Auto Increment  |
| pertanyaan          | TEXT      | Isi pertanyaan kuis          |
| pilihan_a           | TEXT      | Pilihan jawaban A            |
| pilihan_b           | TEXT      | Pilihan jawaban B            |
| pilihan_c           | TEXT      | Pilihan jawaban C            |
| pilihan_d           | TEXT      | Pilihan jawaban D            |
| jawaban_benar       | VARCHAR   | Jawaban benar (A/B/C/D)      |
| penjelasan          | TEXT      | Penjelasan jawaban           |
| tingkat_kesulitan   | VARCHAR   | Tingkat kesulitan kuis       |
| satwa_id            | INT       | Foreign Key ke tabel satwa   |

### Tabel `satwa`
| Kolom           | Tipe Data | Deskripsi                    |
|-----------------|-----------|------------------------------|
| id              | INT       | Primary Key, Auto Increment  |
| nama_indonesia  | VARCHAR   | Nama satwa dalam bahasa Indonesia |
| nama_inggris    | VARCHAR   | Nama satwa dalam bahasa Inggris |
| nama_latin      | VARCHAR   | Nama ilmiah satwa            |
| deskripsi       | TEXT      | Deskripsi tentang satwa      |
| habitat         | VARCHAR   | Habitat alami satwa          |
| makanan         | VARCHAR   | Jenis makanan satwa          |
| status_konservasi | VARCHAR | Status konservasi satwa      |
| gambar_url      | VARCHAR   | URL gambar satwa             |

### Tabel `satwa_kategori`
| Kolom        | Tipe Data | Deskripsi                    |
|--------------|-----------|------------------------------|
| id           | INT       | Primary Key, Auto Increment  |
| satwa_id     | INT       | Foreign Key ke tabel satwa   |
| kategori_id  | INT       | Foreign Key ke tabel kategori|

### Tabel `users`
| Kolom        | Tipe Data | Deskripsi                    |
|--------------|-----------|------------------------------|
| id           | INT       | Primary Key, Auto Increment  |
| username     | VARCHAR   | Nama pengguna unik           |
| email        | VARCHAR   | Email pengguna               |
| peran        | VARCHAR   | Peran pengguna (admin/user)  |
| poin_total   | INT       | Jumlah poin yang dimiliki    |

## Modul GAME

### CREATE - Menambahkan Data Game Baru

**URL**: `/game/create.php`

**Metode**: POST

**Parameter**:
- `nama_game` (string) - Nama permainan
- `deskripsi` (string) - Deskripsi permainan
- `tipe_game` (string) - Jenis permainan
- `url_game` (string) - URL permainan

**Contoh Request**:
```bash
curl -X POST \
  -d "nama_game=Tebak Satwa" \
  -d "deskripsi=Permainan tebak nama satwa berdasarkan gambar" \
  -d "tipe_game=Tebak Gambar" \
  -d "url_game=/games/tebak-satwa" \
  http://localhost/BE-Latihan-kelas/game/create.php
```

### READ - Membaca Data Game

**URL**: `/game/read.php`

**Metode**: GET

**Parameter (Opsional)**:
- `id` (integer) - Untuk mendapatkan data game berdasarkan ID

Jika tidak ada parameter, maka akan mengembalikan semua data game.

### UPDATE - Memperbarui Data Game

**URL**: `/game/update.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID game yang akan diperbarui
- `nama_game` (string) - Nama permainan baru
- `deskripsi` (string) - Deskripsi permainan baru
- `tipe_game` (string) - Jenis permainan baru
- `url_game` (string) - URL permainan baru

### DELETE - Menghapus Data Game

**URL**: `/game/delete.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID game yang akan dihapus

## Modul KATEGORI

### CREATE - Menambahkan Data Kategori Baru

**URL**: `/kategori/create.php`

**Metode**: POST

**Parameter**:
- `nama_kategori` (string) - Nama kategori satwa
- `deskripsi` (string) - Deskripsi kategori

**Contoh Request**:
```bash
curl -X POST \
  -d "nama_kategori=Mamalia" \
  -d "deskripsi=Hewan menyusui yang termasuk dalam kingdom animalia" \
  http://localhost/BE-Latihan-kelas/kategori/create.php
```

### READ - Membaca Data Kategori

**URL**: `/kategori/read.php`

**Metode**: GET

**Parameter (Opsional)**:
- `id` (integer) - Untuk mendapatkan data kategori berdasarkan ID

Jika tidak ada parameter, maka akan mengembalikan semua data kategori.

### UPDATE - Memperbarui Data Kategori

**URL**: `/kategori/update.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID kategori yang akan diperbarui
- `nama_kategori` (string) - Nama kategori baru
- `deskripsi` (string) - Deskripsi kategori baru

### DELETE - Menghapus Data Kategori

**URL**: `/kategori/delete.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID kategori yang akan dihapus

## Modul QUIZ

### CREATE - Menambahkan Data Quiz Baru

**URL**: `/quiz/create.php`

**Metode**: POST

**Parameter**:
- `pertanyaan` (string) - Isi pertanyaan kuis
- `pilihan_a` (string) - Pilihan jawaban A
- `pilihan_b` (string) - Pilihan jawaban B
- `pilihan_c` (string) - Pilihan jawaban C
- `pilihan_d` (string) - Pilihan jawaban D
- `jawaban_benar` (string) - Jawaban benar (A/B/C/D)
- `penjelasan` (string) - Penjelasan jawaban
- `tingkat_kesulitan` (string) - Tingkat kesulitan kuis
- `satwa_id` (integer) - ID satwa terkait

**Contoh Request**:
```bash
curl -X POST \
  -d "pertanyaan=Apa nama satwa endemik Indonesia yang dikenal dengan julukan harimau Sumatra?" \
  -d "pilihan_a=Harimau Bali" \
  -d "pilihan_b=Harimau Jawa" \
  -d "pilihan_c=Harimau Sumatra" \
  -d "pilihan_d=Harimau Malayan" \
  -d "jawaban_benar=C" \
  -d "penjelasan=Harimau Sumatra adalah subspesies harimau yang hanya ditemukan di Pulau Sumatra." \
  -d "tingkat_kesulitan=Sedang" \
  -d "satwa_id=1" \
  http://localhost/BE-Latihan-kelas/quiz/create.php
```

### READ - Membaca Data Quiz

**URL**: `/quiz/read.php`

**Metode**: GET

**Parameter (Opsional)**:
- `id` (integer) - Untuk mendapatkan data quiz berdasarkan ID
- `satwa_id` (integer) - Untuk mendapatkan quiz berdasarkan satwa

Jika tidak ada parameter, maka akan mengembalikan semua data quiz.

### UPDATE - Memperbarui Data Quiz

**URL**: `/quiz/update.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID quiz yang akan diperbarui
- `pertanyaan` (string) - Isi pertanyaan kuis baru
- `pilihan_a` (string) - Pilihan jawaban A baru
- `pilihan_b` (string) - Pilihan jawaban B baru
- `pilihan_c` (string) - Pilihan jawaban C baru
- `pilihan_d` (string) - Pilihan jawaban D baru
- `jawaban_benar` (string) - Jawaban benar baru (A/B/C/D)
- `penjelasan` (string) - Penjelasan jawaban baru
- `tingkat_kesulitan` (string) - Tingkat kesulitan kuis baru
- `satwa_id` (integer) - ID satwa terkait baru

### DELETE - Menghapus Data Quiz

**URL**: `/quiz/delete.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID quiz yang akan dihapus

## Modul SATWA

### CREATE - Menambahkan Data Satwa Baru

**URL**: `/satwa/create.php`

**Metode**: POST

**Parameter**:
- `nama_indonesia` (string) - Nama satwa dalam bahasa Indonesia
- `nama_inggris` (string) - Nama satwa dalam bahasa Inggris
- `nama_latin` (string) - Nama ilmiah satwa
- `deskripsi` (string) - Deskripsi tentang satwa
- `habitat` (string) - Habitat alami satwa
- `makanan` (string) - Jenis makanan satwa
- `status_konservasi` (string) - Status konservasi satwa
- `gambar_url` (string) - URL gambar satwa

**Contoh Request**:
```bash
curl -X POST \
  -d "nama_indonesia=Harimau Sumatra" \
  -d "nama_inggris=Sumatran Tiger" \
  -d "nama_latin=Panthera tigris sumatrae" \
  -d "deskripsi=Harimau Sumatra adalah subspesies harimau yang hanya ditemukan di Pulau Sumatra." \
  -d "habitat=Hutan hujan tropis" \
  -d "makanan=Daging (karnivora)" \
  -d "status_konservasi=Terancam Punah" \
  -d "gambar_url=https://example.com/harimau-sumatra.jpg" \
  http://localhost/BE-Latihan-kelas/satwa/create.php
```

### READ - Membaca Data Satwa

**URL**: `/satwa/read.php`

**Metode**: GET

**Parameter (Opsional)**:
- `id` (integer) - Untuk mendapatkan data satwa berdasarkan ID
- `nama_indonesia` (string) - Untuk mendapatkan data satwa berdasarkan nama Indonesia

Jika tidak ada parameter, maka akan mengembalikan semua data satwa.

### UPDATE - Memperbarui Data Satwa

**URL**: `/satwa/update.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID satwa yang akan diperbarui
- `nama_indonesia` (string) - Nama satwa dalam bahasa Indonesia baru
- `nama_inggris` (string) - Nama satwa dalam bahasa Inggris baru
- `nama_latin` (string) - Nama ilmiah satwa baru
- `deskripsi` (string) - Deskripsi tentang satwa baru
- `habitat` (string) - Habitat alami satwa baru
- `makanan` (string) - Jenis makanan satwa baru
- `status_konservasi` (string) - Status konservasi satwa baru
- `gambar_url` (string) - URL gambar satwa baru

### DELETE - Menghapus Data Satwa

**URL**: `/satwa/delete.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID satwa yang akan dihapus

## Modul SATWA_KATEGORI

Modul ini mengelola relasi antara satwa dan kategori. Biasanya menggunakan endpoint standar CRUD seperti modul lainnya.

## Modul USERS

### CREATE - Menambahkan Data Pengguna Baru

**URL**: `/users/create.php`

**Metode**: POST

**Parameter**:
- `username` (string) - Nama pengguna unik
- `email` (string) - Email pengguna
- `peran` (string) - Peran pengguna (admin/user)
- `poin_total` (integer) - Jumlah poin yang dimiliki

**Contoh Request**:
```bash
curl -X POST \
  -d "username=johndoe" \
  -d "email=john@example.com" \
  -d "peran=user" \
  -d "poin_total=150" \
  http://localhost/BE-Latihan-kelas/users/create.php
```

### READ - Membaca Data Pengguna

**URL**: `/users/read.php`

**Metode**: GET

**Parameter (Opsional)**:
- `id` (integer) - Untuk mendapatkan data pengguna berdasarkan ID
- `username` (string) - Untuk mendapatkan data pengguna berdasarkan username

Jika tidak ada parameter, maka akan mengembalikan semua data pengguna.

### UPDATE - Memperbarui Data Pengguna

**URL**: `/users/update.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID pengguna yang akan diperbarui
- `username` (string) - Nama pengguna baru
- `email` (string) - Email pengguna baru
- `peran` (string) - Peran pengguna baru
- `poin_total` (integer) - Jumlah poin baru

### DELETE - Menghapus Data Pengguna

**URL**: `/users/delete.php`

**Metode**: POST

**Parameter**:
- `id` (integer) - ID pengguna yang akan dihapus

## Instalasi

1. Pastikan Anda memiliki server web dengan PHP dan MySQL
2. Salin semua file ke direktori web server Anda
3. Buat database MySQL bernama `satka_db`
4. Impor struktur tabel sesuai dengan deskripsi di atas
5. Konfigurasi koneksi database di file `db.php`
6. Akses endpoint sesuai kebutuhan

## Konfigurasi Database

Ubah konfigurasi di file `db.php` sesuai dengan lingkungan Anda:

```php
$servername = "localhost"; // Server database Anda
$username   = "root";      // Username database Anda
$password   = "";          // Password database Anda
$dbname     = "satka_db";  // Nama database Anda
```

## Catatan

- Semua endpoint mengembalikan respons dalam format JSON
- Gunakan metode POST untuk CREATE, UPDATE, dan DELETE
- Gunakan metode GET untuk READ
- Gunakan prepared statements untuk mencegah SQL injection
- Pastikan untuk selalu mengecek status respons sebelum memproses data lebih lanjut
- Aplikasi ini mendukung CORS untuk integrasi dengan frontend
- Gunakan header `Content-Type: application/json` saat mengirim data JSON