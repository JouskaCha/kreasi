<?php
/**
 * Template Name: Foto Kegiatan
 * The template for displaying the Foto Kegiatan archive and listing page.
 * Sesuai desain Image 1 (Header Batik Biru, Filter & Search, Grid 3 Kolom Kartu Polaroid Bertumpuk, Pagination)
 *
 * @package kreasi_redesign_2026
 */

get_header();

// Parameter Pencarian & Filter Daerah
$search_query   = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : (isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '');
$current_daerah = isset($_GET['daerah']) ? sanitize_title($_GET['daerah']) : '';

$paged = 1;
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
} elseif (isset($_GET['paged'])) {
    $paged = max(1, (int)$_GET['paged']);
}

// Query Posts untuk Foto Kegiatan
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

// Filter Kategori: Cari slug foto-kegiatan atau kegiatan
$foto_cat = get_category_by_slug('foto-kegiatan');
if (!$foto_cat) {
    $foto_cat = get_category_by_slug('kegiatan');
}
if (!$foto_cat) {
    $foto_cat = get_term_by('name', 'Foto Kegiatan', 'category');
}

if ($foto_cat && !is_wp_error($foto_cat)) {
    $args['cat'] = $foto_cat->term_id;
}

if (!empty($current_daerah) && $current_daerah !== 'semua') {
    $args['tag'] = $current_daerah;
}

if (!empty($search_query)) {
    $args['s'] = $search_query;
}

$query = new WP_Query($args);
$has_posts = $query->have_posts();

// Data fallback sesuai desain Figma Image 1 jika database masih kosong
$default_photos = array(
    array(
        'title' => '226 Siswa SD di Nias Utara Ikuti Kampanye Kebersihan Lingkungan',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail-1.png',
        'link'  => '#',
    ),
    array(
        'title' => 'Lima Hari Lokakarya untuk Peningkatan Kapasitas KREASI',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail-2.png',
        'link'  => '#',
    ),
    array(
        'title' => 'Lima Hari Lokakarya untuk Peningkatan Kapasitas KREASI',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail3.png',
        'link'  => '#',
    ),
    array(
        'title' => '226 Siswa SD di Nias Utara Ikuti Kampanye Kebersihan Lingkungan',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail-1.png',
        'link'  => '#',
    ),
    array(
        'title' => 'Lima Hari Lokakarya untuk Peningkatan Kapasitas KREASI',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail-2.png',
        'link'  => '#',
    ),
    array(
        'title' => 'Lima Hari Lokakarya untuk Peningkatan Kapasitas KREASI',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail3.png',
        'link'  => '#',
    ),
    array(
        'title' => '226 Siswa SD di Nias Utara Ikuti Kampanye Kebersihan Lingkungan',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail-1.png',
        'link'  => '#',
    ),
    array(
        'title' => 'Lima Hari Lokakarya untuk Peningkatan Kapasitas KREASI',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail-2.png',
        'link'  => '#',
    ),
    array(
        'title' => 'Lima Hari Lokakarya untuk Peningkatan Kapasitas KREASI',
        'date'  => '26 Juli 2026',
        'image' => get_template_directory_uri() . '/assets/images/thumbnail3.png',
        'link'  => '#',
    ),
);

$bg_header = get_template_directory_uri() . '/assets/images/bg-header-artikel.png';
$base_url  = home_url('/foto-kegiatan/');
?>

