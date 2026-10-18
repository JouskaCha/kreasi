<?php
/**
 * Template Name: Tentang Kami
 * The template for displaying the Tentang Kami page
 *
 * @package kreasi_redesign_2026
 */

get_header();
?>

<main id="primary" class="site-main page-tentang-kami">

    <!-- ==========================================
         SECTION 1: HERO INTRO & PETA INDONESIA
    =========================================== -->
    <section class="tentang-hero-section py-5 bg-white position-relative overflow-hidden">
        <div class="container px-4 px-lg-5 pt-3 pt-md-4">
            
            <!-- ROW 1: HEADING (KIRI) & DESKRIPSI (KANAN) -->
            <div class="row align-items-center gy-4 mb-5">
                <!-- SISI KIRI: HEADING BESAR -->
                <div class="col-lg-5 col-md-12">
                    <h1 class="tentang-hero-heading mb-0" 
                        style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(38px, 4.5vw, 60px); line-height: 1.1; color: #0b2351; text-transform: uppercase; font-weight: 700; letter-spacing: -0.5px;">
                        UNTUK<br>
                        PENDIDIKAN YANG<br>
                        <span style="color: #D8232A;">BERKUALITAS</span>
                    </h1>
                </div>

                <!-- SISI KANAN: PARAGRAF DESKRIPSI LENGKAP -->
                <div class="col-lg-7 col-md-12">
                    <p class="tentang-hero-desc mb-0" 
                       style="font-family: 'Lato', sans-serif; font-size: 17px; line-height: 1.75; color: #222221; font-weight: 500;">
                        <strong>KREASI</strong> atau <strong>Kolaborasi untuk Edukasi Anak Indonesia</strong> adalah program peningkatan kualitas pendidikan dengan memperkuat literasi, numerasi, dan pendidikan karakter di delapan kabupaten di empat provinsi di Indonesia. KREASI dikelola Save the Children, diimplementasi mitra pelaksana lokal, dengan pendanaan Global Partnership for Education (GPE) dan didukung Mitra Pendidikan Indonesia yang dipimpin Kementerian Pendidikan Dasar dan Menengah (Kemendikdasmen) dan Kementerian Agama (Kemenag).
                    </p>
                </div>
            </div>

            <!-- ROW 2: PETA INDONESIA (WILAYAH INTERVENSI DENGAN HIGHLIGHT MERAH) -->
            <div class="tentang-map-wrapper text-center my-4 my-lg-5 px-2">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/map-indonesia.png'); ?>" 
                     alt="Peta Wilayah Intervensi Program KREASI" 
                     class="img-fluid d-block mx-auto tentang-map-img"
                     style="max-width: 960px; width: 100%; height: auto; object-fit: contain;">
            </div>

        </div>
    </section>


    <!-- ==========================================
         SECTION 2: PARTNER KOLABORASI KAMI (RED BG)
    =========================================== -->
    <section class="partner-kolaborasi-section py-5 position-relative text-white" 
             style="background-color: #D8232A;">
        <div class="container px-4 px-lg-5 py-lg-4">
            
            <!-- HEADER SECTION -->
            <div class="text-center mb-5">
                <h2 class="text-white text-uppercase mb-2" 
                    style="font-family: 'Oswald', sans-serif; font-size: clamp(34px, 4vw, 52px); font-weight: 700; letter-spacing: 0.5px;">
                    PARTNER KOLABORASI KAMI
                </h2>
                <p class="text-white mb-0 mx-auto" 
                   style="font-family: 'Lato', sans-serif; font-size: 17px; font-weight: 400; opacity: 0.95; max-width: 780px;">
                    Dari advokasi untuk kebijakan pendidikan yang lebih baik, hingga ke ruang kelas yang menyenangkan.
                </p>
            </div>

            <!-- GRID 4 KARTU PARTNER (2x2 DI DESKTOP & TABLET, 1 KOLOM DI MOBILE) -->
            <div class="row g-4 justify-content-center">
                
                <!-- CARD 1: GPE -->
                <div class="col-md-6 col-lg-5">
                    <div class="partner-card bg-white p-4 p-xl-5 rounded-4 h-100 d-flex flex-column align-items-center text-center shadow-sm">
                        <div class="partner-card-logo-wrap mb-4 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-gpe.png'); ?>" 
                                 alt="Global Partnership for Education (GPE)" 
                                 class="partner-card-logo img-fluid" 
                                 style="max-height: 50px; width: auto; object-fit: contain;">
                        </div>
                        <p class="partner-card-desc mb-0 text-secondary" 
                           style="font-family: 'Lato', sans-serif; font-size: 14px; line-height: 1.65; color: #333333 !important;">
                            Global Partnership for Education (GPE) adalah lembaga pendanaan global terbesar yang didedikasikan untuk mentransformasi pendidikan di negara-negara berpendapatan rendah, serta merupakan kemitraan unik yang melibatkan berbagai pemangku kepentingan. GPE merupakan pendonor untuk program KREASI.
                        </p>
                    </div>
                </div>

                <!-- CARD 2: Save the Children -->
                <div class="col-md-6 col-lg-5">
                    <div class="partner-card bg-white p-4 p-xl-5 rounded-4 h-100 d-flex flex-column align-items-center text-center shadow-sm">
                        <div class="partner-card-logo-wrap mb-4 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-save-the-children.png'); ?>" 
                                 alt="Save the Children" 
                                 class="partner-card-logo img-fluid" 
                                 style="max-height: 48px; width: auto; object-fit: contain;">
                        </div>
                        <p class="partner-card-desc mb-0 text-secondary" 
                           style="font-family: 'Lato', sans-serif; font-size: 14px; line-height: 1.65; color: #333333 !important;">
                            Save the Children adalah organisasi independen yang bekerja di lebih dari 120 negara di seluruh dunia, mengembangkan kemitraan dengan organisasi lokal, serta menyediakan pelatihan dan sumber daya untuk membangun dan memberdayakan komunitas, di mana ada anak-anak yang membutuhkannya. Save the Children merupakan pengelola program KREASI.
                        </p>
                    </div>
                </div>

                <!-- CARD 3: Kemendikdasmen -->
                <div class="col-md-6 col-lg-5">
                    <div class="partner-card bg-white p-4 p-xl-5 rounded-4 h-100 d-flex flex-column align-items-center text-center shadow-sm">
                        <div class="partner-card-logo-wrap mb-4 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-kemendikdasmen.png'); ?>" 
                                 alt="Kementerian Pendidikan Dasar dan Menengah" 
                                 class="partner-card-logo img-fluid" 
                                 style="max-height: 52px; width: auto; object-fit: contain;">
                        </div>
                        <p class="partner-card-desc mb-0 text-secondary" 
                           style="font-family: 'Lato', sans-serif; font-size: 14px; line-height: 1.65; color: #333333 !important;">
                            Kementerian Pendidikan Dasar dan Menengah Republik Indonesia (Kemendikdasmen RI) adalah pendukung utama program KREASI. Kemendikdasmen adalah pimpinan (co-chair) konsorsium kolaboratif bersama Mitra Pendidikan Indonesia (MPI), yang merupakan pengarah program KREASI.
                        </p>
                    </div>
                </div>

                <!-- CARD 4: Kemenag -->
                <div class="col-md-6 col-lg-5">
                    <div class="partner-card bg-white p-4 p-xl-5 rounded-4 h-100 d-flex flex-column align-items-center text-center shadow-sm">
                        <div class="partner-card-logo-wrap mb-4 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-kemenag.png'); ?>" 
                                 alt="Kementerian Agama Republik Indonesia" 
                                 class="partner-card-logo img-fluid" 
                                 style="max-height: 52px; width: auto; object-fit: contain;">
                        </div>
                        <p class="partner-card-desc mb-0 text-secondary" 
                           style="font-family: 'Lato', sans-serif; font-size: 14px; line-height: 1.65; color: #333333 !important;">
                            Kementerian Agama Republik Indonesia (Kemenag RI) adalah pendukung utama program KREASI. Kemenag adalah pimpinan (co-chair) konsorsium kolaboratif bersama Mitra Pendidikan Indonesia (MPI), yang merupakan pengarah program KREASI.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- ==========================================
         SECTION 3: ARTIKEL TERKINI (OTOMATIS DARI POST)
    =========================================== -->
    <?php
    // Query 3 Artikel Terkini dari kategori parent 'artikel' (dan sub-kategori seperti Cerita / Berita)
    $artikel_cat_ids   = function_exists('kreasi_get_artikel_category_ids') ? kreasi_get_artikel_category_ids() : array();
    $publikasi_cat_ids = function_exists('kreasi_get_publikasi_category_ids') ? kreasi_get_publikasi_category_ids() : array();

    $args_tentang_articles = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'orderby'             => 'date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
    );

    if (!empty($artikel_cat_ids)) {
        $args_tentang_articles['category__in'] = $artikel_cat_ids;
    }
    if (!empty($publikasi_cat_ids)) {
        $args_tentang_articles['category__not_in'] = $publikasi_cat_ids;
    }

    $tentang_articles_query = new WP_Query($args_tentang_articles);
    ?>

    <section class="tentang-artikel-section py-5 bg-white position-relative">
        <div class="container px-4 px-lg-5 py-lg-4">
            
            <!-- HEADER SECTION -->
            <div class="text-center mb-5">
                <h2 class="text-uppercase mb-2" 
                    style="font-family: 'Oswald', sans-serif; font-size: clamp(32px, 3.8vw, 48px); font-weight: 700; letter-spacing: 0.5px; color: #111827;">
                    ARTIKEL TERKINI
                </h2>
                <p class="mb-0 mx-auto text-secondary" 
                   style="font-family: 'Lato', sans-serif; font-size: 16px; font-weight: 400; max-width: 600px;">
                    Ikuti berita perkembangan dan cerita dari delapan kabupaten dampingan KREASI
                </p>
            </div>

            <!-- GRID 3 KARTU ARTIKEL -->
            <div class="row g-4 justify-content-center mb-5">
                
                <?php
                if ($tentang_articles_query->have_posts()) :
                    while ($tentang_articles_query->have_posts()) :
                        $tentang_articles_query->the_post();
                        
                        // Kategori Child (Cerita / Berita / Liputan Media)
                        $cat_obj  = function_exists('kreasi_get_post_child_category') ? kreasi_get_post_child_category(get_the_ID()) : null;
                        $cat_name = $cat_obj ? $cat_obj->name : 'Cerita';

                        // Tag Daerah (Kayong Utara, dll)
                        $tag_obj  = function_exists('kreasi_get_post_region_tag') ? kreasi_get_post_region_tag(get_the_ID()) : null;
                        $tag_name = $tag_obj ? $tag_obj->name : 'Kayong Utara';

                        $thumb_url = has_post_thumbnail() 
                            ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') 
                            : get_template_directory_uri() . '/assets/images/thumbnail-1.png';
                ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="card article-card border-0 rounded-4 overflow-hidden shadow-sm h-100 bg-white">
                                <!-- THUMBNAIL IMAGE -->
                                <div class="position-relative overflow-hidden" style="height: 220px;">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url($thumb_url); ?>" 
                                             alt="<?php the_title_attribute(); ?>" 
                                             class="w-100 h-100 object-fit-cover article-card-img" 
                                             style="transition: transform 0.4s ease;">
                                    </a>
                                </div>

                                <!-- CARD BODY -->
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <!-- BADGES ROW -->
                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                            <!-- BADGE KATEGORI CHILD -->
                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="font-family: 'Lato', sans-serif; font-size: 11px; padding: 5px 12px; border: 1.5px solid #163d6b; color: #163d6b;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                                    <line x1="9" y1="9" x2="15" y2="9" stroke-width="1.8"/>
                                                    <line x1="9" y1="13" x2="15" y2="13" stroke-width="1.8"/>
                                                </svg>
                                                <?php echo esc_html($cat_name); ?>
                                            </span>

                                            <!-- BADGE TAG DAERAH -->
                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="font-family: 'Lato', sans-serif; font-size: 11px; padding: 5px 12px; border: 1.5px solid #D8232A; color: #D8232A;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                                <?php echo esc_html($tag_name); ?>
                                            </span>
                                        </div>

                                        <!-- JUDUL ARTIKEL -->
                                        <h5 class="fw-bold mb-3" style="font-family: 'Oswald', sans-serif; font-size: 18px; line-height: 1.35; letter-spacing: -0.2px;">
                                            <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark article-title-link">
                                                <?php the_title(); ?>
                                            </a>
                                        </h5>
                                    </div>

                                    <!-- TANGGAL PUBLIKASI -->
                                    <div class="mt-2">
                                        <span class="small text-secondary" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                            <?php echo get_the_date('j F Y'); ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback visual jika database belum ada postingan
                    $dummy_tentang = array(
                        array(
                            'title' => 'KREASI Kayong Utara Dorong Penguatan Ekosistem Pendidikan Daerah',
                            'date'  => '26 Juli 2026',
                            'cat'   => 'Cerita',
                            'tag'   => 'Kayong Utara',
                            'img'   => get_template_directory_uri() . '/assets/images/thumbnail-1.png'
                        ),
                        array(
                            'title' => 'KREASI Kayong Utara Dorong Penguatan Ekosistem Pendidikan Daerah',
                            'date'  => '26 Juli 2026',
                            'cat'   => 'Cerita',
                            'tag'   => 'Kayong Utara',
                            'img'   => get_template_directory_uri() . '/assets/images/thumbnail-2.png'
                        ),
                        array(
                            'title' => 'KREASI Kayong Utara Dorong Penguatan Ekosistem Pendidikan Daerah',
                            'date'  => '26 Juli 2026',
                            'cat'   => 'Cerita',
                            'tag'   => 'Kayong Utara',
                            'img'   => get_template_directory_uri() . '/assets/images/thumbnail3.png'
                        ),
                    );

                    foreach ($dummy_tentang as $dummy) :
                ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="card article-card border-0 rounded-4 overflow-hidden shadow-sm h-100 bg-white">
                                <div class="position-relative overflow-hidden" style="height: 220px;">
                                    <a href="<?php echo esc_url(home_url('/artikel/')); ?>">
                                        <img src="<?php echo esc_url($dummy['img']); ?>" 
                                             alt="<?php echo esc_attr($dummy['title']); ?>" 
                                             class="w-100 h-100 object-fit-cover article-card-img" 
                                             style="transition: transform 0.4s ease;">
                                    </a>
                                </div>

                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="font-family: 'Lato', sans-serif; font-size: 11px; padding: 5px 12px; border: 1.5px solid #163d6b; color: #163d6b;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                                                    <line x1="9" y1="9" x2="15" y2="9" stroke-width="1.8"/>
                                                    <line x1="9" y1="13" x2="15" y2="13" stroke-width="1.8"/>
                                                </svg>
                                                <?php echo esc_html($dummy['cat']); ?>
                                            </span>

                                            <span class="badge rounded-pill fw-semibold bg-transparent d-inline-flex align-items-center"
                                                  style="font-family: 'Lato', sans-serif; font-size: 11px; padding: 5px 12px; border: 1.5px solid #D8232A; color: #D8232A;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                                <?php echo esc_html($dummy['tag']); ?>
                                            </span>
                                        </div>

                                        <h5 class="fw-bold mb-3" style="font-family: 'Oswald', sans-serif; font-size: 18px; line-height: 1.35; letter-spacing: -0.2px;">
                                            <a href="<?php echo esc_url(home_url('/artikel/')); ?>" class="text-decoration-none text-dark article-title-link">
                                                <?php echo esc_html($dummy['title']); ?>
                                            </a>
                                        </h5>
                                    </div>

                                    <div class="mt-2">
                                        <span class="small text-secondary" style="font-family: 'Lato', sans-serif; font-size: 12px;">
                                            <?php echo esc_html($dummy['date']); ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>

            </div>

            <!-- TOMBOL BACA ARTIKEL LAINNYA -->
            <div class="text-center pt-2">
                <a href="<?php echo esc_url(home_url('/artikel/')); ?>" 
                   class="btn text-white text-uppercase px-4 py-3 fw-bold shadow-sm"
                   style="font-family: 'Oswald', sans-serif; background-color: #D8232A; border-radius: 6px; font-size: 13px; letter-spacing: 0.5px; transition: all 0.3s ease;">
                    BACA ARTIKEL LAINNYA
                </a>
            </div>

        </div>
    </section>

    <!-- WordPress Editor Content Fallback (jika user menambahkan teks di WP Admin / Elementor) -->
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            if (get_the_content()) :
    ?>
                <section class="tentang-wp-content py-4 bg-white border-top">
                    <div class="container px-4 px-lg-5">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
    <?php
            endif;
        endwhile;
    endif;
    ?>

</main>

<style>
.partner-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.partner-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12) !important;
}
.article-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.article-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12) !important;
}
.article-card:hover .article-card-img {
    transform: scale(1.05);
}
.article-card:hover .article-title-link {
    color: #163d6b !important;
}
</style>

<?php
get_footer();
