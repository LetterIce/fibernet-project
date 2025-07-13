<div class="mb-4">
    <h4 class="text-sm font-medium text-gray-900 mb-2">User: <?= esc($user['name']) ?></h4>
    <p class="text-sm text-gray-600 mb-1"><?= esc($user['email']) ?></p>
    <?php if ($user['package_name']): ?>
        <p class="text-sm text-blue-600">Paket saat ini: <?= esc($user['package_name']) ?> (<?= $user['speed'] ?> Mbps)</p>
    <?php else: ?>
        <p class="text-sm text-gray-500">Belum berlangganan paket</p>
    <?php endif; ?>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Paket Baru:</label>
    <select id="packageSelectModal" name="package_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Hapus paket (tidak berlangganan)</option>
        <?php foreach ($packages as $package): ?>
            <option value="<?= $package['id'] ?>" <?= isset($user['subscribe_plan_id']) && $user['subscribe_plan_id'] == $package['id'] ? 'selected' : '' ?>>
                <?= esc($package['name']) ?> - <?= $package['speed'] ?> Mbps - Rp <?= number_format($package['price'], 0, ',', '.') ?>/bulan
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="bg-yellow-50 border border-yellow-200 rounded-md p-3 mb-4">
    <div class="flex">
        <i class="fas fa-exclamation-triangle text-yellow-400 mr-2 mt-0.5"></i>
        <div class="text-sm text-yellow-700">
            <p><strong>Perhatian:</strong></p>
            <ul class="list-disc list-inside mt-1 space-y-1">
                <li>Perubahan paket akan langsung berlaku</li>
                <li>Pilih "Hapus paket" untuk menghapus langganan user</li>
                <li>User akan menerima notifikasi perubahan paket</li>
            </ul>
        </div>
    </div>
</div>

<script>
// Add debug logging for modal content
console.log('Modal content loaded successfully');
console.log('packageSelectModal element:', document.getElementById('packageSelectModal'));
</script>
