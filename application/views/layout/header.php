<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?= $deskripsi ?>">
  <meta name="author" content="<?= $judul ?>">

  <title><?= $judul . ' - ' . $deskripsi ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/admin/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/admin/') ?>css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Jquery UI -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>css/jquery-ui.min.css">

  <!-- Custom styles for this page -->
  <link href="<?= base_url('assets/admin/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url('assets/admin/js/datetimepicker/jquery.datetimepicker.css') ?>">

  <!-- My CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>css/style.css">

  <script>
    const site_url = '<?= base_url('') ?>'
    const lang = <?= json_encode($this->lang->language) ?>
  </script>

</head>

<body id="page-top">