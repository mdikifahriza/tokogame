![Screenshot]([https://user-images.githubusercontent.com/123456/abcdef.png](https://github.com/mdikifahriza/tokogame/issues/1#issue-3393455348))

# Tutorial Instalasi Web PHP Native

Proyek ini menggunakan **PHP Native** dengan database **MySQL**.
Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal menggunakan **Laragon**.

---

## 🚀 Persiapan

1. Pastikan sudah menginstal [Laragon](https://laragon.org/download/).
2. Ekstrak project ini ke folder `C:\laragon\www\` (atau folder `www` Laragon kamu).
3. Jalankan Laragon dan aktifkan **Apache** serta **MySQL**.

---

## 🗄️ Setup Database

1. Buka **phpMyAdmin** atau gunakan terminal MySQL.
2. Buat database baru dengan nama:

   ```sql
   CREATE DATABASE tokogame;
   ```
3. Import file SQL `tokogame.sql` yang ada di root project:

   * Masuk ke phpMyAdmin → pilih database **tokogame** → klik **Import**.
   * Pilih file `tokogame.sql` lalu jalankan.

---

## 🔧 Konfigurasi Koneksi

Edit file `/config/koneksi.php` dan sesuaikan dengan konfigurasi database Laragon:

```php
<?php
$host     = "localhost";
$user     = "root";       // default user Laragon
$password = "";           // default password kosong
$db       = "tokogame";

$koneksi = mysqli_connect($host, $user, $password, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

---

## ▶️ Menjalankan Project

1. Pastikan Apache & MySQL di Laragon sudah berjalan.
2. Buka browser dan akses:

   ```
   http://localhost/nama-folder-project
   ```

---

## 📂 Struktur Project (ringkas)

```
/config
    └── koneksi.php     -> file konfigurasi koneksi DB
/tokogame.sql           -> file untuk import database
/index.php              -> halaman utama
```

---

## 🔑 Login Akun

Gunakan akun berikut untuk masuk ke sistem:

* **Admin**
  Email: `admin@tokogame.com`
  Password: `admin`

---

## ✅ Selesai

Sekarang web sudah bisa dijalankan di lokal.
Jika ingin di-deploy ke hosting, pastikan menyesuaikan konfigurasi database di `/config/koneksi.php`.

