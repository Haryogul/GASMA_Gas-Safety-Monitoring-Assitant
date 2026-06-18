<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Insiden | GASMA</title>
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
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="material-icons text-3xl text-red-600">notification_important</i> Riwayat Notifikasi Insiden
                </h2>

                <div class="mb-6">
                    <div id="connectionStatus" 
                         class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                         Disconnected
                    </div>
                </div>

                <div id="incidentList" class="grid grid-cols-1 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-gray-400">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-lg text-gray-700">Menunggu Notifikasi Real-time</h3>
                            <span class="text-xs text-gray-500">--:--:--</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Riwayat insiden akan muncul di sini ketika perangkat mengirimkan peringatan.</p>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>**Lokasi:** N/A</span>
                            <span>**Tingkat:** Normal</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-6">
                    <button id="loadMore" class="px-6 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition font-medium text-sm">
                        Muat Lebih Banyak Riwayat Database
                    </button>
                </div>
            </main>
        </div>
    </div>

    <footer class="bg-[#232733] text-white text-center py-4 w-full">
        <p class="text-sm">&copy; 2025 GASMA. All rights reserved.</p>
    </footer>

    <script>
        // MQTT Configuration
        const MQTT_HOST = '192.168.15.189';
        const MQTT_PORT = 9001;
        // TOPIK YANG BERISI DATA ALERT (CONTOH: GAS, SUHU)
        const MQTT_TOPIC_ALERTS = 'gasma/alerts'; 

        let client;
        const incidentList = document.getElementById('incidentList');
        
        // --- LOGIKA STATUS & TAMPILAN ---
        
        function getIncidentDisplay(incidentType, value, location) {
            let title, description, border, titleColor, level;

            switch (incidentType) {
                case 'GAS_DANGER':
                    title = '🚨 GAS BAHAYA (LEVEL TINGGI)';
                    description = `Sensor Gas mendeteksi level ${value.toFixed(1)} PPM, melebihi ambang batas bahaya.`;
                    border = 'border-red-500';
                    titleColor = 'text-red-700';
                    level = 'Darurat';
                    break;
                case 'TEMP_DANGER':
                    title = '🔥 SUHU SANGAT TINGGI';
                    description = `Sensor Suhu mencatat ${value.toFixed(1)}°C. Diperlukan tindakan segera!`;
                    border = 'border-red-500';
                    titleColor = 'text-red-700';
                    level = 'Darurat';
                    break;
                case 'HUMIDITY_WARNING':
                    title = '⚠️ KELEMBABAN BERLEBIH';
                    description = `Kelembaban ${value.toFixed(1)}% RH terdeteksi, mendekati batas toleransi.`;
                    border = 'border-yellow-500';
                    titleColor = 'text-yellow-700';
                    level = 'Peringatan';
                    break;
                default:
                    title = '🔔 INSIDEN TIDAK DIKETAHUI';
                    description = `Tipe insiden: ${incidentType} dengan nilai ${value.toFixed(1)}.`;
                    border = 'border-gray-500';
                    titleColor = 'text-gray-700';
                    level = 'Informasi';
            }

            const timestamp = new Date().toLocaleTimeString();

            return `
                <div class="bg-white p-4 rounded-lg shadow-md border-l-4 ${border} animate-pulse-once">
                    <div class="flex justify-between items-center mb-1">
                        <h3 class="font-bold text-lg ${titleColor}">${title}</h3>
                        <span class="text-xs text-gray-500">${timestamp}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">${description}</p>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>**Lokasi:** ${location}</span>
                        <span>**Tingkat:** ${level}</span>
                    </div>
                </div>
            `;
        }
        
        // --- FUNGSI UTAMA NOTIFIKASI ---
        
        function addIncidentCard(data) {
            // Hapus kartu dummy jika masih ada
            if (incidentList.children.length > 0 && incidentList.children[0].classList.contains('border-gray-400')) {
                incidentList.removeChild(incidentList.children[0]);
            }
            
            // Buat kartu insiden baru
            const newCardHTML = getIncidentDisplay(data.type, parseFloat(data.value), data.location);
            const newCard = document.createElement('div');
            newCard.innerHTML = newCardHTML.trim();
            
            // Tambahkan kartu baru di bagian atas
            incidentList.prepend(newCard.firstChild); 
        }

        // --- FUNGSI KONEKSI MQTT (DIPERBAIKI) ---

        function updateConnectionStatus(connected) {
            const statusEl = document.getElementById('connectionStatus');
            if (connected) {
                statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                statusEl.innerHTML = '<span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Connected';
            } else {
                statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                statusEl.innerHTML = '<span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Disconnected';
            }
        }

        function connectMQTT() {
            client = new Paho.MQTT.Client(MQTT_HOST, MQTT_PORT, "web_alert_client_" + Math.random().toString(16).substr(2, 8));

            client.onConnectionLost = function (responseObject) {
                if (responseObject.errorCode !== 0) {
                    console.log("Connection lost: " + responseObject.errorMessage);
                    updateConnectionStatus(false);
                    setTimeout(connectMQTT, 5000); 
                }
            };

            client.onMessageArrived = function (message) {
                console.log("Alert Message received: " + message.payloadString);
                try {
                    // Asumsi format JSON dari perangkat/server: 
                    // {"type": "GAS_DANGER", "value": 520.5, "location": "Area Server"}
                    const data = JSON.parse(message.payloadString);
                    if (data.type && data.value) {
                        addIncidentCard(data);
                    }
                } catch (error) {
                    console.error("Error parsing alert message:", error);
                }
            };

            const options = {
                onSuccess: function () {
                    console.log("Connected to MQTT broker for Alerts");
                    updateConnectionStatus(true);
                    client.subscribe(MQTT_TOPIC_ALERTS);
                    console.log("Subscribed to topic: " + MQTT_TOPIC_ALERTS);
                },
                onFailure: function (error) {
                    console.log("Alerts Connection failed: " + error.errorMessage);
                    updateConnectionStatus(false);
                    setTimeout(connectMQTT, 5000);
                }
            };

            try {
                client.connect(options);
            } catch (error) {
                console.error(" connection error:", error);
                updateConnectionStatus(false);
            }
        }
        
        // --- LOGIKA SIDEBAR & INIT (Konsisten dengan file lain) ---

        function setSidebarActiveState() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            const currentPath = window.location.pathname.replace(/\/$/, ""); 

            sidebarItems.forEach(item => {
                item.classList.remove('active');
                
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                }
            });
        }
        
        // Simulasikan Notifikasi (Jika MQTT gagal)
        function simulateAlerts() {
            console.log("Simulating alerts...");
            const dummyAlerts = [
                { type: "GAS_DANGER", value: 550.2, location: "Ruang Kontrol" },
                { type: "TEMP_DANGER", value: 43.1, location: "Area Produksi B" },
                { type: "HUMIDITY_WARNING", value: 82.0, location: "Gudang Penyimpanan" },
                { type: "GAS_DANGER", value: 480.9, location: "Area Server" },
            ];
            
            setInterval(() => {
                const randomAlert = dummyAlerts[Math.floor(Math.random() * dummyAlerts.length)];
                // Tambahkan sedikit variasi pada nilai
                randomAlert.value += Math.random() * 5; 
                addIncidentCard(randomAlert);
            }, 7000); // Setiap 7 detik
        }


        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function () {
            setSidebarActiveState(); 
            connectMQTT();
            // Anda dapat memanggil simulateAlerts() di sini jika Anda ingin simulasi berjalan
            // secara paralel atau sebagai fallback jika koneksi MQTT gagal.
            // Contoh untuk fallback (HANYA JIKA connectMQTT GAGAL):
            // setTimeout(simulateAlerts, 1000); 
        });
    </script>
</body>

</html>