<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemantauan Gas | GASMA</title>
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
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-smog text-3xl text-cyan-600"></i> Pemantauan Gas (Sensor MQ2)
                </h2>

                <div class="mb-6">
                    <div id="connectionStatus" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                        Disconnected
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div id="gasCard" class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-gray-500 transition-all duration-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Level Gas (MQ2)</h3>
                                <p id="gasValue" class="text-3xl font-bold text-gray-800">-- PPM</p>
                                <p id="gasStatus" class="text-sm text-gray-500 mt-1">Status: Memuat...</p>
                            </div>
                            <div class="text-cyan-500">
                                <i class="fas fa-gas-pump text-4xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Batas Normal (Threshold)</h3>
                        <p class="text-xl font-bold text-green-600">0 - 400 PPM</p>
                        <p class="text-sm text-gray-500 mt-1">Status: Aman (Green LED)</p>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-red-500">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Batas Bahaya (Warning)</h3>
                        <p class="text-xl font-bold text-red-600">> 400 PPM</p>
                        <p class="text-sm text-gray-500 mt-1">Status: Bahaya (Red LED & Notifikasi)</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Riwayat Level Gas Real-Time</h3>
                        <button id="clearGasChart" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            Clear Data
                        </button>
                    </div>
                    <div style="height: 400px;">
                        <canvas id="gasChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Status LED Sensor</h3>
                    <div class="flex gap-6 items-center">
                        <div class="flex items-center gap-2">
                            <div id="ledRed" class="w-4 h-4 rounded-full bg-gray-300 transition-all duration-300"></div>
                            <span class="text-sm text-gray-600">LED Merah (Bahaya > 400 PPM)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div id="ledGreen" class="w-4 h-4 rounded-full bg-gray-300 transition-all duration-300"></div>
                            <span class="text-sm text-gray-600">LED Hijau (Aman <= 400 PPM)</span>
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
        const MQTT_TOPIC = 'building/gas'; 

        // Variables
        let client;
        let gasChart;
        let gasData = [];
        let timeLabels = [];
        let gasColors = [];
        const maxDataPoints = 20;
        const GAS_THRESHOLD = 400; // Batasan Bahaya untuk MQ2 (PPM)

        function getGasStatus(gasPPM) {
            if (gasPPM <= GAS_THRESHOLD) return 'normal';
            return 'danger';
        }

        function getStatusColor(status) {
            switch (status) {
                case 'normal':
                    return {
                        border: 'rgb(34, 197, 94)', // Green
                        background: 'rgba(34, 197, 94, 0.1)'
                    };
                case 'danger':
                    return {
                        border: 'rgb(239, 68, 68)', // Red
                        background: 'rgba(239, 68, 68, 0.1)'
                    };
                default:
                    return {
                        border: 'rgb(107, 114, 128)',
                        background: 'rgba(107, 114, 128, 0.1)'
                    };
            }
        }

        // Initialize Chart
        function initializeChart() {
            const ctx = document.getElementById('gasChart').getContext('2d');
            gasChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: timeLabels,
                    datasets: [{
                        label: 'Level Gas (PPM)',
                        data: gasData,
                        borderColor: function(context) {
                            const index = context.dataIndex;
                            if (index !== undefined && gasColors[index]) {
                                return gasColors[index].border;
                            }
                            return 'rgb(107, 114, 128)';
                        },
                        backgroundColor: function(context) {
                            const index = context.dataIndex;
                            if (index !== undefined && gasColors[index]) {
                                return gasColors[index].background;
                            }
                            return 'rgba(107, 114, 128, 0.1)';
                        },
                        segment: {
                            borderColor: function(ctx) {
                                const index = ctx.p0DataIndex;
                                if (gasColors[index]) {
                                    return gasColors[index].border;
                                }
                                return 'rgb(107, 114, 128)';
                            }
                        },
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: function(context) {
                            const index = context.dataIndex;
                            if (index !== undefined && gasColors[index]) {
                                return gasColors[index].border;
                            }
                            return 'rgb(107, 114, 128)';
                        }
                    },
                    {
                        label: 'Batas Bahaya (400 PPM)',
                        data: gasData.map(() => GAS_THRESHOLD),
                        borderColor: 'rgb(239, 68, 68)', 
                        backgroundColor: 'transparent',
                        borderWidth: 1.5,
                        borderDash: [5, 5],
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 800,
                            title: {
                                display: true,
                                text: 'Level Gas (PPM)'
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
                // Jika koneksi terputus, mulai simulasi data
                simulateData(); 
            }
        }

        // Update LED Status
        function updateLEDStatus(gasPPM) {
            const ledRed = document.getElementById('ledRed');
            const ledGreen = document.getElementById('ledGreen');

            ledRed.className = 'w-4 h-4 rounded-full bg-gray-300 transition-all duration-300';
            ledGreen.className = 'w-4 h-4 rounded-full bg-gray-300 transition-all duration-300';

            if (gasPPM > GAS_THRESHOLD) {
                ledRed.className = 'w-4 h-4 rounded-full bg-red-500 shadow-lg transition-all duration-300';
            } else {
                ledGreen.className = 'w-4 h-4 rounded-full bg-green-500 shadow-lg transition-all duration-300';
            }
        }

        // Update Data Display
        function updateDataDisplay(data) {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            const gasPPM = parseFloat(data.gas); 

            document.getElementById('gasValue').textContent = `${gasPPM.toFixed(1)} PPM`;
            const gasStatus = getGasStatus(gasPPM);
            let gasStatusText = 'Aman';
            
            const gasCard = document.getElementById('gasCard');
            gasCard.classList.remove('border-gray-500', 'border-green-500', 'border-red-500');
            
            if (gasStatus === 'danger') {
                gasStatusText = 'BAHAYA!';
                document.getElementById('gasStatus').classList.remove('text-green-600', 'text-gray-500');
                document.getElementById('gasStatus').classList.add('text-red-600', 'font-extrabold');
                gasCard.classList.add('border-red-500');
            } else {
                document.getElementById('gasStatus').classList.remove('text-red-600', 'font-extrabold', 'text-gray-500');
                document.getElementById('gasStatus').classList.add('text-green-600');
                gasCard.classList.add('border-green-500');
            }
            document.getElementById('gasStatus').textContent = `Status: ${gasStatusText}`;

            updateLEDStatus(gasPPM);
            addDataToChart(gasPPM, timeString);
        }

        // Add Data to Chart
        function addDataToChart(gasPPM, time) {
            const gasStatus = getGasStatus(gasPPM);
            const gasColor = getStatusColor(gasStatus);

            gasData.push(gasPPM);
            timeLabels.push(time);
            gasColors.push(gasColor);

            if (gasData.length > maxDataPoints) {
                gasData.shift();
                timeLabels.shift();
                gasColors.shift();
            }

            gasChart.update();
        }

        // Clear Chart Data Function
        function clearGasChart() {
            gasData.length = 0;
            timeLabels.length = 0;
            gasColors.length = 0;
            gasChart.update();
        }

        // Initialize MQTT Connection
        function connectMQTT() {
            client = new Paho.MQTT.Client(MQTT_HOST, MQTT_PORT, "web_client_" + Math.random().toString(16).substr(2, 8));

            client.onConnectionLost = function(responseObject) {
                if (responseObject.errorCode !== 0) {
                    console.log("Connection lost: " + responseObject.errorMessage);
                    updateConnectionStatus(false);
                    setTimeout(connectMQTT, 5000);
                }
            };

            client.onMessageArrived = function(message) {
                console.log("Message received: " + message.payloadString);
                try {
                    const data = JSON.parse(message.payloadString);
                    updateDataDisplay(data);
                } catch (error) {
                    console.error("Error parsing message:", error);
                }
            };

            const options = {
                onSuccess: function() {
                    console.log("Connected to MQTT broker");
                    updateConnectionStatus(true);
                    client.subscribe(MQTT_TOPIC);
                    console.log("Subscribed to topic: " + MQTT_TOPIC);
                },
                onFailure: function(error) {
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
                // Biarkan simulasi dimulai di dalam updateConnectionStatus(false)
            }
        }

        // Simulate Data (fallback when MQTT is not available)
        let simulationInterval = null;
        function simulateData() {
             if (simulationInterval) return; // Prevent multiple intervals
            
            console.log("Simulating data...");
            simulationInterval = setInterval(() => {
                const simulatedGas = 100 + Math.random() * 500; // Range 100-600 PPM
                const simulatedData = {
                    gas: simulatedGas.toFixed(1)
                };
                updateDataDisplay(simulatedData);
            }, 3000);
        }
        
        // --- START FIX: Sidebar Active Class Logic ---
        function setSidebarActiveState() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            // Mengambil pathname saat ini, misalnya '/pemantauan_gas'
            const currentPath = window.location.pathname.replace(/\/$/, ""); 

            // Hapus class 'active' dari semua item terlebih dahulu
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
        document.getElementById('clearGasChart').addEventListener('click', clearGasChart);
        
        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeChart();
            connectMQTT();
            setSidebarActiveState(); 
        });
    </script>
</body>

</html>