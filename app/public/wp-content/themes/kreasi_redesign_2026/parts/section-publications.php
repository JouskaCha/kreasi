<?php

/**
 * Template Part: Section Publikasi (Red Background + Publication Cards Grid & 3D Layer Hover Effect)
 */
?>
<section class="publications-section py-5 text-white position-relative overflow-hidden" style="background-color: #D8232A;">
    <div class="container py-lg-4">
        <div class="row align-items-center gy-4">

            <!-- SISI KIRI: TITLE, SUBTITLE & CTA BUTTON -->
            <div class="col-lg-4 col-md-12">
                <h2 class="text-white text-uppercase mb-3" style="font-size: 64px; letter-spacing: 2px;">
                    PUBLIKASI
                </h2>
                <p class="text-white mb-4" style="font-family: 'Lato', sans-serif; font-size: 14px; opacity: 0.95;">
                    Dari buletin bulanan, hingga berbagai bahan ajar seperti poster, dan permainan, terus kami buat untuk mendukung implementasi program.
                </p>
                <a href="<?php echo esc_url(home_url('/pustaka')); ?>" 
                   class="btn text-white px-4 py-3 text-uppercase shadow-sm publications-cta-btn d-inline-flex align-items-center justify-content-center" 
                   style="background-color: #0E2A5D; border-radius: 6px; font-family: 'Oswald', sans-serif; font-size: 12px; letter-spacing: 0.5px; transition: all 0.35s ease;">
                    <span>LIHAT PUBLIKASI LAINNYA</span>
                    <span class="btn-arrow ms-2">→</span>
                </a>
            </div>

            <!-- SISI KANAN: 4 CARDS PUBLIKASI GRID (HORIZONTAL SCROLL PEEK DI MOBILE, 4 KOLOM DI DESKTOP) -->
            <div class="col-lg-8 col-md-12">
                <div class="row row-cols-2 row-cols-md-4 g-3 flex-nowrap overflow-x-auto flex-md-wrap pb-3 pb-md-0 mobile-horizontal-scroll">
                    <?php
                    $publications = array(
                        array(
                            'title' => 'Nota Kesepahaman (MoU) Save the Children dan Kementerian Pendidikan D...',
                            'tag'   => 'Buletin',
                            'img'   => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=400&auto=format&fit=crop'
                        ),
                        array(
                            'title' => 'Nota Kesepahaman (MoU) Save the Children dan Kementerian Pendidikan D...',
                            'tag'   => 'Buletin',
                            'img'   => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=400&auto=format&fit=crop'
                        ),
                        array(
                            'title' => '4 Kata Ajaib - Poster KREASI July 2026',
                            'tag'   => 'Buletin',
                            'img'   => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=400&auto=format&fit=crop'
                        ),
                        array(
                            'title' => 'Jejak KREASI - Maret 2026',
                            'tag'   => 'Buletin',
                            'img'   => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=400&auto=format&fit=crop'
                        ),
                    );

                    foreach ($publications as $pub) :
                    ?>
                        <div class="col-7 col-sm-4 col-md-3 flex-shrink-0 flex-md-shrink-1">
                            <div class="publication-card d-flex flex-column h-100 position-relative">

                                <!-- COVER IMAGE CONTAINER WITH 3D LAYER SHADOW -->
                                <div class="publication-cover-wrap position-relative mb-2" style="height: 220px;">
                                    <!-- 3D RED STACKED SHADOW LAYER -->
                                    <div class="pub-cover-shadow position-absolute rounded-3" 
                                         style="top: 6px; left: 6px; width: 100%; height: 100%; background-color: #ffffff; opacity: 30%; border: 1px solid rgba(0,0,0,0.15); z-index: 1; transition: all 0.3s ease;"></div>
                                    
                                    <!-- MAIN COVER IMAGE -->
                                    <div class="pub-cover-main position-absolute top-0 start-0 w-100 h-100 rounded-3 overflow-hidden shadow-sm"
                                        style="background-color: #ffffff; z-index: 2; transition: all 0.3s ease;">
                                        <img src="<?php echo esc_url($pub['img']); ?>"
                                            alt="<?php echo esc_attr($pub['title']); ?>"
                                            class="w-100 h-100 object-fit-cover pub-cover-img"
                                            style="transition: transform 0.4s ease;">
                                    </div>
                                </div>

                                <!-- TAG BADGE -->
                                <div class="mb-1">
                                    <span class="badge border border-white text-white rounded-pill fw-normal" style="font-family: 'Lato', sans-serif; font-size: 10px; padding: 3px 8px;">
                                        📁 <?php echo esc_html($pub['tag']); ?>
                                    </span>
                                </div>

                                <!-- TITLE -->
                                <p class="text-white small fw-medium mb-0" style="font-size: 12px; line-height: 1.4; display: -webkit-box; line-clamp: 2; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo esc_html($pub['title']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- STYLING HOVER PUBLIKASI & SEMBUNYIKAN SCROLLBAR -->
<style>
    /* 1. SEMBUNYIKAN SCROLLBAR DI SEMUA PERANGKAT (DESKTOP & MOBILE) */
    .mobile-horizontal-scroll {
        scrollbar-width: none !important; /* Firefox */
        -ms-overflow-style: none !important; /* IE & Edge */
    }

    .mobile-horizontal-scroll::-webkit-scrollbar {
        display: none !important; /* Chrome, Safari, Opera */
        width: 0 !important;
        height: 0 !important;
    }

    /* MOBILE HORIZONTAL SCROLL PEEK */
    @media (max-width: 767.98px) {
        .mobile-horizontal-scroll {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .mobile-horizontal-scroll > div {
            scroll-snap-align: start;
        }
    }

    /* 2. ANIMASI HOVER KARTU PUBLIKASI */
    .publication-card {
        cursor: pointer;
    }

    .publication-card .pub-cover-main {
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        transform-origin: center center;
    }

    .publication-card .pub-cover-shadow {
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease, background-color 0.4s ease;
        transform-origin: center center;
    }

    .publication-card .pub-cover-img {
        transition: transform 0.4s ease;
    }

    /* SAAT HOVER: COVER ROTATE KE KIRI SEDIKIT */
    .publication-card:hover .pub-cover-main {
        transform: translate(-5px, -6px) rotate(-3deg);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35) !important;
    }

    /* SAAT HOVER: SHADOW ROTATE KE KANAN SEDIKIT */
    .publication-card:hover .pub-cover-shadow {
        transform: translate(6px, 8px) rotate(3.5deg);
        opacity: 0.5;
        background-color: #ffffff !important;
    }

    .publication-card:hover .pub-cover-img {
        transform: scale(1.04);
    }

    /* 3. TOMBOL LIHAT PUBLIKASI LAINNYA (PANAH MASUK DARI KANAN) */
    .publications-cta-btn {
        overflow: hidden;
        position: relative;
    }

    .publications-cta-btn .btn-arrow {
        display: inline-block;
        opacity: 0;
        transform: translateX(14px);
        max-width: 0;
        white-space: nowrap;
        transition: opacity 0.35s ease, transform 0.35s ease, max-width 0.35s ease;
    }

    .publications-cta-btn:hover {
        background-color: #06173E !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(6, 23, 62, 0.4) !important;
    }

    .publications-cta-btn:hover .btn-arrow {
        opacity: 1;
        transform: translateX(0);
        max-width: 20px;
    }
</style>