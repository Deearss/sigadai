#!/bin/bash
echo "🚀 Memulai server Laravel dan Vite secara bersamaan..."

# Pastikan proses lama dibersihkan (opsional)
killall -9 php 2>/dev/null
killall -9 node 2>/dev/null

# Jalankan backend (Laravel) di background
php artisan serve &
LARAVEL_PID=$!

# Jalankan frontend (Vite) di foreground
npm run dev

# Kalau Vite dimatikan (Ctrl+C), pastikan Laravel juga ikut mati
kill $LARAVEL_PID
