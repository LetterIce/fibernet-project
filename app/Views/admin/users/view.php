<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Detail Pelanggan - <?= esc($user['name']) ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Detail Pelanggan
<?= $this->endSection() ?>

<?= $this->section('page_subtitle') ?>
Informasi lengkap pelanggan <?= esc($user['name']) ?>
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<div class="flex items-center space-x-3">
    <a href="/admin/users" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>
        Kembali
    </a>
    <?php if ($user['role'] !== 'admin'): ?>
        <button type="button" onclick="deleteUser(<?= $user['id'] ?>)" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-trash mr-2"></i>
            Hapus
        </button>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- User Info Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="h-20 w-20 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <span class="text-white font-bold text-2xl"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900"><?= esc($user['name']) ?></h2>
                    <p class="text-gray-600"><?= esc($user['email']) ?></p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $user['role'] === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                            <?= ucfirst($user['role']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User ID</dt>
                            <dd class="text-sm text-gray-900">#<?= str_pad($user['id'], 6, '0', STR_PAD_LEFT) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Daftar</dt>
                            <dd class="text-sm text-gray-900"><?= date('d F Y, H:i', strtotime($user['created_at'])) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terakhir Update</dt>
                            <dd class="text-sm text-gray-900"><?= date('d F Y, H:i', strtotime($user['updated_at'])) ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lama Berlangganan</dt>
                            <dd class="text-sm text-gray-900">
                                <?php 
                                $diff = date_diff(date_create($user['created_at']), date_create('now'));
                                echo $diff->m . ' bulan ' . $diff->d . ' hari';
                                ?>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Login</dt>
                            <dd class="text-sm text-gray-900">-</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Login Terakhir</dt>
                            <dd class="text-sm text-gray-900">-</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Package Info -->
    <div class="space-y-6">
        <!-- Current Package -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Paket Saat Ini</h3>
            
            <?php if ($user['package_name']): ?>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-wifi text-blue-600 text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900"><?= esc($user['package_name']) ?></h4>
                    <p class="text-sm text-gray-600 mb-2"><?= $user['speed'] ?> Mbps</p>
                    <p class="text-lg font-bold text-blue-600">Rp <?= number_format($user['package_price'], 0, ',', '.') ?></p>
                    <p class="text-xs text-gray-500">/bulan</p>
                </div>
                
                <button type="button" onclick="showChangePackageModal()" class="w-full mt-4 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-exchange-alt mr-2"></i>
                    Ubah Paket
                </button>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wifi text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4">Belum berlangganan paket</p>
                    <button type="button" onclick="showChangePackageModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Paket
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu</h3>
            <div class="space-y-3">
                <button type="button" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-envelope text-blue-600 mr-3"></i>
                    <span class="text-sm font-medium text-gray-900">Kirim Email</span>
                </button>
                <button type="button" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-phone text-green-600 mr-3"></i>
                    <span class="text-sm font-medium text-gray-900">Hubungi via WhatsApp</span>
                </button>
                <button type="button" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-file-invoice text-purple-600 mr-3"></i>
                    <span class="text-sm font-medium text-gray-900">Lihat Riwayat Tagihan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Package Modal -->
<div id="changePackageModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    
    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-y-auto transform transition-all z-[10000]">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Ubah Paket Pelanggan</h3>
                        <p class="text-gray-600 mt-1">Pilih paket yang sesuai untuk pelanggan</p>
                    </div>
                    <button type="button" onclick="closeChangePackageModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Current User Info -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                            <span class="text-white font-bold text-lg"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900"><?= esc($user['name']) ?></h4>
                            <p class="text-sm text-gray-600"><?= esc($user['email']) ?></p>
                            <?php if ($user['package_name']): ?>
                                <p class="text-sm text-blue-600 font-medium">
                                    Paket saat ini: <?= esc($user['package_name']) ?> (<?= $user['speed'] ?> Mbps) - Rp <?= number_format($user['package_price'], 0, ',', '.') ?>/bulan
                                </p>
                            <?php else: ?>
                                <p class="text-sm text-gray-500">Belum berlangganan paket</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($user['package_name']): ?>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                Aktif
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="px-6 py-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-6">Pilih Paket Baru</h4>
                
                <!-- No Package Option -->
                <div class="mb-6">
                    <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-red-300 transition-all duration-200 cursor-pointer" onclick="selectPackage(null)">
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="h-12 w-12 bg-gradient-to-br from-red-100 to-red-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-times text-red-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Hapus Paket</h5>
                                        <p class="text-sm text-gray-600">Pelanggan tidak akan berlangganan paket apapun</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($packages as $package): ?>
                        <?php 
                        $isCurrent = isset($user['subscribe_plan_id']) && $user['subscribe_plan_id'] == $package['id'];
                        $isUpgrade = isset($user['package_price']) && $package['price'] > $user['package_price'];
                        $speedDisplay = $package['speed'] >= 1000 ? ($package['speed']/1000) . ' Gbps' : $package['speed'] . ' Mbps';
                        $priceFormatted = number_format($package['price'], 0, ',', '.');
                        ?>
                        
                        <div class="relative border-2 <?= $isCurrent ? 'border-blue-500 bg-blue-50' : 'border-gray-200' ?> rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 cursor-pointer hover:border-blue-300" onclick="selectPackage(<?= $package['id'] ?>)">
                            <?php if ($isCurrent): ?>
                                <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center py-2 text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i>PAKET AKTIF
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6 <?= $isCurrent ? 'pt-12' : '' ?>">
                                <div class="flex items-center mb-4">
                                    <div class="flex-1">
                                        <div class="text-center">
                                            <div class="h-16 w-16 bg-gradient-to-br <?= $isCurrent ? 'from-blue-500 to-blue-600' : 'from-gray-500 to-gray-600' ?> rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                                                <i class="fas fa-wifi text-white text-2xl"></i>
                                            </div>
                                            <h4 class="text-xl font-bold text-gray-900 mb-1"><?= esc($package['name']) ?></h4>
                                            <div class="text-2xl font-bold <?= $isCurrent ? 'text-blue-600' : 'text-gray-900' ?> mb-1"><?= $speedDisplay ?></div>
                                            <div class="text-sm text-gray-500 mb-3">Bandwidth</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4 mb-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900">
                                            Rp <?= $priceFormatted ?>
                                            <span class="text-base font-normal text-gray-500">/bulan</span>
                                        </div>
                                        <?php if ($isUpgrade && !$isCurrent): ?>
                                            <div class="text-sm text-green-600 mt-1">
                                                <i class="fas fa-arrow-up mr-1"></i>Upgrade (+Rp <?= number_format($package['price'] - $user['package_price'], 0, ',', '.') ?>)
                                            </div>
                                        <?php elseif (isset($user['package_price']) && $package['price'] < $user['package_price'] && !$isCurrent): ?>
                                            <div class="text-sm text-orange-600 mt-1">
                                                <i class="fas fa-arrow-down mr-1"></i>Downgrade (-Rp <?= number_format($user['package_price'] - $package['price'], 0, ',', '.') ?>)
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <ul class="space-y-1 text-sm text-gray-600">
                                        <li class="flex justify-between">
                                            <span>Kecepatan:</span>
                                            <span class="font-medium"><?= $speedDisplay ?></span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span>Data:</span>
                                            <span class="font-medium">Unlimited</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span>Paket ID:</span>
                                            <span class="font-medium">#<?= str_pad($package['id'], 3, '0', STR_PAD_LEFT) ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Information Notice -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Admin Notes:</p>
                            <ul class="list-disc list-inside space-y-1 text-blue-700">
                                <li>Perubahan akan ter-update di database secara real-time</li>
                                <li>System akan otomatis mengirim email notifikasi ke pelanggan</li>
                                <li>Billing cycle akan disesuaikan untuk perubahan paket</li>
                                <li>Log aktivitas akan tercatat untuk audit trail</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeChangePackageModal()" class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        Batal
                    </button>
                    <button type="button" onclick="savePackageChange()" class="px-6 py-3 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function showChangePackageModal() {
    const modal = document.getElementById('changePackageModal');
    modal.classList.remove('hidden');
    
    // Prevent body scrolling when modal is open
    document.body.style.overflow = 'hidden';
    
    // Add smooth fade-in effect
    setTimeout(() => {
        modal.style.opacity = '1';
    }, 10);
}

