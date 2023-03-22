# Sistem Informasi Pembayaran SPP

> _Mengelola pembayaran SPP dengan sistem informasi._

Sistem Informasi Pembayaran SPP dibuat dengan Framework **Laravel 8**

### Daftar Isi

1. [Tentang Sistem Informasi SPP](#tentang)
2. [Tujuan](#tujuan)
3. [Cara Install](#cara-install)
    - [Spesifikasi yang Dibutuhkan](#spesifikasi-minimum-server)
    - [Tahap Install](#tahap-install)

---

## Tentang

**Sistem Informasi Pembayaran SPP** adalah software yang bertujuan untuk mempermudah pelayanan pembayaran pada sekolah. Software ini bisa digunakan untuk Sekolah Dasar/Sederajat, Sekolah Menengah Pertama/Sederajat, Sekolah Menengah Atas/Sederajat.

## Cara Install

Software ini dapat dipasang dalam server lokal (PC/Laptop) dan server online, dengan spesifikasi berikut :

#### Spesifikasi minimum server

PHP >= 7.4 (dan memenuhi [server requirement Laravel 8.x](https://laravel.com/docs/8.x/deployment#server-requirements))

#### Tahap Install

1. `$ composer install atau composer update`
2. `$ cp .env.example .env`
3. `$ php artisan key:generate`
4. Buat database pada MySQL untuk aplikasi ini
5. Setting database pada file `.env`
6. `$ php artisan migrate --seed`
7. `$ php artisan serve`
8. Login menggunakan email `farhan@domain.com` dan password `password` untuk admin
9. Login menggunakan nis `11700599` dan password `password` untuk user
10. Selesai
