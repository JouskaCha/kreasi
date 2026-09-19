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

    // --- Section: Pengaturan Menu Navigasi Header (Pilih Route Halaman) ---
    $wp_customize->add_section('customtheme_nav_section', array(
        'title'       => __('Pengaturan Menu Navigasi Header', 'customtheme'),
        'description' => __('Pilih halaman tujuan untuk tombol menu navigasi header (Tentang Kami, Artikel, Pustaka).', 'customtheme'),
        'priority'    => 36,
    ));

    // Menu 1
    $wp_customize->add_setting('nav_item_1_title', array(
        'default'           => 'TENTANG KAMI',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nav_item_1_title', array(
        'label'    => __('Label Menu 1', 'customtheme'),
        'section'  => 'customtheme_nav_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('nav_item_1_page', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('nav_item_1_page', array(
        'label'    => __('Pilih Halaman untuk Menu 1', 'customtheme'),
        'section'  => 'customtheme_nav_section',
        'type'     => 'dropdown-pages',
    ));

    // Menu 2
    $wp_customize->add_setting('nav_item_2_title', array(
        'default'           => 'ARTIKEL',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nav_item_2_title', array(
        'label'    => __('Label Menu 2', 'customtheme'),
        'section'  => 'customtheme_nav_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('nav_item_2_page', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('nav_item_2_page', array(
        'label'    => __('Pilih Halaman untuk Menu 2', 'customtheme'),
        'section'  => 'customtheme_nav_section',
        'type'     => 'dropdown-pages',
    ));

    // Menu 3
    $wp_customize->add_setting('nav_item_3_title', array(
        'default'           => 'PUSTAKA',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('nav_item_3_title', array(
        'label'    => __('Label Menu 3', 'customtheme'),
        'section'  => 'customtheme_nav_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('nav_item_3_page', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('nav_item_3_page', array(
        'label'    => __('Pilih Halaman untuk Menu 3', 'customtheme'),
        'section'  => 'customtheme_nav_section',
        'type'     => 'dropdown-pages',
    ));

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
    $item1_title = get_theme_mod('nav_item_1_title', 'TENTANG KAMI');
    $item1_page  = get_theme_mod('nav_item_1_page', 0);
    $item1_url   = $item1_page ? get_permalink($item1_page) : home_url('/tentang-kami');
    $is_active_1 = ($item1_page && is_page($item1_page)) || is_page('tentang-kami') || is_page_template('page-tentang-kami.php');

    $item2_title = get_theme_mod('nav_item_2_title', 'ARTIKEL');
    $item2_page  = get_theme_mod('nav_item_2_page', 0);
    $item2_url   = $item2_page ? get_permalink($item2_page) : home_url('/artikel');
    $is_active_2 = ($item2_page && is_page($item2_page)) || is_home() || is_singular('post') || is_category() || is_tag() || is_page('artikel');

    $item3_title = get_theme_mod('nav_item_3_title', 'PUSTAKA');
    $item3_page  = get_theme_mod('nav_item_3_page', 0);
    $item3_url   = $item3_page ? get_permalink($item3_page) : home_url('/pustaka');
    $is_active_3 = ($item3_page && is_page($item3_page)) || is_page('pustaka') || is_page_template('page-pustaka.php');

    echo '<ul class="d-flex flex-wrap align-items-center m-0 p-0 gap-2 list-unstyled">';
    if (!empty($item1_title)) {
        $cls1 = $is_active_1 ? 'current-menu-item active' : '';
        echo '<li class="' . esc_attr($cls1) . '"><a href="' . esc_url($item1_url) . '" class="' . ($is_active_1 ? 'active' : '') . '">' . esc_html($item1_title) . '</a></li>';
    }
    if (!empty($item2_title)) {
        $cls2 = $is_active_2 ? 'current-menu-item active' : '';
        echo '<li class="' . esc_attr($cls2) . '"><a href="' . esc_url($item2_url) . '" class="' . ($is_active_2 ? 'active' : '') . '">' . esc_html($item2_title) . '</a></li>';
    }
    if (!empty($item3_title)) {
        $cls3 = $is_active_3 ? 'current-menu-item active' : '';
        echo '<li class="' . esc_attr($cls3) . '"><a href="' . esc_url($item3_url) . '" class="' . ($is_active_3 ? 'active' : '') . '">' . esc_html($item3_title) . '</a></li>';
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
