<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
                <p class="text-3xl font-bold text-gray-900"><?= $total_users ?? 0 ?></p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>Pengguna aktif
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Paket Internet</p>
                <p class="text-3xl font-bold text-gray-900"><?= $total_packages ?? 0 ?></p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-check mr-1"></i>Paket aktif
                </p>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-emerald-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-900"><?= $total_orders ?? 0 ?></p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+0% minggu ini
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                <p class="text-3xl font-bold text-gray-900">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>+0% bulan ini
                </p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-dollar-sign text-amber-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
    <div class="lg:col-span-3 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Statistik Pendaftaran Pelanggan</h3>
        </div>
        <div class="p-6">
            <div class="h-72">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Paket Terpopuler</h3>
        </div>
        <div class="p-6">
            <div class="h-72 flex items-center justify-center">
                <canvas id="packagePopularityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Pelanggan Terbaru</h3>
            <a href="/admin/users" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-hidden">
            <?php if (!empty($latest_users)): ?>
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($latest_users as $user): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                </div>
                                <span class="text-sm font-medium text-gray-900"><?= esc($user['name']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= esc($user['email']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="p-6 text-center text-gray-500">
                <i class="fas fa-users text-4xl mb-4"></i>
                <p>Belum ada pelanggan yang terdaftar</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terkini</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                Live
            </span>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <?php if (!empty($latest_activities) && is_array($latest_activities)): ?>
                    <?php foreach ($latest_activities as $activity): ?>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 <?php 
                            switch($activity['activity_type']) {
                                case 'registration': echo 'bg-green-100'; break;
                                case 'package': echo 'bg-blue-100'; break;
                                case 'payment': echo 'bg-yellow-100'; break;
                                case 'system': echo 'bg-gray-100'; break;
                                case 'maintenance': echo 'bg-orange-100'; break;
                                default: echo 'bg-gray-100';
                            }
                        ?>">
                            <i class="fas fa-<?= esc($activity['icon']) ?> text-<?php 
                                switch($activity['activity_type']) {
                                    case 'registration': echo 'green'; break;
                                    case 'package': echo 'blue'; break;
                                    case 'payment': echo 'yellow'; break;
                                    case 'system': echo 'gray'; break;
                                    case 'maintenance': echo 'orange'; break;
                                    default: echo 'gray';
                                }
                            ?>-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 capitalize"><?= esc(str_replace('_', ' ', $activity['activity_type'])) ?></p>
                            <p class="text-sm text-gray-600 break-words"><?= esc($activity['description']) ?></p>
                            <p class="text-xs text-gray-500 mt-1"><?= date('d M Y H:i', strtotime($activity['created_at'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-info-circle text-4xl mb-4 text-gray-400"></i>
                    <p class="text-lg font-medium">Belum ada aktivitas terkini</p>
                    <p class="text-sm mt-1">Aktivitas akan muncul di sini ketika ada yang terjadi</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Check if Chart.js is loaded
if (typeof Chart === 'undefined') {
    console.error('Chart.js is not loaded');
} else {
    // User Registration Chart with safety checks
    const userCtx = document.getElementById('userRegistrationChart');
    if (userCtx) {
        const userRegistrationData = <?= json_encode($user_registration_data ?? ['labels' => [], 'data' => []]) ?>;
        
        new Chart(userCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: userRegistrationData.labels || [],
                datasets: [{
                    label: 'Pendaftaran Pelanggan',
                    data: userRegistrationData.data || [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
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
                            color: 'rgba(0,0,0,0.05)',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: '#6b7280',
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    }
                }
            }
        });
    }

    // Package Popularity Chart with safety checks
    const packageCtx = document.getElementById('packagePopularityChart');
    if (packageCtx) {
        const packagePopularityData = <?= json_encode($package_popularity_data ?? ['labels' => ['No Data'], 'data' => [1], 'colors' => ['#9ca3af']]) ?>;
        
        new Chart(packageCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: packagePopularityData.labels || ['No Data'],
                datasets: [{
                    data: packagePopularityData.data || [1],
                    backgroundColor: packagePopularityData.colors || ['#9ca3af'],
                    borderWidth: 0,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            color: '#6b7280',
                            font: {
                                size: 14
                            },
                            boxWidth: 15
                        }
                    }
                }
            }
        });
    }
}
</script>
<?= $this->endSection() ?>
