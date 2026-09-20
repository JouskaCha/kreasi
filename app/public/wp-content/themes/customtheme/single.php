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

    $category_ids = wp_list_pluck($categories, 'term_id');

    $related_args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => true,
    );

    if (!empty($category_ids)) {
        $related_args['category__in'] = $category_ids;
    }

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
                                    <?php foreach ($categories as $category) : ?>
                                        <a class="single-article-badge single-article-badge--category"
                                            href="<?php echo esc_url(get_category_link($category)); ?>">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>

                                    <?php if (!empty($tags)) : ?>
                                        <?php foreach (array_slice($tags, 0, 2) as $tag) : ?>
                                            <a class="single-article-badge single-article-badge--tag"
                                                href="<?php echo esc_url(get_tag_link($tag)); ?>">
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
