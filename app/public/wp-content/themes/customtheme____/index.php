<?php get_header(); ?>

<main class="container py-5">

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <article class="mb-5">

                <h1 class="fw-bold mb-4">
                    <?php the_title(); ?>
                </h1>

                <div>
                    <?php the_content(); ?>
                </div>

            </article>

        <?php endwhile; ?>

    <?php else : ?>

        <p>
            Tidak ada konten.
        </p>

    <?php endif; ?>

</main>

<?php get_footer(); ?>