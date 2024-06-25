<header class="header-v4">
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

        <div class="wrap-menu-desktop how-shadow1">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="<?= base_url() ?>" class="logo">
                    <img src="<?= base_url() ?>assets/extra-assets/logo/output-onlinepngtools.png" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li>
                            <a href="<?= base_url() ?>">PeazzyStore</a>

                        </li>

                        <li>
                            <a href="product.html">Produk</a>
                        </li>

                        <li>
                            <a href="shoping-cart.html">Kategori</a>
                        </li>

                        <li>
                            <a href="blog.html">Blog</a>
                        </li>

                        <li>
                            <a href="about.html">Kontak</a>
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
                            id="cart-counter" data-notify="<?= get_cart_count() ?>">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </a>

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
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" id="cart-counter"
                    data-notify="<?= get_cart_count() ?>">
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
            <li>
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
            </li>
        </ul>

        <ul class="main-menu-m">
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