function closeChangePackageModal() {
    const modal = document.getElementById('changePackageModal');
    modal.style.opacity = '0';
    
    // Restore body scrolling
    document.body.style.overflow = '';
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

// Close modal when clicking backdrop
document.getElementById('changePackageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeChangePackageModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('changePackageModal');
        if (!modal.classList.contains('hidden')) {
            closeChangePackageModal();
        }
    }
});

let selectedPackageId = <?= isset($user['subscribe_plan_id']) ? $user['subscribe_plan_id'] : 'null' ?>;

function selectPackage(packageId) {
    selectedPackageId = packageId;
    
    // Update card styling
    const cards = document.querySelectorAll('[onclick^="selectPackage"]');
    cards.forEach(card => {
        card.classList.remove('border-blue-500', 'bg-blue-50', 'border-red-500', 'bg-red-50');
        card.classList.add('border-gray-200');
    });
    
    // Highlight selected card
    if (packageId) {
        const selectedCard = document.querySelector(`[onclick="selectPackage(${packageId})"]`);
        if (selectedCard) {
            selectedCard.classList.remove('border-gray-200');
            selectedCard.classList.add('border-blue-500', 'bg-blue-50');
        }
    } else {
        // Highlight "no package" option
        const noPackageCard = document.querySelector('[onclick="selectPackage(null)"]');
        if (noPackageCard) {
            noPackageCard.classList.remove('border-gray-200');
            noPackageCard.classList.add('border-red-500', 'bg-red-50');
        }
    }
}

