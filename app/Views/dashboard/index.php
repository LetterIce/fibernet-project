<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard Overview
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Welcome Section -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, <?= esc(session()->get('user_name') ?? 'User') ?>!</h2>
    <p class="text-gray-600">Berikut adalah ringkasan aktivitas dan penggunaan internet Anda.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
    <!-- Current Usage -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Penggunaan Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-900 mb-1"><?= number_format($current_usage ?: 456.7, 1) ?> GB</p>
                <p class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-arrow-up mr-1 text-xs"></i>
                    <span><?= $usage_percentage > 0 ? '+' : '' ?><?= abs($usage_percentage) ?: 12 ?>% dari bulan lalu</span>
                </p>
            </div>
            <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-4">
                <i class="fas fa-download text-primary text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Speed Test -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Kecepatan Terakhir</p>
                <p class="text-2xl font-bold text-gray-900 mb-1"><?= $latest_speed ? number_format($latest_speed['download_speed'], 1) : '98.5' ?> Mbps</p>
                <p class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-check-circle mr-1 text-xs"></i>
                    <span>Stabil</span>
                </p>
            </div>
            <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-4">
                <i class="fas fa-tachometer-alt text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Current Bill -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Tagihan Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-900 mb-1">Rp <?= $current_bill ? number_format($current_bill['amount'], 0, ',', '.') : '299.000' ?></p>
                <p class="text-sm text-orange-600 flex items-center">
                    <i class="fas fa-clock mr-1 text-xs"></i>
                    <span>
                        <?php if ($current_bill): ?>
                            <?php 
                                $dueDate = new DateTime($current_bill['due_date']);
                                $today = new DateTime();
                                $interval = $today->diff($dueDate);
                                $daysUntilDue = $interval->invert ? -$interval->days : $interval->days;
                            ?>
                            <?= $daysUntilDue > 0 ? "Jatuh tempo {$daysUntilDue} hari" : 'Jatuh tempo 5 hari' ?>
                        <?php else: ?>
                            Jatuh tempo 5 hari
                        <?php endif; ?>
                    </span>
                </p>
            </div>
            <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-4">
                <i class="fas fa-credit-card text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Connection Status -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Status Koneksi</p>
                <p class="text-2xl font-bold text-green-600 mb-1"><?= $connection_status['status'] ?? 'Online' ?></p>
                <p class="text-sm text-gray-500 flex items-center">
                    <i class="fas fa-circle text-green-500 mr-1 text-xs"></i>
                    <span>Uptime <?= $connection_status['uptime'] ?? '99.9%' ?></span>
                </p>
            </div>
            <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 ml-4">
                <i class="fas fa-wifi text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
    <!-- Usage Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Penggunaan Data 30 Hari Terakhir</h3>
            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">GB</span>
        </div>
        <div class="chart-container">
            <canvas id="usageChart"></canvas>
        </div>
    </div>

    <!-- Speed Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Kecepatan Internet</h3>
            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">Mbps</span>
        </div>
        <div class="chart-container">
            <canvas id="speedChart"></canvas>
        </div>
    </div>
</div>

<!-- Package Info & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Current Package -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Paket Saat Ini</h3>
        <div class="text-center">
            <div class="h-16 w-16 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-rocket text-white text-2xl"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-1">FiberNet Premium</h4>
            <p class="text-primary font-semibold text-lg mb-1">100 Mbps</p>
            <p class="text-sm text-gray-600 mb-4">Unlimited Data</p>
            <button class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-accent transition-colors duration-200 font-medium">
                Upgrade Paket
            </button>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Aktivitas Terbaru</h3>
        <div class="space-y-4">
            <?php if ($recent_activities && count($recent_activities) > 0): ?>
                <?php foreach (array_slice($recent_activities, 0, 4) as $activity): ?>
                    <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-<?= $activity['icon'] ?? 'info-circle' ?> text-primary text-sm"></i>
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
        
        <div class="mt-4 pt-4 border-t border-gray-100">
            <button class="text-primary hover:text-accent font-medium text-sm transition-colors">
                Lihat semua aktivitas <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Aksi Cepat</h3>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <button class="flex flex-col items-center p-4 bg-gray-50 hover:bg-primary hover:text-white rounded-lg transition-all duration-200 group">
            <i class="fas fa-tachometer-alt text-2xl text-primary group-hover:text-white mb-2 transition-colors"></i>
            <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">Speed Test</span>
        </button>
        
        <button class="flex flex-col items-center p-4 bg-gray-50 hover:bg-green-600 hover:text-white rounded-lg transition-all duration-200 group">
            <i class="fas fa-credit-card text-2xl text-green-600 group-hover:text-white mb-2 transition-colors"></i>
            <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">Bayar Tagihan</span>
        </button>
        
        <button class="flex flex-col items-center p-4 bg-gray-50 hover:bg-orange-600 hover:text-white rounded-lg transition-all duration-200 group">
            <i class="fas fa-headset text-2xl text-orange-600 group-hover:text-white mb-2 transition-colors"></i>
            <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">Hubungi Support</span>
        </button>
        
        <button class="flex flex-col items-center p-4 bg-gray-50 hover:bg-purple-600 hover:text-white rounded-lg transition-all duration-200 group">
            <i class="fas fa-download text-2xl text-purple-600 group-hover:text-white mb-2 transition-colors"></i>
            <span class="text-sm font-medium text-gray-700 group-hover:text-white transition-colors">Download Tagihan</span>
        </button>
    </div>
</div>

<style>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
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
});
</script>
<?= $this->endSection() ?>