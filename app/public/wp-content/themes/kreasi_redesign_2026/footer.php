<?php
/**
 * Footer template for kreasi_redesign_2026
 *
 * @package kreasi_redesign_2026
 */
?>

<footer class="site-footer pt-5 pb-3">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row gx-lg-5 gy-4 align-items-start">
            <!-- KOLOM 1: Branding & Organisasi Pengelola -->
            <div class="col-lg-5 col-md-12">
                <div class="footer-branding-wrap d-flex flex-column h-100 justify-content-between">

                    <!-- Logo KREASI: Hardcode -->
                    <div class="mb-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="d-inline-block">
                            <img
                                src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-header/Kreasi logo.png'); ?>"
                                alt="KREASI - Kolaborasi untuk Edukasi Anak Indonesia"
                                class="footer-logo-main">
                        </a>
                    </div>

                    <!-- Dikelola oleh: Hardcode -->
                    <div class="managed-by-wrap mt-lg-4 pt-2">
                        <p class="footer-managed-label mb-2"><?php echo esc_html(kreasi_t('managed_by', 'Dikelola oleh', 'Managed by')); ?></p>

                        <a href="https://savethechildren.or.id"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="d-inline-block">
                            <img
                                src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-header/STC.png'); ?>"
                                alt="Save the Children"
                                class="footer-logo-manager">
                        </a>
                    </div>

                </div>
            </div>

            <!-- =========================================================
                 KOLOM 2: Informasi Kontak & Media Sosial
            ========================================================== -->
            <div class="col-lg-4 col-md-6">
                <?php if (is_active_sidebar('footer-col-2')) : ?>
                    <?php dynamic_sidebar('footer-col-2'); ?>
                <?php else : ?>
                    <ul class="footer-contact-list list-unstyled mb-0">
                        <!-- Alamat Kantor -->
                        <li class="d-flex align-items-start mb-3">
                            <span class="contact-icon me-3 mt-1 flex-shrink-0" style="background: transparent !important; border: none !important;">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-footer/maps.png'); ?>" alt="Alamat" width="22" height="22" style="object-fit: contain;">
                            </span>
                            <span class="contact-text">
                                <?php echo esc_html(kreasi_t('contact_address', 'Kantor Nasional Jalan Bangka IX Nomor 40A&B, Pela Mampang, Mampang Prapatan, Jakarta Selatan, DKI Jakarta 12720', 'National Office Jalan Bangka IX No. 40A&B, Pela Mampang, Mampang Prapatan, South Jakarta, DKI Jakarta 12720')); ?>
                            </span>
                        </li>

                        <!-- Telepon -->
                        <li class="d-flex align-items-center mb-3">
                            <span class="contact-icon me-3 flex-shrink-0" style="background: transparent !important; border: none !important;">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-footer/phone.png'); ?>" alt="Telepon" width="22" height="22" style="object-fit: contain;">
                            </span>
                            <a href="tel:+62217824415" class="contact-link">
                                (+62) 217824415
                            </a>
                        </li>

                        <!-- Email -->
                        <li class="d-flex align-items-center mb-3">
                            <span class="contact-icon me-3 flex-shrink-0" style="background: transparent !important; border: none !important;">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-footer/email.png'); ?>" alt="Email" width="22" height="22" style="object-fit: contain;">
                            </span>
                            <a href="mailto:indonesia.kreasi@savethechildren.org" class="contact-link text-break">
                                indonesia.kreasi@savethechildren.org
                            </a>
                        </li>

                        <!-- Instagram -->
                        <li class="d-flex align-items-center mb-3">
                            <span class="contact-icon me-3 flex-shrink-0" style="background: transparent !important; border: none !important;">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-footer/instagram.png'); ?>" alt="Instagram" width="22" height="22" style="object-fit: contain;">
                            </span>
                            <a href="https://instagram.com/kreasinasional" target="_blank" rel="noopener noreferrer" class="contact-link">
                                @kreasinasional
                            </a>
                        </li>

                        <!-- YouTube -->
                        <li class="d-flex align-items-center mb-0">
                            <span class="contact-icon me-3 flex-shrink-0" style="background: transparent !important; border: none !important;">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-footer/youtube.png'); ?>" alt="YouTube" width="22" height="22" style="object-fit: contain;">
                            </span>
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="contact-link">
                                KREASI (Kolaborasi untuk Edukasi Anak Indonesia)
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- =========================================================
                 KOLOM 3: Widget Interaktif (Newsletter & Laporan)
            ========================================================== -->
            <div class="col-lg-3 col-md-6">
                <?php if (is_active_sidebar('footer-col-3')) : ?>
                    <?php dynamic_sidebar('footer-col-3'); ?>
                <?php else : ?>
                    <div class="footer-interactive-cards d-flex flex-column gap-3">
                        
                        <!-- Card 1: Newsletter -->
                        <div class="card footer-card border-0 shadow-sm">
                            <div class="card-body p-2 p-xl-4">
                                <h6 class="card-title fw-bold text-navy mb-3"><?php echo esc_html(kreasi_t('follow_latest_news', 'Ikuti Kabar Terkini', 'Follow the Latest News')); ?></h6>
                                <form action="#" method="post" class="newsletter-form d-flex gap-2" onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');">
                                    <input type="email" 
                                           name="subscriber_email" 
                                           class="form-control form-control-sm footer-input" 
                                           placeholder="<?php echo esc_attr(kreasi_t('enter_email', 'Masukkan Email Anda', 'Enter Your Email')); ?>" 
                                           required>
                                    <button type="submit" class="btn btn-danger btn-sm btn-subscribe px-3 flex-shrink-0">
                                        <?php echo esc_html(kreasi_t('subscribe', 'BERLANGGANAN', 'SUBSCRIBE')); ?>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Card 2: Laporan & Feedback -->
                        <div class="card footer-card border-0 shadow-sm">
                            <div class="card-body p-2 p-xl-4">
                                <p class="card-text text-secondary small mb-3">
                                    <?php echo wp_kses_post(kreasi_t('safeguarding_text', 'Laporkan pelanggaran <em>safeguarding</em>, atau sampaikan kritik dan saran.', 'Report safeguarding violations, or provide feedback and suggestions.')); ?>
                                </p>
                                <a href="<?php echo esc_url(home_url('/safeguarding')); ?>" class="btn btn-navy btn-sm btn-report w-100 py-2 text-center text-decoration-none">
                                    <?php echo esc_html(kreasi_t('read_more', 'SELENGKAPNYA', 'READ MORE')); ?>
                                </a>
                            </div>
                        </div>

                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- =========================================================
             FOOTER COPYRIGHT (Bottom Line)
        ========================================================== -->
        <hr class="footer-divider mt-5 mb-3">

        <div class="row">
            <div class="col-12 text-center">
                <p class="footer-copyright text-secondary small mb-0">
                    <?php echo esc_html(kreasi_t('copyright_prefix', 'Hak Cipta', 'Copyright')); ?> &copy; <?php echo date('Y'); ?> Save the Children Indonesia
                </p>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
