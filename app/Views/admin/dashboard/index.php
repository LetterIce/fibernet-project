<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Dashboard Admin
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard Admin
<?= $this->endSection() ?>

<?= $this->section('page_subtitle') ?>
Selamat datang di panel admin FiberNet
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Pengguna</p>
                <p class="text-2xl font-bold text-gray-900"><?= $total_users ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-box text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Paket</p>
                <p class="text-2xl font-bold text-gray-900"><?= $total_packages ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-wifi text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Pelanggan Aktif</p>
                <p class="text-2xl font-bold text-gray-900"><?= $subscribers ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="fas fa-user-plus text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Pengguna Baru</p>
                <p class="text-2xl font-bold text-gray-900"><?= $new_users_this_month ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Statistik Pendaftaran Pelanggan</h3>
        </div>
        <div class="p-6">
            <div class="h-64">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Paket Terpopuler</h3>
        </div>
        <div class="p-6">
            <div class="h-64 flex items-center justify-center">
                <canvas id="packagePopularityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Pelanggan Terbaru</h2>
            <a href="/admin/users" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($recent_users)): ?>
                        <?php foreach ($recent_users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                        <span class="text-white font-medium text-xs"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900"><?= esc($user['name']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= esc($user['email']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $user['package_name'] ?? 'Belum berlangganan' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-4 text-gray-400"></i>
                                <p>Belum ada pelanggan yang terdaftar</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terkini</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                Live
            </span>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                <?php if (!empty($recent_activities) && is_array($recent_activities)): ?>
                    <?php foreach (array_slice($recent_activities, 0, 8) as $activity): ?>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 <?php 
                            $activityType = $activity['activity_type'] ?? 'system';
                            switch($activityType) {
                                case 'registration': echo 'bg-green-100'; break;
                                case 'package': echo 'bg-blue-100'; break;
                                case 'payment': echo 'bg-yellow-100'; break;
                                case 'system': echo 'bg-gray-100'; break;
                                case 'maintenance': echo 'bg-orange-100'; break;
                                default: echo 'bg-gray-100';
                            }
                        ?>">
                            <i class="fas fa-<?= esc($activity['icon'] ?? 'info') ?> text-<?php 
                                switch($activityType) {
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
                            <p class="text-sm font-medium text-gray-900 capitalize"><?= esc(str_replace('_', ' ', $activityType)) ?></p>
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
    // User Registration Chart
    const userCtx = document.getElementById('userRegistrationChart');
    if (userCtx) {
        const userRegistrationData = <?= json_encode($user_registration_data ?? ['labels' => [], 'data' => []]) ?>;
        
        new Chart(userCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: userRegistrationData.labels || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Pendaftaran Pelanggan',
                    data: userRegistrationData.data || [0, 0, 0, 0, 0, 0],
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

    // Package Popularity Chart
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
                                size: 12
                            },
                            boxWidth: 12
                        }
                    }
                }
            }
        });
    }
}

// Debug information
console.log('Dashboard loaded with data:', {
    totalUsers: <?= $total_users ?>,
    totalPackages: <?= $total_packages ?>,
    subscribers: <?= $subscribers ?>,
    newUsersThisMonth: <?= $new_users_this_month ?>,
    recentUsersCount: <?= count($recent_users ?? []) ?>,
    activitiesCount: <?= count($recent_activities ?? []) ?>
});
</script>
<?= $this->endSection() ?>
