<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title><?php $title ?></title>

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
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/vendors/styles/style.css" />

</head>

<body>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="<?= base_url() ?>assets/backend/vendors/images/forgot-password.png" alt="" />
                </div>
                <div class="col-md-6">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Lupa Password</h2>
                        </div>
                        <?php if (!empty($this->session->flashdata('fail'))) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('fail') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($this->session->flashdata('success'))) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <h6 class="mb-20">
                            Masukan Email untuk reset password anda
                        </h6>
                        <form action="<?= base_url('auth/forgotpassword') ?>" method="post">
                            <div class="input-group custom">
                                <input type="text" value="<?= set_value('email') ?>"
                                    class="form-control form-control-lg" value="<?= set_value('email') ?>" name="email"
                                    placeholder="Email" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fa fa-envelope-o"
                                            aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <?= form_error('email', '<div class="d-block text-danger mb-3">', '</div>') ?>
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <div class="input-group mb-0">
                                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="font-16 weight-600 text-center" data-color="#707373">
                                        OR
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group mb-0">
                                        <a class="btn btn-outline-primary btn-lg btn-block"
                                            href="<?= base_url('auth/login') ?>">Login</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- welcome modal end -->
    <!-- js -->
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/core.js"></script>
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/script.min.js"></script>
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/process.js"></script>
    <script src="<?= base_url() ?>assets/backend/vendors/scripts/layout-settings.js"></script>
</body>

</html>