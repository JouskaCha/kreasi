<?php

/**
 * Template Part: Document cards section for the Publikasi page.
 */

$document_image_url = function ($filename, $fallback) {
    $attachments = get_posts(array(
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'     => '_wp_attached_file',
                'value'   => $filename,
                'compare' => 'LIKE',
            ),
        ),
    ));

    if (!empty($attachments)) {
        $image_url = wp_get_attachment_image_url($attachments[0]->ID, 'full');

        if ($image_url) {
            return $image_url;
        }
    }

    $uploads = wp_upload_dir();
    $matches = glob(trailingslashit($uploads['basedir']) . '*/*/' . basename($filename));

    if (!empty($matches)) {
        $base_path = trailingslashit(wp_normalize_path($uploads['basedir']));
        $relative_path = ltrim(str_replace($base_path, '', wp_normalize_path($matches[0])), '/');
        $encoded_path = implode('/', array_map('rawurlencode', explode('/', $relative_path)));

        return trailingslashit($uploads['baseurl']) . $encoded_path;
    }

    return $fallback;
};

$documents = array(
    array(
        'title' => 'Jejak KREASI - April Mei 2026',
        'type'  => 'Buletin',
        'date'  => '26 Juli 2026',
        'image' => $document_image_url('publikasi_dokumen1.png', 'https://images.unsplash.com/photo-1512820790803-83ca734da794?q=85&w=700&auto=format&fit=crop'),
    ),
    array(
        'title' => 'Nota Kesepahaman (MoU) Save the Children dan Kementerian Pendidikan Dasar dan Menengah',
        'type'  => 'Dokumen Strategis',
        'date'  => '26 Juli 2026',
        'image' => $document_image_url('publikasi_dokumen2.png', 'https://images.unsplash.com/photo-1456324504439-367cee3b3c32?q=85&w=700&auto=format&fit=crop'),
    ),
    array(
        'title' => 'Jejak KREASI - Februari Maret 2026',
        'type'  => 'Buletin',
        'date'  => '26 Juli 2026',
        'image' => $document_image_url('publikasi_dokumen3.png', 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=85&w=700&auto=format&fit=crop'),
    ),
    array(
        'title' => '4 Kata Ajaib - Poster KREASI July 2026',
        'type'  => 'KIE',
        'date'  => '26 Juli 2026',
        'image' => $document_image_url('publikasi_dokumen4.png', 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=85&w=700&auto=format&fit=crop'),
    ),
    array(
        'title' => 'Jejak KREASI - Januari 2026',
        'type'  => 'Buletin',
        'date'  => '26 Juli 2026',
        'image' => $document_image_url('publikasi_dokumen5.png', 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?q=85&w=700&auto=format&fit=crop'),
    ),
);
?>

<section class="documents-section" aria-labelledby="documents-title">
    <div class="container px-4 px-lg-5">
        <div class="documents-section__header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h2 id="documents-title" class="documents-section__title mb-0">Dokumen</h2>
            <a class="documents-section__link" href="<?php echo esc_url(home_url('/publikasi/')); ?>">
                Lihat Semua
            </a>
        </div>

        <div class="documents-scroller" role="list">
            <?php foreach ($documents as $document) : ?>
                <article class="document-card" role="listitem">
                    <a class="document-card__media" href="<?php echo esc_url(home_url('/publikasi/')); ?>">
                        <img src="<?php echo esc_url($document['image']); ?>" alt="<?php echo esc_attr($document['title']); ?>" loading="lazy">
                    </a>
                    <div class="document-card__meta">
                        <span class="document-card__tag"><i class="bi bi-folder2-open" aria-hidden="true"></i><?php echo esc_html($document['type']); ?></span>
                        <time datetime="2026-07-26"><i class="bi bi-calendar3" aria-hidden="true"></i><?php echo esc_html($document['date']); ?></time>
                    </div>
                    <h3 class="document-card__title">
                        <a href="<?php echo esc_url(home_url('/publikasi/')); ?>"><?php echo esc_html($document['title']); ?></a>
                    </h3>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>