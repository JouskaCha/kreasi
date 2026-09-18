<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title('|', true, 'right'); ?></title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <?php wp_head(); ?>

</head>

<body <?php body_class('bg-white'); ?>>

    <?php wp_body_open(); ?>


    <!-- =====================================================
     HEADER
====================================================== -->

    <header class="bg-white">

        <!-- TOP HEADER -->
        <div
            class="container-fluid px-4"
            style="height: 50px;">

            <div
                class="d-flex justify-content-between align-items-center h-100">

                <!-- LOGO KREASI -->

                <a
                    href="<?php echo esc_url(home_url('/')); ?>"
                    class="d-block">

                    <img
                        src="<?php echo esc_url(
                                    get_template_directory_uri()
                                        . '/assets/images/logo-kreasi.png'
                                ); ?>"
                        alt="KREASI"
                        style="
                        width: 75px;
                        height: auto;
                        display: block;
                    ">

                </a>


                <!-- PARTNER LOGOS -->

                <div
                    class="d-flex align-items-center"
                    style="gap: 8px;">

                    <img
                        src="<?php echo esc_url(
                                    get_template_directory_uri()
                                        . '/assets/images/logo-partner-1.png'
                                ); ?>"
                        alt="Partner"
                        style="
                        width: 75px;
                        max-height: 36px;
                        object-fit: contain;
                    ">

                    <img
                        src="<?php echo esc_url(
                                    get_template_directory_uri()
                                        . '/assets/images/logo-partner-2.png'
                                ); ?>"
                        alt="Partner"
                        style="
                        width: 75px;
                        max-height: 36px;
                        object-fit: contain;
                    ">

                    <img
                        src="<?php echo esc_url(
                                    get_template_directory_uri()
                                        . '/assets/images/logo-partner-3.png'
                                ); ?>"
                        alt="Partner"
                        style="
                        width: 75px;
                        max-height: 36px;
                        object-fit: contain;
                    ">

                    <img
                        src="<?php echo esc_url(
                                    get_template_directory_uri()
                                        . '/assets/images/logo-save-the-children.png'
                                ); ?>"
                        alt="Save the Children"
                        style="
                        width: 75px;
                        max-height: 36px;
                        object-fit: contain;
                    ">

                </div>

            </div>

        </div>


        <!-- BLUE LINE -->

        <div
            class="w-100"
            style="
            height: 2px;
            background-color: #168be8;
        "></div>


        <!-- BOTTOM HEADER -->

        <div
            class="container-fluid px-4"
            style="height: 35px;">

            <div
                class="d-flex justify-content-between align-items-center h-100">

                <!-- NAVIGATION -->

                <nav
                    class="d-flex align-items-center"
                    style="gap: 8px;">

                    <a
                        href="<?php echo esc_url(home_url('/tentang-kami')); ?>"
                        class="d-flex align-items-center justify-content-center text-decoration-none"
                        style="
                        height: 27px;
                        padding: 0 12px;
                        border-radius: 15px;
                        background-color: #f1f3f7;
                        color: #163d6b;
                        font-size: 10px;
                        font-weight: 600;
                    ">
                        TENTANG KAMI
                    </a>


                    <a
                        href="<?php echo esc_url(home_url('/artikel')); ?>"
                        class="d-flex align-items-center justify-content-center text-decoration-none"
                        style="
                        height: 27px;
                        padding: 0 12px;
                        border-radius: 15px;
                        background-color: #f1f3f7;
                        color: #163d6b;
                        font-size: 10px;
                        font-weight: 600;
                    ">
                        ARTIKEL
                    </a>


                    <a
                        href="<?php echo esc_url(home_url('/pustaka')); ?>"
                        class="d-flex align-items-center justify-content-center text-decoration-none"
                        style="
                        height: 27px;
                        padding: 0 12px;
                        border-radius: 15px;
                        background-color: #f1f3f7;
                        color: #163d6b;
                        font-size: 10px;
                        font-weight: 600;
                    ">
                        PUSTAKA
                    </a>

                </nav>


                <!-- RIGHT -->

                <div
                    class="d-flex align-items-center"
                    style="gap: 10px;">

                    <!-- SEARCH -->

                    <form
                        method="get"
                        action="<?php echo esc_url(home_url('/')); ?>"
                        class="d-flex align-items-center"
                        style="
                        width: 165px;
                        height: 25px;
                        padding: 0 10px;
                        border-radius: 14px;
                        background-color: #f2f3f5;
                    ">

                        <span
                            style="
                            font-size: 9px;
                            color: #aaa;
                            margin-right: 5px;
                        ">
                            🔍
                        </span>

                        <input
                            type="search"
                            name="s"
                            value="<?php echo esc_attr(get_search_query()); ?>"
                            placeholder="CARI"
                            class="border-0 bg-transparent w-100"
                            style="
                            outline: none;
                            font-size: 9px;
                            color: #555;
                        ">

                    </form>


                    <!-- LANGUAGE -->

                    <div
                        class="d-flex align-items-center"
                        style="gap: 5px;">

                        <a
                            href="#"
                            class="d-flex align-items-center justify-content-center text-decoration-none"
                            style="
                            width: 20px;
                            height: 20px;
                            border-radius: 50%;
                            background-color: #e52d2d;
                            color: white;
                            font-size: 9px;
                            font-weight: 600;
                        ">
                            IN
                        </a>

                        <a
                            href="#"
                            class="d-flex align-items-center justify-content-center text-decoration-none"
                            style="
                            width: 20px;
                            height: 20px;
                            color: #aaa;
                            font-size: 9px;
                            font-weight: 600;
                        ">
                            EN
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </header>