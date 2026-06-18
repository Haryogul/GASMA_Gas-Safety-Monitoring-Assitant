<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem | GASMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
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
                    <input type="text" placeholder="Type to search..." class="bg-gray-100 px-4 py-2 rounded-md w-64 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                </div>
                <div class="flex items-center gap-6">
                    <button class="bg-gray-100 p-2 rounded-full relative">
                        <span class="material-icons text-gray-500">notifications</span>
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">2</span>
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
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2 mb-6">
                    <i class="material-icons text-3xl text-cyan-600">settings</i> Pengaturan Sistem
                </h2>

                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-orange-500"></i> Ambang Batas Sensor Real-time
                    </h3>
                    
                    <div id="mqttStatus" class="mb-4 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                        Disconnected
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <label class="text-gray-700 font-medium flex items-center gap-2 mb-1">
                                <i class="fas fa-smog text-cyan-600"></i> Level Gas Bahaya (MQ2)
                            </label>
                            <p id="gasThresholdDisplay" class="text-3xl font-bold text-red-600">-- PPM</p>
                            <p class="text-sm text-gray-500 mt-1">Nilai di atas ini akan memicu peringatan Darurat.</p>
                        </div>
                        
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <label class="text-gray-700 font-medium flex items-center gap-2 mb-1">
                                <i class="material-icons text-red-600">thermostat</i> Suhu Tinggi (DHT22)
                            </label>
                            <p id="tempThresholdDisplay" class="text-3xl font-bold text-red-600">--°C</p>
                            <p class="text-sm text-gray-500 mt-1">Nilai di atas ini akan memicu peringatan Suhu Tinggi.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                        <i class="fas fa-question-circle text-gray-500"></i> Lupa Password
                    </h3>
                    <p class="text-gray-600">
                        Jika Anda lupa password dan tidak dapat mengakses sistem, silakan hubungi administrator utama atau gunakan 
                        <span class="text-gray-500 cursor-default font-medium">link Pemulihan Password</span> 
                        yang tersedia di halaman *login*.
                    </p>
                </div>
            </main>
            
            <footer class="bg-[#232733] text-white text-center py-4 w-full mt-auto">
                <p class="text-sm">&copy; 2024 GASMA. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <script>
        // MQTT Configuration
        const MQTT_HOST = '192.168.15.189';
        const MQTT_PORT = 9001;
        // Topik baru untuk menerima pengaturan sistem/threshold dari server/backend
        const MQTT_TOPIC_SETTINGS = 'gasma/system/threshold'; 

        let client;

        // Default value jika MQTT belum terhubung/belum ada data
        let currentThresholds = {
            gas: 400,
            temp: 45
        };

        // --- FUNGSI TAMPILAN ---

        function updateThresholdDisplay(thresholds) {
            document.getElementById('gasThresholdDisplay').textContent = `${thresholds.gas} PPM`;
            document.getElementById('tempThresholdDisplay').textContent = `${thresholds.temp}°C`;
        }

        function updateConnectionStatus(connected) {
            const statusEl = document.getElementById('mqttStatus');
            if (connected) {
                statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                statusEl.innerHTML = '<span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Connected';
            } else {
                statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                statusEl.innerHTML = '<span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Disconnected';
            }
        }
        
        // --- FUNGSI MQTT ---

        function connectMQTT() {
            client = new Paho.MQTT.Client(MQTT_HOST, MQTT_PORT, "web_settings_client_" + Math.random().toString(16).substr(2, 8));

            client.onConnectionLost = function (responseObject) {
                if (responseObject.errorCode !== 0) {
                    console.log("Connection lost: " + responseObject.errorMessage);
                    updateConnectionStatus(false);
                    setTimeout(connectMQTT, 5000); 
                }
            };

            client.onMessageArrived = function (message) {
                console.log("Settings Message received: " + message.payloadString);
                try {
                    // Asumsi format JSON dari server: {"gas": 420, "temp": 48}
                    const data = JSON.parse(message.payloadString);
                    if (data.gas && data.temp) {
                        currentThresholds = {
                            gas: parseFloat(data.gas),
                            temp: parseFloat(data.temp)
                        };
                        updateThresholdDisplay(currentThresholds);
                    }
                } catch (error) {
                    console.error("Error parsing settings message:", error);
                }
            };

            const options = {
                onSuccess: function () {
                    console.log("Connected to MQTT broker for Settings");
                    updateConnectionStatus(true);
                    // Subscribe ke topik pengaturan sistem
                    client.subscribe(MQTT_TOPIC_SETTINGS);
                    console.log("Subscribed to topic: " + MQTT_TOPIC_SETTINGS);
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
        
        // --- LOGIKA SIDEBAR & INIT ---
        
        function setSidebarActiveState() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            const currentPath = window.location.pathname.replace(/\/$/, "") || '/dashboard'; 

            sidebarItems.forEach(item => {
                item.classList.remove('active');
                
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                }
            });
        }


        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function () {
            updateThresholdDisplay(currentThresholds); // Tampilkan nilai default saat load
            connectMQTT(); 
            setSidebarActiveState(); 
        });
    </script>
</body>

</html>