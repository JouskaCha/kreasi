<?php
/**
 * Template Part: Section Area Intervensi & Mitra Pelaksana (Full Width Image + Text in Front)
 */

$map_title = get_theme_mod('map_section_title', 'AREA INTERVENSI & MITRA PELAKSANA');
$map_image = get_theme_mod('map_section_image', '');

// Fallback image jika belum diunggah dari Customizer
if (empty($map_image)) {
    $map_image = get_template_directory_uri() . '/assets/images/area-intervensi-map.png';
}
?>

<!-- SECTION AREA INTERVENSI & MITRA PELAKSANA (FULL WIDTH IMAGE & OVERLAY TEXT) -->
<section class="intervention-map-section position-relative overflow-hidden w-100 bg-white py-4 py-lg-5">
    
    <!-- CONTAINER FLUID FULL WIDTH -->
    <div class="container-fluid px-3 px-lg-5 position-relative">
        
        <!-- JUDUL SECTION DI DEPAN GAMBAR (TOP LEFT OVERLAY - Z-INDEX 10) -->
        <?php if (!empty($map_title)) : ?>
            <div class="position-absolute top-0 start-0 ps-3 ps-lg-5 pt-2 pt-lg-4" style="z-index: 10;">
                <h2 class="fw-bold text-uppercase mb-0" style="font-size: 34px; letter-spacing: 0.5px; color: #1A202C;">
                    <?php echo esc_html($map_title); ?>
                </h2>
            </div>
        <?php endif; ?>

        <!-- FULL WIDTH MAP GRAPHIC IMAGE (BERADA DI BELAKANG JUDUL) -->
        <div class="map-graphic-full-wrap w-100 text-center position-relative pt-4 pt-lg-4">
            <img src="<?php echo esc_url($map_image); ?>" 
                 alt="<?php echo esc_attr($map_title); ?>" 
                 class="img-fluid w-100 object-fit-contain" 
                 style="max-height: 650px; width: 100%; transition: transform 0.4s ease;"
                 onerror="this.src='https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=1400&auto=format&fit=crop';">
        </div>

    </div>

</section>

<!-- STYLING HOVER FULL WIDTH MAP & MOBILE RESPONSIVE -->
<style>
.map-graphic-full-wrap img {
    transition: transform 0.35s ease;
}
.map-graphic-full-wrap img:hover {
    transform: scale(1.008);
}
@media (max-width: 767.98px) {
    .intervention-map-section h2 {
        font-size: 20px !important;
    }
}
</style>
