<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASMA - Dashboard Utama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .metric-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-item {
            transition: all 0.2s ease;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 3px solid #06b6d4;
        }
        
        /* CATATAN: Style .logout-btn kustom dihapus dan diganti dengan kelas Tailwind di HTML */
    </style>
</head>

<body class="bg-slate-50">
    <div class="flex min-h-screen">
        <div class="w-70 gradient-bg text-white shadow-xl">
            <div class="p-6 border-b border-slate-600">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-hard-hat text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">GASMA</h1>
                        <p class="text-xs text-slate-300">Gas Safety Monitoring Assistant</p>
                    </div>
                </div>
            </div>

            <nav class="mt-6 px-4">
                <div class="mb-6">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">MAIN MENU</p>
                    <a href="/dashboard" class="sidebar-item active flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
                        <i class="material-icons text-lg">dashboard</i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="/pemantauan_gas" class="sidebar-item flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
                        <i class="material-icons text-lg">analytics</i>
                        <span class="font-medium">Pemantauan Gas</span>
                    </a>
                    <a href="/pemantauan_suhu" class="sidebar-item flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
                        <i class="material-icons text-lg">thermostat</i>
                        <span class="font-medium">Pemantauan Suhu</span>
                    </a>
                </div>

                <div class="mb-6">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">MONITORING</p>
                    <a href="/notifikasi_insiden" class="sidebar-item flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
                        <i class="material-icons text-lg">notification_important</i>
                        <span class="font-medium">Notifikasi Insiden</span>
                    </a>
                    <a href="/pemantauan_lokasi" class="sidebar-item flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
                        <i class="material-icons text-lg">location_on</i>
                        <span class="font-medium">Lokasi</span>
                    </a>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">SYSTEM</p>
                    <a href="/pengguna" class="sidebar-item flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
                        <i class="material-icons text-lg">people</i>
                        <span class="font-medium">Pengguna</span>
                    </a>
                    <a href="/pengaturan_sistem" class="sidebar-item flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
                        <i class="material-icons text-lg">settings</i>
                        <span class="font-medium">Pengaturan Sistem</span>
                    </a>
                </div>
            </nav>
        </div>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm border-b border-slate-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-semibold text-slate-900">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</h1>
                        <p class="text-slate-600 text-sm">Pantau Keamanan Gas Anda dan Laporkan Keadaan yang serius</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <i class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400">search</i>
                            <input type="text" placeholder="Search for..."
                                class="pl-10 pr-4 py-2 w-80 bg-slate-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-sm">
                        </div>

                        <button class="relative p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                            <i class="material-icons">notifications</i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                        </button>

                        <div class="flex items-center gap-4 pl-4 border-l border-slate-200">
                            <div class="flex items-center gap-3">
                                <img src="https://via.placeholder.com/40" alt="User" class="w-10 h-10 rounded-full">
                                <div class="flex flex-col">
                                    <p class="font-semibold text-slate-900 text-sm">{{ Auth::user()->name ?? 'User' }}</p>
                                    <p class="text-slate-500 text-xs">Admin</p>
                                </div>
                            </div>
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf 
                                <button type="submit" 
                                        class="flex items-center gap-1 bg-red-500 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-600 transition-colors shadow-md">
                                    <i class="fas fa-sign-out-alt text-xs"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 bg-slate-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="metric-card card-hover rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="material-icons text-red-600 text-xl">gas_meter</i>
                            </div>
                            <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">TINGGI</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-1">12 PPM</h3>
                        <p class="text-slate-600 text-sm mb-2">Bahaya Gas Terdeteksi</p>
                        <div class="flex items-center gap-2">
                            <span class="text-red-500 text-xs">↑ Tingkat Bahaya: Tinggi</span>
                        </div>
                    </div>

                    <div class="metric-card card-hover rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="material-icons text-orange-600 text-xl">thermostat</i>
                            </div>
                            <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">TINGGI</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-1">35°C</h3>
                        <p class="text-slate-600 text-sm mb-2">Suhu Tertinggi</p>
                        <div class="flex items-center gap-2">
                            <span class="text-orange-500 text-xs">↑ Suhu Melebihi Batas</span>
                        </div>
                    </div>

                    <div class="metric-card card-hover rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                                <i class="material-icons text-cyan-600 text-xl">warning</i>
                            </div>
                            <span class="text-xs font-semibold text-cyan-600 bg-cyan-100 px-2 py-1 rounded-full">ALERT</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-1">2</h3>
                        <p class="text-slate-600 text-sm mb-2">Jumlah Insiden</p>
                        <div class="flex items-center gap-2">
                            <span class="text-cyan-500 text-xs">↑ Tingkat Keparahan: Tinggi</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Perubahan Tingkat Suhu</h3>
                                <p class="text-slate-600 text-sm">Total temperature changes</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-3 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded hover:bg-slate-200">Harian</button>
                                <button class="px-3 py-1 text-xs font-medium bg-cyan-500 text-white rounded">Mingguan</button>
                                <button class="px-3 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded hover:bg-slate-200">Bulanan</button>
                            </div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="tempChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Perbandingan Insiden Gas</h3>
                                <p class="text-slate-600 text-sm">Last 12 months</p>
                            </div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="incidentChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Riwayat Pemantauan Gas</h3>
                                <p class="text-slate-600 text-sm">Weekly gas level monitoring</p>
                            </div>
                        </div>
                        <div style="height: 250px;">
                            <canvas id="gasHistoryChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Riwayat Insiden</h3>
                                <p class="text-slate-600 text-sm">Incident distribution</p>
                            </div>
                        </div>
                        <div class="flex justify-center" style="height: 200px;">
                            <canvas id="incidentPieChart"></canvas>
                        </div>
                        <div class="mt-6 space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-slate-700 rounded-full"></div>
                                <span class="text-sm text-slate-600">Insiden A</span>
                                <span class="text-sm font-semibold text-slate-900 ml-auto">30%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-slate-400 rounded-full"></div>
                                <span class="text-sm text-slate-600">Insiden B</span>
                                <span class="text-sm font-semibold text-slate-900 ml-auto">50%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-slate-500 rounded-full"></div>
                                <span class="text-sm text-slate-600">Insiden C</span>
                                <span class="text-sm font-semibold text-slate-900 ml-auto">20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Temperature Line Chart
        const tempCtx = document.getElementById('tempChart').getContext('2d');
        new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Suhu (°C)',
                    data: [20, 22, 25, 27, 30, 28, 26, 29, 31, 33, 30, 28],
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 3,
                    pointRadius: 6,
                    pointBackgroundColor: '#06b6d4',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Incident Bar Chart
        const incidentCtx = document.getElementById('incidentChart').getContext('2d');
        new Chart(incidentCtx, {
            type: 'bar',
            data: {
                labels: ['Helm A', 'Helm B', 'Helm C', 'Helm D', 'Helm E'],
                datasets: [{
                    label: 'Jumlah Insiden',
                    data: [5, 3, 8, 6, 9],
                    backgroundColor: [
                        '#1e293b',
                        '#334155',
                        '#475569',
                        '#64748b',
                        '#94a3b8'
                    ],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8',
                            stepSize: 1
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });

        // Gas History Chart
        const gasHistoryCtx = document.getElementById('gasHistoryChart').getContext('2d');
        new Chart(gasHistoryCtx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Tingkat Gas (PPM)',
                    data: [12, 15, 8, 10, 18, 20, 22],
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 3,
                    pointRadius: 6,
                    pointBackgroundColor: '#06b6d4',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8',
                            stepSize: 2
                        }
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Incident Pie Chart
        const pieCtx = document.getElementById('incidentPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Insiden A', 'Insiden B', 'Insiden C'],
                datasets: [{
                    data: [30, 50, 20],
                    backgroundColor: ['#2C3E50', '#95A5A6', '#7F8C8D'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Enhanced Sidebar Navigation with Active State Management
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            const currentPath = window.location.pathname;

            // Set active state based on current URL
            sidebarItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && href !== '#' && currentPath.includes(href.replace('/', ''))) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            // Handle click events
            sidebarItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Don't prevent default for links with valid href
                    const href = this.getAttribute('href');
                    if (!href || href === '#' || this.classList.contains('cursor-not-allowed')) {
                        e.preventDefault();
                        return;
                    }

                    // Update active state
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    // Navigate to the page
                    window.location.href = href;
                });
            });
        });

        // Quick access functions for cards
        function navigateToGasMonitoring() {
            window.location.href = '/pemantauan_gas';
        }

        function navigateToTemperatureMonitoring() {
            window.location.href = '/pemantauan_suhu';
        }

        function navigateToIncidentNotifications() {
            window.location.href = '/notifikasi_insiden';
        }

        // Add click handlers to metric cards for quick navigation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.metric-card');
            cards.forEach((card, index) => {
                card.style.cursor = 'pointer';
                card.addEventListener('click', function() {
                    switch (index) {
                        case 0: // Gas Detection Card
                            navigateToGasMonitoring();
                            break;
                        case 1: // Temperature Card
                            navigateToTemperatureMonitoring();
                            break;
                        case 2: // Incidents Card
                            navigateToIncidentNotifications();
                            break;
                    }
                });
            });
        });
    </script>
</body>

</html>