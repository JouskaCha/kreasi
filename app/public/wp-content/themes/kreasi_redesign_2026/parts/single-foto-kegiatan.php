<?php
/**
 * Template Part: Single Foto Kegiatan
 * Sesuai desain Image 3 (Hero Batik, Title & Share, Slider Carousel, Card Deskripsi & Kredit Foto)
 *
 * @package kreasi_redesign_2026
 */

$post_id = get_the_ID();

// Tanggal
$post_date = get_the_date('j F Y');

// Kredit Foto (Caption)
$photo_credit = get_post_meta($post_id, '_kreasi_photo_credit', true);
if (empty($photo_credit)) {
    $photo_credit = 'Foto: Calvin S. Telaumbanua/KREASI/Article 33 Indonesia/Save the Children';
}

// Galeri Foto untuk Slider
$gallery_raw = get_post_meta($post_id, '_kreasi_gallery_images', true);
$slides = array();

if (!empty($gallery_raw)) {
    $img_ids = is_array($gallery_raw) ? $gallery_raw : explode(',', $gallery_raw);
    foreach ($img_ids as $img_id) {
        $img_id = (int) trim($img_id);
        if ($img_id > 0) {
            $img_url = wp_get_attachment_image_url($img_id, 'full');
            if ($img_url) {
                $slides[] = $img_url;
            }
        }
    }
}

// Fallback jika belum ada galeri diisi: gunakan featured image atau aset tema
if (empty($slides)) {
    if (has_post_thumbnail($post_id)) {
        $slides[] = get_the_post_thumbnail_url($post_id, 'full');
    } else {
        $slides[] = get_template_directory_uri() . '/assets/images/thumbnail-1.png';
        $slides[] = get_template_directory_uri() . '/assets/images/thumbnail-2.png';
        $slides[] = get_template_directory_uri() . '/assets/images/thumbnail3.png';
    }
}

$share_url   = rawurlencode(get_permalink());
$share_title = rawurlencode(get_the_title());
$bg_header   = get_template_directory_uri() . '/assets/images/bg-header-artikel.png';
?>

