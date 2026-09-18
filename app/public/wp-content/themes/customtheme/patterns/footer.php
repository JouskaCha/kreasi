<?php
/**
 * Title: Footer
 * Slug: customtheme/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 */
?>
<footer class="site-footer pt-5 pb-3">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row gx-lg-5 gy-4 align-items-start">
            
            <!-- KOLOM 1: Branding & Organisasi Pengelola -->
            <div class="col-lg-4 col-md-12">
                <?php if (is_active_sidebar('footer-col-1')) : ?>
                    <?php dynamic_sidebar('footer-col-1'); ?>
                <?php else : ?>
                    <div class="footer-branding-wrap d-flex flex-column h-100 justify-content-between">
                        <!-- Logo Utama (Dinamis dari Custom Logo / Fallback) -->
                        <div class="mb-4">
                            <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="d-inline-block">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-kreasi.png'); ?>" 
                                         alt="KREASI - Kolaborasi untuk Edukasi Anak Indonesia" 
                                         class="footer-logo-main"
                                         onerror="this.outerHTML='<h3 class=\'fw-bold text-navy mb-0\'>KREASI</h3><small class=\'text-secondary fw-semibold\'>Kolaborasi untuk Edukasi Anak Indonesia</small>'">
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Keterangan Dikelola oleh + Logo Save the Children -->
                        <div class="managed-by-wrap mt-lg-4 pt-2">
                            <p class="text-secondary small mb-2 fw-medium">Dikelola oleh</p>
                            <a href="https://savethechildren.or.id" target="_blank" rel="noopener noreferrer" class="d-inline-block">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-save-the-children.png'); ?>" 
                                     alt="Save the Children" 
                                     class="footer-logo-manager"
                                     onerror="this.outerHTML='<span class=\'text-danger fw-bold fs-5\'>Save the Children</span>'">
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- KOLOM 2: Informasi Kontak & Media Sosial -->
            <div class="col-lg-4 col-md-6">
                <?php if (is_active_sidebar('footer-col-2')) : ?>
                    <?php dynamic_sidebar('footer-col-2'); ?>
                <?php else : ?>
                    <ul class="footer-contact-list list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <span class="contact-icon me-3 mt-1 flex-shrink-0">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>
                            <span class="contact-text">
                                Kantor Nasional Jalan Bangka IX Nomor 40A&B, Pela Mampang, Mampang Prapatan, Jakarta Selatan, DKI Jakarta 12720
                            </span>
                        </li>

                        <li class="d-flex align-items-center mb-3">
                            <span class="contact-icon me-3 flex-shrink-0">
                                <i class="bi bi-telephone-fill"></i>
                            </span>
                            <a href="tel:+62217824415" class="contact-link">
                                (+62) 217824415
                            </a>
                        </li>

                        <li class="d-flex align-items-center mb-3">
                            <span class="contact-icon me-3 flex-shrink-0">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <a href="mailto:indonesia.kreasi@savethechildren.org" class="contact-link text-break">
                                indonesia.kreasi@savethechildren.org
                            </a>
                        </li>

                        <li class="d-flex align-items-center mb-3">
                            <span class="contact-icon me-3 flex-shrink-0">
                                <i class="bi bi-instagram"></i>
                            </span>
                            <a href="https://instagram.com/kreasinasional" target="_blank" rel="noopener noreferrer" class="contact-link">
                                @kreasinasional
                            </a>
                        </li>

                        <li class="d-flex align-items-center mb-0">
                            <span class="contact-icon me-3 flex-shrink-0">
                                <i class="bi bi-youtube"></i>
                            </span>
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="contact-link">
                                KREASI (Kolaborasi untuk Edukasi Anak Indonesia)
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- KOLOM 3: Widget Interaktif (Newsletter & Laporan) -->
            <div class="col-lg-4 col-md-6">
                <?php if (is_active_sidebar('footer-col-3')) : ?>
                    <?php dynamic_sidebar('footer-col-3'); ?>
                <?php else : ?>
                    <div class="footer-interactive-cards d-flex flex-column gap-3">
                        <div class="card footer-card border-0 shadow-sm">
                            <div class="card-body p-3 p-xl-4">
                                <h6 class="card-title fw-bold text-navy mb-3">Ikuti Kabar Terkini</h6>
                                <form action="#" method="post" class="newsletter-form d-flex gap-2" onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');">
                                    <input type="email" 
                                           name="subscriber_email" 
                                           class="form-control form-control-sm footer-input" 
                                           placeholder="Masukkan Email Anda" 
                                           required>
                                    <button type="submit" class="btn btn-danger btn-sm btn-subscribe px-3 fw-bold flex-shrink-0">
                                        BERLANGGANAN
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card footer-card border-0 shadow-sm">
                            <div class="card-body p-3 p-xl-4">
                                <p class="card-text text-secondary small mb-3">
                                    Laporkan pelanggaran <em>safeguarding</em>, atau sampaikan kritik dan saran.
                                </p>
                                <a href="<?php echo esc_url(home_url('/safeguarding')); ?>" class="btn btn-navy btn-sm btn-report w-100 fw-bold py-2 text-center text-decoration-none">
                                    SELENGKAPNYA
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <hr class="footer-divider mt-5 mb-3">

        <div class="row">
            <div class="col-12 text-center">
                <p class="footer-copyright text-secondary small mb-0">
                    Hak Cipta &copy; <?php echo date('Y'); ?> Save the Children Indonesia
                </p>
            </div>
        </div>

    </div>
</footer>