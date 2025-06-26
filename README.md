<div align="center">
  <img src="https://path-to-your-logo.com/logo.png" alt="Belum ada Logo" width="120">
  <h1><strong>SIMPEG - Sistem Informasi Karyawan</strong></h1>
  <p>
    Aplikasi web modern untuk manajemen karyawan dan kinerja berbasis Laravel 11.
  </p>
    <p>
    <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php" alt="PHP 8.3">
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  </p>
</div>

---

## 📖 Deskripsi Proyek

**SIMPEG Karyawan** adalah sebuah aplikasi web yang dirancang untuk membantu perusahaan dalam mengelola data karyawan, departemen, jabatan, serta memantau dan mencatat kinerja mereka. Aplikasi ini dibangun dari awal menggunakan **Laravel 11** dan didesain dengan antarmuka yang modern, bersih, dan profesional.

Sistem ini memiliki tiga level hak akses (Admin, Manajer, dan Karyawan) untuk memastikan keamanan dan relevansi data yang ditampilkan bagi setiap pengguna.

---

## ✨ Fitur Utama

Aplikasi ini dilengkapi dengan berbagai fitur untuk memenuhi kebutuhan manajemen SDM modern.

| Peran | Fitur yang Dapat Diakses |
| :--- | :--- |
| 👤 **Admin** | <ul><li>**Dashboard Komprehensif:** Ringkasan data, aktivitas terbaru, dan grafik distribusi karyawan.</li><li>**Manajemen Penuh:** CRUD untuk Karyawan, Departemen, Jabatan, dan Pengguna.</li><li>**Kontrol Akses:** Mengubah peran pengguna (Admin/Manager/Karyawan).</li><li>**Analitik:** Halaman laporan kinerja dengan tren bulanan dan rata-rata per departemen.</li><li>**Ekspor Data:** Mengunduh data karyawan ke format `.csv`.</li></ul> |
| 👨‍💼 **Manajer** | <ul><li>**Dashboard Tim:** Melihat aktivitas terbaru (anggota baru & penilaian) di departemennya.</li><li>**Manajemen Tim:** Mengelola anggota tim di bawahnya (lihat detail, tambah penilaian, edit, hapus).</li></ul> |
| 🧑‍💻 **Karyawan**| <ul><li>**Dashboard Personal:** Melihat profil diri dan riwayat lengkap penilaian kinerja.</li><li>**Manajemen Profil:** Memperbarui nama, email, dan password pribadi.</li></ul> |

---

## 🛠️ Teknologi yang Digunakan

-   **Backend:** Laravel 11, PHP 8.3
-   **Frontend:** Tailwind CSS, Alpine.js
-   **Database:** MySQL
-   **Visualisasi Data:** Chart.js
-   **Testing:** PEST
