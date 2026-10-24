<?php
/**
 * Registrasi Meta Box untuk Publikasi & Foto Kegiatan
 * Sesuai PRD FR-05 & FR-06 serta desain Single Publikasi & Single Foto Kegiatan
 *
 * @package kreasi_redesign_2026
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Registrasi Meta Boxes pada Post
 */
function kreasi_register_custom_meta_boxes()
{
    // Meta box Publikasi
    add_meta_box(
        'kreasi_publikasi_meta_box',
        __('Pengaturan Publikasi KREASI (Unduh & Baca)', 'kreasi_redesign_2026'),
        'kreasi_publikasi_meta_box_html',
        'post',
        'normal',
        'high'
    );

    // Meta box Foto Kegiatan
    add_meta_box(
        'kreasi_foto_kegiatan_meta_box',
        __('Pengaturan Foto Kegiatan (Galeri Slider & Kredit Foto)', 'kreasi_redesign_2026'),
        'kreasi_foto_kegiatan_meta_box_html',
        'post',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'kreasi_register_custom_meta_boxes');

/**
 * Enqueue Media Scripts untuk Post Editor
 */
function kreasi_post_admin_enqueue_scripts($hook)
{
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'kreasi_post_admin_enqueue_scripts');

/**
 * HTML Output: Meta Box Publikasi
 */
function kreasi_publikasi_meta_box_html($post)
{
    wp_nonce_field('kreasi_save_publikasi_meta', 'kreasi_publikasi_meta_nonce');

    $action_mode = get_post_meta($post->ID, '_kreasi_pub_action', true);
    if ($action_mode === '') {
        $action_mode = 'both'; // Default
    }

    $pdf_id      = get_post_meta($post->ID, '_kreasi_pub_pdf_id', true);
    $pdf_url     = get_post_meta($post->ID, '_kreasi_pub_pdf_url', true);
    $read_source = get_post_meta($post->ID, '_kreasi_pub_read_source', true);
    $summary     = get_post_meta($post->ID, '_kreasi_pub_summary', true);

    // Fallback URL jika ID ada tapi URL belum tersimpan
    if (empty($pdf_url) && !empty($pdf_id)) {
        $pdf_url = wp_get_attachment_url((int)$pdf_id);
    }
    ?>
    <div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, sans-serif;">
        <p style="color: #646970; font-size: 13px; margin-top: 0; margin-bottom: 16px;">
            <?php echo esc_html__('Konfigurasikan aksi tombol (Unduh dan/atau Baca) untuk postingan kategori Publikasi/Pustaka.', 'kreasi_redesign_2026'); ?>
        </p>

        <!-- PILIHAN TINDAKAN TOMBOL -->
        <div style="margin-bottom: 20px; padding: 12px 16px; background: #f6f7f7; border: 1px solid #dcdcde; border-radius: 6px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px;">
                <?php echo esc_html__('Mode Tindakan Tombol (Aksi Pengunjung):', 'kreasi_redesign_2026'); ?>
            </label>
            <div style="display: flex; flex-wrap: wrap; gap: 16px;">
                <label style="cursor: pointer;">
                    <input type="radio" name="kreasi_pub_action" value="both" <?php checked($action_mode, 'both'); ?>>
                    <strong><?php echo esc_html__('Unduh dan Baca', 'kreasi_redesign_2026'); ?></strong>
                    <span style="color: #646970; font-size: 12px;">(Tampilkan 2 tombol jika sumber tersedia)</span>
                </label>
                <label style="cursor: pointer;">
                    <input type="radio" name="kreasi_pub_action" value="unduh" <?php checked($action_mode, 'unduh'); ?>>
                    <strong><?php echo esc_html__('Unduh saja', 'kreasi_redesign_2026'); ?></strong>
                </label>
                <label style="cursor: pointer;">
                    <input type="radio" name="kreasi_pub_action" value="baca" <?php checked($action_mode, 'baca'); ?>>
                    <strong><?php echo esc_html__('Baca saja', 'kreasi_redesign_2026'); ?></strong>
                </label>
                <label style="cursor: pointer;">
                    <input type="radio" name="kreasi_pub_action" value="none" <?php checked($action_mode, 'none'); ?>>
                    <strong><?php echo esc_html__('Tidak ada tombol', 'kreasi_redesign_2026'); ?></strong>
                </label>
            </div>
        </div>

        <!-- FILE PDF (UNDUH) -->
        <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">
                <?php echo esc_html__('File Dokumen PDF (untuk Tombol Unduh):', 'kreasi_redesign_2026'); ?>
            </label>
            <input type="hidden" id="kreasi_pub_pdf_id" name="kreasi_pub_pdf_id" value="<?php echo esc_attr($pdf_id); ?>">
            <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 6px;">
                <input type="url" id="kreasi_pub_pdf_url" name="kreasi_pub_pdf_url" value="<?php echo esc_attr($pdf_url); ?>" placeholder="https://.../dokumen.pdf" class="regular-text" style="width: 100%; max-width: 500px;">
                <button type="button" class="button" id="btn_upload_pdf">
                    <span class="dashicons dashicons-media-document" style="margin-top: 3px;"></span> <?php echo esc_html__('Pilih PDF Media Library', 'kreasi_redesign_2026'); ?>
                </button>
                <button type="button" class="button" id="btn_clear_pdf">
                    <?php echo esc_html__('Hapus', 'kreasi_redesign_2026'); ?>
                </button>
            </div>
            <p class="description" style="margin: 0;">
                <?php echo esc_html__('Tombol Unduh hanya muncul di halaman jika mode mengizinkan Unduh dan file PDF terisi.', 'kreasi_redesign_2026'); ?>
            </p>
        </div>

        <!-- SUMBER BACA / FLIPBOOK -->
        <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">
                <?php echo esc_html__('Sumber Baca / Flipbook (URL Tujuan Tombol Baca):', 'kreasi_redesign_2026'); ?>
            </label>
            <input type="url" id="kreasi_pub_read_source" name="kreasi_pub_read_source" value="<?php echo esc_attr($read_source); ?>" placeholder="https://..." class="regular-text" style="width: 100%; max-width: 500px;">
            <p class="description" style="margin-top: 4px;">
                <?php echo esc_html__('Masukkan tautan baca online, flipbook, atau viewer dokumen. Tombol Baca hanya muncul jika URL ini diisi.', 'kreasi_redesign_2026'); ?>
            </p>
        </div>

        <!-- RINGKASAN PUBLIKASI (SUMMARY) -->
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">
                <?php echo esc_html__('Ringkasan / Sinopsis Publikasi (Muncul di Kotak Detail Publikasi):', 'kreasi_redesign_2026'); ?>
            </label>
            <textarea name="kreasi_pub_summary" rows="4" style="width: 100%;" placeholder="<?php echo esc_attr__('Tuliskan ringkasan 1-2 paragraf mengenai publikasi atau majalah ini...', 'kreasi_redesign_2026'); ?>"><?php echo esc_textarea($summary); ?></textarea>
            <p class="description" style="margin-top: 4px;">
                <?php echo esc_html__('Jika dikosongkan, tema otomatis menggunakan excerpt post atau cuplikan paragraf isi artikel.', 'kreasi_redesign_2026'); ?>
            </p>
        </div>
    </div>

    <!-- Script PDF Media Library Selector -->
    <script>
    jQuery(document).ready(function($) {
        var pdfFrame;
        $('#btn_upload_pdf').on('click', function(e) {
            e.preventDefault();
            if (pdfFrame) {
                pdfFrame.open();
                return;
            }
            pdfFrame = wp.media({
                title: 'Pilih Berkas PDF Publikasi',
                button: { text: 'Pilih Dokumen Ini' },
                multiple: false,
                library: { type: 'application/pdf' }
            });
            pdfFrame.on('select', function() {
                var attachment = pdfFrame.state().get('selection').first().toJSON();
                $('#kreasi_pub_pdf_id').val(attachment.id);
                $('#kreasi_pub_pdf_url').val(attachment.url);
            });
            pdfFrame.open();
        });

        $('#btn_clear_pdf').on('click', function(e) {
            e.preventDefault();
            $('#kreasi_pub_pdf_id').val('');
            $('#kreasi_pub_pdf_url').val('');
        });
    });
    </script>
    <?php
}

/**
 * HTML Output: Meta Box Foto Kegiatan
 */
function kreasi_foto_kegiatan_meta_box_html($post)
{
    wp_nonce_field('kreasi_save_foto_kegiatan_meta', 'kreasi_foto_kegiatan_meta_nonce');

    $photo_credit   = get_post_meta($post->ID, '_kreasi_photo_credit', true);
    $gallery_images = get_post_meta($post->ID, '_kreasi_gallery_images', true);
    if (!is_array($gallery_images)) {
        $gallery_images = !empty($gallery_images) ? explode(',', $gallery_images) : array();
    }
    $gallery_ids_str = implode(',', array_filter(array_map('intval', $gallery_images)));
    ?>
    <div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, sans-serif;">
        <p style="color: #646970; font-size: 13px; margin-top: 0; margin-bottom: 16px;">
            <?php echo esc_html__('Gunakan bagian ini jika artikel berupa Foto Kegiatan. Anda dapat mengunggah beberapa foto dokumentasi untuk slider gambar dan mengisi kredit fotografer.', 'kreasi_redesign_2026'); ?>
        </p>

        <!-- KREDIT FOTO -->
        <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 4px;">
                <?php echo esc_html__('Keterangan / Kredit Foto (Caption):', 'kreasi_redesign_2026'); ?>
            </label>
            <input type="text" name="kreasi_photo_credit" value="<?php echo esc_attr($photo_credit); ?>" placeholder="Foto: Calvin S. Telaumbanua/KREASI/Article 33 Indonesia/Save the Children" class="regular-text" style="width: 100%; max-width: 600px;">
            <p class="description" style="margin-top: 4px;">
                <?php echo esc_html__('Teks kredit foto akan ditampilkan dengan format miring (italic) di bawah deskripsi kegiatan.', 'kreasi_redesign_2026'); ?>
            </p>
        </div>

        <!-- GALERI FOTO KEGIATAN UNTUK SLIDER -->
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 6px;">
                <?php echo esc_html__('Daftar Foto Dokumentasi Kegiatan (Slider Foto):', 'kreasi_redesign_2026'); ?>
            </label>
            <input type="hidden" id="kreasi_gallery_images" name="kreasi_gallery_images" value="<?php echo esc_attr($gallery_ids_str); ?>">

            <div id="gallery_preview_container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 12px; min-height: 50px;">
                <?php
                if (!empty($gallery_images)) {
                    foreach ($gallery_images as $img_id) {
                        $img_id = (int)$img_id;
                        if ($img_id > 0) {
                            $thumb = wp_get_attachment_image_url($img_id, 'thumbnail');
                            if ($thumb) {
                                echo '<div class="gallery-thumb-item" data-id="' . esc_attr($img_id) . '" style="position: relative; width: 80px; height: 80px; border-radius: 6px; overflow: hidden; border: 1px solid #c3c4c7;">';
                                echo '<img src="' . esc_url($thumb) . '" style="width:100%; height:100%; object-fit: cover;">';
                                echo '<span class="remove-gallery-img" style="position: absolute; top: 2px; right: 2px; background: rgba(0,0,0,0.6); color: #fff; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 11px;">&times;</span>';
                                echo '</div>';
                            }
                        }
                    }
                }
                ?>
            </div>

            <div>
                <button type="button" class="button button-secondary" id="btn_add_gallery">
                    <span class="dashicons dashicons-format-gallery" style="margin-top: 3px;"></span> <?php echo esc_html__('Pilih / Tambah Foto dari Media Library', 'kreasi_redesign_2026'); ?>
                </button>
                <button type="button" class="button" id="btn_clear_gallery" style="margin-left: 6px;">
                    <?php echo esc_html__('Hapus Semua Foto', 'kreasi_redesign_2026'); ?>
                </button>
            </div>
            <p class="description" style="margin-top: 6px;">
                <?php echo esc_html__('Pilih satu atau lebih foto (Tahan tombol Shift/Ctrl di Media Library untuk memilih beberapa foto sekaligus). Foto ini akan menjadi slide pada carousel foto kegiatan.', 'kreasi_redesign_2026'); ?>
            </p>
        </div>
    </div>

    <!-- Script Multi-Image Gallery Selector -->
    <script>
    jQuery(document).ready(function($) {
        var galleryFrame;
        $('#btn_add_gallery').on('click', function(e) {
            e.preventDefault();
            if (galleryFrame) {
                galleryFrame.open();
                return;
            }
            galleryFrame = wp.media({
                title: 'Pilih Foto untuk Slider Foto Kegiatan',
                button: { text: 'Tambahkan Foto Terpilih' },
                multiple: true,
                library: { type: 'image' }
            });

            galleryFrame.on('select', function() {
                var selection = galleryFrame.state().get('selection');
                var currentIds = $('#kreasi_gallery_images').val() ? $('#kreasi_gallery_images').val().split(',') : [];

                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    var idStr = attachment.id.toString();
                    if (currentIds.indexOf(idStr) === -1) {
                        currentIds.push(idStr);
                        var thumbUrl = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
                        $('#gallery_preview_container').append(
                            '<div class="gallery-thumb-item" data-id="' + idStr + '" style="position: relative; width: 80px; height: 80px; border-radius: 6px; overflow: hidden; border: 1px solid #c3c4c7;">' +
                            '<img src="' + thumbUrl + '" style="width:100%; height:100%; object-fit: cover;">' +
                            '<span class="remove-gallery-img" style="position: absolute; top: 2px; right: 2px; background: rgba(0,0,0,0.6); color: #fff; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 11px;">&times;</span>' +
                            '</div>'
                        );
                    }
                });

                $('#kreasi_gallery_images').val(currentIds.join(','));
            });

            galleryFrame.open();
        });

        $(document).on('click', '.remove-gallery-img', function() {
            var item = $(this).closest('.gallery-thumb-item');
            var removeId = item.attr('data-id');
            var currentIds = $('#kreasi_gallery_images').val() ? $('#kreasi_gallery_images').val().split(',') : [];
            currentIds = currentIds.filter(function(id) { return id !== removeId; });
            $('#kreasi_gallery_images').val(currentIds.join(','));
            item.remove();
        });

        $('#btn_clear_gallery').on('click', function(e) {
            e.preventDefault();
            $('#kreasi_gallery_images').val('');
            $('#gallery_preview_container').empty();
        });
    });
    </script>
    <?php
}

