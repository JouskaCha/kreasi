<?php
/**
 * Template Name: Artikel
 * The template for displaying the article archive and search page.
 *
 * @package kreasi_redesign_2026
 */

get_header();

// 1. Inisialisasi Filter Kategori, Daerah, dan Pencarian
$current_kategori = isset($_GET['kategori']) ? sanitize_title($_GET['kategori']) : '';
$current_daerah   = isset($_GET['daerah']) ? sanitize_title($_GET['daerah']) : '';
$search_keyword   = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : (isset($_GET['s']) ? sanitize_text_field($_GET['s']) : (is_search() ? get_search_query() : ''));

if (empty($current_kategori) && is_category()) {
    $cat_obj = get_queried_object();
    if ($cat_obj && !is_wp_error($cat_obj)) {
        $current_kategori = $cat_obj->slug;
    }
}

if (empty($current_daerah) && is_tag()) {
    $tag_obj = get_queried_object();
    if ($tag_obj && !is_wp_error($tag_obj)) {
        $current_daerah = $tag_obj->slug;
    }
}

// 2. Ambil Kategori ID Parent Artikel & Publikasi serta data master filter
$artikel_cat_ids   = function_exists('kreasi_get_artikel_category_ids') ? kreasi_get_artikel_category_ids() : array();
$publikasi_cat_ids = function_exists('kreasi_get_publikasi_category_ids') ? kreasi_get_publikasi_category_ids() : array();
$child_categories  = function_exists('kreasi_get_artikel_child_categories') ? kreasi_get_artikel_child_categories() : array();
$region_tags       = function_exists('kreasi_get_region_tags_with_counts') ? kreasi_get_region_tags_with_counts() : array();

// 3. Setup WP_Query untuk Halaman Artikel
$paged = 1;
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
} elseif (isset($_GET['paged'])) {
    $paged = max(1, (int) $_GET['paged']);
}

$query_args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 9,
    'paged'               => $paged,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => false,
);

// Filter Parent 'artikel' & Exclusion 'publikasi'
if (!empty($current_kategori) && $current_kategori !== 'semua') {
    $query_args['category_name'] = $current_kategori;
} else {
    if (!empty($artikel_cat_ids)) {
        $query_args['category__in'] = $artikel_cat_ids;
    }
    if (!empty($publikasi_cat_ids)) {
        $query_args['category__not_in'] = $publikasi_cat_ids;
    }
}

// Filter Tag Daerah
if (!empty($current_daerah) && $current_daerah !== 'semua') {
    $query_args['tag'] = $current_daerah;
}

// Filter Pencarian
if (!empty($search_keyword)) {
    $query_args['s'] = $search_keyword;
}

$artikel_query = new WP_Query($query_args);
$total_posts_count = (int) $artikel_query->found_posts;

// Hitung total artikel published untuk badge "Semua Daerah"
$all_articles_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
);
if (!empty($current_kategori) && $current_kategori !== 'semua') {
    $all_articles_args['category_name'] = $current_kategori;
} else {
    if (!empty($artikel_cat_ids)) {
        $all_articles_args['category__in'] = $artikel_cat_ids;
    }
    if (!empty($publikasi_cat_ids)) {
        $all_articles_args['category__not_in'] = $publikasi_cat_ids;
    }
}
$all_articles_query = new WP_Query($all_articles_args);
$total_all_daerah_count = (int) $all_articles_query->found_posts;
if ($total_all_daerah_count === 0) {
    $total_all_daerah_count = 34; // Sesuai desain Figma mockup
}

// URL Dasar untuk Filter
$base_artikel_url = home_url('/artikel/');

// Background Banner Header Artikel (Desktop & Mobile)
$artikel_bg_desktop = get_theme_mod('artikel_header_bg_desktop', '');
$artikel_bg_mobile  = get_theme_mod('artikel_header_bg_mobile', '');

$default_artikel_bg_desktop = get_template_directory_uri() . '/assets/images/bg-header-artikel.png';
$default_artikel_bg_mobile  = get_template_directory_uri() . '/assets/images/bg-header-artikel-mobile.png';

if (empty($artikel_bg_desktop)) {
    $artikel_bg_desktop = $default_artikel_bg_desktop;
}
if (empty($artikel_bg_mobile)) {
    $artikel_bg_mobile = file_exists(get_template_directory() . '/assets/images/bg-header-artikel-mobile.png')
        ? $default_artikel_bg_mobile 
        : $artikel_bg_desktop;
}

