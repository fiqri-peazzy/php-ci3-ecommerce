<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title><?= isset($title) ? $title : 'New Page Title' ?></title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?= base_url() ?>assets/backend/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/extra-assets/logo/icon-title.png" />


    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/backend/vendors/styles/style.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/backend/src/plugins/toastr/toastr.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/backend/src/plugins/ijabo/ijaboCropTool.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/backend/src/plugins/sweetalert2/sweetalert2.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.theme.min.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>assets/backend/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css">

</head>

<body>