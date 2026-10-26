<?php
/**
 * Template Part: Section Event Homepage
 * Sesuai PRD FR-07: Membaca pengaturan dari WordPress Admin (kreasi_get_event_settings()),
 * mendukung Banner Gambar Responsif (Desktop/Mobile), Embed YouTube Responsif, dan Tombol CTA.
 *
 * @package kreasi_redesign_2026
 */

$event_settings = function_exists('kreasi_get_event_settings') ? kreasi_get_event_settings(true) : array();

// 1. Cek apakah section diaktifkan oleh admin
if (isset($event_settings['show_section']) && empty($event_settings['show_section'])) {
    return; // Sembunyikan section jika dinonaktifkan
}

$event_title = function_exists('kreasi_t') 
    ? kreasi_t('event_title', 'AREA INTERVENSI & MITRA PELAKSANA', 'INTERVENTION AREAS & IMPLEMENTING PARTNERS') 
    : 'AREA INTERVENSI & MITRA PELAKSANA';

$event_image_desktop = !empty($event_settings['image_desktop']) ? $event_settings['image_desktop'] : '';
$event_image_mobile  = !empty($event_settings['image_mobile']) ? $event_settings['image_mobile'] : $event_image_desktop;

$show_video  = !empty($event_settings['show_video']);
$youtube_url = !empty($event_settings['youtube_url']) ? $event_settings['youtube_url'] : '';
$youtube_id  = function_exists('kreasi_extract_youtube_id') ? kreasi_extract_youtube_id($youtube_url) : '';

$show_cta = !empty($event_settings['show_cta']);
$cta_text = !empty($event_settings['cta_text']) ? $event_settings['cta_text'] : '';
$cta_url  = !empty($event_settings['cta_url']) ? $event_settings['cta_url'] : '';

$has_event_content = !empty($event_image_desktop) 
    || ($show_cta && !empty($cta_url) && !empty($cta_text)) 
    || ($show_video && !empty($youtube_id));

// =========================================================================
// PENGATURAN HANDLE KETIKA KONTEN EVENT KOSONG (HOMEPAGE EVENT)
// =========================================================================
// OPSI A (AKTIF): Sembunyikan seluruh section jika belum ada banner/konten event yang diisi
if (!$has_event_content) {
    return;
}

// OPSI B (NONAKTIF / COMMENT): Jika ingin tetap menampilkan wrapper section saat belum ada konten,
// beri tanda komentar (//) pada baris OPSI A di atas.
?>

<!-- SECTION AREA INTERVENSI & EVENT -->
<section class="intervention-event-section position-relative overflow-hidden bg-white">

    <!-- GAMBAR RESPONSIVE FULL WIDTH (DESKTOP & MOBILE) -->
    <?php if (!empty($event_image_desktop)) : ?>
        <div class="event-graphic-full-wrap position-relative">
            <picture class="event-picture">
                <!-- Khusus layar mobile: portrait / compact -->
                <?php if (!empty($event_image_mobile) && $event_image_mobile !== $event_image_desktop) : ?>
                    <source media="(max-width: 767.98px)" srcset="<?php echo esc_url($event_image_mobile); ?>">
                <?php endif; ?>
                <!-- Desktop: landscape -->
                <img src="<?php echo esc_url($event_image_desktop); ?>"
                     alt="<?php echo esc_attr($event_title); ?>"
                     class="event-full-image"
                     loading="lazy"
                     decoding="async">
            </picture>

            <!-- OVERLAY CTA BUTTON (JIKA DIAKTIFKAN) -->
            <?php if ($show_cta && !empty($cta_url) && !empty($cta_text)) : ?>
                <div class="event-cta-overlay position-absolute bottom-0 start-50 translate-middle-x mb-4 mb-md-5 text-center" style="z-index: 5;">
                    <a href="<?php echo esc_url($cta_url); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-event-cta text-white px-4 py-2 text-uppercase fw-bold shadow-lg"
                       style="background-color: #062172; border-radius: 6px; font-family: 'Oswald', sans-serif; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s ease;">
                        <?php echo esc_html($cta_text); ?> &rarr;
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif ($show_cta && !empty($cta_url) && !empty($cta_text)) : ?>
        <!-- CTA BUTTON JIKA BANNER GAMBAR DIKOSONGKAN -->
        <div class="event-cta-standalone py-5 text-center bg-light">
            <div class="container">
                <a href="<?php echo esc_url($cta_url); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn btn-event-cta text-white px-4 py-3 text-uppercase fw-bold shadow"
                   style="background-color: #062172; border-radius: 6px; font-family: 'Oswald', sans-serif; font-size: 15px; letter-spacing: 0.5px; transition: all 0.3s ease;">
                    <?php echo esc_html($cta_text); ?> &rarr;
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- EMBED VIDEO YOUTUBE RESPONSIVE (JIKA DIAKTIFKAN OLEH ADMIN) -->
    <?php if ($show_video && !empty($youtube_id)) : ?>
        <div class="event-video-section py-5" style="background-color: #0B2055;">
            <div class="container px-4 px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10">
                        <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg border border-secondary">
                            <iframe src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($youtube_id); ?>" 
                                    title="Video Event KREASI" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

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
}

.btn-event-cta:hover {
    background-color: #D8232A !important;
}
</style>
