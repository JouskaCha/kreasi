<?php
/**
 * Header template for customtheme
 *
 * @package customtheme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="siteHeader" class="site-header">

    <!-- =========================================================
         1. BARIS ATAS (Top Bar: Logo KREASI & Partner / Hamburger)
    ========================================================== -->
    <div id="topHeaderBar" class="header-top-bar bg-white py-2">
        <div class="container-fluid px-4 px-lg-5">
            <div class="d-flex justify-content-between align-items-center">

                <!-- SISI KIRI: Logo Utama (Dinamis dari WordPress Media Library / Custom Logo) -->
                <div class="header-main-logo d-flex align-items-center">
                    <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="d-inline-block" rel="home">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-kreasi.png'); ?>" 
                                 alt="<?php bloginfo('name'); ?>" 
                                 class="logo-kreasi-img"
                                 onerror="this.outerHTML='<h3 class=\'fw-bold text-navy mb-0\'>KREASI</h3><small class=\'text-secondary fw-semibold\'>Kolaborasi untuk Edukasi Anak Indonesia</small>'">
                        </a>
                    <?php endif; ?>
                </div>

                <!-- SISI KANAN DESKTOP: Barisan Logo Mitra/Partner (Hidden on Mobile) -->
                <div class="partner-logos d-none d-md-flex align-items-center gap-3">
                    <?php customtheme_render_partner_logos(false); ?>
                </div>

                <!-- SISI KANAN MOBILE: Hamburger Menu Button (Visible on Mobile only) -->
                <button class="navbar-toggler d-md-none border rounded p-1 shadow-none" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#mobileNavCollapse" 
                        aria-controls="mobileNavCollapse" 
                        aria-expanded="false" 
                        aria-label="Toggle navigation">
                    <i class="bi bi-list fs-2 text-dark"></i>
                </button>

            </div>
        </div>
    </div>

    <!-- Garis Pembatas Horizontal Tipis -->
    <div class="header-divider"></div>

    <!-- SISI MOBILE: Barisan Logo Partner di Bawah Garis (Mobile only) -->
    <div class="partner-logos-mobile d-md-none bg-white py-2 border-bottom">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <?php customtheme_render_partner_logos(true); ?>
            </div>
        </div>
    </div>

    <!-- =========================================================
         2. BARIS BAWAH (Main Navigation Bar - Desktop & Mobile Collapse)
    ========================================================== -->
    <div id="mainHeaderNav" class="header-main-nav bg-white">
        <div class="container-fluid px-4 px-lg-5">
            
            <!-- Mobile Collapse Wrapper -->
            <div class="collapse d-md-block" id="mobileNavCollapse">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center py-2 gap-3 gap-md-0">

                    <!-- SISI KIRI: Navigasi Menu Utama (Pills Capsule) -->
                    <nav class="main-navigation kreasi-nav-menu">
                        <?php
                        if (has_nav_menu('primary')) {
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'container'      => false,
                                'menu_class'     => 'd-flex flex-wrap align-items-center m-0 p-0 gap-2',
                                'fallback_cb'    => 'customtheme_render_default_nav_menu',
                            ));
                        } else {
                            customtheme_render_default_nav_menu();
                        }
                        ?>
                    </nav>

                    <!-- SISI KANAN: Form Pencarian & Switcher Bahasa -->
                    <div class="header-right-actions d-flex align-items-center gap-3">
                        
                        <!-- Form Pencarian Capsule -->
                        <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="header-search-form">
                            <button type="submit" aria-label="Search">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="CARI" class="ms-2">
                        </form>

                        <!-- Switcher Bahasa (IN [Aktif - Merah] | EN) -->
                        <div class="language-switcher d-flex align-items-center gap-1">
                            <a href="#" class="lang-btn active" title="Bahasa Indonesia">IN</a>
                            <a href="#" class="lang-btn" title="English">EN</a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

</header>

<!-- Skrip Sticky Header (Vanilla JS untuk Desktop) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainNav = document.getElementById('mainHeaderNav');
    const topBar = document.getElementById('topHeaderBar');

    if (!mainNav || !topBar) return;

    function handleSticky() {
        // Efek Sticky hanya aktif pada Desktop (>= 768px)
        if (window.innerWidth >= 768) {
            const topBarOffset = topBar.offsetHeight + 2;
            if (window.scrollY > topBarOffset) {
                if (!mainNav.classList.contains('is-sticky')) {
                    mainNav.classList.add('is-sticky');
                    document.body.style.paddingTop = mainNav.offsetHeight + 'px';
                }
            } else {
                if (mainNav.classList.contains('is-sticky')) {
                    mainNav.classList.remove('is-sticky');
                    document.body.style.paddingTop = '0px';
                }
            }
        } else {
            if (mainNav.classList.contains('is-sticky')) {
                mainNav.classList.remove('is-sticky');
                document.body.style.paddingTop = '0px';
            }
        }
    }

    window.addEventListener('scroll', handleSticky, { passive: true });
    window.addEventListener('resize', handleSticky);
});
</script>
