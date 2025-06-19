<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> | FiberNet Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#60A5FA',
                        accent: '#1E40AF',
                        light: '#EFF6FF',
                        sidebar: '#1F2937',
                        sidebarHover: '#374151'
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-sidebar transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:transform-none">
            <!-- Logo Area -->
            <div class="flex items-center justify-center h-16 px-4 bg-accent border-b border-gray-600">
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-lg p-2">
                        <i class="fas fa-bolt text-accent text-lg"></i>
                    </div>
                    <div>
                        <span class="text-white text-xl font-bold">FiberNet</span>
                        <div class="text-blue-200 text-xs font-medium">DASHBOARD</div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto">
                <div class="space-y-2">
                    <a href="/dashboard" class="flex items-center px-4 py-3 text-gray-300 hover:bg-sidebarHover hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-tachometer-alt w-5 text-center mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/dashboard/usage" class="flex items-center px-4 py-3 text-gray-300 hover:bg-sidebarHover hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-chart-line w-5 text-center mr-3"></i>
                        <span>Penggunaan Data</span>
                    </a>
                    <a href="/dashboard/billing" class="flex items-center px-4 py-3 text-gray-300 hover:bg-sidebarHover hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-credit-card w-5 text-center mr-3"></i>
                        <span>Tagihan</span>
                    </a>
                    <a href="/dashboard/packages" class="flex items-center px-4 py-3 text-gray-300 hover:bg-sidebarHover hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-box w-5 text-center mr-3"></i>
                        <span>Paket Saya</span>
                    </a>
                    <a href="/dashboard/support" class="flex items-center px-4 py-3 text-gray-300 hover:bg-sidebarHover hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-headset w-5 text-center mr-3"></i>
                        <span>Dukungan</span>
                    </a>
                    <a href="/dashboard/profile" class="flex items-center px-4 py-3 text-gray-300 hover:bg-sidebarHover hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-user w-5 text-center mr-3"></i>
                        <span>Profil Saya</span>
                    </a>
                </div>
                
                <!-- Bottom Links -->
                <div class="mt-8 pt-4 border-t border-gray-600">
                    <a href="/" class="flex items-center px-4 py-3 text-gray-300 hover:bg-sidebarHover hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-home w-5 text-center mr-3"></i>
                        <span>Kembali ke Website</span>
                    </a>
                    <a href="/logout" class="flex items-center px-4 py-3 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Left Side -->
                        <div class="flex items-center">
                            <button class="lg:hidden text-gray-500 hover:text-gray-600 mr-4" onclick="toggleSidebar()">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h1 class="text-xl font-semibold text-gray-900"><?= $this->renderSection('page_title') ?></h1>
                        </div>
                        
                        <!-- Right Side -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="text-gray-500 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-bell text-lg"></i>
                                    <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                                </button>
                            </div>
                            
                            <!-- User Profile -->
                            <div class="flex items-center space-x-3">
                                <div class="hidden sm:block text-right">
                                    <div class="text-sm font-medium text-gray-900"><?= esc(session()->get('user_name') ?? 'User') ?></div>
                                    <div class="text-xs text-gray-500">Pelanggan Premium</div>
                                </div>
                                <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-4 sm:p-6 lg:p-8">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleButton = event.target.closest('button');
            
            if (window.innerWidth < 1024 && !sidebar.contains(event.target) && !toggleButton) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
