<?php
/**
 * Template Name: Pustaka / Publikasi
 * The template for displaying the Pustaka (Publikasi) main page & per-category page.
 *
 * @package kreasi_redesign_2026
 */

get_header();

// 1. Deteksi apakah sedang membuka Halaman Per Category atau Halaman Utama
$current_cat_slug = '';
if (!empty($_GET['kategori'])) {
    $current_cat_slug = sanitize_title($_GET['kategori']);
} elseif (!empty($_GET['category'])) {
    $current_cat_slug = sanitize_title($_GET['category']);
} elseif (!empty($_GET['cat'])) {
    $current_cat_slug = sanitize_title($_GET['cat']);
} elseif (is_category()) {
    $cat_obj = get_queried_object();
    if ($cat_obj && !is_wp_error($cat_obj)) {
        $current_cat_slug = $cat_obj->slug;
    }
}

$search_keyword = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

// Jika kategori ditentukan (e.g. ?kategori=buletin), aktifkan Versi 2 (Per Category)
$is_category_view = !empty($current_cat_slug);

// URL dasar
$base_page_url = home_url('/publikasi/');
$child_categories = function_exists('kreasi_get_publikasi_child_categories') ? kreasi_get_publikasi_child_categories() : array();
$default_publications = function_exists('kreasi_get_default_publications') ? kreasi_get_default_publications() : array();

// Tentukan judul kategori jika berada pada tampilan per category
$cat_title_display = 'BULETIN';
if ($is_category_view) {
    $found_cat = get_category_by_slug($current_cat_slug);
    if ($found_cat) {
        $cat_title_display = $found_cat->name;
    } else {
        foreach ($child_categories as $c) {
            if ($c->slug === $current_cat_slug) {
                $cat_title_display = $c->name;
                break;
            }
        }
        if ($cat_title_display === 'BULETIN' && !empty($current_cat_slug)) {
            $cat_title_display = ucwords(str_replace('-', ' ', $current_cat_slug));
        }
    }
}
?>

