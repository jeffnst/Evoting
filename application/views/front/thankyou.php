<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="refresh" content="3;url=<?php echo base_url(); ?>" />
  <title>e-VOTING | SMA YPSA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url() ;?>aset/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ;?>aset/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ;?>aset/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ;?>aset/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url() ;?>aset/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('aset/plugins/sweetalert/sweetalert.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand"><b>SMA</b>&nbsp; YPSA</a>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->

        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->

        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Halaman Voting
          <small></small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">

        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Successful Terima Kasih Telah Melakukan Pemilihan</h3>
          </div>

          <!-- /.box-body -->
        </div>

        
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2016 <a href="#">Hendrawan Sucipto</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url() ;?>aset/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('aset/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url() ;?>aset/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ;?>aset/dist/js/app.min.js"></script>
<script type="text/javascript">
$('#pilih').on('click',function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    swal({
        title: "Yakin Mau Nyimpan?",
        text: "udah pas blom datanya....?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Udah, Lanjut Gan...",
        cancelButtonText: "blom, Gan..",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function(isConfirm){
        if (isConfirm) 
        { window.location.href = href;

       }
      else {
      swal("Ga jadi disimpan", "OK, Lanjut nginput lagi gan", "error");
       }
    });
})
</script>
</html>
