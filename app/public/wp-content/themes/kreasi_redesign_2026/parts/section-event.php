
<?php
/**
 * Template Part: Event
 * Responsive Full Width Image: Desktop & Mobile
 */

$event_title = get_theme_mod(
    'event_section_title',
    'EVENT'
);

// Gambar Desktop (Landscape)
$event_image_desktop = get_theme_mod(
    'event_section_image_desktop',
    ''
);

// Gambar Mobile (Portrait)
$event_image_mobile = get_theme_mod(
    'event_section_image_mobile',
    ''
);

// Fallback jika gambar belum diunggah di Customizer
$event_fallback = get_template_directory_uri() . '/assets/images/event.png';

if (empty($event_image_desktop)) {
    $event_image_desktop = $event_image_mobile ?: $event_fallback;
}

if (empty($event_image_mobile)) {
    $event_image_mobile = $event_image_desktop;
}
?>

<!-- SECTION AREA INTERVENSI -->
<section class="intervention-event-section">

    <!-- JUDUL (saat ini disembunyikan sesuai template lama) -->
    <?php if (!empty($event_title)) : ?>
        <!--
        <div class="event-section-title">
            <h2 class="fw-bold text-uppercase mb-0">
                <?php echo esc_html($event_title); ?>
            </h2>
        </div>
        -->
    <?php endif; ?>

    <!-- GAMBAR RESPONSIVE FULL WIDTH -->
    <div class="event-graphic-full-wrap">
        <picture class="event-picture">

            <!-- Khusus layar mobile: portrait -->
            <source
                media="(max-width: 767.98px)"
                srcset="<?php echo esc_url($event_image_mobile); ?>"
            >

            <!-- Desktop: landscape -->
            <img
                src="<?php echo esc_url($event_image_desktop); ?>"
                alt="<?php echo esc_attr($event_title); ?>"
                class="event-full-image"
                loading="lazy"
                decoding="async"
            >

        </picture>
    </div>

</section>

<style>
/* Section full width */
.intervention-event-section {
    position: relative;
    width: 100%;
    max-width: 100%;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden;
    background: #fff;
}

/* Judul overlay */
.intervention-event-section .event-section-title {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    padding: 24px 0 0 48px;
}

.intervention-event-section .event-section-title h2 {
    font-size: 34px;
    letter-spacing: 0.5px;
    color: #1A202C;
}

/* Wrapper gambar */
.event-graphic-full-wrap {
    display: block;
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
    line-height: 0;
}

/* Picture mengikuti lebar container */
.event-graphic-full-wrap .event-picture {
    display: block;
    width: 100%;
}

/* Gambar mengikuti rasio asli */
.event-graphic-full-wrap .event-full-image {
    display: block;
    width: 100%;
    max-width: 100%;
    height: auto;
    margin: 0;
    padding: 0;
    transition: transform 0.35s ease;
}

/* Efek hover hanya untuk perangkat dengan mouse */
@media (hover: hover) and (pointer: fine) {
    .event-graphic-full-wrap:hover .event-full-image {
        transform: scale(1.008);
    }
}

/* Mobile */
@media (max-width: 767.98px) {
    .intervention-event-section .event-section-title {
        padding: 12px 0 0 16px;
    }

    .intervention-event-section .event-section-title h2 {
        font-size: 20px;
    }
}
</style>
