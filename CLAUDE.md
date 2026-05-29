# Techno — Project Guide

Full-stack SPA: Laravel 11 backend (REST API) + Vue 3 frontend. Admin dashboard untuk manajemen produk, plus landing page publik.

## Tech Stack

**Frontend**: Vue 3, Vite 5, Vue Router 4, Pinia 2, Vuetify 3, Bootstrap 5, Axios, SCSS  
**Backend**: Laravel 11, PHP 8.2+, MySQL, JWT Auth (tymon/jwt-auth v2.1)

## Running the App

```bash
# Terminal 1 — Laravel
php artisan serve         # http://localhost:8000

# Terminal 2 — Vite dev server
npm run dev               # http://localhost:3000

# Build produksi
npm run build
```

## Database

MySQL (primary). Konfigurasi di `.env`:
- Host: `127.0.0.1:3306`, DB: `techno`, User: `root` (no password)

```bash
php artisan migrate
php artisan db:seed       # opsional
```

## Project Structure

```
app/Http/Controllers/     # AuthController, ProductController, VendorController, dll
app/Models/               # User, MtProduct, MtVendor, MtProductSeries, dll (prefix Mt)
routes/
  api.php                 # REST API — publik (GET) + protected (POST/PUT/DELETE)
  web.php                 # Catch-all → SPA blade template
resources/js/
  app.js                  # Entry point
  router/                 # index.js + admin.js + landing-page.js + products.js
  store/user.js           # Pinia store (auth state, persisted ke localStorage)
  components/             # Dialogs, LandingPage, TopNavBar, MainFooter
  layouts/                # DashboardLayout, DefaultLayout, LandingPageLayout
  pages/
    admin/                # Login, Dashboard, CRUD: product, series, category, vendor, dll
    landing/              # Index, About, Contact, EngineeringServices
    products/             # Catalog, Vendor
  plugins/vuetify.js      # Vuetify config (light theme, MDI icons)
```

## Auth Flow

- JWT token-based (tidak pakai session cookie)
- Token disimpan di Pinia store, persisted ke `localStorage`
- Axios interceptor otomatis sertakan token di header
- Route guard: `meta.auth: true` → redirect ke `/admin/login` jika belum login
- Route guard: `meta.guest: true` → redirect ke admin jika sudah login

## API Routes Pattern

```
POST   /api/auth/login
POST   /api/auth/register
POST   /api/auth/logout
GET    /api/product          # publik
GET    /api/product/{id}     # publik
POST   /api/product          # protected (middleware: auth:api)
PUT    /api/product/{id}     # protected
DELETE /api/product/{id}     # protected
```

Pola serupa untuk: `product/series`, `product/category`, `vendor`, `manufacture-type`, `images-storage`, `files-storage`.

## Naming Conventions

- Model PHP: prefix `Mt` (MtProduct, MtVendor, MtImagesStorage, dll)
- Tabel DB: prefix `mt_` (mt_product, mt_vendor, dll)
- Controller: `[Resource]Controller`

## Reusable Components

| Komponen | Kegunaan |
|---|---|
| `dialogs/Loading.vue` | Overlay loading |
| `dialogs/Message.vue` | Dialog konfirmasi/info |
| `dialogs/SnackBar.vue` | Notifikasi toast |
| `dialogs/ImageFullScreen.vue` | Preview gambar fullscreen |
| `dialogs/SelectFileImage.vue` | File picker dari assets manager |
| `ImagePicker.vue` | Upload & pilih gambar |

## Vite Config Notes

- Path alias: `@` → `resources/js`
- Dev server: port `3000`
- SCSS preprocessor aktif (modern compiler API)
- Entry points: `resources/css/app.css`, `resources/js/app.js`, `resources/js/variables.scss`
