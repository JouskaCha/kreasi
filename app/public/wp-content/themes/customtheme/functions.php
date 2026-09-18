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
    // Section Logo Kemitraan
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
        // Fallback default gambar jika belum diupload
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-1.png') . '" alt="Kemendikdasmen" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-2.png') . '" alt="Kemenag" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-partner-3.png') . '" alt="GPE" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/logo-save-the-children.png') . '" alt="Save the Children" class="' . esc_attr($class) . '" onerror="this.style.display=\'none\'">';
    }
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
