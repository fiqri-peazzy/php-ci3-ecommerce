<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <a href="product.html" class="stext-109 cl8 hov-cl1 trans-04">
            User
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Dashboard User
        </span>
    </div>
</div>
<section class=" bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light">

                    <div class="d-flex flex-row">
                        <div class="img-holder mr-2">
                            <img id="user_picture" class="img-thumbnail m-auto flex-row flex-t"
                                src="<?= get_user()->picture == null ? base_url() . 'assets/extra-assets/default-avatar.jpg' : base_url() . 'uploads/users/' . get_user()->picture ?>"
                                width="50" height="50" alt="">
                        </div>
                        <div class="info-profile ml-3 flex-col flex-c-t">
                            <div class="username flex-l flex-t"><?= get_user()->username ?></div>
                            <div class="flex-b flex-r">
                                <a class="btn-edit-profile" href="#">
                                    <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-right: 4px;">
                                        <path
                                            d="M8.54 0L6.987 1.56l3.46 3.48L12 3.48M0 8.52l.073 3.428L3.46 12l6.21-6.18-3.46-3.48"
                                            fill="#9B9B9B" fill-rule="evenodd">
                                        </path>
                                    </svg>
                                    Ubah Profil

                                </a>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" aria-current="page">
                                <i class="fa fa-user"></i>
                                Profil Saya
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">

                                Pesanan Saya
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark">
                                Ubah Password
                            </a>
                        </li>

                        <hr>
                        <li>
                            <a href="<?= base_url('auth/logout') ?>" class="nav-link link-dark">

                                Log Out
                            </a>
                        </li>
                    </ul>


                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-box">
                    <div class="card-header">
                        <h5>Profile Saya</h5>
                        <small class="text-muted">
                            Kelola informasi profil Anda untuk mengontrol, melindungi dan
                            mengamankan akun
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="p-4">

                            <div class="row">

                                <div class="col-md-8">
                                    <form action="<?= base_url('user/updateUserProfile') ?>" method="post"
                                        id="user_profile_form_u">
                                        <div class="form-group">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" value="<?= get_user()->username ?>"
                                                class="form-control">
                                            <span class="error-text text-danger username_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="name" value="<?= get_user()->name ?>"
                                                class="form-control">
                                            <span class="error-text text-danger name_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" name="email" value="<?= get_user()->email ?>"
                                                class="form-control">
                                            <span class="error-text text-danger email_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Nomor Telepon</label>
                                            <input type="text" name="phone" value="<?= get_user()->phone ?>"
                                                class="form-control">
                                            <span class="error-text text-danger phone_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Alamat</label>
                                            <textarea name="alamat" id="" placeholder="Masukan Alamat Lengkap" cols="30"
                                                rows="5" class="form-control"><?= get_user()->alamat ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-4">
                                    <div class="flex-w flex-col flex-c-m text-center">
                                        <div class="TJWfNh">
                                            <div class="flex-w flex-c-m mb-3" role="header">
                                                <div class="user-profile-img">
                                                    <img id="profile-picture"
                                                        class="img-thumbnail m-auto flex-row flex-t"
                                                        src="<?= get_user()->picture == null ? base_url() . 'assets/extra-assets/default-avatar.jpg' : base_url() . 'uploads/users/' . get_user()->picture ?>"
                                                        alt="">
                                                </div>
                                            </div>
                                            <form id="form_profile_pict" enctype="multipart/form-data" method="post">
                                                <input class="user-profile-pict-file d-none" id="user-profile-pict-file"
                                                    name="profile_pict" type="file" accept=".jpg,.jpeg,.png">
                                                <button type="button"
                                                    onclick="event.preventDefault();document.getElementById('user-profile-pict-file').click();"
                                                    class="btn btn-success mb-2 btn--m btn--inline">Pilih
                                                    gambar
                                                </button>
                                            </form>

                                            <div class="T_8sqN">
                                                <div class="JIExfq text-muted">Ukuran gambar: maks. 1 MB</div>
                                                <div class="JIExfq text-muted">Format gambar: .JPEG, .PNG</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">
                            Semua
                        </button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                            type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                            Tertunda
                        </button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                            type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                            Selesai
                        </button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="p-4">
                            semua
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="p-4">
                            tunda
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="p-4">
                            selesa
                        </div>
                    </div>
                </div> -->
            </div>
        </div>


    </div>
</section>