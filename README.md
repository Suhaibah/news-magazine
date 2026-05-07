# MetroPress News Magazine

Laravel news magazine website menggunakan MySQL XAMPP/Herd, admin panel, search, kategori, pagination, trending/popular, dan importer RSS Malaysia.

## Features

- Homepage gaya editorial/news magazine.
- Artikel disimpan dalam database MySQL.
- Search artikel berdasarkan tajuk, ringkasan, isi, dan author.
- Filter kategori.
- Trending/Popular berdasarkan `views_count`.
- Page detail artikel dengan related posts dan counter views.
- Admin panel untuk tambah, edit, dan padam artikel/kategori.
- Admin dashboard untuk lihat statistik artikel, kategori, RSS, artikel tanpa gambar, dan artikel popular.
- Butang admin untuk import RSS dan cleanup tanpa perlu buka terminal.
- Upload gambar artikel ke local storage.
- RSS import dari feed berita Malaysia yang menyediakan gambar artikel.
- Multi-feed RSS untuk Terkini, Malaysia, Politik, Bisnes, dan Teknologi.
- Auto refresh RSS melalui Laravel Scheduler.
- Cleanup artikel lama supaya database tidak membesar tanpa had.
- Gambar RSS disimpan local jika feed atau halaman sumber menyediakan image.
- Link "Baca sumber" untuk buka artikel asal.
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
NEWS_RSS_URL=https://www.astroawani.com/rss/latest/public
NEWS_MAX_POSTS=100
```

## Import RSS News

Import semua feed yang dikonfigurasi:

```bash
php artisan news:import-rss
```

Import satu custom RSS:

```bash
php artisan news:import-rss "https://www.astroawani.com/rss/national/public" --category=Malaysia --limit=20
```

Nota: command akan cari image daripada `enclosure`, `media:thumbnail`, `media:content`, kemudian cuba `og:image` atau `twitter:image` daripada halaman sumber. Jika jumpa, gambar disimpan ke `storage/app/public/rss`.

## Auto Refresh RSS

Scheduler sudah dikonfigurasi di `routes/console.php`:

- `news:import-rss --all --limit=10` berjalan setiap jam.
- `news:cleanup` berjalan setiap hari.

Untuk aktifkan scheduler di server, tambah cron/task scheduler yang menjalankan:

```bash
php artisan schedule:run
```

Untuk development, boleh run:

```bash
php artisan schedule:work
```

## Cleanup Artikel Lama

Default simpan `NEWS_MAX_POSTS=100` artikel terbaru:

```bash
php artisan news:cleanup
```

Custom jumlah artikel:

```bash
php artisan news:cleanup --keep=200
```

## Admin

URL:

```text
/admin/login
```

Default password:

```env
ADMIN_PASSWORD=admin123
```

Untuk demo, boleh tukar `ADMIN_PASSWORD` di `.env`.

Untuk lebih selamat, gunakan hashed password:

```bash
php artisan tinker --execute="echo Hash::make('password-baru');"
```

Kemudian letak hasil hash dalam `.env`:

```env
ADMIN_PASSWORD_HASH=$2y$...
```

Jika `ADMIN_PASSWORD_HASH` ada nilai, sistem akan guna hash itu dan abaikan password plain.

Selepas login, dashboard admin menyediakan:

- Ringkasan jumlah artikel, kategori, artikel RSS, dan artikel tanpa gambar.
- Butang `Import RSS` untuk tarik semua feed yang dikonfigurasi.
- Butang `Cleanup` untuk buang artikel RSS lama.
- Senarai artikel popular berdasarkan views.

## Deploy Checklist

1. Set `.env` production/local yang betul.
2. Pastikan database MySQL sudah wujud.
3. Run `composer install --no-dev --optimize-autoloader`.
4. Run `php artisan key:generate` jika belum ada `APP_KEY`.
5. Run `php artisan migrate --force`.
6. Run `php artisan storage:link`.
7. Set writable permission untuk `storage` dan `bootstrap/cache`.
8. Set scheduler untuk `php artisan schedule:run` setiap minit.
9. Tukar `ADMIN_PASSWORD` atau guna `ADMIN_PASSWORD_HASH`.
10. Run `php artisan news:import-rss` untuk mula tarik berita RSS.

## Local Run

```bash
php artisan serve
```

Atau buka melalui Herd jika folder berada dalam `C:\Users\User\Herd\news-magazine`.

## Tests

```bash
php artisan test
```