<main id="primary" class="site-main page-foto-kegiatan bg-white pb-5">

    <!-- ==========================================
         HERO HEADER BANNER: BIRU MOTIF BATIK (FIGMA IMAGE 1)
    =========================================== -->
    <section class="foto-kegiatan-hero text-center text-white d-flex align-items-center justify-content-center position-relative overflow-hidden"
             style="background: #0B2055 url('<?php echo esc_url($bg_header); ?>') center/cover no-repeat; min-height: 240px; padding: 60px 15px;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(11, 32, 85, 0.78); z-index: 1;"></div>
        
        <div class="container position-relative" style="z-index: 2; max-width: 860px;">
            <h1 class="page-title text-white fw-bold mb-3 text-uppercase" 
                style="font-family: 'Oswald', 'Bebas Neue', sans-serif; font-size: clamp(40px, 5vw, 64px); letter-spacing: 1px;">
                <?php echo esc_html(kreasi_t('foto_kegiatan_title', 'FOTO KEGIATAN', 'ACTIVITY PHOTOS')); ?>
            </h1>
            <p class="mb-0 text-white" style="font-family: 'Lato', sans-serif; font-size: 15px; font-weight: 400; opacity: 0.95; line-height: 1.6;">
                <?php echo esc_html(kreasi_t('foto_kegiatan_subtitle', 'Pelajari langkah strategis, laporan dampak, dan materi edukasi kami yang dirancang khusus untuk mendukung pemerataan pendidikan anak Indonesia.', 'Learn about our strategic steps, impact reports, and educational materials specifically designed to support educational equity for Indonesian children.')); ?>
            </p>
        </div>
    </section>

    <!-- ==========================================
         FILTER & SEARCH BAR (FIGMA IMAGE 1)
    =========================================== -->
    <div class="container px-4 px-lg-5 py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            
            <!-- SISI KIRI: FILTER BUTTON / DROPDOWN -->
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3 py-2 fw-bold text-uppercase border-0 shadow-none text-navy" 
                            type="button" 
                            id="filterFotoDropdown" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false"
                            style="font-family: 'Oswald', sans-serif; font-size: 14px; letter-spacing: 0.5px; color: #062172;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <span><?php echo esc_html(kreasi_t('filter', 'FILTER', 'FILTER')); ?></span>
                    </button>
                    <ul class="dropdown-menu shadow border-0 py-2 rounded-3" aria-labelledby="filterFotoDropdown">
                        <li><a class="dropdown-item" href="<?php echo esc_url($base_url); ?>"><?php echo esc_html(kreasi_t('all_regions', 'Semua Daerah', 'All Regions')); ?></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <?php
                        $region_tags = function_exists('kreasi_get_region_tags_with_counts') ? kreasi_get_region_tags_with_counts() : array();
                        foreach ($region_tags as $rg) :
                            $rg_url = add_query_arg('daerah', $rg->slug, $base_url);
                        ?>
                            <li><a class="dropdown-item" href="<?php echo esc_url($rg_url); ?>"><?php echo esc_html($rg->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if (!empty($current_daerah)) : ?>
                    <span class="badge bg-danger rounded-pill px-3 py-2 fw-normal d-inline-flex align-items-center">
                        <?php echo esc_html(ucwords(str_replace('-', ' ', $current_daerah))); ?>
                        <a href="<?php echo esc_url($base_url); ?>" class="text-white ms-2 text-decoration-none">&times;</a>
                    </span>
                <?php endif; ?>
            </div>

            <!-- SISI KANAN: SEARCH BAR CAPSULE (FIGMA IMAGE 1) -->
            <div style="min-width: 260px; max-width: 380px;" class="w-100">
                <form method="get" action="<?php echo esc_url($base_url); ?>">
                    <?php if (!empty($current_daerah)) : ?>
                        <input type="hidden" name="daerah" value="<?php echo esc_attr($current_daerah); ?>">
                    <?php endif; ?>
                    <div class="input-group search-pill-group rounded-pill overflow-hidden border" style="background-color: #E2E8F0;">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-secondary">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input type="text" 
                               name="q" 
                               value="<?php echo esc_attr($search_query); ?>" 
                               class="form-control bg-transparent border-0 py-2 ps-1 shadow-none" 
                               placeholder="<?php echo esc_attr(kreasi_t('search', 'SEARCH', 'SEARCH')); ?>" 
                               style="font-family: 'Lato', sans-serif; font-size: 13px; font-weight: 600; letter-spacing: 0.5px; color: #4B5563;">
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- ==========================================
         GRID 3 KOLOM KARTU FOTO KEGIATAN (FIGMA IMAGE 1)
    =========================================== -->
    <div class="container px-4 px-lg-5 mb-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 g-xl-5">
            
            <?php if ($has_posts) : 
                $card_counter = 0;
                while ($query->have_posts()) : $query->the_post(); 
                    $card_counter++;
                    $post_id    = get_the_ID();
                    $title      = get_the_title();
                    $link       = get_permalink();
                    $date       = get_the_date('j F Y');
                    $tilt_angle = ($card_counter % 2 === 0) ? '1.8deg' : '-1.8deg';

                    if (has_post_thumbnail($post_id)) {
                        $img_url = get_the_post_thumbnail_url($post_id, 'large');
                    } else {
                        $idx = $card_counter % count($default_photos);
                        $img_url = $default_photos[$idx]['image'];
                    }
            ?>
                    <div class="col">
                        <div class="polaroid-photo-card text-center d-flex flex-column h-100">
                            <!-- BINGKAI FOTO POLAROID DENGAN LAYER BERTUMPUK -->
                            <div class="polaroid-stack-container position-relative mb-3 mx-auto w-100">
                                <!-- LAYER BELAKANG YANG MIRING -->
                                <div class="polaroid-underlay position-absolute" 
                                     style="transform: rotate(<?php echo esc_attr($tilt_angle); ?>);"></div>

                                <!-- LAYER UTAMA BINGKAI FOTO PUTIH -->
                                <div class="polaroid-frame-main position-relative rounded-2 overflow-hidden bg-white shadow-sm">
                                    <a href="<?php echo esc_url($link); ?>" class="d-block w-100">
                                        <div class="polaroid-img-wrapper overflow-hidden" style="aspect-ratio: 16 / 10;">
                                            <img src="<?php echo esc_url($img_url); ?>" 
                                                 alt="<?php echo esc_attr($title); ?>" 
                                                 class="w-100 h-100 object-fit-cover polaroid-img">
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- TANGGAL KEGIATAN -->
                            <p class="text-secondary small mb-1 d-inline-flex align-items-center justify-content-center" 
                               style="font-family: 'Lato', sans-serif; font-size: 11.5px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1 text-muted">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo esc_html($date); ?>
                            </p>

                            <!-- JUDUL KEGIATAN -->
                            <h3 class="polaroid-title mb-0" 
                                style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; line-height: 1.35; color: #111111;">
                                <a href="<?php echo esc_url($link); ?>" class="text-decoration-none text-dark polaroid-title-link">
                                    <?php echo esc_html($title); ?>
                                </a>
                            </h3>
                        </div>
                    </div>

            <?php endwhile; wp_reset_postdata(); else : 
                // Tampilkan data default mock sesuai desain Gambar 1
                foreach ($default_photos as $k => $item) : 
                    $tilt_angle = ($k % 2 === 0) ? '-1.8deg' : '1.8deg';
            ?>
                    <div class="col">
                        <div class="polaroid-photo-card text-center d-flex flex-column h-100">
                            <!-- BINGKAI FOTO POLAROID DENGAN LAYER BERTUMPUK -->
                            <div class="polaroid-stack-container position-relative mb-3 mx-auto w-100">
                                <!-- LAYER BELAKANG YANG MIRING -->
                                <div class="polaroid-underlay position-absolute" 
                                     style="transform: rotate(<?php echo esc_attr($tilt_angle); ?>);"></div>

                                <!-- LAYER UTAMA BINGKAI FOTO PUTIH -->
                                <div class="polaroid-frame-main position-relative rounded-2 overflow-hidden bg-white shadow-sm">
                                    <a href="<?php echo esc_url($item['link']); ?>" class="d-block w-100">
                                        <div class="polaroid-img-wrapper overflow-hidden" style="aspect-ratio: 16 / 10;">
                                            <img src="<?php echo esc_url($item['image']); ?>" 
                                                 alt="<?php echo esc_attr($item['title']); ?>" 
                                                 class="w-100 h-100 object-fit-cover polaroid-img">
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- TANGGAL KEGIATAN -->
                            <p class="text-secondary small mb-1 d-inline-flex align-items-center justify-content-center" 
                               style="font-family: 'Lato', sans-serif; font-size: 11.5px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1 text-muted">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo esc_html($item['date']); ?>
                            </p>

                            <!-- JUDUL KEGIATAN -->
                            <h3 class="polaroid-title mb-0" 
                                style="font-family: 'Oswald', sans-serif; font-size: 16px; font-weight: 700; line-height: 1.35; color: #111111;">
                                <a href="<?php echo esc_url($item['link']); ?>" class="text-decoration-none text-dark polaroid-title-link">
                                    <?php echo esc_html($item['title']); ?>
                                </a>
                            </h3>
                        </div>
                    </div>
            <?php endforeach; endif; ?>

        </div>

        <?php if ($has_posts && $query->max_num_pages > 1) : ?>
        <!-- ==========================================
             PAGINATION
        =========================================== -->
        <div class="d-flex justify-content-center align-items-center mt-5 pt-3 pagination-wrapper">
            <nav aria-label="Page navigation">
                <?php
                echo paginate_links(array(
                    'base'      => add_query_arg('paged', '%#%'),
                    'format'    => '',
                    'current'   => $paged,
                    'total'     => $query->max_num_pages,
                    'prev_text' => '&lsaquo;',
                    'next_text' => '&rsaquo;',
                    'type'      => 'list',
                ));
                ?>
            </nav>
        </div>
        <?php endif; ?>

    </div>

</main>

<style>
/* STYLING BINGKAI FOTO POLAROID LAYERED (FIGMA IMAGE 1) */
.polaroid-stack-container {
    padding: 8px;
}

.polaroid-underlay {
    top: 4px;
    left: 4px;
    width: 98%;
    height: 98%;
    background-color: #ffffff;
    border: 1px solid #E5E7EB;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    z-index: 1;
    transition: transform 0.35s ease;
}

.polaroid-frame-main {
    padding: 8px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    z-index: 2;
    transition: transform 0.35s ease, box-shadow 0.35s ease;
}

.polaroid-img {
    transition: transform 0.4s ease;
}

.polaroid-photo-card:hover .polaroid-frame-main {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.14) !important;
}

.polaroid-photo-card:hover .polaroid-img {
    transform: scale(1.04);
}

.polaroid-photo-card:hover .polaroid-underlay {
    transform: rotate(0deg) scale(0.98);
}

.polaroid-title-link:hover {
    color: #D8232A !important;
}

/* PAGINATION SESUAI FIGMA */
.pagination-custom .page-link,
.pagination-wrapper .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px !important;
    border: 1px solid #E5E7EB;
    background-color: #FFFFFF;
    color: #4B5563;
    font-family: 'Lato', sans-serif;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    margin: 0 2px;
}

.pagination-custom .page-item.active .page-link,
.pagination-wrapper .page-numbers.current {
    background-color: #062172 !important;
    border-color: #062172 !important;
    color: #FFFFFF !important;
}

.pagination-custom .page-link:hover,
.pagination-wrapper a.page-numbers:hover {
    background-color: #F3F4F6;
    color: #062172;
}

.pagination-custom .page-item.disabled .page-link {
    color: #9CA3AF;
    background-color: transparent;
    border-color: transparent;
}
</style>

<?php get_footer(); ?>
