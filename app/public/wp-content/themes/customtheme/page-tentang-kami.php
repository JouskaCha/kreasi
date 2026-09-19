<?php
/**
 * Template Name: Tentang Kami
 * The template for displaying the Tentang Kami page
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main page-tentang-kami py-5">
    <div class="container px-4 px-lg-5">

        <!-- Header Halaman Tentang Kami -->
        <header class="page-header mb-5 text-center">
            <h1 class="page-title fw-bold text-navy mb-3">
                <?php the_title(); ?>
            </h1>
            <p class="text-secondary lead mx-auto" style="max-width: 700px;">
                Kolaborasi untuk Edukasi Anak Indonesia (KREASI)
            </p>
        </header>

        <!-- Area Konten / Sections Khusus Tentang Kami (Siap Diisi Desain Figma) -->
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="bg-light p-5 rounded-4 text-center border">
                    <h4 class="text-navy fw-bold mb-2">Section Konten Tentang Kami</h4>
                    <p class="text-muted mb-0">
                        Area template kosong untuk halaman <strong>Tentang Kami</strong>. 
                        Anda dapat meletakkan markup HTML spesifik berdasarkan desain Figma di sini atau memuat konten dari editor WordPress.
                    </p>
                </div>
            </div>
        </div>

        <!-- WordPress Editor Content Fallback -->
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                if (get_the_content()) :
        ?>
                    <div class="entry-content mt-5">
                        <?php the_content(); ?>
                    </div>
        <?php
                endif;
            endwhile;
        endif;
        ?>

    </div>
</main>

<?php
get_footer();
