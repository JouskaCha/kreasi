<?php

/**
 * Title: Header
 * Slug: customtheme/header
 * Categories: header
 * Block Types: core/template-part/header
 */
?>
<header id="siteHeader" class="site-header">

    <!-- =========================================================
         1. BARIS ATAS (Top Bar: Logo KREASI & Partner / Hamburger)
    ========================================================== -->
    <div id="topHeaderBar" class="header-top-bar bg-white py-2">
        <div class="container-fluid px-4 px-lg-5">
            <div class="d-flex justify-content-between align-items-center">

                <!-- SISI KIRI: Logo Utama KREASI (Dinamis dari Media Library / Custom Logo) -->
                <div class="header-main-logo">
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
            <div class="collapse d-md-block" id="mobileNavCollapse">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center py-2 gap-3 gap-md-0">

                    <!-- SISI KIRI: Navigasi Menu Utama (Pills Capsule) -->
                    <nav class="main-navigation kreasi-nav-menu">
                        <?php
                        $nav_items = array(
                            array(
                                'label' => 'TENTANG KAMI',
                                'slug'  => 'tentang-kami',
                            ),
                            array(
                                'label' => 'ARTIKEL',
                                'slug'  => 'artikel',
                            ),
                            array(
                                'label' => 'PUSTAKA',
                                'slug'  => 'pustaka',
                            ),
                        );
                        ?>
                        <ul class="d-flex flex-wrap align-items-center m-0 p-0 gap-2">
                            <li>
                                <a href="<?php echo esc_url(home_url('/tentang-kami/')); ?>">
                                    TENTANG KAMI
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(home_url('/artikel/')); ?>">
                                    ARTIKEL
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(home_url('/pustaka/')); ?>">
                                    PUSTAKA
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- SISI KANAN: Form Pencarian & Switcher Bahasa -->
                    <div class="header-right-actions d-flex align-items-center gap-3">
                        <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="header-search-form">
                            <button type="submit" aria-label="Search">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="CARI" class="ms-2">
                        </form>

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