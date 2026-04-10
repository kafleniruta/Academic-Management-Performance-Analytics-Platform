<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Nexus Dashboard | Performance Hub</title>
    <!-- Bootstrap 5 + Icons + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fe 0%, #eef2ff 100%);
            padding: 2rem 0;
        }

        /* custom scroll */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* header */
        .page-header h1 {
            font-weight: 800;
            font-size: 2rem;
            background: linear-gradient(135deg, #1e293b, #2d3a5e);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        /* modern stat cards */
        .stat-card {
            border: none;
            border-radius: 2rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.2);
        }
        .card-primary { background: linear-gradient(145deg, #4f46e5, #7c3aed); }
        .card-success { background: linear-gradient(145deg, #059669, #10b981); }
        .card-danger { background: linear-gradient(145deg, #dc2626, #ef4444); }
        .stat-card .card-body {
            padding: 1.5rem;
            position: relative;
        }
        .stat-icon {
            position: absolute;
            right: 1.2rem;
            bottom: 1rem;
            font-size: 3rem;
            opacity: 0.2;
            color: white;
        }
        .stat-card .card-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .stat-number {
            font-size: 2.6rem;
            font-weight: 800;
            line-height: 1.1;
        }

        /* glass cards for charts & table */
        .glass-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(2px);
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 12px 28px -10px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
        }
        .card-header-custom {
            background: transparent;
            border-bottom: 2px solid #f1f5f9;
            padding: 1.2rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .card-header-custom i { color: #3b82f6; font-size: 1.3rem; }

        /* table styling */
        .rank-table thead th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }
        .rank-table tbody tr {
            transition: background 0.2s;
        }
        .rank-table tbody tr:hover {
            background: #fefce8;
        }
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: #eef2ff;
            border-radius: 40px;
            font-weight: 700;
            color: #2563eb;
        }
        .avg-score-badge {
            background: #e6f7ec;
            color: #15803d;
            padding: 0.3rem 0.9rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .dashboard-container { padding: 0 1rem; }
            .stat-number { font-size: 2rem; }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Back button row - left aligned, outside the header for clear separation -->
    <div class="d-flex justify-content-start mb-3">
        <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary rounded-pill shadow-sm px-4 py-2">
            <i class="fas fa-arrow-left me-2"></i> Back to Admin Dashboard
        </a>
    </div>

    <!-- Header -->
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="fas fa-chalkboard-user me-2 text-primary"></i> Academic Insight</h1>
            <p class="text-muted mt-1">Real‑time performance overview</p>
        </div>
        <div class="bg-white px-3 py-2 rounded-4 shadow-sm">
            <i class="far fa-calendar-alt me-1"></i> {{ date('F j, Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card card-primary text-white">
                <div class="card-body">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <h6 class="card-title"><i class="fas fa-graduation-cap me-1"></i> Total Students</h6>
                    <div class="stat-number">{{ $totalStudents }}</div>
                    <p class="small opacity-75 mb-0 mt-2">Active enrollments</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card card-success text-white">
                <div class="card-body">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <h6 class="card-title"><i class="fas fa-star-of-life me-1"></i> Pass (≥40)</h6>
                    <div class="stat-number">{{ $pass }}</div>
                    <p class="small opacity-75 mb-0 mt-2">Successful records</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card card-danger text-white">
                <div class="card-body">
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <h6 class="card-title"><i class="fas fa-chart-line me-1"></i> Fail (<40)</h6>
                    <div class="stat-number">{{ $fail }}</div>
                    <p class="small opacity-75 mb-0 mt-2">Needs improvement</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="glass-card h-100">
                <div class="card-header-custom">
                    <i class="fas fa-chart-simple"></i> 📊 Course Average Marks
                    <span class="ms-auto badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">per subject</span>
                </div>
                <div class="p-3">
                    <canvas id="avgMarksChart" style="max-height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="glass-card h-100">
                <div class="card-header-custom">
                    <i class="fas fa-chart-pie"></i> 🎯 Pass / Fail Distribution
                </div>
                <div class="p-3 text-center">
                    <canvas id="passFailChart" style="max-height: 240px; width: 100%;"></canvas>
                    <div class="mt-3 d-flex justify-content-center gap-4">
                        <div><span class="badge bg-success px-3 py-2">✔ Pass {{ $passPercent }}%</span></div>
                        <div><span class="badge bg-danger px-3 py-2">✖ Fail {{ $failPercent }}%</span></div>
                    </div>
                    <hr class="my-2">
                    <div class="small text-secondary">Based on {{ $pass + $fail }} graded submissions</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 Students -->
    <div class="glass-card">
        <div class="card-header-custom">
            <i class="fas fa-trophy text-warning"></i> 🏆 Top 5 Students
            <span class="ms-auto small text-muted">by average marks</span>
        </div>
        <div class="table-responsive">
            <table class="table rank-table mb-0">
                <thead>
                    <tr><th>Rank</th><th>Student Name</th><th>Average Marks</th></tr>
                </thead>
                <tbody>
                    @forelse($topStudents as $index => $student)
                    <tr>
                        <td><span class="rank-badge">#{{ $index+1 }}</span> {!! $index==0 ? '🥇' : ($index==1 ? '🥈' : ($index==2 ? '🥉' : '⭐')) !!}</td>
                        <td class="fw-semibold"><i class="fas fa-user-graduate me-2 text-primary"></i>{{ $student->student_name }}</td>
                        <td><span class="avg-score-badge">{{ number_format($student->avg_marks, 2) }}%</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-4 text-muted">No data available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center text-muted small mt-4 pt-2 border-top">
        <i class="fas fa-chalkboard me-1"></i> Performance threshold: 40 marks = passing grade
    </div>
</div>

<script>
    // Course average chart
    const avgLabels = @json($avgMarks->pluck('course_name'));
    const avgValues = @json($avgMarks->pluck('average'));
    new Chart(document.getElementById('avgMarksChart'), {
        type: 'bar',
        data: {
            labels: avgLabels,
            datasets: [{
                label: 'Average Marks',
                data: avgValues,
                backgroundColor: '#3b82f6',
                borderRadius: 10,
                barPercentage: 0.65
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: { y: { beginAtZero: true, max: 100, title: { display: true, text: 'Marks (out of 100)' } } },
            plugins: { tooltip: { callbacks: { label: (ctx) => 📊 ${ctx.raw.toFixed(2)} points } } }
        }
    });

    // Pass/Fail pie chart
    new Chart(document.getElementById('passFailChart'), {
        type: 'pie',
        data: {
            labels: ['Pass', 'Fail'],
            datasets: [{
                data: [{{ $passPercent }}, {{ $failPercent }}],
                backgroundColor: ['#2ecc71', '#e74c3c'],
                borderWidth: 2,
                borderColor: 'white'
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
</script>
</body>
</html>