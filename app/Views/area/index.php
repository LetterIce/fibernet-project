<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Coverage Area - FiberNet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Cek Coverage Area</h1>
                <h2 class="text-3xl text-blue-500 font-semibold">FiberNet</h2>
                <div class="w-16 h-1 bg-blue-500 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Form Section -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <!-- Message -->
                    <?php if (session()->get('message')): ?>
                        <div class="mb-6 p-4 rounded-lg <?= strpos(session()->get('message'), 'Selamat') !== false ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
                            <p class="text-sm font-medium text-center">
                                <?= session()->get('message') ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Map Result Message -->
                    <div id="mapMessage" class="mb-6 p-4 rounded-lg hidden">
                        <p id="mapMessageText" class="text-sm font-medium text-center"></p>
                    </div>

                    <!-- Postal Code Form -->
                    <form action="<?= base_url('area/proses') ?>" method="post" class="space-y-6 mb-8">
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
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 transform hover:scale-105">
                            Cek dengan Kode Pos
                        </button>
                    </form>
                    
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            Klik pada peta untuk mengetahui coverage area di lokasi tersebut
                        </p>
                    </div>
                </div>
                
                <!-- Map Section -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pilih Lokasi di Peta</h3>
                        <p class="text-sm text-gray-600">Klik pada peta untuk mengecek coverage area</p>
                    </div>
                    <div id="map" class="w-full h-96 rounded-lg border border-gray-200"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps JavaScript -->
    <script>
        let map;
        let marker;
        let coverageAreas = <?= json_encode($covered_areas) ?>;
        
        // Add error handling for Google Maps API
        window.gm_authFailure = function() {
            console.error('Google Maps API authentication failed');
            document.getElementById('map').innerHTML = '<div class="flex items-center justify-center h-full bg-red-50 text-red-600 rounded-lg"><p>Error: Google Maps API key tidak valid atau kuota terlampaui</p></div>';
        };
        
        function initMap() {
            try {
                console.log('Initializing map...');
                console.log('Coverage areas:', coverageAreas);
                
                // Initialize map
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: <?= $default_zoom ?>,
                    center: { lat: <?= $default_center['lat'] ?>, lng: <?= $default_center['lng'] ?> },
                    mapTypeControl: true,
                    streetViewControl: false,
                    fullscreenControl: true
                });
                
                console.log('Map initialized successfully');
                
                // Draw coverage areas
                drawCoverageAreas();
                
                // Add click listener
                map.addListener('click', function(event) {
                    placeMarker(event.latLng);
                    checkCoverage(event.latLng.lat(), event.latLng.lng());
                });
                
            } catch (error) {
                console.error('Error initializing map:', error);
                document.getElementById('map').innerHTML = '<div class="flex items-center justify-center h-full bg-red-50 text-red-600 rounded-lg"><p>Error loading map: ' + error.message + '</p></div>';
            }
        }
        
        function drawCoverageAreas() {
            try {
                console.log('Drawing coverage areas...');
                
                Object.keys(coverageAreas).forEach(function(areaKey) {
                    const area = coverageAreas[areaKey];
                    const bounds = area.boundaries;
                    
                    console.log('Drawing area:', area.name, bounds);
                    
                    // Create rectangle for coverage area
                    const rectangle = new google.maps.Rectangle({
                        bounds: {
                            north: bounds.north,
                            south: bounds.south,
                            east: bounds.east,
                            west: bounds.west
                        },
                        fillColor: '#4F46E5',
                        fillOpacity: 0.2,
                        strokeColor: '#4F46E5',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        clickable: false,
                        map: map
                    });
                });
                
                console.log('Coverage areas drawn successfully');
                
            } catch (error) {
                console.error('Error drawing coverage areas:', error);
            }
        }
        
        function placeMarker(location) {
            if (marker) {
                marker.setMap(null);
            }
            
            marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'Lokasi yang dipilih',
                animation: google.maps.Animation.DROP
            });
        }
        
        function checkCoverage(lat, lng) {
            // Show loading state
            const messageDiv = document.getElementById('mapMessage');
            const messageText = document.getElementById('mapMessageText');
            
            messageDiv.className = 'mb-6 p-4 rounded-lg bg-blue-50 text-blue-800 border border-blue-200';
            messageText.textContent = 'Mengecek coverage area...';
            messageDiv.classList.remove('hidden');
            
            // Send AJAX request
            fetch('<?= base_url('/cek-area/checkByCoordinates') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `lat=${lat}&lng=${lng}&<?= csrf_token() ?>=<?= csrf_hash() ?>`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update message
                    messageDiv.className = data.covered 
                        ? 'mb-6 p-4 rounded-lg bg-green-50 text-green-800 border border-green-200'
                        : 'mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200';
                    
                    messageText.textContent = data.message;
                    
                } else {
                    messageDiv.className = 'mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200';
                    messageText.textContent = data.message || 'Terjadi kesalahan saat mengecek coverage';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.className = 'mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200';
                messageText.textContent = 'Terjadi kesalahan saat mengecek coverage';
            });
        }
        
        // Add fallback if Google Maps fails to load
        setTimeout(function() {
            if (typeof google === 'undefined') {
                console.error('Google Maps API failed to load');
                document.getElementById('map').innerHTML = '<div class="flex items-center justify-center h-full bg-yellow-50 text-yellow-600 rounded-lg"><p>Loading Google Maps... Jika map tidak muncul, cek koneksi internet atau API key.</p></div>';
            }
        }, 10000); // Wait 10 seconds
    </script>
    
    <!-- Load Google Maps API with error handling -->
    <script>
        function loadGoogleMaps() {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=<?= $google_maps_api_key ?>&callback=initMap&libraries=geometry';
            script.onerror = function() {
                console.error('Failed to load Google Maps API script');
                document.getElementById('map').innerHTML = '<div class="flex items-center justify-center h-full bg-red-50 text-red-600 rounded-lg"><p>Error: Gagal memuat Google Maps API</p></div>';
            };
            document.head.appendChild(script);
        }
        
        // Load the script when page is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadGoogleMaps);
        } else {
            loadGoogleMaps();
        }
    </script>
</body>
</html>
