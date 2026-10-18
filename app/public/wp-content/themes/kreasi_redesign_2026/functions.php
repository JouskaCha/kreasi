<?php

/**
 * Functions and definitions for kreasi_redesign_2026
 *
 * @package kreasi_redesign_2026
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * 1. Setup Theme Features & Supports
 */
function kreasi_redesign_2026_setup_features()
{
    // Menambahkan dukungan Title Tag dinamis
    add_theme_support('title-tag');

    // Menambahkan dukungan Featured Image (Post Thumbnail)
    add_theme_support('post-thumbnails');

    // Menambahkan dukungan Custom Logo dari WordPress Media Library
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
        'unlink-homepage-logo' => false,
    ));

    // Menambahkan dukungan Block Patterns
    add_theme_support('core-block-patterns');

    // Menambahkan dukungan HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Registrasi Menu Navigasi Utama
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'kreasi_redesign_2026'),
    ));
}


add_action('after_setup_theme', 'kreasi_redesign_2026_setup_features');
/**
 * Register custom design page routes.
 */
function kreasi_redesign_2026_register_design_routes()
{
    add_rewrite_rule(
        '^artikel/?$',
        'index.php?kreasi_redesign_2026_design_page=artikel',
        'top'
    );

    add_rewrite_rule(
        '^pustaka/?$',
        'index.php?kreasi_redesign_2026_design_page=pustaka',
        'top'
    );

    add_rewrite_rule(
        '^tentang-kami/?$',
        'index.php?kreasi_redesign_2026_design_page=tentang-kami',
        'top'
    );

    add_rewrite_rule(
        '^publikasi/?$',
        'index.php?kreasi_redesign_2026_design_page=publikasi',
        'top'
    );
}
add_action('init', 'kreasi_redesign_2026_register_design_routes');

/**
 * Register custom query variable.
 */
function kreasi_redesign_2026_design_query_vars($vars)
{
    $vars[] = 'kreasi_redesign_2026_design_page';
    return $vars;
}
add_filter('query_vars', 'kreasi_redesign_2026_design_query_vars');

/**
 * Load the corresponding template.
 */
function kreasi_redesign_2026_load_design_page($template)
{
    $design_page = get_query_var('kreasi_redesign_2026_design_page');

    // Fallback untuk instalasi yang belum menyegarkan rewrite rules.
    if (!$design_page && !empty($_SERVER['REQUEST_URI'])) {
        $request_path = trim((string) wp_parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH), '/');
        $home_path    = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');

        if ($home_path && strpos($request_path, $home_path . '/') === 0) {
            $request_path = substr($request_path, strlen($home_path) + 1);
        }

        if (in_array($request_path, array('artikel', 'pustaka', 'tentang-kami', 'publikasi'), true)) {
            $design_page = $request_path;
        }
    }

    $templates = array(
        'artikel'      => 'artikel.php',
        'pustaka'      => 'page-publikasi.php',
        'tentang-kami' => 'page-tentang-kami.php',
        'publikasi'    => 'page-publikasi.php',
    );

    if (isset($templates[$design_page])) {
        $file = get_theme_file_path($templates[$design_page]);

        if (file_exists($file)) {
            global $wp_query;
            $wp_query->is_404 = false;
            status_header(200);
            return $file;
        }

        error_log(
            'kreasi_redesign_2026: Template tidak ditemukan: ' .
                $file
        );
    }

    return $template;
}
add_filter('template_include', 'kreasi_redesign_2026_load_design_page');

/**
 * 2. Registrasi WordPress Customizer untuk Upload Logo Kemitraan dari Media Library
 */
