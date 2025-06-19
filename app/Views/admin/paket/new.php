<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Tambah Paket Baru
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Tambah Paket Internet Baru
<?= $this->endSection() ?>

<?= $this->section('page_subtitle') ?>
Buat paket internet baru untuk pelanggan
<?= $this->endSection() ?>

<?= $this->section('page_actions') ?>
<a href="/admin/paket" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
    <i class="fas fa-arrow-left mr-2"></i>
    Kembali
</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <!-- Main Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-plus text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Paket</h2>
                        <p class="text-gray-600">Lengkapi detail paket internet baru</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                            <div>
                                <h3 class="text-sm font-medium text-red-800 mb-2">Terdapat kesalahan:</h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="/admin/paket/create" method="post" id="packageForm" class="space-y-8">
                    <?= csrf_field() ?>
                    
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Informasi Dasar
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Paket <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="name" name="name" value="<?= old('name') ?>" required placeholder="Contoh: Paket Premium">
                                <p class="mt-1 text-sm text-gray-500">Nama yang mudah diingat dan menarik</p>
                            </div>
                            <div>
                                <label for="speed" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kecepatan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" class="w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="speed" name="speed" value="<?= old('speed') ?>" required min="1" placeholder="100">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="text-gray-500 font-medium">Mbps</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-dollar-sign text-blue-600 mr-2"></i>
                            Harga & Biaya
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Bulanan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 font-medium">Rp</span>
                                    </div>
                                    <input type="number" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="price" name="price" value="<?= old('price') ?>" required min="0" placeholder="200000">
                                </div>
                                <div id="pricePreview" class="mt-1 text-sm text-green-600 font-medium"></div>
                            </div>
                            <div>
                                <label for="installation_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                    Biaya Instalasi
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 font-medium">Rp</span>
                                    </div>
                                    <input type="number" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="installation_fee" name="installation_fee" value="<?= old('installation_fee', 0) ?>" min="0" placeholder="0">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Kosongkan atau isi 0 untuk gratis instalasi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-align-left text-blue-600 mr-2"></i>
                            Deskripsi
                        </h3>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Paket
                            </label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="description" name="description" rows="4" placeholder="Jelaskan keunggulan dan fitur paket ini..."><?= old('description') ?></textarea>
                            <p class="mt-1 text-sm text-gray-500">Deskripsikan keunggulan yang membedakan paket ini dari yang lain</p>
                        </div>
                    </div>

                    <!-- Features -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-list-check text-blue-600 mr-2"></i>
                            Fitur Unggulan
                        </h3>
                        <div id="featuresContainer" class="space-y-3">
                            <div class="flex space-x-3">
                                <input type="text" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="features[]" placeholder="Contoh: Unlimited Download">
                                <button type="button" class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" onclick="addFeature()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Tambahkan fitur-fitur unggulan yang membedakan paket ini</p>
                    </div>

                    <!-- Settings -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cog text-blue-600 mr-2"></i>
                            Pengaturan Paket
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-4">Status & Visibilitas</h4>
                                <div class="space-y-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" id="is_active" name="is_active" value="1" checked>
                                        <span class="ml-3 text-sm text-gray-700 flex items-center">
                                            <i class="fas fa-eye text-green-500 mr-2"></i>
                                            Aktifkan paket
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" id="is_popular" name="popular" value="1">
                                        <span class="ml-3 text-sm text-gray-700 flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                                            Tandai sebagai populer
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-4">Batasan Kuota</h4>
                                <div class="space-y-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" id="has_quota" name="has_quota" value="1">
                                        <span class="ml-3 text-sm text-gray-700 flex items-center">
                                            <i class="fas fa-database text-blue-500 mr-2"></i>
                                            Paket memiliki batas kuota
                                        </span>
                                    </label>
                                    <div id="quotaSettings" class="hidden">
                                        <div class="flex space-x-3">
                                            <input type="number" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="quota_limit" name="quota_limit" placeholder="500" min="1">
                                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="quota_unit">
                                                <option value="GB">GB</option>
                                                <option value="TB">TB</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <a href="/admin/paket" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <div class="flex space-x-3">
                            <button type="button" class="inline-flex items-center px-6 py-3 border border-blue-300 rounded-lg text-base font-medium text-blue-700 bg-white hover:bg-blue-50 transition-colors" onclick="saveDraft()">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Draft
                            </button>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg text-base font-medium text-white hover:bg-blue-700 transition-colors">
                                <i class="fas fa-check mr-2"></i>
                                Simpan Paket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <!-- Preview Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-24">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <i class="fas fa-eye text-blue-600 mr-2"></i>
                    <h3 class="font-semibold text-gray-900">Preview Paket</h3>
                </div>
            </div>
            <div class="p-6 text-center">
                <div class="mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wifi text-blue-600 text-2xl"></i>
                    </div>
                    <h3 id="previewName" class="text-xl font-bold text-gray-900 mb-2">Nama Paket</h3>
                    <p id="previewDesc" class="text-gray-600 text-sm">Deskripsi paket akan muncul di sini</p>
                </div>
                
                <div class="mb-6">
                    <span id="previewSpeed" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">0 Mbps</span>
                </div>
                
                <div class="mb-6">
                    <div class="text-3xl font-bold text-gray-900 mb-1" id="previewPrice">Rp 0</div>
                    <div class="text-sm text-gray-500">/bulan</div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <div class="text-sm text-gray-500 mb-1">Status</div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-500 mb-1">Popular</div>
                        <span id="previewPopular" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Tidak</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const speedInput = document.getElementById('speed');
    const priceInput = document.getElementById('price');
    const descInput = document.getElementById('description');
    const hasQuotaCheck = document.getElementById('has_quota');
    const isPopularCheck = document.getElementById('is_popular');
    
    function updatePreview() {
        // Update name
        const name = nameInput.value.trim() || 'Nama Paket';
        document.getElementById('previewName').textContent = name;
        
        // Update description
        const desc = descInput.value.trim() || 'Deskripsi paket akan muncul di sini';
        document.getElementById('previewDesc').textContent = desc;
        
        // Update speed
        const speed = speedInput.value || '0';
        document.getElementById('previewSpeed').textContent = speed + ' Mbps';
        
        // Update price
        const price = priceInput.value || '0';
        if (price) {
            const formattedPrice = new Intl.NumberFormat('id-ID').format(price);
            document.getElementById('previewPrice').textContent = 'Rp ' + formattedPrice;
        }
        
        // Update popular badge
        const popularBadge = document.getElementById('previewPopular');
        if (isPopularCheck.checked) {
            popularBadge.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800';
            popularBadge.textContent = 'Ya';
        } else {
            popularBadge.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
            popularBadge.textContent = 'Tidak';
        }
    }
    
    // Add event listeners
    [nameInput, speedInput, priceInput, descInput].forEach(input => {
        input.addEventListener('input', updatePreview);
    });
    
    isPopularCheck.addEventListener('change', updatePreview);
    
    // Quota settings toggle
    hasQuotaCheck.addEventListener('change', function() {
        const quotaSettings = document.getElementById('quotaSettings');
        quotaSettings.classList.toggle('hidden', !this.checked);
    });
    
    // Initial preview update
    updatePreview();
});

function addFeature() {
    const container = document.getElementById('featuresContainer');
    const newFeature = document.createElement('div');
    newFeature.className = 'flex space-x-3';
    newFeature.innerHTML = `
        <input type="text" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="features[]" placeholder="Fitur unggulan">
        <button type="button" class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors" onclick="this.parentElement.remove()">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(newFeature);
}

function saveDraft() {
    alert('Draft akan disimpan');
}
</script>
<?= $this->endSection() ?>
