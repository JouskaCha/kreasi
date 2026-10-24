<?php
/**
 * Pengaturan Section Event Homepage di WP Admin
 * Sesuai PRD FR-07: Menggantikan Theme Customizer dengan menu pengaturan admin terstruktur.
 *
 * @package kreasi_redesign_2026
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registrasi Menu Admin untuk Event Homepage
 */
function kreasi_event_register_admin_menu()
{
    add_menu_page(
        __('Event Homepage', 'kreasi_redesign_2026'),
        __('Event Homepage', 'kreasi_redesign_2026'),
        'manage_options',
        'kreasi-event-settings',
        'kreasi_event_settings_page_html',
        'dashicons-calendar-alt',
        25
    );
}
add_action('admin_menu', 'kreasi_event_register_admin_menu');

/**
 * Enqueue Media Scripts untuk Image Selector
 */
function kreasi_event_admin_enqueue_scripts($hook)
{
    if ($hook !== 'toplevel_page_kreasi-event-settings') {
        return;
    }
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'kreasi_event_admin_enqueue_scripts');

/**
 * Helper: Ambil Pengaturan Event
 *
 * @param bool $apply_fallbacks Jika true (untuk frontend), gambar kosong akan otomatis memakai aset default tema.
 *                              Jika false (untuk admin), nilai kosong tetap kosong sehingga reset/hapus tidak tertimpa URL tema.
 */
function kreasi_get_event_settings($apply_fallbacks = true)
{
    $defaults = array(
        'show_section'         => 1,
        'image_desktop'        => '',
        'image_mobile'         => '',
        'use_default_fallback' => 1,
        'show_video'           => 0,
        'youtube_url'          => '',
        'show_cta'             => 0,
        'cta_text'             => '',
        'cta_url'              => '',
    );

    $saved = get_option('kreasi_event_settings', array());
    if (!is_array($saved)) {
        $saved = array();
    }

    $settings = wp_parse_args($saved, $defaults);

    // Jika dipanggil untuk frontend dan diizinkan memakai fallback tema
    if ($apply_fallbacks && !empty($settings['use_default_fallback'])) {
        if (empty($settings['image_desktop'])) {
            $settings['image_desktop'] = get_template_directory_uri() . '/assets/images/event.png';
        }

        if (empty($settings['image_mobile'])) {
            if (file_exists(get_template_directory() . '/assets/images/event-mobile.png')) {
                $settings['image_mobile'] = get_template_directory_uri() . '/assets/images/event-mobile.png';
            } else {
                $settings['image_mobile'] = $settings['image_desktop'];
            }
        }
    }

    return $settings;
}

/**
 * Helper: Ekstrak ID YouTube dari berbagai variasi URL
 */
function kreasi_extract_youtube_id($url)
{
    if (empty($url)) {
        return '';
    }
    $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i';
    if (preg_match($pattern, $url, $matches)) {
        return $matches[1];
    }
    return '';
}

/**
 * Halaman Pengaturan Event Homepage (HTML & Form Handler)
 */
