<!-- Header -->
<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">

                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        Bantuan
                    </a>

                    <?php if ($this->user_auth->check()) : ?>
                    <a href="<?= base_url('user/dashboarduser') ?>" role="button" id="user-name-trigger"
                        class="flex-c-m trans-04 p-lr-25">
                        <?= $this->session->userdata('username') ?>

                    </a>

                    <?php else : ?>
                    <a href="#" role="button" class="flex-c-m trans-04 p-lr-25">
                        Guest
                    </a>

                    <?php endif; ?>

                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        ID
                    </a>


                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="#" class="logo">
                    <img src="<?= base_url() ?>assets/extra-assets/logo/output-onlinepngtools.png" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu">
                            <a href="<?= base_url() ?>">PeazzyStore</a>
                        </li>

                        <li>
                            <a href="product.html">Produk</a>
                        </li>
                        <li>
                            <a href="blog.html">Kategori</a>
                        </li>

                        <li>
                            <a href="about.html">Blog</a>
                        </li>

                        <li>
                            <a href="contact.html">Kontak</a>
                        </li>

                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <a href="<?= base_url('cart') ?>">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                            data-notify="<?= get_cart_count() ?>" id="cart-counter">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </a>
                    <div class="user-profile d-flex ml-3 g-4">
                        <?php if ($this->user_auth->check() == false) : ?>
                        <button class="btn btn-primary btn-md"><a class="text-white"
                                href="<?= base_url('auth/registration') ?>">Daftar</a> |
                            <a href="<?= base_url('auth/login') ?>" class="text-white">Masuk</a></button>
                        <?php else :  ?>
                        <a href="<?= base_url('user/dashboarduser') ?>" style="text-decoration: none;">

                            <i class="fa fa-user fs-20 mr-2"></i>
                            <span class="user-name"><?= get_user()->username ?></span>
                        </a>

                        <?php endif; ?>

                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/extra-assets/logo/output-onlinepngtools.png"
                    alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>
            <a href="<?= base_url('cart') ?>">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                    data-notify="<?= get_cart_count() ?>" id="cart-counter">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
            </a>



        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <div class="left-top-bar">

            </div>

            <div class="right-top-bar flex-w h-full">
                <a href="#" class="flex-c-m trans-04 p-lr-25">
                    Bantuan
                </a>

                <a href="#" class="flex-c-m trans-04 p-lr-25">
                    Akun Saya
                </a>

                <a href="#" class="flex-c-m trans-04 p-lr-25">
                    ID
                </a>


            </div>
        </ul>

        <ul class="main-menu-m">
            <li class="active-menu">
                <a href="<?= base_url() ?>">Home</a>

            </li>

            <li>
                <a href="product.html">Produk</a>
            </li>

            <li>
                <a href="blog.html">Kategori</a>
            </li>

            <li>
                <a href="about.html">Blog</a>
            </li>

            <li>
                <a href="contact.html">Kontak</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="<?= base_url() ?>assets/frontend/images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>