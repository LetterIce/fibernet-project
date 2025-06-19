<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Paket Internet
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="bg-gradient-to-br from-light to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                <span data-lang="id">Nikmati #WifiTerbaik </span>
                <span data-lang="en" style="display: none;">Enjoy #BestWifi</span>
                <span class="text-primary block">
                    <span data-lang="id">Fiber Ultra Cepat dan Unlimited</span>
                    <span data-lang="en" style="display: none;">Ultra Fast and Unlimited</span>
                </span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                <span data-lang="id">Paket internet fiber optik berkecepatan tinggi yang dirancang untuk rumah dan bisnis modern. 
                Rasakan konektivitas andal dengan kecepatan hingga 1 Gbps.</span>
                <span data-lang="en" style="display: none;">High-speed fiber optic internet packages designed for modern homes and businesses. 
                Experience reliable connectivity with speeds up to 1 Gbps.</span>
            </p>
            <button id="scrollToPackages" class="inline-flex items-center bg-primary text-white px-8 py-3 rounded-lg font-medium hover:bg-accent transition-colors">
                <span data-lang="id">Lihat Semua Paket</span>
                <span data-lang="en" style="display: none;">View All Packages</span>
                <i class="fas fa-arrow-down ml-2"></i>
            </button>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-light rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tachometer-alt text-primary text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                    <span data-lang="id">Kecepatan Ultra Cepat</span>
                    <span data-lang="en" style="display: none;">Ultra Fast Speed</span>
                </h3>
                <p class="text-gray-600">
                    <span data-lang="id">Teknologi fiber optik menghadirkan internet berkecepatan tinggi yang konsisten untuk semua kebutuhan Anda.</span>
                    <span data-lang="en" style="display: none;">Fiber optic technology delivers consistently high-speed internet for all your needs.</span>
                </p>
            </div>
            
            <div class="text-center">
                <div class="bg-light rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-primary text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                    <span data-lang="id">Jaringan Terpercaya</span>
                    <span data-lang="en" style="display: none;">Reliable Network</span>
                </h3>
                <p class="text-gray-600">
                    <span data-lang="id">Jaminan uptime 99.9% dengan infrastruktur fiber redundan dan monitoring 24/7.</span>
                    <span data-lang="en" style="display: none;">99.9% uptime guarantee with redundant fiber infrastructure and 24/7 monitoring.</span>
                </p>
            </div>
            
            <div class="text-center">
                <div class="bg-light rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-primary text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                    <span data-lang="id">Dukungan Ahli</span>
                    <span data-lang="en" style="display: none;">Expert Support</span>
                </h3>
                <p class="text-gray-600">
                    <span data-lang="id">Dukungan teknis profesional dan layanan instalasi tersedia di seluruh Indonesia.</span>
                    <span data-lang="en" style="display: none;">Professional technical support and installation services available throughout Indonesia.</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Packages Section -->
