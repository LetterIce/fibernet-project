<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - FiberNet Admin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Fix header z-index and positioning */
        .admin-header {
            position: sticky !important;
            top: 0 !important;
            z-index: 1000 !important;
            background: white !important;
        }
        
        .admin-sidebar {
            z-index: 999 !important;
        }
        
        .main-content {
            z-index: 1 !important;
            position: relative;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <nav class="admin-sidebar w-64 bg-white shadow-lg border-r border-gray-200 fixed h-full z-10">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wifi text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">FiberNet</h1>
                        <p class="text-sm text-gray-500">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <div class="py-6">
                <nav class="space-y-2 px-4">
                    <a href="/admin" class="<?= uri_string() == 'admin' ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                        Dashboard
                    </a>
                    <a href="/admin/paket" class="<?= strpos(uri_string(), 'admin/paket') !== false ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-box mr-3 text-lg"></i>
                        Paket Internet
                    </a>
                    <a href="/admin/users" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-users mr-3 text-lg"></i>
                        Pelanggan
                    </a>
                    <a href="/admin/orders" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-shopping-cart mr-3 text-lg"></i>
                        Pesanan
                    </a>
                    <a href="/admin/reports" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-chart-bar mr-3 text-lg"></i>
                        Laporan
                    </a>
                </nav>
                
                <div class="mt-8 pt-6 border-t border-gray-200 px-4">
                    <a href="/logout" class="text-gray-600 hover:bg-red-50 hover:text-red-600 group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                        Logout
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <div class="main-content flex-1 ml-64">
            <!-- Header -->
            <header class="admin-header bg-white shadow-sm border-b border-gray-200 sticky top-0 z-5">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900"><?= $this->renderSection('page_title') ?></h1>
                            <p class="text-sm text-gray-600 mt-1"><?= $this->renderSection('page_subtitle') ?></p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <?= $this->renderSection('page_actions') ?>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="p-6">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
