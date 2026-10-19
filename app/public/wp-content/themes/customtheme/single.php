<?php
/**
 * Template single artikel.
 *
 * @package kreasi_redesign_2026
 */

get_header();

while (have_posts()) :
    the_post();

    $post_id    = get_the_ID();
    $author_id  = (int) get_the_author_meta('ID');
    $tags       = get_the_tags($post_id);

    // Kategori Child (Cerita / Berita / Liputan Media) - JANGAN tampilkan parent 'Artikel'
    $cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category($post_id) : null;
    $cat_name = $cat_obj ? $cat_obj->name : 'Cerita';

    // Tag Daerah (Kayong Utara, dll)
    $tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag($post_id) : null;
    $tag_name = $tag_obj ? $tag_obj->name : '';

    $share_url   = rawurlencode(get_permalink());
    $share_title = rawurlencode(get_the_title());

    // Hitung / Ambil View Count
    $views = (int) get_post_meta($post_id, 'kreasi_redesign_2026_post_views', true);
    if ($views <= 0) {
        $views = 414; // Default fallback tampilan sesuai desain
    }

    // Query 3 Artikel Terkait dari Kategori Parent Artikel (Exclude current post)
    $artikel_cat_ids   = function_exists('kreasi_get_artikel_category_ids') ? kreasi_get_artikel_category_ids() : array();
    $publikasi_cat_ids = function_exists('kreasi_get_publikasi_category_ids') ? kreasi_get_publikasi_category_ids() : array();

    $related_args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'post__not_in'        => array($post_id),
        'orderby'             => 'rand',
        'ignore_sticky_posts' => true,
    );

    if (!empty($artikel_cat_ids)) {
        $related_args['category__in'] = $artikel_cat_ids;
    }
    if (!empty($publikasi_cat_ids)) {
        $related_args['category__not_in'] = $publikasi_cat_ids;
    }

    $related_query = new WP_Query($related_args);
