<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package customtheme
 */

get_header();
?>

<main id="primary" class="site-main py-5 text-center">
    <div class="container px-4 px-lg-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1 class="display-1 fw-bold text-danger mb-3">404</h1>
                <h3 class="fw-bold text-navy mb-3">Halaman Tidak Ditemukan</h3>
                <p class="text-secondary mb-4">
                    Maaf, halaman yang Anda cari tidak ditemukan atau telah dipindahkan.
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-navy px-4 py-2 fw-semibold rounded-pill">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
