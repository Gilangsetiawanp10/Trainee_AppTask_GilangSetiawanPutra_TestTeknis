🗂 Trainee Task Manager

Aplikasi Manajemen Tugas Trainee dengan Sistem Multi-Role

Dibangun sebagai bagian dari Tes Teknis Programmer di PT Mabito Karya melalui program MagangHub.

🎯 Tentang Aplikasi
Trainee Task Manager adalah aplikasi web modern yang dirancang untuk mengelola tugas-tugas trainee dengan efisien. Aplikasi ini mendukung sistem multi-role (Admin & User), dilengkapi dengan fitur CRUD lengkap, export/import Excel, dan automated cron job untuk update status tugas.

⚡ Fitur Utama
🔐 Authentication & Authorization
Multi-Guard Authentication - Sistem login terpisah untuk Admin dan User
Role-Based Access Control - Pembatasan akses berdasarkan role
Session Management - Pengelolaan session yang aman

📝 Task Management (CRUD)
Create Task - Buat tugas baru dengan validasi form lengkap
Read Task - Tampilkan daftar tugas dengan DataTables
Update Task - Edit tugas dengan real-time validation
Delete Task - Hapus tugas (bulk delete untuk admin)

📊 Data Management
Export Excel - Export data ke format Excel (.xlsx)
Import Excel - Import data dari file Excel
Advanced Filtering - Filter berdasarkan status, trainee, tanggal
Search Functionality - Pencarian real-time

🤖 Automation
Cron Job - Auto-update status tugas ke 'Late' jika melewati deadline
Email Notifications - Notifikasi email untuk deadline reminder
Activity Logging - Log aktivitas sistem

💫 User Experience
Responsive Design - Design yang responsive untuk semua device
Real-time Validation - Validasi form secara real-time

🛠 Tech Stack
Backend
Framework: Laravel 5.8
Language: PHP 7.3
Database: MySQL 5.7+

Frontend
CSS Framework: TailwindCSS 2.x
JavaScript: jQuery 3.6
DataTables: jQuery DataTables
Icons: FontAwesome 6.0
Notifications: SweetAlert2

Additional Libraries
Excel Processing: Maatwebsite/Laravel-Excel
UUID: Ramsey/UUID
Date Picker: Flatpickr
Validation: Laravel Form Request

🔐 Login Default (Seeder)
Admin
Email: admin@trainee.com
Password: password

👨‍💻 About Developer
Gilang Setiawan Putra
Fresh Graduate — Universitas Komputer Indonesia
Program Studi Teknik Informatika
