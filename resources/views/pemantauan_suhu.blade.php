<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemantauan Suhu | GASMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
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
                    <a href="/dashboard" class="sidebar-item flex items-center gap-3 py-3 px-4 rounded-lg mb-2">
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
            <header class="bg-white shadow-md py-4 px-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="material-icons text-gray-500">search</span>
                    <input type="text" placeholder="Type to search..."
                        class="bg-gray-100 px-4 py-2 rounded-md w-64 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                </div>
                <div class="flex items-center gap-6">
                    <button class="bg-gray-100 p-2 rounded-full relative">
                        <span class="material-icons text-gray-500">notifications</span>
                        <span
                            class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">2</span>
                    </button>
                    <button class="bg-gray-100 p-2 rounded-full">
                        <span class="material-icons text-gray-500">chat</span>
                    </button>
                    
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                        <div class="flex items-center gap-2">
                            <img src="https://via.placeholder.com/40" alt="User Photo" class="w-10 h-10 rounded-full">
                            <div>
                                <h4 class="text-gray-800 text-sm font-semibold">{{ Auth::user()->name ?? 'User' }}</h4>
                                <p class="text-gray-500 text-xs">{{ Auth::user()->role ?? 'Admin' }}</p>
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
            </header>

            <main class="flex-1 p-6">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pemantauan Suhu</h1>
                    <p class="text-gray-600">Monitoring suhu dan kelembaban real-time dari sensor DHT22 dengan indikator warna dinamis</p>
                </div>

                <div class="mb-6">
                    <div id="connectionStatus"
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                        Disconnected
                    </div>
                </div>

                <div class="mb-6 bg-white rounded-lg shadow-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Indikator Warna Status</h3>
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Normal (15-40°C, 30-80% RH)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Butuh Penyesuaian (10-15°C atau 25-30% RH)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Tidak Normal (&lt;10°C atau&gt;40°C, &lt;25% atau&gt;80% RH)</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div id="tempCard" class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-gray-500 transition-all duration-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Suhu</h3>
                                <p id="temperatureValue" class="text-3xl font-bold text-gray-800">--°C</p>
                                <p id="temperatureStatus" class="text-sm text-gray-500 mt-1">Status: Memuat...</p>
                            </div>
                            <div class="text-red-500">
                                <i class="material-icons text-4xl">thermostat</i>
                            </div>
                        </div>
                    </div>

                    <div id="humidityCard" class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-gray-500 transition-all duration-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Kelembaban</h3>
                                <p id="humidityValue" class="text-3xl font-bold text-gray-800">--%</p>
                                <p id="humidityStatus" class="text-sm text-gray-500 mt-1">Status: Memuat...</p>
                            </div>
                            <div class="text-blue-500">
                                <i class="material-icons text-4xl">water_drop</i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Update Terakhir</h3>
                                <p id="lastUpdate" class="text-lg font-medium text-green-600">--:--:--</p>
                                <p class="text-sm text-gray-500 mt-1">Waktu terbaru</p>
                            </div>
                            <div class="text-green-500">
                                <i class="material-icons text-4xl">schedule</i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Grafik Suhu Real-time</h3>
                            <button id="clearTempChart"
                                class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                Clear
                            </button>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="temperatureChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Grafik Kelembaban Real-time</h3>
                            <button id="clearHumidityChart"
                                class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                                Clear
                            </button>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="humidityChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Grafik Gabungan Suhu dan Kelembaban Real-Time</h3>
                        <button id="clearCombinedChart"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            Clear Data
                        </button>
                    </div>
                    <div style="height: 400px;">
                        <canvas id="combinedChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Status LED Sensor</h3>
                    <div class="flex gap-6 items-center">
                        <div class="flex items-center gap-2">
                            <div id="ledRed" class="w-4 h-4 rounded-full bg-gray-300 transition-all duration-300"></div>
                            <span class="text-sm text-gray-600">LED Merah (> 40°C)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div id="ledYellow" class="w-4 h-4 rounded-full bg-gray-300 transition-all duration-300"></div>
                            <span class="text-sm text-gray-600">LED Kuning (< 15°C)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div id="ledGreen" class="w-4 h-4 rounded-full bg-green-500 transition-all duration-300"></div>
                            <span class="text-sm text-gray-600">LED Hijau (Normal)</span>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <footer class="bg-[#232733] text-white text-center py-4 w-full">
        <p class="text-sm">&copy; 2024 GASMA. All rights reserved.</p>
    </footer>

    <script>
        // MQTT Configuration
        const MQTT_HOST = '192.168.15.189';
        const MQTT_PORT = 9001;
        const MQTT_TOPIC = 'building/temperature';

        // Variables
        let client;
        let temperatureChart;
        let humidityChart;
        let combinedChart;
        let temperatureData = [];
        let humidityData = [];
        let combinedTempData = [];
        let combinedHumidityData = [];
        let timeLabels = [];
        let combinedTimeLabels = [];
        let temperatureColors = [];
        let humidityColors = [];
        let combinedTempColors = [];
        let combinedHumidityColors = [];
        const maxDataPoints = 20;

        // Status determination functions
        function getTemperatureStatus(temp) {
            if (temp >= 15 && temp <= 40) return 'normal';
            if ((temp >= 10 && temp < 15) || (temp > 40 && temp <= 45)) return 'warning';
            return 'danger';
        }

        function getHumidityStatus(humidity) {
            if (humidity >= 30 && humidity <= 80) return 'normal';
            if ((humidity >= 25 && humidity < 30) || (humidity > 80 && humidity <= 85)) return 'warning';
            return 'danger';
        }

        function getStatusColor(status) {
            switch (status) {
                case 'normal':
                    return {
                        border: 'rgb(34, 197, 94)',
                        background: 'rgba(34, 197, 94, 0.1)'
                    };
                case 'warning':
                    return {
                        border: 'rgb(234, 179, 8)',
                        background: 'rgba(234, 179, 8, 0.1)'
                    };
                case 'danger':
                    return {
                        border: 'rgb(239, 68, 68)',
                        background: 'rgba(239, 68, 68, 0.1)'
                    };
                default:
                    return {
                        border: 'rgb(107, 114, 128)',
                        background: 'rgba(107, 114, 128, 0.1)'
                    };
            }
        }

        // Initialize Charts
        function initializeCharts() {
            // Temperature Chart
            const tempCtx = document.getElementById('temperatureChart').getContext('2d');
            temperatureChart = new Chart(tempCtx, {
                type: 'line',
                data: {
                    labels: timeLabels,
                    datasets: [{
                        label: 'Suhu (°C)',
                        data: temperatureData,
                        borderColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && temperatureColors[index]) {
                                return temperatureColors[index].border;
                            }
                            return 'rgb(239, 68, 68)';
                        },
                        backgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && temperatureColors[index]) {
                                return temperatureColors[index].background;
                            }
                            return 'rgba(107, 114, 128, 0.1)';
                        },
                        segment: {
                            borderColor: function (ctx) {
                                const index = ctx.p0DataIndex;
                                if (temperatureColors[index]) {
                                    return temperatureColors[index].border;
                                }
                                return 'rgb(107, 114, 128)';
                            }
                        },
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && temperatureColors[index]) {
                                return temperatureColors[index].border;
                            }
                            return 'rgb(107, 114, 128)';
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Suhu (°C)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Humidity Chart
            const humCtx = document.getElementById('humidityChart').getContext('2d');
            humidityChart = new Chart(humCtx, {
                type: 'line',
                data: {
                    labels: timeLabels,
                    datasets: [{
                        label: 'Kelembaban (%)',
                        data: humidityData,
                        borderColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && humidityColors[index]) {
                                return humidityColors[index].border;
                            }
                            return 'rgb(30,144,255)';
                        },
                        backgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && humidityColors[index]) {
                                return humidityColors[index].background;
                            }
                            return 'rgba(107, 114, 128, 0.1)';
                        },
                        segment: {
                            borderColor: function (ctx) {
                                const index = ctx.p0DataIndex;
                                if (humidityColors[index]) {
                                    return humidityColors[index].border;
                                }
                                return 'rgb(107, 114, 128)';
                            }
                        },
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && humidityColors[index]) {
                                return humidityColors[index].border;
                            }
                            return 'rgb(107, 114, 128)';
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Kelembaban (%)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Combined Chart
            const combinedCtx = document.getElementById('combinedChart').getContext('2d');
            combinedChart = new Chart(combinedCtx, {
                type: 'line',
                data: {
                    labels: combinedTimeLabels,
                    datasets: [{
                        label: 'Suhu (°C)',
                        data: combinedTempData,
                        borderColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && combinedTempColors[index]) {
                                return combinedTempColors[index].border;
                            }
                            return 'rgb(239, 68, 68)';
                        },
                        backgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && combinedTempColors[index]) {
                                return combinedTempColors[index].background;
                            }
                            return 'rgba(107, 114, 128, 0.1)';
                        },
                        segment: {
                            borderColor: function (ctx) {
                                const index = ctx.p0DataIndex;
                                if (combinedTempColors[index]) {
                                    return combinedTempColors[index].border;
                                }
                                return 'rgb(107, 114, 128)';
                            }
                        },
                        tension: 0.4,
                        yAxisID: 'y',
                        pointBackgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && combinedTempColors[index]) {
                                return combinedTempColors[index].border;
                            }
                            return 'rgb(107, 114, 128)';
                        }
                    }, {
                        label: 'Kelembaban (%)',
                        data: combinedHumidityData,
                        borderColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && combinedHumidityColors[index]) {
                                return combinedHumidityColors[index].border;
                            }
                            return 'rgb(30,144,255)';
                        },
                        backgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && combinedHumidityColors[index]) {
                                return combinedHumidityColors[index].background;
                            }
                            return 'rgba(107, 114, 128, 0.1)';
                        },
                        segment: {
                            borderColor: function (ctx) {
                                const index = ctx.p0DataIndex;
                                if (combinedHumidityColors[index]) {
                                    return combinedHumidityColors[index].border;
                                }
                                return 'rgb(107, 114, 128)';
                            }
                        },
                        tension: 0.4,
                        yAxisID: 'y1',
                        pointBackgroundColor: function (context) {
                            const index = context.dataIndex;
                            if (index !== undefined && combinedHumidityColors[index]) {
                                return combinedHumidityColors[index].border;
                            }
                            return 'rgb(107, 114, 128)';
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Suhu (°C)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Kelembaban (%)'
                            },
                            grid: {
                                drawOnChartArea: false,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        }

        // Update Connection Status
        function updateConnectionStatus(connected) {
            const statusEl = document.getElementById('connectionStatus');
            if (connected) {
                statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                statusEl.innerHTML = '<span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Connected';
            } else {
                statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                statusEl.innerHTML = '<span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>Disconnected';
            }
        }

        // Update LED Status
        function updateLEDStatus(temperature) {
            const ledRed = document.getElementById('ledRed');
            const ledYellow = document.getElementById('ledYellow');
            const ledGreen = document.getElementById('ledGreen');

            // Reset all LEDs
            ledRed.className = 'w-4 h-4 rounded-full bg-gray-300 transition-all duration-300';
            ledYellow.className = 'w-4 h-4 rounded-full bg-gray-300 transition-all duration-300';
            ledGreen.className = 'w-4 h-4 rounded-full bg-gray-300 transition-all duration-300';

            if (temperature > 40) {
                ledRed.className = 'w-4 h-4 rounded-full bg-red-500 shadow-lg transition-all duration-300';
            } else if (temperature < 15) {
                ledYellow.className = 'w-4 h-4 rounded-full bg-yellow-500 shadow-lg transition-all duration-300';
            } else {
                ledGreen.className = 'w-4 h-4 rounded-full bg-green-500 shadow-lg transition-all duration-300';
            }
        }

        // Update Data Display
        function updateDataDisplay(data) {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            const tempCard = document.getElementById('tempCard');
            const humidityCard = document.getElementById('humidityCard');

            // --- SUHU (Temperature) ---
            document.getElementById('temperatureValue').textContent = `${data.suhu.toFixed(1)}°C`;
            const tempStatus = getTemperatureStatus(data.suhu);
            let tempStatusText = 'Normal';
            let tempBorderClass = 'border-green-500';

            if (tempStatus === 'warning') {
                tempStatusText = 'Butuh Penyesuaian';
                tempBorderClass = 'border-yellow-500';
            } else if (tempStatus === 'danger') {
                tempStatusText = 'Tidak Normal';
                tempBorderClass = 'border-red-500';
            }
            document.getElementById('temperatureStatus').textContent = `Status: ${tempStatusText}`;
            tempCard.className = `bg-white rounded-lg shadow-lg p-6 border-l-4 ${tempBorderClass} transition-all duration-500`;
            document.getElementById('temperatureValue').classList.remove('text-red-600', 'text-yellow-600', 'text-green-600');
            document.getElementById('temperatureValue').classList.add(tempStatus === 'danger' ? 'text-red-600' : tempStatus === 'warning' ? 'text-yellow-600' : 'text-green-600');
            

            // --- KELEMBABAN (Humidity) ---
            document.getElementById('humidityValue').textContent = `${data.kelembaban.toFixed(1)}%`;
            const humidityStatus = getHumidityStatus(data.kelembaban);
            let humidityStatusText = 'Normal';
            let humBorderClass = 'border-blue-500';

            if (humidityStatus === 'warning') {
                humidityStatusText = 'Butuh Penyesuaian';
                // Gunakan warna batas yang berbeda untuk Kelembaban agar tidak bingung dengan suhu
                humBorderClass = 'border-yellow-500'; 
            } else if (humidityStatus === 'danger') {
                humidityStatusText = 'Tidak Normal';
                // Gunakan warna batas yang berbeda untuk Kelembaban agar tidak bingung dengan suhu
                humBorderClass = 'border-red-500'; 
            }
            document.getElementById('humidityStatus').textContent = `Status: ${humidityStatusText}`;
            humidityCard.className = `bg-white rounded-lg shadow-lg p-6 border-l-4 ${humBorderClass} transition-all duration-500`;
            document.getElementById('humidityValue').classList.remove('text-red-600', 'text-yellow-600', 'text-green-600');
            document.getElementById('humidityValue').classList.add(humidityStatus === 'danger' ? 'text-red-600' : humidityStatus === 'warning' ? 'text-yellow-600' : 'text-blue-600');
            

            // Update last update time
            document.getElementById('lastUpdate').textContent = timeString;

            // Update LED status (berdasarkan suhu)
            updateLEDStatus(data.suhu);

            // Add data to charts
            addDataToCharts(data.suhu, data.kelembaban, timeString);
        }

        // Add Data to Charts
        function addDataToCharts(temperature, humidity, time) {
            // Determine colors based on status
            const tempStatus = getTemperatureStatus(temperature);
            const humidityStatus = getHumidityStatus(humidity);
            const tempColor = getStatusColor(tempStatus);
            const humidityColor = getStatusColor(humidityStatus);

            // Individual charts data
            temperatureData.push(temperature);
            humidityData.push(humidity);
            timeLabels.push(time);
            temperatureColors.push(tempColor);
            humidityColors.push(humidityColor);

            // Combined chart data
            combinedTempData.push(temperature);
            combinedHumidityData.push(humidity);
            combinedTimeLabels.push(time);
            combinedTempColors.push(tempColor);
            combinedHumidityColors.push(humidityColor);

            // Keep only last maxDataPoints
            if (temperatureData.length > maxDataPoints) {
                temperatureData.shift();
                humidityData.shift();
                timeLabels.shift();
                temperatureColors.shift();
                humidityColors.shift();
            }

            if (combinedTempData.length > maxDataPoints) {
                combinedTempData.shift();
                combinedHumidityData.shift();
                combinedTimeLabels.shift();
                combinedTempColors.shift();
                combinedHumidityColors.shift();
            }

            // Update all charts
            temperatureChart.update();
            humidityChart.update();
            combinedChart.update();
        }

        // Clear Chart Data Functions
        function clearTemperatureChart() {
            temperatureData.length = 0;
            timeLabels.length = 0;
            temperatureColors.length = 0;
            temperatureChart.update();
        }

        function clearHumidityChart() {
            humidityData.length = 0;
            humidityColors.length = 0;
            humidityChart.update();
        }

        function clearCombinedChart() {
            combinedTempData.length = 0;
            combinedHumidityData.length = 0;
            combinedTimeLabels.length = 0;
            combinedTempColors.length = 0;
            combinedHumidityColors.length = 0;
            combinedChart.update();
        }

        // Initialize MQTT Connection
        function connectMQTT() {
            client = new Paho.MQTT.Client(MQTT_HOST, MQTT_PORT, "web_client_" + Math.random().toString(16).substr(2, 8));

            client.onConnectionLost = function (responseObject) {
                if (responseObject.errorCode !== 0) {
                    console.log("Connection lost: " + responseObject.errorMessage);
                    updateConnectionStatus(false);
                    setTimeout(connectMQTT, 5000);
                }
            };

            client.onMessageArrived = function (message) {
                console.log("Message received: " + message.payloadString);
                try {
                    const data = JSON.parse(message.payloadString);
                    updateDataDisplay(data);
                } catch (error) {
                    console.error("Error parsing message:", error);
                }
            };

            const options = {
                onSuccess: function () {
                    console.log("Connected to MQTT broker");
                    updateConnectionStatus(true);
                    client.subscribe(MQTT_TOPIC);
                    console.log("Subscribed to topic: " + MQTT_TOPIC);
                },
                onFailure: function (error) {
                    console.log("Connection failed: " + error.errorMessage);
                    updateConnectionStatus(false);
                    setTimeout(connectMQTT, 5000);
                }
            };

            try {
                client.connect(options);
            } catch (error) {
                console.error("MQTT connection error:", error);
                updateConnectionStatus(false);
            }
        }

        // Simulate Data (Fallback)
        function simulateData() {
            // Check if simulation is already running (assuming you implement an interval variable in a real app)
            // For this snippet, we'll skip interval control for brevity, assuming the function is called once if MQTT fails.
             console.log("Simulating data...");
             setInterval(() => {
                 const simulatedData = {
                     suhu: 5 + Math.random() * 50, // Range 5-55°C
                     kelembaban: 15 + Math.random() * 75 // Range 15-90%
                 };
                 updateDataDisplay(simulatedData);
             }, 3000); // Every 3 seconds
        }

        // --- START FIX: Sidebar Active Class Logic ---
        function setSidebarActiveState() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            // Mengambil pathname saat ini, misalnya '/pemantauan_suhu'
            const currentPath = window.location.pathname.replace(/\/$/, ""); 

            // Loop untuk mengatur kelas 'active'
            sidebarItems.forEach(item => {
                item.classList.remove('active');
                
                // Cek apakah href item sama dengan path saat ini
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                }
            });
        }
        // --- END FIX ---


        // Event Listeners
        document.getElementById('clearTempChart').addEventListener('click', clearTemperatureChart);
        document.getElementById('clearHumidityChart').addEventListener('click', clearHumidityChart);
        document.getElementById('clearCombinedChart').addEventListener('click', clearCombinedChart);
        
        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function () {
            initializeCharts();
            connectMQTT();
            setSidebarActiveState(); // Panggil fungsi perbaikan
        });
    </script>
</body>

</html>