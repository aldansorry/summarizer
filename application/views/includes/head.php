<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Peringkasan Berita">
  <meta name="author" content="aldansorry">
  <link rel="icon" href="<?php echo base_url("assets/img/newspaper-regular.ico") ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo base_url("assets/img/newspaper-regular.ico") ?>" type="image/x-icon" />

  <title><?php echo $title ?> - Summarizer</title>

  <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- datatables -->
  <link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
  <!-- sweetalert2 -->
  <link href="<?= base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- dropify -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">

  <!-- daterangepicker -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">


  <style>
    .loading-ico {
      display: none;
    }

    .btn-loading.disabled .loading-ico {
      display: inline-block;
    }

    .btn.disabled {
      pointer-events: none;
    }

    .btn-loading.disabled span {
      display: none;
    }

    .btn-loading.disabled:after {
      content: " Searching";
    }


    .dt-buttons {
      float: left;
    }

    .th-sticky {
      position: sticky;
      width: 10px;
      left: 0px;
      background-color: #fff !important;
    }

    .preloader {
      display: none;
      width: calc(100% - 14rem);
      left: 14rem;
      height: calc(100% - 4.375rem);
      position: absolute;
      background-color: #4e73df;
      opacity: 0.5;
      z-index: 1059;
    }

    .lds-dual-ring {
      display: inline-block;
      width: 80px;
      height: 80px;
      position: absolute;
      top: 20rem;
      left: 45%;
    }

    .lds-dual-ring:after {
      content: " ";
      display: block;
      width: 64px;
      height: 64px;
      margin: 8px;
      border-radius: 50%;
      border: 6px solid #fff;
      border-color: #fff transparent #fff transparent;
      animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .table-y-scroll {
      position: relative;
      height: 50vh;
      overflow: auto;
    }

    .img-hover {
      border-radius: 5px;
    }

    .img-hover:hover {

      box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, .25);
    }

    td.wrapok {
      white-space: normal !important;
    }

    .btn-chart-toggle label.active {
      pointer-events: none;
    }

    .loading-bar {
      display: none;
      width: 100%;
      height: 5px;
      position: fixed;
      overflow: hidden;
      z-index: 1340;
    }

    .loading-bar:before {
      display: block;
      position: absolute;
      content: "";
      left: -200px;
      width: 200px;
      height: 5px;
      background-color: #4e73df;
      -webkit-animation: loading 1s linear infinite;
      animation: loading 1s linear infinite;
    }

    @-webkit-keyframes loading {
      from {
        left: -200px;
        width: 30%;
      }

      50% {
        width: 30%;
      }

      70% {
        width: 70%;
      }

      80% {
        left: 50%;
      }

      95% {
        left: 120%;
      }

      to {
        left: 100%;
      }
    }

    @-webkit-keyframes loading {
      from {
        left: -200px;
        width: 30%;
      }

      50% {
        width: 30%;
      }

      70% {
        width: 70%;
      }

      80% {
        left: 50%;
      }

      95% {
        left: 120%;
      }

      to {
        left: 100%;
      }
    }

    .btn-filter-sumber .btn:not(.active) {
      background-color: #ddd;
      color: #000;
    }
  </style>

</head>