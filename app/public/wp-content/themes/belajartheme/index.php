<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="site-header">
        <h1 class="site-title">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a>
        </h1>
        <a href="<?php echo esc_url(get_theme_file_uri('hehe.php')); ?>">Buka halaman hehe.php</a>
    </header>
    <main class="site-main">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('post'); ?>>
                    <h2 class="post-title">
                        <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e('Belum ada konten.', 'belajartheme'); ?></p>
        <?php endif; ?>
    </main>
    <footer class="site-footer">
        <p><?php echo esc_html(get_bloginfo('name')); ?> &copy; <?php echo esc_html(wp_date('Y')); ?></p>
    </footer>
    <?php wp_footer(); ?>
</body>

</html>