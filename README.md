# MetroPress News Magazine

Laravel news magazine website menggunakan MySQL XAMPP/Herd, admin panel, search, kategori, pagination, trending/popular, dan importer RSS Google News Malaysia.

## Features

- Homepage gaya editorial/news magazine.
- Artikel disimpan dalam database MySQL.
- Search artikel berdasarkan tajuk, ringkasan, isi, dan author.
- Filter kategori.
- Trending/Popular berdasarkan `views_count`.
- Admin panel untuk tambah, edit, dan padam artikel/kategori.
- Upload gambar artikel ke local storage.
- RSS import dari Google News Malaysia.
- Gambar RSS disimpan local jika feed atau halaman sumber menyediakan image.
- Basic SEO meta dan Open Graph.

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

Pastikan MySQL XAMPP/Herd berjalan dan database ini wujud:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_magazine
DB_USERNAME=root
DB_PASSWORD=
```

Default RSS:

```env
NEWS_RSS_URL=https://news.google.com/rss?hl=ms-MY&gl=MY&ceid=MY:ms
```

## Import RSS News

Import berita Malaysia daripada Google News RSS:

```bash
php artisan news:import-rss
```

Import custom RSS:

```bash
php artisan news:import-rss "https://news.google.com/rss/search?q=site:bernama.com&hl=ms-MY&gl=MY&ceid=MY:ms" --category=Bernama --limit=20
```

Nota: Google News RSS kadang-kadang tidak membekalkan gambar. Command akan cuba cari image daripada RSS dahulu, kemudian cuba `og:image` daripada halaman sumber. Jika jumpa, gambar disimpan ke `storage/app/public/rss`.

## Admin

URL:

```text
/admin/login
```

Default password:

```env
ADMIN_PASSWORD=admin123
```

Tukar password ini di `.env` untuk penggunaan sebenar.

## Local Run

```bash
php artisan serve
```

Atau buka melalui Herd jika folder berada dalam `C:\Users\User\Herd\news-magazine`.

## Tests

```bash
php artisan test
```
