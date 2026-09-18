<?php get_header(); ?>


<main>

    <section
        class="position-relative overflow-hidden"
        style="
            height: 450px;
        ">

        <!-- HERO IMAGE -->

        <img
            src="<?php echo esc_url(
                        get_template_directory_uri()
                            . '/assets/images/hero.jpg'
                    ); ?>"
            alt="Guru dan siswa"
            class="position-absolute top-0 start-0 w-100 h-100"
            style="
                object-fit: cover;
            ">


        <!-- OVERLAY -->

        <div
            class="position-absolute top-0 start-0 w-100 h-100"
            style="
                background-color: rgba(0, 0, 0, 0.30);
            "></div>


        <!-- CONTENT -->

        <div
            class="container-fluid px-5 position-relative h-100">

            <div
                class="position-absolute text-white"
                style="
                    left: 50px;
                    bottom: 75px;
                    max-width: 700px;
                ">

                <h1
                    class="fw-bold text-white mb-0"
                    style="
                        font-size: 36px;
                        line-height: 1.15;
                        letter-spacing: -0.5px;
                    ">

                    GURU DI PESISIR BARAT MENYULAP RUANG
                    <br>
                    SEDERHANA MENJADI PERPUSTAKAAN

                </h1>


                <!-- READ MORE -->

                <a
                    href="#"
                    class="text-white text-decoration-none d-inline-flex align-items-center"
                    style="
                        margin-top: 20px;
                        font-size: 10px;
                        font-weight: 600;
                    ">

                    READ MORE

                    <span
                        class="ms-2"
                        style="font-size: 15px;">
                        →
                    </span>

                </a>

            </div>


            <!-- SLIDER INDICATOR -->

            <div
                class="position-absolute d-flex align-items-center"
                style="
                    left: 50px;
                    bottom: 30px;
                    gap: 4px;
                ">

                <span
                    style="
                        width: 25px;
                        height: 6px;
                        border-radius: 5px;
                        background-color: white;
                    "></span>

                <span
                    style="
                        width: 6px;
                        height: 6px;
                        border-radius: 50%;
                        background-color: rgba(255,255,255,.5);
                    "></span>

                <span
                    style="
                        width: 6px;
                        height: 6px;
                        border-radius: 50%;
                        background-color: rgba(255,255,255,.5);
                    "></span>

                <span
                    style="
                        width: 6px;
                        height: 6px;
                        border-radius: 50%;
                        background-color: rgba(255,255,255,.5);
                    "></span>

            </div>

        </div>

    </section>


    <!-- ==========================================
         SECTION BERIKUTNYA
    =========================================== -->

    <section class="container py-5">

        <h2 class="fw-bold">
            Konten berikutnya
        </h2>

        <p class="text-secondary">
            Section ini nanti kita isi berdasarkan desain Figma.
        </p>

    </section>

</main>


<?php get_footer(); ?>