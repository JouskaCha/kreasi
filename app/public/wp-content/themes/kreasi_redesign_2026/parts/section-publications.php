<?php
/**
 * Template Part: Section Publikasi Homepage (Red Background + 4 Dynamic Latest Publications + 3D Hover Effect)
 * Sesuai PRD FR-03: Menampilkan 4 publikasi terbaru dari WordPress, kartu terhubung ke single publikasi, CTA ke kanonis /publikasi/.
 *
 * @package kreasi_redesign_2026
 */

$pub_cat_ids = function_exists('kreasi_get_publikasi_category_ids') ? kreasi_get_publikasi_category_ids() : array();

$pub_query_args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 4,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
);

if (!empty($pub_cat_ids)) {
    $pub_query_args['category__in'] = $pub_cat_ids;
} else {
    $pub_query_args['category_name'] = 'publikasi';
}

$pub_query = new WP_Query($pub_query_args);
$has_dynamic_publications = $pub_query->have_posts();

// =========================================================================
// PENGATURAN HANDLE KETIKA 0 POST / KOSONG (PUBLIKASI HOMEPAGE)
// =========================================================================
// OPSI A (AKTIF): Sembunyikan seluruh section publikasi jika belum ada post di database
if (!$has_dynamic_publications) {
    return;
}

// OPSI B (NONAKTIF / COMMENT): Jika ingin tetap menampilkan section ini saat 0 post,
// beri komentar (//) pada baris OPSI A di atas, lalu tentukan Opsi pada bagian kartu di bawah.

// Sample fallback data dari tema jika belum ada post di WordPress
$default_publications = function_exists('kreasi_get_default_publications') ? kreasi_get_default_publications() : array(
    array(
        'title' => 'Nota Kesepahaman (MoU) Save the Children dan Kementerian Pendidikan D...',
        'tag'   => 'Buletin',
        'image' => get_template_directory_uri() . '/assets/images/pub-cover-2.png',
        'link'  => home_url('/publikasi/'),
    ),
    array(
        'title' => 'Jejak KREASI - April Mei 2026',
        'tag'   => 'Buletin',
        'image' => get_template_directory_uri() . '/assets/images/pub-cover-1.png',
        'link'  => home_url('/publikasi/'),
    ),
    array(
        'title' => '4 Kata Ajaib - Poster KREASI July 2026',
        'tag'   => 'KIE',
        'image' => get_template_directory_uri() . '/assets/images/pub-cover-4.png',
        'link'  => home_url('/publikasi/'),
    ),
    array(
        'title' => 'Jejak KREASI - Maret 2026',
        'tag'   => 'Buletin',
        'image' => get_template_directory_uri() . '/assets/images/pub-cover-3.png',
        'link'  => home_url('/publikasi/'),
    ),
);
?>

