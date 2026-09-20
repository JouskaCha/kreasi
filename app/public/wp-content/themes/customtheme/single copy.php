<?php
/**
 * The template for displaying all single posts (Detail Artikel)
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main py-5">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <?php
                while (have_posts()) :
                    the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-entry'); ?>>
                        
                        <!-- Header Artikel -->
                        <header class="post-header mb-4">
                            <div class="post-meta text-muted small mb-2">
                                <span>Dipublikasikan pada: <?php echo get_the_date('d F Y'); ?></span>
                                <span class="mx-2">&bull;</span>
                                <span>Oleh: <?php the_author(); ?></span>
                            </div>
                            <h1 class="post-title fw-bold text-navy mb-3">
                                <?php the_title(); ?>
                            </h1>
                        </header>

                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-featured-image mb-4 rounded-4 overflow-hidden">
                                <?php the_post_thumbnail('large', array('class' => 'w-100 h-auto')); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Isi Konten Artikel -->
                        <div class="post-content lh-lg text-secondary mb-5">
                            <?php the_content(); ?>
                        </div>

                        <!-- Navigasi Artikel Sebelumnya / Selanjutnya -->
                        <div class="post-navigation border-top border-bottom py-3 d-flex justify-content-between mb-5">
                            <div><?php previous_post_link('&larr; %link', 'Artikel Sebelumnya'); ?></div>
                            <div><?php next_post_link('%link &rarr;', 'Artikel Berikutnya'); ?></div>
                        </div>

                    </article>
                <?php
                endwhile;
                ?>

            </div>
        </div>
    </div>
</main>

<?php
get_footer();
