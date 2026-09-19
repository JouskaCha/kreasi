<?php
/**
 * The template for displaying the blog posts index (Artikel / Berita)
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main py-5">
    <div class="container px-4 px-lg-5">

        <!-- Header Halaman Artikel -->
        <header class="page-header mb-5 text-center">
            <h1 class="page-title fw-bold text-navy mb-2">Artikel & Berita</h1>
            <p class="text-secondary lead">Kabar terkini seputar kegiatan dan perkembangan edukasi anak Indonesia.</p>
        </header>

        <!-- Daftar Artikel (Grid Layout) -->
        <div class="row g-4">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
            ?>
                    <div class="col-md-6 col-lg-4">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 border-0 shadow-sm rounded-4 overflow-hidden'); ?>>
                            <!-- Thumbnail / Gambar Artikel -->
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail" style="height: 200px; overflow: hidden;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', array('class' => 'w-100 h-100 object-fit-cover')); ?>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted small">No Image</span>
                                </div>
                            <?php endif; ?>

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column p-4">
                                <div class="post-meta small text-muted mb-2">
                                    <span><?php echo get_the_date('d M Y'); ?></span>
                                </div>

                                <h5 class="card-title fw-bold mb-3">
                                    <a href="<?php the_permalink(); ?>" class="text-navy text-decoration-none">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>

                                <div class="card-text text-secondary small mb-4 flex-grow-1">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="btn btn-navy btn-sm align-self-start fw-semibold px-3 py-2 rounded-3">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </article>
                    </div>
            <?php
                endwhile;

                // Pagination
                echo '<div class="col-12 mt-5 text-center">';
                the_posts_pagination(array(
                    'prev_text' => '&laquo; Sebelumnya',
                    'next_text' => 'Selanjutnya &raquo;',
                    'class'     => 'pagination justify-content-center',
                ));
                echo '</div>';

            else :
            ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada artikel yang dipublikasikan.</p>
                </div>
            <?php
            endif;
            ?>
        </div>

    </div>
</main>

<?php
get_footer();
