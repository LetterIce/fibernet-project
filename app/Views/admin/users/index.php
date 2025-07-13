<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Pelanggan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Manajemen Pelanggan
<?= $this->endSection() ?>

<?= $this->section('page_subtitle') ?>
Kelola data pelanggan FiberNet
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<div class="flex items-center space-x-3">
    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
        <i class="fas fa-filter mr-2"></i>
        Filter
    </button>
    <a href="/admin/users/export" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors" id="exportBtn">
        <i class="fas fa-download mr-2"></i>
        Export
    </a>
    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors" onclick="showImportModal()">
        <i class="fas fa-upload mr-2"></i>
        Import
    </button>
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
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Pelanggan</p>
                <p class="text-2xl font-bold text-gray-900"><?= $total_users ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-user-check text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">User Aktif</p>
                <p class="text-2xl font-bold text-gray-900"><?= $active_users ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-wifi text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Berlangganan</p>
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
                <p class="text-sm text-gray-600">Baru Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-900"><?= $new_users_this_month ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="col-span-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari nama atau email..." id="searchInput">
            </div>
        </div>
        <div>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="roleFilter">
                <option value="">Semua Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="packageFilter">
                <option value="">Semua Paket</option>
                <option value="subscribed">Berlangganan</option>
                <option value="unsubscribed">Belum Berlangganan</option>
            </select>
        </div>
        <div>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="sortBy">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
                <option value="name">Nama A-Z</option>
                <option value="email">Email A-Z</option>
            </select>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="usersTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Option</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
                <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-50" data-user-id="<?= $user['id'] ?>">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                        <span class="text-white font-medium text-sm"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?= esc($user['name']) ?></div>
                                    <div class="text-sm text-gray-500"><?= esc($user['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $user['role'] === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($user['package_name']): ?>
                                <div class="text-sm text-gray-900"><?= esc($user['package_name']) ?></div>
                                <div class="text-sm text-gray-500"><?= $user['speed'] ?> Mbps - Rp <?= number_format($user['package_price'], 0, ',', '.') ?></div>
                            <?php else: ?>
                                <span class="text-sm text-gray-400">Belum berlangganan</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="/admin/users/view/<?= $user['id'] ?>" class="text-blue-600 hover:text-blue-900 transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($user['role'] !== 'admin'): ?>
                                    <button onclick="deleteUser(<?= $user['id'] ?>)" class="text-red-600 hover:text-red-900 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                                <div class="relative">
                                    <button type="button" class="text-gray-600 hover:text-gray-900 transition-colors" onclick="toggleUserDropdown(<?= $user['id'] ?>)">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="user-dropdown-<?= $user['id'] ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                        <div class="py-1">
                                            <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="showPackageModal(<?= $user['id'] ?>)">
                                                <i class="fas fa-wifi mr-2"></i>Ubah Paket
                                            </button>
                                            <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="sendEmail(<?= $user['id'] ?>)">
                                                <i class="fas fa-envelope mr-2"></i>Kirim Email
                                            </button>
                                            <a href="/admin/users/view/<?= $user['id'] ?>" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-eye mr-2"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($users)): ?>
        <div class="p-12 text-center">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-users text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada pelanggan</h3>
            <p class="text-gray-600">Pelanggan akan muncul di sini setelah melakukan registrasi.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Package Modal -->
<div id="packageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Paket Pelanggan</h3>
            <form id="packageForm">
                <input type="hidden" id="selectedUserId" name="user_id">
                <div id="packageModalContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closePackageModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Dropdown functions
function toggleUserDropdown(id) {
    document.querySelectorAll('[id^="user-dropdown-"]').forEach(dropdown => {
        if (dropdown.id !== `user-dropdown-${id}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    const dropdown = document.getElementById(`user-dropdown-${id}`);
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('[onclick^="toggleUserDropdown"]')) {
        document.querySelectorAll('[id^="user-dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

// Delete user function
function deleteUser(id) {
    if (confirm('Yakin ingin menghapus pelanggan ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`/admin/users/delete/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Gagal menghapus pelanggan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus pelanggan');
        });
    }
}

// Package modal functions
function showPackageModal(userId) {
    document.getElementById('selectedUserId').value = userId;
    
    // Load package modal content
    fetch(`/admin/users/change-package/${userId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('packageModalContent').innerHTML = data.html;
            document.getElementById('packageModal').classList.remove('hidden');
        } else {
            alert('Gagal memuat data: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memuat data');
    });
}

function closePackageModal() {
    document.getElementById('packageModal').classList.add('hidden');
}

// Handle package change form
document.getElementById('packageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('selectedUserId').value;
    // Get the package ID from the dynamically loaded modal content
    const packageSelectModal = document.getElementById('packageSelectModal');
    
    if (!packageSelectModal) {
        alert('Error: Modal content not loaded properly');
        return;
    }
    
    const packageId = packageSelectModal.value;
    
    const formData = new FormData();
    formData.append('package_id', packageId);
    
    // Add loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    submitBtn.disabled = true;
    
    fetch(`/admin/dashboard/update-user-package/${userId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closePackageModal();
            location.reload();
        } else {
            alert('Gagal mengubah paket: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah paket');
    })
    .finally(() => {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Export functionality - updated for regular export only
document.getElementById('exportBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    createDownloadProgress();
    
    const originalText = this.innerHTML;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Exporting...';
    this.style.pointerEvents = 'none';
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '/admin/users/export';
    form.style.display = 'none';
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    // Reset button
    setTimeout(() => {
        this.innerHTML = originalText;
        this.style.pointerEvents = 'auto';
    }, 2000);
});

// Enhanced search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTableBody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isVisible = text.includes(searchTerm);
        row.style.display = isVisible ? '' : 'none';
        if (isVisible) visibleCount++;
    });
    
    // Update visible count if needed
    console.log(`Showing ${visibleCount} of ${rows.length} users`);
});

