<?php
/**
 * The category archive template.
 * Routes:
 * - Publication categories -> page-publikasi.php (sesuai instruksi user)
 * - Foto Kegiatan category -> archive-foto-kegiatan.php (sesuai Image 1)
 * - Article categories -> artikel.php
 *
 * @package kreasi_redesign_2026
 */

$cat = get_queried_object();
$pub_cat_ids = function_exists('kreasi_get_publikasi_category_ids') ? kreasi_get_publikasi_category_ids() : array();

// 1. Cek Kategori Foto Kegiatan
if ($cat && in_array($cat->slug, array('foto-kegiatan', 'kegiatan'), true)) {
    get_template_part('archive', 'foto-kegiatan');
    return;
}

// 2. Cek Kategori Publikasi
$is_publikasi_cat = false;
if ($cat && !empty($pub_cat_ids)) {
    if (in_array($cat->term_id, $pub_cat_ids, true) || in_array($cat->parent, $pub_cat_ids, true)) {
        $is_publikasi_cat = true;
    }
}
if (!$is_publikasi_cat && $cat && in_array($cat->slug, array('publikasi', 'pustaka', 'buletin', 'dokumen-strategis', 'kie', 'laporan', 'repositori-pengetahuan', 'materi-pembelajaran'), true)) {
    $is_publikasi_cat = true;
}

if ($is_publikasi_cat) {
    get_template_part('page', 'publikasi');
} else {
    get_template_part('artikel');
}
