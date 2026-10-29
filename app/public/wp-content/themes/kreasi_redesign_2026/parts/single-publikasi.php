<?php
/**
 * Template Part: Single Publikasi
 * Sesuai desain Image 4 & PRD FR-05 (Tombol Unduh & Baca, Cover, Sinopsis, Share)
 *
 * @package kreasi_redesign_2026
 */

$post_id = get_the_ID();

// Kategori anak (e.g. Buletin, Dokumen Strategis, Repositori Pengetahuan, dll)
$cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category($post_id) : null;
$cat_name = $cat_obj ? $cat_obj->name : 'Buletin';

// Featured Image / Cover
if (has_post_thumbnail($post_id)) {
    $cover_url = get_the_post_thumbnail_url($post_id, 'full');
} else {
    $cover_url = get_template_directory_uri() . '/assets/images/pub-cover-1.png';
}

// Meta Unduh & Baca
$action_mode = get_post_meta($post_id, '_kreasi_pub_action', true);
if ($action_mode === '') {
    $action_mode = 'both';
}

$pdf_id      = get_post_meta($post_id, '_kreasi_pub_pdf_id', true);
$pdf_url     = get_post_meta($post_id, '_kreasi_pub_pdf_url', true);
if (empty($pdf_url) && !empty($pdf_id)) {
    $pdf_url = wp_get_attachment_url((int)$pdf_id);
}

$read_source = get_post_meta($post_id, '_kreasi_pub_read_source', true);

// Evaluasi tombol aktif sesuai kriteria PRD FR-05
$show_unduh = ($action_mode === 'unduh' || $action_mode === 'both') && !empty($pdf_url);
$show_baca  = ($action_mode === 'baca' || $action_mode === 'both') && !empty($read_source);

// Ringkasan
$summary = get_post_meta($post_id, '_kreasi_pub_summary', true);
if (empty($summary)) {
    $summary = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 60);
}
if (empty($summary)) {
    $summary = 'Jejak KREASI adalah laporan bulanan dalam bentuk majalah yang disusun untuk menyebarluaskan informasi perkembangan serta praktik baik kepada seluruh pemangku kepentingan sektor pendidikan: Global Partnership for Education (GPE) sebagai donor, Mitra Pendidikan Indonesia (MPI), Mitra Pelaksana Lokal (MPL), Pemerintah, dan ekosistem pendidikan.';
}

$share_url   = rawurlencode(get_permalink());
$share_title = rawurlencode(get_the_title());

// Background Banner Header Publikasi (Sama dengan Header Artikel)
$artikel_bg_desktop = get_theme_mod('artikel_header_bg_desktop', '');
$artikel_bg_mobile  = get_theme_mod('artikel_header_bg_mobile', '');
if (empty($artikel_bg_desktop)) {
    $artikel_bg_desktop = get_template_directory_uri() . '/assets/images/bg-header-artikel.png';
}
if (empty($artikel_bg_mobile)) {
    $artikel_bg_mobile = get_template_directory_uri() . '/assets/images/bg-header-artikel-mobile.png';
}
?>

