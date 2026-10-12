<?php

/**
 * Template single artikel.
 *
 * @package customtheme
 */

get_header();

while (have_posts()) :
    the_post();

    $post_id    = get_the_ID();
    $categories = get_the_category($post_id);
    $tags       = get_the_tags($post_id);
    $author_id  = (int) get_the_author_meta('ID');

    $share_url   = rawurlencode(get_permalink());
    $share_title = rawurlencode(get_the_title());

    // Badge 1: kategori pertama artikel.
    $cat_name = !empty($categories) ? $categories[0]->name : 'Cerita';

    // Badge 2: tag pertama artikel.
    $tag_name = !empty($tags) ? $tags[0]->name : 'Kayong Utara';

    $related_args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => true,
    );

    // if (!empty($category_ids)) {
    //     $related_args['category__in'] = $category_ids;
    // }

    $related_query = new WP_Query($related_args);
?>

    <main id="primary" class="site-main single-article">

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-article-entry'); ?>>

            <header class="single-article-hero position-relative overflow-hidden">

                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full', array(
                        'class' => 'single-article-hero__image w-100 h-auto d-block',
                    )); ?>
                <?php endif; ?>

                <div class="position-absolute top-0 start-0 w-100 h-100"
                    style="background: linear-gradient(180deg, rgba(0,0,0,.10), rgba(0,0,0,.65)); z-index: 1;">
                </div>

                <div class="position-absolute bottom-0 start-0 w-100 px-4 px-md-5 pb-5 text-white"
                    style="z-index: 2;">
                    <div style="max-width: 900px;">
                        <h1 class="fw-bold mb-0"
                            style="font-size: clamp(2rem, 4.2vw, 4rem); line-height: 1.08; text-transform: uppercase;">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>

            </header>

            <div class="container px-4 px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-9">

                        <section class="single-article-meta py-4 border-bottom">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center" style="font-size: 11px; padding: 5px 12px; border: 1.5px solid #163d6b; color: #163d6b;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                            <line x1="9" y1="9" x2="15" y2="9" stroke-width="1.8" />
                                            <line x1="9" y1="13" x2="15" y2="13" stroke-width="1.8" />
                                            <line x1="10.5" y1="7" x2="10.5" y2="15" stroke-width="1.8" />
                                            <line x1="13.5" y1="7" x2="13.5" y2="15" stroke-width="1.8" />
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

                                <div class="small text-secondary d-flex flex-wrap gap-3">
                                    <span>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?php echo esc_html(get_the_date('j F Y')); ?>
                                    </span>
                                    <span>
                                        <i class="bi bi-person me-1"></i>
                                        <?php echo esc_html(get_the_author()); ?>
                                    </span>
                                    <span>
                                        <i class="bi bi-eye me-1"></i>
                                        <?php
                                        echo esc_html(
                                            number_format_i18n((int) get_post_meta(get_the_ID(), 'customtheme_post_views', true))
                                        );
                                        ?>
                                        views
                                    </span>
                                </div>
                            </div>
                        </section>

                        <div class="single-article-content py-5">
                            <?php the_content(); ?>
                        </div>

                        <section class="single-article-author border-top pt-4">
                            <p class="small text-uppercase text-secondary mb-1">Penulis</p>
                            <div class="d-flex align-items-center gap-3">
                                <?php echo get_avatar($author_id, 56, '', get_the_author(), array(
                                    'class' => 'rounded-circle',
                                )); ?>

                                <div>
                                    <h2 class="h6 mb-1 text-navy">
                                        <?php echo esc_html(get_the_author()); ?>
                                    </h2>

                                    <?php if (get_the_author_meta('description', $author_id)) : ?>
                                        <p class="small text-secondary mb-0">
                                            <?php echo esc_html(get_the_author_meta('description', $author_id)); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </section>

                        <?php if (!empty($tags)) : ?>
                            <section class="single-article-tags border-top mt-4 pt-4">
                                <h2 class="h6 text-navy mb-3">Tag</h2>

                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($tags as $tag) : ?>
                                        <a class="single-article-tag"
                                            href="<?php echo esc_url(get_tag_link($tag)); ?>">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>

                        <section class="single-article-share border-top mt-4 pt-4 pb-5">
                            <h2 class="h6 text-navy mb-3">Bagikan artikel</h2>

                            <div class="d-flex flex-wrap gap-2">
                                <a class="btn btn-outline-primary btn-sm"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($share_url); ?>">
                                    <i class="bi bi-facebook"></i>
                                    Facebook
                                </a>

                                <a class="btn btn-outline-success btn-sm"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    href="https://wa.me/?text=<?php echo esc_attr($share_title . '%20' . $share_url); ?>">
                                    <i class="bi bi-whatsapp"></i>
                                    WhatsApp
                                </a>

                                <a class="btn btn-outline-secondary btn-sm"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr($share_url); ?>">
                                    <i class="bi bi-linkedin"></i>
                                    LinkedIn
                                </a>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </article>

        <?php if ($related_query->have_posts()) : ?>
            <section class="single-article-related py-5">
                <div class="container px-4 px-lg-5">
                    <h2 class="text-center text-navy fw-bold mb-4">Artikel Terkait</h2>

                    <div class="row g-4">
                        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                            <div class="col-md-6 col-lg-4">
                                <article <?php post_class('card h-100 border-0 shadow-sm rounded-4 overflow-hidden'); ?>>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>" class="d-block">
                                            <?php the_post_thumbnail('medium_large', array(
                                                'class' => 'w-100 single-related-card__image',
                                            )); ?>
                                        </a>
                                    <?php endif; ?>

                                    <div class="card-body p-4">
                                        <p class="small text-secondary mb-2">
                                            <?php echo esc_html(get_the_date('j F Y')); ?>
                                        </p>

                                        <h3 class="h6 fw-bold mb-0">
                                            <a href="<?php the_permalink(); ?>" class="text-navy text-decoration-none">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </main>

<?php
    wp_reset_postdata();
endwhile;

get_footer();
