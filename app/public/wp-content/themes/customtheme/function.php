<?php

function kreasi_theme_setup()
{
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    register_nav_menus(
        array(
            'primary' => 'Primary Menu',
        )
    );
}

add_action(
    'after_setup_theme',
    'kreasi_theme_setup'
);