<main id="primary" class="site-main single-foto-kegiatan-page bg-light pb-5">

    <!-- ==========================================
         HERO HEADER BANNER: BIRU MOTIF BATIK (FIGMA IMAGE 3)
    =========================================== -->
    <section class="foto-kegiatan-hero position-relative overflow-hidden text-white" 
             style="background: #0B2055 url('<?php echo esc_url($bg_header); ?>') center/cover no-repeat; padding: 48px 0 60px;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(11, 32, 85, 0.75); z-index: 1;"></div>

        <div class="container px-4 px-lg-5 position-relative" style="z-index: 2;">
            <div class="row align-items-end justify-content-between gy-3">
                
                <!-- SISI KIRI: TANGGAL & JUDUL KEGIATAN -->
                <div class="col-lg-9 col-md-8">
                    <!-- TANGGAL -->
                    <p class="text-white-50 small mb-2 d-inline-flex align-items-center" style="font-family: 'Lato', sans-serif; font-size: 13px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2 text-white-50">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <?php echo esc_html($post_date); ?>
                    </p>

                    <!-- JUDUL BESAR -->
                    <h1 class="page-title text-white fw-bold mb-0 text-uppercase" 
                        style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(28px, 3.8vw, 48px); line-height: 1.15; letter-spacing: 0.5px;">
                        <?php the_title(); ?>
                    </h1>
                </div>

                <!-- SISI KANAN: BAGIKAN KE... (FACEBOOK & X FIGMA IMAGE 3) -->
                <div class="col-lg-3 col-md-4 text-md-end">
                    <div class="d-inline-flex align-items-center gap-2">
                        <span class="text-white small fw-medium" style="font-family: 'Lato', sans-serif; font-size: 13px; opacity: 0.9;">
                            <?php echo esc_html(kreasi_t('bagikan_ke', 'Bagikan ke...', 'Share to...')); ?>
                        </span>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($share_url); ?>" 
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-sm btn-outline-light rounded-circle d-inline-flex align-items-center justify-content-center"
                           style="width: 32px; height: 32px; border-color: rgba(255,255,255,0.4);"
                           title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <!-- X (Twitter) -->
                        <a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($share_title); ?>&url=<?php echo esc_attr($share_url); ?>" 
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-sm btn-outline-light rounded-circle d-inline-flex align-items-center justify-content-center"
                           style="width: 32px; height: 32px; border-color: rgba(255,255,255,0.4);"
                           title="X">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================
         CAROUSEL / SLIDER FOTO KEGIATAN (FIGMA IMAGE 3)
    =========================================== -->
    <section class="foto-kegiatan-slider-section py-4">
        <div class="container px-4 px-lg-5">
            <div class="row justify-content-center">
                <div class="col-xl-11 col-lg-12">
                    
                    <div id="fotoKegiatanCarousel" class="carousel slide position-relative rounded-4 overflow-hidden shadow-lg" data-bs-ride="false" style="background: #111;">
                        
                        <!-- SLIDES -->
                        <div class="carousel-inner" style="aspect-ratio: 16 / 9; max-height: 600px;">
                            <?php foreach ($slides as $idx => $slide_img) : ?>
                                <div class="carousel-item <?php echo $idx === 0 ? 'active' : ''; ?> w-100 h-100">
                                    <img src="<?php echo esc_url($slide_img); ?>" 
                                         alt="<?php the_title_attribute(); ?> - Slide <?php echo esc_attr($idx + 1); ?>" 
                                         class="d-block w-100 h-100 object-fit-cover">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- NAVIGATION ARROWS (CIRCULAR DARK ARROWS FIGMA IMAGE 3) -->
                        <?php if (count($slides) > 1) : ?>
                            <button class="carousel-control-prev custom-carousel-arrow custom-arrow-prev" 
                                    type="button" 
                                    data-bs-target="#fotoKegiatanCarousel" 
                                    data-bs-slide="prev"
                                    aria-label="Previous">
                                <span class="arrow-circle d-inline-flex align-items-center justify-content-center">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                </span>
                            </button>

                            <button class="carousel-control-next custom-carousel-arrow custom-arrow-next" 
                                    type="button" 
                                    data-bs-target="#fotoKegiatanCarousel" 
                                    data-bs-slide="next"
                                    aria-label="Next">
                                <span class="arrow-circle d-inline-flex align-items-center justify-content-center">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </span>
                            </button>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         KARTU KONTEN DESKRIPSI & KREDIT FOTO (FIGMA IMAGE 3)
    =========================================== -->
    <div class="container px-4 px-lg-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                
                <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                    <!-- PARAGRAF DESKRIPSI KEGIATAN -->
                    <div class="foto-kegiatan-content text-dark mb-4 entry-content" 
                         style="font-family: 'Lato', sans-serif; font-size: 15.5px; line-height: 1.75; color: #374151;">
                        <?php 
                        if (!empty(get_the_content())) {
                            the_content();
                        } else {
                            echo '<p>KREASI Nias Utara menyelenggarakan Kampanye Kebersihan Lingkungan bersama 226 Siswa Sekolah Dasar di Nias Utara. Kegiatan ini diisi dengan penyampaian materi dari Dinas Lingkungan Hidup dan DP3AP2KB Kabupaten Nias Utara, serta ajakan dari duta sebaya untuk menjaga kebersihan lingkungan sekolah. Terlihat anak-anak sangat bersemangat dan antusias selama kegiatan ini. Dari sini sekolah didorong untuk mulai langkah pencegahan perubahan iklim, salah satunya dengan menanam dan merawat tanaman oleh masing-masing siswa.</p>';
                        }
                        ?>
                    </div>

                    <!-- KREDIT FOTO (ITALIC DI BAWAH DESKRIPSI FIGMA IMAGE 3) -->
                    <?php if (!empty($photo_credit)) : ?>
                        <div class="photo-caption-credit pt-3 border-top" style="font-family: 'Lato', sans-serif; font-size: 13.5px; color: #6B7280;">
                            <em><?php echo esc_html($photo_credit); ?></em>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

</main>

<style>
/* CUSTOM ARROW BUTTONS SESUAI GAMBAR 3 */
.custom-carousel-arrow {
    width: 60px !important;
    opacity: 0.9 !important;
    transition: all 0.25s ease;
}

.custom-arrow-prev {
    left: 15px !important;
}

.custom-arrow-next {
    right: 15px !important;
}

.arrow-circle {
    width: 48px;
    height: 48px;
    background-color: rgba(30, 41, 59, 0.7);
    color: #ffffff;
    border-radius: 50%;
    backdrop-filter: blur(4px);
    transition: all 0.25s ease;
}

.custom-carousel-arrow:hover .arrow-circle {
    background-color: rgba(11, 32, 85, 0.95);
    transform: scale(1.08);
}
</style>
