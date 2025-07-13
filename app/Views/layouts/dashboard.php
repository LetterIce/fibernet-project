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
                        secondary: '#DBEAFE',
                        accent: '#1D4ED8',
                        light: '#F8FAFC',
                        sidebar: '#FFFFFF',
                        sidebarHover: '#F1F5F9'
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
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:transform-none">
            <!-- Logo Area -->
            <div class="flex items-center justify-center h-16 px-4 bg-white border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-primary rounded-lg p-2">
                        <i class="fas fa-bolt text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-gray-900 text-xl font-bold">FiberNet</span>
                        <div class="text-primary text-xs font-medium">DASHBOARD</div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto">
                <div class="space-y-1">
                    <?php 
                    $currentUri = uri_string();
                    $isDashboard = ($currentUri === 'dashboard' || $currentUri === '');
                    $isProfile = strpos($currentUri, 'dashboard/profile') !== false;
                    ?>
                    
                    <a href="/dashboard" class="flex items-center px-4 py-3 <?= $isDashboard ? 'bg-secondary text-primary border-r-2 border-primary' : 'text-gray-700 hover:bg-secondary hover:text-primary' ?> rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-tachometer-alt w-5 text-center mr-3 <?= $isDashboard ? 'text-primary' : 'text-gray-500 group-hover:text-primary' ?>"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <!-- Bottom Links -->
                <div class="mt-8 pt-4 border-t border-gray-200">
                    <a href="/" class="flex items-center px-4 py-3 text-gray-700 hover:bg-secondary hover:text-primary rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-home w-5 text-center mr-3 text-gray-500 group-hover:text-primary"></i>
                        <span>Kembali ke Website</span>
                    </a>
                    <a href="/logout" class="flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors duration-200 group">
                        <i class="fas fa-sign-out-alt w-5 text-center mr-3 text-gray-500 group-hover:text-red-600"></i>
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
                            <button class="lg:hidden text-gray-500 hover:text-primary mr-4" onclick="toggleSidebar()">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h1 class="text-xl font-semibold text-gray-900"><?= $this->renderSection('page_title') ?></h1>
                        </div>
                        
                        <!-- Right Side -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="text-gray-500 hover:text-primary p-2 rounded-lg hover:bg-gray-50 transition-colors">
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
            <main class="flex-1 overflow-y-auto bg-white">
                <div class="p-4 sm:p-6 lg:p-8">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-25 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

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
