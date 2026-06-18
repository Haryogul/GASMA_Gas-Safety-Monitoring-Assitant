<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemantauan Lokasi | GASMA</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
        
        #map { height: 500px; width: 100%; border-radius: 0.5rem; }
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
                    <i class="material-icons text-3xl text-blue-600">location_on</i> Pelacakan Lokasi (NEO-6M)
                </h2>

                <div class="mb-6 flex justify-between items-center bg-white p-4 rounded-lg shadow">
                    <div id="connectionStatus" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                         Disconnected
                    </div>
                    <div class="text-gray-600 text-sm">
                        Lokasi Terakhir: <span id="lastCoords">--</span> | Akurasi: <span id="gpsAccuracy">--</span>
                    </div>
                </div>

                <div id="map" class="shadow-lg"></div>

            </main>

            <script>
                // Konfigurasi MQTT
                const MQTT_HOST = '192.168.15.189'; // Ganti dengan IP broker Anda
                const MQTT_PORT = 9001; // Port WebSocket MQTT
                const MQTT_TOPIC = 'gasma/gps/location'; // Topik dari NEO-6M

                let map;
                let marker;
                let client;
                // Menggunakan koordinat Jakarta sebagai contoh default
                const initialLat = -6.2088; 
                const initialLon = 106.8456;
                const initialZoom = 13;

                // --- FUNGSI PETA & MARKER ---

                function initializeMap() {
                    map = L.map('map').setView([initialLat, initialLon], initialZoom);

                    // LAYER 1: GOOGLE SATELIT (CITRA)
                    L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
                        attribution: 'Google Satellite',
                        maxZoom: 20
                    }).addTo(map);

                    // LAYER 2: GOOGLE LABEL (JALAN/NAMA TEMPAT) - Diletakkan di atas Satelit untuk Hybrid
                    L.tileLayer('http://www.google.cn/maps/vt?lyrs=h@189&gl=cn&x={x}&y={y}&z={z}', {
                        pane: 'markerPane',
                        attribution: 'Google Labels'
                    }).addTo(map);


                    marker = L.marker([initialLat, initialLon]).addTo(map)
                        .bindPopup('Lokasi Awal')
                        .openPopup();
                }

                function updateMarkerLocation(lat, lon, accuracy = '--') {
                    const newLatLng = new L.LatLng(lat, lon);
                    marker.setLatLng(newLatLng);
                    marker.setPopupContent(`Lokasi GPS Terbaru: ${lat.toFixed(4)}, ${lon.toFixed(4)}`).openPopup();
                    map.setView(newLatLng, 15); // Zoom in pada lokasi baru
                    document.getElementById('lastCoords').textContent = `${lat.toFixed(4)}, ${lon.toFixed(4)}`;
                    document.getElementById('gpsAccuracy').textContent = accuracy !== '--' ? `${parseFloat(accuracy).toFixed(2)} m` : '--';
                }

                // --- FUNGSI MQTT ---

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
                    client = new Paho.MQTT.Client(MQTT_HOST, MQTT_PORT, "web_gps_client_" + Math.random().toString(16).substr(2, 8));

                    client.onConnectionLost = function (responseObject) {
                        if (responseObject.errorCode !== 0) {
                            console.log("Connection lost: " + responseObject.errorMessage);
                            updateConnectionStatus(false);
                            setTimeout(connectMQTT, 5000); // Coba koneksi ulang
                        }
                    };

                    client.onMessageArrived = function (message) {
                        console.log("GPS Message received: " + message.payloadString);
                        try {
                            // Asumsi format JSON dari ESP32: {"lat": 0.54321, "lon": 101.9876, "acc": 5.2}
                            const data = JSON.parse(message.payloadString);
                            if (data.lat && data.lon) {
                                updateMarkerLocation(parseFloat(data.lat), parseFloat(data.lon), data.acc || '--');
                            }
                        } catch (error) {
                            console.error("Error parsing GPS message:", error);
                        }
                    };

                    const options = {
                        onSuccess: function () {
                            console.log("Connected to MQTT broker for GPS");
                            updateConnectionStatus(true);
                            client.subscribe(MQTT_TOPIC);
                            console.log("Subscribed to topic: " + MQTT_TOPIC);
                        },
                        onFailure: function (error) {
                            console.log(" Connection failed: " + error.errorMessage);
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

                // --- FUNGSI SIDEBAR & INIT ---
                
                function setSidebarActiveState() {
                    const sidebarItems = document.querySelectorAll('.sidebar-item');
                    // Mengambil pathname saat ini, misalnya '/pemantauan_lokasi'
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


                document.addEventListener('DOMContentLoaded', function () {
                    initializeMap();
                    connectMQTT();
                    setSidebarActiveState(); 
                });
            </script>
        </div>
    </div>
</body>

</html>