/**
 * Simpan Meta Data Post
 */
function kreasi_save_custom_post_meta($post_id)
{
    // Cek autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Cek permission
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // 1. Simpan Meta Publikasi
    if (isset($_POST['kreasi_publikasi_meta_nonce']) && wp_verify_nonce($_POST['kreasi_publikasi_meta_nonce'], 'kreasi_save_publikasi_meta')) {
        if (isset($_POST['kreasi_pub_action'])) {
            $action = sanitize_text_field($_POST['kreasi_pub_action']);
            if (in_array($action, array('both', 'unduh', 'baca', 'none'), true)) {
                update_post_meta($post_id, '_kreasi_pub_action', $action);
            }
        }

        if (isset($_POST['kreasi_pub_pdf_id'])) {
            update_post_meta($post_id, '_kreasi_pub_pdf_id', absint($_POST['kreasi_pub_pdf_id']));
        }

        if (isset($_POST['kreasi_pub_pdf_url'])) {
            update_post_meta($post_id, '_kreasi_pub_pdf_url', esc_url_raw(wp_unslash($_POST['kreasi_pub_pdf_url'])));
        }

        if (isset($_POST['kreasi_pub_read_source'])) {
            update_post_meta($post_id, '_kreasi_pub_read_source', esc_url_raw(wp_unslash($_POST['kreasi_pub_read_source'])));
        }

        if (isset($_POST['kreasi_pub_summary'])) {
            update_post_meta($post_id, '_kreasi_pub_summary', sanitize_textarea_field(wp_unslash($_POST['kreasi_pub_summary'])));
        }
    }

    // 2. Simpan Meta Foto Kegiatan
    if (isset($_POST['kreasi_foto_kegiatan_meta_nonce']) && wp_verify_nonce($_POST['kreasi_foto_kegiatan_meta_nonce'], 'kreasi_save_foto_kegiatan_meta')) {
        if (isset($_POST['kreasi_photo_credit'])) {
            update_post_meta($post_id, '_kreasi_photo_credit', sanitize_text_field(wp_unslash($_POST['kreasi_photo_credit'])));
        }

        if (isset($_POST['kreasi_gallery_images'])) {
            $raw_ids = sanitize_text_field(wp_unslash($_POST['kreasi_gallery_images']));
            $id_array = array_filter(array_map('absint', explode(',', $raw_ids)));
            update_post_meta($post_id, '_kreasi_gallery_images', implode(',', $id_array));
        }
    }
}
add_action('save_post', 'kreasi_save_custom_post_meta');
