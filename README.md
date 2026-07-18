# Global Supply Chain Risk Intelligence Platform

Platform Monitoring Risiko Rantai Pasok Global Berbasis Multi-API dan Analitik Data.

---

## Daftar Isi

1. [Latar Belakang](#latar-belakang)
2. [Studi Kasus](#studi-kasus)
3. [Teknologi](#teknologi)
4. [API Eksternal yang Digunakan](#api-eksternal-yang-digunakan)
5. [Fitur Utama](#fitur-utama)
6. [Fitur Data Science — Sentiment Analysis](#fitur-data-science--sentiment-analysis)
7. [Supply Chain Risk Prediction](#supply-chain-risk-prediction)
8. [Database](#database)
9. [REST API yang Dibuat](#rest-api-yang-dibuat)
10. [Struktur Project](#struktur-project)
11. [Cara Menjalankan](#cara-menjalankan)

---

## Latar Belakang

Project ini dibangun untuk memenuhi kebutuhan pemantauan risiko rantai pasok secara global. Sistem ini sangat bergantung pada data untuk:

- Mengelola risiko logistik
- Memantau kondisi cuaca ekstrem
- Menganalisis gangguan transportasi
- Mengamati kondisi ekonomi suatu negara
- Membantu pengambilan keputusan bisnis

Project ini memperlihatkan kemampuan mahasiswa dalam:

- Full Stack Development
- API Integration
- Data Engineering
- Dashboard Analytics
- Geospatial Visualization
- Business Intelligence
- Decision Support System

---

## Studi Kasus

Sebuah perusahaan ingin mengimpor barang dari berbagai negara.

**Masalah yang dihadapi:**

- Cuaca buruk dapat mengganggu pengiriman
- Nilai tukar mata uang berubah sewaktu-waktu
- Konflik geopolitik meningkatkan risiko
- Kemacetan pelabuhan menyebabkan keterlambatan
- Inflasi suatu negara mempengaruhi biaya produksi

Maka dibangunlah sistem yang dapat memantau seluruh indikator tersebut dalam satu dashboard terpadu.

---

## Teknologi

### Backend

| Teknologi | Keterangan |
|-----------|------------|
| PHP 8.3 | Bahasa pemrograman server |
| Laravel 13 | Framework backend utama |
| MySQL 8 | Database relasional |

### Frontend

| Teknologi | Keterangan |
|-----------|------------|
| Bootstrap 5 | CSS framework untuk layout responsif |
| AJAX | Komunikasi asinkron client-server |
| JavaScript ES6 | Logika interaksi di sisi browser |
| Select2 | Komponen dropdown pencarian negara |

### Visualisasi

| Teknologi | Keterangan |
|-----------|------------|
| Chart.js | Grafik bar, line, radar, doughnut |
| Leaflet.js | Peta interaktif berbasis OpenStreetMap |

### Deployment

| Teknologi | Keterangan |
|-----------|------------|
| Laragon | Web server lokal untuk development |
| GitHub | Version control dan hosting repositori |

---

## API Eksternal yang Digunakan

### 1. Open-Meteo API — Cuaca Global

- Website: https://open-meteo.com/
- Data: Temperatur, Curah hujan, Kecepatan angin, Risiko badai
- Tidak membutuhkan API Key
- Service: `app/Services/WeatherService.php`

### 2. World Bank API — Data Ekonomi

- Website: https://datahelpdesk.worldbank.org/
- Data: GDP, Inflasi, Populasi, Ekspor, Impor
- Tidak membutuhkan API Key
- Service: `app/Services/WorldBankService.php`
- Caching: 24 jam per indikator per negara

### 3. REST Countries API — Data Negara

- Website: https://restcountries.com/
- Data: Negara, Mata uang, Wilayah, Bahasa, Koordinat
- Tidak membutuhkan API Key
- Service: `app/Services/CountryService.php`

### 4. ExchangeRate / Frankfurter API — Kurs Mata Uang

- Website: https://api.frankfurter.app/
- Data: Kurs mata uang real-time dan historis
- Tidak membutuhkan API Key
- Service: `app/Services/ExchangeRateService.php`

### 5. GNews API — Berita Ekonomi & Logistik

- Website: https://gnews.io/
- Data: Berita ekonomi, logistik, geopolitik per negara
- Membutuhkan API Key (gratis, daftar di gnews.io)
- Service: `app/Services/NewsSentimentService.php`

### 6. OpenStreetMap (via Leaflet.js) — Peta Interaktif

- Digunakan untuk menampilkan peta dunia, marker negara, dan lokasi pelabuhan
- Tidak membutuhkan API Key

---

## Fitur Utama

### 1. Global Country Dashboard

User memilih negara dari dropdown (contoh: Germany, China, Indonesia, Australia).

Sistem menampilkan:
- GDP dan data ekonomi (World Bank API)
- Inflasi dan populasi
- Mata uang dan nilai tukar (Frankfurter API)
- Cuaca saat ini — suhu, angin (Open-Meteo API)
- Skor risiko komposit (Risk Scoring Engine)
- Daftar negara favorit yang dipantau

### 2. Risk Scoring Engine

Sistem menghitung skor risiko berdasarkan 4 dimensi:

```
Risk Score = Weather + Inflation + Exchange Rate + News Sentiment
```

Output contoh:
```
Germany  : 22 (Low Risk)
China    : 47 (Medium Risk)
Indonesia: 37 (Medium Risk)
```

Algoritma scoring dibuat sendiri menggunakan Weighted Risk Model. Visualisasi menggunakan grafik radar dan bar chart per dimensi risiko.

### 3. Global Weather Monitoring

Peta dunia berbasis Leaflet.js menunjukkan:
- Suhu udara
- Kecepatan angin
- Kondisi cuaca

Data diambil berdasarkan koordinat negara yang dipilih melalui Open-Meteo API.

### 4. Currency Impact Dashboard

Menampilkan:
- Nilai tukar mata uang terhadap USD
- Grafik perubahan kurs historis (10 hari terakhir)

Menggunakan Chart.js dan data dari Frankfurter API.

### 5. News Intelligence

Menampilkan berita terkait:
- Logistics, Trade, Shipping, Economy

Berita diambil dari GNews API dan dianalisis sentimennya menggunakan Lexicon-Based Sentiment Analysis.

### 6. Port Location Dashboard (Geospatial Map)

Menampilkan lokasi pelabuhan dunia pada peta interaktif.

Fitur:
- Cari pelabuhan berdasarkan nama
- Cari berdasarkan negara
- Marker interaktif dengan popup informasi
- Data cuaca real-time per koordinat marker

### 7. Data Visualization Dashboard

Grafik historis menggunakan Chart.js:
- GDP Trend (5 tahun terakhir dari World Bank)
- Inflation Trend (5 tahun terakhir)
- Currency Trend (10 hari terakhir dari Frankfurter)
- Risk Index Trend (proyeksi 10 hari)

### 8. Country Comparison Engine

Membandingkan dua negara secara side-by-side.

Contoh perbandingan **Germany vs Australia**:
- GDP
- Inflation
- Risk Score
- Weather
- Currency
- Wind Speed

Dilengkapi:
- Bar chart perbandingan GDP
- Radar chart overlay risk breakdown
- Tabel makroekonomi
- Panel ringkasan (selisih risiko, negara lebih aman)

Data diambil dari `ComparisonService` yang mengagregasi 6 API sekaligus.

### 9. Favorite Monitoring List

User dapat menyimpan negara yang dipantau secara rutin.

Fitur:
- Tambah/hapus negara favorit
- Data favorit tersimpan di `localStorage` browser
- Setiap negara favorit menampilkan: GDP, Inflasi, Risk Score, Suhu, Mata Uang
- Data dimuat secara batch melalui API `/api/favorites/batch`
- Negara favorit juga tampil di dashboard utama (kolom ke-5 di metrics)

### 10. Admin Dashboard

Panel admin untuk mengelola:
- **User** — CRUD pengguna + role management (admin/user)
- **Dataset Pelabuhan** — CRUD data pelabuhan + koordinat
- **Artikel Analisis** — CRUD artikel + status draft/published

Dilindungi middleware `auth` dan `AdminOnly`.

---

## Fitur Data Science — Sentiment Analysis

### Metode: Lexicon-Based Sentiment Analysis

Dibuat menggunakan PHP murni tanpa library berbayar.

Sistem menggunakan kamus kata (dictionary) positif dan negatif:

**Tabel positive_words:**

| id | word |
|----|------|
| 1 | growth |
| 2 | increase |
| 3 | profit |
| 4 | stable |
| 5 | improve |
| 6 | success |
| 7 | boom |
| 8 | recovery |

**Tabel negative_words:**

| id | word |
|----|------|
| 1 | war |
| 2 | crisis |
| 3 | inflation |
| 4 | delay |
| 5 | disaster |
| 6 | conflict |
| 7 | disruption |
| 8 | strike |

### Contoh Proses Analisis

Misalnya berita:
> "Inflation increases while exports decrease due to war."

Program akan mencocokkan:
```
Positive : increase (1 kata)
Negative : inflation, decrease, war (3 kata)
```

Hasil:
```
Positive : 1
Negative : 3
Sentiment = Negative
```

### Implementasi di PHP

```php
$positiveScore = 0;
$negativeScore = 0;

foreach ($words as $word) {
    if (in_array($word, $positiveWords)) {
        $positiveScore++;
    }
    if (in_array($word, $negativeWords)) {
        $negativeScore++;
    }
}

$sentiment = $positiveScore > $negativeScore
    ? "Positive"
    : "Negative";
```

Output sentimen per negara:
```
Positive : 60%
Neutral  : 25%
Negative : 15%
```

File implementasi: `app/Services/NewsSentimentService.php`

---

## Supply Chain Risk Prediction

### Metode: Weighted Risk Model (Simple Scoring Algorithm)

Setiap dimensi risiko memiliki bobot yang berbeda:

| Dimensi | Bobot | Sumber Data |
|---------|-------|-------------|
| Weather Risk | 30% | Open-Meteo API |
| News Sentiment Risk | 40% | GNews API + Lexicon Analysis |
| Inflation Risk | 20% | World Bank API |
| Currency Volatility Risk | 10% | Frankfurter API |

### Formula Perhitungan

```
Final Score = (Weather × 0.3) + (News × 0.4) + (Inflation × 0.2) + (Currency × 0.1)
```

### Contoh Perhitungan

```
Weather Risk     = 20
News Risk        = 50
Inflation Risk   = 30
Currency Risk    = 50

Final Score = (20 × 0.3) + (50 × 0.4) + (30 × 0.2) + (50 × 0.1)
           = 6 + 20 + 6 + 5
           = 37 (Medium Risk)
```

### Klasifikasi Risiko

| Skor | Status | Keterangan |
|------|--------|------------|
| 0 – 34 | Low Risk | Aman untuk operasi logistik |
| 35 – 59 | Medium Risk | Perlu diwaspadai, ada potensi gangguan |
| 60 – 100 | High Risk | Risiko tinggi, perlu evaluasi rute alternatif |

File implementasi: `app/Services/RiskScoringService.php`

---

## Database

### Daftar Tabel

| No | Tabel | Keterangan |
|----|-------|------------|
| 1 | `users` | Data pengguna sistem (admin/user) |
| 2 | `countries` | Daftar negara + koordinat (lat, lng) |
| 3 | `ports` | Lokasi pelabuhan + kode + relasi ke countries |
| 4 | `positive_words` | Kamus kata positif untuk sentiment analysis |
| 5 | `negative_words` | Kamus kata negatif untuk sentiment analysis |
| 6 | `news_cache` | Cache berita + hasil sentimen |
| 7 | `risk_scores` | Skor risiko per negara per dimensi |
| 8 | `watchlists` | Daftar pantauan negara per user |
| 9 | `articles` | Artikel analisis dari admin |
| 10 | `cache` | Cache framework Laravel |
| 11 | `sessions` | Session pengguna |
| 12 | `jobs` | Queue jobs (jika digunakan) |

### Relasi Antar Tabel

```
users ──────┐
            ├──→ watchlists ←── countries
            │                      │
            └──→ articles          ├──→ ports
                                   └──→ risk_scores
```

### Skema Tabel Utama

**countries**
```sql
id          BIGINT PRIMARY KEY
name        VARCHAR(255) UNIQUE
lat         DECIMAL(10,6)
lng         DECIMAL(10,6)
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

**ports**
```sql
id          BIGINT PRIMARY KEY
name        VARCHAR(255)
code        VARCHAR(10)
country_id  BIGINT FOREIGN KEY → countries(id)
lat         DECIMAL(10,8)
lng         DECIMAL(11,8)
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

**risk_scores**
```sql
id               BIGINT PRIMARY KEY
country_id       BIGINT FOREIGN KEY → countries(id)
weather_score    FLOAT DEFAULT 0
inflation_score  FLOAT DEFAULT 0
news_score       FLOAT DEFAULT 0
currency_score   FLOAT DEFAULT 0
total_risk       FLOAT DEFAULT 0
risk_level       VARCHAR (Low/Medium/High)
created_at       TIMESTAMP
updated_at       TIMESTAMP
```

**news_cache**
```sql
id          BIGINT PRIMARY KEY
title       VARCHAR(255)
description TEXT
url         VARCHAR(255)
sentiment   VARCHAR DEFAULT 'Neutral'
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

File migrasi: `database/migrations/2026_06_29_141311_create_globchain.php`

---

## REST API yang Dibuat

### API Endpoint Internal

| Method | Endpoint | Deskripsi | Controller |
|--------|----------|-----------|------------|
| `GET` | `/api/countries` | Daftar semua negara + koordinat | Closure (web.php) |
| `GET` | `/api/ports` | Daftar semua pelabuhan + negara | Closure (web.php) |
| `GET` | `/api/weather/live` | Cuaca real-time per koordinat | Closure (web.php) |
| `GET` | `/api/compare` | Data intelijen 1 negara | ComparisonController |
| `GET` | `/api/compare/dual` | Perbandingan 2 negara | ComparisonController |
| `GET` | `/api/favorites/batch` | Batch data negara favorit | ComparisonController |

### Contoh Request & Response

**GET** `/api/compare?country=Indonesia`

```json
{
    "success": true,
    "message": "Data intelijen untuk Indonesia berhasil dimuat.",
    "data": {
        "country": "Indonesia",
        "gdp": "$1.32 T",
        "inflation": "3.7",
        "currency": "15487",
        "currCode": "IDR",
        "weather": "28.5°C",
        "wind": "12.3 km/h",
        "risk": {
            "score": 42,
            "status": "Medium",
            "breakdown": {
                "weather": 20,
                "news": 55,
                "inflation": 35,
                "currency": 50
            }
        }
    }
}
```

**GET** `/api/compare/dual?countryA=Germany&countryB=Australia`

```json
{
    "success": true,
    "message": "Perbandingan berhasil.",
    "data": {
        "countryA": { "country": "Germany", "gdp": "$4.4T", "risk": { "score": 22 } },
        "countryB": { "country": "Australia", "gdp": "$1.7T", "risk": { "score": 35 } },
        "analysis": {
            "risk_difference": 13,
            "safer_country": "Germany",
            "better_inflation": "Germany"
        }
    }
}
```

---

## Struktur Project

```
globchain/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php             # CRUD admin (user, port, artikel)
│   │   ├── AuthController.php              # Login & logout
│   │   ├── ComparisonController.php        # Country Comparison & Favorites API
│   │   ├── CountryController.php           # Dashboard utama + pencarian
│   │   ├── MapController.php               # Halaman peta geospasial
│   │   ├── MarketIntelligenceController.php # Currency & News
│   │   ├── RiskController.php              # Risk Scoring Engine
│   │   └── VisualizationController.php     # Data Visualization Dashboard
│   ├── Models/
│   │   ├── User.php, Country.php, Port.php, Article.php
│   ├── Services/
│   │   ├── CountryService.php              # REST Countries API
│   │   ├── WeatherService.php              # Open-Meteo API
│   │   ├── WorldBankService.php            # World Bank API
│   │   ├── ExchangeRateService.php         # Frankfurter API
│   │   ├── NewsSentimentService.php        # GNews + Sentiment Analysis
│   │   ├── RiskScoringService.php          # Weighted Risk Model
│   │   └── ComparisonService.php           # Agregator data perbandingan
│   └── Middleware/
│       ├── AdminOnly.php                   # Pembatasan akses role admin
│       └── PreventBackHistory.php          # Cache control header
├── database/migrations/
│   └── 2026_06_29_141311_create_globchain.php
├── resources/views/
│   ├── layouts/app.blade.php               # Master layout + sidebar navigasi
│   ├── dashboard.blade.php                 # Halaman utama
│   ├── partials/                           # Komponen dashboard (header, profile, metrics, visuals, modals)
│   ├── analytics/risk.blade.php            # Risk Scoring Engine
│   ├── analytics/visualization.blade.php   # Data Visualization
│   ├── maps/index.blade.php               # Peta geospasial
│   ├── market/currency.blade.php          # Currency monitor
│   ├── market/news.blade.php              # News & sentiment
│   ├── tools/comparison.blade.php         # Country Comparison Engine
│   ├── tools/favorites.blade.php          # Favorite Monitoring List
│   ├── admin/                             # Panel admin
│   └── auth/                              # Halaman login
├── routes/web.php                         # Seluruh route definition
├── public/                                # Assets (CSS, JS, gambar)
└── .env                                   # Konfigurasi environment
```

---

## Cara Menjalankan

### Prasyarat

- PHP >= 8.3
- Composer
- MySQL
- Laragon / XAMPP

### Langkah-Langkah

1. Clone repositori

```
git clone https://github.com/tasykiaananda/globechain.git
cd globechain
```

2. Install dependensi

```
composer install
```

3. Konfigurasi environment

```
cp .env.example .env
php artisan key:generate
```

4. Setting database di `.env`

```
DB_DATABASE=globchain
DB_USERNAME=root
DB_PASSWORD=
```

5. Setting API key di `.env`

```
GNEWS_API_KEY=isi_api_key_gnews_disini
```

6. Jalankan migrasi dan seeder

```
php artisan migrate --seed
```

7. Jalankan server

```
php artisan serve
```

8. Buka di browser: `http://127.0.0.1:8000`

---

## Skala Project

- 12 tabel database
- 6 API endpoint internal
- 6 API eksternal terintegrasi
- 10 halaman utama
- 8 Service class (business logic)
- 9 Controller
- Dashboard analitik dengan grafik interaktif
- Sistem scoring dan prediksi risiko
- Peta interaktif global
- Sentiment analysis berbasis lexicon
