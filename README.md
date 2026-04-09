# Laravel + Vue.js — Setup Guide

> Proiect full-stack cu Laravel 12 (backend + API) și Vue.js (frontend), dezvoltat în cadrul internship-ului la Life is Hard, Cluj.

---

## Cerințe

- PHP >= 8.2
- Composer
- Node.js >= 18 + npm
- MariaDB (sau MySQL)

---

## Instalare

### 1. Clonează repo-ul

```bash
git clone https://github.com/alnezt/Laravel-Vue.js.git
cd Laravel-Vue.js
```

### 2. Instalează dependențele PHP

```bash
composer install
```

### 3. Creează fișierul `.env`

```bash
cp .env.example .env
nano .env
```

Modifică aceste linii:

```env
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_vue
DB_USERNAME=root         # sau userul tău MariaDB
DB_PASSWORD=             # parola ta MariaDB
```

### 4. Generează cheia aplicației

```bash
php artisan key:generate
```

### 5. Creează baza de date

```bash
sudo mariadb
```

```sql
CREATE DATABASE laravel_vue;
CREATE USER 'username'@'localhost' IDENTIFIED BY 'parola';
GRANT ALL PRIVILEGES ON laravel_vue.* TO 'username'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

> Înlocuiește `username` și `parola` cu ce ai pus în `.env`.

### 6. Rulează migrările

```bash
php artisan migrate
```

### 7. Instalează dependențele Node.js

```bash
npm install
```

---

## Pornire

Ai nevoie de **două terminale** deschise simultan:

**Terminal 1 — Backend Laravel:**
```bash
php artisan serve
```

**Terminal 2 — Frontend Vue.js (Vite):**
```bash
npm run dev
```

Accesează aplicația la: **http://localhost:8000**

---

## Rute disponibile

| Metodă | URL | Descriere |
|--------|-----|-----------|
| GET | `/` | Redirecționează automat către `/api/offer` |
| GET | `/api/offer` | Frontend Vue.js — pagina principală |
| GET | `/api/offer` | Listează toate ofertele |
| POST | `/api/offer` | Creează o ofertă nouă |
| POST | `/api/process-talon` | Procesează un talon prin OCR |

---

## Troubleshooting

**`Address already in use` la `php artisan serve`**
```bash
php artisan serve --port=8001
```

**`No application encryption key`**
```bash
php artisan key:generate
```

**`Connection refused` la migrate**
```bash
sudo systemctl start mariadb
```

**Vue-ul nu se încarcă (pagină goală / erori JS)**  
Asigură-te că rulează `npm run dev` în al doilea terminal.