// Role filter functionality
document.getElementById('roleFilter').addEventListener('change', function() {
    const selectedRole = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTableBody tr');
    
    rows.forEach(row => {
        if (selectedRole === '') {
            row.style.display = '';
        } else {
            const roleCell = row.querySelector('td:nth-child(2)');
            const roleText = roleCell ? roleCell.textContent.toLowerCase() : '';
            row.style.display = roleText.includes(selectedRole) ? '' : 'none';
        }
    });
});

// Package filter functionality
document.getElementById('packageFilter').addEventListener('change', function() {
    const selectedFilter = this.value;
    const rows = document.querySelectorAll('#usersTableBody tr');
    
    rows.forEach(row => {
        const packageCell = row.querySelector('td:nth-child(3)');
        const packageText = packageCell ? packageCell.textContent.trim() : '';
        
        let showRow = true;
        
        if (selectedFilter === 'subscribed') {
            showRow = !packageText.includes('Belum berlangganan');
        } else if (selectedFilter === 'unsubscribed') {
            showRow = packageText.includes('Belum berlangganan');
        }
        
        row.style.display = showRow ? '' : 'none';
    });
});

// Add notification for successful export
function showExportNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Add download progress indicator
function createDownloadProgress() {
    const progress = document.createElement('div');
    progress.id = 'downloadProgress';
    progress.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    progress.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-download mr-2"></i>
            <span>Mempersiapkan file CSV...</span>
        </div>
    `;
    
    document.body.appendChild(progress);
    
    // Update progress message
    setTimeout(() => {
        progress.querySelector('span').textContent = 'Mengunduh file...';
    }, 1000);
    
    // Remove progress after 3 seconds
    setTimeout(() => {
        progress.remove();
        showExportNotification('File CSV berhasil diunduh!');
    }, 3000);
}
</script>
<?= $this->endSection() ?>
