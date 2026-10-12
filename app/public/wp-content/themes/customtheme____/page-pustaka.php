<?php
/**
 * Template Name: Pustaka
 * The template for displaying the Pustaka page
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main page-pustaka py-5">
    <div class="container px-4 px-lg-5">

        <!-- Header Halaman Pustaka -->
        <header class="page-header mb-5 text-center">
            <h1 class="page-title fw-bold text-navy mb-3">
                <?php the_title(); ?>
            </h1>
            <p class="text-secondary lead mx-auto" style="max-width: 700px;">
                Pusat Sumber Daya & Publikasi Edukasi KREASI
            </p>
        </header>

        <!-- Area Konten / Modul Pustaka (Siap Diisi Desain Figma) -->
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="bg-light p-5 rounded-4 text-center border">
                    <h4 class="text-navy fw-bold mb-2">Section Konten Pustaka</h4>
                    <p class="text-muted mb-0">
                        Area template kosong untuk halaman <strong>Pustaka</strong>. 
                        Anda dapat meletakkan filter dokumen, modul download buku/modul, atau katalog publikasi di sini.
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
