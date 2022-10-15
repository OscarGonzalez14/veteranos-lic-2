<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["usuario"])){
$categoria_usuario = $_SESSION["categoria"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventarios-Vet</title>
<?php require_once("links_plugin.php"); 
 require_once('../modelos/Orders.php');
 $ordenes = new Ordenes();
 //$suc = $ordenes->get_opticas();
 require_once('../modales/nueva_orden_lab.php');

 require_once('../modales/aros_en_orden.php');

 ?>
<style>
  .buttons-excel{
      background-color: green !important;
      margin: 2px;
      max-width: 150px;
  }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style='font-family: Helvetica, Arial, sans-serif;'>
<div class="wrapper">
<!-- top-bar -->
  <?php require_once('top_menu.php')?>
  <!-- /.top-bar -->

  <!-- Main Sidebar Container -->
  <?php require_once('side_bar.php')?>
  <!--End SideBar Container-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
    <div style="margin: 0px">
	  <div class="callout callout-info">
        <h5 align="center" style="margin:0px"><i class="fas fa-glasses" style="color:green"></i> <strong>BODEGA CENTRAL</strong></h5>
      <?php include 'ordenes/nav-inventarios.php'?>
    </div>
    </div>
    <div class="row">
          <div class="col-md-6" style="max-height: 200px">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-glasses"></i>
                  AROS
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="margin: 0px !important; padding: 2px">

              <table width="100%" class="table-bordered table-hover"  id="aros_creados" data-order='[[ 0, "desc" ]]'>
              <thead style="color:white;font-family: Helvetica, Arial, sans-serif;font-size: 13px;text-align: center" class='bg-info'>
                <tr>
                <th style="width:5%">ID</th>
                <th style="width:23%">Marca</th>
                <th style="width:23%">Modelo</th>
                <th style="width:18%">Color</th>
                <th style="width:23%">Material</th>
                <th style="width:8%">Agregar</th>
                </tr>
              </thead>
              <tbody style="font-family: Helvetica, Arial, sans-serif;font-size: 11px;text-align: center;">                                  
              </tbody>
        </table>
  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.COLUMNA DE AROS -->

          <div class="col-md-6" style="max-height: 200px">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-dolly"></i>
                   INGRESOS A BODEGAS &nbsp;&nbsp;&nbsp;&nbsp; <b><span id="count-aros" align="center" style="text-align:center;color:green"></span></b>
                </h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body" style="margin: 0px !important; padding: 2px">
              <button type="button" class="btn btn-sm btn-outline-primary btn-flat float-right" onClick="enviarArosSucursalLote()" style="margin:6px"><i class="fas fa-dolly"></i> Enviar a sucursal</button>
              <table width="100%" class="table-bordered table-hover"  id="aros_creados" data-order='[[ 0, "desc" ]]' style="margin-top:8px;text-transform:uppercase">
              <thead style="color:white;font-family: Helvetica, Arial, sans-serif;font-size: 13px;text-align: center" class='bg-dark'>
                <tr>
                <th style="width:20%">Marca</th>
                <th style="width:20%">Modelo</th>
                <th style="width:18%">Color</th>
                <th style="width:23%">Material</th>
                <th style="width:11%">Cant</th>
                <th style="width:8%">Elim.</th>
                </tr>
              </thead>
              <tbody style="font-family: Helvetica, Arial, sans-serif;font-size: 11px;text-align: center;" id="aros-enviar-bodega">                                  
              </tbody>
        </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.COLUMNA DE INGRESOS A BODEGA -->
</div>
    </section>
    <!-- /.content -->
  </div>

  <input type="hidden" value="<?php echo $categoria_usuario;?>" id="cat_users">

   <!--Modal Imagen Aro-->
   <div class="modal" id="imagen_aro_order">
    <div class="modal-dialog" style="max-width: 45%">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div style="  background-size: cover;background-position: center;display:flex;align-items: center;">
            <img src="" alt="" id="imagen_aro_ord" style="width: 100%;border-radius: 8px;">
          </div>          
        </div>        
   
      </div>
    </div>
  </div>
  <?php
require_once('../modales/nuevo_aro.php');
//require_once('../modales/nueva_marca.php');
?>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>2021 Lenti || <b>Version</b> 1.0</strong>
     &nbsp;All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer>
</div>


<!-- ./wrapper -->
<?php 
require_once("links_js.php");
?>
<script>
      $(function () {
    //Initialize Select2 Elements
    $('#marca_aros').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $("#marca_aros").select2({
        maximumSelectionLength: 1
    });

 
    })
</script>
<script type="text/javascript" src="../js/ordenes.js"></script>
<script type="text/javascript" src="../js/productos.js"></script>
<script type="text/javascript" src="../js/cleave.js"></script>
<script>
  var dui = new Cleave('#dui_pac', {
  delimiter: '-',
  blocks: [8,1],
  uppercase : true
});
</script>
</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>