// 4. Data Fallback / Mockup Sesuai Desain Figma (9 Kartu Lengkap)
$sample_articles = array(
    array(
        'title'     => 'KREASI Nias Utara Perkuat Kapasitas Penggerak Pendidikan melalui Pelatihan Fasilitator Daerah dan Kepala Sekolah',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Cerita',
        'cat_slug'  => 'cerita',
        'tag_name'  => 'Nias Utara',
        'tag_slug'  => 'nias-utara',
        'date'      => '26 Juli 2026',
        'excerpt'   => 'Sejak mulai mengabdi sebagai guru pada tahun 2007, Karnawati selalu memegang satu keyakinan: setiap anak berhak mendapatkan pendidikan yang layak. Baginya, menjadi pendidik bukan hanya tentang mengajar di ruang kelas, tetapi juga tentang menumbuhkan harapan, terutama bagi anak-anak yang belum sepenuhnya memiliki kesempatan dan dukungan untuk belajar. Semangat itulah yang terus ia bawa hingga kini, ketika ia menjalankan peran sebagai guru sekaligus kepala sekolah dampingan Program KREASI di Kabupaten Kayong Utara.',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail-1.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail-2.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail3.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail-1.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail-2.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail3.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail-1.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail-2.png',
    ),
    array(
        'title'     => 'Melihat Sekolah Melalui Mata Anak: Menyiapkan Fasilitator Daerah untuk Budaya Sekolah Aman dan Nyaman',
        'permalink' => home_url('/artikel/'),
        'cat_name'  => 'Berita & Perkembangan',
        'cat_slug'  => 'berita',
        'tag_name'  => 'Tanggamus',
        'tag_slug'  => 'tanggamus',
        'date'      => '26 Juli 2026',
        'excerpt'   => '',
        'image'     => get_template_directory_uri() . '/assets/images/thumbnail3.png',
    ),
);

// Gabungkan artikel nyata dari WP_Query
$article_items = array();
if ($artikel_query->have_posts()) {
    foreach ($artikel_query->posts as $p) {
        $cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category($p->ID) : null;
        $tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag($p->ID) : null;
        $thumb    = has_post_thumbnail($p->ID) 
            ? get_the_post_thumbnail_url($p->ID, 'large') 
            : get_template_directory_uri() . '/assets/images/thumbnail-1.png';
        
        $article_items[] = array(
            'id'        => $p->ID,
            'title'     => get_the_title($p->ID),
            'permalink' => get_permalink($p->ID),
            'cat_name'  => $cat_obj ? $cat_obj->name : 'Cerita',
            'cat_slug'  => $cat_obj ? $cat_obj->slug : 'cerita',
            'tag_name'  => $tag_obj ? $tag_obj->name : '',
            'tag_slug'  => $tag_obj ? $tag_obj->slug : '',
            'date'      => get_the_date('j F Y', $p->ID),
            'excerpt'   => wp_trim_words(get_the_excerpt($p->ID), 42, '...'),
            'image'     => $thumb,
        );
    }
}

// Cek apakah user sedang melakukan pencarian / filter aktif
$is_filtered = (!empty($current_kategori) && $current_kategori !== 'semua') 
            || (!empty($current_daerah) && $current_daerah !== 'semua') 
            || !empty($search_keyword);

// Jika tidak sedang difilter dan artikel di DB kurang dari 9, lengkapi dengan sample cards
if (!$is_filtered && count($article_items) < 9) {
    $existing_count = count($article_items);
    for ($i = $existing_count; $i < 9; $i++) {
        $article_items[] = $sample_articles[$i];
    }
}
?>

