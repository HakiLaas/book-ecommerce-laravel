#!/bin/bash

echo "🚀 Menjalankan Migration untuk Book Store..."
echo ""

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations
echo "📦 Menjalankan migrations..."
php artisan migrate

# Seed categories
echo "🌱 Menambahkan kategori default..."
php artisan db:seed --class=CategorySeeder

echo ""
echo "✅ Setup selesai!"
echo ""
echo "📋 Migration yang dijalankan:"
echo "  - Categories table"
echo "  - Category ID column in books"
echo "  - Transaction status history table"
echo "  - User notifications table"
echo "  - Admin notifications status column update"
echo ""
echo "🎉 Semua siap digunakan!"


