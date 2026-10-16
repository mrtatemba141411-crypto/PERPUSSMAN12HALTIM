# Perpustakaan Kita

Aplikasi perpustakaan sederhana berbasis Laravel 12 dan MySQL. Fitur: katalog buku dengan pencarian, data anggota (tambah, lihat, edit, hapus) beserta kartu QR, pencatatan kunjungan anggota melalui scan QR, pencatatan peminjaman, menu pengembalian, serta laporan PDF peminjaman dan pengembalian dengan filter periode. Perubahan pengembalian menyesuaikan stok buku secara otomatis.

## Kebutuhan

- PHP 8.2+ dengan ekstensi PDO MySQL
- Composer 2
- MySQL 8+ atau MariaDB

## Menjalankan aplikasi

1. Buat database MySQL bernama `perpustakaan` (atau sesuaikan `.env`).
2. Salin `.env.example` menjadi `.env`, lalu isi kredensial database.
3. Jalankan perintah berikut dari folder proyek:

```sh
composer install
php artisan key:generate
php artisan migrate
```

4. Buat akun pertama melalui perintah interaktif:

```sh
php artisan app:create-user
```

5. Jalankan `php artisan serve`, buka `http://localhost:8000`, lalu masuk menggunakan username serta password yang dibuat.

Semua halaman katalog dan peminjaman memerlukan login. Password disimpan dalam bentuk hash.

Untuk mencatat kunjungan, tambahkan anggota terlebih dahulu, buka kartu QR anggota dari menu **Anggota**, lalu scan QR tersebut pada menu **Pengunjung**. Izinkan akses kamera di browser. Pencarian katalog mencocokkan judul, penulis, penerbit, dan ISBN.
