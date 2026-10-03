<?php

/**
 * Template Name: Artikel
 * The template for displaying the article archive page.
 *
 * @package customtheme
 */

get_header();
?>

<style>
    .btn-outline-danger:hover svg path {
        stroke: #ffffff;
        transition: stroke 0.2s ease-in-out;

        /* Menambahkan transisi halus */
    }

    .small-text {
        background-color: #0621721A;
        color: #062172B2;
    }

    .btn-outline-ungu {
        color: #062172;
        border-color: #062172;
    }

    .btn-outline-ungu:hover {
        background-color: #062172;
        border-color: #062172;
        color: #ffffff;
    }

    .btn-outline-ungu:hover .small-text {
        color: #ffffff;
    }

    .btn-outline-ungu:hover svg path {
        stroke: #ffffff;
        transition: stroke 0.2s ease-in-out;

        /* Menambahkan transisi halus */
    }
</style>
<main id="primary" class="site-main py-5 bg-light">
    <div class="container px-4 px-lg-5">
        <header class="page-header mb-5 text-center">
            <h1 class="page-title fw-bold text-navy mb-2">ARTIKEL</h1>
        </header>
        <div class="shadow p-4 mb-5 bg-white rounded">
            <div class="d-flex flex-wrap justify-content-center">
                <a href="#" type="button" class="btn btn-outline-danger m-1 fst-normal rounded-pill">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.25 10.5H12.75M10.5 8.25V12.75M0.75 0.75H5.25V5.25H0.75V0.75ZM8.25 0.75H12.75V5.25H8.25V0.75ZM0.75 8.25H5.25V12.75H0.75V8.25Z" stroke="#DA291C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Semua Artikel
                </a>
                <a href="#" type="button" class="btn btn-outline-danger m-1 fst-normal rounded-pill">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 6.75H12M6 9.75H10.5M13.5 3C14.0967 3 14.669 3.23705 15.091 3.65901C15.5129 4.08097 15.75 4.65326 15.75 5.25V11.25C15.75 11.8467 15.5129 12.419 15.091 12.841C14.669 13.2629 14.0967 13.5 13.5 13.5H9.75L6 15.75V13.5H4.5C3.90326 13.5 3.33097 13.2629 2.90901 12.841C2.48705 12.419 2.25 11.8467 2.25 11.25V5.25C2.25 4.65326 2.48705 4.08097 2.90901 3.65901C3.33097 3.23705 3.90326 3 4.5 3H13.5Z" stroke="#DA291C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Cerita
                </a>
                <a href="#" type="button" class="btn btn-outline-danger m-1 fst-normal rounded-pill">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.75 2.25H12C12.1989 2.25 12.3897 2.32902 12.5303 2.46967C12.671 2.61032 12.75 2.80109 12.75 3V11.25C12.75 11.6478 12.592 12.0294 12.3107 12.3107C12.0294 12.592 11.6478 12.75 11.25 12.75M11.25 12.75C10.8522 12.75 10.4706 12.592 10.1893 12.3107C9.90804 12.0294 9.75 11.6478 9.75 11.25V1.5C9.75 1.30109 9.67098 1.11032 9.53033 0.96967C9.38968 0.829018 9.19891 0.75 9 0.75H1.5C1.30109 0.75 1.11032 0.829018 0.96967 0.96967C0.829018 1.11032 0.75 1.30109 0.75 1.5V10.5C0.75 11.0967 0.987053 11.669 1.40901 12.091C1.83097 12.5129 2.40326 12.75 3 12.75H11.25ZM3.75 3.75H6.75M3.75 6.75H6.75M3.75 9.75H6.75" stroke="#DA291C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Berita
                </a>
                <a href="#" type="button" class="btn btn-outline-danger m-1 fst-normal rounded-pill">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.25 6H12.75M5.25 9H12.75M5.25 12H12.75M2.25 4.5C2.25 4.10218 2.40804 3.72064 2.68934 3.43934C2.97064 3.15804 3.35218 3 3.75 3H14.25C14.6478 3 15.0294 3.15804 15.3107 3.43934C15.592 3.72064 15.75 4.10218 15.75 4.5V13.5C15.75 13.8978 15.592 14.2794 15.3107 14.5607C15.0294 14.842 14.6478 15 14.25 15H3.75C3.35218 15 2.97064 14.842 2.68934 14.5607C2.40804 14.2794 2.25 13.8978 2.25 13.5V4.5Z" stroke="#DA291C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Liputan Media
                </a>
            </div>
            <div class="d-flex flex-wrap justify-content-center mb-2 px-3">
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Semua Daerah&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Nasional&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Nias Utara&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Nias Selatan&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Tanggamus&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Pesisir Barat&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Ketapang&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Kayong Utara&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Halmahera Utara&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
                <a href="#" type="button" class="btn btn-outline-ungu m-1 fst-normal rounded-pill">
                    Pulau Morotai&nbsp;<small class="p-1 rounded-pill small-text">24</small>
                </a>
            </div>
            <hr class="my-3 text-secondary">
            <div class="row g-0 justify-content-center">
                <div class="col-8 col-md-9 px-1 py-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Kata Kunci">
                    </div>
                </div>
                <div class="col-4 col-md-3 px-1 py-3">
                    <button type="button" class="btn btn-primary w-100"><small>TELUSURI</small></button>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Di mobile (default) selebar 12 kolom (full), di desktop/tablet (md) selebar 8 kolom -->
            <div class="col-12 col-md-8">
                <div class="shadow p-4 mb-3 bg-white rounded">
                    <div class="d-flex flex-wrap mb-2">
                        <a href="#" type="button" class="btn btn-outline-ungu m-1 btn-sm">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_848_1752)">
                                    <path d="M7.00009 12.8333C10.2218 12.8333 12.8334 10.2217 12.8334 6.99996C12.8334 3.77821 10.2218 1.16663 7.00009 1.16663C3.77834 1.16663 1.16675 3.77821 1.16675 6.99996C1.16544 8.15382 1.50738 9.28199 2.14909 10.241C2.22006 10.3469 2.08706 11.0166 1.75009 12.25C2.98364 11.913 3.65331 11.78 3.75909 11.851C4.71805 12.4927 5.84622 12.8346 7.00009 12.8333Z" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linejoin="round" />
                                    <path d="M4.8431 5.78079H9.73697M6.37202 4.59021L5.5221 9.40971M8.41368 4.59021L7.56377 9.40971M4.25977 8.16663H9.15364" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_848_1752">
                                        <rect width="14" height="14" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            Berita Dan Perkembangan
                        </a>
                        <a href="#" type="button" class="btn btn-outline-danger m-1 btn-sm">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.5 8.125C8.53553 8.125 9.375 7.28553 9.375 6.25C9.375 5.21447 8.53553 4.375 7.5 4.375C6.46447 4.375 5.625 5.21447 5.625 6.25C5.625 7.28553 6.46447 8.125 7.5 8.125Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M3.96447 2.71447C4.90215 1.77678 6.17392 1.25 7.5 1.25C8.82608 1.25 10.0979 1.77678 11.0355 2.71447C11.9732 3.65215 12.5 4.92392 12.5 6.25C12.5 7.4325 12.2487 8.20625 11.5625 9.0625L7.5 13.75L3.4375 9.0625C2.75125 8.20625 2.5 7.4325 2.5 6.25C2.5 4.92392 3.02678 3.65215 3.96447 2.71447Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            Nias Utara
                        </a>
                    </div>
                    <h3 class="fw-bold">
                        KREASI Nias Utara Perkuat Kapasitas Penggerak Pendidikan melalui Pelatihan Fasilitator Daerah dan Kepala Sekolah
                    </h3>
                    <div class="mb-2 py-2">
                        <p>Sejak mulai mengabdi sebagai guru pada tahun 2007, Karmawati selalu memegang satu keyakinan: setiap anak berhak mendapatkan pendidikan yang layak. Baginya,
                            menjadi pendidik bukan hanya tentang mengajar di ruang kelas,
                            tetapi juga tentang menumbuhkan harapan, terutama bagi anak-anak yang belum sepenuhnya memiliki kesempatan dan dukungan untuk belajar.
                            Semangat itulah yang terus ia bawa hingga kini, ketika ia menjalankan peran sebagai guru sekaligus kepala sekolah dampingan Program KREASI di
                            Kabupaten Kayong Utara.</p>
                    </div>
                    <button type="button" class="btn btn-danger px-2"><small>SELENGKAPNYA</small></button>
                </div>
            </div>

            <!-- Di mobile (default) selebar 12 kolom (full), di desktop/tablet (md) selebar 4 kolom -->
            <div class="col-12 col-md-4">
                <div class="px-4 mb-3">
                    <div>
                        <div class="d-flex flex-wrap mb-2">
                            <a href="#" type="button" class="btn btn-outline-ungu m-1 btn-sm">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_848_1752)">
                                        <path d="M7.00009 12.8333C10.2218 12.8333 12.8334 10.2217 12.8334 6.99996C12.8334 3.77821 10.2218 1.16663 7.00009 1.16663C3.77834 1.16663 1.16675 3.77821 1.16675 6.99996C1.16544 8.15382 1.50738 9.28199 2.14909 10.241C2.22006 10.3469 2.08706 11.0166 1.75009 12.25C2.98364 11.913 3.65331 11.78 3.75909 11.851C4.71805 12.4927 5.84622 12.8346 7.00009 12.8333Z" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linejoin="round" />
                                        <path d="M4.8431 5.78079H9.73697M6.37202 4.59021L5.5221 9.40971M8.41368 4.59021L7.56377 9.40971M4.25977 8.16663H9.15364" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_848_1752">
                                            <rect width="14" height="14" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                Berita Dan Perkembangan
                            </a>
                            <a href="#" type="button" class="btn btn-outline-danger m-1 btn-sm">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 8.125C8.53553 8.125 9.375 7.28553 9.375 6.25C9.375 5.21447 8.53553 4.375 7.5 4.375C6.46447 4.375 5.625 5.21447 5.625 6.25C5.625 7.28553 6.46447 8.125 7.5 8.125Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3.96447 2.71447C4.90215 1.77678 6.17392 1.25 7.5 1.25C8.82608 1.25 10.0979 1.77678 11.0355 2.71447C11.9732 3.65215 12.5 4.92392 12.5 6.25C12.5 7.4325 12.2487 8.20625 11.5625 9.0625L7.5 13.75L3.4375 9.0625C2.75125 8.20625 2.5 7.4325 2.5 6.25C2.5 4.92392 3.02678 3.65215 3.96447 2.71447Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                Nias Utara
                            </a>
                        </div>
                        <h3 class="fw-bold">
                            Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman
                        </h3>

                        <div class="mb-2 py-2">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_848_906)">
                                    <path d="M10.875 12H1.125C0.5025 12 0 11.4975 0 10.875V1.875C0 1.2525 0.5025 0.75 1.125 0.75H10.875C11.4975 0.75 12 1.2525 12 1.875V10.875C12 11.4975 11.4975 12 10.875 12ZM1.125 1.5C0.915 1.5 0.75 1.665 0.75 1.875V10.875C0.75 11.085 0.915 11.25 1.125 11.25H10.875C11.085 11.25 11.25 11.085 11.25 10.875V1.875C11.25 1.665 11.085 1.5 10.875 1.5H1.125Z" fill="black" fill-opacity="0.5" />
                                    <path d="M3.375 3C3.165 3 3 2.835 3 2.625V0.375C3 0.165 3.165 0 3.375 0C3.585 0 3.75 0.165 3.75 0.375V2.625C3.75 2.835 3.585 3 3.375 3ZM8.625 3C8.415 3 8.25 2.835 8.25 2.625V0.375C8.25 0.165 8.415 0 8.625 0C8.835 0 9 0.165 9 0.375V2.625C9 2.835 8.835 3 8.625 3ZM11.625 4.5H0.375C0.165 4.5 0 4.335 0 4.125C0 3.915 0.165 3.75 0.375 3.75H11.625C11.835 3.75 12 3.915 12 4.125C12 4.335 11.835 4.5 11.625 4.5Z" fill="black" fill-opacity="0.5" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_848_906">
                                        <rect width="12" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>

                            <small class="text-secondary">20 Juli 2026</small>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex flex-wrap mb-2">
                            <a href="#" type="button" class="btn btn-outline-ungu m-1 btn-sm">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_848_1752)">
                                        <path d="M7.00009 12.8333C10.2218 12.8333 12.8334 10.2217 12.8334 6.99996C12.8334 3.77821 10.2218 1.16663 7.00009 1.16663C3.77834 1.16663 1.16675 3.77821 1.16675 6.99996C1.16544 8.15382 1.50738 9.28199 2.14909 10.241C2.22006 10.3469 2.08706 11.0166 1.75009 12.25C2.98364 11.913 3.65331 11.78 3.75909 11.851C4.71805 12.4927 5.84622 12.8346 7.00009 12.8333Z" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linejoin="round" />
                                        <path d="M4.8431 5.78079H9.73697M6.37202 4.59021L5.5221 9.40971M8.41368 4.59021L7.56377 9.40971M4.25977 8.16663H9.15364" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_848_1752">
                                            <rect width="14" height="14" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                Berita Dan Perkembangan
                            </a>
                            <a href="#" type="button" class="btn btn-outline-danger m-1 btn-sm">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 8.125C8.53553 8.125 9.375 7.28553 9.375 6.25C9.375 5.21447 8.53553 4.375 7.5 4.375C6.46447 4.375 5.625 5.21447 5.625 6.25C5.625 7.28553 6.46447 8.125 7.5 8.125Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3.96447 2.71447C4.90215 1.77678 6.17392 1.25 7.5 1.25C8.82608 1.25 10.0979 1.77678 11.0355 2.71447C11.9732 3.65215 12.5 4.92392 12.5 6.25C12.5 7.4325 12.2487 8.20625 11.5625 9.0625L7.5 13.75L3.4375 9.0625C2.75125 8.20625 2.5 7.4325 2.5 6.25C2.5 4.92392 3.02678 3.65215 3.96447 2.71447Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                Nias Utara
                            </a>
                        </div>
                        <h3 class="fw-bold">
                            Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman
                        </h3>

                        <div class="mb-2 py-2">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_848_906)">
                                    <path d="M10.875 12H1.125C0.5025 12 0 11.4975 0 10.875V1.875C0 1.2525 0.5025 0.75 1.125 0.75H10.875C11.4975 0.75 12 1.2525 12 1.875V10.875C12 11.4975 11.4975 12 10.875 12ZM1.125 1.5C0.915 1.5 0.75 1.665 0.75 1.875V10.875C0.75 11.085 0.915 11.25 1.125 11.25H10.875C11.085 11.25 11.25 11.085 11.25 10.875V1.875C11.25 1.665 11.085 1.5 10.875 1.5H1.125Z" fill="black" fill-opacity="0.5" />
                                    <path d="M3.375 3C3.165 3 3 2.835 3 2.625V0.375C3 0.165 3.165 0 3.375 0C3.585 0 3.75 0.165 3.75 0.375V2.625C3.75 2.835 3.585 3 3.375 3ZM8.625 3C8.415 3 8.25 2.835 8.25 2.625V0.375C8.25 0.165 8.415 0 8.625 0C8.835 0 9 0.165 9 0.375V2.625C9 2.835 8.835 3 8.625 3ZM11.625 4.5H0.375C0.165 4.5 0 4.335 0 4.125C0 3.915 0.165 3.75 0.375 3.75H11.625C11.835 3.75 12 3.915 12 4.125C12 4.335 11.835 4.5 11.625 4.5Z" fill="black" fill-opacity="0.5" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_848_906">
                                        <rect width="12" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>

                            <small class="text-secondary">20 Juli 2026</small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-12 col-md-4">
                    <div class="px-4 mb-3">
                        <div>
                            <!-- Konten 1 -->
                            <div class="d-flex flex-wrap mb-2">
                                <a href="#" type="button" class="btn btn-outline-ungu m-1 btn-sm">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_848_1752)">
                                            <path d="M7.00009 12.8333C10.2218 12.8333 12.8334 10.2217 12.8334 6.99996C12.8334 3.77821 10.2218 1.16663 7.00009 1.16663C3.77834 1.16663 1.16675 3.77821 1.16675 6.99996C1.16544 8.15382 1.50738 9.28199 2.14909 10.241C2.22006 10.3469 2.08706 11.0166 1.75009 12.25C2.98364 11.913 3.65331 11.78 3.75909 11.851C4.71805 12.4927 5.84622 12.8346 7.00009 12.8333Z" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linejoin="round" />
                                            <path d="M4.8431 5.78079H9.73697M6.37202 4.59021L5.5221 9.40971M8.41368 4.59021L7.56377 9.40971M4.25977 8.16663H9.15364" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_848_1752">
                                                <rect width="14" height="14" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    Berita Dan Perkembangan
                                </a>
                                <a href="#" type="button" class="btn btn-outline-danger m-1 btn-sm">
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.5 8.125C8.53553 8.125 9.375 7.28553 9.375 6.25C9.375 5.21447 8.53553 4.375 7.5 4.375C6.46447 4.375 5.625 5.21447 5.625 6.25C5.625 7.28553 6.46447 8.125 7.5 8.125Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M3.96447 2.71447C4.90215 1.77678 6.17392 1.25 7.5 1.25C8.82608 1.25 10.0979 1.77678 11.0355 2.71447C11.9732 3.65215 12.5 4.92392 12.5 6.25C12.5 7.4325 12.2487 8.20625 11.5625 9.0625L7.5 13.75L3.4375 9.0625C2.75125 8.20625 2.5 7.4325 2.5 6.25C2.5 4.92392 3.02678 3.65215 3.96447 2.71447Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Nias Utara
                                </a>
                            </div>
                            <h3 class="fw-bold">
                                Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman
                            </h3>

                            <div class="mb-2 py-2">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_848_906)">
                                        <path d="M10.875 12H1.125C0.5025 12 0 11.4975 0 10.875V1.875C0 1.2525 0.5025 0.75 1.125 0.75H10.875C11.4975 0.75 12 1.2525 12 1.875V10.875C12 11.4975 11.4975 12 10.875 12ZM1.125 1.5C0.915 1.5 0.75 1.665 0.75 1.875V10.875C0.75 11.085 0.915 11.25 1.125 11.25H10.875C11.085 11.25 11.25 11.085 11.25 10.875V1.875C11.25 1.665 11.085 1.5 10.875 1.5H1.125Z" fill="black" fill-opacity="0.5" />
                                        <path d="M3.375 3C3.165 3 3 2.835 3 2.625V0.375C3 0.165 3.165 0 3.375 0C3.585 0 3.75 0.165 3.75 0.375V2.625C3.75 2.835 3.585 3 3.375 3ZM8.625 3C8.415 3 8.25 2.835 8.25 2.625V0.375C8.25 0.165 8.415 0 8.625 0C8.835 0 9 0.165 9 0.375V2.625C9 2.835 8.835 3 8.625 3ZM11.625 4.5H0.375C0.165 4.5 0 4.335 0 4.125C0 3.915 0.165 3.75 0.375 3.75H11.625C11.835 3.75 12 3.915 12 4.125C12 4.335 11.835 4.5 11.625 4.5Z" fill="black" fill-opacity="0.5" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_848_906">
                                            <rect width="12" height="12" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>

                                <small class="text-secondary">20 Juli 2026</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2 -->
                <div class="col-12 col-md-4">
                    <div class="px-4 mb-3">
                        <div>
                            <!-- Konten 2 -->
                            <div class="d-flex flex-wrap mb-2">
                                <a href="#" type="button" class="btn btn-outline-ungu m-1 btn-sm">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_848_1752)">
                                            <path d="M7.00009 12.8333C10.2218 12.8333 12.8334 10.2217 12.8334 6.99996C12.8334 3.77821 10.2218 1.16663 7.00009 1.16663C3.77834 1.16663 1.16675 3.77821 1.16675 6.99996C1.16544 8.15382 1.50738 9.28199 2.14909 10.241C2.22006 10.3469 2.08706 11.0166 1.75009 12.25C2.98364 11.913 3.65331 11.78 3.75909 11.851C4.71805 12.4927 5.84622 12.8346 7.00009 12.8333Z" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linejoin="round" />
                                            <path d="M4.8431 5.78079H9.73697M6.37202 4.59021L5.5221 9.40971M8.41368 4.59021L7.56377 9.40971M4.25977 8.16663H9.15364" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_848_1752">
                                                <rect width="14" height="14" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    Berita Dan Perkembangan
                                </a>
                                <a href="#" type="button" class="btn btn-outline-danger m-1 btn-sm">
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.5 8.125C8.53553 8.125 9.375 7.28553 9.375 6.25C9.375 5.21447 8.53553 4.375 7.5 4.375C6.46447 4.375 5.625 5.21447 5.625 6.25C5.625 7.28553 6.46447 8.125 7.5 8.125Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M3.96447 2.71447C4.90215 1.77678 6.17392 1.25 7.5 1.25C8.82608 1.25 10.0979 1.77678 11.0355 2.71447C11.9732 3.65215 12.5 4.92392 12.5 6.25C12.5 7.4325 12.2487 8.20625 11.5625 9.0625L7.5 13.75L3.4375 9.0625C2.75125 8.20625 2.5 7.4325 2.5 6.25C2.5 4.92392 3.02678 3.65215 3.96447 2.71447Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Nias Utara
                                </a>
                            </div>
                            <h3 class="fw-bold">
                                Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman
                            </h3>

                            <div class="mb-2 py-2">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_848_906)">
                                        <path d="M10.875 12H1.125C0.5025 12 0 11.4975 0 10.875V1.875C0 1.2525 0.5025 0.75 1.125 0.75H10.875C11.4975 0.75 12 1.2525 12 1.875V10.875C12 11.4975 11.4975 12 10.875 12ZM1.125 1.5C0.915 1.5 0.75 1.665 0.75 1.875V10.875C0.75 11.085 0.915 11.25 1.125 11.25H10.875C11.085 11.25 11.25 11.085 11.25 10.875V1.875C11.25 1.665 11.085 1.5 10.875 1.5H1.125Z" fill="black" fill-opacity="0.5" />
                                        <path d="M3.375 3C3.165 3 3 2.835 3 2.625V0.375C3 0.165 3.165 0 3.375 0C3.585 0 3.75 0.165 3.75 0.375V2.625C3.75 2.835 3.585 3 3.375 3ZM8.625 3C8.415 3 8.25 2.835 8.25 2.625V0.375C8.25 0.165 8.415 0 8.625 0C8.835 0 9 0.165 9 0.375V2.625C9 2.835 8.835 3 8.625 3ZM11.625 4.5H0.375C0.165 4.5 0 4.335 0 4.125C0 3.915 0.165 3.75 0.375 3.75H11.625C11.835 3.75 12 3.915 12 4.125C12 4.335 11.835 4.5 11.625 4.5Z" fill="black" fill-opacity="0.5" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_848_906">
                                            <rect width="12" height="12" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>

                                <small class="text-secondary">20 Juli 2026</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 3 -->
                <div class="col-12 col-md-4">
                    <div class="px-4 mb-3">
                        <div>
                            <!-- Konten 3 -->
                            <div class="d-flex flex-wrap mb-2">
                                <a href="#" type="button" class="btn btn-outline-ungu m-1 btn-sm">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_848_1752)">
                                            <path d="M7.00009 12.8333C10.2218 12.8333 12.8334 10.2217 12.8334 6.99996C12.8334 3.77821 10.2218 1.16663 7.00009 1.16663C3.77834 1.16663 1.16675 3.77821 1.16675 6.99996C1.16544 8.15382 1.50738 9.28199 2.14909 10.241C2.22006 10.3469 2.08706 11.0166 1.75009 12.25C2.98364 11.913 3.65331 11.78 3.75909 11.851C4.71805 12.4927 5.84622 12.8346 7.00009 12.8333Z" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linejoin="round" />
                                            <path d="M4.8431 5.78079H9.73697M6.37202 4.59021L5.5221 9.40971M8.41368 4.59021L7.56377 9.40971M4.25977 8.16663H9.15364" stroke="#062172" stroke-opacity="0.7" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_848_1752">
                                                <rect width="14" height="14" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    Berita Dan Perkembangan
                                </a>
                                <a href="#" type="button" class="btn btn-outline-danger m-1 btn-sm">
                                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.5 8.125C8.53553 8.125 9.375 7.28553 9.375 6.25C9.375 5.21447 8.53553 4.375 7.5 4.375C6.46447 4.375 5.625 5.21447 5.625 6.25C5.625 7.28553 6.46447 8.125 7.5 8.125Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M3.96447 2.71447C4.90215 1.77678 6.17392 1.25 7.5 1.25C8.82608 1.25 10.0979 1.77678 11.0355 2.71447C11.9732 3.65215 12.5 4.92392 12.5 6.25C12.5 7.4325 12.2487 8.20625 11.5625 9.0625L7.5 13.75L3.4375 9.0625C2.75125 8.20625 2.5 7.4325 2.5 6.25C2.5 4.92392 3.02678 3.65215 3.96447 2.71447Z" stroke="#DA291C" stroke-opacity="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    Nias Utara
                                </a>
                            </div>
                            <h3 class="fw-bold">
                                Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman
                            </h3>

                            <div class="mb-2 py-2">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_848_906)">
                                        <path d="M10.875 12H1.125C0.5025 12 0 11.4975 0 10.875V1.875C0 1.2525 0.5025 0.75 1.125 0.75H10.875C11.4975 0.75 12 1.2525 12 1.875V10.875C12 11.4975 11.4975 12 10.875 12ZM1.125 1.5C0.915 1.5 0.75 1.665 0.75 1.875V10.875C0.75 11.085 0.915 11.25 1.125 11.25H10.875C11.085 11.25 11.25 11.085 11.25 10.875V1.875C11.25 1.665 11.085 1.5 10.875 1.5H1.125Z" fill="black" fill-opacity="0.5" />
                                        <path d="M3.375 3C3.165 3 3 2.835 3 2.625V0.375C3 0.165 3.165 0 3.375 0C3.585 0 3.75 0.165 3.75 0.375V2.625C3.75 2.835 3.585 3 3.375 3ZM8.625 3C8.415 3 8.25 2.835 8.25 2.625V0.375C8.25 0.165 8.415 0 8.625 0C8.835 0 9 0.165 9 0.375V2.625C9 2.835 8.835 3 8.625 3ZM11.625 4.5H0.375C0.165 4.5 0 4.335 0 4.125C0 3.915 0.165 3.75 0.375 3.75H11.625C11.835 3.75 12 3.915 12 4.125C12 4.335 11.835 4.5 11.625 4.5Z" fill="black" fill-opacity="0.5" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_848_906">
                                            <rect width="12" height="12" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>

                                <small class="text-secondary">20 Juli 2026</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
