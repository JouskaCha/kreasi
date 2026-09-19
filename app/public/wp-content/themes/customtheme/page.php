<?php
/**
 * The template for displaying all static pages
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main py-5">
    <div class="container px-4 px-lg-5">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
        ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('page-entry'); ?>>
                    <!-- Page Header / Judul Halaman -->
                    <header class="entry-header mb-4">
                        <h1 class="entry-title fw-bold text-navy">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <!-- Page Content / Konten Dinamis dari Editor WordPress -->
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
        <?php
            endwhile;
        else :
        ?>
            <p class="text-muted">Tidak ada konten yang tersedia.</p>
        <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
