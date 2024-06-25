<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= isset($title)  ? $title : 'New Page Title' ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/extra-assets/logo/icon-title.png" />
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/frontend/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/frontend/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/frontend/vendor/slick/slick.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/vendor/MagnificPopup/magnific-popup.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/frontend/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/frontend/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/frontend/css/main.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/backend/src/plugins/toastr/toastr.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/map/leaflet.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/extra-assets/jquery-ui-1.13.3/jquery-ui.theme.min.css">

    <style>
    * {
        text-decoration: none !important;
    }

    .empty-cart {
        background-image: url('<?= base_url() ?>assets/frontend/images/empty-cart.png');
        background-position: 50%;
        background-repeat: no-repeat;
        background-size: cover;
        height: 11.1875rem;
        width: 12.5rem;
    }

    .ui-autocomplete {
        z-index: 1000;
        background-color: #fff;

        border: 1px solid #ccc;

        max-height: 200px;

        overflow-y: auto;

        overflow-x: hidden;

    }

    #map-container {
        position: relative;
        z-index: 1;

    }

    #map {
        position: relative;
        z-index: 0;

    }
    </style>
</head>

<body class="animsition">