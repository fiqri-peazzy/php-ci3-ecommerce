<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Admin Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">

                <form action="<?= base_url('admin/updateprofilepicture') ?>" enctype="multipart/form-data"
                    id="form_user_profile_file" method="post">
                    <a href="javascript:;"
                        onclick="event.preventDefault();document.getElementById('user_profile_file').click();"
                        class="edit-avatar"><i class="fa fa-pencil"></i></a>
                    <input type="file" name="user_profile_file" id="user_profile_file" class="d-none"
                        style="opacity: 0;">
                </form>

                <img src="<?= get_user()->picture == null ? base_url() . 'assets/backend/vendors/images/photo1.jpg' : base_url() . 'uploads/users/' . get_user()->picture ?>"
                    alt="" class="avatar-photo ci-avatar-photo">
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body pd-5">
                                <div class="img-container">
                                    <img id="image" src="vendors/images/photo2.jpg" alt="Picture">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" value="Update" class="btn btn-primary">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="text-center h5 mb-0 user-name"><?= get_user()->username ?></h5>
            <p class="text-center text-muted user-email font-14">
                <?= get_user()->email ?>
            </p>
            <p class="user-phone text-center text-muted font-14 mt-0 p-0"><?= get_user()->phone ?></p>

        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal_details" role="tab">Info
                                Pribadi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Ubah Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- personal_details Tab start -->
                        <div class="tab-pane fade show active" id="personal_details" role="tabpanel">
                            <div class="pd-20">
                                <form action="<?= base_url('admin/updatepersonaldetails') ?>" method="post"
                                    id="update_personal_details">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="form-label">Nama Lengkap</label>
                                                <input type="text" name="name" value="<?=
                                                                                        get_user()->name;
                                                                                        ?>" class="form-control">
                                                <span class="error-text text-danger name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="form-label">Username</label>
                                                <input type="text" name="username" class="form-control" value="<?=
                                                                                                                get_user()->username;
                                                                                                                ?>">
                                                <span class="error-text text-danger username_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="form-label">Email</label>
                                                <input type="text" name="email" id="" class="form-control"
                                                    value="<?=
                                                                                                                    get_user()->email;
                                                                                                                    ?>">
                                                <span class="text-danger error-text email_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="" class="form-label">No Telepon</label>
                                                <input type="text" name="phone" id="" class="form-control"
                                                    value="<?=
                                                                                                                    get_user()->phone;
                                                                                                                    ?>">
                                                <span class="text-danger error-text phone_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- personal_details Tab End -->
                        <!-- change_password Tab start -->
                        <div class="tab-pane fade" id="change_password" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                                tab change password
                            </div>
                        </div>
                        <!-- change_password Tab End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>