<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        .navbar-custom {
            background: #23262b;
            color: #fff;
        }
        .navbar-custom .navbar-nav .nav-link {
            color: #ccc;
            font-size: 1.1rem;
            margin-right: 18px;
            transition: color 0.2s;
        }
        .navbar-custom .navbar-nav .nav-link.active, .navbar-custom .navbar-nav .nav-link:focus {
            color: #fff;
            border-bottom: 2px solid #fff;
            font-weight: bold;
        }
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #fff;
        }
        .navbar-custom .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        body {
            background: #f8f9fa;
        }
        .menu-img {
            height: 180px;
            width: 100%;
            object-fit: contain;
            background: #f8f9fa;
            border-radius: 10px 10px 0 0;
            display: block;
        }
        .menu-img-wrapper {
            position: relative;
            overflow: hidden;
        }
        .menu-img-wrapper .menu-img {
            display: block;
        }
        .menu-img-wrapper::before {
            content: '';
            position: absolute;
            top: -75%;
            left: -75%;
            width: 50%;
            height: 200%;
            background: linear-gradient(120deg, rgba(255,255,255,0.0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0.0) 100%);
            transform: skewX(-20deg);
            pointer-events: none;
            animation: shine-move 2.2s linear infinite;
        }
        @keyframes shine-move {
            0% { left: -75%; }
            100% { left: 120%; }
        }
        /* Loading overlay */
        #loading-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s;
        }
        #loading-overlay.hide {
            opacity: 0;
            pointer-events: none;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #dc3545;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom mb-4 sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('img/pizza-hut-logo.svg') }}" alt="Pizza Logo" style="height:40px;width:auto;">
            </a>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">All menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/pizza">Pizza</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pasta">Pasta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/minuman">Minuman</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h1 class="mb-4">Pizza</h1>
        <div class="row">
            @php
                function badgeWarna($kategori) {
                    switch (strtolower($kategori)) {
                        case 'classic': return 'bg-primary';
                        case 'premium': return 'bg-warning text-dark';
                        case 'vegetarian': return 'bg-success';
                        case 'spicy': return 'bg-danger';
                        default: return 'bg-secondary';
                    }
                }
            @endphp
            @foreach($pizza as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="menu-img-wrapper">
                            <img src="{{ asset('img/' . $item['gambar']) }}" class="card-img-top menu-img" alt="{{ $item['nama'] }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item['nama'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $item['deskripsi'] }}</p>
                            <div class="mt-auto">
                                <span class="badge {{ badgeWarna($item['kategori']) }} mb-2">{{ $item['kategori'] }}</span>
                                <p class="card-text"><strong>Rp {{ number_format($item['harga'], 0, ',', '.') }}</strong></p>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-2 view-menu-btn" 
                                    onclick="showMenuDetail({{ json_encode($item) }})">
                                    View Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Menu Detail Modal -->
    <div class="modal fade" id="menuModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="menuModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img id="menuModalImage" src="" alt="" class="img-fluid mb-3" style="max-height: 200px; object-fit: contain;">
                    <p id="menuModalDescription"></p>
                    <p><strong>Harga: Rp <span id="menuModalPrice"></span></strong></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hide loading overlay when page is loaded
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loading-overlay').classList.add('hidden');
            }, 500);
        });

        // Show loading overlay when clicking navbar links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (this.getAttribute('href') !== window.location.pathname) {
                    document.getElementById('loading-overlay').classList.remove('hidden');
                }
            });
        });

        // Menu detail modal function
        function showMenuDetail(item) {
            document.getElementById('menuModalTitle').textContent = item.nama;
            document.getElementById('menuModalImage').src = '/img/' + item.gambar;
            document.getElementById('menuModalImage').alt = item.nama;
            document.getElementById('menuModalDescription').textContent = item.deskripsi;
            document.getElementById('menuModalPrice').textContent = new Intl.NumberFormat('id-ID').format(item.harga);
            
            const modal = new bootstrap.Modal(document.getElementById('menuModal'));
            modal.show();
        }
    </script>
</body>
</html> 