<div id="packages" class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                <span data-lang="id">Paket Internet Fiber</span>
                <span data-lang="en" style="display: none;">Fiber Internet Packages</span>
            </h2>
            <p class="text-lg text-gray-600">
                <span data-lang="id">Pilih paket yang sempurna untuk kebutuhan konektivitas Anda</span>
                <span data-lang="en" style="display: none;">Choose the perfect package for your connectivity needs</span>
            </p>
        </div>

        <?php if (!empty($packages)): ?>
            <?php if (count($packages) > 3): ?>
            <!-- Horizontal Scrollable Layout for 4+ packages -->
            <div class="relative">
                <!-- Navigation Arrows -->
                <button id="scrollLeft" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow-lg rounded-full w-12 h-12 flex items-center justify-center text-gray-600 hover:text-primary hover:shadow-xl transition-all duration-300 -ml-6">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="scrollRight" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow-lg rounded-full w-12 h-12 flex items-center justify-center text-gray-600 hover:text-primary hover:shadow-xl transition-all duration-300 -mr-6">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- Scrollable Container -->
                <div id="packagesContainer" class="overflow-hidden py-2 px-2">
                    <div id="packagesScroll" class="flex gap-8 transition-transform duration-500 ease-in-out">
                        <?php foreach ($packages as $index => $pkg): ?>
                        <div class="flex-shrink-0 w-full max-w-sm bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 <?= $index === 1 ? 'ring-2 ring-primary' : '' ?> <?= $index === 1 ? 'my-1' : '' ?>">
                            <?php if ($index === 1): ?>
                            <div class="bg-primary text-white text-center py-2 text-sm font-medium">
                                <span data-lang="id">PALING POPULER</span>
                                <span data-lang="en" style="display: none;">MOST POPULAR</span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="p-8">
                                <div class="text-center mb-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?= esc($pkg['name']) ?></h3>
                                    <div class="mb-4">
                                        <span class="text-4xl font-bold text-gray-900"><?= esc($pkg['speed']) ?></span>
                                        <span class="text-lg text-gray-500 ml-1">Mbps</span>
                                    </div>
                                    <p class="text-gray-600 text-sm"><?= esc($pkg['description']) ?></p>
                                </div>
                                
                                <div class="text-center mb-6">
                                    <div class="text-2xl font-bold text-gray-900">
                                        Rp <?= number_format($pkg['price'], 0, ',', '.') ?>
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        <span data-lang="id">per bulan</span>
                                        <span data-lang="en" style="display: none;">per month</span>
                                    </div>
                                </div>
                                
                                <ul class="space-y-3 mb-8">
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                        <span class="text-gray-700">
                                            <span data-lang="id">Koneksi fiber optik premium</span>
                                            <span data-lang="en" style="display: none;">Premium fiber optic connection</span>
                                        </span>
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                        <span class="text-gray-700">
                                            <span data-lang="id">Kuota data unlimited</span>
                                            <span data-lang="en" style="display: none;">Unlimited data quota</span>
                                        </span>
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                        <span class="text-gray-700">
                                            <span data-lang="id">Instalasi & perangkat gratis</span>
                                            <span data-lang="en" style="display: none;">Free installation & equipment</span>
                                        </span>
                                    </li>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                        <span class="text-gray-700">
                                            <span data-lang="id">Dukungan pelanggan 24/7</span>
                                            <span data-lang="en" style="display: none;">24/7 customer support</span>
                                        </span>
                                    </li>
                                    <?php if ($pkg['speed'] >= 100): ?>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                        <span class="text-gray-700">
                                            <span data-lang="id">Prioritas dukungan teknis</span>
                                            <span data-lang="en" style="display: none;">Priority technical support</span>
                                        </span>
                                    </li>
                                    <?php endif; ?>
                                    <?php if ($pkg['speed'] >= 250): ?>
                                    <li class="flex items-center text-sm">
                                        <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                        <span class="text-gray-700">
                                            <span data-lang="id">Layanan tingkat bisnis</span>
                                            <span data-lang="en" style="display: none;">Business-grade services</span>
                                        </span>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                                
                                <button class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-accent transition-colors package-select-btn" data-package-id="<?= $pkg['id'] ?>">
                                    <span data-lang="id">Pilih Paket Ini</span>
                                    <span data-lang="en" style="display: none;">Choose This Package</span>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Dots Indicator -->
                <div class="flex justify-center mt-8 space-x-2" id="dotsContainer">
                    <!-- Dots will be generated by JavaScript -->
                </div>
            </div>
            <?php else: ?>
            <!-- Grid Layout for 3 or fewer packages -->
            <div class="grid grid-cols-1 md:grid-cols-<?= count($packages) <= 2 ? count($packages) : '3' ?> gap-12 justify-center">
                <?php foreach ($packages as $index => $pkg): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 <?= $index === 1 ? 'ring-2 ring-primary' : '' ?>">
                    <?php if ($index === 1): ?>
                    <div class="bg-primary text-white text-center py-2 text-sm font-medium">
                        <span data-lang="id">PALING POPULER</span>
                        <span data-lang="en" style="display: none;">MOST POPULAR</span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3"><?= esc($pkg['name']) ?></h3>
                            <div class="mb-4">
                                <span class="text-4xl font-bold text-gray-900"><?= esc($pkg['speed']) ?></span>
                                <span class="text-lg text-gray-500 ml-1">Mbps</span>
                            </div>
                            <p class="text-gray-600 text-sm"><?= esc($pkg['description']) ?></p>
                        </div>
                        
                        <div class="text-center mb-6">
                            <div class="text-2xl font-bold text-gray-900">
                                Rp <?= number_format($pkg['price'], 0, ',', '.') ?>
                            </div>
                            <div class="text-gray-500 text-sm">
                                <span data-lang="id">per bulan</span>
                                <span data-lang="en" style="display: none;">per month</span>
                            </div>
                        </div>
                        
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                <span class="text-gray-700">
                                    <span data-lang="id">Koneksi fiber optik premium</span>
                                    <span data-lang="en" style="display: none;">Premium fiber optic connection</span>
                                </span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                <span class="text-gray-700">
                                    <span data-lang="id">Kuota data unlimited</span>
                                    <span data-lang="en" style="display: none;">Unlimited data quota</span>
                                </span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                <span class="text-gray-700">
                                    <span data-lang="id">Instalasi & perangkat gratis</span>
                                    <span data-lang="en" style="display: none;">Free installation & equipment</span>
                                </span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                <span class="text-gray-700">
                                    <span data-lang="id">Dukungan pelanggan 24/7</span>
                                    <span data-lang="en" style="display: none;">24/7 customer support</span>
                                </span>
                            </li>
                            <?php if ($pkg['speed'] >= 100): ?>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                <span class="text-gray-700">
                                    <span data-lang="id">Prioritas dukungan teknis</span>
                                    <span data-lang="en" style="display: none;">Priority technical support</span>
                                </span>
                            </li>
                            <?php endif; ?>
                            <?php if ($pkg['speed'] >= 250): ?>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-3 text-xs"></i>
                                <span class="text-gray-700">
                                    <span data-lang="id">Layanan tingkat bisnis</span>
                                    <span data-lang="en" style="display: none;">Business-grade services</span>
                                </span>
                            </li>
                            <?php endif; ?>
                        </ul>
                        
                        <button class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-accent transition-colors package-select-btn" data-package-id="<?= $pkg['id'] ?>">
                            <span data-lang="id">Pilih Paket Ini</span>
                            <span data-lang="en" style="display: none;">Choose This Package</span>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-info-circle text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">
                    <span data-lang="id">Tidak Ada Paket Tersedia</span>
                    <span data-lang="en" style="display: none;">No Packages Available</span>
                </h3>
                <p class="text-gray-500">
                    <span data-lang="id">Kami sedang memperbarui paket layanan kami. Silakan cek kembali nanti.</span>
                    <span data-lang="en" style="display: none;">We are updating our service packages. Please check back later.</span>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Benefits Section -->
