<?php
/**
 * Functions and definitions for customtheme
 *
 * @package customtheme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * 1. Setup Theme Features & Supports
 */
function customtheme_setup_features() {
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
        'primary' => __('Primary Menu', 'customtheme'),
    ));
}


add_action('after_setup_theme', 'customtheme_setup_features');

/**
 * Route URL statis langsung ke file desain theme.HARDCODE
 */
function customtheme_register_design_routes()
{
    add_rewrite_rule(
        '^artikel/?$',
        'index.php?customtheme_design_page=artikel',
        'top'
    );

    add_rewrite_rule(
        '^pustaka/?$',
        'index.php?customtheme_design_page=pustaka',
        'top'
    );

    add_rewrite_rule(
        '^tentang-kami/?$',
        'index.php?customtheme_design_page=tentang-kami',
        'top'
    );
}
add_action('init', 'customtheme_register_design_routes');

function customtheme_design_query_vars($vars)
{
    $vars[] = 'customtheme_design_page';
    return $vars;
}
add_filter('query_vars', 'customtheme_design_query_vars');

function customtheme_load_design_page($template)
{
    $design_page = get_query_var('customtheme_design_page');

    $templates = array(
        'artikel'      => 'page-artikel.php',
        'pustaka'      => 'page-pustaka.php',
        'tentang-kami' => 'front-page.php',
    );

    if (isset($templates[$design_page])) {
        $file = get_template_directory() . '/' . $templates[$design_page];

        if (file_exists($file)) {
            return $file;
        }
    }

    return $template;
}
add_filter('template_include', 'customtheme_load_design_page');

/**
 * 2. Registrasi WordPress Customizer untuk Upload Logo Kemitraan dari Media Library
 */