<main id="primary" class="site-main page-artikel bg-light pb-5">

    <!-- ==========================================
         HERO BANNER ARTIKEL (RESPONSIVE DESKTOP & MOBILE)
    =========================================== -->
    <section class="artikel-hero-banner position-relative overflow-hidden text-center text-white d-flex align-items-center justify-content-center"
             style="background-color: #D8232A; min-height: 240px; padding: 45px 15px 85px;">
        
        <!-- Background Banner Responsive Image (Desktop & Mobile) -->
        <picture class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: 1;">
            <source media="(max-width: 767.98px)" srcset="<?php echo esc_url($artikel_bg_mobile); ?>">
            <img src="<?php echo esc_url($artikel_bg_desktop); ?>" alt="Background Header Artikel" class="w-100 h-100 object-fit-cover">
        </picture>

        <div class="container position-relative" style="z-index: 2;">
            <h1 class="page-title text-white fw-bold mb-0 text-uppercase" 
                style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(40px, 5vw, 68px); letter-spacing: 1px;">
                <?php echo esc_html(kreasi_t('nav_artikel', 'ARTIKEL', 'ARTICLE')); ?>
            </h1>
        </div>
    </section>


    <!-- ==========================================
         FLOATING FILTER CARD & SEARCH BAR
    =========================================== -->
    <div class="container px-4 px-lg-5 position-relative" style="z-index: 10; margin-top: -60px;">
        <div class="card border-0 rounded-4 shadow-sm p-4 p-md-4 bg-white mb-5">
            
            <!-- BARIS 1: FILTER KATEGORI (RED CAPSULES) -->
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3">
                
                <!-- Semua Artikel -->
                <?php
                $is_all_cat = (empty($current_kategori) || $current_kategori === 'semua');
                $all_cat_url = add_query_arg(array(
                    'kategori' => 'semua',
                    'daerah'   => $current_daerah ? $current_daerah : false,
                    'q'        => $search_keyword ? $search_keyword : false,
                ), $base_artikel_url);
                ?>
                <a href="<?php echo esc_url($all_cat_url); ?>" 
                   class="btn btn-cat-filter rounded-pill d-inline-flex align-items-center <?php echo $is_all_cat ? 'active' : ''; ?>">
                    <svg width="15" height="15" viewBox="0 0 14 14" fill="none" class="me-1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.25 10.5H12.75M10.5 8.25V12.75M0.75 0.75H5.25V5.25H0.75V0.75ZM8.25 0.75H12.75V5.25H8.25V0.75ZM0.75 8.25H5.25V12.75H0.75V8.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php echo esc_html(kreasi_t('all_articles', 'Semua Artikel', 'All Articles')); ?>
                </a>

                <!-- Child Categories under 'Artikel' (Cerita, Berita, Liputan Media, dll) -->
                <?php foreach ($child_categories as $cat) : 
                    $cat_slug = $cat->slug;
                    $is_active = ($current_kategori === $cat_slug);
                    $cat_url = add_query_arg(array(
                        'kategori' => $cat_slug,
                        'daerah'   => $current_daerah ? $current_daerah : false,
                        'q'        => $search_keyword ? $search_keyword : false,
                    ), $base_artikel_url);
                ?>
                    <a href="<?php echo esc_url($cat_url); ?>" 
                       class="btn btn-cat-filter rounded-pill d-inline-flex align-items-center <?php echo $is_active ? 'active' : ''; ?>">
                        <?php if ($cat_slug === 'cerita') : ?>
                            <svg width="15" height="15" viewBox="0 0 18 18" fill="none" class="me-1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 6.75H12M6 9.75H10.5M13.5 3C14.0967 3 14.669 3.23705 15.091 3.65901C15.5129 4.08097 15.75 4.65326 15.75 5.25V11.25C15.75 11.8467 15.5129 12.419 15.091 12.841C14.669 13.2629 14.0967 13.5 13.5 13.5H9.75L6 15.75V13.5H4.5C3.90326 13.5 3.33097 13.2629 2.90901 12.841C2.48705 12.419 2.25 11.8467 2.25 11.25V5.25C2.25 4.65326 2.48705 4.08097 2.90901 3.65901C3.33097 3.23705 3.90326 3 4.5 3H13.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <?php elseif ($cat_slug === 'berita') : ?>
                            <svg width="15" height="15" viewBox="0 0 14 14" fill="none" class="me-1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.75 2.25H12C12.1989 2.25 12.3897 2.32902 12.5303 2.46967C12.671 2.61032 12.75 2.80109 12.75 3V11.25C12.75 11.6478 12.592 12.0294 12.3107 12.3107C12.0294 12.592 11.6478 12.75 11.25 12.75M11.25 12.75C10.8522 12.75 10.4706 12.592 10.1893 12.3107C9.90804 12.0294 9.75 11.6478 9.75 11.25V1.5C9.75 1.30109 9.67098 1.11032 9.53033 0.96967C9.38968 0.829018 9.19891 0.75 9 0.75H1.5C1.30109 0.75 1.11032 0.829018 0.96967 0.96967C0.829018 1.11032 0.75 1.30109 0.75 1.5V10.5C0.75 11.0967 0.987053 1.1669 1.40901 12.091C1.83097 12.5129 2.40326 12.75 3 12.75H11.25ZM3.75 3.75H6.75M3.75 6.75H6.75M3.75 9.75H6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <?php else : ?>
                            <svg width="15" height="15" viewBox="0 0 18 18" fill="none" class="me-1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.25 6H12.75M5.25 9H12.75M5.25 12H12.75M2.25 4.5C2.25 4.10218 2.40804 3.72064 2.68934 3.43934C2.97064 3.15804 3.35218 3 3.75 3H14.25C14.6478 3 15.0294 3.15804 15.3107 3.43934C15.592 3.72064 15.75 4.10218 15.75 4.5V13.5C15.75 13.8978 15.592 14.2794 15.3107 14.5607C15.0294 14.842 14.6478 15 14.25 15H3.75C3.35218 15 2.97064 14.842 2.68934 14.5607C2.40804 14.2794 2.25 13.8978 2.25 13.5V4.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <?php endif; ?>
                        <?php echo esc_html(kreasi_translate_term($cat->name)); ?>
                    </a>
                <?php endforeach; ?>

            </div>


            <!-- BARIS 2: FILTER DAERAH / TAGS (NAVY CAPSULES DENGAN ANGKA) -->
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-3 px-2">
                
                <!-- Semua Daerah -->
                <?php
                $is_all_daerah = (empty($current_daerah) || $current_daerah === 'semua');
                $all_daerah_url = add_query_arg(array(
                    'daerah'   => 'semua',
                    'kategori' => $current_kategori ? $current_kategori : false,
                    'q'        => $search_keyword ? $search_keyword : false,
                ), $base_artikel_url);
                ?>
                <a href="<?php echo esc_url($all_daerah_url); ?>" 
                   class="btn btn-daerah-filter rounded-pill d-inline-flex align-items-center <?php echo $is_all_daerah ? 'active' : ''; ?>">
                    <?php echo esc_html(kreasi_t('all_regions', 'Semua Daerah', 'All Regions')); ?>
                    <span class="badge rounded-pill ms-1 badge-count"><?php echo esc_html($total_all_daerah_count); ?></span>
                </a>

                <!-- Daftar 8 Kabupaten + Nasional Sesuai Mockup Desain Figma -->
                <?php foreach ($region_tags as $rt) : 
                    $is_active = ($current_daerah === $rt->slug);
                    $rt_url = add_query_arg(array(
                        'daerah'   => $rt->slug,
                        'kategori' => $current_kategori ? $current_kategori : false,
                        'q'        => $search_keyword ? $search_keyword : false,
                    ), $base_artikel_url);
                ?>
                    <a href="<?php echo esc_url($rt_url); ?>" 
                       class="btn btn-daerah-filter rounded-pill d-inline-flex align-items-center <?php echo $is_active ? 'active' : ''; ?>">
                        <?php echo esc_html(kreasi_translate_term($rt->name)); ?>
                        <span class="badge rounded-pill ms-1 badge-count"><?php echo esc_html($rt->count); ?></span>
                    </a>
                <?php endforeach; ?>

            </div>

            <!-- GARIS PEMBATAS HORIZONTAL -->
            <hr class="my-3" style="border-color: #E5E7EB; opacity: 1;">

            <!-- BARIS 3: FORM PENCARIAN & TOMBOL TELUSURI -->
            <form method="get" action="<?php echo esc_url($base_artikel_url); ?>" class="search-filter-form">
                <?php if (!empty($current_kategori)) : ?>
                    <input type="hidden" name="kategori" value="<?php echo esc_attr($current_kategori); ?>">
                <?php endif; ?>
                <?php if (!empty($current_daerah)) : ?>
                    <input type="hidden" name="daerah" value="<?php echo esc_attr($current_daerah); ?>">
                <?php endif; ?>

                <div class="row g-2 justify-content-center align-items-center">
                    <div class="col-8 col-md-9 col-lg-10">
                        <div class="input-group search-input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="q" value="<?php echo esc_attr($search_keyword); ?>" 
                                   class="form-control border-start-0 py-2 ps-2" 
                                   placeholder="<?php echo esc_attr(kreasi_t('keywords_placeholder', 'Kata kunci...', 'Keywords...')); ?>" 
                                   style="font-family: 'Lato', sans-serif; font-size: 14px;">
                        </div>
                    </div>
                    <div class="col-4 col-md-3 col-lg-2">
                        <button type="submit" class="btn btn-telusuri w-100 py-2 text-white text-uppercase fw-semibold"
                                style="background-color: #062172; border-radius: 6px; font-family: 'Oswald', sans-serif; font-size: 13px; letter-spacing: 0.5px;">
                            <?php echo esc_html(kreasi_t('telusuri', 'TELUSURI', 'SEARCH')); ?>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <!-- ==========================================
         GRID ARTIKEL (LAYOUT FIGMA: 1 BESAR + 2 KECIL, LALU 3 KOLOM, LALU 3 KOLOM)
    =========================================== -->
    <div class="container px-4 px-lg-5">

        <?php if (!empty($article_items)) : 
            $item_featured = $article_items[0];
            $item_side_1   = isset($article_items[1]) ? $article_items[1] : null;
            $item_side_2   = isset($article_items[2]) ? $article_items[2] : null;
            $items_grid    = array_slice($article_items, 3);
        ?>

            <!-- BARIS ATAS: 1 BESAR (COL-LG-8) + 2 TERTUMPUK VERTIKAL (COL-LG-4) -->
            <div class="row g-4 mb-4 align-items-stretch">
                
                <!-- KOLOM KIRI (FEATURED POST BESAR) -->
                <div class="col-12 col-lg-8 d-flex flex-column">
                    <?php 
                    $cat_url_featured = !empty($item_featured['cat_slug']) 
                        ? add_query_arg('kategori', $item_featured['cat_slug'], $base_artikel_url) 
                        : $base_artikel_url;
                    $tag_url_featured = !empty($item_featured['tag_slug']) 
                        ? add_query_arg('daerah', $item_featured['tag_slug'], $base_artikel_url) 
                        : $base_artikel_url;
                    ?>
                    <article class="card article-card featured-main-card border-0 rounded-4 shadow-sm p-4 bg-white h-100 d-flex flex-column justify-content-between">
                        <div>
                            <!-- Thumbnail Besar 16:9 -->
                            <div class="position-relative overflow-hidden rounded-3 mb-3" style="aspect-ratio: 16/9; width: 100%;">
                                <a href="<?php echo esc_url($item_featured['permalink']); ?>">
                                    <img src="<?php echo esc_url($item_featured['image']); ?>" 
                                         alt="<?php echo esc_attr($item_featured['title']); ?>" 
                                         class="w-100 h-100 object-fit-cover article-card-img" 
                                         style="transition: transform 0.4s ease;">
                                </a>
                            </div>

                            <!-- Badges (Kategori Child + Daerah) - Klik untuk Filter/Cari -->
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <a href="<?php echo esc_url($cat_url_featured); ?>" 
                                   class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-cat-outline text-decoration-none">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                    </svg>
                                    <?php echo esc_html(kreasi_translate_term($item_featured['cat_name'])); ?>
                                </a>
                                <?php if (!empty($item_featured['tag_name'])) : ?>
                                <a href="<?php echo esc_url($tag_url_featured); ?>" 
                                   class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-tag-outline text-decoration-none">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <?php echo esc_html(kreasi_translate_term($item_featured['tag_name'])); ?>
                                </a>
                                <?php endif; ?>
                            </div>

                            <!-- Judul Besar -->
                            <h2 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: clamp(20px, 2.3vw, 26px); line-height: 1.3;">
                                <a href="<?php echo esc_url($item_featured['permalink']); ?>" class="text-decoration-none text-dark article-title-link">
                                    <?php echo esc_html($item_featured['title']); ?>
                                </a>
                            </h2>

                            <!-- Tanggal -->
                            <div class="mb-3 d-flex align-items-center text-muted" style="font-family: 'Lato', sans-serif; font-size: 13px;">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?php echo esc_html($item_featured['date']); ?>
                            </div>

                            <!-- Kutipan / Excerpt -->
                            <?php if (!empty($item_featured['excerpt'])) : ?>
                            <p class="text-secondary mb-4" style="font-family: 'Lato', sans-serif; font-size: 14.5px; line-height: 1.65; color: #4B5563;">
                                <?php echo esc_html($item_featured['excerpt']); ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <!-- Tombol Selengkapnya -->
                        <div class="mt-2">
                            <a href="<?php echo esc_url($item_featured['permalink']); ?>" 
                               class="btn text-white px-3 py-2 text-uppercase fw-semibold"
                               style="background-color: #D8232A; border-radius: 4px; font-family: 'Oswald', sans-serif; font-size: 12px; letter-spacing: 0.5px;">
                                <?php echo esc_html(kreasi_t('read_more', 'SELENGKAPNYA', 'READ MORE')); ?>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- KOLOM KANAN (2 POST STACKED SECARA VERTIKAL) -->
                <div class="col-12 col-lg-4 d-flex flex-column gap-4">
                    
                    <!-- Side Card 1 -->
                    <?php if ($item_side_1) : 
                        $cat_url_side1 = !empty($item_side_1['cat_slug']) 
                            ? add_query_arg('kategori', $item_side_1['cat_slug'], $base_artikel_url) 
                            : $base_artikel_url;
                        $tag_url_side1 = !empty($item_side_1['tag_slug']) 
                            ? add_query_arg('daerah', $item_side_1['tag_slug'], $base_artikel_url) 
                            : $base_artikel_url;
                    ?>
                        <article class="card article-card border-0 rounded-4 shadow-sm p-3 bg-white flex-fill d-flex flex-column justify-content-between">
                            <div>
                                <div class="position-relative overflow-hidden rounded-3 mb-2" style="aspect-ratio: 16/9; width: 100%;">
                                    <a href="<?php echo esc_url($item_side_1['permalink']); ?>">
                                        <img src="<?php echo esc_url($item_side_1['image']); ?>" 
                                             alt="<?php echo esc_attr($item_side_1['title']); ?>" 
                                             class="w-100 h-100 object-fit-cover article-card-img" 
                                             style="transition: transform 0.4s ease;">
                                    </a>
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                    <a href="<?php echo esc_url($cat_url_side1); ?>" 
                                       class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-cat-outline text-decoration-none">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                        </svg>
                                        <?php echo esc_html(kreasi_translate_term($item_side_1['cat_name'])); ?>
                                    </a>
                                    <?php if (!empty($item_side_1['tag_name'])) : ?>
                                    <a href="<?php echo esc_url($tag_url_side1); ?>" 
                                       class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-tag-outline text-decoration-none">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <?php echo esc_html(kreasi_translate_term($item_side_1['tag_name'])); ?>
                                    </a>
                                    <?php endif; ?>
                                </div>

                                <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: 16px; line-height: 1.35;">
                                    <a href="<?php echo esc_url($item_side_1['permalink']); ?>" class="text-decoration-none text-dark article-title-link">
                                        <?php echo esc_html($item_side_1['title']); ?>
                                    </a>
                                </h4>
                            </div>

                            <div class="text-muted small mt-2" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?php echo esc_html($item_side_1['date']); ?>
                            </div>
                        </article>
                    <?php endif; ?>

                    <!-- Side Card 2 -->
                    <?php if ($item_side_2) : 
                        $cat_url_side2 = !empty($item_side_2['cat_slug']) 
                            ? add_query_arg('kategori', $item_side_2['cat_slug'], $base_artikel_url) 
                            : $base_artikel_url;
                        $tag_url_side2 = !empty($item_side_2['tag_slug']) 
                            ? add_query_arg('daerah', $item_side_2['tag_slug'], $base_artikel_url) 
                            : $base_artikel_url;
                    ?>
                        <article class="card article-card border-0 rounded-4 shadow-sm p-3 bg-white flex-fill d-flex flex-column justify-content-between">
                            <div>
                                <div class="position-relative overflow-hidden rounded-3 mb-2" style="aspect-ratio: 16/9; width: 100%;">
                                    <a href="<?php echo esc_url($item_side_2['permalink']); ?>">
                                        <img src="<?php echo esc_url($item_side_2['image']); ?>" 
                                             alt="<?php echo esc_attr($item_side_2['title']); ?>" 
                                             class="w-100 h-100 object-fit-cover article-card-img" 
                                             style="transition: transform 0.4s ease;">
                                    </a>
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                    <a href="<?php echo esc_url($cat_url_side2); ?>" 
                                       class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-cat-outline text-decoration-none">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                        </svg>
                                        <?php echo esc_html(kreasi_translate_term($item_side_2['cat_name'])); ?>
                                    </a>
                                    <?php if (!empty($item_side_2['tag_name'])) : ?>
                                    <a href="<?php echo esc_url($tag_url_side2); ?>" 
                                       class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-tag-outline text-decoration-none">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <?php echo esc_html(kreasi_translate_term($item_side_2['tag_name'])); ?>
                                    </a>
                                    <?php endif; ?>
                                </div>

                                <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: 16px; line-height: 1.35;">
                                    <a href="<?php echo esc_url($item_side_2['permalink']); ?>" class="text-decoration-none text-dark article-title-link">
                                        <?php echo esc_html($item_side_2['title']); ?>
                                    </a>
                                </h4>
                            </div>

                            <div class="text-muted small mt-2" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?php echo esc_html($item_side_2['date']); ?>
                            </div>
                        </article>
                    <?php endif; ?>

                </div>

            </div>


            <!-- SISA ARTIKEL: GRID 3 KOLOM SEPERTI PADA GAMBAR DESAIN FIGMA (6 KARTU) -->
            <?php if (!empty($items_grid)) : ?>
                <div class="row g-4 mb-5">
                    <?php foreach ($items_grid as $grid_item) : 
                        $cat_url_grid = !empty($grid_item['cat_slug']) 
                            ? add_query_arg('kategori', $grid_item['cat_slug'], $base_artikel_url) 
                            : $base_artikel_url;
                        $tag_url_grid = !empty($grid_item['tag_slug']) 
                            ? add_query_arg('daerah', $grid_item['tag_slug'], $base_artikel_url) 
                            : $base_artikel_url;
                    ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card article-card border-0 rounded-4 shadow-sm p-3 bg-white h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="position-relative overflow-hidden rounded-3 mb-3" style="aspect-ratio: 16/9; width: 100%;">
                                        <a href="<?php echo esc_url($grid_item['permalink']); ?>">
                                            <img src="<?php echo esc_url($grid_item['image']); ?>" 
                                                 alt="<?php echo esc_attr($grid_item['title']); ?>" 
                                                 class="w-100 h-100 object-fit-cover article-card-img" 
                                                 style="transition: transform 0.4s ease;">
                                        </a>
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <a href="<?php echo esc_url($cat_url_grid); ?>" 
                                           class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-cat-outline text-decoration-none">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                            </svg>
                                            <?php echo esc_html(kreasi_translate_term($grid_item['cat_name'])); ?>
                                        </a>
                                        <?php if (!empty($grid_item['tag_name'])) : ?>
                                        <a href="<?php echo esc_url($tag_url_grid); ?>" 
                                           class="badge rounded-pill fw-medium bg-transparent d-inline-flex align-items-center badge-tag-outline text-decoration-none">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            <?php echo esc_html(kreasi_translate_term($grid_item['tag_name'])); ?>
                                        </a>
                                        <?php endif; ?>
                                    </div>

                                    <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: 16px; line-height: 1.35;">
                                        <a href="<?php echo esc_url($grid_item['permalink']); ?>" class="text-decoration-none text-dark article-title-link">
                                            <?php echo esc_html($grid_item['title']); ?>
                                        </a>
                                    </h4>
                                </div>

                                <div class="text-muted small mt-2" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <?php echo esc_html($grid_item['date']); ?>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


            <!-- ==========================================
                 PAGINATION ARTIKEL
            =========================================== -->
            <?php
            $total_pages = (int) $artikel_query->max_num_pages;
            if ($total_pages > 1) :
                $pagination_links = paginate_links(array(
                    'base'      => add_query_arg('paged', '%#%'),
                    'format'    => '',
                    'current'   => max(1, $paged),
                    'total'     => $total_pages,
                    'type'      => 'array',
                    'prev_text' => '<i class="bi bi-chevron-left"></i>',
                    'next_text' => '<i class="bi bi-chevron-right"></i>',
                    'end_size'  => 2,
                    'mid_size'  => 2,
                ));
                if (!empty($pagination_links)) :
            ?>
                <nav class="d-flex justify-content-center my-5" aria-label="Navigasi Halaman Artikel">
                    <ul class="pagination custom-artikel-pagination d-flex align-items-center gap-1 list-unstyled m-0">
                        <?php if ($paged <= 1) : ?>
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link rounded-circle d-inline-flex align-items-center justify-content-center text-muted" style="opacity: 0.45; cursor: default;">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            </li>
                        <?php endif; ?>

                        <?php foreach ($pagination_links as $link) : 
                            $is_active = strpos($link, 'current') !== false;
                            $is_dots   = strpos($link, 'dots') !== false;
                        ?>
                            <li class="page-item <?php echo $is_active ? 'active' : ''; ?> <?php echo $is_dots ? 'disabled' : ''; ?>">
                                <?php echo str_replace('page-numbers', 'page-link rounded-circle d-inline-flex align-items-center justify-content-center', $link); ?>
                            </li>
                        <?php endforeach; ?>

                        <?php if ($paged >= $total_pages) : ?>
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link rounded-circle d-inline-flex align-items-center justify-content-center text-muted" style="opacity: 0.45; cursor: default;">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php 
                endif;
            endif; 
            ?>

        <?php else : ?>
            
            <!-- FALLBACK JIKA PENCARIAN / FILTER TIDAK MENEMUKAN HASIL -->
            <div class="text-center py-5 my-4 bg-white rounded-4 shadow-sm p-5">
                <i class="bi bi-journal-x fs-1 text-muted mb-3 d-block"></i>
                <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; color: #062172;">
                    <?php echo esc_html(kreasi_t('no_articles_title', 'Belum Ada Artikel Ditemukan', 'No Articles Found')); ?>
                </h4>
                <p class="text-muted mb-4" style="font-family: 'Lato', sans-serif;">
                    <?php echo esc_html(kreasi_t('no_articles_desc', 'Tidak ada artikel yang cocok dengan filter kategori, daerah, atau kata kunci pencarian Anda.', 'No articles match your selected category, region, or search keywords.')); ?>
                </p>
                <a href="<?php echo esc_url($base_artikel_url); ?>" class="btn btn-outline-danger rounded-pill px-4" style="border-color: #D8232A; color: #D8232A;">
                    <?php echo esc_html(kreasi_t('reset_filter', 'Reset Semua Filter', 'Reset All Filters')); ?>
                </a>
            </div>

        <?php endif; ?>

    </div>

