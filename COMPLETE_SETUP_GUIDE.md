# Complete Setup Guide - Academic Management Platform

## Prerequisites
- MAMP installed on your Mac
- PHP 8.1+ (MAMP includes this)
- Composer installed

## Step-by-Step Setup

### 1. Start MAMP
1. Open MAMP application
2. Click "Start Servers" 
3. Wait for green indicators (Apache & MySQL running)
4. Note: MySQL runs on port 8889 by default

### 2. Create Database
1. Click "Open WebStart page" in MAMP
2. Click "phpMyAdmin" 
3. Click "New" in left sidebar
4. Enter database name: `academic_management`
5. Click "Create" button

### 3. Configure Environment
Your `.env` file is already configured for MAMP:
- Host: 127.0.0.1
- Port: 8889
- Database: academic_management
- Username: root
- Password: root

### 4. Run Setup Commands
```bash
# Navigate to project directory
cd /Users/macbook/Desktop/Academic-Management-Performance-Analytics-Platform

# Clear caches
php artisan config:clear
php artisan cache:clear

# Run database migrations
php artisan migrate

# Seed sample data (optional, for testing)
php artisan db:seed

# Start development server
php artisan serve
```

### 5. Access the Application
- Main API: http://localhost:8000/api
- Development Server: http://localhost:8000

## Test Accounts (if you run db:seed)
- **Admin**: admin@academic.com / password
- **Teacher**: teacher@academic.com / password  
- **Student**: student@academic.com / password

## API Endpoints

### Authentication
- POST `/api/auth/register` - Register new user
- POST `/api/auth/login` - Login user
- POST `/api/auth/logout` - Logout user

### Students (Admin/Teacher access)
- GET `/api/students` - List students
- POST `/api/students` - Create student
- GET `/api/students/{id}` - Get student details
- PUT `/api/students/{id}` - Update student
- DELETE `/api/students/{id}` - Delete student

### Courses (Admin/Teacher access)
- GET `/api/courses` - List courses
- POST `/api/courses` - Create course
- GET `/api/courses/{id}` - Get course details
- PUT `/api/courses/{id}` - Update course
- DELETE `/api/courses/{id}` - Delete course

### Marks (Admin/Teacher access)
- GET `/api/marks` - List marks
- POST `/api/marks` - Create mark entry
- GET `/api/marks/{id}` - Get mark details
- PUT `/api/marks/{id}` - Update mark
- DELETE `/api/marks/{id}` - Delete mark

### Dashboard
- GET `/api/dashboard/stats` - Get statistics

## Role-Based Access Control
- **Admin**: Full access to all endpoints
- **Teacher**: Can manage courses, students, and marks
- **Student**: Can only view own data, courses, and marks

## Testing the System
1. Register a user via POST `/api/auth/register`
2. Login via POST `/api/auth/login`
3. Use the returned token for authenticated requests
4. Test role-based access with different user types

## Features Implemented
- [x] Authentication with JWT tokens
- [x] Role-based access control (Admin, Teacher, Student)
- [x] Student management (CRUD operations)
- [x] Course management with teacher assignments
- [x] Marks/grades management with automatic grade calculation
- [x] Proper database relationships and constraints
- [x] Data validation and error handling
- [x] RESTful API design

## Troubleshooting
- If migrations fail: Ensure database exists and MAMP is running
- If connection fails: Verify MAMP port 8889 is correct
- Clear caches: `php artisan config:clear`
- Check .env file for correct database settings