function customtheme_customize_register($wp_customize) {
    // --- Section 1: Hero Section & Slider (Homepage) ---
    $wp_customize->add_section('customtheme_hero_section', array(
        'title'       => __('Hero Section & Slider (Homepage)', 'customtheme'),
        'description' => __('Unggah gambar atau video (MP4/WebM) dari Media Library untuk Hero Slider.', 'customtheme'),
        'priority'    => 30,
    ));

    // Fallback single hero image
    $wp_customize->add_setting('hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label'    => __('Gambar Default Hero (Fallback)', 'customtheme'),
        'section'  => 'customtheme_hero_section',
        'settings' => 'hero_image',
    )));

    // Slider Autoplay Speed
    $wp_customize->add_setting('hero_slider_interval', array(
        'default'           => '6000',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('hero_slider_interval', array(
        'label'       => __('Durasi Auto-Slide (Milidetik, contoh: 6000)', 'customtheme'),
        'section'     => 'customtheme_hero_section',
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
            'label'       => sprintf(__('Slide %d: Media (Gambar / Video MP4)', 'customtheme'), $i),
            'description' => __('Pilih dari Media Library (file .mp4/.webm akan otomatis diputar sebagai video background).', 'customtheme'),
            'section'     => 'customtheme_hero_section',
            'settings'    => $media_setting,
        )));

        // Title
        $title_setting = 'hero_slide_' . $i . '_title';
        $wp_customize->add_setting($title_setting, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($title_setting, array(
            'label'    => sprintf(__('Slide %d: Judul / Heading', 'customtheme'), $i),
            'section'  => 'customtheme_hero_section',
            'type'     => 'textarea',
        ));

        // Link Target
        $link_setting = 'hero_slide_' . $i . '_link';
        $wp_customize->add_setting($link_setting, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control($link_setting, array(
            'label'    => sprintf(__('Slide %d: URL Link (opsional)', 'customtheme'), $i),
            'section'  => 'customtheme_hero_section',
            'type'     => 'url',
        ));

        // Link Text
        $link_text_setting = 'hero_slide_' . $i . '_link_text';
        $wp_customize->add_setting($link_text_setting, array(
            'default'           => 'READ MORE',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($link_text_setting, array(
            'label'    => sprintf(__('Slide %d: Teks Tombol Link', 'customtheme'), $i),
            'section'  => 'customtheme_hero_section',
            'type'     => 'text',
        ));
    }

    // --- Section 2: Logo Kemitraan (Header Top) ---
    $wp_customize->add_section('customtheme_partner_logos_section', array(
        'title'       => __('Logo Kemitraan (Header Top)', 'customtheme'),
        'description' => __('Unggah dan kelola logo mitra/kemitraan langsung dari WordPress Media Library.', 'customtheme'),
        'priority'    => 35,
    ));

    // 4 Slot Logo Kemitraan (Bisa diunggah dari Media Library)
    for ($i = 1; $i <= 4; $i++) {
        $setting_id = 'partner_logo_' . $i;

        $wp_customize->add_setting($setting_id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $setting_id, array(
            'label'    => sprintf(__('Logo Mitra %d (Pilih dari Media)', 'customtheme'), $i),
            'section'  => 'customtheme_partner_logos_section',
            'settings' => $setting_id,
        )));
    }

    // --- Section: Pengaturan Menu Navigasi Header (Pilih Route Halaman / Tambah Slot) ---
    $wp_customize->add_section('customtheme_nav_section', array(
        'title'       => __('Pengaturan Menu Navigasi Header', 'customtheme'),
        'description' => __('Kelola tombol menu navigasi header (Tambah label, pilih Halaman WordPress, atau isi URL kustom). Isi label untuk mengaktifkan slot menu.', 'customtheme'),
        'priority'    => 36,
    ));

    $default_nav_items = array(
        1 => array('title' => 'TENTANG KAMI', 'url' => '/tentang-kami'),
        2 => array('title' => 'ARTIKEL',      'url' => '/artikel'),
        3 => array('title' => 'PUSTAKA',      'url' => '/pustaka'),
        4 => array('title' => '',             'url' => ''),
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
            'label'       => sprintf(__('Slot %d: Label Tombol Menu', 'customtheme'), $i),
            'description' => __('Isi nama tombol (kosongkan jika slot ini tidak digunakan).', 'customtheme'),
            'section'     => 'customtheme_nav_section',
            'type'        => 'text',
        ));

        // Pilih Halaman (Dropdown Pages)
        $page_setting = 'nav_item_' . $i . '_page';
        $wp_customize->add_setting($page_setting, array(
            'default'           => '0',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control($page_setting, array(
            'label'    => sprintf(__('Slot %d: Pilih Halaman (Page)', 'customtheme'), $i),
            'section'  => 'customtheme_nav_section',
            'type'     => 'dropdown-pages',
        ));

        // Custom URL Input
        $url_setting = 'nav_item_' . $i . '_url';
        $wp_customize->add_setting($url_setting, array(
            'default'           => $default_nav_items[$i]['url'],
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control($url_setting, array(
            'label'       => sprintf(__('Slot %d: Atau Input URL Kustom (Opsional)', 'customtheme'), $i),
            'description' => __('Contoh: /galeri atau https://...', 'customtheme'),
            'section'     => 'customtheme_nav_section',
            'type'        => 'text',
        ));
    }

    // --- Section 3: Footer & Logo Save the Children ---
    $wp_customize->add_section('customtheme_footer_section', array(
        'title'       => __('Pengaturan Footer & Logo', 'customtheme'),
        'description' => __('Unggah dan kelola logo Footer & Save the Children dari Media Library.', 'customtheme'),
        'priority'    => 40,
    ));

    // Logo Utama Footer
    $wp_customize->add_setting('footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
        'label'    => __('Logo Utama Footer (Pilih dari Media Library)', 'customtheme'),
        'section'  => 'customtheme_footer_section',
        'settings' => 'footer_logo',
    )));

    // Logo Save the Children Footer
    $wp_customize->add_setting('save_the_children_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'save_the_children_logo', array(
        'label'    => __('Logo Save the Children (Pilih dari Media Library)', 'customtheme'),
        'section'  => 'customtheme_footer_section',
        'settings' => 'save_the_children_logo',
    )));

    // --- Section 4: Kartu Statistik Dampak (Impact Cards) ---
    $wp_customize->add_section('customtheme_impact_section', array(
        'title'       => __('Kartu Statistik (Membawa Perubahan)', 'customtheme'),
        'description' => __('Unggah gambar background dan kelola angka/teks 4 kartu statistik dari Media Library.', 'customtheme'),
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
            'label'    => sprintf(__('Kartu %d: Gambar Background (Media Library)', 'customtheme'), $i),
            'section'  => 'customtheme_impact_section',
            'settings' => $img_setting,
        )));

        // Angka Statistik
        $num_setting = 'impact_card_' . $i . '_number';
        $wp_customize->add_setting($num_setting, array(
            'default'           => $default_impact_data[$i]['num'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($num_setting, array(
            'label'    => sprintf(__('Kartu %d: Angka / Jumlah', 'customtheme'), $i),
            'section'  => 'customtheme_impact_section',
            'type'     => 'text',
        ));

        // Label Teks
        $lbl_setting = 'impact_card_' . $i . '_label';
        $wp_customize->add_setting($lbl_setting, array(
            'default'           => $default_impact_data[$i]['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($lbl_setting, array(
            'label'    => sprintf(__('Kartu %d: Label Keterangan', 'customtheme'), $i),
            'section'  => 'customtheme_impact_section',
            'type'     => 'text',
        ));

        // Deskripsi Hover Box
        $desc_setting = 'impact_card_' . $i . '_desc';
        $wp_customize->add_setting($desc_setting, array(
            'default'           => $default_impact_data[$i]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control($desc_setting, array(
            'label'    => sprintf(__('Kartu %d: Teks Deskripsi Hover (Kotak Biru)', 'customtheme'), $i),
            'section'  => 'customtheme_impact_section',
            'type'     => 'textarea',
        ));
    }

    // --- Section 5: Area Intervensi & Mitra Pelaksana ---
    $wp_customize->add_section('customtheme_map_section', array(
        'title'       => __('Area Intervensi & Peta Mitra', 'customtheme'),
        'description' => __('Kelola judul dan unggah gambar peta area intervensi & mitra pelaksana dari Media Library.', 'customtheme'),
        'priority'    => 39,
    ));

    // Judul Section
    $wp_customize->add_setting('map_section_title', array(
        'default'           => 'AREA INTERVENSI & MITRA PELAKSANA',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('map_section_title', array(
        'label'    => __('Judul Section', 'customtheme'),
        'section'  => 'customtheme_map_section',
        'type'     => 'text',
    ));

    // Gambar Peta Intervensi
    $wp_customize->add_setting('map_section_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'map_section_image', array(
        'label'       => __('Gambar Peta Intervensi (Pilih dari Media Library)', 'customtheme'),
        'description' => __('Unggah grafis peta Indonesia & logo mitra pelaksana.', 'customtheme'),
        'section'     => 'customtheme_map_section',
        'settings'    => 'map_section_image',
    )));
}
add_action('customize_register', 'customtheme_customize_register');

/**
 * Helper Function: Render Logo Kemitraan (Customizer Media / Widget / Fallback)
 */
function customtheme_render_partner_logos($is_mobile = false) {
    $class = $is_mobile ? 'partner-logo-mobile-img' : 'partner-logo-img';

    $logo1 = get_theme_mod('partner_logo_1', '');
    $logo2 = get_theme_mod('partner_logo_2', '');
    $logo3 = get_theme_mod('partner_logo_3', '');
    $logo4 = get_theme_mod('partner_logo_4', '');

    $has_custom_partner_logos = ($logo1 || $logo2 || $logo3 || $logo4);

    if ($has_custom_partner_logos) {
        if ($logo1) echo '<img src="' . esc_url($logo1) . '" alt="Mitra 1" class="' . esc_attr($class) . '">';
        if ($logo2) echo '<img src="' . esc_url($logo2) . '" alt="Mitra 2" class="' . esc_attr($class) . '">';
        if ($logo3) echo '<img src="' . esc_url($logo3) . '" alt="Mitra 3" class="' . esc_attr($class) . '">';
        if ($logo4) echo '<img src="' . esc_url($logo4) . '" alt="Mitra 4" class="' . esc_attr($class) . '">';
    } elseif (is_active_sidebar('partner-logos-sidebar')) {
        dynamic_sidebar('partner-logos-sidebar');
    } else {
        $stc_logo = get_theme_mod('save_the_children_logo', '');
        $stc_fallback = $stc_logo ? $stc_logo : get_template_directory_uri() . '/assets/images/logo-save-the-children.png';
        // Fallback default gambar jika belum diupload
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-1.png') . '" alt="Kemendikdasmen" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-2.png') . '" alt="Kemenag" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-3.png') . '" alt="GPE" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
    }
}

/**
 * Helper Function: Render Nav Menu Buttons (Customizer Page Selector / Route URLs)
 */
function customtheme_render_default_nav_menu() {
    $default_items = array(
        1 => array('title' => 'TENTANG KAMI', 'slug' => '/tentang-kami'),
        2 => array('title' => 'ARTIKEL',      'slug' => '/artikel'),
        3 => array('title' => 'PUSTAKA',      'slug' => '/pustaka'),
        4 => array('title' => '',             'slug' => ''),
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

        // Determine active state
        $is_active = false;
        if ($page_id && is_page($page_id)) {
            $is_active = true;
        } elseif ($i === 1 && (is_page('tentang-kami') || is_page_template('page-tentang-kami.php'))) {
            $is_active = true;
        } elseif ($i === 2 && (is_home() || is_singular('post') || is_category() || is_tag() || is_page('artikel'))) {
            $is_active = true;
        } elseif ($i === 3 && (is_page('pustaka') || is_page_template('page-pustaka.php'))) {
            $is_active = true;
        }

        $cls = $is_active ? 'current-menu-item active' : '';
        echo '<li class="' . esc_attr($cls) . '"><a href="' . esc_url($url) . '" class="' . ($is_active ? 'active' : '') . '">' . esc_html($title) . '</a></li>';
    }
    
    echo '</ul>';
}

/**
 * Helper Function: Cek apakah URL media adalah file video (MP4, WebM, MOV, dll)
 */
function customtheme_is_video_url($url) {
    if (empty($url)) return false;
    $path = parse_url($url, PHP_URL_PATH);
    if (!$path) return false;
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    return in_array($ext, array('mp4', 'webm', 'ogg', 'mov', 'm4v'), true);
}

/**
 * 3. Registrasi Dynamic Sidebars / Widget Areas
 */
function customtheme_widgets_init() {
    // Area Logo Mitra di Atas Header
    register_sidebar(array(
        'name'          => __('Logo Kemitraan (Header Top)', 'customtheme'),
        'id'            => 'partner-logos-sidebar',
        'description'   => __('Tambahkan widget gambar/logo mitra di bagian atas header.', 'customtheme'),
        'before_widget' => '<div class="partner-logo-item d-inline-block">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="d-none">',
        'after_title'   => '</span>',
    ));

    // Footer Kolom 1 (Branding & Pengelola)
    register_sidebar(array(
        'name'          => __('Footer Kolom 1 (Branding)', 'customtheme'),
        'id'            => 'footer-col-1',
        'description'   => __('Widget area untuk logo utama dan logo pengelola.', 'customtheme'),
        'before_widget' => '<div class="footer-widget footer-widget-1 mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="footer-widget-title fw-bold mb-3">',
        'after_title'   => '</h5>',
    ));

    // Footer Kolom 2 (Kontak & Media Sosial)
    register_sidebar(array(
        'name'          => __('Footer Kolom 2 (Kontak & Sosmed)', 'customtheme'),
        'id'            => 'footer-col-2',
        'description'   => __('Widget area untuk informasi kontak, alamat, dan link media sosial.', 'customtheme'),
        'before_widget' => '<div class="footer-widget footer-widget-2 mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="footer-widget-title fw-bold mb-3">',
        'after_title'   => '</h5>',
    ));

    // Footer Kolom 3 (Form Newsletter & Laporan)
    register_sidebar(array(
        'name'          => __('Footer Kolom 3 (Interaktif / Card)', 'customtheme'),
        'id'            => 'footer-col-3',
        'description'   => __('Widget area untuk newsletter dan tombol aksi/laporan.', 'customtheme'),
        'before_widget' => '<div class="footer-widget footer-widget-3 mb-3">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="footer-widget-title fw-bold mb-3">',
        'after_title'   => '</h5>',
    ));
}
add_action('widgets_init', 'customtheme_widgets_init');

/**
 * 4. Enqueue Stylesheets & Scripts (Bootstrap 5 CDN, Bootstrap Icons, & Theme Style)
 */
function customtheme_enqueue_scripts() {
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

    // Main Theme Stylesheet (style.css)
    wp_enqueue_style(
        'customtheme-style',
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
add_action('wp_enqueue_scripts', 'customtheme_enqueue_scripts');

/**
 * Menambah jumlah view artikel satu kali per browser setiap 24 jam.
 */
function customtheme_track_post_views()
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
    $cookie_key = 'customtheme_viewed_post_' . $post_id;

    // Jangan menghitung refresh berulang dari browser yang sama selama 24 jam.
    if (isset($_COOKIE[$cookie_key])) {
        return;
    }

    $views = (int) get_post_meta($post_id, 'customtheme_post_views', true);
    update_post_meta($post_id, 'customtheme_post_views', $views + 1);

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
add_action('template_redirect', 'customtheme_track_post_views');
