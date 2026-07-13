# TASK-09: Deploy ke VPS Biznet (Ubuntu 24.04)

**Status:** ⬜ Belum
**Prasyarat:** Dier udah sewa VPS Biznet + beli domain `.my.id`. **Bagian A boleh (dan sebaiknya) dikerjain lebih awal** begitu VPS ready — lihat aturan di [01-CARA-KERJA](../01-CARA-KERJA.md). Bagian B nunggu TASK-08 ✅.
**Fase spec:** 0 (skeleton) + 4 (final)

> Task ini butuh info dari Dier: IP VPS, user SSH, dan nama domain final. **Tanya dulu, jangan ngarang.** Semua perintah di bawah dijalankan DI VPS via SSH kecuali disebut lain.

## Bagian A — Deploy skeleton (sekali, di awal)

1. **Persiapan server:**
   ```bash
   apt update && apt upgrade -y
   apt install -y nginx mysql-server git unzip curl \
     php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath
   # Composer:
   curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
   # Node 22 LTS (buat build Tailwind):
   curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && apt install -y nodejs
   ```
   Ubuntu 24.04 udah bawa PHP 8.3 native, jadi langsung jalan. **Peringatan:** kalau ternyata image server-nya Ubuntu 22.04 (repo default cuma PHP 8.1), WAJIB tambah PPA dulu sebelum apt install di atas: `apt install -y software-properties-common && add-apt-repository -y ppa:ondrej/php && apt update` — tanpa itu, `php8.3-*` nggak ketemu dan seluruh install gagal. Cek dulu: `lsb_release -rs`.
2. **MySQL:** bikin DB + user (JANGAN pakai root buat app):
   ```sql
   CREATE DATABASE sigadai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'sigadai'@'localhost' IDENTIFIED BY '<password-kuat-generate-sendiri>';
   GRANT ALL PRIVILEGES ON sigadai.* TO 'sigadai'@'localhost';
   FLUSH PRIVILEGES;
   ```
3. **Deploy app:**
   ```bash
   cd /var/www && git clone https://github.com/Deearss/sigadai.git
   cd sigadai
   composer install --no-dev --optimize-autoloader
   npm ci && npm run build
   cp .env.example .env
   ```
4. **`.env` produksi** — yang WAJIB beda dari lokal:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://<domain>
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_DATABASE=sigadai
   DB_USERNAME=sigadai
   DB_PASSWORD=<password tadi>
   SESSION_DRIVER=database
   QUEUE_CONNECTION=sync
   ```
   Lalu: `php artisan key:generate` dan migrate — **kondisional**:
   - TASK-02 (seeder + akun demo) udah kelar → `php artisan migrate --seed --force`
   - TASK-02 BELUM kelar (deploy skeleton duluan) → `php artisan migrate --force` **TANPA `--seed`** — seeder bawaan Laravel bikin user `test@example.com` password `password`, kredensial ketebak di server publik. Seed nyusul setelah TASK-02: `php artisan migrate:fresh --seed --force`.
   - Terakhir: `php artisan optimize`
   Catatan: seeder butuh faker di dependency produksi — TASK-02 langkah 3 udah mindahin (`composer require fakerphp/faker`), jadi `composer install --no-dev` aman.
5. **Permission:** `chown -R www-data:www-data /var/www/sigadai && chmod -R 775 storage bootstrap/cache`
6. **Nginx** — server block root ke `/var/www/sigadai/public`, template standar Laravel (`try_files $uri $uri/ /index.php?$query_string;` + fastcgi ke `php8.3-fpm.sock`). Enable site, `nginx -t`, reload.
7. **Domain & SSL:** arahkan A record domain ke IP VPS (di panel registrar), tunggu propagasi, lalu:
   ```bash
   apt install -y certbot python3-certbot-nginx
   certbot --nginx -d <domain>
   ```
8. **Firewall:** `ufw allow OpenSSH && ufw allow 'Nginx Full' && ufw enable`

### Kriteria selesai Bagian A
- [ ] `https://<domain>` kebuka dari HP pakai data seluler (bukan wifi rumah) — halaman login muncul, gembok SSL hijau
- [ ] Kalau TASK-02 udah kelar: bisa login pakai akun demo. Kalau belum: cukup halaman login muncul (tes login nyusul begitu TASK-02 + seed produksi jalan)
- [ ] `APP_DEBUG=false` — bikin error sengaja (URL ngaco) → error page generik, BUKAN stack trace

## Bagian B — Deploy final (setelah TASK-08)

```bash
cd /var/www/sigadai
git pull
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan optimize:clear && php artisan optimize
```
Kalau struktur data berubah sejak seed awal dan datanya masih dummy semua: `php artisan migrate:fresh --seed --force` juga boleh (data produksi = data demo, aman di-reset).

### Kriteria selesai Bagian B
- [ ] Semua fitur (CRUD, dashboard, search/filter, badge) jalan di URL publik
- [ ] Definition of Done poin 1–6 ✓ di produksi

## Jangan

- Jangan simpan password DB / .env produksi di repo.
- Jangan matiin firewall / buka port MySQL ke publik.
- Jangan deploy pakai `APP_DEBUG=true`.

## Commit

Perubahan di repo dari task ini paling cuma catatan kecil (kalau ada). Kalau nggak ada perubahan file, nggak perlu commit — cukup update status file ini + push.
`TASK-09: catatan deploy VPS`
