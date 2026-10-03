<?php
/**
 * Template Part: Section Artikel Terkini (Pin & Recently Posts Query)
 *
 * Logika Query:
 * 1. Cek apakah ada Sticky/Pinned Posts di WordPress (Posts yang di-Pin oleh Admin).
 * 2. Ambil artikel Pinned terlebih dahulu.
 * 3. Jika artikel Pinned kurang dari 3, secara otomatis melengkapi dengan Artikel Terbaru (Recently Published).
 */

// Step 1: Ambil ID Sticky / Pinned Posts
$sticky_posts = get_option('sticky_posts');
$post_ids     = array();

// Query 1: Ambil Pinned Posts (jika ada)
if (!empty($sticky_posts)) {
    $args_pinned = array(
        'post_type'           => 'post',
        'post__in'            => $sticky_posts,
        'posts_per_page'      => 3,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
    );
    $query_pinned = new WP_Query($args_pinned);
    if ($query_pinned->have_posts()) {
        while ($query_pinned->have_posts()) {
            $query_pinned->the_post();
            $post_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }
}

// Query 2: Lengkapi sisa slot (hingga total 3 artikel) dengan Recently Published Posts
$needed_recent = 3 - count($post_ids);
if ($needed_recent > 0) {
    $args_recent = array(
        'post_type'           => 'post',
        'post__not_in'        => !empty($post_ids) ? $post_ids : array(),
        'posts_per_page'      => $needed_recent,
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => 1,
    );
    $query_recent = new WP_Query($args_recent);
    if ($query_recent->have_posts()) {
        while ($query_recent->have_posts()) {
            $query_recent->the_post();
            $post_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }
}

// Final Query dengan urutan Pinned dulu, baru Recently Published
if (!empty($post_ids)) {
    $final_query = new WP_Query(array(
        'post_type'      => 'post',
        'post__in'       => $post_ids,
        'orderby'        => 'post__in',
        'posts_per_page' => 3,
    ));
} else {
    $final_query = false;
}
?>

<!-- SECTION ARTIKEL TERKINI -->
<section class="latest-articles-section py-5 bg-white position-relative overflow-hidden">
    <div class="container py-lg-4">
        
        <!-- HEADER SECTION -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark text-uppercase mb-2" style="font-size: 34px; letter-spacing: 0.5px; color: #1A202C;">
                ARTIKEL TERKINI
            </h2>
            <p class="text-secondary mb-0" style="font-size: 15px; max-width: 680px; margin-left: auto; margin-right: auto;">
                Ikuti berita perkembangan dan cerita dari delapan kabupaten dampingan KREASI.
            </p>
        </div>

        <!-- 3 CARDS GRID (HORIZONTAL SCROLL PEEK DI MOBILE, 3 KOLOM DI DESKTOP) -->
        <div class="row g-3 g-md-4 flex-nowrap overflow-x-auto flex-md-wrap pb-3 pb-md-0 mobile-horizontal-scroll">
            <?php
            if ($final_query && $final_query->have_posts()) :
                while ($final_query->have_posts()) : $final_query->the_post();
                    $is_pinned   = is_sticky(get_the_ID());
                    $categories  = get_the_category();
                    $tags        = get_the_tags();
                    $thumb_url   = has_post_thumbnail() 
                        ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                        : 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop';

                    // Badge 1: Kategori Utama (Border Biru Navy + Speech Bubble Hashtag Icon)
                    $cat_name = !empty($categories) ? $categories[0]->name : 'Cerita';
                    
                    // Badge 2: Tag Daerah (Border Merah + Pin Marker Icon)
                    $tag_name = !empty($tags) ? $tags[0]->name : 'Kayong Utara';
            ?>
                    <div class="col-10 col-sm-6 col-lg-4 flex-shrink-0 flex-md-shrink-1">
                        <div class="card article-card border-0 rounded-4 overflow-hidden shadow-sm h-100 bg-white">
                            
                            <!-- THUMBNAIL IMAGE -->
                            <div class="position-relative overflow-hidden" style="height: 210px;">
                                <img src="<?php echo esc_url($thumb_url); ?>" 
                                     alt="<?php the_title_attribute(); ?>" 
                                     class="w-100 h-100 object-fit-cover article-card-img" 
                                     style="transition: transform 0.4s ease;">
                                
                                <?php if ($is_pinned) : ?>
                                    <span class="position-absolute top-0 end-0 bg-danger text-white small fw-bold px-3 py-1 rounded-bl shadow-sm" style="font-size: 11px; z-index: 2;">
                                        📌 PINNED
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- CARD BODY -->
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <!-- BADGES (BADGE 1: KATEGORI, BADGE 2: TAG DAERAH - SESUAI FIGMA) -->
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                        <!-- BADGE 1: KATEGORI (BIRU NAVY + SPEECH BUBBLE HASHTAG ICON) -->
                                        <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center" style="font-size: 11px; padding: 5px 12px; border: 1.5px solid #163d6b; color: #163d6b;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                                <line x1="9" y1="9" x2="15" y2="9" stroke-width="1.8"/>
                                                <line x1="9" y1="13" x2="15" y2="13" stroke-width="1.8"/>
                                                <line x1="10.5" y1="7" x2="10.5" y2="15" stroke-width="1.8"/>
                                                <line x1="13.5" y1="7" x2="13.5" y2="15" stroke-width="1.8"/>
                                            </svg>
                                            <?php echo esc_html($cat_name); ?>
                                        </span>

                                        <!-- BADGE 2: TAG DAERAH (MERAH + LOCATION PIN ICON) -->
                                        <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center" style="font-size: 11px; padding: 5px 12px; border: 1.5px solid #D8232A; color: #D8232A;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            <?php echo esc_html($tag_name); ?>
                                        </span>
                                    </div>

                                    <!-- TITLE -->
                                    <h5 class="fw-bold mb-3" style="color: #1A202C; font-size: 18px; line-height: 1.35; letter-spacing: -0.3px;">
                                        <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark article-title-link" style="transition: color 0.3s ease;">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>
                                </div>

                                <!-- DATE & SELENGKAPNYA LINK (ANIMASI MASUK DARI BAWAH) -->
                                <div class="mt-3 d-flex align-items-center justify-content-between position-relative" style="min-height: 24px;">
                                    <span class="fw-semibold small" style="color: #D8232A; font-size: 12px;">
                                        <?php echo get_the_date('j F Y'); ?>
                                    </span>
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none fw-bold text-uppercase article-hover-link" style="color: #D8232A; font-size: 11px; letter-spacing: 0.5px;">
                                        SELENGKAPNYA →
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // FALLBACK PLACEHOLDER CARDS (Jika Belum Ada Post di Database)
                $dummy_articles = array(
                    array(
                        'title' => 'KREASI Kayong Utara Dorong Penguatan Ekosistem Pendidikan Daerah',
                        'date'  => '26 Juli 2026',
                        'cat'   => 'Cerita',
                        'tag'   => 'Kayong Utara',
                        'img'   => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'title' => 'KREASI Kayong Utara Dorong Penguatan Ekosistem Pendidikan Daerah',
                        'date'  => '26 Juli 2026',
                        'cat'   => 'Cerita',
                        'tag'   => 'Kayong Utara',
                        'img'   => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop'
                    ),
                    array(
                        'title' => 'KREASI Kayong Utara Dorong Penguatan Ekosistem Pendidikan Daerah',
                        'date'  => '26 Juli 2026',
                        'cat'   => 'Cerita',
                        'tag'   => 'Kayong Utara',
                        'img'   => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop'
                    ),
                );

                foreach ($dummy_articles as $dummy) :
            ?>
                    <div class="col-10 col-sm-6 col-lg-4 flex-shrink-0 flex-md-shrink-1">
                        <div class="card article-card border-0 rounded-4 overflow-hidden shadow-sm h-100 bg-white">
                            <div class="position-relative overflow-hidden" style="height: 210px;">
                                <img src="<?php echo esc_url($dummy['img']); ?>" class="w-100 h-100 object-fit-cover article-card-img" style="transition: transform 0.4s ease;">
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                        <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center" style="font-size: 11px; padding: 5px 12px; border: 1.5px solid #163d6b; color: #163d6b;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                                <line x1="9" y1="9" x2="15" y2="9" stroke-width="1.8"/>
                                                <line x1="9" y1="13" x2="15" y2="13" stroke-width="1.8"/>
                                                <line x1="10.5" y1="7" x2="10.5" y2="15" stroke-width="1.8"/>
                                                <line x1="13.5" y1="7" x2="13.5" y2="15" stroke-width="1.8"/>
                                            </svg>
                                            <?php echo esc_html($dummy['cat']); ?>
                                        </span>
                                        <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center" style="font-size: 11px; padding: 5px 12px; border: 1.5px solid #D8232A; color: #D8232A;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            <?php echo esc_html($dummy['tag']); ?>
                                        </span>
                                    </div>
                                    <h5 class="fw-bold mb-3" style="color: #1A202C; font-size: 18px; line-height: 1.35; letter-spacing: -0.3px;">
                                        <a href="#" class="text-decoration-none text-dark article-title-link" style="transition: color 0.3s ease;"><?php echo esc_html($dummy['title']); ?></a>
                                    </h5>
                                </div>
                                <div class="mt-3 d-flex align-items-center justify-content-between position-relative" style="min-height: 24px;">
                                    <span class="fw-semibold small" style="color: #D8232A; font-size: 12px;"><?php echo esc_html($dummy['date']); ?></span>
                                    <a href="#" class="text-decoration-none fw-bold text-uppercase article-hover-link" style="color: #D8232A; font-size: 11px; letter-spacing: 0.5px;">
                                        SELENGKAPNYA →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>

        <!-- BUTTON BACA ARTIKEL LAINNYA -->
        <div class="text-center mt-5">
            <?php 
            $posts_page_id = get_option('page_for_posts');
            $artikel_url   = $posts_page_id ? get_permalink($posts_page_id) : home_url('/artikel');
            ?>
            <a href="<?php echo esc_url($artikel_url); ?>" 
               class="btn text-white fw-bold px-4 py-3 text-uppercase shadow-sm articles-more-btn d-inline-flex align-items-center justify-content-center" 
               style="background-color: #D8232A; border-radius: 6px; font-size: 12px; letter-spacing: 0.5px; transition: all 0.35s ease;">
                <span>BACA ARTIKEL LAINNYA</span>
                <span class="btn-arrow ms-2">→</span>
            </a>
        </div>

    </div>
</section>

<!-- STYLING HOVER ANIMASI & MOBILE HORIZONTAL PEEK SCROLL -->
<style>
/* MOBILE HORIZONTAL SCROLL PEEK (SESUAI FIGMA MOBILE) */
@media (max-width: 767.98px) {
    .mobile-horizontal-scroll {
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .mobile-horizontal-scroll::-webkit-scrollbar {
        display: none;
    }
    .mobile-horizontal-scroll > div {
        scroll-snap-align: start;
    }
}

/* 1. KARTU ARTIKEL & LINK SELENGKAPNYA (MASUK DARI BAWAH) */
.article-card {
    transition: transform 0.35s ease, box-shadow 0.35s ease;
    cursor: pointer;
}
.article-card .article-hover-link {
    opacity: 0;
    transform: translateY(12px);
    transition: opacity 0.35s ease, transform 0.35s ease;
}
.article-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12) !important;
}
.article-card:hover .article-card-img {
    transform: scale(1.06);
}
.article-card:hover .article-title-link {
    color: #163d6b !important;
}
.article-card:hover .article-hover-link {
    opacity: 1;
    transform: translateY(0);
}

/* 2. TOMBOL BACA ARTIKEL LAINNYA (MERAH -> BIRU NAVY + PANAH MASUK DARI KANAN) */
.articles-more-btn {
    overflow: hidden;
    position: relative;
}
.articles-more-btn .btn-arrow {
    display: inline-block;
    opacity: 0;
    transform: translateX(14px);
    max-width: 0;
    white-space: nowrap;
    transition: opacity 0.35s ease, transform 0.35s ease, max-width 0.35s ease;
}
.articles-more-btn:hover {
    background-color: #0B2567 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(11, 37, 103, 0.4) !important;
}
.articles-more-btn:hover .btn-arrow {
    opacity: 1;
    transform: translateX(0);
    max-width: 20px;
}
</style>
