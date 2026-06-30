# Sistem Informasi Akademik Sederhana

Aplikasi SIAKAD sederhana berbasis Laravel yang dibuat untuk memenuhi Tugas Besar Mata Kuliah Pemrograman Web Lanjut.

Aplikasi menyediakan pengelolaan data dosen, mahasiswa, mata kuliah, jadwal perkuliahan, serta Kartu Rencana Studi (KRS).

## Fitur Aplikasi

### Authentication dan Authorization

* Login dan logout
* Role Admin
* Role Mahasiswa
* Pembatasan halaman menggunakan middleware
* Mengganti nama profil dan password

### Fitur Admin

* Dashboard statistik
* CRUD data dosen
* CRUD data mahasiswa
* CRUD data mata kuliah
* CRUD jadwal perkuliahan
* Menentukan dosen pengajar
* Menentukan mata kuliah
* Menentukan kelas, hari, dan jam
* Melihat seluruh data KRS mahasiswa
* Pencarian dan filter data

### Fitur Mahasiswa

* Melihat dashboard mahasiswa
* Melihat jadwal perkuliahan
* Mengambil mata kuliah melalui KRS
* Melihat KRS yang sudah diambil
* Drop mata kuliah dari KRS
* Melihat jumlah mata kuliah dan total SKS
* Mengunduh KRS dalam format PDF

## Teknologi yang Digunakan

* PHP 8.2
* Laravel 12
* MySQL
* Blade Template
* HTML
* CSS
* Laravel Eloquent ORM
* Laravel Middleware
* DomPDF
* XAMPP

## Struktur Database

Aplikasi menggunakan tabel:

* users
* dosen
* mahasiswa
* matakuliah
* jadwal
* krs

Relasi utama:

* Jadwal terhubung dengan dosen
* Jadwal terhubung dengan mata kuliah
* KRS terhubung dengan mahasiswa
* KRS terhubung dengan mata kuliah

## Fungsi Halaman

### Halaman Login

Digunakan oleh Admin dan Mahasiswa untuk masuk ke dalam aplikasi.

### Dashboard Admin

Menampilkan jumlah dosen, mahasiswa, mata kuliah, dan jadwal. Dashboard juga menyediakan menu menuju halaman pengelolaan data.

### Data Dosen

Digunakan untuk menambah, melihat, mencari, mengedit, dan menghapus data dosen.

### Data Mahasiswa

Digunakan untuk menambah, melihat, mencari, mengedit, dan menghapus data mahasiswa.

### Data Mata Kuliah

Digunakan untuk mengelola kode mata kuliah, nama mata kuliah, dan jumlah SKS.

### Jadwal Perkuliahan

Digunakan untuk menentukan mata kuliah, dosen pengajar, kelas, hari, dan jam perkuliahan.

### Data KRS Admin

Digunakan oleh Admin untuk melihat seluruh mata kuliah yang diambil mahasiswa.

### Dashboard Mahasiswa

Menampilkan identitas mahasiswa, jumlah mata kuliah yang diambil, dan total SKS.

### Jadwal Mahasiswa

Digunakan mahasiswa untuk melihat jadwal perkuliahan yang tersedia.

### KRS Mahasiswa

Digunakan mahasiswa untuk mengambil mata kuliah, melihat KRS, drop mata kuliah, dan mengunduh KRS dalam format PDF.

## LINK HOSTING
siakad.infy.click

## Akun Demo

### Admin

text
Email    : admin@siakad.test
Password : password


### Mahasiswa

text
Email    : mahasiswa@siakad.test
Password : password

note: saya tidak memasukkan data-data nya di seeder, jadi datanya dimasukan manual lewat si app siakad nya langsung
