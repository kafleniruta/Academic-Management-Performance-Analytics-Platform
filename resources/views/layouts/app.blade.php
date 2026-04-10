<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Academic Management Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .sidebar-gradient {
            background: linear-gradient(180deg, #4f46e5 0%, #7c3aed 100%);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .nav-item {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .table-hover tbody tr:hover {
            background-color: #f3f4f6;
            transition: background-color 0.3s ease;
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex" x-cloak>
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-full" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-full" class="fixed inset-y-0 left-0 z-50 w-64 sidebar-gradient text-white shadow-2xl lg:relative lg:flex lg:flex-col lg:transform lg:translate-x-0">
            <div class="flex items-center justify-between h-16 px-6 border-b border-white border-opacity-20">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white">Academic Platform</h1>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="mt-6 px-4">
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <!-- ADMIN NAVIGATION -->
                            <div class="pt-4 pb-2">
                                <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                    <i class="fas fa-shield-alt mr-1"></i>Admin Panel
                                </h3>
                            </div>
                            
                            <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-chart-pie w-5 mr-3"></i>
                                <span>Admin Dashboard</span>
                                <span class="ml-auto bg-red-500 text-xs px-2 py-1 rounded-full">Analytics</span>
                            </a>
                            
                            <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-users-cog w-5 mr-3"></i>
                                <span>User Management</span>
                                <span class="ml-auto bg-blue-500 text-xs px-2 py-1 rounded-full">CRUD</span>
                            </a>
                            
                            <a href="{{ route('admin.roles.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-user-tag w-5 mr-3"></i>
                                <span>Role Management</span>
                                <span class="ml-auto bg-purple-500 text-xs px-2 py-1 rounded-full">CRUD</span>
                            </a>

                            <div class="pt-4 pb-2">
                                <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                    <i class="fas fa-graduation-cap mr-1"></i>Academic Management
                                </h3>
                            </div>
                            
                            <a href="{{ route('students.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-user-graduate w-5 mr-3"></i>
                                <span>Students</span>
                                <span class="ml-auto bg-green-500 text-xs px-2 py-1 rounded-full">CRUD</span>
                            </a>
                            
                            <a href="{{ route('courses.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-book w-5 mr-3"></i>
                                <span>Courses</span>
                                <span class="ml-auto bg-orange-500 text-xs px-2 py-1 rounded-full">CRUD</span>
                            </a>
                            
                            <a href="{{ route('marks.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-chart-line w-5 mr-3"></i>
                                <span>Marks</span>
                                <span class="ml-auto bg-pink-500 text-xs px-2 py-1 rounded-full">CRUD</span>
                            </a>

                            <div class="pt-4 pb-2">
                                <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                    <i class="fas fa-plus-circle mr-1"></i>Quick Actions
                                </h3>
                            </div>
                            
                            <a href="{{ route('admin.users.create') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-user-plus w-5 mr-3"></i>
                                <span>Add User</span>
                            </a>
                            
                            <a href="{{ route('students.create') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-user-plus w-5 mr-3"></i>
                                <span>Add Student</span>
                            </a>
                            
                            <a href="{{ route('courses.create') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-plus-circle w-5 mr-3"></i>
                                <span>Add Course</span>
                            </a>
                            
                            <a href="{{ route('marks.create') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-plus-square w-5 mr-3"></i>
                                <span>Add Mark</span>
                            </a>

                        @elseif(auth()->user()->isTeacher())
                            <!-- TEACHER NAVIGATION -->
                            <div class="pt-4 pb-2">
                                <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                    <i class="fas fa-chalkboard-teacher mr-1"></i>Teacher Panel
                                </h3>
                            </div>
                            
                            <a href="{{ route('courses.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-book w-5 mr-3"></i>
                                <span>My Courses</span>
                                <span class="ml-auto bg-blue-500 text-xs px-2 py-1 rounded-full">Manage</span>
                            </a>
                            
                            <a href="{{ route('students.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-user-graduate w-5 mr-3"></i>
                                <span>Students</span>
                                <span class="ml-auto bg-green-500 text-xs px-2 py-1 rounded-full">View</span>
                            </a>
                            
                            <a href="{{ route('marks.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-chart-line w-5 mr-3"></i>
                                <span>Marks Management</span>
                                <span class="ml-auto bg-orange-500 text-xs px-2 py-1 rounded-full">CRUD</span>
                            </a>

                            <div class="pt-4 pb-2">
                                <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                    <i class="fas fa-plus-circle mr-1"></i>Quick Actions
                                </h3>
                            </div>
                            
                            <a href="{{ route('courses.create') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-plus-circle w-5 mr-3"></i>
                                <span>Create Course</span>
                            </a>
                            
                            <a href="{{ route('marks.create') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-plus-square w-5 mr-3"></i>
                                <span>Enter Marks</span>
                            </a>
                            
                            <a href="{{ route('marks.statistics') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-chart-bar w-5 mr-3"></i>
                                <span>Mark Statistics</span>
                            </a>

                        @elseif(auth()->user()->isStudent())
                            <!-- STUDENT NAVIGATION -->
                            <div class="pt-4 pb-2">
                                <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                    <i class="fas fa-user-graduate mr-1"></i>Student Panel
                                </h3>
                            </div>
                            
                            <a href="{{ route('students.mycourses') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-book-open w-5 mr-3"></i>
                                <span>My Courses</span>
                                <span class="ml-auto bg-blue-500 text-xs px-2 py-1 rounded-full">Active</span>
                            </a>
                            
                            <a href="{{ route('students.mymarks') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-award w-5 mr-3"></i>
                                <span>My Marks</span>
                                <span class="ml-auto bg-green-500 text-xs px-2 py-1 rounded-full">Grades</span>
                            </a>

                            <div class="pt-4 pb-2">
                                <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-1"></i>Academic Info
                                </h3>
                            </div>
                            
                            <a href="{{ route('courses.index') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-list w-5 mr-3"></i>
                                <span>All Courses</span>
                                <span class="ml-auto bg-purple-500 text-xs px-2 py-1 rounded-full">Browse</span>
                            </a>
                            
                            <a href="{{ route('dashboard') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-chart-pie w-5 mr-3"></i>
                                <span>My Performance</span>
                                <span class="ml-auto bg-orange-500 text-xs px-2 py-1 rounded-full">Stats</span>
                            </a>
                        @endif
                        
                        <div class="pt-4 pb-2">
                            <h3 class="text-xs font-semibold text-white text-opacity-50 uppercase tracking-wider">
                                <i class="fas fa-cog mr-1"></i>System
                            </h3>
                        </div>
                        
                        <a href="javascript:history.back()" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <i class="fas fa-arrow-left w-5 mr-3"></i>
                            <span>Go Back</span>
                        </a>
                        
                        <a href="{{ url()->previous() }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <i class="fas fa-history w-5 mr-3"></i>
                            <span>Previous Page</span>
                        </a>
                        
                        <a href="{{ route('dashboard') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <i class="fas fa-home w-5 mr-3"></i>
                            <span>Home</span>
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center px-4 py-3 text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 rounded-lg">
                                <i class="fas fa-shield-alt w-5 mr-3"></i>
                                <span>Admin Panel</span>
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top navigation -->
            <div class="sticky top-0 z-40 bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600 hover:bg-red-50 px-3 py-2 rounded-lg transition flex items-center space-x-2">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
