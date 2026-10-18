<?php
/**
 * Template Name: Artikel
 * The template for displaying the article archive page.
 *
 * @package kreasi_redesign_2026
 */

get_header();

// 1. Inisialisasi Filter Kategori, Daerah, dan Pencarian
$current_kategori = isset($_GET['kategori']) ? sanitize_title($_GET['kategori']) : '';
$current_daerah   = isset($_GET['daerah']) ? sanitize_title($_GET['daerah']) : '';
$search_keyword   = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

// 2. Ambil Kategori ID Parent Artikel & Publikasi
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
$total_posts_count = $artikel_query->found_posts;

// URL Dasar untuk Filter
$base_artikel_url = home_url('/artikel/');
?>

<main id="primary" class="site-main page-artikel bg-light pb-5">

    <!-- ==========================================
         HERO BANNER ARTIKEL (MERAH + GEOMETRIC STRIPES)
    =========================================== -->
    <section class="artikel-hero-banner position-relative overflow-hidden text-center text-white d-flex align-items-center justify-content-center"
             style="background-color: #D8232A; min-height: 240px; padding: 45px 15px 85px;">
        
        <!-- Background Banner Image atau Geometric Shapes -->
        <div class="position-absolute top-0 start-0 w-100 h-100 banner-decorations pointer-events-none" style="z-index: 1;">
            <!-- Geometric Stripe Kiri -->
            <div class="geom-stripe geom-stripe-1" style="position: absolute; top: 15px; left: -30px; width: 140px; height: 38px; background-color: #0B2567; transform: rotate(-35deg); border-radius: 4px;"></div>
            <div class="geom-stripe geom-stripe-2" style="position: absolute; top: 75px; left: -20px; width: 160px; height: 42px; background-color: #27C281; transform: rotate(-35deg); border-radius: 4px;"></div>

            <!-- Geometric Stripe Kanan -->
            <div class="geom-stripe geom-stripe-3" style="position: absolute; top: 20px; right: -25px; width: 150px; height: 40px; background-color: #27C281; transform: rotate(-35deg); border-radius: 4px;"></div>
            <div class="geom-stripe geom-stripe-4" style="position: absolute; top: 85px; right: -30px; width: 140px; height: 38px; background-color: #0B2567; transform: rotate(-35deg); border-radius: 4px;"></div>
        </div>

        <div class="container position-relative" style="z-index: 2;">
            <h1 class="page-title text-white fw-bold mb-0 text-uppercase" 
                style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(40px, 5vw, 68px); letter-spacing: 1px;">
                ARTIKEL
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
                    Semua Artikel
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
                                <path d="M9.75 2.25H12C12.1989 2.25 12.3897 2.32902 12.5303 2.46967C12.671 2.61032 12.75 2.80109 12.75 3V11.25C12.75 11.6478 12.592 12.0294 12.3107 12.3107C12.0294 12.592 11.6478 12.75 11.25 12.75M11.25 12.75C10.8522 12.75 10.4706 12.592 10.1893 12.3107C9.90804 12.0294 9.75 11.6478 9.75 11.25V1.5C9.75 1.30109 9.67098 1.11032 9.53033 0.96967C9.38968 0.829018 9.19891 0.75 9 0.75H1.5C1.30109 0.75 1.11032 0.829018 0.96967 0.96967C0.829018 1.11032 0.75 1.30109 0.75 1.5V10.5C0.75 11.0967 0.987053 11.669 1.40901 12.091C1.83097 12.5129 2.40326 12.75 3 12.75H11.25ZM3.75 3.75H6.75M3.75 6.75H6.75M3.75 9.75H6.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <?php else : ?>
                            <svg width="15" height="15" viewBox="0 0 18 18" fill="none" class="me-1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.25 6H12.75M5.25 9H12.75M5.25 12H12.75M2.25 4.5C2.25 4.10218 2.40804 3.72064 2.68934 3.43934C2.97064 3.15804 3.35218 3 3.75 3H14.25C14.6478 3 15.0294 3.15804 15.3107 3.43934C15.592 3.72064 15.75 4.10218 15.75 4.5V13.5C15.75 13.8978 15.592 14.2794 15.3107 14.5607C15.0294 14.842 14.6478 15 14.25 15H3.75C3.35218 15 2.97064 14.842 2.68934 14.5607C2.40804 14.2794 2.25 13.8978 2.25 13.5V4.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <?php endif; ?>
                        <?php echo esc_html($cat->name); ?>
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
                    Semua Daerah
                    <span class="badge rounded-pill ms-1 badge-count"><?php echo esc_html($total_posts_count > 0 ? $total_posts_count : 24); ?></span>
                </a>

                <!-- Daftar 8 Kabupaten + Nasional -->
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
                        <?php echo esc_html($rt->name); ?>
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
                                   placeholder="Kata kunci..." 
                                   style="font-family: 'Lato', sans-serif; font-size: 14px;">
                        </div>
                    </div>
                    <div class="col-4 col-md-3 col-lg-2">
                        <button type="submit" class="btn btn-telusuri w-100 py-2 text-white text-uppercase fw-semibold"
                                style="background-color: #062172; border-radius: 6px; font-family: 'Oswald', sans-serif; font-size: 13px; letter-spacing: 0.5px;">
                            TELUSURI
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

        <?php if ($artikel_query->have_posts()) : 
            $posts_array = $artikel_query->posts;
            $count = count($posts_array);
            
            // Post 1: Card Besar Kiri
            $post_featured = $posts_array[0];
            // Post 2 & 3: Card Kecil Kanan
            $post_side_1   = isset($posts_array[1]) ? $posts_array[1] : null;
            $post_side_2   = isset($posts_array[2]) ? $posts_array[2] : null;
            // Post 4-9: Grid 3 Kolom
            $posts_grid    = array_slice($posts_array, 3);
        ?>

            <!-- BARIS ATAS: 1 BESAR (COL-LG-8) + 2 TERTUMPUK VERTIKAL (COL-LG-4) -->
            <div class="row g-4 mb-4">
                
                <!-- KOLOM KIRI (FEATURED POST BESAR) -->
                <div class="col-12 col-lg-8">
                    <?php 
                    $post = $post_featured;
                    setup_postdata($post);
                    
                    $cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category(get_the_ID()) : null;
                    $cat_name = $cat_obj ? $cat_obj->name : 'Cerita';
                    
                    $tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag(get_the_ID()) : null;
                    $tag_name = $tag_obj ? $tag_obj->name : 'Nias Utara';

                    $thumb_url = has_post_thumbnail() 
                        ? get_the_post_thumbnail_url(get_the_ID(), 'large') 
                        : get_template_directory_uri() . '/assets/images/thumbnail-1.png';
                    ?>
                    <article class="card article-card featured-main-card border-0 rounded-4 shadow-sm p-4 bg-white h-100 d-flex flex-column justify-content-between">
                        <div>
                            <!-- Thumbnail Besar -->
                            <div class="position-relative overflow-hidden rounded-3 mb-3" style="aspect-ratio: 16/9; max-height: 380px;">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url($thumb_url); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         class="w-100 h-100 object-fit-cover article-card-img" 
                                         style="transition: transform 0.4s ease;">
                                </a>
                            </div>

                            <!-- Badges (Kategori Child + Daerah) -->
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-cat-outline">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                    </svg>
                                    <?php echo esc_html($cat_name); ?>
                                </span>
                                <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-tag-outline">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <?php echo esc_html($tag_name); ?>
                                </span>
                            </div>

                            <!-- Judul Besar -->
                            <h2 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: clamp(20px, 2.5vw, 28px); line-height: 1.25;">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark article-title-link">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <!-- Tanggal -->
                            <div class="mb-3 d-flex align-items-center text-muted small" style="font-family: 'Lato', sans-serif; font-size: 13px;">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?php echo get_the_date('j F Y'); ?>
                            </div>

                            <!-- Kutipan / Excerpt -->
                            <p class="text-secondary mb-4" style="font-family: 'Lato', sans-serif; font-size: 15px; line-height: 1.65;">
                                <?php echo wp_trim_words(get_the_excerpt(), 42, '...'); ?>
                            </p>
                        </div>

                        <!-- Tombol Selengkapnya -->
                        <div>
                            <a href="<?php the_permalink(); ?>" 
                               class="btn text-white px-3 py-2 text-uppercase fw-semibold"
                               style="background-color: #D8232A; border-radius: 4px; font-family: 'Oswald', sans-serif; font-size: 12px; letter-spacing: 0.5px;">
                                SELENGKAPNYA
                            </a>
                        </div>
                    </article>
                    <?php wp_reset_postdata(); ?>
                </div>

                <!-- KOLOM KANAN (2 POST STACKED SECARA VERTIKAL) -->
                <div class="col-12 col-lg-4 d-flex flex-column gap-4">
                    
                    <?php if ($post_side_1) : 
                        $post = $post_side_1;
                        setup_postdata($post);
                        $cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category(get_the_ID()) : null;
                        $cat_name = $cat_obj ? $cat_obj->name : 'Berita & Perkembangan';
                        $tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag(get_the_ID()) : null;
                        $tag_name = $tag_obj ? $tag_obj->name : 'Tanggamus';
                        $thumb_url = has_post_thumbnail() 
                            ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                            : get_template_directory_uri() . '/assets/images/thumbnail-2.png';
                    ?>
                        <article class="card article-card border-0 rounded-4 shadow-sm p-3 bg-white flex-fill">
                            <div class="position-relative overflow-hidden rounded-3 mb-3" style="aspect-ratio: 16/9; max-height: 180px;">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url($thumb_url); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         class="w-100 h-100 object-fit-cover article-card-img" 
                                         style="transition: transform 0.4s ease;">
                                </a>
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-cat-outline">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                    </svg>
                                    <?php echo esc_html($cat_name); ?>
                                </span>
                                <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-tag-outline">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <?php echo esc_html($tag_name); ?>
                                </span>
                            </div>

                            <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: 17px; line-height: 1.35;">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark article-title-link">
                                    <?php the_title(); ?>
                                </a>
                            </h4>

                            <div class="text-muted small" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?php echo get_the_date('j F Y'); ?>
                            </div>
                        </article>
                    <?php wp_reset_postdata(); endif; ?>

                    <?php if ($post_side_2) : 
                        $post = $post_side_2;
                        setup_postdata($post);
                        $cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category(get_the_ID()) : null;
                        $cat_name = $cat_obj ? $cat_obj->name : 'Berita & Perkembangan';
                        $tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag(get_the_ID()) : null;
                        $tag_name = $tag_obj ? $tag_obj->name : 'Tanggamus';
                        $thumb_url = has_post_thumbnail() 
                            ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                            : get_template_directory_uri() . '/assets/images/thumbnail3.png';
                    ?>
                        <article class="card article-card border-0 rounded-4 shadow-sm p-3 bg-white flex-fill">
                            <div class="position-relative overflow-hidden rounded-3 mb-3" style="aspect-ratio: 16/9; max-height: 180px;">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url($thumb_url); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         class="w-100 h-100 object-fit-cover article-card-img" 
                                         style="transition: transform 0.4s ease;">
                                </a>
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-cat-outline">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                    </svg>
                                    <?php echo esc_html($cat_name); ?>
                                </span>
                                <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-tag-outline">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <?php echo esc_html($tag_name); ?>
                                </span>
                            </div>

                            <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: 17px; line-height: 1.35;">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark article-title-link">
                                    <?php the_title(); ?>
                                </a>
                            </h4>

                            <div class="text-muted small" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?php echo get_the_date('j F Y'); ?>
                            </div>
                        </article>
                    <?php wp_reset_postdata(); endif; ?>

                </div>

            </div>


            <!-- SISA ARTIKEL: GRID 3 KOLOM SEPERTI PADA GAMBAR DESAIN FIGMA -->
            <?php if (!empty($posts_grid)) : ?>
                <div class="row g-4 mb-5">
                    <?php foreach ($posts_grid as $post) : 
                        setup_postdata($post);
                        $cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category(get_the_ID()) : null;
                        $cat_name = $cat_obj ? $cat_obj->name : 'Berita & Perkembangan';
                        $tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag(get_the_ID()) : null;
                        $tag_name = $tag_obj ? $tag_obj->name : 'Tanggamus';
                        $thumb_url = has_post_thumbnail() 
                            ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                            : get_template_directory_uri() . '/assets/images/thumbnail-1.png';
                    ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card article-card border-0 rounded-4 shadow-sm p-3 bg-white h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="position-relative overflow-hidden rounded-3 mb-3" style="aspect-ratio: 16/9; max-height: 200px;">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo esc_url($thumb_url); ?>" 
                                                 alt="<?php the_title_attribute(); ?>" 
                                                 class="w-100 h-100 object-fit-cover article-card-img" 
                                                 style="transition: transform 0.4s ease;">
                                        </a>
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                        <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-cat-outline">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                            </svg>
                                            <?php echo esc_html($cat_name); ?>
                                        </span>
                                        <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center badge-tag-outline">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            <?php echo esc_html($tag_name); ?>
                                        </span>
                                    </div>

                                    <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; font-size: 17px; line-height: 1.35;">
                                        <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark article-title-link">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                </div>

                                <div class="text-muted small mt-2" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <?php echo get_the_date('j F Y'); ?>
                                </div>
                            </article>
                        </div>
                    <?php 
                        wp_reset_postdata(); 
                    endforeach; ?>
                </div>
            <?php endif; ?>


            <!-- ==========================================
                 PAGINATION ANGKA FIGMA (< 1 2 3 ... 20 21 >)
            =========================================== -->
            <?php
            $total_pages = $artikel_query->max_num_pages;
            if ($total_pages > 1) :
                $pagination_links = paginate_links(array(
                    'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'format'    => '?paged=%#%',
                    'current'   => max(1, $paged),
                    'total'     => $total_pages,
                    'type'      => 'array',
                    'prev_text' => '<i class="bi bi-chevron-left"></i>',
                    'next_text' => '<i class="bi bi-chevron-right"></i>',
                    'end_size'  => 2,
                    'mid_size'  => 2,
                ));
            ?>
                <nav class="d-flex justify-content-center my-5" aria-label="Navigasi Halaman Artikel">
                    <ul class="pagination custom-artikel-pagination d-flex align-items-center gap-1 list-unstyled m-0">
                        <?php foreach ($pagination_links as $link) : 
                            $is_active = strpos($link, 'current') !== false;
                        ?>
                            <li class="page-item <?php echo $is_active ? 'active' : ''; ?>">
                                <?php echo str_replace('page-numbers', 'page-link rounded-circle d-inline-flex align-items-center justify-content-center', $link); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            
            <!-- FALLBACK JIKA BELUM ADA POSTINGAN SESUAI FILTER -->
            <div class="text-center py-5 my-4 bg-white rounded-4 shadow-sm p-5">
                <i class="bi bi-journal-x fs-1 text-muted mb-3 d-block"></i>
                <h4 class="fw-bold mb-2" style="font-family: 'Oswald', sans-serif; color: #0b2351;">
                    Belum Ada Artikel Ditemukan
                </h4>
                <p class="text-muted mb-4" style="font-family: 'Lato', sans-serif;">
                    Tidak ada artikel yang cocok dengan filter kategori atau kata kunci pencarian Anda.
                </p>
                <a href="<?php echo esc_url($base_artikel_url); ?>" class="btn btn-outline-danger rounded-pill px-4">
                    Reset Semua Filter
                </a>
            </div>

        <?php endif; ?>

    </div>

</main>

<style>
/* Tombol Filter Kategori (Merah) */
.btn-cat-filter {
    color: #DA291C;
    border: 1.5px solid #DA291C;
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
    background-color: #DA291C !important;
    border-color: #DA291C !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(218, 41, 28, 0.25);
}

/* Tombol Filter Daerah (Navy) */
.btn-daerah-filter {
    color: #062172;
    border: 1.5px solid #062172;
    background-color: #ffffff;
    font-family: 'Lato', sans-serif;
    font-size: 12px;
    font-weight: 500;
    padding: 5px 14px;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}
.btn-daerah-filter .badge-count {
    background-color: rgba(6, 33, 114, 0.1);
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
    border: 1.5px solid #062172;
    color: #062172;
    font-family: 'Lato', sans-serif;
    font-size: 11px;
    padding: 4px 10px;
}
.badge-tag-outline {
    border: 1.5px solid #DA291C;
    color: #DA291C;
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
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12) !important;
}
.article-card:hover .article-card-img {
    transform: scale(1.05);
}
.article-card:hover .article-title-link {
    color: #163d6b !important;
}
</style>

<?php
get_footer();
