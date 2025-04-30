# Boilerplate Laravel 12 dengan Repository Pattern & CRUD Generator

Repositori ini adalah kerangka dasar (boilerplate) untuk membangun aplikasi RESTful API menggunakan Laravel versi 12 dengan implementasi *Repository Pattern* berbasis interface, serta dilengkapi dengan generator CRUD otomatis.

## Fitur Utama

- Laravel 12
- Sistem Repository & Interface untuk pemisahan *business logic*
- Generator CRUD otomatis via command `make:apiv1`
- Autentikasi API menggunakan Laravel Sanctum
- Manajemen *role* dan *permission* dengan Spatie Laravel Permission
- Encoding ID dengan Vinkla Hashids

## Daftar Paket yang Digunakan

- laravel/framework
- laravel/sail
- laravel/sanctum
- laravel/tinker
- nesbot/carbon
- nunomaduro/collision
- nunomaduro/termwind
- spatie/laravel-permission
- vinkla/hashids

## Instalasi & Setup

1. Clone repository
   ```bash
   git clone <url-repo>
   cd <nama-project>
   ```
2. Install dependencies
   ```bash
   composer install
   ```
3. Salin file environment dan buat *app key*
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Konfigurasi koneksi database di file `.env`
5. Jalankan migrasi dan seeder
   ```bash
   php artisan migrate --seed
   ```
6. Publikasikan konfigurasi Sanctum
   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   ```
7. (Opsional) Bersihkan cache
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

## Autentikasi API

- **Login**  : `POST /api/login` (body: `email`, `password`)
- **Me**     : `GET /api/me` (header: `Authorization: Bearer {token}`)
- **Logout**: `POST /api/logout` (header: `Authorization: Bearer {token}`)

## Cara Menggunakan CRUD Generator

Generator ini membuat CRUD lengkap (Model, Migration, Controller, Request, Resource, Interface, Repository, Factory, dan route) secara otomatis.

1. Jalankan perintah:
   ```bash
   php artisan make:apiv1 {Name}
   ```
   Ganti `{Name}` dengan nama entitas yang diinginkan (tanpa spasi), misal `Product`, `Category`, dll.

2. Contoh:
   ```bash
   php artisan make:apiv1 Product
   ```

3. Setelah dijalankan, akan dibuatkan:
   - Model `Product` dengan trait SoftDeletes & UUID
   - Migration `create_products_table`
   - Form Request `StoreProductRequest` & `UpdateProductRequest`
   - API Resource `ProductResource`
   - Interface `ProductRepositoryInterface`
   - Repository `ProductRepository` dengan implementasi CRUD
   - Binding interface di `RepositoryServiceProvider`
   - Factory `ProductFactory`
   - Route API di `routes/api.php`: `Route::apiResource('product', ProductController::class);`

4. Jalankan migrasi jika ada file baru:
   ```bash
   php artisan migrate
   ```

## Testing

Jalankan unit/feature test:
```bash
php artisan test
```

## Kontribusi

Silakan kirim *pull request* untuk perbaikan atau fitur baru. ��

## Lisensi

MIT