<div class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-8">
                    <span data-lang="id">Mengapa Memilih Internet Fiber?</span>
                    <span data-lang="en" style="display: none;">Why Choose Fiber Internet?</span>
                </h2>
                <p class="text-lg text-gray-600 mb-12">
                    <span data-lang="id">Teknologi fiber optik merupakan standar emas dalam konektivitas internet, 
                    menawarkan kecepatan, keandalan, dan performa yang terdepan.</span>
                    <span data-lang="en" style="display: none;">Fiber optic technology is the gold standard in internet connectivity, 
                    offering speed, reliability, and top-notch performance.</span>
                </p>
                
                <div class="space-y-8">
                    <div class="flex items-start space-x-4">
                        <div class="bg-light rounded-lg p-2 flex-shrink-0">
                            <i class="fas fa-rocket text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">
                                <span data-lang="id">Kecepatan Sangat Tinggi</span>
                                <span data-lang="en" style="display: none;">Extremely High Speed</span>
                            </h4>
                            <p class="text-gray-600 text-sm">
                                <span data-lang="id">Rasakan kecepatan hingga 100x lebih cepat dibandingkan koneksi broadband tradisional.</span>
                                <span data-lang="en" style="display: none;">Experience speeds up to 100x faster than traditional broadband connections.</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-light rounded-lg p-2 flex-shrink-0">
                            <i class="fas fa-sync text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">
                                <span data-lang="id">Bandwidth Simetris</span>
                                <span data-lang="en" style="display: none;">Symmetrical Bandwidth</span>
                            </h4>
                            <p class="text-gray-600 text-sm">
                                <span data-lang="id">Kecepatan unggah dan unduh yang sama untuk panggilan video dan berbagi file tanpa hambatan.</span>
                                <span data-lang="en" style="display: none;">Equal upload and download speeds for seamless video calls and file sharing.</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="bg-light rounded-lg p-2 flex-shrink-0">
                            <i class="fas fa-clock text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">
                                <span data-lang="id">Latensi Rendah</span>
                                <span data-lang="en" style="display: none;">Low Latency</span>
                            </h4>
                            <p class="text-gray-600 text-sm">
                                <span data-lang="id">Penundaan minimal untuk gaming online, streaming video, dan aplikasi real-time.</span>
                                <span data-lang="en" style="display: none;">Minimal delay for online gaming, video streaming, and real-time applications.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-light to-blue-50 rounded-2xl p-10">
                <div class="text-center">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="fas fa-wifi text-primary text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <span data-lang="id">Jaringan Premium</span>
                        <span data-lang="en" style="display: none;">Premium Network</span>
                    </h3>
                    <p class="text-gray-600 mb-6">
                        <span data-lang="id">Dibangun di atas infrastruktur fiber optik canggih dengan jalur redundan 
                        yang memastikan uptime dan performa maksimal.</span>
                        <span data-lang="en" style="display: none;">Built on advanced fiber optic infrastructure with redundant paths 
                        ensuring maximum uptime and performance.</span>
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-primary">99.9%</div>
                            <div class="text-sm text-gray-600">
                                <span data-lang="id">Uptime</span>
                                <span data-lang="en" style="display: none;">Uptime</span>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-primary">24/7</div>
                            <div class="text-sm text-gray-600">
                                <span data-lang="id">Dukungan</span>
                                <span data-lang="en" style="display: none;">Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-primary py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">
            <span data-lang="id">Siap untuk Memulai?</span>
            <span data-lang="en" style="display: none;">Ready to Get Started?</span>
        </h2>
        <p class="text-xl text-blue-100 mb-12 max-w-2xl mx-auto">
            <span data-lang="id">Cek ketersediaan internet fiber di area Anda dan nikmati akses internet fiber berkecepatan tinggi.</span>
            <span data-lang="en" style="display: none;">Check fiber internet availability in your area and join thousands of satisfied customers.</span>
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/cek-area" class="bg-white text-primary px-8 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <span data-lang="id">Cek Area Coverage</span>
                <span data-lang="en" style="display: none;">Check Area Coverage</span>
            </a>
            <a href="tel:0800-1234-5678" class="border-2 border-white text-white px-8 py-3 rounded-lg font-medium hover:bg-white hover:text-primary transition-colors">
                <span data-lang="id">Hubungi: 0800-1234-5678</span>
                <span data-lang="en" style="display: none;">Call: 0800-1234-5678</span>
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll functionality
    const scrollButton = document.getElementById('scrollToPackages');
    const packagesSection = document.getElementById('packages');
    
    scrollButton.addEventListener('click', function(e) {
        e.preventDefault();
        packagesSection.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
    
    // Language changer functionality - integrate with existing dropdown
    function switchLanguage(targetLang) {
        console.log('Switching to language:', targetLang); // Debug log
        
        const langElements = document.querySelectorAll('[data-lang]');
        
        // Show/hide language elements
        langElements.forEach(element => {
            if (element.getAttribute('data-lang') === targetLang) {
                element.style.display = '';
            } else {
                element.style.display = 'none';
            }
        });
        
        // Store language preference
        localStorage.setItem('preferred_language', targetLang);
    }
    
    // Multiple event listeners for different dropdown patterns
    document.addEventListener('click', function(e) {
        const target = e.target;
        
        // Pattern 1: Check for data-language attribute
        if (target.hasAttribute('data-language')) {
            const langCode = target.getAttribute('data-language');
            const targetLang = langCode === 'id' || langCode === 'ID' ? 'id' : 'en';
            switchLanguage(targetLang);
            return;
        }
        
        // Pattern 2: Check for data-lang attribute on clickable elements
        if (target.hasAttribute('data-lang-switch')) {
            const langCode = target.getAttribute('data-lang-switch');
            const targetLang = langCode === 'id' || langCode === 'ID' ? 'id' : 'en';
            switchLanguage(targetLang);
            return;
        }
        
        // Pattern 3: Check for common class names or text content
        const classList = target.classList;
        const textContent = target.textContent.trim().toLowerCase();
        
        if (classList.contains('lang-id') || textContent.includes('indonesia') || textContent === 'id') {
            switchLanguage('id');
            return;
        }
        
        if (classList.contains('lang-en') || textContent.includes('english') || textContent === 'en') {
            switchLanguage('en');
            return;
        }
        
        // Pattern 4: Check parent elements
        const parent = target.closest('[data-language], [data-lang-switch], .lang-id, .lang-en');
        if (parent) {
            if (parent.hasAttribute('data-language')) {
                const langCode = parent.getAttribute('data-language');
                const targetLang = langCode === 'id' || langCode === 'ID' ? 'id' : 'en';
                switchLanguage(targetLang);
            } else if (parent.hasAttribute('data-lang-switch')) {
                const langCode = parent.getAttribute('data-lang-switch');
                const targetLang = langCode === 'id' || langCode === 'ID' ? 'id' : 'en';
                switchLanguage(targetLang);
            } else if (parent.classList.contains('lang-id')) {
                switchLanguage('id');
            } else if (parent.classList.contains('lang-en')) {
                switchLanguage('en');
            }
        }
    });
    
    // Listen for custom language change events
    document.addEventListener('languageChanged', function(e) {
        const targetLang = e.detail.language === 'id' || e.detail.language === 'ID' ? 'id' : 'en';
        switchLanguage(targetLang);
    });
    
    // Global function to switch language (can be called from anywhere)
    window.switchLanguage = switchLanguage;
    
    // Load saved language preference
    const savedLang = localStorage.getItem('preferred_language') || 'id';
    switchLanguage(savedLang);

    // Package selection functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('package-select-btn') || e.target.closest('.package-select-btn')) {
            const button = e.target.classList.contains('package-select-btn') ? e.target : e.target.closest('.package-select-btn');
            const packageId = button.getAttribute('data-package-id');
            
            // Redirect to registration with selected package
            window.location.href = `/registration?package=${packageId}`;
        }
    });

    // Package scrolling functionality
    const packagesContainer = document.getElementById('packagesContainer');
    const packagesScroll = document.getElementById('packagesScroll');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');
    const dotsContainer = document.getElementById('dotsContainer');

    if (packagesContainer && packagesScroll) {
        let currentIndex = 0;
        const cards = packagesScroll.children;
        const totalCards = cards.length;
        const cardsPerView = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
        const maxIndex = Math.max(0, totalCards - cardsPerView);

        // Create dots indicator
        function createDots() {
            dotsContainer.innerHTML = '';
            for (let i = 0; i <= maxIndex; i++) {
                const dot = document.createElement('button');
                dot.className = `w-3 h-3 rounded-full transition-colors duration-300 ${i === currentIndex ? 'bg-primary' : 'bg-gray-300'}`;
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            }
        }

        // Update card width based on viewport
        function updateCardWidth() {
            const containerWidth = packagesContainer.offsetWidth - 16; // Account for px-2 padding (8px each side)
            const cardWidth = containerWidth / cardsPerView;
            Array.from(cards).forEach(card => {
                card.style.minWidth = `${cardWidth - 32}px`; // 32px for gap
            });
        }

        // Go to specific slide
        function goToSlide(index) {
            currentIndex = Math.max(0, Math.min(index, maxIndex));
            const cardWidth = cards[0].offsetWidth + 32; // Include gap
            const translateX = -currentIndex * cardWidth;
            packagesScroll.style.transform = `translateX(${translateX}px)`;
            
            // Update dots
            const dots = dotsContainer.children;
            Array.from(dots).forEach((dot, i) => {
                dot.className = `w-3 h-3 rounded-full transition-colors duration-300 ${i === currentIndex ? 'bg-primary' : 'bg-gray-300'}`;
            });
            
            // Update arrow visibility
            scrollLeftBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
            scrollLeftBtn.style.pointerEvents = currentIndex === 0 ? 'none' : 'auto';
            scrollRightBtn.style.opacity = currentIndex === maxIndex ? '0.5' : '1';
            scrollRightBtn.style.pointerEvents = currentIndex === maxIndex ? 'none' : 'auto';
        }

        // Scroll left
        if (scrollLeftBtn) {
            scrollLeftBtn.addEventListener('click', () => {
                goToSlide(currentIndex - 1);
            });
        }

        // Scroll right
        if (scrollRightBtn) {
            scrollRightBtn.addEventListener('click', () => {
                goToSlide(currentIndex + 1);
            });
        }

        // Handle touch/swipe for mobile
        let startX = 0;
        let isDragging = false;

        packagesContainer.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        packagesContainer.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
        });

        packagesContainer.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;
            
            if (Math.abs(diffX) > 50) { // Minimum swipe distance
                if (diffX > 0) {
                    goToSlide(currentIndex + 1); // Swipe left, go right
                } else {
                    goToSlide(currentIndex - 1); // Swipe right, go left
                }
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                goToSlide(currentIndex - 1);
            } else if (e.key === 'ArrowRight') {
                goToSlide(currentIndex + 1);
            }
        });

        // Auto-scroll (optional - uncomment to enable)
        // let autoScrollInterval = setInterval(() => {
        //     if (currentIndex >= maxIndex) {
        //         goToSlide(0);
        //     } else {
        //         goToSlide(currentIndex + 1);
        //     }
        // }, 5000);

        // // Pause auto-scroll on hover
        // packagesContainer.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
        // packagesContainer.addEventListener('mouseleave', () => {
        //     autoScrollInterval = setInterval(() => {
        //         if (currentIndex >= maxIndex) {
        //             goToSlide(0);
        //         } else {
        //             goToSlide(currentIndex + 1);
        //         }
        //     }, 5000);
        // });

        // Handle window resize
        window.addEventListener('resize', () => {
            updateCardWidth();
            goToSlide(0); // Reset to first slide on resize
        });

        // Initialize
        updateCardWidth();
        createDots();
        goToSlide(0);
    }
});
</script>
<?= $this->endSection() ?>