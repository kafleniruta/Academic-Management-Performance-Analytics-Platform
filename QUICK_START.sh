#!/bin/bash

echo "=== Academic Management Platform Quick Start ==="
echo ""
echo "Step 1: Make sure MAMP is running with MySQL on port 8889"
echo "Step 2: Create database 'academic_management' in phpMyAdmin"
echo "Step 3: Press Enter to continue..."
read

echo "Step 4: Clearing caches..."
php artisan config:clear
php artisan cache:clear

echo "Step 5: Running database migrations..."
php artisan migrate --force

echo "Step 6: Starting development server..."
echo "Server will start at: http://localhost:8000"
echo "API Documentation: http://localhost:8000/api"
echo ""
echo "Press Ctrl+C to stop the server"
php artisan serve