</main>

<style>
/* Tombol Filter Kategori (Merah) */
.btn-cat-filter {
    color: #D8232A;
    border: 1.5px solid #D8232A;
    background-color: #ffffff;
    font-family: 'Lato', sans-serif;
    font-size: 13px;
    font-weight: 500;
    padding: 6px 16px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}
.btn-cat-filter:hover,
.btn-cat-filter.active {
    background-color: #D8232A !important;
    border-color: #D8232A !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(216, 35, 42, 0.25);
}

/* Tombol Filter Daerah (Navy) */
.btn-daerah-filter {
    color: #062172;
    border: 1.5px solid #CBD5E1;
    background-color: #ffffff;
    font-family: 'Lato', sans-serif;
    font-size: 12px;
    font-weight: 500;
    padding: 5px 14px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}
.btn-daerah-filter .badge-count {
    background-color: rgba(6, 33, 114, 0.08);
    color: #062172;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 6px;
}
.btn-daerah-filter:hover,
.btn-daerah-filter.active {
    background-color: #062172 !important;
    border-color: #062172 !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(6, 33, 114, 0.25);
}
.btn-daerah-filter:hover .badge-count,
.btn-daerah-filter.active .badge-count {
    background-color: rgba(255, 255, 255, 0.25) !important;
    color: #ffffff !important;
}

