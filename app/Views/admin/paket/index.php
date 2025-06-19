<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Paket Internet
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Manajemen Paket Internet
<?= $this->endSection() ?>

<?= $this->section('page_subtitle') ?>
Kelola paket internet yang tersedia untuk pelanggan
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<div class="flex items-center space-x-3">
    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
        <i class="fas fa-filter mr-2"></i>
        Filter
    </button>
    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
        <i class="fas fa-download mr-2"></i>
        Export
    </button>
    <a href="/admin/paket/new" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
        <i class="fas fa-plus mr-2"></i>
        Tambah Paket
    </a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700"><?= session()->getFlashdata('success') ?></p>
        </div>
    </div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-box text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Paket</p>
                <p class="text-2xl font-bold text-gray-900"><?= count($packages) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Paket Aktif</p>
                <p class="text-2xl font-bold text-gray-900"><?= count(array_filter($packages, fn($p) => ($p['status'] ?? 'active') === 'active')) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="fas fa-star text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Paket Popular</p>
                <p class="text-2xl font-bold text-gray-900"><?= count(array_filter($packages, fn($p) => $p['is_popular'] ?? false)) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Pelanggan</p>
                <p class="text-2xl font-bold text-gray-900"><?= array_sum(array_column($packages, 'subscribers')) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="col-span-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari nama paket..." id="searchInput">
            </div>
        </div>
        <div>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="sortBy">
                <option value="name">Urutkan: Nama</option>
                <option value="price">Urutkan: Harga</option>
                <option value="speed">Urutkan: Kecepatan</option>
                <option value="created_at">Urutkan: Terbaru</option>
            </select>
        </div>
        <div>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Nonaktif</option>
            </select>
        </div>
    </div>
</div>

<!-- Packages Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="packagesGrid">
    <?php foreach ($packages as $package): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 relative" data-package-id="<?= $package['id'] ?>">
            <!-- Popular Badge -->
            <?php if ($package['is_popular'] ?? false): ?>
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-star mr-1"></i>Popular
                    </span>
                </div>
            <?php endif; ?>
            
            <div class="p-6">
                <!-- Package Header -->
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wifi text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?= esc($package['name']) ?></h3>
                    <p class="text-gray-600 text-sm"><?= esc(substr($package['description'], 0, 80)) ?>...</p>
                </div>

                <!-- Package Speed -->
                <div class="text-center mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <?= esc($package['speed']) ?> Mbps
                    </span>
                </div>

                <!-- Package Price -->
                <div class="text-center mb-6">
                    <div class="text-3xl font-bold text-gray-900 mb-1">
                        Rp <?= number_format($package['price'], 0, ',', '.') ?>
                    </div>
                    <div class="text-sm text-gray-500">/bulan</div>
                </div>

                <!-- Package Stats -->
                <div class="grid grid-cols-3 gap-4 mb-6 py-4 border-t border-gray-100">
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Views</div>
                        <div class="font-semibold text-gray-900"><?= $package['views'] ?? 0 ?></div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Subscribers</div>
                        <div class="font-semibold text-gray-900"><?= $package['subscribers'] ?? 0 ?></div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Status</div>
                        <?php $status = $package['status'] ?? 'active'; ?>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <a href="/admin/paket/view/<?= $package['id'] ?>" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-eye mr-2"></i>Detail
                    </a>
                    <a href="/admin/paket/edit/<?= $package['id'] ?>" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <div class="relative">
                        <button type="button" class="inline-flex items-center justify-center p-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors" onclick="toggleDropdown(<?= $package['id'] ?>)">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div id="dropdown-<?= $package['id'] ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                            <div class="py-1">
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="togglePopular(<?= $package['id'] ?>)">
                                    <i class="fas fa-star mr-2"></i>Toggle Popular
                                </button>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="duplicatePackage(<?= $package['id'] ?>)">
                                    <i class="fas fa-copy mr-2"></i>Duplikat
                                </button>
                                <hr class="my-1">
                                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" onclick="deletePackage(<?= $package['id'] ?>)">
                                    <i class="fas fa-trash mr-2"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (empty($packages)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-box text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada paket</h3>
        <p class="text-gray-600 mb-6">Klik tombol "Tambah Paket" untuk membuat paket internet pertama Anda.</p>
        <a href="/admin/paket/new" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg text-base font-medium text-white hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Paket Pertama
        </a>
    </div>
<?php endif; ?>

<script>
function toggleDropdown(id) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
        if (dropdown.id !== `dropdown-${id}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById(`dropdown-${id}`);
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('[onclick^="toggleDropdown"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

function togglePopular(id) {
    if (confirm('Toggle status popular untuk paket ini?')) {
        console.log('Toggle popular for package:', id);
    }
}

function duplicatePackage(id) {
    if (confirm('Duplikat paket ini?')) {
        console.log('Duplicate package:', id);
    }
}

function deletePackage(id) {
    if (confirm('Yakin ingin menghapus paket ini? Tindakan ini tidak dapat dibatalkan.')) {
        console.log('Delete package:', id);
    }
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const cards = document.querySelectorAll('[data-package-id]');
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
<?= $this->endSection() ?>