function savePackageChange() {
    const currentPackageId = <?= isset($user['subscribe_plan_id']) ? $user['subscribe_plan_id'] : 'null' ?>;
    
    if (selectedPackageId == currentPackageId) {
        alert('Tidak ada perubahan pada paket pelanggan.');
        return;
    }
    
    // Find package details for confirmation
    let packageName = 'Tidak berlangganan';
    let packagePrice = 0;
    
    if (selectedPackageId) {
        const packages = <?= json_encode($packages) ?>;
        const selectedPackage = packages.find(p => p.id == selectedPackageId);
        if (selectedPackage) {
            packageName = selectedPackage.name;
            packagePrice = selectedPackage.price;
        }
    }
    
    const priceFormatted = new Intl.NumberFormat('id-ID').format(packagePrice);
    
    let confirmMessage = `Konfirmasi Perubahan Paket\n\n`;
    confirmMessage += `Pelanggan: <?= esc($user['name']) ?>\n`;
    confirmMessage += `Paket Baru: ${packageName}\n`;
    if (selectedPackageId) {
        confirmMessage += `Biaya: Rp ${priceFormatted}/bulan\n`;
    }
    confirmMessage += `\nApakah Anda yakin ingin melanjutkan?`;
    
    if (confirm(confirmMessage)) {
        const submitBtn = document.querySelector('[onclick="savePackageChange()"]');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan perubahan...';
        submitBtn.disabled = true;
        
        const formData = new FormData();
        formData.append('package_id', selectedPackageId || '');
        
        fetch(`/admin/dashboard/update-user-package/<?= $user['id'] ?>`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Berhasil! ${data.message}`);
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
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }
}

function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`/admin/users/delete/${userId}`, {
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
                window.location.href = '/admin/users';
            } else {
                alert('Gagal menghapus user: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus user');
        });
    }
}
</script>
<?= $this->endSection() ?>