<section class="publications-section py-5 text-white position-relative overflow-hidden" style="background-color: #D8232A;">
    <div class="container py-lg-4">
        <div class="row align-items-center gy-4 gy-lg-0">

            <!-- SISI KIRI: TITLE, SUBTITLE & CTA BUTTON (FIGMA) -->
            <div class="col-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                <h2 class="text-white text-uppercase mb-3" style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(38px, 4vw, 56px); letter-spacing: 1.5px; line-height: 1.1;">
                    <?php echo esc_html(kreasi_t('publications_title', 'PUBLIKASI', 'PUBLICATIONS')); ?>
                </h2>
                <p class="text-white mb-4" style="font-family: 'Lato', sans-serif; font-size: 14px; opacity: 0.95; line-height: 1.6;">
                    <?php echo esc_html(kreasi_t('publications_subtitle', 'Dari buletin bulanan, hingga berbagai bahan ajar seperti poster, dan permainan, terus kami buat untuk mendukung implementasi program.', 'From monthly bulletins to learning materials such as posters and games, we continuously create them to support program implementation.')); ?>
                </p>
                <!-- CTA Button menuju kanonis /publikasi/ -->
                <a href="<?php echo esc_url(home_url('/publikasi/')); ?>" 
                   class="btn text-white px-4 py-2.5 text-uppercase shadow-sm publications-cta-btn d-inline-flex align-items-center justify-content-center" 
                   style="background-color: #0E2A5D; border-radius: 6px; font-family: 'Oswald', sans-serif; font-size: 12px; letter-spacing: 0.5px; transition: all 0.35s ease;">
                    <span><?php echo esc_html(kreasi_t('view_all_publications', 'LIHAT PUBLIKASI LAINNYA', 'VIEW ALL PUBLICATIONS')); ?></span>
                    <span class="btn-arrow ms-2">→</span>
                </a>
            </div>

            <!-- SISI KANAN: 4 CARDS PUBLIKASI TERBARU (PROPORSIONAL DENGAN GAP OPTIMAL) -->
            <div class="col-12 col-lg-9 col-xl-9">
                <div class="row g-3 g-xl-4 flex-nowrap overflow-x-auto flex-md-wrap pt-2 pt-md-3 pb-3 pb-md-0 mobile-horizontal-scroll">
                    
                    <?php if ($has_dynamic_publications) : 
                        while ($pub_query->have_posts()) : $pub_query->the_post();
                            $post_id    = get_the_ID();
                            $card_title = get_the_title();
                            $card_link  = get_permalink();
                            
                            // Tag Kategori Anak
                            $cat_obj    = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category($post_id) : null;
                            $tag_label  = $cat_obj ? $cat_obj->name : 'Buletin';

                            // Cover Image
                            if (has_post_thumbnail($post_id)) {
                                $card_image = get_the_post_thumbnail_url($post_id, 'medium_large');
                            } else {
                                $idx = ($pub_query->current_post % count($default_publications));
                                $card_image = $default_publications[$idx]['image'];
                            }
                    ?>
                        <div class="col-8 col-sm-6 col-md-3 flex-shrink-0 flex-md-shrink-1">
                            <a href="<?php echo esc_url($card_link); ?>" class="text-decoration-none d-block h-100">
                                <div class="publication-card d-flex flex-column h-100 position-relative">

                                    <!-- COVER IMAGE CONTAINER WITH 3D LAYER SHADOW (ASPECT RATIO 1 / 1.38) -->
                                    <div class="publication-cover-wrap position-relative mb-3" style="aspect-ratio: 1 / 1.38; width: 100%;">
                                        <!-- 3D RED/WHITE STACKED SHADOW LAYER -->
                                        <div class="pub-cover-shadow position-absolute rounded-3" 
                                             style="top: 6px; left: 6px; width: 100%; height: 100%; background-color: #ffffff; opacity: 30%; border: 1px solid rgba(255,255,255,0.3); z-index: 1;"></div>
                                        
                                        <!-- MAIN COVER IMAGE -->
                                        <div class="pub-cover-main position-absolute top-0 start-0 w-100 h-100 rounded-3 overflow-hidden shadow-sm"
                                            style="background-color: #ffffff; z-index: 2;">
                                            <img src="<?php echo esc_url($card_image); ?>"
                                                alt="<?php echo esc_attr($card_title); ?>"
                                                class="w-100 h-100 object-fit-cover pub-cover-img">
                                        </div>
                                    </div>

                                    <!-- TAG BADGE -->
                                    <div class="mb-2">
                                        <span class="badge border border-white text-white rounded-pill fw-normal" style="font-family: 'Lato', sans-serif; font-size: 10.5px; padding: 3px 10px; background-color: rgba(255,255,255,0.12);">
                                            📁 <?php echo esc_html(kreasi_translate_term($tag_label)); ?>
                                        </span>
                                    </div>

                                    <!-- TITLE (2 BARIS DENGAN KETINGGIAN KONSISTEN) -->
                                    <h3 class="text-white fw-medium mb-0" style="font-family: 'Oswald', sans-serif; font-size: 13.5px; line-height: 1.4; display: -webkit-box; line-clamp: 2; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; letter-spacing: 0.2px;">
                                        <?php echo esc_html($card_title); ?>
                                    </h3>
                                </div>
                            </a>
                        </div>
                    <?php 
                        endwhile; 
                        wp_reset_postdata(); 
                    else : 
                        // =========================================================================
                        // HANDLE KETIKA 0 POST PADA SISI KARTU PUBLIKASI
                        // =========================================================================

                        // -------------------------------------------------------------------------
                        // OPSI 1 (AKTIF): Pesan bersih bahwa publikasi belum tersedia
                        // -------------------------------------------------------------------------
                    ?>
                        <div class="col-12 py-4">
                            <p class="text-white-50 fst-italic mb-0" style="font-family: 'Lato', sans-serif; font-size: 14px;">
                                <?php echo esc_html(kreasi_t('no_publications', 'Belum ada publikasi yang tersedia saat ini.', 'No publications available at this time.')); ?>
                            </p>
                        </div>
                    <?php
                        // -------------------------------------------------------------------------
                        // OPSI 2 (NONAKTIF / COMMENT): Contoh Fallback Sample Mockup dari Desain
                        // Buka tanda komentar (/* ... */) jika ingin menampilkan kartu contoh.
                        // -------------------------------------------------------------------------
                        /*
                        foreach (array_slice($default_publications, 0, 4) as $pub) :
                            $sample_tag = isset($pub['tag']) ? $pub['tag'] : 'Buletin';
                            $sample_img = isset($pub['image']) ? $pub['image'] : (isset($pub['img']) ? $pub['img'] : '');
                            $sample_url = isset($pub['link']) ? $pub['link'] : home_url('/publikasi/');
                    ?>
                        <div class="col-8 col-sm-6 col-md-3 flex-shrink-0 flex-md-shrink-1">
                            <a href="<?php echo esc_url($sample_url); ?>" class="text-decoration-none d-block h-100">
                                <div class="publication-card d-flex flex-column h-100 position-relative">

                                    <!-- COVER IMAGE CONTAINER WITH 3D LAYER SHADOW (ASPECT RATIO 1 / 1.38) -->
                                    <div class="publication-cover-wrap position-relative mb-3" style="aspect-ratio: 1 / 1.38; width: 100%;">
                                        <div class="pub-cover-shadow position-absolute rounded-3" 
                                             style="top: 6px; left: 6px; width: 100%; height: 100%; background-color: #ffffff; opacity: 30%; border: 1px solid rgba(255,255,255,0.3); z-index: 1;"></div>
                                        
                                        <div class="pub-cover-main position-absolute top-0 start-0 w-100 h-100 rounded-3 overflow-hidden shadow-sm"
                                            style="background-color: #ffffff; z-index: 2;">
                                            <img src="<?php echo esc_url($sample_img); ?>"
                                                alt="<?php echo esc_attr($pub['title']); ?>"
                                                class="w-100 h-100 object-fit-cover pub-cover-img">
                                        </div>
                                    </div>

                                    <!-- TAG BADGE -->
                                    <div class="mb-2">
                                        <span class="badge border border-white text-white rounded-pill fw-normal" style="font-family: 'Lato', sans-serif; font-size: 10.5px; padding: 3px 10px; background-color: rgba(255,255,255,0.12);">
                                            📁 <?php echo esc_html(kreasi_translate_term($sample_tag)); ?>
                                        </span>
                                    </div>

                                    <!-- TITLE -->
                                    <h3 class="text-white fw-medium mb-0" style="font-family: 'Oswald', sans-serif; font-size: 13.5px; line-height: 1.4; display: -webkit-box; line-clamp: 2; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; letter-spacing: 0.2px;">
                                        <?php echo esc_html($pub['title']); ?>
                                    </h3>
                                </div>
                            </a>
                        </div>
                    <?php 
                        endforeach; 
                        */
                    endif; 
                    ?>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- STYLING HOVER PUBLIKASI & SEMBUNYIKAN SCROLLBAR -->
<style>
    .mobile-horizontal-scroll {
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    .mobile-horizontal-scroll::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    @media (max-width: 767.98px) {
        .mobile-horizontal-scroll {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .mobile-horizontal-scroll > div {
            scroll-snap-align: start;
        }
    }

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

    .publication-card:hover .pub-cover-main {
        transform: translate(-5px, -6px) rotate(-3deg);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.35) !important;
    }

    .publication-card:hover .pub-cover-shadow {
        transform: translate(6px, 8px) rotate(3.5deg);
        opacity: 0.5;
        background-color: #ffffff !important;
    }

    .publication-card:hover .pub-cover-img {
        transform: scale(1.04);
    }

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