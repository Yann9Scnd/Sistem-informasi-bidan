# Sistem Informasi Bidan

<p align="center">
  <img src="https://cdn-icons-png.flaticon.com/512/2966/2966486.png" width="180" alt="Logo Sistem Informasi Bidan">
</p>

<p align="center">
  <b>Aplikasi Management Informasi Pasien Bidan</b><br>
  Digunakan untuk membantu proses pendataan pasien, pemeriksaan, dan anamnesa pasien secara digital.
</p>

---

## Tentang Project

Sistem Informasi Bidan adalah aplikasi berbasis web yang dibuat untuk membantu bidan dalam mengelola data pasien secara lebih cepat, rapi, dan efisien.

Aplikasi ini memungkinkan bidan untuk:

* Menambahkan data pasien baru
* Mengelola informasi pasien
* Melakukan pencatatan anamnesa pasien
* Menyimpan riwayat pemeriksaan pasien
* Mengelola data pemeriksaan kesehatan
* Mempermudah pencarian data pasien
* Membantu proses administrasi klinik atau praktik bidan

Project ini dibangun menggunakan framework **Laravel** sehingga memiliki struktur aplikasi yang modern, aman, dan mudah dikembangkan.

---

## Fitur Utama

### 👩‍⚕️ Management Pasien

* Tambah data pasien
* Edit data pasien
* Hapus data pasien
* Pencarian data pasien

### 🩺 Anamnesa Pasien

* Keluhan pasien
* Riwayat penyakit
* Hasil pemeriksaan awal
* Catatan tindakan bidan

### 📋 Data Pemeriksaan

* Riwayat pemeriksaan pasien
* Status pemeriksaan
* Informasi tindakan medis

### 🔐 Authentication

* Login admin / bidan
* Keamanan akses sistem

---

## Teknologi yang Digunakan

* Laravel
* PHP
* MySQL
* Blade Template
* Bootstrap / Tailwind CSS
* JavaScript

---

## Instalasi Project

Clone repository:

```bash
git clone https://github.com/Yann9Scnd/Sistem-informasi-bidan.git
```

Masuk ke folder project:

```bash
cd Sistem-informasi-bidan
```

Install dependency:

```bash
composer install
```

Copy file environment:

```bash
cp .env.example .env
```

Generate key Laravel:

```bash
php artisan key:generate
```

Atur database pada file `.env`

Lalu jalankan migration:

```bash
php artisan migrate
```

Menjalankan server:

```bash
php artisan serve
```

---

## Tujuan Project

Project ini dibuat untuk membantu digitalisasi pelayanan kesehatan khususnya pada praktik bidan agar proses pendataan pasien dan anamnesa menjadi lebih efektif dan terorganisir.

---

## Developer

Developed by **Yann9Scnd**

GitHub:
https://github.com/Yann9Scnd

---

## License

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan sistem informasi kesehatan.
