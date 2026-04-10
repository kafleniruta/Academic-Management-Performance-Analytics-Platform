# Academic Management Performance Analytics Platform

A comprehensive Laravel-based academic management system with role-based access control for managing students, courses, and performance tracking.

## Features

### 🔐 Authentication & Role-Based Access Control
- **Admin**: Full system control
- **Teacher**: Manage courses and student performance
- **Student**: View personal academic data
- JWT-based authentication with Laravel Sanctum

### 👥 Student Management
- Create, update, delete, and view student records
- Assign students to courses
- Track enrollment year and personal information
- Data integrity and uniqueness validation

### 📚 Course Management
- Create and manage courses with unique codes
- Assign teachers to courses
- Track credit hours and course descriptions
- Student enrollment management

### 📊 Performance/Marks Management
- Record marks per student per course
- Automatic grade assignment based on marks
- Multiple exam types (midterm, final, assignment, quiz, project)
- Performance statistics and analytics

### 🗄️ Database Design
- Properly normalized tables with clear relationships
- Users, Roles, Students, Courses, Enrollments, and Marks tables
- Foreign key constraints and data integrity

## Technology Stack

- **Backend**: Laravel 10.x
- **Authentication**: Laravel Sanctum
- **Database**: MySQL (configurable)
- **Validation**: Laravel Form Requests
- **API**: RESTful API endpoints

## Installation

### Prerequisites
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js (optional, for frontend development)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Academic-Management-Performance-Analytics-Platform
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit your `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=academic_management
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## API Endpoints

### Authentication
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - User login
- `POST /api/auth/logout` - User logout
- `GET /api/auth/profile` - Get user profile
- `PUT /api/auth/profile` - Update user profile

### Students
- `GET /api/students` - List students
- `POST /api/students` - Create student (Admin/Teacher)
- `GET /api/students/{id}` - Get student details
- `PUT /api/students/{id}` - Update student (Admin/Teacher)
- `DELETE /api/students/{id}` - Delete student (Admin/Teacher)
- `GET /api/students/my/profile` - Student's own profile
- `GET /api/students/my/courses` - Student's enrolled courses
- `GET /api/students/my/marks` - Student's marks

### Courses
- `GET /api/courses` - List courses
- `POST /api/courses` - Create course (Admin/Teacher)
- `GET /api/courses/{id}` - Get course details
- `PUT /api/courses/{id}` - Update course (Admin/Teacher)
- `DELETE /api/courses/{id}` - Delete course (Admin/Teacher)
- `GET /api/courses/available-teachers` - Get available teachers
- `POST /api/courses/{courseId}/enroll/{studentId}` - Enroll student
- `DELETE /api/courses/{courseId}/remove/{studentId}` - Remove student
- `GET /api/courses/{courseId}/students` - Get enrolled students

### Marks
- `GET /api/marks` - List marks
- `POST /api/marks` - Create mark (Admin/Teacher)
- `POST /api/marks/bulk` - Bulk create marks (Admin/Teacher)
- `GET /api/marks/statistics` - Get performance statistics
- `GET /api/marks/{id}` - Get mark details
- `PUT /api/marks/{id}` - Update mark (Admin/Teacher)
- `DELETE /api/marks/{id}` - Delete mark (Admin/Teacher)
- `GET /api/marks/student/{studentId}` - Student's marks
- `GET /api/marks/course/{courseId}` - Course marks (Admin/Teacher)

### Dashboard
- `GET /api/dashboard/stats` - Get dashboard statistics

## Database Schema

### Tables
- **roles**: User roles (admin, teacher, student)
- **users**: User accounts with role assignments
- **students**: Student-specific information
- **courses**: Course information and assignments
- **enrollments**: Many-to-many relationship between students and courses
- **marks**: Student performance records

### Relationships
- Users belong to Roles
- Students belong to Users
- Courses belong to Teachers (Users)
- Students and Courses have many-to-many relationship through Enrollments
- Marks belong to Students and Courses

## Grade System

| Marks Range | Grade | Grade Points |
|-------------|-------|--------------|
| 90-100      | A+    | 4.0          |
| 85-89       | A     | 4.0          |
| 80-84       | A-    | 3.7          |
| 75-79       | B+    | 3.3          |
| 70-74       | B     | 3.0          |
| 65-69       | B-    | 2.7          |
| 60-64       | C+    | 2.3          |
| 55-59       | C     | 2.0          |
| 50-54       | C-    | 1.7          |
| 45-49       | D     | 1.0          |
| Below 45    | F     | 0.0          |

## Security Features

- JWT-based authentication
- Role-based access control
- Input validation and sanitization
- SQL injection prevention
- Rate limiting
- CORS configuration

## Testing

Run the test suite:
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please open an issue in the repository.