?>

    <main id="primary" class="site-main single-article bg-white">

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-article-entry'); ?>>

            <!-- ==========================================
                 HERO BANNER DENGAN GAMBAR BESAR & JUDUL FIGMA
            =========================================== -->
            <header class="single-article-hero position-relative overflow-hidden w-100" style="min-height: 480px; max-height: 560px; background-color: #111;">
                
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'full')); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" 
                         style="z-index: 0; filter: brightness(0.9);">
                <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/thumbnail-1.png'); ?>" 
                         alt="<?php the_title_attribute(); ?>" 
                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" 
                         style="z-index: 0; filter: brightness(0.9);">
                <?php endif; ?>

                <!-- Gradient Overlay Gelap -->
                <div class="position-absolute top-0 start-0 w-100 h-100"
                     style="background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.85) 100%); z-index: 1;">
                </div>

                <!-- Konten Judul di Bawah Banner -->
                <div class="container position-relative h-100 d-flex align-items-end px-4 px-lg-5 pb-5" style="z-index: 2; min-height: 480px;">
                    <div style="max-width: 960px;">
                        <!-- Label Kategori / Anak Indonesia -->
                        <p class="text-white-50 small mb-2 text-uppercase fw-semibold" style="font-family: 'Lato', sans-serif; letter-spacing: 0.5px;">
                            <?php echo esc_html($cat_name); ?>
                        </p>

                        <!-- Judul Besar Condensed Font (Oswald) -->
                        <h1 class="text-white fw-bold mb-0 text-uppercase"
                            style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(26px, 3.8vw, 48px); line-height: 1.15; letter-spacing: 0.3px;">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>

            </header>


            <!-- ==========================================
                 META BAR (KATEGORI, TAG DAERAH, TANGGAL, VIEWS)
            =========================================== -->
            <div class="container px-4 px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10">

                        <section class="single-article-meta py-4 border-bottom">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                
                                <!-- Sisi Kiri: Badges (Biru Navy Kategori + Merah Tag Daerah) -->
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <!-- BADGE 1: KATEGORI CHILD (BIRU NAVY SOLID CAPSULE) -->
                                    <span class="badge rounded-pill fw-semibold text-white d-inline-flex align-items-center" 
                                          style="background-color: #062172; font-family: 'Lato', sans-serif; font-size: 12px; padding: 6px 14px;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                            <line x1="9" y1="9" x2="15" y2="9" stroke-width="1.8" />
                                            <line x1="9" y1="13" x2="15" y2="13" stroke-width="1.8" />
                                        </svg>
                                        <?php echo esc_html($cat_name); ?>
                                    </span>

                                    <!-- BADGE 2: TAG DAERAH (MERAH SOLID CAPSULE) -->
                                    <?php if (!empty($tag_name)) : ?>
                                    <span class="badge rounded-pill fw-semibold text-white d-inline-flex align-items-center" 
                                          style="background-color: #D8232A; font-family: 'Lato', sans-serif; font-size: 12px; padding: 6px 14px;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <?php echo esc_html($tag_name); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Sisi Kanan: Tanggal & Views -->
                                <div class="text-secondary small d-flex align-items-center gap-3" style="font-family: 'Lato', sans-serif; font-size: 13px;">
                                    <span>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?php echo esc_html(get_the_date('j F Y')); ?>
                                    </span>
                                    <span>
                                        <i class="bi bi-eye me-1"></i>
                                        <?php echo esc_html(number_format_i18n($views)); ?> views
                                    </span>
                                </div>

                            </div>
                        </section>


                        <!-- ==========================================
                             KONTEN UTAMA ARTIKEL (GUTENBERG & ELEMENTOR STYLED)
                        =========================================== -->
                        <div class="single-article-content entry-content py-4 py-md-5">
                            <?php the_content(); ?>
                        </div>


                        <!-- ==========================================
                             KOTAK INFORMASI / DISCLAIMER KREASI (FIGMA)
                        =========================================== -->
                        <div class="kreasi-disclaimer-box p-3 p-md-4 rounded-3 mb-4" 
                             style="background-color: #F8F9FA; border: 1px solid #E5E7EB;">
                            <p class="mb-0 text-secondary" style="font-family: 'Lato', sans-serif; font-size: 13px; line-height: 1.65;">
                                <em>KREASI (Kolaborasi untuk Edukasi Anak Indonesia) adalah program peningkatan kualitas pendidikan dengan memperkuat literasi, numerasi, dan pendidikan karakter di delapan kabupaten di empat provinsi di Indonesia. KREASI dikelola Save the Children, diimplementasi mitra pelaksana lokal, dengan pendanaan Global Partnership for Education (GPE) dan didukung Mitra Pendidikan Indonesia yang dipimpin Kementerian Pendidikan Dasar dan Menengah (Kemendikdasmen) dan Kementerian Agama (Kemenag).</em>
                            </p>
                        </div>


                        <!-- ==========================================
                             KREDIT PENULIS, EDITOR & FOTOGRAFER
                        =========================================== -->
                        <div class="article-credits text-secondary mb-4 pb-2" style="font-family: 'Lato', sans-serif; font-size: 13px;">
                            <span><strong>Penulis:</strong> <?php echo esc_html(get_the_author()); ?></span>
                            <span class="mx-2">|</span>
                            <span><strong>Editor:</strong> Tim Komunikasi KREASI</span>
                            <span class="mx-2">|</span>
                            <span><strong>Foto:</strong> Dok. KREASI / Save the Children</span>
                        </div>


                        <!-- ==========================================
                             TAGS PILLS (RADAR, KEPRIHALUAN, DLL)
                        =========================================== -->
                        <?php if (!empty($tags)) : ?>
                            <div class="article-tags-wrap mb-4 pb-2 d-flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag)); ?>" 
                                       class="btn btn-sm rounded-pill px-3 py-1 text-uppercase text-decoration-none"
                                       style="font-family: 'Lato', sans-serif; font-size: 11px; font-weight: 600; color: #4B5563; border: 1px solid #D1D5DB; background-color: #fff;">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>


                        <!-- ==========================================
                             BAGIKAN ARTIKEL (SOCIAL SHARE)
                        =========================================== -->
                        <div class="article-share-section py-4 border-top d-flex flex-wrap align-items-center gap-3">
                            <span class="fw-semibold text-secondary small" style="font-family: 'Lato', sans-serif;">
                                Bagikan:
                            </span>

                            <!-- Copy Link -->
                            <button type="button" 
                                    class="btn btn-outline-secondary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center share-btn"
                                    style="width: 32px; height: 32px; padding: 0;"
                                    onclick="navigator.clipboard.writeText('<?php echo esc_url(get_permalink()); ?>'); alert('Tautan artikel berhasil disalin!');"
                                    title="Salin Tautan">
                                <i class="bi bi-link-45deg"></i>
                            </button>

                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text=<?php echo esc_attr($share_title . '%20' . $share_url); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="btn btn-outline-success btn-sm rounded-circle d-inline-flex align-items-center justify-content-center share-btn"
                               style="width: 32px; height: 32px; padding: 0;"
                               title="Bagikan ke WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>

                            <!-- Twitter / X -->
                            <a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($share_title); ?>&url=<?php echo esc_attr($share_url); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="btn btn-outline-dark btn-sm rounded-circle d-inline-flex align-items-center justify-content-center share-btn"
                               style="width: 32px; height: 32px; padding: 0;"
                               title="Bagikan ke X">
                                <i class="bi bi-twitter-x"></i>
                            </a>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($share_url); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="btn btn-outline-primary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center share-btn"
                               style="width: 32px; height: 32px; padding: 0;"
                               title="Bagikan ke Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr($share_url); ?>" 
                               target="_blank" rel="noopener noreferrer"
                               class="btn btn-outline-primary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center share-btn"
                               style="width: 32px; height: 32px; padding: 0;"
                               title="Bagikan ke LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </article>


        <!-- ==========================================
             ARTIKEL TERKAIT (3 KARTU FIGMA DARI KATEGORI ARTIKEL)
        =========================================== -->
        <?php if ($related_query->have_posts()) : ?>
            <section class="single-article-related py-5 bg-light border-top mt-4">
                <div class="container px-4 px-lg-5">
                    
                    <div class="row g-4 justify-content-center">
                        <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                            $rel_cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category(get_the_ID()) : null;
                            $rel_cat_name = $rel_cat_obj ? $rel_cat_obj->name : 'Berita & Perkembangan';
                            $rel_tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag(get_the_ID()) : null;
                            $rel_tag_name = $rel_tag_obj ? $rel_tag_obj->name : '';
                            $rel_thumb    = has_post_thumbnail() 
                                ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                                : get_template_directory_uri() . '/assets/images/thumbnail-1.png';
                        ?>
                            <div class="col-md-6 col-lg-4">
                                <article class="card article-card border-0 rounded-4 shadow-sm p-3 bg-white h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="position-relative overflow-hidden rounded-3 mb-3" style="aspect-ratio: 16/9; max-height: 200px;">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo esc_url($rel_thumb); ?>" 
                                                     alt="<?php the_title_attribute(); ?>" 
                                                     class="w-100 h-100 object-fit-cover article-card-img" 
                                                     style="transition: transform 0.4s ease;">
                                            </a>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="font-family: 'Lato', sans-serif; font-size: 11px; padding: 4px 10px; border: 1.5px solid #062172; color: #062172;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                                </svg>
                                                <?php echo esc_html($rel_cat_name); ?>
                                            </span>
                                            <?php if (!empty($rel_tag_name)) : ?>
                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="font-family: 'Lato', sans-serif; font-size: 11px; padding: 4px 10px; border: 1.5px solid #DA291C; color: #DA291C;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                                <?php echo esc_html($rel_tag_name); ?>
                                            </span>
                                            <?php endif; ?>
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
                        <?php endwhile; ?>
                    </div>

                </div>
            </section>
        <?php 
            wp_reset_postdata();
        endif; 
        ?>

    </main>

<style>
/* Styling Tambahan untuk Single Post & Kartu Terkait */
.single-article-content {
    font-family: 'Lato', sans-serif;
    font-size: 17px;
    line-height: 1.8;
    color: #2b2b2b;
}

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
endwhile;

get_footer();
