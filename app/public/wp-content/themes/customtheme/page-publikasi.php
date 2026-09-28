<?php

/**
 * Template Name: Publikasi
 * The template for displaying the Publikasi page
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main page-publikasi">
    <?php
    $publication_banner_image = '';
    $publication_banner_attachments = get_posts(array(
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'     => '_wp_attached_file',
                'value'   => 'banner_publikasi_2-scaled',
                'compare' => 'LIKE',
            ),
        ),
    ));

    if (!empty($publication_banner_attachments)) {
        $publication_banner_image = wp_get_attachment_image_url($publication_banner_attachments[0]->ID, 'full');
    }

    if (!$publication_banner_image) {
        $publication_banner_image = get_theme_mod(
            'hero_image',
            'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=1600&w=2200&auto=format&fit=crop'
        );
    }
    ?>

    <section class="publication-banner position-relative overflow-hidden" style="--publication-banner-image: url('<?php echo esc_url($publication_banner_image); ?>');">
        <div class="publication-banner__overlay position-absolute top-0 start-0 w-100 h-100"></div>
        <div class="container position-relative h-100 d-flex align-items-center justify-content-center px-4 px-lg-5">
            <div class="publication-banner__content text-center text-white">
                <span class="publication-banner__eyebrow d-inline-block mb-4">PUBLIKASI</span>
                <h1 class="publication-banner__title fw-bold text-uppercase mb-3">
                    BACA LEBIH. TAHU LEBIH. <span>BERBUAT LEBIH.</span>
                </h1>
                <p class="publication-banner__description mx-auto mb-0">
                    Literasi adalah kunci pergerakan nyata. Pelajari langkah strategis, laporan dampak,
                    dan materi edukasi kami yang dirancang khusus untuk mendukung pemerataan pendidikan anak Indonesia.
                </p>
            </div>
        </div>
    </section>

    <?php get_template_part('parts/section', 'documents'); ?>

    <?php get_template_part('parts/section', 'publications'); ?>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (get_the_content()) : ?>
                <div class="container px-4 px-lg-5 py-5 entry-content">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>