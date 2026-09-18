<?php get_header(); ?>


<main>

<?php
// Build array of active slides from Customizer
$slides = array();
for ($i = 1; $i <= 4; $i++) {
    $media = get_theme_mod('hero_slide_' . $i . '_media');
    if (!empty($media)) {
        $slides[] = array(
            'media'     => $media,
            'title'     => get_theme_mod('hero_slide_' . $i . '_title', ''),
            'link'      => get_theme_mod('hero_slide_' . $i . '_link', '#'),
            'link_text' => get_theme_mod('hero_slide_' . $i . '_link_text', 'READ MORE'),
        );
    }
}

// Fallback if no specific slides are defined in Customizer
if (empty($slides)) {
    $hero_image = get_theme_mod('hero_image');
    if (empty($hero_image)) {
        $hero_image = get_template_directory_uri() . '/assets/images/hero.jpg';
    }
    $slides[] = array(
        'media'     => $hero_image,
        'title'     => 'GURU DI PESISIR BARAT MENYULAP RUANG<br>SEDERHANA MENJADI PERPUSTAKAAN',
        'link'      => '#',
        'link_text' => 'READ MORE',
    );
}

$interval = get_theme_mod('hero_slider_interval', 6000);
?>

    <!-- HERO SECTION SLIDER (IMAGE & VIDEO) -->
    <section class="hero-section position-relative overflow-hidden" style="height: 450px;">
        <div id="heroCarousel" class="carousel slide carousel-fade h-100 position-relative" data-bs-ride="carousel" data-bs-interval="<?php echo esc_attr($interval); ?>">
            
            <!-- CAROUSEL SLIDES -->
            <div class="carousel-inner h-100">
                <?php foreach ($slides as $index => $slide) : 
                    $is_active = ($index === 0) ? 'active' : '';
                    $is_video  = function_exists('customtheme_is_video_url') && customtheme_is_video_url($slide['media']);
                ?>
                    <div class="carousel-item <?php echo esc_attr($is_active); ?> h-100 position-relative">
                        
                        <!-- MEDIA (VIDEO OR IMAGE BACKGROUND) -->
                        <?php if ($is_video) : ?>
                            <video autoplay loop muted playsinline 
                                   class="position-absolute top-0 start-0 w-100 h-100 hero-bg-media" 
                                   style="object-fit: cover; z-index: 0; pointer-events: none;">
                                <source src="<?php echo esc_url($slide['media']); ?>">
                                Your browser does not support the video tag.
                            </video>
                        <?php else : ?>
                            <img src="<?php echo esc_url($slide['media']); ?>" 
                                 alt="<?php echo esc_attr(strip_tags($slide['title'])); ?>" 
                                 class="position-absolute top-0 start-0 w-100 h-100 hero-bg-media" 
                                 style="object-fit: cover; z-index: 0; pointer-events: none;">
                        <?php endif; ?>

                        <!-- DARK OVERLAY FOR READABILITY -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 hero-bg-overlay" 
                             style="background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.55) 100%); z-index: 1; pointer-events: none;"></div>

                        <!-- CONTENT LAYER (TEXT & LINK ON TOP) -->
                        <div class="container-fluid px-5 position-relative h-100 d-flex align-items-end pb-5 hero-content-layer" style="z-index: 5;">
                            <div class="text-white mb-4 position-relative" style="max-width: 700px; z-index: 6;">
                                <?php if (!empty($slide['title'])) : ?>
                                    <h1 class="fw-bold text-white mb-0" style="font-size: 36px; line-height: 1.15; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">
                                        <?php echo wp_kses_post($slide['title']); ?>
                                    </h1>
                                <?php endif; ?>

                                <?php if (!empty($slide['link'])) : ?>
                                    <a href="<?php echo esc_url($slide['link']); ?>" 
                                       class="text-white text-decoration-none d-inline-flex align-items-center" 
                                       style="margin-top: 20px; font-size: 10px; font-weight: 600; position: relative; z-index: 7;">
                                        <?php echo esc_html($slide['link_text'] ? $slide['link_text'] : 'READ MORE'); ?>
                                        <span class="ms-2" style="font-size: 15px;">→</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- CAROUSEL INDICATORS (Pill & Dots) -->
            <?php if (count($slides) > 1) : ?>
                <div class="carousel-indicators position-absolute d-flex align-items-center m-0" style="left: 50px; bottom: 30px; gap: 6px; justify-content: flex-start; width: auto; z-index: 3;">
                    <?php foreach ($slides as $index => $slide) : 
                        $is_active = ($index === 0) ? 'active' : '';
                    ?>
                        <button type="button" 
                                data-bs-target="#heroCarousel" 
                                data-bs-slide-to="<?php echo esc_attr($index); ?>" 
                                class="hero-indicator-btn <?php echo esc_attr($is_active); ?>" 
                                aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                                aria-label="Slide <?php echo esc_attr($index + 1); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- STYLING UNTUK INDICATOR PILL DESAIN FIGMA -->
    <style>
    .hero-indicator-btn {
        width: 8px !important;
        height: 8px !important;
        border-radius: 50% !important;
        background-color: rgba(255, 255, 255, 0.5) !important;
        border: none !important;
        opacity: 1 !important;
        margin: 0 !important;
        padding: 0 !important;
        transition: all 0.3s ease-in-out !important;
    }
    .hero-indicator-btn.active {
        width: 25px !important;
        border-radius: 5px !important;
        background-color: #ffffff !important;
    }
    </style>


    <!-- ==========================================
         SECTION 2: ABOUT PROGRAM (UNTUK PENDIDIKAN YANG BERKUALITAS)
    =========================================== -->
    <section class="about-section py-5 bg-white position-relative overflow-hidden">
        <!-- DECORATIVE WAVE BACKGROUND WATERMARK -->
        <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none opacity-25" 
             style="background-image: radial-gradient(circle at 10% 20%, rgba(14, 42, 93, 0.05) 0%, transparent 60%);"></div>

        <div class="container py-lg-4 position-relative z-1">
            <div class="row align-items-center gy-4">
                
                <!-- SISI KIRI: HEADING & CTA BUTTON -->
                <div class="col-lg-5 col-md-12">
                    <h2 class="fw-bold mb-4" style="color: #0E2A5D; font-size: 38px; line-height: 1.15; letter-spacing: -0.5px;">
                        UNTUK PENDIDIKAN<br>YANG <span style="color: #D8232A;">BERKUALITAS</span>
                    </h2>
                    
                    <a href="<?php echo esc_url(home_url('/tentang-kami')); ?>" 
                       class="btn text-white fw-bold px-4 py-3 text-uppercase shadow-sm about-cta-btn" 
                       style="background-color: #D8232A; border-radius: 6px; font-size: 13px; letter-spacing: 0.5px; transition: all 0.3s ease;">
                        SELENGKAPNYA TENTANG KAMI
                    </a>
                </div>

                <!-- SISI KANAN: PARAGRAF DESKRIPSI -->
                <div class="col-lg-7 col-md-12">
                    <p class="mb-0" style="font-size: 15px; line-height: 1.75; color: #333333;">
                        <strong>KREASI</strong> atau <strong>Kolaborasi untuk Edukasi Anak Indonesia</strong> adalah program peningkatan kualitas pendidikan dengan memperkuat literasi, numerasi, dan pendidikan karakter di delapan kabupaten di empat provinsi di Indonesia. KREASI dikelola Save the Children, diimplementasi mitra pelaksana lokal, dengan pendanaan Global Partnership for Education (GPE) dan didukung Mitra Pendidikan Indonesia yang dipimpin Kementerian Pendidikan Dasar dan Menengah (Kemendikdasmen) dan Kementerian Agama (Kemenag).
                    </p>
                </div>

            </div>
        </div>
    </section>


    <!-- ==========================================
         SECTION 3: IMPACT & STATISTICS (MEMBAWA PERUBAHAN KE PELOSOK)
    =========================================== -->
    <section class="impact-section py-5 text-white" style="background-color: #D8232A;">
        <div class="container py-lg-4">
            
            <!-- HEADER SECTION -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-white text-uppercase mb-2" style="font-size: 34px; letter-spacing: 0.5px;">
                    MEMBAWA PERUBAHAN KE PELOSOK
                </h2>
                <p class="text-white mb-0" style="font-size: 15px; opacity: 0.9; max-width: 720px; margin-left: auto; margin-right: auto;">
                    Dari advokasi untuk kebijakan pendidikan yang lebih baik, hingga ke ruang kelas yang menyenangkan.
                </p>
            </div>

            <!-- 4 KARTU STATISTIK GRID -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                
                <?php
                $default_cards = array(
                    array(
                        'number'   => '50,000',
                        'label'    => 'Murid',
                        'desc'     => 'Mendapatkan akses buku berkualitas dan ruang baca yang nyaman untuk menumbuhkan kecintaan pada literasi sejak dini.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-murid.jpg',
                        'fallback' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'number'   => '4,000',
                        'label'    => 'Guru',
                        'desc'     => 'Mendapatkan pelatihan metode pembelajaran kreatif dan efektif untuk meningkatkan kualitas pengajaran di kelas.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-guru.jpg',
                        'fallback' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'number'   => '560',
                        'label'    => 'Kepala Sekolah',
                        'desc'     => 'Mendapatkan pendampingan manajemen kepemimpinan sekolah dan tata kelola pendidikan yang inklusif.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-kepala-sekolah.jpg',
                        'fallback' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'number'   => '560',
                        'label'    => 'Sekolah',
                        'desc'     => 'Menerima perbaikan fasilitas perpustakaan, sarana belajar, dan ruang kelas yang kondusif untuk siswa.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-sekolah.jpg',
                        'fallback' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=600&auto=format&fit=crop'
                    ),
                );

                for ($i = 1; $i <= 4; $i++) {
                    $custom_img    = get_theme_mod('impact_card_' . $i . '_image');
                    $custom_number = get_theme_mod('impact_card_' . $i . '_number');
                    $custom_label  = get_theme_mod('impact_card_' . $i . '_label');
                    $custom_desc   = get_theme_mod('impact_card_' . $i . '_desc');

                    $card_img  = !empty($custom_img) ? $custom_img : $default_cards[$i - 1]['image'];
                    $card_num  = !empty($custom_number) ? $custom_number : $default_cards[$i - 1]['number'];
                    $card_lbl  = !empty($custom_label) ? $custom_label : $default_cards[$i - 1]['label'];
                    $card_desc = !empty($custom_desc) ? $custom_desc : $default_cards[$i - 1]['desc'];
                    $fallback  = $default_cards[$i - 1]['fallback'];
                ?>

                    <div class="col">
                        <div class="card impact-card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="height: 380px;">
                            <!-- BACKGROUND IMAGE -->
                            <img src="<?php echo esc_url($card_img); ?>" 
                                 alt="<?php echo esc_attr($card_lbl); ?>" 
                                 class="position-absolute top-0 start-0 w-100 h-100 impact-card-img" 
                                 style="object-fit: cover; transition: transform 0.4s ease-out, filter 0.4s ease;"
                                 onerror="this.src='<?php echo esc_url($fallback); ?>';">
                            
                            <!-- GRADIENT OVERLAY DEFAULT -->
                            <div class="position-absolute top-0 start-0 w-100 h-100" 
                                 style="background: linear-gradient(180deg, rgba(0,0,0,0) 30%, rgba(0,0,0,0.85) 100%); pointer-events: none;"></div>

                            <!-- KONTEN ANGKA & LABEL (BERGESER KE ATAS SAAT HOVER) -->
                            <div class="card-body position-relative z-2 d-flex flex-column justify-content-end align-items-center p-4 text-white h-100 impact-card-main-content">
                                <h3 class="fw-bold text-white mb-0 text-center impact-card-num" style="font-size: 42px; line-height: 1.0; letter-spacing: -0.5px;">
                                    <?php echo esc_html($card_num); ?>
                                </h3>
                                <p class="text-white mb-0 fw-medium fs-6 mt-1 text-center impact-card-lbl">
                                    <?php echo esc_html($card_lbl); ?>
                                </p>
                            </div>

                            <!-- HOVER BOX BLUE (KOTAK BIRU DENGAN DESKRIPSI) -->
                            <?php if (!empty($card_desc)) : ?>
                                <div class="position-absolute bottom-0 start-0 w-100 impact-card-hover-box p-3 p-xl-4 text-center text-white" 
                                     style="background-color: #0B2567; border-radius: 16px; z-index: 5;">
                                    <p class="mb-0 text-white" style="font-size: 13px; line-height: 1.5; font-weight: 400;">
                                        <?php echo esc_html($card_desc); ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                <?php } ?>

            </div>

        </div>
    </section>

    <!-- STYLING KUSTOM UNTUK TOMBOL ABOUT & EFEK HOVER KARTU STATISTIK -->
    <style>
    .about-cta-btn:hover {
        background-color: #B81B21 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(216, 35, 42, 0.35) !important;
    }
    
    /* STYLING EFEK HOVER KARTU STATISTIK (SESUAI DESAIN FIGMA) */
    .impact-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .impact-card .impact-card-main-content {
        transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .impact-card .impact-card-hover-box {
        transform: translateY(105%);
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* KETIKA KARTU DI-HOVER */
    .impact-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25) !important;
    }
    .impact-card:hover .impact-card-img {
        transform: scale(1.06) !important;
        filter: brightness(0.85);
    }
    .impact-card:hover .impact-card-main-content {
        transform: translateY(-120px) !important;
    }
    .impact-card:hover .impact-card-hover-box {
        transform: translateY(0) !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
    </style>

</main>


<?php get_footer(); ?>