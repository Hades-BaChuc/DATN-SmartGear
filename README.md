<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">SmartGear — Tech Shop (Laravel)</h1>

<p align="center">
  <a href="https://github.com/Hades-BaChuc/DATN-SmartGear/actions"><img src="https://img.shields.io/badge/build-passing-brightgreen" alt="Build Status"></a>
  <a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-red" alt="Laravel"></a>
  <a href="#"><img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="License"></a>
</p>

SmartGear là website bán **đồ công nghệ** (thay thế cho bookshop cũ) xây dựng bằng **Laravel + Bootstrap**.  
Các thực thể chính: `Product`, `Brand`, `Supplier`, `Category`, giỏ hàng/đơn hàng, seeding dữ liệu demo đầy đủ.

## Tính năng chính
- Danh mục & lọc sản phẩm (theo `category`, `brand`, tìm kiếm theo tên/SKU).
- Trang chi tiết sản phẩm, giá/khuyến mại, tồn kho.
- Giỏ hàng & đặt hàng cơ bản (Orders, Order Items).
- Khu vực quản trị CRUD (Products/Brands/Suppliers/Categories).
- Seeder sinh dữ liệu demo (50 sản phẩm ngẫu nhiên, thương hiệu/nhà cung cấp/mục lục).

## Kiến trúc & công nghệ
- **Backend:** Laravel 12.x, Eloquent ORM, Form Request, Migration/Seeder/Factory.
- **Frontend:** Blade + Bootstrap (Vite).
- **DB:** MySQL 8+ (InnoDB).
- **Khác:** Storage symlink cho ảnh, route resource theo chuẩn REST.

---

## Yêu cầu hệ thống
- PHP 8.2+
- Composer
- Node 18+ / npm
- MySQL 8+ hoặc MariaDB tương đương

---

## Bắt đầu nhanh

```bash
# 1) Clone
git clone https://github.com/Hades-BaChuc/DATN-SmartGear.git
cd DATN-SmartGear

# 2) Cài backend
composer install
cp .env.example .env

# Cập nhật các biến DB_* trong .env cho môi trường local của bạn
php artisan key:generate

# 3) Database
php artisan migrate --seed
php artisan storage:link   # link public/storage

# 4) Frontend assets
npm install
npm run dev    # hoặc: npm run build

# 5) Chạy ứng dụng
php artisan serve   # http://127.0.0.1:8000
