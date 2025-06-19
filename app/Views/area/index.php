<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Coverage Area - FiberNet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Cek Coverage Area</h1>
                <h2 class="text-3xl text-blue-500 font-semibold">FiberNet</h2>
                <div class="w-16 h-1 bg-blue-500 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <!-- Message -->
            <?php if (session()->get('message')): ?>
                <div class="mb-6 p-4 rounded-lg <?= strpos(session()->get('message'), 'Selamat') !== false ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
                    <p class="text-sm font-medium text-center">
                        <?= session()->get('message') ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="<?= base_url('area/proses') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>
                
                <div class="space-y-2">
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">
                        Kode Pos
                    </label>
                    <input type="text" 
                           id="postal_code" 
                           name="postal_code" 
                           placeholder="Masukkan kode pos Anda" 
                           value="<?= old('postal_code') ?>" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500"
                           required>
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Cek Coverage
                </button>
            </form>
            
            <!-- Footer Text -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 leading-relaxed">
                    Masukkan kode pos area Anda untuk mengecek ketersediaan layanan FiberNet di wilayah Anda.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