<main id="primary" class="site-main single-publikasi-page pb-5" style="background-color: #F8F9FA;">

    <!-- HERO HEADER BANNER: MERAH MOTIF ARTIKEL (PERSIS DENGAN HEADER ARTIKEL) -->
    <section class="single-publikasi-hero artikel-hero-banner position-relative overflow-hidden text-center text-white d-flex align-items-center justify-content-center" 
             style="background-color: #D8232A; min-height: 240px; padding: 40px 15px 100px;">
        <picture class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: 1;">
            <source media="(max-width: 767.98px)" srcset="<?php echo esc_url($artikel_bg_mobile); ?>">
            <img src="<?php echo esc_url($artikel_bg_desktop); ?>" alt="Background Header Publikasi" class="w-100 h-100 object-fit-cover">
        </picture>
    </section>

    <!-- KONTEN UTAMA: COVER KIRI & KARTU PUTIH KANAN (FIGMA IMAGE 4) -->
    <div class="container px-4 px-lg-5 position-relative" style="z-index: 10; margin-top: -120px;">
        <div class="row g-4 g-xl-5 align-items-start justify-content-center">

            <!-- SISI KIRI: COVER MAJALAH / BUKU -->
            <div class="col-12 col-md-5 col-lg-4">
                <div class="publication-single-cover rounded-4 overflow-hidden position-relative mx-auto" 
                     style="max-width: 380px; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18); border: 2px solid #ffffff; background: #ffffff;">
                    <img src="<?php echo esc_url($cover_url); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         class="w-100 h-auto d-block" 
                         style="aspect-ratio: 1 / 1.38; object-fit: cover;">
                </div>
            </div>

            <!-- SISI KANAN: KARTU PUTIH DETAIL PUBLIKASI -->
            <div class="col-12 col-md-7 col-lg-8">
                <div class="card border-0 rounded-4 p-4 p-md-5 bg-white" 
                     style="box-shadow: 0 6px 24px rgba(0,0,0,0.06);">
                    
                    <!-- TOP META BAR: BADGE KATEGORI + TANGGAL -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <span class="badge text-white d-inline-flex align-items-center"
                              style="background-color: #D8232A; border-radius: 6px; font-family: 'Lato', sans-serif; font-size: 11px; font-weight: 600; padding: 4px 10px; width: fit-content; border: none;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="me-1.5">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <?php echo esc_html(kreasi_translate_term($cat_name)); ?>
                        </span>

                        <span class="text-secondary d-inline-flex align-items-center" style="font-family: 'Lato', sans-serif; font-size: 13px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1 text-secondary">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <?php echo esc_html(get_the_date('j F Y')); ?>
                        </span>
                    </div>

                    <!-- JUDUL BESAR CONDENSED FONT -->
                    <h1 class="single-pub-title mb-0 text-uppercase" 
                        style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(26px, 3.2vw, 42px); font-weight: 700; color: #111111; letter-spacing: 0.5px; line-height: 1.18;">
                        <?php the_title(); ?>
                    </h1>

                    <!-- GARIS PEMBATAS HORIZONTAL -->
                    <hr class="my-4" style="border: none; border-top: 1px solid #E5E7EB; opacity: 1;">

                    <!-- KONTEN DESKRIPSI PUBLIKASI (HANYA DITAMPILKAN 1 KALI, TIDAK DOUBLE) -->
                    <?php 
                    $raw_custom_summary = get_post_meta($post_id, '_kreasi_pub_summary', true);
                    $has_editor_content = !empty(get_the_content());
                    
                    if (!empty($raw_custom_summary)) : ?>
                        <div class="single-pub-summary mb-4" 
                             style="font-family: 'Lato', sans-serif; font-weight: 600; font-size: 16px; line-height: 1.5; letter-spacing: 0; color: #111827;">
                            <?php echo wp_kses_post(wpautop($raw_custom_summary)); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($has_editor_content) : ?>
                        <div class="single-pub-extra-content mb-4 entry-content" 
                             style="font-family: 'Lato', sans-serif; font-weight: 600; font-size: 16px; line-height: 1.5; letter-spacing: 0; color: #111827;">
                            <?php the_content(); ?>
                        </div>
                    <?php elseif (empty($raw_custom_summary)) : ?>
                        <div class="single-pub-summary mb-4" 
                             style="font-family: 'Lato', sans-serif; font-weight: 600; font-size: 16px; line-height: 1.5; letter-spacing: 0; color: #111827;">
                            <p><?php echo esc_html(has_excerpt() ? get_the_excerpt() : 'Jejak KREASI adalah laporan bulanan dalam bentuk majalah yang disusun untuk menyebarluaskan informasi perkembangan serta praktik baik kepada seluruh pemangku kepentingan sektor pendidikan.'); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- ROW TOMBOL TINDAKAN (UNDUH & BACA) & SHARE SOCIAL -->
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 pt-3 border-top">
                        
                        <!-- TOMBOL AKSI: UNDUH ↓ & BACA → -->
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <?php if ($show_unduh) : ?>
                                <a href="<?php echo esc_url($pdf_url); ?>" 
                                   target="_blank" 
                                   download
                                   class="btn btn-navy-download text-white px-4 py-2 text-uppercase shadow-sm d-inline-flex align-items-center"
                                   style="background-color: #062172; border-radius: 6px; font-family: 'Oswald', sans-serif; font-weight: 400; font-size: 16px; letter-spacing: 0.5px; transition: all 0.25s ease;">
                                    <span><?php echo esc_html(kreasi_t('unduh', 'UNDUH', 'DOWNLOAD')); ?></span>
                                    <span class="ms-2">↓</span>
                                </a>
                            <?php endif; ?>

                            <?php if ($show_baca) : ?>
                                <a href="<?php echo esc_url($read_source); ?>" 
                                   class="btn btn-red-read text-white px-4 py-2 text-uppercase shadow-sm d-inline-flex align-items-center"
                                   style="background-color: #D8232A; border-radius: 6px; font-family: 'Oswald', sans-serif; font-weight: 400; font-size: 16px; letter-spacing: 0.5px; transition: all 0.25s ease;">
                                    <span><?php echo esc_html(kreasi_t('baca', 'BACA', 'READ')); ?></span>
                                    <span class="ms-2">→</span>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- BAGIKAN / SOCIAL SHARE (FIGMA IMAGE 4) -->
                        <div class="d-flex align-items-center gap-2 ms-lg-auto">
                            <span class="text-secondary small fw-medium" style="font-family: 'Lato', sans-serif; font-size: 13px;">
                                <?php echo esc_html(kreasi_t('bagikan', 'Bagikan', 'Share')); ?>
                            </span>

                            <!-- Copy Link -->
                            <button type="button" 
                                    class="pub-share-circle border-0 bg-transparent p-0 d-inline-flex align-items-center justify-content-center"
                                    onclick="navigator.clipboard.writeText('<?php echo esc_url(get_permalink()); ?>'); alert('Tautan berhasil disalin!');"
                                    title="Salin Tautan">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-artikel/link.png'); ?>" alt="Salin" width="24" height="24" style="object-fit: contain;">
                            </button>

                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text=<?php echo esc_attr($share_title . '%20' . $share_url); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="pub-share-circle border-0 bg-transparent p-0 d-inline-flex align-items-center justify-content-center"
                               title="Bagikan ke WhatsApp">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-artikel/whatsapp.png'); ?>" alt="WhatsApp" width="24" height="24" style="object-fit: contain;">
                            </a>

                            <!-- Instagram -->
                            <a href="https://instagram.com" 
                               target="_blank" rel="noopener noreferrer"
                               class="pub-share-circle border-0 bg-transparent p-0 d-inline-flex align-items-center justify-content-center"
                               title="Instagram">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-artikel/instagram.png'); ?>" alt="Instagram" width="24" height="24" style="object-fit: contain;">
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($share_url); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="pub-share-circle border-0 bg-transparent p-0 d-inline-flex align-items-center justify-content-center"
                               title="Bagikan ke Facebook">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-artikel/facebook.png'); ?>" alt="Facebook" width="24" height="24" style="object-fit: contain;">
                            </a>

                            <!-- X (Twitter) -->
                            <a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($share_title); ?>&url=<?php echo esc_attr($share_url); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="pub-share-circle border-0 bg-transparent p-0 d-inline-flex align-items-center justify-content-center"
                               title="Bagikan ke X">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-artikel/x-twitter.png'); ?>" alt="X" width="24" height="24" style="object-fit: contain;">
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

</main>

<style>
.btn-navy-download:hover {
    background-color: #041445 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(6, 33, 114, 0.3) !important;
}

.btn-red-read:hover {
    background-color: #b91c22 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(216, 35, 42, 0.3) !important;
}

.pub-share-circle:hover {
    background-color: #F3F4F6 !important;
    border-color: #9CA3AF !important;
    color: #111827 !important;
    transform: translateY(-1px);
}
</style>