<main id="primary" class="site-main page-pustaka bg-white pb-5">

    <?php if (!$is_category_view) : ?>
        <!-- =========================================================
             VERSI 1: HALAMAN UTAMA PUBLIKASI / PUSTAKA (SESUAI GAMBAR 1)
        ========================================================== -->

        <!-- HERO HEADER BANNER: MERAH SOLID + TITLE PUSTAKA -->
        <section class="pustaka-hero-banner text-center text-white d-flex align-items-center justify-content-center"
                 style="background-color: #D8232A; min-height: 220px; padding: 50px 15px;">
            <div class="container">
                <h1 class="page-title text-white fw-bold mb-0 text-uppercase" 
                    style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(48px, 5.5vw, 76px); letter-spacing: 1px;">
                    <?php echo esc_html(kreasi_t('pustaka_title', 'PUSTAKA', 'LIBRARY')); ?>
                </h1>
            </div>
        </section>

        <!-- SECTIONS PER KATEGORI (BULETIN, REPOSITORI PENGETAHUAN, MATERI PEMBELAJARAN) -->
        <?php 
        $rendered_categories_count = 0;
        foreach ($child_categories as $idx => $cat) : 
            $section_bg = ($idx % 2 === 1) ? '#F8F9FA' : '#FFFFFF';
            $cat_slug   = $cat->slug;
            $cat_name   = $cat->name;
            $cat_url    = add_query_arg('kategori', $cat_slug, $base_page_url);

            // Query post untuk kategori ini
            $cat_query_args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 5,
                'category_name'  => $cat_slug,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            $cat_query = new WP_Query($cat_query_args);
            $has_wp_posts = $cat_query->have_posts();

            // =========================================================================
            // PENGATURAN HANDLE KETIKA KATEGORI INI KOSONG (0 POST)
            // =========================================================================
            // OPSI A (AKTIF): Sembunyikan section kategori jika belum ada postingan di kategori ini
            if (!$has_wp_posts) {
                continue;
            }

            // OPSI B (NONAKTIF / COMMENT): Jika ingin tetap menampilkan section kategori dengan contoh mockup / pesan kosong,
            // beri komentar (//) pada baris OPSI A ("continue;") di atas dan tentukan opsi kartu di bawah.

            $rendered_categories_count++;
        ?>
            <section class="pustaka-category-section py-5" style="background-color: <?php echo esc_attr($section_bg); ?>;">
                <div class="container px-4 px-lg-5">
                    
                    <!-- HEADER SECTION: KIRI TITLE, KANAN LIHAT SEMUA -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="section-category-title mb-0 text-uppercase" 
                            style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(26px, 3vw, 36px); font-weight: 700; color: #111111; letter-spacing: 0.5px;">
                            <?php echo esc_html(kreasi_translate_term($cat_name)); ?>
                        </h2>
                        
                        <a href="<?php echo esc_url($cat_url); ?>" 
                           class="btn btn-lihat-semua px-3 py-2 text-white text-uppercase fw-bold shadow-sm"
                           style="background-color: #D8232A; font-family: 'Oswald', sans-serif; font-size: 13px; letter-spacing: 0.5px; border-radius: 4px; transition: all 0.25s ease;">
                            <?php echo esc_html(kreasi_t('view_all', 'LIHAT SEMUA', 'VIEW ALL')); ?>
                        </a>
                    </div>

                    <!-- ROW PUBLICATION CARDS (4 KOLOM DENGAN HORIZONTAL SCROLL PEEK) -->
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 flex-nowrap overflow-x-auto flex-lg-wrap pb-3 pb-lg-0 publication-cards-scroll pt-2">
                        
                        <?php if ($has_wp_posts) : 
                            while ($cat_query->have_posts()) : $cat_query->the_post(); 
                                $post_id     = get_the_ID();
                                $card_title  = get_the_title();
                                $card_link   = get_permalink();
                                $card_date   = get_the_date('j M Y');
                                
                                // Tag daerah atau child category badge
                                $tag_obj     = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag($post_id) : null;
                                $tag_label   = $tag_obj ? $tag_obj->name : $cat_name;
                                
                                // Cover image
                                if (has_post_thumbnail($post_id)) {
                                    $card_image = get_the_post_thumbnail_url($post_id, 'medium_large');
                                } else {
                                    $sample_idx = ($cat_query->current_post % count($default_publications));
                                    $card_image = $default_publications[$sample_idx]['image'];
                                }
                        ?>
                                <div class="col-9 col-sm-6 col-md-4 col-lg-3 flex-shrink-0 flex-lg-shrink-1">
                                    <div class="publication-item d-flex flex-column h-100">
                                        <!-- Cover Image with 3D Stacked Shadow (Identik Front-Page) -->
                                        <div class="publication-cover-wrap position-relative mb-3" style="aspect-ratio: 1 / 1.38;">
                                            <div class="pub-cover-shadow position-absolute rounded-3" 
                                                 style="top: 6px; left: 6px; width: 100%; height: 100%; background-color: #E2E8F0; opacity: 0.8; border: 1px solid #CBD5E1; z-index: 1;"></div>
                                            <div class="pub-cover-main position-absolute top-0 start-0 w-100 h-100 rounded-3 overflow-hidden shadow-sm"
                                                 style="background-color: #ffffff; z-index: 2;">
                                                <a href="<?php echo esc_url($card_link); ?>" class="d-block w-100 h-100">
                                                    <img src="<?php echo esc_url($card_image); ?>" 
                                                         alt="<?php echo esc_attr($card_title); ?>" 
                                                         class="w-100 h-100 object-fit-cover pub-cover-img publication-cover-img">
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Metadata Bar (Tag + Date) -->
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="border: 1px solid #062172; color: #062172; font-family: 'Lato', sans-serif; font-size: 11px; padding: 2px 8px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                                <?php echo esc_html(kreasi_translate_term($tag_label)); ?>
                                            </span>
                                            <span class="text-muted d-inline-flex align-items-center" style="font-family: 'Lato', sans-serif; font-size: 11px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1 text-secondary">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg>
                                                <?php echo esc_html($card_date); ?>
                                            </span>
                                        </div>

                                        <!-- Judul -->
                                        <h3 class="publication-title mb-0" 
                                            style="font-family: 'Oswald', sans-serif; font-size: 15px; font-weight: 600; line-height: 1.35; color: #111111;">
                                            <a href="<?php echo esc_url($card_link); ?>" class="text-decoration-none text-dark publication-title-link">
                                                <?php echo esc_html($card_title); ?>
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                        <?php endwhile; wp_reset_postdata(); else : 
                            // =========================================================================
                            // HANDLE KETIKA 0 POST PADA SLIDER KATEGORI
                            // =========================================================================

                            // -------------------------------------------------------------------------
                            // OPSI 1 (AKTIF): Pesan bersih bahwa belum ada publikasi pada kategori ini
                            // -------------------------------------------------------------------------
                        ?>
                            <div class="col-12 py-3">
                                <p class="text-muted fst-italic mb-0" style="font-family: 'Lato', sans-serif; font-size: 14px;">
                                    <?php echo esc_html(kreasi_t('no_publications_cat', 'Belum ada publikasi pada kategori ini.', 'No publications in this category yet.')); ?>
                                </p>
                            </div>
                        <?php
                            // -------------------------------------------------------------------------
                            // OPSI 2 (NONAKTIF / COMMENT): Tampilkan data sampel sesuai desain Figma
                            // Buka tanda komentar (/* ... */) jika ingin mengaktifkan kartu contoh.
                            // -------------------------------------------------------------------------
                            /*
                            foreach ($default_publications as $pub) : 
                        ?>
                                <div class="col-9 col-sm-6 col-md-4 col-lg-3 flex-shrink-0 flex-lg-shrink-1">
                                    <div class="publication-item d-flex flex-column h-100">
                                        <!-- Cover Image with 3D Stacked Shadow (Identik Front-Page) -->
                                        <div class="publication-cover-wrap position-relative mb-3" style="aspect-ratio: 1 / 1.38;">
                                            <div class="pub-cover-shadow position-absolute rounded-3" 
                                                 style="top: 6px; left: 6px; width: 100%; height: 100%; background-color: #E2E8F0; opacity: 0.8; border: 1px solid #CBD5E1; z-index: 1;"></div>
                                            <div class="pub-cover-main position-absolute top-0 start-0 w-100 h-100 rounded-3 overflow-hidden shadow-sm"
                                                 style="background-color: #ffffff; z-index: 2;">
                                                <a href="<?php echo esc_url($pub['link']); ?>" class="d-block w-100 h-100">
                                                    <img src="<?php echo esc_url($pub['image']); ?>" 
                                                         alt="<?php echo esc_attr($pub['title']); ?>" 
                                                         class="w-100 h-100 object-fit-cover pub-cover-img publication-cover-img">
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Metadata Bar (Tag + Date) -->
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="border: 1px solid #062172; color: #062172; font-family: 'Lato', sans-serif; font-size: 11px; padding: 2px 8px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                                <?php echo esc_html($pub['tag']); ?>
                                            </span>
                                            <span class="text-muted d-inline-flex align-items-center" style="font-family: 'Lato', sans-serif; font-size: 11px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1 text-secondary">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg>
                                                <?php echo esc_html($pub['date']); ?>
                                            </span>
                                        </div>

                                        <!-- Judul -->
                                        <h3 class="publication-title mb-0" 
                                            style="font-family: 'Oswald', sans-serif; font-size: 15px; font-weight: 600; line-height: 1.35; color: #111111;">
                                            <a href="<?php echo esc_url($pub['link']); ?>" class="text-decoration-none text-dark publication-title-link">
                                                <?php echo esc_html($pub['title']); ?>
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                        <?php 
                            endforeach; 
                            */
                        endif; 
                        ?>

                    </div>

                </div>
            </section>
        <?php endforeach; ?>

        <?php if ($rendered_categories_count === 0) : ?>
            <!-- STATE KETIKA SEMUA KATEGORI MASIH KOSONG -->
            <div class="container py-5 text-center">
                <div class="p-5 my-4 rounded-4 bg-white shadow-sm border">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                    <h3 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; color: #1E293B;">
                        <?php echo esc_html(kreasi_t('no_publications_all', 'Belum Ada Publikasi yang Diterbitkan', 'No Publications Published Yet')); ?>
                    </h3>
                    <p class="text-muted mb-0" style="font-family: 'Lato', sans-serif; font-size: 15px;">
                        <?php echo esc_html(kreasi_t('no_publications_all_desc', 'Publikasi dan dokumen materi belajar akan segera tersedia di halaman ini.', 'Publications and learning materials will be available here soon.')); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <!-- =========================================================
             VERSI 2: HALAMAN PER CATEGORY (SESUAI GAMBAR 2)
        ========================================================== -->

        <!-- HERO HEADER BANNER: MERAH SOLID + NAMA KATEGORI -->
        <section class="pustaka-hero-banner text-center text-white d-flex align-items-center justify-content-center"
                 style="background-color: #D8232A; min-height: 220px; padding: 50px 15px 75px;">
            <div class="container">
                <h1 class="page-title text-white fw-bold mb-0 text-uppercase" 
                    style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(48px, 5.5vw, 76px); letter-spacing: 1px;">
                    <?php echo esc_html(kreasi_translate_term($cat_title_display)); ?>
                </h1>
            </div>
        </section>

        <!-- FLOATING SEARCH BAR -->
        <div class="container px-4 px-lg-5 position-relative" style="z-index: 10; margin-top: -50px;">
            <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 bg-white mb-5 mx-auto" style="max-width: 900px;">
                <form method="get" action="<?php echo esc_url($base_page_url); ?>">
                    <input type="hidden" name="kategori" value="<?php echo esc_attr($current_cat_slug); ?>">
                    <div class="row g-2 align-items-center">
                        <div class="col-8 col-md-9 col-lg-10">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </span>
                                <input type="text" name="q" value="<?php echo esc_attr($search_keyword); ?>" 
                                       class="form-control border-start-0 py-2 ps-2" 
                                       placeholder="<?php echo esc_attr(kreasi_t('keywords_placeholder', 'Kata kunci...', 'keywords...')); ?>" 
                                       style="font-family: 'Lato', sans-serif; font-size: 14px;">
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-lg-2">
                            <button type="submit" class="btn w-100 py-2 text-white text-uppercase fw-semibold"
                                    style="background-color: #062172; border-radius: 6px; font-family: 'Oswald', sans-serif; font-size: 13px; letter-spacing: 0.5px;">
                                <?php echo esc_html(kreasi_t('telusuri', 'TELUSURI', 'SEARCH')); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- GRID 4 KOLOM PUBLIKASI -->
        <div class="container px-4 px-lg-5 mb-5">
            <?php
            $paged = 1;
            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif (get_query_var('page')) {
                $paged = get_query_var('page');
            } elseif (isset($_GET['paged'])) {
                $paged = max(1, (int) $_GET['paged']);
            }

            $cat_grid_args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 12,
                'paged'          => $paged,
                'category_name'  => $current_cat_slug,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            if (!empty($search_keyword)) {
                $cat_grid_args['s'] = $search_keyword;
            }

            $cat_grid_query = new WP_Query($cat_grid_args);
            $has_grid_posts = $cat_grid_query->have_posts();
            ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
                <?php if ($has_grid_posts) : 
                    while ($cat_grid_query->have_posts()) : $cat_grid_query->the_post(); 
                        $post_id     = get_the_ID();
                        $card_title  = get_the_title();
                        $card_link   = get_permalink();
                        $card_date   = get_the_date('j M Y');
                        
                        $tag_obj     = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag($post_id) : null;
                        $tag_label   = $tag_obj ? $tag_obj->name : $cat_title_display;
                        
                        if (has_post_thumbnail($post_id)) {
                            $card_image = get_the_post_thumbnail_url($post_id, 'medium_large');
                        } else {
                            $sample_idx = ($cat_grid_query->current_post % count($default_publications));
                            $card_image = $default_publications[$sample_idx]['image'];
                        }
                ?>
                        <div class="col">
                            <div class="publication-item d-flex flex-column h-100">
                                <!-- Cover Image with 3D Stacked Shadow (Identik Front-Page) -->
                                <div class="publication-cover-wrap position-relative mb-3" style="aspect-ratio: 1 / 1.38;">
                                    <div class="pub-cover-shadow position-absolute rounded-3" 
                                         style="top: 6px; left: 6px; width: 100%; height: 100%; background-color: #E2E8F0; opacity: 0.8; border: 1px solid #CBD5E1; z-index: 1;"></div>
                                    <div class="pub-cover-main position-absolute top-0 start-0 w-100 h-100 rounded-3 overflow-hidden shadow-sm"
                                         style="background-color: #ffffff; z-index: 2;">
                                        <a href="<?php echo esc_url($card_link); ?>" class="d-block w-100 h-100">
                                            <img src="<?php echo esc_url($card_image); ?>" 
                                                 alt="<?php echo esc_attr($card_title); ?>" 
                                                 class="w-100 h-100 object-fit-cover pub-cover-img publication-cover-img">
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                          style="border: 1px solid #062172; color: #062172; font-family: 'Lato', sans-serif; font-size: 11px; padding: 2px 8px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        <?php echo esc_html(kreasi_translate_term($tag_label)); ?>
                                    </span>
                                    <span class="text-muted d-inline-flex align-items-center" style="font-family: 'Lato', sans-serif; font-size: 11px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1 text-secondary">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <?php echo esc_html($card_date); ?>
                                    </span>
                                </div>

                                <h3 class="publication-title mb-0" 
                                    style="font-family: 'Oswald', sans-serif; font-size: 15px; font-weight: 600; line-height: 1.35; color: #111111;">
                                    <a href="<?php echo esc_url($card_link); ?>" class="text-decoration-none text-dark publication-title-link">
                                        <?php echo esc_html($card_title); ?>
                                    </a>
                                </h3>
                            </div>
                        </div>
                <?php endwhile; wp_reset_postdata(); else : 
                    // =========================================================================
                    // HANDLE KETIKA 0 POST PADA GRID KATEGORI
                    // =========================================================================

                    // -------------------------------------------------------------------------
                    // OPSI 1 (AKTIF): Pesan kosong bersih informatif ketika belum ada postingan
                    // -------------------------------------------------------------------------
                ?>
                    <div class="col-12 py-5 text-center">
                        <div class="p-5 rounded-4 bg-white shadow-sm border border-light">
                            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                            <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; color: #1E293B;">
                                <?php echo esc_html(kreasi_t('no_publications_found', 'Belum Ada Publikasi', 'No Publications Found')); ?>
                            </h4>
                            <p class="text-muted mb-0" style="font-family: 'Lato', sans-serif; font-size: 14.5px;">
                                <?php echo esc_html(kreasi_t('no_publications_desc', 'Belum ada publikasi yang diterbitkan pada kategori ini.', 'There are no publications published in this category yet.')); ?>
                            </p>
                        </div>
                    </div>
                <?php
                    // -------------------------------------------------------------------------
                    // OPSI 2 (NONAKTIF / COMMENT): Tampilkan 12 item grid mock sesuai desain Gambar 2
                    // Buka tanda komentar (/* ... */) jika ingin mengaktifkan kartu contoh.
                    // -------------------------------------------------------------------------
                    /*
                    for ($m = 0; $m < 12; $m++) :
                        $pub = $default_publications[$m % count($default_publications)];
                ?>
                        <div class="col">
                            <div class="publication-item d-flex flex-column h-100">
                                <!-- Cover Image with 3D Stacked Shadow (Identik Front-Page) -->
                                <div class="publication-cover-wrap position-relative mb-3" style="aspect-ratio: 1 / 1.38;">
                                    <div class="pub-cover-shadow position-absolute rounded-3" 
                                         style="top: 6px; left: 6px; width: 100%; height: 100%; background-color: #E2E8F0; opacity: 0.8; border: 1px solid #CBD5E1; z-index: 1;"></div>
                                    <div class="pub-cover-main position-absolute top-0 start-0 w-100 h-100 rounded-3 overflow-hidden shadow-sm"
                                         style="background-color: #ffffff; z-index: 2;">
                                        <a href="<?php echo esc_url($pub['link']); ?>" class="d-block w-100 h-100">
                                            <img src="<?php echo esc_url($pub['image']); ?>" 
                                                 alt="<?php echo esc_attr($pub['title']); ?>" 
                                                 class="w-100 h-100 object-fit-cover pub-cover-img publication-cover-img">
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                          style="border: 1px solid #062172; color: #062172; font-family: 'Lato', sans-serif; font-size: 11px; padding: 2px 8px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        <?php echo esc_html($pub['tag']); ?>
                                    </span>
                                    <span class="text-muted d-inline-flex align-items-center" style="font-family: 'Lato', sans-serif; font-size: 11px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1 text-secondary">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <?php echo esc_html($pub['date']); ?>
                                    </span>
                                </div>

                                <h3 class="publication-title mb-0" 
                                    style="font-family: 'Oswald', sans-serif; font-size: 15px; font-weight: 600; line-height: 1.35; color: #111111;">
                                    <a href="<?php echo esc_url($pub['link']); ?>" class="text-decoration-none text-dark publication-title-link">
                                        <?php echo esc_html($pub['title']); ?>
                                    </a>
                                </h3>
                            </div>
                        </div>
                <?php 
                    endfor; 
                    */
                endif; 
                ?>
            </div>

            <?php if ($has_grid_posts && $cat_grid_query->max_num_pages > 1) : ?>
            <!-- PAGINATION -->
            <div class="d-flex justify-content-center align-items-center mt-5 pagination-wrapper">
                <nav aria-label="Page navigation">
                    <?php
                    echo paginate_links(array(
                        'base'      => add_query_arg('paged', '%#%'),
                        'format'    => '',
                        'current'   => $paged,
                        'total'     => $cat_grid_query->max_num_pages,
                        'prev_text' => '&lsaquo;',
                        'next_text' => '&rsaquo;',
                        'type'      => 'list',
                    ));
                    ?>
                </nav>
            </div>
            <?php endif; ?>

        </div>

    <?php endif; ?>

