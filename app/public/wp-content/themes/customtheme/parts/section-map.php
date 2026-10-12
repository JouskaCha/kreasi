<?php
/**
 * Template Part: Section Area Intervensi & Mitra Pelaksana (Full Width Image + Text in Front)
 */

$map_title = get_theme_mod('map_section_title', 'AREA INTERVENSI & MITRA PELAKSANA');
$map_image = get_theme_mod('map_section_image', '');

// Fallback image jika belum diunggah dari Customizer
if (empty($map_image)) {
    $map_image = get_template_directory_uri() . '/assets/images/map.png';
}
?>

<!-- SECTION AREA INTERVENSI & MITRA PELAKSANA (FULL WIDTH IMAGE & OVERLAY TEXT) -->
<section class="intervention-map-section">

    <!-- JUDUL DI DEPAN GAMBAR (TOP LEFT OVERLAY) -->
    <?php if (!empty($map_title)) : ?>
        <div class="map-section-title">
            <h2 class="fw-bold text-uppercase mb-0">
                <?php echo esc_html($map_title); ?>
            </h2>
        </div>
    <?php endif; ?>

    <!-- GAMBAR FULL WIDTH TANPA PADDING & MARGIN -->
    <div class="map-graphic-full-wrap">
        <img src="<?php echo esc_url($map_image); ?>"
             alt="<?php echo esc_attr($map_title); ?>"
             class="map-full-image"
             onerror="this.src='https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=1400&auto=format&fit=crop';">
    </div>

</section>

<style>
/* Section: benar-benar full width, tanpa jarak */
.intervention-map-section {
    position: relative;
    width: 100%;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden;
    background: #fff;
}

/* Judul overlay */
.intervention-map-section .map-section-title {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    padding: 24px 0 0 48px;
}
.intervention-map-section .map-section-title h2 {
    font-size: 34px;
    letter-spacing: 0.5px;
    color: #1A202C;
}

/* Wrapper gambar */
.map-graphic-full-wrap {
    width: 100%;
    margin: 0;
    padding: 0;
    line-height: 0; /* hilangkan celah bawah gambar */
}

/* Gambar: penuh lebar, tinggi mengikuti rasio asli */
.map-graphic-full-wrap .map-full-image {
    display: block;
    width: 100%;
    max-width: 100%;
    height: auto;
    margin: 0;
    padding: 0;
    transition: transform 0.35s ease;
}
.map-graphic-full-wrap:hover .map-full-image {
    transform: scale(1.008);
}

/* Mobile */
@media (max-width: 767.98px) {
    .intervention-map-section .map-section-title {
        padding: 12px 0 0 16px;
    }
    .intervention-map-section .map-section-title h2 {
        font-size: 20px;
    }
}
</style>