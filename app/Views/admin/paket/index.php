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
    <a href="/admin/paket/export" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors" id="exportBtn">
        <i class="fas fa-download mr-2"></i>
        Export
    </a>
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
                <p class="text-2xl font-bold text-gray-900"><?= count($packages) ?></p>
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
                <p class="text-2xl font-bold text-gray-900"><?= count(array_filter($packages, fn($p) => $p['popular'] === 'true')) ?></p>
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
                <p class="text-2xl font-bold text-gray-900"><?= $total_users ?? 0 ?></p>
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
            <?php if ($package['popular'] === 'true'): ?>
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
                        <div class="text-sm text-gray-500">Created</div>
                        <div class="font-semibold text-gray-900 text-xs">
                            <?= $package['created_at'] ? date('d/m/Y', strtotime($package['created_at'])) : '-' ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Updated</div>
                        <div class="font-semibold text-gray-900 text-xs">
                            <?= $package['updated_at'] ? date('d/m/Y', strtotime($package['updated_at'])) : '-' ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-500">Status</div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
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
                        <div id="dropdown-<?= $package['id'] ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
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
        fetch(`/admin/paket/toggle-popular/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to show updated status
            } else {
                alert('Gagal mengubah status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status');
        });
    }
}

function duplicatePackage(id) {
    if (confirm('Duplikat paket ini?')) {
        // Implement duplication logic
        console.log('Duplicate package:', id);
    }
}

function deletePackage(id) {
    if (confirm('Yakin ingin menghapus paket ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`/admin/paket/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message and reload
                alert(data.message);
                location.reload();
            } else {
                alert('Gagal menghapus paket: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus paket');
        });
    }
}

// Global filter and sort functionality
let allPackages = [];

// Store original package data
document.addEventListener('DOMContentLoaded', function() {
    const packageCards = document.querySelectorAll('[data-package-id]');
    packageCards.forEach(card => {
        const packageData = {
            element: card,
            id: card.getAttribute('data-package-id'),
            name: card.querySelector('h3').textContent.toLowerCase(),
            price: parseInt(card.querySelector('.text-3xl').textContent.replace(/[^0-9]/g, '')),
            speed: parseInt(card.querySelector('.bg-blue-100.text-blue-800').textContent.replace(/[^0-9]/g, '')),
            popular: card.querySelector('.bg-yellow-100') ? true : false,
            status: 'active', // Assuming all packages are active since there's no inactive status in the data
            created_at: card.querySelector('.text-xs').textContent
        };
        allPackages.push(packageData);
    });
});

function applyFilters() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const sortBy = document.getElementById('sortBy').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    let filteredPackages = [...allPackages];
    
    // Apply search filter
    if (searchTerm) {
        filteredPackages = filteredPackages.filter(pkg => 
            pkg.name.includes(searchTerm)
        );
    }
    
    // Apply status filter
    if (statusFilter) {
        filteredPackages = filteredPackages.filter(pkg => 
            pkg.status === statusFilter
        );
    }
    
    // Apply sorting
    filteredPackages.sort((a, b) => {
        switch (sortBy) {
            case 'name':
                return a.name.localeCompare(b.name);
            case 'price':
                return a.price - b.price;
            case 'speed':
                return b.speed - a.speed; // Descending for speed
            case 'created_at':
                return new Date(b.created_at) - new Date(a.created_at); // Newest first
            default:
                return 0;
        }
    });
    
    // Hide all packages first
    allPackages.forEach(pkg => {
        pkg.element.style.display = 'none';
    });
    
    // Show filtered packages
    const packagesGrid = document.getElementById('packagesGrid');
    filteredPackages.forEach((pkg, index) => {
        pkg.element.style.display = '';
        // Reorder elements
        packagesGrid.appendChild(pkg.element);
    });
    
    // Show/hide empty state
    const emptyState = document.querySelector('.bg-white.rounded-lg.shadow-sm.border.border-gray-200.p-12.text-center');
    if (filteredPackages.length === 0 && !emptyState) {
        showEmptyFilterState();
    } else if (filteredPackages.length > 0 && document.getElementById('empty-filter-state')) {
        document.getElementById('empty-filter-state').remove();
    }
}

function showEmptyFilterState() {
    const packagesGrid = document.getElementById('packagesGrid');
    const emptyDiv = document.createElement('div');
    emptyDiv.id = 'empty-filter-state';
    emptyDiv.className = 'col-span-full bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center';
    emptyDiv.innerHTML = `
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-search text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada paket ditemukan</h3>
        <p class="text-gray-600 mb-6">Coba ubah kriteria pencarian atau filter Anda.</p>
        <button onclick="clearFilters()" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg text-base font-medium text-white hover:bg-blue-700 transition-colors">
            <i class="fas fa-times mr-2"></i>Reset Filter
        </button>
    `;
    packagesGrid.parentNode.insertBefore(emptyDiv, packagesGrid.nextSibling);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('sortBy').value = 'name';
    document.getElementById('statusFilter').value = '';
    applyFilters();
}

// Event listeners
document.getElementById('searchInput').addEventListener('input', applyFilters);
document.getElementById('sortBy').addEventListener('change', applyFilters);
document.getElementById('statusFilter').addEventListener('change', applyFilters);

// Export functionality
document.getElementById('exportBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Show loading state
    const originalText = this.innerHTML;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Exporting...';
    this.style.pointerEvents = 'none';
    
    // Create a temporary link and trigger download
    const link = document.createElement('a');
    link.href = '/admin/paket/export';
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Reset button state after a delay
    setTimeout(() => {
        this.innerHTML = originalText;
        this.style.pointerEvents = 'auto';
    }, 2000);
});
</script>

<style>
/* Ensure proper z-index layering */
.admin-header {
    z-index: 1000 !important;
}

.admin-sidebar {
    z-index: 999 !important;
}

.main-content {
    z-index: 1 !important;
}

/* Fix content scrolling under header */
body {
    position: relative;
}
</style>

<?= $this->endSection() ?>
