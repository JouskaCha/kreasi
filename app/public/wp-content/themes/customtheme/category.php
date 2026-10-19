<?php
/**
 * The category archive template.
 * Routes publication categories to page-pustaka.php (Versi 2)
 * and article categories to artikel.php.
 *
 * @package kreasi_redesign_2026
 */

$cat = get_queried_object();
$pub_cat_ids = function_exists('kreasi_get_publikasi_category_ids') ? kreasi_get_publikasi_category_ids() : array();

$is_publikasi_cat = false;
if ($cat && !empty($pub_cat_ids)) {
    if (in_array($cat->term_id, $pub_cat_ids, true) || in_array($cat->parent, $pub_cat_ids, true)) {
        $is_publikasi_cat = true;
    }
}

if ($is_publikasi_cat) {
    get_template_part('page-pustaka');
} else {
    get_template_part('artikel');
}
