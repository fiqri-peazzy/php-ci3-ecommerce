<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title><?= $title ?></title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?= base_url() ?>assets/backend/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="<?= base_url() ?>assets/backend/vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?= base_url() ?>assets/backend/vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/backend/src/plugins/jquery-steps/jquery.steps.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/vendors/styles/style.css" />
    <style>
    .form-control input[type="text"] {
        border-radius: 50px !important;
    }
    </style>

</head>

<body class="login-page">
    <div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-6">
                    <img src="<?= base_url() ?>assets/backend/vendors/images/register-page-img.png" alt="">
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login-box bg-white box-shadow border-radius-10"
                        style="max-width: 600px !important;padding:40px 50px !important">
                        <div class="login-title">
                            <h2 class="text-center text-primary mb-2">Buat Akun baru</h2>
                        </div>
                        <?php if (!empty($this->session->flashData('success'))) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashData('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($this->session->flashData('fail'))) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashData('fail') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <form action="<?= base_url('auth/registration') ?>" method="post">
                            <div class="form-row">
                                <div class="col-lg-6 form-group">
                                    <label for="" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" value="<?= set_value('name') ?>"
                                        placeholder="Nama Lengkap">
                                    <?= form_error('name', '<span class="text-danger error-text">', '</span>') ?>

                                </div>
                                <div class="col-lg-6 form-group">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username"
                                        value="<?= set_value('username') ?>" placeholder="Username">
                                    <?= form_error('username', '<span class="text-danger error-text">', '</span>') ?>


                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 form-group">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email"
                                        value="<?= set_value('email') ?>" placeholder="Email">
                                    <?= form_error('email', '<span class="text-danger error-text">', '</span>') ?>


                                </div>
                                <div class="col-lg-6 form-group">
                                    <label for="" class="form-label">No Telepon</label>
                                    <input type="text" class="form-control" value="<?= set_value('phone') ?>"
                                        name="phone" placeholder="No Telepon">
                                    <?= form_error('phone', '<span class="text-danger error-text">', '</span>') ?>


                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 form-group">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" name="password" placeholder="password"
                                        value="<?= set_value('password') ?>" class="form-control">
                                    <?= form_error('password', '<span class="text-danger error-text">', '</span>') ?>


                                </div>
                                <div class="col-lg-6 form-group">
                                    <label for="" class="form-label">konfirmasi Password</label>
                                    <input type="password" name="conf_password"
                                        value="<?= set_value('conf_password') ?>" placeholder="konfirmasi password"
                                        class="form-control">
                                    <?= form_error('conf_password', '<span class="text-danger error-text">', '</span>') ?>


                                </div>
                            </div>
                            <div class="row form-group d-flex align-items-center flex-wrap justify-content-center mt-2">

                                <div class="col-sm-5">
                                    <div class="input-group mb-3">
                                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Daftar">


                                    </div>
                                    <div class="input-group mb-0">
                                        <span class="text-secondary">Sudah Punya Akun ? <a
                                                href="<?= base_url('auth/login') ?>"
                                                class="text-primary">Login</a></span>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/core.js"></script>
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/script.min.js"></script>
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/process.js"></script>
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/layout-settings.js"></script>
    <script src="src/plugins/jquery-steps/jquery.steps.js"></script>
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/steps-setting.js"></script>

</body>

</html>