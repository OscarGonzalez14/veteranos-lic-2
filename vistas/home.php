<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["usuario"])){

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
<?php require_once("links_plugin.php"); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<!-- top-bar -->
  <?php require_once('top_menu.php')?>
  <!-- /.top-bar -->

  <!-- Main Sidebar Container -->
  <?php require_once('side_bar.php')?>
  <!--End SideBar Container-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="backgroud:white !important">
    <!-- Content Header (Page header) -->
    <div class="content-header" style="">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <b><h5 style="text-transform: uppercase;text-align: center;font-size: 25px;font-family: Helvetica, Arial, sans-serif;" >BIENVENID@: &nbsp;<?php echo $_SESSION["usuario"];?></h5></b>
      <div style="margin-top:0px;">        
      <img src="../dist/img/inabve.jpg" alt="" class="img-responsive log" width="650" height="475" align="center" style="margin-top: 15px !important">
      <img src="../dist/img/logo_avplus.jpg" alt="" class="img-responsive log" width="650" height="350" align="center" >
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>2021 Lenti || <b>Version</b> 1.0</strong>
     &nbsp;All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<?php require_once("links_js.php"); ?>
</body>
</html>
<?php } else{
echo "Acceso no permitido";
  } ?>
