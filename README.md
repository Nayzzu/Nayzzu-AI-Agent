<div align="center">

  <img src="logo-nayzzu.png" alt="Nayzzu AI Agent Logo" width="180"/>

  # Nayzzu AI Agent Control

  **Sistem Kontrol & Monitoring Perangkat IoT berbasis AI Agent**

</div>

---

## 📌 Deskripsi Proyek

**Nayzzu AI Agent Control** adalah sistem integrasi kontrol dan pemantauan IoT (Internet of Things) yang menggabungkan server IoT berbasis Python, antarmuka antarmuka/AI berbasis PHP, serta penyimpanan status lokal dalam format JSON. 

Sistem ini memungkinkan pemantauan kondisi lingkungan (seperti suhu dan kelembapan) serta kontrol perangkat lunak/keras secara otomatis maupun manual.

---

## 📁 Struktur Repositori

```text
Nayzzu-AI-Agent-control/
├── logo-nayzzu.png          # Logo proyek
├── nayzzu_ai.php            # Script PHP untuk antarmuka pemprosesan AI / Web Dashboard
├── server_iot.py            # Server Backend IoT berbasis Python
├── status_lingkungan.json   # File data status sensor lingkungan (real-time/cached)
└── status_perangkat.json    # File data status kondisi saklar/perangkat
```

---

## ✨ Fitur Utama

- **Monitoring Lingkungan (`status_lingkungan.json`)**: Membaca dan menyimpan parameter lingkungan seperti suhu, kelembapan, dan sensor terkait.
- **Kontrol Perangkat (`status_perangkat.json`)**: Memantau dan mengubah status daya/saklar perangkat terhubung (ON/OFF).
- **Backend IoT (`server_iot.py`)**: Bertindak sebagai bridge komunikasi antara perangkat hardware / sensor dengan sistem backend.
- **AI Agent Controller (`nayzzu_ai.php`)**: Memproses logika cerdas untuk mengambil keputusan berdasarkan input pengguna atau perubahan sensor.

---

## 🛠️ Prasyarat Sistem

Sebelum menjalankan proyek ini, pastikan sistem Anda telah terinstal:

1. **Python 3.x**
2. **PHP 7.4+ / PHP 8.x** (Bisa menggunakan XAMPP, Nginx, Apache, atau built-in PHP CLI server)
3. Module Python pendukung (sesuai kebutuhan `server_iot.py`):
   ```bash
   pip install requests
   ```

---

## 🚀 Panduan Instalasi & Penggunaan

### 1. Clone Repositori

```bash
git clone https://github.com/username/Nayzzu-AI-Agent-control.git
cd Nayzzu-AI-Agent-control
```

### 2. Menjalankan Server IoT (Python)

Jalankan server IoT untuk mulai menerima/mengirim data dari perangkat hardware:

```bash
python server_iot.py
```

### 3. Menjalankan Web Agent / Dashboard (PHP)

Anda dapat menggunakan web server bawaan PHP untuk pengujian cepat:

```bash
php -S localhost:8000
```

Buka browser Anda dan akses:
```
http://localhost:8000/nayzzu_ai.php
```

---

## 📄 Format Data JSON

### `status_lingkungan.json`
Menyimpan data Telemetri Lingkungan:
```json
{
  "suhu": 28.5,
  "kelembapan": 65,
  "updated_at": "2026-10-20 13:45:00"
}
```

### `status_perangkat.json`
Menyimpan data Kondisi Perangkat Control:
```json
{
  "lampu_utama": "ON",
  "kipas": "OFF",
  "pompa": "OFF"
}
```

---

## 🤝 Kontribusi

Aplikasi ini terbuka untuk pengembangan lebih lanjut. Jika Anda ingin berkontribusi:
1. *Fork* repositori ini.
2. Buat *feature branch* baru (`git checkout -b feature/FiturBaru`).
3. Commit perubahan Anda (`git commit -m 'Menambahkan FiturBaru'`).
4. *Push* ke branch tersebut (`git push origin feature/FiturBaru`).
5. Buat *Pull Request*.

---

## 📝 Lisensi

Distribusi dan penggunaan repositori ini diatur di bawah lisensi terbuka. Silakan sesuaikan dengan kebutuhan proyek Anda.
