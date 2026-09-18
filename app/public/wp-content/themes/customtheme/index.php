<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Belajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white min-vh-100 d-flex flex-column">
    <header>
        <div class="container-fluid px-4">
            <!-- Menambahkan d-flex, justify-content-between, dan align-items-center -->
            <div class="py-4 d-flex justify-content-between align-items-center">
                <h1 class="display-6 fw-bold mb-0">Kreasi</h1>

                <!-- Menambahkan class navbar-light agar ikon garis hamburger berwarna gelap & terlihat di bg putih -->
                <button class="navbar-toggler shadow-none"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    style="
                            border: 2px solid #E5E5E9; /* Border abu-abu terang */
                            border-radius: 12px;       /* Sudut melengkung */
                            padding: 14px 14px;      /* Padding agar kotak proposional */
                            display: flex;
                            flex-direction: column;
                            gap: 6px;                 /* Jarak antar garis */
                            outline: none !important;
        ">
                    <!-- Garis Manual -->
                    <span style="display: block; width: 30px; height: 3px; background-color: black; border-radius: 1px;"></span>
                    <span style="display: block; width: 30px; height: 3px; background-color: black; border-radius: 1px;"></span>
                    <span style="display: block; width: 30px; height: 3px; background-color: black; border-radius: 1px;"></span>
                </button>
            </div>

            <!-- Catatan: Typo 'order-bottom' disesuaikan menjadi 'border-bottom' -->
            <div class="border-bottom border-4" style="background-color: #E5E5EA;">
            </div>
        </div>
    </header>

    <main class="flex-grow-1 py-4 py-lg-5">
        <div class="container-fluid">
            <div class="row justify-content-center ">
                <!-- <div class="card"> -->

                <!-- <p class="lead text-secondary mb-4">
                    UNTUK PENDIDIKAN YANG BERKUALITAS.
                </p> -->
            </div>
        </div>

        <div class="mb-4">
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80"
                alt="Belajar di depan laptop"
                class="img-fluid shadow-sm w-100" style="height: 260px; object-fit: cover;">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center ">



                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 bg-light">
                            <div class="card-body">
                                <h2 class="h4 fw-bold mb-3">Tujuan Belajar</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-light">Memahami struktur dasar halaman</li>
                                    <li class="list-group-item bg-light">Menggunakan HTML dan Bootstrap 5</li>
                                    <li class="list-group-item bg-light">Menyesuaikan tampilan di WordPress</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100 border-0 bg-primary-subtle">
                            <div class="card-body">
                                <h2 class="h4 fw-bold mb-3">Catatan</h2>
                                <p class="mb-0 text-dark">
                                    Kamu bisa menambahkan teks, gambar, tombol, formulir, atau bagian lain sesuai kebutuhan
                                    halaman belajar Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="btn btn-primary btn-lg px-4">Lanjut Belajar</a>
                    <a href="#" class="btn btn-outline-primary btn-lg px-4">Lihat Materi</a>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </main>

    <footer class="bg-dark text-light text-center py-3">
        <div class="container-fluid px-4">
            © 2026 Belajar WordPress
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>