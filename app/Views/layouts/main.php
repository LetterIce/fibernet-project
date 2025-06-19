<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> | FiberNet - Internet Fiber Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#60A5FA',
                        accent: '#1E40AF',
                        light: '#EFF6FF'
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/js/language-helper.js') ?>"></script>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-primary to-accent rounded-lg p-2">
                            <i class="fas fa-bolt text-white text-lg"></i>
                        </div>
                        <div>
                            <span class="text-gray-900 text-xl font-bold">FiberNet</span>
                            <div class="text-primary text-xs font-medium">INTERNET FIBER</div>
                        </div>
                    </a>
                </div>
                
                <!-- Center Navigation -->
                <div class="hidden lg:flex items-center justify-center flex-1">
                    <div class="flex items-center space-x-8">
                        <a href="/" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
                            Beranda
                        </a>
                        <a href="/paket" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
                            Paket Internet
                        </a>
                        <a href="/cek-area" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
                            Cek Coverage
                        </a>
                        <a href="#" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
                            Dukungan
                        </a>
                        <a href="#" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
                            Tentang Kami
                        </a>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- Language Dropdown -->
                    <div class="relative inline-block text-left">
                        <button onclick="toggleLanguageDropdown()" class="flex items-center space-x-2 text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
                            <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-4 h-3">
                            <span>ID</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div id="language-dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                            <div class="py-1">
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-4 h-3">
                                    <span>Indonesia</span>
                                </a>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <img src="https://flagcdn.com/w20/us.png" alt="English" class="w-4 h-3">
                                    <span>English</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Auth Buttons -->
                    <?php if(session()->get('isLoggedIn')): ?>
                        <div class="flex items-center space-x-3">
                            <a href="/admin" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-accent transition-colors">
                                Dashboard
                            </a>
                            <a href="/logout" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
                                Keluar
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="bg-primary text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-accent transition-colors">
                            Masuk
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden flex items-center space-x-2">
                    <!-- Mobile Language Selector -->
                    <div class="relative inline-block text-left">
                        <button onclick="toggleMobileLanguageDropdown()" class="flex items-center space-x-1 text-gray-700 hover:text-primary p-2">
                            <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-4 h-3">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div id="mobile-language-dropdown" class="hidden absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                            <div class="py-1">
                                <a href="#" class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-4 h-3">
                                    <span>ID</span>
                                </a>
                                <a href="#" class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <img src="https://flagcdn.com/w20/us.png" alt="English" class="w-4 h-3">
                                    <span>EN</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <button class="text-gray-700 hover:text-primary p-2" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-gray-100">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="/" class="text-gray-700 block px-3 py-2 text-base font-medium hover:text-primary hover:bg-gray-50 rounded-md">Beranda</a>
                <a href="/paket" class="text-gray-700 block px-3 py-2 text-base font-medium hover:text-primary hover:bg-gray-50 rounded-md">Paket Internet</a>
                <a href="/cek-area" class="text-gray-700 block px-3 py-2 text-base font-medium hover:text-primary hover:bg-gray-50 rounded-md">Cek Coverage</a>
                <a href="#" class="text-gray-700 block px-3 py-2 text-base font-medium hover:text-primary hover:bg-gray-50 rounded-md">Dukungan</a>
                <a href="#" class="text-gray-700 block px-3 py-2 text-base font-medium hover:text-primary hover:bg-gray-50 rounded-md">Tentang Kami</a>
                
                <!-- Mobile Auth -->
                <div class="border-t border-gray-100 pt-3 mt-3">
                    <?php if(session()->get('isLoggedIn')): ?>
                        <a href="/admin" class="text-gray-700 block px-3 py-2 text-base font-medium hover:text-primary hover:bg-gray-50 rounded-md">Dashboard</a>
                        <a href="/logout" class="text-gray-700 block px-3 py-2 text-base font-medium hover:text-primary hover:bg-gray-50 rounded-md">Keluar</a>
                    <?php else: ?>
                        <a href="/login" class="bg-primary text-white block px-3 py-2 text-base font-medium rounded-md text-center">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-gradient-to-br from-primary to-accent rounded-lg p-2">
                            <i class="fas fa-bolt text-white text-lg"></i>
                        </div>
                        <div>
                            <span class="text-gray-900 text-xl font-bold">FiberNet</span>
                            <div class="text-primary text-xs font-medium">INTERNET FIBER</div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 max-w-md">
                        Penyedia layanan internet fiber optik premium yang menghadirkan konektivitas ultra-cepat 
                        dan terpercaya untuk rumah dan bisnis di seluruh Indonesia.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-gray-900 font-semibold mb-4">Layanan</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-primary transition-colors">Internet Fiber</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Paket Bisnis</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Instalasi</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Dukungan Teknis</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-gray-900 font-semibold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-phone text-primary mr-2 text-sm"></i>
                            <span>0800-1234-5678</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-primary mr-2 text-sm"></i>
                            <span>info@fibernet.id</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-primary mr-2 text-sm"></i>
                            <span>Dukungan 24/7</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-8 text-center">
                <p class="text-gray-500 text-sm">
                    © <?= date('Y') ?> FiberNet. Hak cipta dilindungi. Layanan internet fiber optik profesional.
                </p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        function toggleLanguageDropdown() {
            const dropdown = document.getElementById('language-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function toggleMobileLanguageDropdown() {
            const dropdown = document.getElementById('mobile-language-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const languageDropdown = document.getElementById('language-dropdown');
            const mobileLanguageDropdown = document.getElementById('mobile-language-dropdown');
            
            if (!event.target.closest('.relative')) {
                languageDropdown.classList.add('hidden');
                mobileLanguageDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>