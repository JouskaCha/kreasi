<?php
/**
 * The template for displaying search results pages
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main py-5">
    <div class="container px-4 px-lg-5">

        <header class="page-header mb-5">
            <h1 class="page-title fw-bold text-navy">
                Hasil Pencarian: <span class="text-primary">"<?php echo esc_html(get_search_query()); ?>"</span>
            </h1>
        </header>

        <div class="row g-4">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
            ?>
                    <div class="col-12">
                        <article class="p-4 bg-light rounded-3 border">
                            <h4 class="fw-bold mb-2">
                                <a href="<?php the_permalink(); ?>" class="text-navy text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                            <p class="text-secondary small mb-2"><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="text-primary small fw-semibold">Baca Selengkapnya &rarr;</a>
                        </article>
                    </div>
            <?php
                endwhile;

                the_posts_pagination(array(
                    'prev_text' => '&laquo; Sebelumnya',
                    'next_text' => 'Selanjutnya &raquo;',
                    'class'     => 'pagination justify-content-center mt-4',
                ));
            else :
            ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Tidak ditemukan hasil untuk pencarian tersebut. Silakan coba kata kunci lain.</p>
                </div>
            <?php
            endif;
            ?>
        </div>

    </div>
</main>

<?php
get_footer();
