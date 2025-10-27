# jalankan server lokal
php artisan serve --port=8000

# di jendela PowerShell lain, jalankan ngrok
ngrok http 8000

# jika ganti APP_URL (.env), clear config
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear