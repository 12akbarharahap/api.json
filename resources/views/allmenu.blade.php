<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Menu</title>
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
        .card.menu-shine {
            position: relative;
            overflow: hidden;
        }
        .card.menu-shine::before {
            content: '';
            position: absolute;
            top: -75%;
            left: -75%;
            width: 50%;
            height: 200%;
            background: linear-gradient(120deg, rgba(255,255,255,0.0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0.0) 100%);
            transform: skewX(-20deg);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .card.menu-shine:hover::before {
            opacity: 1;
            animation: shine-move 0.9s linear;
        }
        @keyframes shine-move {
            0% { left: -75%; }
            100% { left: 120%; }
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
    </style>
</head>
<body>
    <div id="loading-overlay">
        <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-custom mb-4 sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('img/pizza-hut-logo.svg') }}" alt="Pizza Logo" style="height:40px;width:auto;">
            </a>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">All menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pizza">Pizza</a>
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
    <div class="container mb-4">
        <h1 class="mb-4" style="font-size:2.5rem;">All Menu</h1>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <form class="d-flex gap-2 justify-content-center align-items-center" method="get" action="" style="max-width:400px;margin:0 auto;">
                    <input type="text" class="form-control" name="q" placeholder="Cari menu..." value="{{ request('q') }}" style="max-width:220px;">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
                @if(request('q'))
                    <div class="text-center mt-2 text-muted">Hasil pencarian untuk: <strong>{{ request('q') }}</strong></div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        @if(!empty($errors))
            <div class="alert alert-warning" role="alert">
                <ul class="mb-0">
                    @foreach($errors as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2 class="mt-4 mb-3">Pizza</h2>
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
                                    data-nama="{{ $item['nama'] }}"
                                    data-deskripsi="{{ $item['deskripsi'] }}"
                                    data-harga="{{ number_format($item['harga'], 0, ',', '.') }}"
                                    data-gambar="{{ asset('img/' . $item['gambar']) }}"
                                    data-kategori="{{ $item['kategori'] }}"
                                    data-bs-toggle="modal" data-bs-target="#menuModal">
                                    View Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <h2 class="mt-4 mb-3">Pasta</h2>
        <div class="row">
            @foreach($pasta as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="menu-img-wrapper">
                            <img src="{{ asset('img/' . $item['gambar']) }}" class="card-img-top menu-img" alt="{{ $item['nama'] }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item['nama'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $item['deskripsi'] }}</p>
                            <div class="mt-auto">
                                <span class="badge bg-success mb-2">{{ $item['kategori'] }}</span>
                                <p class="card-text"><strong>Rp {{ number_format($item['harga'], 0, ',', '.') }}</strong></p>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-2 view-menu-btn" 
                                    data-nama="{{ $item['nama'] }}"
                                    data-deskripsi="{{ $item['deskripsi'] }}"
                                    data-harga="{{ number_format($item['harga'], 0, ',', '.') }}"
                                    data-gambar="{{ asset('img/' . $item['gambar']) }}"
                                    data-kategori="{{ $item['kategori'] }}"
                                    data-bs-toggle="modal" data-bs-target="#menuModal">
                                    View Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <h2 class="mt-4 mb-3">Minuman</h2>
        <div class="row">
            @foreach($minuman as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="menu-img-wrapper">
                            <img src="{{ asset('img/' . $item['gambar']) }}" class="card-img-top menu-img" alt="{{ $item['nama'] }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item['nama'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $item['deskripsi'] }}</p>
                            <div class="mt-auto">
                                <span class="badge bg-info mb-2">{{ $item['kategori'] }}</span>
                                <p class="card-text"><strong>Rp {{ number_format($item['harga'], 0, ',', '.') }}</strong></p>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-2 view-menu-btn" 
                                    data-nama="{{ $item['nama'] }}"
                                    data-deskripsi="{{ $item['deskripsi'] }}"
                                    data-harga="{{ number_format($item['harga'], 0, ',', '.') }}"
                                    data-gambar="{{ asset('img/' . $item['gambar']) }}"
                                    data-kategori="{{ $item['kategori'] }}"
                                    data-bs-toggle="modal" data-bs-target="#menuModal">
                                    View Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="menuModalLabel">Menu Detail</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img id="modalMenuImg" src="" alt="Menu" class="img-fluid rounded mb-3" style="max-height:180px;object-fit:contain;">
            <h4 id="modalMenuNama"></h4>
            <span class="badge mb-2" id="modalMenuKategori"></span>
            <p id="modalMenuDeskripsi"></p>
            <p class="fw-bold">Harga: <span id="modalMenuHarga"></span></p>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Hide spinner after content loaded
      window.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
          document.getElementById('loading-overlay').classList.add('hide');
        }, 350); // delay for smoothness
      });
      // Show spinner on navbar link click
      document.querySelectorAll('.navbar-nav .nav-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
          if (link.getAttribute('href') && link.getAttribute('href') !== window.location.pathname) {
            document.getElementById('loading-overlay').classList.remove('hide');
          }
        });
      });
      document.addEventListener('DOMContentLoaded', function() {
        const modalNama = document.getElementById('modalMenuNama');
        const modalDeskripsi = document.getElementById('modalMenuDeskripsi');
        const modalHarga = document.getElementById('modalMenuHarga');
        const modalImg = document.getElementById('modalMenuImg');
        const modalKategori = document.getElementById('modalMenuKategori');
        document.querySelectorAll('.view-menu-btn').forEach(function(btn) {
          btn.addEventListener('click', function() {
            modalNama.textContent = btn.getAttribute('data-nama');
            modalDeskripsi.textContent = btn.getAttribute('data-deskripsi');
            modalHarga.textContent = 'Rp ' + btn.getAttribute('data-harga');
            modalImg.src = btn.getAttribute('data-gambar');
            modalKategori.textContent = btn.getAttribute('data-kategori');
            // Badge color
            modalKategori.className = 'badge mb-2 ' + btn.closest('.card').querySelector('.badge').className.replace('badge mb-2', '').trim();
          });
        });
      });
    </script>
</body>
</html> 