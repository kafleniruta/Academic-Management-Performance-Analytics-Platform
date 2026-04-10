# MAMP Setup Guide for Academic Management Platform

## Step 1: Start MAMP
1. Open MAMP application
2. Click "Start Servers" to start Apache and MySQL
3. Wait for servers to start (green indicators)

## Step 2: Create Database
1. Open MAMP's phpMyAdmin (click "Open WebStart page" then "phpMyAdmin")
2. Create a new database named `academic_management`
3. Click "Create" button

## Step 3: Verify MAMP Settings
- MAMP MySQL runs on port 8889 by default
- Username: root
- Password: root
- Host: 127.0.0.1

## Step 4: Test Database Connection
Run this command in terminal:
```bash
php artisan tinker
```
Then test:
```php
DB::connection()->getPdo();
```

## Step 5: Run Migrations
```bash
php artisan migrate
```

## Step 6: Start Development Server
```bash
php artisan serve
```

## Troubleshooting
If migrations fail:
1. Ensure MAMP servers are running
2. Verify database exists in phpMyAdmin
3. Check .env database settings match MAMP settings
4. Try: `php artisan config:clear` then retry migrations
