<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISTEMA ANDRES</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/daterangepicker/daterangepicker.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/datatables/css/responsive.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>dist/css/adminlte.min.css">
  <!-- Morris -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/morris/morris.css">
  <!-- CHART-CSS -->
  <link rel="stylesheet" href="<?php echo PUBLIC_C ?>plugins/chart.js/Chart.min.css">
   
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<!-- sidebar-collapse -->
 
<body class="hold-transition  sidebar-mini layout-fixed <?php echo (METHOD.CONTROLLER == 'indexhome')?  'login-page':'' ?> ">
  
  <style>
  .labelpe{
    font-weight: normal !important;
    font-size: 15px;
  }
  .pace {
  -webkit-pointer-events: none;
  pointer-events: none;

  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

.pace-inactive {
  display: none;
}

.pace .pace-progress {
  background: #161616;
  position: fixed;
  z-index: 2000;
  top: 0;
  right: 100%;
  width: 100%;
  height: 4px;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

input[type=number] { -moz-appearance:textfield; }
   
  </style>

<div id="app" class="<?php  echo (METHOD.CONTROLLER == 'indexhome')?  'login-box ':'wrapper' ?>">


