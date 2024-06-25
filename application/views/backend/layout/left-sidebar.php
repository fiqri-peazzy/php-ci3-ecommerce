<div class="left-side-bar">
    <div class="brand-logo">
        <a href="">
            <img src="<?= base_url() ?>assets/extra-assets/logo/output-onlinepngtools.png" alt="" class="dark-logo" />

        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house"></span><span class="mtext">Home</span>
                    </a>

                </li>
                <li class="dropdown">
                    <a href="<?= base_url('admin/category') ?>" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-list"></span><span class="mtext">Kategori</span>
                    </a>

                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-table"></span><span class="mtext">Produk</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('admin/getallproduct') ?>">Semua Produk</a></li>
                        <li><a href="<?= base_url('admin/addproduct') ?>">Tambah Produk</a></li>
                        <li><a href="<?= base_url('admin/productvariations') ?>">Variasi Produk</a></li>
                    </ul>
                </li>

                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">Auth</div>
                </li>
                <li>
                    <a href="<?= base_url('admin/profile') ?>" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-user"></span><span class="mtext">Profile</span>
                    </a>

                </li>

                <li>
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-settings"></span><span class="mtext">Lainnya</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="basic-table.html">Pengaturan</a></li>
                        <li><a href="<?= base_url('admin/manageUser') ?>">User</a></li>
                    </ul>

                </li>

            </ul>
        </div>
    </div>
</div>