function kreasi_event_settings_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Handle Form Submit
    if (isset($_POST['kreasi_event_settings_nonce'])) {
        check_admin_referer('kreasi_save_event_settings', 'kreasi_event_settings_nonce');

        $show_section         = isset($_POST['show_section']) ? 1 : 0;
        $image_desktop        = isset($_POST['image_desktop']) ? esc_url_raw(trim(wp_unslash($_POST['image_desktop']))) : '';
        $image_mobile         = isset($_POST['image_mobile']) ? esc_url_raw(trim(wp_unslash($_POST['image_mobile']))) : '';
        $use_default_fallback = isset($_POST['use_default_fallback']) ? 1 : 0;
        $show_video           = isset($_POST['show_video']) ? 1 : 0;
        $youtube_url          = isset($_POST['youtube_url']) ? esc_url_raw(trim(wp_unslash($_POST['youtube_url']))) : '';
        $show_cta             = isset($_POST['show_cta']) ? 1 : 0;
        $cta_text             = isset($_POST['cta_text']) ? sanitize_text_field(wp_unslash($_POST['cta_text'])) : '';
        $cta_url              = isset($_POST['cta_url']) ? esc_url_raw(trim(wp_unslash($_POST['cta_url']))) : '';

        // Bersihkan Customizer mod lawas jika gambar di-reset / dihapus
        if (empty($image_desktop)) {
            remove_theme_mod('event_section_image_desktop');
        } else {
            set_theme_mod('event_section_image_desktop', $image_desktop);
        }

        if (empty($image_mobile)) {
            remove_theme_mod('event_section_image_mobile');
        } else {
            set_theme_mod('event_section_image_mobile', $image_mobile);
        }

        $data_to_save = array(
            'show_section'         => $show_section,
            'image_desktop'        => $image_desktop,
            'image_mobile'         => $image_mobile,
            'use_default_fallback' => $use_default_fallback,
            'show_video'           => $show_video,
            'youtube_url'          => $youtube_url,
            'show_cta'             => $show_cta,
            'cta_text'             => $cta_text,
            'cta_url'              => $cta_url,
        );

        update_option('kreasi_event_settings', $data_to_save);

        echo '<div class="notice notice-success is-dismissible"><p><strong>' . esc_html__('Pengaturan Event Homepage berhasil disimpan.', 'kreasi_redesign_2026') . '</strong></p></div>';
    }

    // Ambil data tanpa fallback otomatis agar form menampilkan nilai aktual yang tersimpan
    $settings = kreasi_get_event_settings(false);
    $theme_default_desktop = get_template_directory_uri() . '/assets/images/event.png';
    $theme_default_mobile  = get_template_directory_uri() . '/assets/images/event-mobile.png';
    ?>
    <div class="wrap" style="max-width: 920px;">
        <h1 style="font-size: 26px; font-weight: 700; margin-bottom: 8px;">
            <?php echo esc_html__('Pengaturan Section Event Homepage', 'kreasi_redesign_2026'); ?>
        </h1>
        <p class="description" style="margin-bottom: 24px; font-size: 14px;">
            <?php echo esc_html__('Kelola tampilan banner responsif (Desktop & Mobile), video YouTube, dan tombol aksi (CTA) untuk section Event homepage KREASI.', 'kreasi_redesign_2026'); ?>
        </p>

        <form method="post" action="" style="background: #ffffff; border: 1px solid #c3c4c7; border-radius: 8px; padding: 24px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <?php wp_nonce_field('kreasi_save_event_settings', 'kreasi_event_settings_nonce'); ?>

            <!-- VISIBILITY SECTION -->
            <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f1;">
                <label style="font-weight: 600; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="show_section" value="1" <?php checked(1, $settings['show_section']); ?> style="margin: 0; width: 18px; height: 18px;">
                    <span><?php echo esc_html__('Tampilkan Section Event pada Homepage', 'kreasi_redesign_2026'); ?></span>
                </label>
                <p class="description" style="margin: 6px 0 0 26px;">
                    <?php echo esc_html__('Jika tidak dicentang, seluruh section Event tidak akan ditampilkan di homepage.', 'kreasi_redesign_2026'); ?>
                </p>
            </div>

            <!-- GAMBAR DESKTOP -->
            <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f1;">
                <label style="font-weight: 600; font-size: 14px; display: block; margin-bottom: 8px;">
                    <?php echo esc_html__('Gambar Event - Desktop (Landscape)', 'kreasi_redesign_2026'); ?>
                </label>
                <div style="display: flex; gap: 18px; align-items: flex-start; flex-wrap: wrap;">
                    <div style="max-width: 320px; width: 100%;">
                        <div id="desktop_preview" style="border: 1px solid #dcdcde; border-radius: 6px; overflow: hidden; background: #f6f7f7; min-height: 120px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($settings['image_desktop'])) : ?>
                                <img src="<?php echo esc_url($settings['image_desktop']); ?>" alt="Preview Desktop" style="width: 100%; height: auto; display: block;">
                            <?php else : ?>
                                <div style="text-align: center; padding: 16px 12px; color: #50575e;">
                                    <span class="dashicons dashicons-format-image" style="font-size: 32px; width: 32px; height: 32px; color: #a7aaad; margin-bottom: 4px;"></span>
                                    <div style="font-size: 12.5px; font-weight: 600;"><?php echo esc_html__('Tidak ada gambar kustom', 'kreasi_redesign_2026'); ?></div>
                                    <small style="color: #646970;"><?php echo esc_html__('Menggunakan gambar default tema (event.png)', 'kreasi_redesign_2026'); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($settings['image_desktop'])) : ?>
                            <div id="desktop_status_badge" style="margin-top: 6px;">
                                <span style="display: inline-block; background: #e7f5ea; color: #0e6221; padding: 2px 8px; border-radius: 4px; font-size: 11.5px; font-weight: 600;">
                                    <span class="dashicons dashicons-yes" style="font-size: 14px; width: 14px; height: 14px; vertical-align: text-top;"></span> <?php echo esc_html__('Gambar Kustom Terpasang', 'kreasi_redesign_2026'); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="flex: 1; min-width: 250px;">
                        <input type="text" id="image_desktop" name="image_desktop" value="<?php echo esc_attr($settings['image_desktop']); ?>" placeholder="<?php echo esc_attr__('Kosong (menggunakan gambar default tema)...', 'kreasi_redesign_2026'); ?>" class="regular-text" style="width: 100%; margin-bottom: 8px;">
                        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <button type="button" class="button button-secondary" id="btn_upload_desktop">
                                <span class="dashicons dashicons-upload" style="margin-top: 3px;"></span> <?php echo esc_html__('Pilih dari Media Library', 'kreasi_redesign_2026'); ?>
                            </button>
                            <button type="button" class="button button-link-delete" id="btn_clear_desktop" style="color: #b32d2e; border: 1px solid #dcdcde; padding: 4px 10px; border-radius: 3px; background: #fff; text-decoration: none;">
                                <span class="dashicons dashicons-trash" style="margin-top: 3px; font-size: 16px;"></span> <?php echo esc_html__('Reset / Hapus Media', 'kreasi_redesign_2026'); ?>
                            </button>
                        </div>
                        <p class="description" style="margin-top: 8px;">
                            <?php echo esc_html__('Format landscape untuk tampilan desktop. Klik "Reset / Hapus Media" lalu "Simpan" jika ingin kembali ke gambar default tema.', 'kreasi_redesign_2026'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- GAMBAR MOBILE -->
            <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f1;">
                <label style="font-weight: 600; font-size: 14px; display: block; margin-bottom: 8px;">
                    <?php echo esc_html__('Gambar Event - Mobile (Portrait / Compact)', 'kreasi_redesign_2026'); ?>
                </label>
                <div style="display: flex; gap: 18px; align-items: flex-start; flex-wrap: wrap;">
                    <div style="max-width: 200px; width: 100%;">
                        <div id="mobile_preview" style="border: 1px solid #dcdcde; border-radius: 6px; overflow: hidden; background: #f6f7f7; min-height: 120px; display: flex; align-items: center; justify-content: center;">
                            <?php if (!empty($settings['image_mobile'])) : ?>
                                <img src="<?php echo esc_url($settings['image_mobile']); ?>" alt="Preview Mobile" style="width: 100%; height: auto; display: block;">
                            <?php else : ?>
                                <div style="text-align: center; padding: 16px 10px; color: #50575e;">
                                    <span class="dashicons dashicons-smartphone" style="font-size: 32px; width: 32px; height: 32px; color: #a7aaad; margin-bottom: 4px;"></span>
                                    <div style="font-size: 12px; font-weight: 600;"><?php echo esc_html__('Tidak ada gambar mobile kustom', 'kreasi_redesign_2026'); ?></div>
                                    <small style="color: #646970;"><?php echo esc_html__('Otomatis memakai gambar default tema', 'kreasi_redesign_2026'); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($settings['image_mobile'])) : ?>
                            <div id="mobile_status_badge" style="margin-top: 6px;">
                                <span style="display: inline-block; background: #e7f5ea; color: #0e6221; padding: 2px 8px; border-radius: 4px; font-size: 11.5px; font-weight: 600;">
                                    <span class="dashicons dashicons-yes" style="font-size: 14px; width: 14px; height: 14px; vertical-align: text-top;"></span> <?php echo esc_html__('Gambar Mobile Kustom Terpasang', 'kreasi_redesign_2026'); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="flex: 1; min-width: 250px;">
                        <input type="text" id="image_mobile" name="image_mobile" value="<?php echo esc_attr($settings['image_mobile']); ?>" placeholder="<?php echo esc_attr__('Kosong (otomatis menggunakan gambar Desktop atau default tema)...', 'kreasi_redesign_2026'); ?>" class="regular-text" style="width: 100%; margin-bottom: 8px;">
                        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <button type="button" class="button button-secondary" id="btn_upload_mobile">
                                <span class="dashicons dashicons-upload" style="margin-top: 3px;"></span> <?php echo esc_html__('Pilih dari Media Library', 'kreasi_redesign_2026'); ?>
                            </button>
                            <button type="button" class="button button-link-delete" id="btn_clear_mobile" style="color: #b32d2e; border: 1px solid #dcdcde; padding: 4px 10px; border-radius: 3px; background: #fff; text-decoration: none;">
                                <span class="dashicons dashicons-trash" style="margin-top: 3px; font-size: 16px;"></span> <?php echo esc_html__('Reset / Hapus Media', 'kreasi_redesign_2026'); ?>
                            </button>
                        </div>
                        <p class="description" style="margin-top: 8px;">
                            <?php echo esc_html__('Format portrait untuk layar HP (< 768px). Jika dikosongkan, tema otomatis memakai gambar Desktop atau default tema.', 'kreasi_redesign_2026'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- OPSI FALLBACK TEMA -->
            <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f1;">
                <label style="font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="use_default_fallback" value="1" <?php checked(1, $settings['use_default_fallback']); ?> style="margin: 0; width: 17px; height: 17px;">
                    <span><?php echo esc_html__('Gunakan gambar bawaan tema (event.png) jika gambar kustom di atas dikosongkan', 'kreasi_redesign_2026'); ?></span>
                </label>
                <p class="description" style="margin: 4px 0 0 25px;">
                    <?php echo esc_html__('Jika opsi ini dinonaktifkan dan gambar dikosongkan, banner grafik event tidak akan dirender di frontend.', 'kreasi_redesign_2026'); ?>
                </p>
            </div>

            <!-- VIDEO YOUTUBE (OPSIONAL) -->
            <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f1;">
                <label style="font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                    <input type="checkbox" name="show_video" value="1" <?php checked(1, $settings['show_video']); ?> style="margin: 0; width: 17px; height: 17px;">
                    <span><?php echo esc_html__('Tampilkan Video YouTube di Section Event', 'kreasi_redesign_2026'); ?></span>
                </label>
                <div style="margin-left: 25px;">
                    <label for="youtube_url" style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px;">
                        <?php echo esc_html__('URL Video YouTube', 'kreasi_redesign_2026'); ?>
                    </label>
                    <input type="url" id="youtube_url" name="youtube_url" value="<?php echo esc_attr($settings['youtube_url']); ?>" placeholder="https://www.youtube.com/watch?v=..." class="regular-text" style="width: 100%;">
                    <p class="description" style="margin-top: 4px;">
                        <?php echo esc_html__('Masukkan tautan video YouTube yang valid.', 'kreasi_redesign_2026'); ?>
                    </p>
                </div>
            </div>

            <!-- CTA BUTTON (OPSIONAL) -->
            <div style="margin-bottom: 28px;">
                <label style="font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                    <input type="checkbox" name="show_cta" value="1" <?php checked(1, $settings['show_cta']); ?> style="margin: 0; width: 17px; height: 17px;">
                    <span><?php echo esc_html__('Tampilkan Tombol Aksi (CTA) pada Event', 'kreasi_redesign_2026'); ?></span>
                </label>
                <div style="margin-left: 25px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label for="cta_text" style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px;">
                            <?php echo esc_html__('Label Teks Tombol CTA', 'kreasi_redesign_2026'); ?>
                        </label>
                        <input type="text" id="cta_text" name="cta_text" value="<?php echo esc_attr($settings['cta_text']); ?>" placeholder="Contoh: DAFTAR SEKARANG" class="regular-text" style="width: 100%;">
                    </div>
                    <div>
                        <label for="cta_url" style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 4px;">
                            <?php echo esc_html__('URL Tujuan Tombol CTA', 'kreasi_redesign_2026'); ?>
                        </label>
                        <input type="url" id="cta_url" name="cta_url" value="<?php echo esc_attr($settings['cta_url']); ?>" placeholder="https://..." class="regular-text" style="width: 100%;">
                    </div>
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <div>
                <button type="submit" class="button button-primary button-hero" style="font-size: 14px; height: 40px; line-height: 38px; padding: 0 24px; background: #062172; border-color: #062172;">
                    <?php echo esc_html__('Simpan Perubahan Event', 'kreasi_redesign_2026'); ?>
                </button>
            </div>

        </form>
    </div>

    <!-- SCRIPT WP MEDIA PICKER & RESET HANDLER -->
    <script>
    jQuery(document).ready(function($) {
        // Setup Media Picker
        function setupMediaPicker(btnId, clearBtnId, inputId, previewId, badgeId, isMobile) {
            var frame;
            $('#' + btnId).on('click', function(e) {
                e.preventDefault();
                if (frame) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: 'Pilih Gambar Banner Event ' + (isMobile ? 'Mobile' : 'Desktop'),
                    button: { text: 'Gunakan Gambar Ini' },
                    multiple: false,
                    library: { type: 'image' }
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#' + inputId).val(attachment.url);
                    $('#' + previewId).html('<img src="' + attachment.url + '" style="width:100%; height:auto; display:block;">');
                    if ($('#' + badgeId).length) {
                        $('#' + badgeId).show();
                    }
                });
                frame.open();
            });

            // Handler Reset / Hapus
            $('#' + clearBtnId).on('click', function(e) {
                e.preventDefault();
                $('#' + inputId).val(''); // Kosongkan input form secara eksplisit
                
                var resetHtml = '<div style="text-align: center; padding: 16px 10px; color: #b32d2e;">' +
                    '<span class="dashicons dashicons-trash" style="font-size: 28px; width: 28px; height: 28px; margin-bottom: 4px;"></span>' +
                    '<div style="font-weight: 600; font-size: 12.5px;">Gambar kustom dihapus</div>' +
                    '<small style="color: #646970;">Klik <strong>Simpan Perubahan Event</strong> di bawah untuk menerapkan.</small>' +
                    '</div>';

                $('#' + previewId).html(resetHtml);

                if ($('#' + badgeId).length) {
                    $('#' + badgeId).hide();
                }
            });
        }

        setupMediaPicker('btn_upload_desktop', 'btn_clear_desktop', 'image_desktop', 'desktop_preview', 'desktop_status_badge', false);
        setupMediaPicker('btn_upload_mobile', 'btn_clear_mobile', 'image_mobile', 'mobile_preview', 'mobile_status_badge', true);
    });
    </script>
    <?php
}
