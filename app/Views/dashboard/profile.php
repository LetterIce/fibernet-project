<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Profil Pengguna
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Profil Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <!-- Success/Error Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="h-20 w-20 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900"><?= esc($user['name']) ?></h3>
                    <p class="text-gray-500"><?= esc($user['email']) ?></p>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            <p><span class="font-medium">Status:</span> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </p>
                            <?php if ($user['package_name']): ?>
                                <p class="mt-2"><span class="font-medium">Paket:</span> <?= esc($user['package_name']) ?></p>
                                <p><span class="font-medium">Kecepatan:</span> <?= esc($user['speed']) ?> Mbps</p>
                            <?php endif; ?>
                            <p class="mt-2"><span class="font-medium">Bergabung:</span> <?= date('d M Y', strtotime($user['created_at'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Edit Profil</h2>
                    <p class="text-gray-600 text-sm mt-1">Perbarui informasi profil Anda</p>
                </div>
                
                <div class="p-6">
                    <form action="/dashboard/profile/update" method="post" class="space-y-6">
                        <?= csrf_field() ?>
                        
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="<?= old('name', $user['name']) ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            <?php if (isset($errors['name'])): ?>
                                <p class="mt-1 text-sm text-red-600"><?= $errors['name'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="<?= old('email', $user['email']) ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                                   placeholder="Masukkan alamat email"
                                   required>
                            <?php if (isset($errors['email'])): ?>
                                <p class="mt-1 text-sm text-red-600"><?= $errors['email'] ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit" class="flex-1 bg-primary hover:bg-accent text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                            <a href="/dashboard" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center text-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
