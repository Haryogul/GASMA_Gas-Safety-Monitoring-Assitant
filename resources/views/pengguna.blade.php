<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna | GASMA</title>
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

        .pulse-green {
            animation: pulse-green 1.5s infinite;
        }
        @keyframes pulse-green {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
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
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="material-icons text-3xl text-cyan-600">people</i> Manajemen Pengguna & Helm
                    </h2>
                    </div>

                <div class="bg-white rounded-lg shadow-lg overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Helm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Helm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody" class="bg-white divide-y divide-gray-200">
                            <tr id="emptyStateRow">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 italic">Tidak ada helm yang aktif saat ini. Data pengguna akan muncul di sini.</td>
                            </tr>
                        </tbody>
                    </table>
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
        // Topik yang mengirimkan status koneksi setiap helm (misal: 'helm_A/status', 'helm_B/status')
        const MQTT_TOPIC_HELM_STATUS = 'gasma/helm/+/status'; 

        let client;
        const userTableBody = document.getElementById('userTableBody');
        
        // Data Master Pengguna (Dianggap sudah terdaftar di database, kunci: ID Helm)
        const masterUsers = {
            "HELM_A": { id: 1, name: "Budi Santoso", email: "budi@gasma.com", role: "Teknisi" },
            "HELM_B": { id: 2, name: "Rina Wijaya", email: "rina@gasma.com", role: "Operator" },
            "HELM_C": { id: 3, name: "Joko Susilo", email: "joko@gasma.com", role: "Supervisor" },
            "HELM_D": { id: 4, name: "Siti Aisyah", email: "siti@gasma.com", role: "Teknisi" },
        };

        // Data Active Users (Hanya pengguna yang helmnya aktif/terkoneksi)
        let activeUsers = {}; // Key: Helm ID, Value: User Object

        // --- FUNGSI UTILITY ---
        
        function renderUserRow(user) {
            const isActive = user.helmActive;
            const statusClass = isActive 
                ? 'bg-green-100 text-green-800' 
                : 'bg-gray-100 text-gray-800';
            const statusText = isActive ? 'Aktif' : 'Non-aktif';
            const statusPulse = isActive ? 'pulse-green' : '';

            const roleClass = user.role === 'Admin' 
                ? 'bg-blue-100 text-blue-800' 
                : (user.role === 'Supervisor' ? 'bg-indigo-100 text-indigo-800' : 'bg-yellow-100 text-yellow-800');

            return `
                <tr id="row-${user.helmId}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${user.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${user.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.helmId}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span id="helmStatus-${user.helmId}" 
                              class="px-2 inline-flex items-center gap-2 text-xs leading-5 font-semibold rounded-full ${statusClass}">
                            <span class="w-2 h-2 rounded-full ${isActive ? 'bg-green-500 ' + statusPulse : 'bg-gray-500'}"></span>
                            ${statusText}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${roleClass}">${user.role}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        <button title="Edit" class="text-indigo-600 hover:text-indigo-900 mx-1"><i class="fas fa-edit"></i></button>
                        <button title="Hapus" class="text-red-600 hover:text-red-900 mx-1"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        }
        
        function refreshTable() {
            const emptyRow = document.getElementById('emptyStateRow');
            if (emptyRow) {
                userTableBody.removeChild(emptyRow);
            }
            
            if (Object.keys(activeUsers).length === 0) {
                 userTableBody.innerHTML = `
                    <tr id="emptyStateRow">
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 italic">Tidak ada helm yang aktif saat ini. Data pengguna akan muncul di sini.</td>
                    </tr>`;
                return;
            }

            userTableBody.innerHTML = Object.values(activeUsers).map(user => renderUserRow(user)).join('');
        }

        function handleHelmStatusUpdate(helmId, isOnline) {
            const masterUser = masterUsers[helmId];

            if (!masterUser) {
                console.warn(`Helm ID ${helmId} tidak terdaftar di master user list.`);
                return;
            }

            if (isOnline) {
                // Tambahkan pengguna jika helm online dan belum ada di tabel aktif
                if (!activeUsers[helmId]) {
                    activeUsers[helmId] = { ...masterUser, helmActive: true };
                    refreshTable();
                    console.log(`HELM ${helmId} AKTIF. Pengguna ${masterUser.name} ditambahkan.`);
                }
            } else {
                // Hapus pengguna jika helm offline
                if (activeUsers[helmId]) {
                    delete activeUsers[helmId];
                    refreshTable();
                    console.log(`HELM ${helmId} NON-AKTIF. Pengguna ${masterUser.name} dihapus.`);
                }
            }
        }

        // --- FUNGSI MQTT ---

        function connectMQTT() {
            client = new Paho.MQTT.Client(MQTT_HOST, MQTT_PORT, "web_user_client_" + Math.random().toString(16).substr(2, 8));

            client.onConnectionLost = function (responseObject) {
                if (responseObject.errorCode !== 0) {
                    console.log("Connection lost: " + responseObject.errorMessage);
                    setTimeout(connectMQTT, 5000); 
                }
            };

            client.onMessageArrived = function (message) {
                const topicParts = message.destinationName.split('/');
                const helmId = topicParts[2];
                const payload = message.payloadString.toLowerCase(); 
                
                let isOnline = false;
                if (payload === "online") {
                    isOnline = true;
                } else if (payload === "offline") {
                    isOnline = false;
                } else {
                    try {
                        const data = JSON.parse(payload);
                        if (data.status === "online") isOnline = true;
                        if (data.status === "offline") isOnline = false;
                    } catch(e) { /* ignore non-standard message */ }
                }

                handleHelmStatusUpdate(helmId, isOnline);
            };

            const options = {
                onSuccess: function () {
                    console.log("Connected to MQTT broker for User Status");
                    client.subscribe(MQTT_TOPIC_HELM_STATUS);
                    console.log("Subscribed to topic: " + MQTT_TOPIC_HELM_STATUS);
                },
                onFailure: function (error) {
                    console.log("Connection failed: " + error.errorMessage);
                    setTimeout(connectMQTT, 5000);
                }
            };

            try {
                client.connect(options);
            } catch (error) {
                console.error("MQTT connection error:", error);
            }
        }
        
        // --- LOGIKA SIDEBAR & INIT ---
        
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


        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function () {
            refreshTable(); 
            connectMQTT(); 
            setSidebarActiveState(); 
        });
    </script>
</body>

</html>