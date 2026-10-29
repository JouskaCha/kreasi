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
    $hero_video = get_template_directory_uri() . '/assets/videos/hero.mp4';

    $slides[] = array(
        'media'     => $hero_video,
        'title'     => 'GURU DI PESISIR BARAT MENYULAP RUANG<br>SEDERHANA MENJADI PERPUSTAKAAN',
        'link'      => '#',
        'link_text' => 'READ MORE',
    );
}

$interval = get_theme_mod('hero_slider_interval', 6000);
?>
    <!-- HERO SECTION SLIDER (IMAGE & VIDEO) -->
    <section class="hero-section position-relative overflow-hidden">
        <div id="heroCarousel" class="carousel slide carousel-fade h-100 position-relative" data-bs-ride="carousel" data-bs-interval="<?php echo esc_attr($interval); ?>">
            
            <!-- CAROUSEL SLIDES -->
            <div class="carousel-inner h-100">
                <?php foreach ($slides as $index => $slide) : 
                    $is_active = ($index === 0) ? 'active' : '';
                    $is_video  = function_exists('kreasi_redesign_2026_is_video_url') && kreasi_redesign_2026_is_video_url($slide['media']);
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
                        <div class="container-fluid px-3 px-md-5 position-relative h-100 d-flex align-items-end pb-4 pb-md-5 hero-content-layer" style="z-index: 5;">
                            <div class="hero-slide-content text-white position-relative w-100 d-flex align-items-end justify-content-between">
                                <?php if (!empty($slide['title'])) : ?>
                                    <h1 class="hero-slide-title text-white mb-0">
                                        <?php echo wp_kses_post($slide['title']); ?>
                                    </h1>
                                <?php endif; ?>
                                <?php if (!empty($slide['link'])) : ?>
                                    <a href="<?php echo esc_url($slide['link']); ?>"
                                    class="hero-slide-read-more text-white text-decoration-none ms-auto text-end">
                                        <span>
                                            <?php echo esc_html(!empty($slide['link_text']) ? $slide['link_text'] : 'READ MORE'); ?>
                                        </span>
                                        <span class="hero-slide-arrow" aria-hidden="true">→</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- CAROUSEL INDICATORS (Pill & Dots) -->
            <?php if (count($slides) > 1) : ?>
                <div class="carousel-indicators position-absolute d-flex align-items-center m-0 hero-carousel-indicators" style="gap: 6px; justify-content: flex-start; width: auto; z-index: 3;">
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

    <!-- STYLING UNTUK INDICATOR PILL DESAIN FIGMA & RESPONSIVE MOBILE FONT SIZE -->
    <style>
    .hero-carousel-indicators {
        left: 50px;
        bottom: 30px;
    }
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

    /* RESPONSIVE FONT SIZE & READ MORE ALIGNMENT */
    @media (max-width: 767.98px) {
        .hero-section {
            height: 480px !important;
        }
        .hero-content-layer {
            padding-left: 20px !important;
            padding-right: 20px !important;
            padding-bottom: 55px !important;
        }
        .hero-slide-title {
            font-size: 32px !important;
            line-height: 1.15 !important;
        }
        .hero-carousel-indicators {
            left: 20px !important;
            bottom: 20px !important;
        }
    }
    </style>


    <!-- ==========================================
         SECTION 2: ABOUT PROGRAM (UNTUK PENDIDIKAN YANG BERKUALITAS)
    =========================================== -->
    <?php
    $about_bg_desktop = get_theme_mod('about_section_bg', '');
    if (empty($about_bg_desktop)) {
        if (file_exists(get_template_directory() . '/assets/images/bg-section2.png')) {
            $about_bg_desktop = get_template_directory_uri() . '/assets/images/bg-section2.png';
        } elseif (file_exists(get_template_directory() . '/assets/images/about-bg.jpg')) {
            $about_bg_desktop = get_template_directory_uri() . '/assets/images/about-bg.jpg';
        }
    }
    $about_bg_mobile = '';
    if (file_exists(get_template_directory() . '/assets/images/bg-section2-mobile.png')) {
        $about_bg_mobile = get_template_directory_uri() . '/assets/images/bg-section2-mobile.png';
    } else {
        $about_bg_mobile = $about_bg_desktop;
    }
    ?>
    <section class="about-section py-5 position-relative overflow-hidden"
             style="min-height: 480px; width: 100%;">
        <style>
            .about-section {
                background-image: url('<?php echo esc_url($about_bg_desktop); ?>');
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
            }
            @media (max-width: 767.98px) {
                .about-section {
                    background-image: url('<?php echo esc_url($about_bg_mobile); ?>') !important;
                }
            }
        </style>
        <!-- DECORATIVE WAVE BACKGROUND WATERMARK (fallback jika belum ada background image) -->
        <?php if (empty($about_bg_desktop)) : ?>
        <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none opacity-25" 
             style="background-image: radial-gradient(circle at 10% 20%, rgba(14, 42, 93, 0.05) 0%, transparent 60%);"></div>
        <?php endif; ?>

        <div class="container py-lg-4 position-relative z-1">
            <div class="row align-items-center gy-4">
                
                <!-- SISI KIRI: HEADING & CTA BUTTON -->
                <div class="col-lg-5 col-md-12">
                    <h2 class="mb-4" style="color: #0E2A5D; font-family: 'Bebas Neue', sans-serif; font-weight: 400; font-size: 56px; line-height: 1.15; letter-spacing: -0.5px;">
                        <?php echo wp_kses_post(kreasi_t('quality_edu_title', 'UNTUK PENDIDIKAN<br>YANG <span style="color: #D8232A;">BERKUALITAS</span>', 'FOR QUALITY<br><span style="color: #D8232A;">EDUCATION</span>')); ?>
                    </h2>
                    
                    <a href="<?php echo esc_url(home_url('/tentang-kami')); ?>" 
                       class="btn text-white px-4 py-3 text-uppercase shadow-sm about-cta-btn" 
                       style="background-color: #D8232A; border-radius: 6px; font-family: 'Oswald', sans-serif; font-weight: 400; font-size: 16px; letter-spacing: 0.5px; transition: all 0.3s ease;">
                        <?php echo esc_html(kreasi_t('more_about_us', 'SELENGKAPNYA TENTANG KAMI', "LET'S READ MORE")); ?>
                    </a>
                </div>

                <!-- SISI KANAN: PARAGRAF DESKRIPSI -->
                <div class="col-lg-7 col-md-12">
                    <p class="about-description mb-0" style="font-size: 18px;">
                        <?php echo wp_kses_post(kreasi_t('about_description')); ?>
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
                <h2 class="text-white text-uppercase mb-2" style="font-family: 'Bebas Neue', sans-serif; font-weight: 400; font-size: 64px; letter-spacing: 0.5px;">
                    <?php echo esc_html(kreasi_t('impact_title', 'MEMBAWA PERUBAHAN KE PELOSOK', 'BRINGING CHANGE TO REMOTE AREAS')); ?>
                </h2>
                <p class="text-white mb-0" style="font-family: 'Lato', sans-serif; font-size: 18px; font-weight: 700; opacity: 0.9; margin-left: auto; margin-right: auto;">
                    <?php echo esc_html(kreasi_t('impact_subtitle', 'Dari advokasi untuk kebijakan pendidikan yang lebih baik, hingga ke ruang kelas yang menyenangkan.', 'From advocacy for better education policies to enjoyable classrooms.')); ?>
                </p>
            </div>

            <!-- 4 KARTU STATISTIK GRID (2x2 DI MOBILE, 4 KOLOM DI DESKTOP) -->
            <div class="row row-cols-2 row-cols-lg-4 g-2 g-md-4">
                
                <?php
                $default_cards = array(
                    array(
                        'number'   => '50,000',
                        'label'    => kreasi_t('student', 'MURID', 'SSTUDENTS'),
                        'desc'     => 'Mendapatkan akses buku berkualitas dan ruang baca yang nyaman untuk menumbuhkan kecintaan pada literasi sejak dini.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-murid.png',
                        'fallback' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'number'   => '4,000',
                        'label'    => kreasi_t('teacher', 'GURU', 'TEACHERS'),
                        'desc'     => 'Mendapatkan pelatihan metode pembelajaran kreatif dan efektif untuk meningkatkan kualitas pengajaran di kelas.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-guru.png',
                        'fallback' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'number'   => '560',
                        'label'    => kreasi_t('school_principal', 'KEPALA SEKOLAH', 'SCHOOL PRINCIPALS'),
                        'desc'     => 'Mendapatkan pendampingan manajemen kepemimpinan sekolah dan tata kelola pendidikan yang inklusif.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-kepala-sekolah.png',
                        'fallback' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'number'   => '560',
                        'label'    => kreasi_t('school', 'SEKOLAH', 'SCHOOLS'),
                        'desc'     => 'Menerima perbaikan fasilitas perpustakaan, sarana belajar, dan ruang kelas yang kondusif untuk siswa.',
                        'image'    => get_template_directory_uri() . '/assets/images/impact-sekolah.png',
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
                        <div class="card impact-card border-0 rounded-4 overflow-hidden position-relative shadow-sm">
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
                            <div class="card-body position-relative z-2 d-flex flex-column justify-content-end align-items-center p-3 p-md-4 text-white h-100 impact-card-main-content">
                                <h3 class="text-white mb-0 text-center impact-card-num" style="font-family: 'Bebas Neue', sans-serif; font-weight: 400; line-height: 1.0; letter-spacing: -0.5px;">
                                    <?php echo esc_html($card_num); ?>
                                </h3>
                                <p class="text-white mb-0 mt-1 text-center impact-card-lbl text-uppercase" style="font-family: 'Oswald', sans-serif;">
                                    <?php echo esc_html($card_lbl); ?>
                                </p>
                            </div>

                            <!-- HOVER BOX BLUE (KOTAK BIRU DENGAN DESKRIPSI) -->
                            <?php if (!empty($card_desc)) : ?>
                            <div class="position-absolute bottom-0 start-0 w-100 impact-card-hover-box p-3 p-xl-4 text-center text-white"
                                style="background-color: #0B2567; border-radius: 16px; z-index: 5;">
                                <p class="mb-0 text-white" style="font-family: 'Lato', sans-serif; font-size: 18px; line-height: 1.5; font-weight: 500;">
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
        height: 380px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .impact-card-num {
        font-family: 'Bebas Neue', sans-serif !important;
        font-weight: 400 !important;
        font-size: 80px;
    }
    .impact-card-lbl {
        font-family: 'Oswald', sans-serif !important;
        text-transform: uppercase !important;
        font-size: 16px;
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

    /* MEDIA QUERY MOBILE RESPONSIVE (2x2 GRID FIGMA) */
    @media (max-width: 767.98px) {
        .impact-card {
            height: 240px !important;
        }
        .impact-card-num {
            font-size: 30px !important;
        }
        .impact-card-lbl {
            font-size: 13px !important;
        }
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

    <!-- ==========================================
         SECTION 4: ARTIKEL TERKINI (PIN & RECENTLY POSTS)
    =========================================== -->
    <?php get_template_part('parts/section', 'articles'); ?>

    <!-- ==========================================
         SECTION 5: PUBLIKASI (BULETIN & BAHAN AJAR)
    =========================================== -->
    <?php get_template_part('parts/section', 'publications'); ?>

    <!-- ==========================================
         SECTION 6: EVENT
    =========================================== -->
    <?php get_template_part('parts/section', 'event'); ?>

</main>


<?php get_footer(); ?>