</main>

<!-- STYLING KHUSUS HALAMAN PUSTAKA / PUBLIKASI -->
<style>
/* Sembunyikan scrollbar pada container horizontal scroll */
.publication-cards-scroll {
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
}
.publication-cards-scroll::-webkit-scrollbar {
    display: none !important;
}

/* 3D PUBLICATION COVER & HOVER ANIMATION (IDENTIK DENGAN FRONT-PAGE SECTION PUBLIKASI) */
.publication-item {
    cursor: pointer;
}

.publication-item .pub-cover-main {
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    transform-origin: center center;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.publication-item .pub-cover-shadow {
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease, background-color 0.4s ease;
    transform-origin: center center;
}

.publication-item .pub-cover-img,
.publication-item .publication-cover-img {
    transition: transform 0.4s ease;
}

.publication-item:hover .pub-cover-main {
    transform: translate(-5px, -6px) rotate(-3deg);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.22) !important;
}

.publication-item:hover .pub-cover-shadow {
    transform: translate(6px, 8px) rotate(3.5deg);
    opacity: 0.95;
    background-color: #E2E8F0 !important;
}

.publication-item:hover .pub-cover-img,
.publication-item:hover .publication-cover-img {
    transform: scale(1.04);
}

.publication-item:hover .publication-title-link {
    color: #D8232A !important;
}

.publication-title-link:hover {
    color: #D8232A !important;
}

.btn-lihat-semua:hover {
    background-color: #b91c22 !important;
    transform: translateY(-1px);
}

/* Pagination Styling sesuai Gambar 2 */
.pagination-custom .page-link,
.pagination-wrapper .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px !important;
    border: 1px solid #E5E7EB;
    background-color: #FFFFFF;
    color: #4B5563;
    font-family: 'Lato', sans-serif;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    margin: 0 2px;
}

.pagination-custom .page-item.active .page-link,
.pagination-wrapper .page-numbers.current {
    background-color: #062172 !important;
    border-color: #062172 !important;
    color: #FFFFFF !important;
}

.pagination-custom .page-link:hover,
.pagination-wrapper a.page-numbers:hover {
    background-color: #F3F4F6;
    color: #062172;
}

.pagination-custom .page-item.disabled .page-link {
    color: #9CA3AF;
    background-color: transparent;
    border-color: transparent;
}
</style>

<?php get_footer(); ?>