/* Badges Outline */
.badge-cat-outline {
    border: 1.5px solid #5E60CE;
    color: #5E60CE;
    font-family: 'Lato', sans-serif;
    font-size: 11px;
    padding: 4px 10px;
}
.badge-tag-outline {
    border: 1.5px solid #E65A5A;
    color: #E65A5A;
    font-family: 'Lato', sans-serif;
    font-size: 11px;
    padding: 4px 10px;
}

/* Pagination Styling */
.custom-artikel-pagination .page-link {
    width: 36px;
    height: 36px;
    padding: 0;
    font-family: 'Lato', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #4b5563;
    border: 1px solid #e5e7eb;
    background-color: #ffffff;
    text-decoration: none;
    transition: all 0.2s ease;
}
.custom-artikel-pagination .page-item.active .page-link,
.custom-artikel-pagination .page-link.current {
    background-color: #062172 !important;
    border-color: #062172 !important;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(6, 33, 114, 0.3);
}
.custom-artikel-pagination .page-link:hover:not(.current) {
    background-color: #f3f4f6;
    color: #062172;
}

/* Card Hover Effects */
.article-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.article-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1) !important;
}
.article-card:hover .article-card-img {
    transform: scale(1.05);
}
.article-card:hover .article-title-link {
    color: #062172 !important;
}
</style>

<?php
get_footer();
