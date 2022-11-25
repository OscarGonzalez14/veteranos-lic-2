<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["user"])){
$categoria_usuario = $_SESSION["categoria"];
date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H-i-s");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
<?php require_once("links_plugin.php"); 
 require_once('../modelos/Ordenes.php');
 $ordenes = new Ordenes();
 //$suc = $ordenes->get_opticas();
 //require_once('../modales/modal_ingresos_lab.php');
 require_once('../modales/nueva_orden_lab.php');
 require_once('../modales/aros_en_orden.php');

 ?>
<style>
  .buttons-excel{
      /*background-color: green !important;*/
      margin: 2px;
      max-width: 150px;
  }
</style>
 <script src="../plugins/exportoExcel.js"></script>
 <script src="../plugins/keymaster.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style='font-family: Helvetica, Arial, sans-serif;'>
<div class="wrapper">
<input type="hidden" id="correlativo_acc_vet" name="correlativo_acc_vet">
<!-- top-bar -->
  <?php require_once('top_menu.php')?>
  <?php require_once('side_bar.php')?>
  <!--End SideBar Container-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
      <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_user"];?>"/>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION["user"];?>"/>
      <input type="hidden" name="categoria" id="get_categoria" value="<?php echo $_SESSION["categoria"];?>"/>
      <div style="border-top: 0px">
      </div>

      <?php include 'ordenes/header_status_lab.php'; ?>
      <div class="row">
        <div class="col-sm-10"><h5 style="text-align: center">ORDENES FINALIZADAS</h5></div>
        <div class="col-sm-2 float-right" style="margin-bottom: 5px !important">         
         <button class="btn btn-success barcode_actions_chk" onClick='envioOrrdenesCheck()'><i class="fas fa-shipping-fast"></i> Enviar</button>
         </div>
      </div>
        <table width="100%" class="table-hover table-bordered" id="ordenes_finalizadas_lab"  data-order='[[ 0, "desc" ]]'> 
              
         <thead class="style_th bg-dark" style="color: white">
           <th>ID</th>
           <th>Codigo</th>
           <th>Fecha Fin.</th>
           <th>DUI</th>
           <th>Paciente</th>
           <th>Tipo lente</th>
           <th>Detalles</th>
         </thead>
         <tbody class="style_th"></tbody>
       </table>

    </section>
    <!-- /.content -->
  </div>

  <input type="hidden" value="<?php echo $categoria_usuario;?>" id="cat_users">
   <!--Modal Ingreso a laboratorio-->
   <div class="modal" id="modal_procesando_lab" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="max-width: 35%">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ORDENES FINALIZADAS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>       
        <!-- Modal body -->
        <div class="modal-body">
          <b><h5 style="font-size: 16px;text-align: center">Confirmar que se han finzalizado <span id="count_select"></span> ordenes.</h5></b>
          
        </div>
        <div class="modal-footer">
        <form action="listado_ordenes_finalizadas.php"  method="post" target="_blank">
          <input type="hidden" id="ordenes_imp_finish" name="ordenes_imp_finish" value="">
           <button type="submit" class="btn btn-info" onClick="confirmarSalidaLab();"> Finzalizr</button>
        </form>        
      </div>       
   
      </div>
    </div>
  </div>
  <input type="hidden" id="cat_data_barcode" value="finalizar_lab">
  <input type="hidden" id='fecha_envios_veteranos_i' value="<?php echo $hoy; ?>">
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>2021 Lenti || <b>Version</b> 1.0</strong>
     &nbsp;All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer>
</div>

<!--ENVIO DE ITEMS POR CHECKBOX-->
<div class="modal" id="envios_chk" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">    
    <div class="modal-dialog" style="max-width: 85%">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header" style="background: #162e41;color: white">
          <h4 class="modal-title" style="font-size: 14px;font-family: Helvetica, Arial, sans-serif;"><b><span id="c_accion"></span></b></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <input type="text" class="form-control" id="reg_ingresos_barcode" onchange="getOrdenBarcode()">

          <button type="button" class="btn btn-default float-right btn-sm " onClick="registrarBarcodeOrdenes()" style='margin: 3px'><i class=" fas fa-file-export" style="color: #0275d8"></i> Registrar</button>

          <table class="table-hover table-bordered" style="font-family: Helvetica, Arial, sans-serif;max-width: 100%;text-align: left;margin-top: 5px !important" width="100%" id="tabla_acciones_veterans">

          <thead style="font-family: Helvetica, Arial, sans-serif;width: 100%;text-align: center;font-size: 12px;" class="bg-dark">
            <th>ID</th>
            <th>#Orden</th>
            <th>Fecha</th>
            <th>DUI</th>
            <th>Paciente</th>
            <th>Cod. Envio</th>
            <th>Sucursal</th>
            <th>Eliminar</th>
          </thead>
          <tbody id="items-ordenes-barcode" style="font-size: 12px"></tbody>
        </table>

        </div> 
        <!-- Modal footer -->
       
      </div>
    </div>
  </div>


<!-- ./wrapper -->
<?php 
require_once("links_js.php");
?>
<script type="text/javascript" src="../js/laboratorios.js"></script>
<script type="text/javascript" src="../js/ordenes.js"></script>

</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>
