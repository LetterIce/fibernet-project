<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard Overview
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Background -->
<div class="min-h-screen bg-white">
    <!-- Welcome Section -->
    <div class="mb-6 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-blue-900 bg-clip-text text-transparent mb-2">
            Selamat Datang, <?= esc(session()->get('user_name') ?? 'User') ?>!
        </h2>
        <p class="text-gray-600">Berikut adalah ringkasan aktivitas dan penggunaan internet Anda.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <!-- Current Usage -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:scale-105 transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/3 to-transparent"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Penggunaan Bulan Ini</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-1">
                        <?= number_format($current_usage ?: 456.7, 1) ?> GB
                    </p>
                    <p class="text-sm text-green-600 flex items-center">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i>
                        <span><?= $usage_percentage > 0 ? '+' : '' ?><?= abs($usage_percentage) ?: 12 ?>% dari bulan lalu</span>
                    </p>
                </div>
                <div class="h-12 w-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center flex-shrink-0 ml-4 shadow-sm">
                    <i class="fas fa-download text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Speed Test -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:scale-105 transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/3 to-transparent"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Kecepatan Terakhir</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent mb-1">
                        <?= $latest_speed ? number_format($latest_speed['download_speed'], 1) : '98.5' ?> Mbps
                    </p>
                    <p class="text-sm text-green-600 flex items-center">
                        <i class="fas fa-check-circle mr-1 text-xs"></i>
                        <span>Stabil</span>
                    </p>
                </div>
                <div class="h-12 w-12 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center flex-shrink-0 ml-4 shadow-sm">
                    <i class="fas fa-tachometer-alt text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Current Bill -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:scale-105 transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-500/3 to-transparent"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Tagihan Bulan Ini</p>
                    <?php if ($current_bill): ?>
                        <p class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent mb-1">
                            Rp <?= number_format($current_bill['amount'], 0, ',', '.') ?>
                        </p>
                        <p class="text-sm flex items-center">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span class="<?php 
                                $dueDate = new DateTime($current_bill['due_date']);
                                $today = new DateTime();
                                $interval = $today->diff($dueDate);
                                $daysUntilDue = $interval->invert ? -$interval->days : $interval->days;
                                
                                if ($daysUntilDue < 0) {
                                    echo 'text-red-600';
                                } elseif ($daysUntilDue <= 3) {
                                    echo 'text-orange-600';
                                } else {
                                    echo 'text-orange-600';
                                }
                            ?>">
                                <?php if ($daysUntilDue < 0): ?>
                                    Terlambat <?= abs($daysUntilDue) ?> hari
                                <?php elseif ($daysUntilDue == 0): ?>
                                    Jatuh tempo hari ini
                                <?php else: ?>
                                    Jatuh tempo <?= $daysUntilDue ?> hari
                                <?php endif; ?>
                            </span>
                        </p>
                    <?php else: ?>
                        <p class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent mb-1">
                            Lunas
                        </p>
                        <p class="text-sm text-green-600 flex items-center">
                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                            <span>Tidak ada tagihan pending</span>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="h-12 w-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center flex-shrink-0 ml-4 shadow-sm">
                    <i class="fas fa-credit-card text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Connection Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:scale-105 transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/3 to-transparent"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-600 mb-1">Status Koneksi</p>
                    <p class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-800 bg-clip-text text-transparent mb-1">
                        <?= $connection_status['status'] ?? 'Online' ?>
                    </p>
                    <p class="text-sm text-gray-500 flex items-center">
                        <i class="fas fa-circle text-emerald-500 mr-1 text-xs"></i>
                        <span>Uptime <?= $connection_status['uptime'] ?? '99.9%' ?></span>
                    </p>
                </div>
                <div class="h-12 w-12 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-lg flex items-center justify-center flex-shrink-0 ml-4 shadow-sm">
                    <i class="fas fa-wifi text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <!-- Usage Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-gray-900 to-blue-900 bg-clip-text text-transparent">
                    Penggunaan Data 30 Hari Terakhir
                </h3>
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full shadow-sm">GB</span>
            </div>
            <div class="chart-container">
                <canvas id="usageChart"></canvas>
            </div>
        </div>

        <!-- Speed Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-gray-900 to-green-900 bg-clip-text text-transparent">
                    Riwayat Kecepatan Internet
                </h3>
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full shadow-sm">Mbps</span>
            </div>
            <div class="chart-container">
                <canvas id="speedChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Package Info & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Current Package -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/3 to-transparent"></div>
            <div class="relative">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-gray-900 to-purple-900 bg-clip-text text-transparent mb-6">
                    Paket Saat Ini
                </h3>
                
                <div class="space-y-6">
                    <?php if ($current_package): ?>
                        <div class="text-center">
                            <div class="h-16 w-16 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="fas fa-<?= $current_package['speed'] >= 1000 ? 'bolt' : ($current_package['speed'] >= 250 ? 'rocket' : ($current_package['speed'] >= 100 ? 'wifi' : 'signal')) ?> text-white text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-2">
                                <?= esc($current_package['name']) ?>
                            </h4>
                            <div class="flex items-center justify-center space-x-3 mb-2">
                                <span class="text-2xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                                    <?= $current_package['speed'] >= 1000 ? '1 Gbps' : number_format($current_package['speed']) . ' Mbps' ?>
                                </span>
                                <span class="text-sm text-gray-400">•</span>
                                <span class="text-sm text-gray-600">Unlimited Data</span>
                            </div>
                        </div>
                        
                        <div class="rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="text-center flex-1">
                                    <p class="text-sm font-medium text-gray-700 mb-1">Biaya Bulanan</p>
                                    <p class="text-lg font-bold bg-gradient-to-r from-gray-900 to-blue-900 bg-clip-text text-transparent">
                                        Rp <?= number_format($current_package['price'], 0, ',', '.') ?>
                                    </p>
                                </div>
                                <div class="w-px h-12 bg-gray-200 mx-3"></div>
                                <div class="text-center flex-1">
                                    <p class="text-sm text-gray-500 mb-1">Status</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow-sm">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <?= isset($user['status']) && $user['status'] == 'active' ? 'Aktif' : 'Aktif' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-gray-400 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-600 mb-2">Tidak Ada Paket Aktif</h4>
                            <p class="text-sm text-gray-500 mb-4">Anda belum memiliki paket internet yang aktif.</p>
                            <button class="bg-gradient-to-r from-primary to-accent text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Pilih Paket
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($current_package): ?>
                        <div class="text-center">
                            <button id="upgradePackageBtn" class="w-full text-primary hover:text-accent font-medium text-sm py-3 bg-gray-0 hover:bg-gray-100 rounded-lg transition-all duration-200 border border-gray-200 shadow-sm">
                                <i class="fas fa-arrow-up mr-2"></i>
                                Upgrade Paket
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-500/3 to-transparent"></div>
            <div class="relative">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-gray-900 to-slate-900 bg-clip-text text-transparent mb-6">
                    Aktivitas Terbaru
                </h3>
                <div class="space-y-4">
                    <?php if ($recent_activities && count($recent_activities) > 0): ?>
                        <?php foreach (array_slice($recent_activities, 0, 4) as $activity): ?>
                            <div class="flex items-start space-x-3 p-3 rounded-lg">
                                <div class="h-8 w-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <i class="fas fa-<?= $activity['icon'] ?? 'info-circle' ?> text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900"><?= esc($activity['description']) ?></p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <?php
                                            $activityDate = new DateTime($activity['created_at']);
                                            $now = new DateTime();
                                            $diff = $now->diff($activityDate);
                                            
                                            if ($diff->days > 7) {
                                                echo $diff->days . ' hari yang lalu';
                                            } elseif ($diff->days > 0) {
                                                echo $diff->days . ' hari yang lalu';
                                            } elseif ($diff->h > 0) {
                                                echo $diff->h . ' jam yang lalu';
                                            } elseif ($diff->i > 0) {
                                                echo $diff->i . ' menit yang lalu';
                                            } else {
                                                echo 'Baru saja';
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button class="text-primary hover:text-accent font-medium text-sm transition-colors">
                        Lihat semua aktivitas <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/3 to-transparent"></div>
        <div class="relative">
            <h3 class="text-lg font-semibold bg-gradient-to-r from-gray-900 to-indigo-900 bg-clip-text text-transparent mb-6">
                Fitur Lain
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <button class="flex flex-col items-center p-4 bg-gray-50 hover:from-primary hover:to-blue-600 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md hover:scale-105 border border-gray-200 hover:bg-gradient-to-br">
                    <i class="fas fa-tachometer-alt text-2xl text-primary group-hover:text-white mb-2 transition-colors"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">Speed Test</span>
                </button>
                
                <button class="flex flex-col items-center p-4 bg-gray-50 hover:from-green-500 hover:to-green-600 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md hover:scale-105 border border-gray-200 hover:bg-gradient-to-br">
                    <i class="fas fa-credit-card text-2xl text-green-600 group-hover:text-white mb-2 transition-colors"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">
                        <?= $current_bill ? 'Bayar Tagihan' : 'Riwayat Tagihan' ?>
                    </span>
                </button>
                
                <button class="flex flex-col items-center p-4 bg-gray-50 hover:from-orange-500 hover:to-orange-600 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md hover:scale-105 border border-gray-200 hover:bg-gradient-to-br">
                    <i class="fas fa-headset text-2xl text-orange-600 group-hover:text-white mb-2 transition-colors"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">Hubungi Support</span>
                </button>
                
                <button class="flex flex-col items-center p-4 bg-gray-50 hover:from-purple-500 hover:to-purple-600 hover:text-white rounded-lg transition-all duration-300 group shadow-sm hover:shadow-md hover:scale-105 border border-gray-200 hover:bg-gradient-to-br">
                    <i class="fas fa-download text-2xl text-purple-600 group-hover:text-white mb-2 transition-colors"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">Download Tagihan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Package Upgrade Modal -->
<div id="upgradeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-blue-900 bg-clip-text text-transparent">
                        Upgrade Paket Internet
                    </h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <p class="text-gray-600 mt-2">Pilih paket yang sesuai dengan kebutuhan Anda</p>
            </div>
            
            <div class="p-6">
                <div id="packagesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Packages will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}

/* Enhanced hover effects */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Usage Chart
    const usageCtx = document.getElementById('usageChart');
    if (usageCtx) {
        const usageChart = new Chart(usageCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: [<?php 
                    if ($last_30_days_usage && count($last_30_days_usage) > 0) {
                        $labels = array_map(function($item) {
                            return date('j', strtotime($item['created_at']));
                        }, $last_30_days_usage);
                        echo implode(',', $labels);
                    } else {
                        echo '1,5,10,15,20,25,30';
                    }
                ?>],
                datasets: [{
                    label: 'Penggunaan Harian (GB)',
                    data: [<?php 
                        if ($last_30_days_usage && count($last_30_days_usage) > 0) {
                            echo implode(',', array_column($last_30_days_usage, 'data_used_gb'));
                        } else {
                            echo '12,19,15,25,22,18,28';
                        }
                    ?>],
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5
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
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6B7280'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6B7280'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }

    // Speed Chart
    const speedCtx = document.getElementById('speedChart');
    if (speedCtx) {
        const speedChart = new Chart(speedCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: [<?php 
                    if ($speed_history && count($speed_history) > 0) {
                        $labels = array_map(function($item) {
                            return date('D', strtotime($item['tested_at']));
                        }, array_slice($speed_history, -7));
                        echo '"' . implode('","', $labels) . '"';
                    } else {
                        echo '"Sen","Sel","Rab","Kam","Jum","Sab","Min"';
                    }
                ?>],
                datasets: [{
                    label: 'Kecepatan Rata-rata (Mbps)',
                    data: [<?php 
                        if ($speed_history && count($speed_history) > 0) {
                            $lastSeven = array_slice($speed_history, -7);
                            echo implode(',', array_column($lastSeven, 'download_speed'));
                        } else {
                            echo '95,98,92,99,96,94,97';
                        }
                    ?>],
                    backgroundColor: '#10B981',
                    borderColor: '#059669',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false
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
                    y: {
                        beginAtZero: true,
                        max: 110,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6B7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6B7280'
                        }
                    }
                }
            }
        });
    }

    // Package upgrade functionality
    const upgradeBtn = document.getElementById('upgradePackageBtn');
    const modal = document.getElementById('upgradeModal');
    const closeModal = document.getElementById('closeModal');
    const packagesContainer = document.getElementById('packagesContainer');

    if (upgradeBtn) {
        upgradeBtn.addEventListener('click', function() {
            loadAvailablePackages();
            modal.classList.remove('hidden');
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
    }

    // Close modal when clicking outside
    modal?.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    function loadAvailablePackages() {
        fetch('<?= base_url('packages/available') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    displayPackages(data.packages, data.current_package_id);
                } else {
                    console.error('Error loading packages:', data.message);
                    packagesContainer.innerHTML = '<div class="text-center p-8"><p class="text-gray-500">Gagal memuat paket. Silakan coba lagi.</p></div>';
                }
            })
            .catch(error => {
                console.error('Error loading packages:', error);
                packagesContainer.innerHTML = '<div class="text-center p-8"><p class="text-gray-500">Terjadi kesalahan saat memuat paket.</p></div>';
            });
    }

    function displayPackages(packages, currentPackageId) {
        let html = '';
        
        packages.forEach(package => {
            const isPopular = package.popular == 1;
            const isCurrent = package.id == currentPackageId;
            const speedDisplay = package.speed >= 1000 ? `${package.speed/1000} Gbps` : `${package.speed} Mbps`;
            const priceFormatted = new Intl.NumberFormat('id-ID').format(package.price);
            
            html += `
                <div class="relative bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 ${isPopular ? 'ring-2 ring-blue-500' : ''} ${isCurrent ? 'ring-2 ring-green-500' : ''}">
                    ${isPopular ? '<div class="absolute -top-3 left-1/2 transform -translate-x-1/2"><span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-medium">POPULER</span></div>' : ''}
                    ${isCurrent ? '<div class="absolute -top-3 right-4"><span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">PAKET AKTIF</span></div>' : ''}
                    
                    <div class="text-center mb-6">
                        <div class="h-16 w-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-${package.speed >= 1000 ? 'bolt' : package.speed >= 250 ? 'rocket' : package.speed >= 100 ? 'wifi' : 'signal'} text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">${package.name}</h4>
                        <div class="text-3xl font-bold text-blue-600 mb-1">${speedDisplay}</div>
                        <div class="text-2xl font-bold text-gray-900">Rp ${priceFormatted}</div>
                        <div class="text-sm text-gray-500">per bulan</div>
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-gray-600 text-sm text-center">${package.description}</p>
                    </div>
                    
                    ${isCurrent ? 
                        '<button class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-lg font-medium cursor-not-allowed"><i class="fas fa-check mr-2"></i>Paket Saat Ini</button>' :
                        `<button onclick="upgradeToPackage(${package.id}, '${package.name}')" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg"><i class="fas fa-arrow-up mr-2"></i>Upgrade ke Paket Ini</button>`
                    }
                </div>
            `;
        });
        
        packagesContainer.innerHTML = html;
    }

    window.upgradeToPackage = function(packageId, packageName) {
        if (confirm(`Apakah Anda yakin ingin upgrade ke paket ${packageName}?`)) {
            const formData = new FormData();
            formData.append('package_id', packageId);
            
            // Show loading state
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            button.disabled = true;
            
            fetch('<?= base_url('packages/upgrade') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    modal.classList.add('hidden');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error upgrading package:', error);
                alert('Terjadi kesalahan saat upgrade paket');
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    };
});
</script>
<?= $this->endSection() ?>