function kreasi_redesign_2026_customize_register($wp_customize)
{
    // --- Section 1: Hero Section & Slider (Homepage) ---
    $wp_customize->add_section('kreasi_redesign_2026_hero_section', array(
        'title'       => __('Hero Section & Slider (Homepage)', 'kreasi_redesign_2026'),
        'description' => __('Unggah gambar atau video (MP4/WebM) dari Media Library untuk Hero Slider.', 'kreasi_redesign_2026'),
        'priority'    => 30,
    ));

    // Fallback single hero image
    $wp_customize->add_setting('hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label'    => __('Gambar Default Hero', 'kreasi_redesign_2026'),
        'section'  => 'kreasi_redesign_2026_hero_section',
        'settings' => 'hero_image',
    )));

    // Slider Autoplay Speed
    $wp_customize->add_setting('hero_slider_interval', array(
        'default'           => '6000',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('hero_slider_interval', array(
        'label'       => __('Durasi Auto-Slide (Milidetik, contoh: 6000)', 'kreasi_redesign_2026'),
        'section'     => 'kreasi_redesign_2026_hero_section',
        'type'        => 'number',
        'input_attrs' => array('min' => 2000, 'step' => 500),
    ));

    // 4 Slot Slide Hero (Bisa Gambar atau Video MP4/WebM)
    for ($i = 1; $i <= 4; $i++) {
        // Media (Upload Control accepts both Image and Video URLs from Media Library)
        $media_setting = 'hero_slide_' . $i . '_media';
        $wp_customize->add_setting($media_setting, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, $media_setting, array(
            'label'       => sprintf(__('Slide %d: Media (Gambar / Video MP4)', 'kreasi_redesign_2026'), $i),
            'description' => __('Pilih dari Media Library (file .mp4/.webm akan otomatis diputar sebagai video background).', 'kreasi_redesign_2026'),
            'section'     => 'kreasi_redesign_2026_hero_section',
            'settings'    => $media_setting,
        )));

        // Title
        $title_setting = 'hero_slide_' . $i . '_title';
        $wp_customize->add_setting($title_setting, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($title_setting, array(
            'label'    => sprintf(__('Slide %d: Judul / Heading', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_hero_section',
            'type'     => 'textarea',
        ));

        // Link Target
        $link_setting = 'hero_slide_' . $i . '_link';
        $wp_customize->add_setting($link_setting, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control($link_setting, array(
            'label'    => sprintf(__('Slide %d: URL Link (opsional)', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_hero_section',
            'type'     => 'url',
        ));

        // Link Text
        $link_text_setting = 'hero_slide_' . $i . '_link_text';
        $wp_customize->add_setting($link_text_setting, array(
            'default'           => 'READ MORE',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($link_text_setting, array(
            'label'    => sprintf(__('Slide %d: Teks Tombol Link', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_hero_section',
            'type'     => 'text',
        ));
    }

    // --- Section 2: Logo Kemitraan (Header Top) ---
    // $wp_customize->add_section('kreasi_redesign_2026_partner_logos_section', array(
    //     'title'       => __('Logo Kemitraan (Header Top)', 'kreasi_redesign_2026'),
    //     'description' => __('Unggah dan kelola logo mitra/kemitraan langsung dari WordPress Media Library.', 'kreasi_redesign_2026'),
    //     'priority'    => 35,
    // ));

    // // 4 Slot Logo Kemitraan (Bisa diunggah dari Media Library)
    // for ($i = 1; $i <= 4; $i++) {
    //     $setting_id = 'partner_logo_' . $i;

    //     $wp_customize->add_setting($setting_id, array(
    //         'default'           => '',
    //         'sanitize_callback' => 'esc_url_raw',
    //     ));

    //     $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $setting_id, array(
    //         'label'    => sprintf(__('Logo Mitra %d (Pilih dari Media)', 'kreasi_redesign_2026'), $i),
    //         'section'  => 'kreasi_redesign_2026_partner_logos_section',
    //         'settings' => $setting_id,
    //     )));
    // }

    // --- Section: Pengaturan Menu Navigasi Header (Pilih Route Halaman / Tambah Slot) ---
    $wp_customize->add_section('kreasi_redesign_2026_nav_section', array(
        'title'       => __('Pengaturan Menu Navigasi Header', 'kreasi_redesign_2026'),
        'description' => __('Kelola tombol menu navigasi header (Tambah label, pilih Halaman WordPress, atau isi URL kustom). Isi label untuk mengaktifkan slot menu.', 'kreasi_redesign_2026'),
        'priority'    => 36,
    ));

    $default_nav_items = array(
        1 => array('title' => 'TENTANG KAMI', 'url' => '/tentang-kami'),
        2 => array('title' => 'ARTIKEL',      'url' => '/artikel'),
        3 => array('title' => 'PUSTAKA',      'url' => '/pustaka'),
        4 => array('title' => 'PUBLIKASI',     'url' => '/publikasi'),
        5 => array('title' => '',             'url' => ''),
        6 => array('title' => '',             'url' => ''),
    );

    for ($i = 1; $i <= 6; $i++) {
        // Label Tombol Menu
        $title_setting = 'nav_item_' . $i . '_title';
        $wp_customize->add_setting($title_setting, array(
            'default'           => $default_nav_items[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($title_setting, array(
            'label'       => sprintf(__('Slot %d: Label Tombol Menu', 'kreasi_redesign_2026'), $i),
            'description' => __('Isi nama tombol (kosongkan jika slot ini tidak digunakan).', 'kreasi_redesign_2026'),
            'section'     => 'kreasi_redesign_2026_nav_section',
            'type'        => 'text',
        ));

        // Pilih Halaman (Dropdown Pages)
        $page_setting = 'nav_item_' . $i . '_page';
        $wp_customize->add_setting($page_setting, array(
            'default'           => '0',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control($page_setting, array(
            'label'    => sprintf(__('Slot %d: Pilih Halaman (Page)', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_nav_section',
            'type'     => 'dropdown-pages',
        ));

        // Custom URL Input
        $url_setting = 'nav_item_' . $i . '_url';
        $wp_customize->add_setting($url_setting, array(
            'default'           => $default_nav_items[$i]['url'],
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control($url_setting, array(
            'label'       => sprintf(__('Slot %d: Atau Input URL Kustom (Opsional)', 'kreasi_redesign_2026'), $i),
            'description' => __('Contoh: /galeri atau https://...', 'kreasi_redesign_2026'),
            'section'     => 'kreasi_redesign_2026_nav_section',
            'type'        => 'text',
        ));
    }

    // // --- Section 3: Footer & Logo Save the Children ---
    // $wp_customize->add_section('kreasi_redesign_2026_footer_section', array(
    //     'title'       => __('Pengaturan Footer & Logo', 'kreasi_redesign_2026'),
    //     'description' => __('Unggah dan kelola logo Footer & Save the Children dari Media Library.', 'kreasi_redesign_2026'),
    //     'priority'    => 40,
    // ));

    // // Logo Utama Footer
    // $wp_customize->add_setting('footer_logo', array(
    //     'default'           => '',
    //     'sanitize_callback' => 'esc_url_raw',
    // ));

    // $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
    //     'label'    => __('Logo Utama Footer (Pilih dari Media Library)', 'kreasi_redesign_2026'),
    //     'section'  => 'kreasi_redesign_2026_footer_section',
    //     'settings' => 'footer_logo',
    // )));

    // // Logo Save the Children Footer
    // $wp_customize->add_setting('save_the_children_logo', array(
    //     'default'           => '',
    //     'sanitize_callback' => 'esc_url_raw',
    // ));

    // $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'save_the_children_logo', array(
    //     'label'    => __('Logo Save the Children (Pilih dari Media Library)', 'kreasi_redesign_2026'),
    //     'section'  => 'kreasi_redesign_2026_footer_section',
    //     'settings' => 'save_the_children_logo',
    // )));

    // --- Section 4: Kartu Statistik Dampak (Impact Cards) ---
    $wp_customize->add_section('kreasi_redesign_2026_impact_section', array(
        'title'       => __('Kartu Statistik', 'kreasi_redesign_2026'),
        'description' => __('Unggah gambar background dan kelola angka/teks 4 kartu statistik dari Media Library.', 'kreasi_redesign_2026'),
        'priority'    => 38,
    ));

    $default_impact_data = array(
        1 => array(
            'num'   => '50,000',
            'label' => 'Murid',
            'desc'  => 'Mendapatkan akses buku berkualitas dan ruang baca yang nyaman untuk menumbuhkan kecintaan pada literasi sejak dini.'
        ),
        2 => array(
            'num'   => '4,000',
            'label' => 'Guru',
            'desc'  => 'Mendapatkan pelatihan metode pembelajaran kreatif dan efektif untuk meningkatkan kualitas pengajaran di kelas.'
        ),
        3 => array(
            'num'   => '560',
            'label' => 'Kepala Sekolah',
            'desc'  => 'Mendapatkan pendampingan manajemen kepemimpinan sekolah dan tata kelola pendidikan yang inklusif.'
        ),
        4 => array(
            'num'   => '560',
            'label' => 'Sekolah',
            'desc'  => 'Menerima perbaikan fasilitas perpustakaan, sarana belajar, dan ruang kelas yang kondusif untuk siswa.'
        ),
    );

    for ($i = 1; $i <= 4; $i++) {
        // Gambar Kartu
        $img_setting = 'impact_card_' . $i . '_image';
        $wp_customize->add_setting($img_setting, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $img_setting, array(
            'label'    => sprintf(__('Kartu %d: Gambar Background (Media Library)', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_impact_section',
            'settings' => $img_setting,
        )));

        // Angka Statistik
        $num_setting = 'impact_card_' . $i . '_number';
        $wp_customize->add_setting($num_setting, array(
            'default'           => $default_impact_data[$i]['num'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($num_setting, array(
            'label'    => sprintf(__('Kartu %d: Angka / Jumlah', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_impact_section',
            'type'     => 'text',
        ));

        // Label Teks
        $lbl_setting = 'impact_card_' . $i . '_label';
        $wp_customize->add_setting($lbl_setting, array(
            'default'           => $default_impact_data[$i]['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($lbl_setting, array(
            'label'    => sprintf(__('Kartu %d: Label Keterangan', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_impact_section',
            'type'     => 'text',
        ));

        // Deskripsi Hover Box
        $desc_setting = 'impact_card_' . $i . '_desc';
        $wp_customize->add_setting($desc_setting, array(
            'default'           => $default_impact_data[$i]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control($desc_setting, array(
            'label'    => sprintf(__('Kartu %d: Teks Deskripsi Hover (Kotak Biru)', 'kreasi_redesign_2026'), $i),
            'section'  => 'kreasi_redesign_2026_impact_section',
            'type'     => 'textarea',
        ));
    }

    // --- Section 5: Area Intervensi & Mitra Pelaksana ---
    $wp_customize->add_section('kreasi_redesign_2026_event_section', array(
        'title'       => __('Event', 'kreasi_redesign_2026'),
        'description' => __('Kelola judul dan unggah gambar event.', 'kreasi_redesign_2026'),
        'priority'    => 39,
    ));

    // Judul Section
    // $wp_customize->add_setting('event_section_title', array(
    //     'default'           => 'AREA INTERVENSI & MITRA PELAKSANA',
    //     'sanitize_callback' => 'sanitize_text_field',
    // ));
    // $wp_customize->add_control('event_section_title', array(
    //     'label'    => __('Judul Section', 'kreasi_redesign_2026'),
    //     'section'  => 'kreasi_redesign_2026_event_section',
    //     'type'     => 'text',
    // ));

    
    /**
     * Gambar Event - Desktop
     */
    $wp_customize->add_setting('event_section_image_desktop', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'event_section_image_desktop',
            array(
                'label'       => __('Gambar Event - Desktop', 'kreasi_redesign_2026'),
                'description' => __('Upload gambar landscape untuk tampilan desktop.', 'kreasi_redesign_2026'),
                'section'     => 'kreasi_redesign_2026_event_section',
                'settings'    => 'event_section_image_desktop',
            )
        )
    );


    /**
     * Gambar Event - Mobile
     */
    $wp_customize->add_setting('event_section_image_mobile', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'event_section_image_mobile',
            array(
                'label'       => __('Gambar Event - Mobile', 'kreasi_redesign_2026'),
                'description' => __('Upload gambar portrait untuk tampilan mobile.', 'kreasi_redesign_2026'),
                'section'     => 'kreasi_redesign_2026_event_section',
                'settings'    => 'event_section_image_mobile',
            )
        )
    );

}
add_action('customize_register', 'kreasi_redesign_2026_customize_register');

/**
 * Helper Function: Render Logo Kemitraan (Customizer Media / Widget / Fallback)
 */
// function kreasi_redesign_2026_render_partner_logos($is_mobile = false) {
//     $class = $is_mobile ? 'partner-logo-mobile-img' : 'partner-logo-img';

//     $logo1 = get_theme_mod('partner_logo_1', '');
//     $logo2 = get_theme_mod('partner_logo_2', '');
//     $logo3 = get_theme_mod('partner_logo_3', '');
//     $logo4 = get_theme_mod('partner_logo_4', '');

//     $has_custom_partner_logos = ($logo1 || $logo2 || $logo3 || $logo4);

//     if ($has_custom_partner_logos) {
//         if ($logo1) echo '<img src="' . esc_url($logo1) . '" alt="Mitra 1" class="' . esc_attr($class) . '">';
//         if ($logo2) echo '<img src="' . esc_url($logo2) . '" alt="Mitra 2" class="' . esc_attr($class) . '">';
//         if ($logo3) echo '<img src="' . esc_url($logo3) . '" alt="Mitra 3" class="' . esc_attr($class) . '">';
//         if ($logo4) echo '<img src="' . esc_url($logo4) . '" alt="Mitra 4" class="' . esc_attr($class) . '">';
//     } elseif (is_active_sidebar('partner-logos-sidebar')) {
//         dynamic_sidebar('partner-logos-sidebar');
//     } else {
//         $stc_logo = get_theme_mod('save_the_children_logo', '');
//         $stc_fallback = $stc_logo ? $stc_logo : get_template_directory_uri() . '/assets/images/logo-save-the-children.png';
//         // Fallback default gambar jika belum diupload
//         echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-1.png') . '" alt="Kemendikdasmen" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
//         echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-2.png') . '" alt="Kemenag" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
//         echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-3.png') . '" alt="GPE" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
//     }
// }

function kreasi_redesign_2026_render_partner_logos($is_mobile = false) {

    $class = $is_mobile
        ? 'partner-logo-mobile-img'
        : 'partner-logo-img';

    $theme_uri = get_template_directory_uri();
    $logos = [
        [
            'src' => $theme_uri . '/assets/images/logo-kemendikdasmen.png',
            'alt' => 'Kemendikdasmen',
        ],
        [
            'src' => $theme_uri . '/assets/images/logo-kemenag.png',
            'alt' => 'Kemenag',
        ],
        [
            'src' => $theme_uri . '/assets/images/logo-gpe.png',
            'alt' => 'GPE',
        ],
        [
            'src' => $theme_uri . '/assets/images/logo-save-the-children.png',
            'alt' => 'Save the Children',
        ],
    ];

    foreach ($logos as $logo) {
        echo '<img src="' . esc_url($logo['src']) . '"'
            . ' alt="' . esc_attr($logo['alt']) . '"'
            . ' class="' . esc_attr($class) . '">';
    }
}


/**
 * Helper Function: Render Nav Menu Buttons (Customizer Page Selector / Route URLs)
 */
function kreasi_redesign_2026_render_default_nav_menu()
{
    $default_items = array(
        1 => array('title' => 'TENTANG KAMI', 'slug' => '/tentang-kami'),
        2 => array('title' => 'ARTIKEL',      'slug' => '/artikel'),
        3 => array('title' => 'PUSTAKA',      'slug' => '/pustaka'),
        4 => array('title' => 'PUBLIKASI',     'slug' => '/publikasi'),
        5 => array('title' => '',             'slug' => ''),
        6 => array('title' => '',             'slug' => ''),
    );

    echo '<ul class="d-flex flex-wrap align-items-center m-0 p-0 gap-2 list-unstyled">';

    for ($i = 1; $i <= 6; $i++) {
        $default_title = isset($default_items[$i]) ? $default_items[$i]['title'] : '';
        $default_slug  = isset($default_items[$i]) ? $default_items[$i]['slug'] : '';

        $title      = get_theme_mod('nav_item_' . $i . '_title', $default_title);
        $page_id    = get_theme_mod('nav_item_' . $i . '_page', 0);
        $custom_url = get_theme_mod('nav_item_' . $i . '_url', '');

        // If title is empty, skip rendering this slot
        if (empty(trim($title))) {
            continue;
        }

        // Determine link URL
        if ($page_id) {
            $url = get_permalink($page_id);
        } elseif (!empty($custom_url)) {
            $url = $custom_url;
        } elseif (!empty($default_slug)) {
            $url = home_url($default_slug);
        } else {
            $url = '#';
        }

        // Determine active state (tidak ada yang aktif saat di front page)
        $is_active = false;
        if (!is_front_page()) {
            if ($page_id && is_page($page_id)) {
                $is_active = true;
            } elseif ($i === 1 && (is_page('tentang-kami') || is_page_template('page-tentang-kami.php'))) {
                $is_active = true;
            } elseif ($i === 2 && (is_home() || is_singular('post') || is_category() || is_tag() || is_page('artikel'))) {
                $is_active = true;
            } elseif ($i === 3 && (is_page('pustaka') || is_page_template('page-pustaka.php'))) {
                $is_active = true;
            } elseif ($i === 4 && (is_page('publikasi') || is_page_template('page-publikasi.php'))) {
                $is_active = true;
            }
        }

        $cls = $is_active ? 'current-menu-item active' : '';
        echo '<li class="' . esc_attr($cls) . '"><a href="' . esc_url($url) . '" class="' . ($is_active ? 'active' : '') . '">' . esc_html($title) . '</a></li>';
    }

    echo '</ul>';
}

/**
 * Helper Function: Cek apakah URL media adalah file video (MP4, WebM, MOV, dll)
 */
function kreasi_redesign_2026_is_video_url($url)
{
    if (empty($url)) return false;
    $path = parse_url($url, PHP_URL_PATH);
    if (!$path) return false;
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    return in_array($ext, array('mp4', 'webm', 'ogg', 'mov', 'm4v'), true);
}

/**
 * 3. Registrasi Dynamic Sidebars / Widget Areas
 */
function kreasi_redesign_2026_widgets_init()
{
    // Area Logo Mitra di Atas Header
    register_sidebar(array(
        'name'          => __('Logo Kemitraan (Header Top)', 'kreasi_redesign_2026'),
        'id'            => 'partner-logos-sidebar',
        'description'   => __('Tambahkan widget gambar/logo mitra di bagian atas header.', 'kreasi_redesign_2026'),
        'before_widget' => '<div class="partner-logo-item d-inline-block">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="d-none">',
        'after_title'   => '</span>',
    ));

    // Footer Kolom 1 (Branding & Pengelola)
    register_sidebar(array(
        'name'          => __('Footer Kolom 1 (Branding)', 'kreasi_redesign_2026'),
        'id'            => 'footer-col-1',
        'description'   => __('Widget area untuk logo utama dan logo pengelola.', 'kreasi_redesign_2026'),
        'before_widget' => '<div class="footer-widget footer-widget-1 mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="footer-widget-title fw-bold mb-3">',
        'after_title'   => '</h5>',
    ));

    // Footer Kolom 2 (Kontak & Media Sosial)
    register_sidebar(array(
        'name'          => __('Footer Kolom 2 (Kontak & Sosmed)', 'kreasi_redesign_2026'),
        'id'            => 'footer-col-2',
        'description'   => __('Widget area untuk informasi kontak, alamat, dan link media sosial.', 'kreasi_redesign_2026'),
        'before_widget' => '<div class="footer-widget footer-widget-2 mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="footer-widget-title fw-bold mb-3">',
        'after_title'   => '</h5>',
    ));

    // Footer Kolom 3 (Form Newsletter & Laporan)
    register_sidebar(array(
        'name'          => __('Footer Kolom 3 (Interaktif / Card)', 'kreasi_redesign_2026'),
        'id'            => 'footer-col-3',
        'description'   => __('Widget area untuk newsletter dan tombol aksi/laporan.', 'kreasi_redesign_2026'),
        'before_widget' => '<div class="footer-widget footer-widget-3 mb-3">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="footer-widget-title fw-bold mb-3">',
        'after_title'   => '</h5>',
    ));
}
add_action('widgets_init', 'kreasi_redesign_2026_widgets_init');

/**
 * 4. Enqueue Stylesheets & Scripts (Bootstrap 5 CDN, Bootstrap Icons, & Theme Style)
 */
function kreasi_redesign_2026_enqueue_scripts()
{
    // Bootstrap 5 CSS CDN
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Bootstrap Icons CDN
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        array(),
        '1.11.3'
    );

    wp_enqueue_style(
        'kreasi_redesign_2026-google-fonts',
        'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700&family=Oswald:wght@400;500;600;700&display=swap',
        array(),
        null
    );



    // Main Theme Stylesheet (style.css)
    wp_enqueue_style(
        'kreasi_redesign_2026-style',
        get_stylesheet_uri(),
        array('bootstrap-css', 'bootstrap-icons'),
        wp_get_theme()->get('Version')
    );

    // Bootstrap 5 JS Bundle CDN
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );
}
add_action('wp_enqueue_scripts', 'kreasi_redesign_2026_enqueue_scripts');

/**
 * Menambah jumlah view artikel satu kali per browser setiap 24 jam.
 */
function kreasi_redesign_2026_track_post_views()
{
    if (
        is_admin() ||
        wp_doing_ajax() ||
        !is_singular('post') ||
        is_preview()
    ) {
        return;
    }

    $post_id    = get_queried_object_id();
    $cookie_key = 'kreasi_redesign_2026_viewed_post_' . $post_id;

    // Jangan menghitung refresh berulang dari browser yang sama selama 24 jam.
    if (isset($_COOKIE[$cookie_key])) {
        return;
    }

    $views = (int) get_post_meta($post_id, 'kreasi_redesign_2026_post_views', true);
    update_post_meta($post_id, 'kreasi_redesign_2026_post_views', $views + 1);

    setcookie(
        $cookie_key,
        '1',
        array(
            'expires'  => time() + DAY_IN_SECONDS,
            'path'     => COOKIEPATH ? COOKIEPATH : '/',
            'domain'   => COOKIE_DOMAIN,
            'secure'   => is_ssl(),
            'httponly' => true,
            'samesite' => 'Lax',
        )
    );
}
add_action('template_redirect', 'kreasi_redesign_2026_track_post_views');

/**
 * =========================================================================
 * HELPER KATEGORI, TAG DAERAH, DAN NAVIGASI AKTIF UNTUK KREASI
 * =========================================================================
 */

/**
 * 1. Ambil semua ID kategori di bawah parent 'artikel' (termasuk parent itu sendiri).
 */
function kreasi_get_artikel_category_ids()
{
    $parent = get_category_by_slug('artikel');
    if (!$parent) {
        $parent = get_term_by('name', 'Artikel', 'category');
    }

    if ($parent && !is_wp_error($parent)) {
        $children = get_term_children($parent->term_id, 'category');
        if (!is_wp_error($children) && !empty($children)) {
            return array_merge(array($parent->term_id), $children);
        }
        return array($parent->term_id);
    }

    return array();
}

/**
 * 2. Ambil semua ID kategori di bawah parent 'publikasi' (termasuk parent itu sendiri).
 */
function kreasi_get_publikasi_category_ids()
{
    $parent = get_category_by_slug('publikasi');
    if (!$parent) {
        $parent = get_term_by('name', 'Publikasi', 'category');
    }

    if ($parent && !is_wp_error($parent)) {
        $children = get_term_children($parent->term_id, 'category');
        if (!is_wp_error($children) && !empty($children)) {
            return array_merge(array($parent->term_id), $children);
        }
        return array($parent->term_id);
    }

    return array();
}

/**
 * 3. Ambil daftar child categories di bawah 'artikel' untuk ditampilkan pada filter tab.
 */
function kreasi_get_artikel_child_categories()
{
    $parent = get_category_by_slug('artikel');
    if (!$parent) {
        $parent = get_term_by('name', 'Artikel', 'category');
    }

    if ($parent && !is_wp_error($parent)) {
        $terms = get_terms(array(
            'taxonomy'   => 'category',
            'parent'     => $parent->term_id,
            'hide_empty' => false,
        ));
        if (!is_wp_error($terms) && !empty($terms)) {
            return $terms;
        }
    }

    // Fallback jika belum ada child categories di database
    return array(
        (object) array('term_id' => 0, 'name' => 'Cerita', 'slug' => 'cerita'),
        (object) array('term_id' => 0, 'name' => 'Berita', 'slug' => 'berita'),
        (object) array('term_id' => 0, 'name' => 'Liputan Media', 'slug' => 'liputan-media'),
    );
}

/**
 * 4. Ambil kategori CHILD untuk kartu artikel / single post.
 * Jangan pernah menampilkan parent 'Artikel' atau 'Publikasi'. Tampilkan child seperti 'Cerita' / 'Berita'.
 */
function kreasi_get_post_child_category($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $categories = get_the_category($post_id);
    if (!empty($categories)) {
        // Cari category yang memiliki parent != 0
        foreach ($categories as $cat) {
            if ($cat->parent != 0) {
                return $cat;
            }
        }
        // Jika tidak ada subkategori, cari yang namanya bukan 'artikel' atau 'publikasi'
        foreach ($categories as $cat) {
            if ($cat->slug !== 'artikel' && $cat->slug !== 'publikasi' && strtolower($cat->name) !== 'artikel' && strtolower($cat->name) !== 'publikasi') {
                return $cat;
            }
        }
    }

    return (object) array(
        'name'    => 'Cerita',
        'slug'    => 'cerita',
        'term_id' => 0,
    );
}

/**
 * 5. Ambil tag daerah / region untuk kartu artikel / single post.
 */
function kreasi_get_post_region_tag($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $tags = get_the_tags($post_id);
    if (!empty($tags)) {
        return $tags[0];
    }

    return (object) array(
        'name'    => 'Kayong Utara',
        'slug'    => 'kayong-utara',
        'term_id' => 0,
    );
}

/**
 * 6. Daftar 8 Kabupaten Wilayah Intervensi KREASI + Nasional beserta jumlah post artikelnya.
 */
function kreasi_get_region_tags_with_counts()
{
    $regions = array(
        'nasional'         => 'Nasional',
        'nias-utara'       => 'Nias Utara',
        'nias-selatan'     => 'Nias Selatan',
        'tanggamus'        => 'Tanggamus',
        'pesisir-barat'    => 'Pesisir Barat',
        'ketapang'         => 'Ketapang',
        'kayong-utara'     => 'Kayong Utara',
        'halmahera-utara'  => 'Halmahera Utara',
        'pulau-morotai'    => 'Pulau Morotai',
    );

    $artikel_cat_ids = kreasi_get_artikel_category_ids();
    $publikasi_cat_ids = kreasi_get_publikasi_category_ids();

    $result = array();
    foreach ($regions as $slug => $label) {
        $tag = get_term_by('slug', $slug, 'post_tag');
        if (!$tag) {
            $tag = get_term_by('name', $label, 'post_tag');
        }

        $count = 0;
        if ($tag && !is_wp_error($tag)) {
            $args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'fields'         => 'ids',
                'tag_id'         => $tag->term_id,
            );
            if (!empty($artikel_cat_ids)) {
                $args['category__in'] = $artikel_cat_ids;
            }
            if (!empty($publikasi_cat_ids)) {
                $args['category__not_in'] = $publikasi_cat_ids;
            }
            $query = new WP_Query($args);
            $count = (int) $query->found_posts;
        }

        // Jika count 0 saat belum ada postingan, tampilkan 24 seperti pada mockup Figma
        $display_count = ($count > 0) ? $count : 24;

        $result[] = (object) array(
            'slug'  => $slug,
            'name'  => $label,
            'count' => $display_count,
        );
    }

    return $result;
}

/**
 * 7. Helper: Deteksi menu navbar yang sedang aktif.
 */
function kreasi_get_active_nav_item()
{
    // Jika berada di Halaman Utama (Front Page), tidak ada navbar yang aktif
    if (is_front_page()) {
        return '';
    }

    $request_uri = trim((string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $home_path   = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');
    if ($home_path && strpos($request_uri, $home_path . '/') === 0) {
        $request_uri = substr($request_uri, strlen($home_path) + 1);
    } elseif ($home_path && $request_uri === $home_path) {
        $request_uri = '';
    }

    // Jika URI kosong, berarti berada di root front-page
    if (empty($request_uri)) {
        return '';
    }

    $design_page = get_query_var('kreasi_redesign_2026_design_page');

    if (
        is_page('tentang-kami') ||
        is_page_template('page-tentang-kami.php') ||
        $request_uri === 'tentang-kami' ||
        $design_page === 'tentang-kami'
    ) {
        return 'tentang-kami';
    }

    if (
        is_page(array('pustaka', 'publikasi')) ||
        is_page_template(array('page-pustaka.php', 'page-publikasi.php')) ||
        in_array($request_uri, array('pustaka', 'publikasi'), true) ||
        in_array($design_page, array('pustaka', 'publikasi'), true)
    ) {
        return 'pustaka';
    }

    if (is_singular('post')) {
        $cats = get_the_category();
        $pub_cat_ids = kreasi_get_publikasi_category_ids();
        if (!empty($cats) && !empty($pub_cat_ids)) {
            foreach ($cats as $cat) {
                if (in_array($cat->term_id, $pub_cat_ids, true) || in_array($cat->parent, $pub_cat_ids, true)) {
                    return 'pustaka';
                }
            }
        }
        return 'artikel';
    }

    if (
        is_page('artikel') ||
        $request_uri === 'artikel' ||
        $design_page === 'artikel' ||
        (!is_front_page() && is_home()) ||
        is_category() ||
        is_tag()
    ) {
        return 'artikel';
    }

    return '';
}

