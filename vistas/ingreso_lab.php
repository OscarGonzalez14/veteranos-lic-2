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


 require_once('../modales/modal_ingresos_lab.php');
 require_once('../modales/nueva_orden_lab.php');
 require_once('../modales/aros_en_orden.php');

 ?>

<style>
  .buttons-excel{
    margin: 2px;
    max-width: 150px;
}
</style>
 <script src="../plugins/exportoExcel.js"></script>
 <script src="../plugins/keymaster.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style='font-family: Helvetica, Arial, sans-serif;'>
<div class="wrapper">
<!-- top-bar -->
  <?php require_once('top_menu.php')?>
  <?php require_once('side_bar.php')?>
  <!--End SideBar Container-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
      <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_user"];?>"/>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION["usuario"];?>"/>
      <input type="hidden" name="categoria" id="get_categoria" value="<?php echo $_SESSION["categoria"];?>"/>
      <div style="border-top: 0px">
      </div>

      <?php include 'ordenes/header_status_lab.php'; ?>
      <div class="row">
        <div class="col-sm-10"><h5 style="text-align: center">INGRESO A LABORATORIO</h5></div>
        <div class="col-sm-2 float-right" style="margin-bottom: 5px !important">         
        <button class="btn btn-app btn-success" id="modal_ingreso_lab" style="color: black;border: solid #5bc0de 1px;" onclick="ingreso_laboratorio()">
          <span class="badge bg-success"></span>
          <i class="fas fa-file"></i> INGRESO A LABORATORIO
        </button>
         </div>
      </div>
        <table width="100%" class="table-hover table-bordered" id="ingreso_lab_ordenes"  data-order='[[ 0, "desc" ]]'> 
              
         <thead class="style_th bg-dark" style="color: white">
           <th>ID</th>
           <th>Número de orden</th>
           <th>Detalle de orden</th>
           <th>Fecha</th>
           <th>Laboratorio</th>
           <th>DUI</th>
           <th>Paciente</th>
           <th>Editar</th>
         </thead>
         <tbody class="style_th"></tbody>
       </table>

    </section>
    <!-- /.content -->
  </div>

  <input type="hidden" value="<?php echo $categoria_usuario;?>" id="cat_users">

  <!--Modal buscar despacho-->
  <div class="modal" id="modal_ingreso_laboratorio" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="max-width: 35%">
    <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header" style="background: #162e41;color: white">
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <input type="text" class="form-control" id="n_despacho" onchange="getDespachoLab(this.id)" placeholder="Buscar por código de envio">

          <input type="text" class="form-control" id="dui_despacho" onchange="buscar_dui_table(this.id)" placeholder="Buscar por Escaner">

          <button type="button" class="btn btn-default float-right btn-sm " id='showModalEnviarLab' style="margin: 3px"><i class=" fas fa-file-export" style="color: #0275d8"></i> Enviar <span id="totalOrdenLab">0</span></button>

          <table class="table-hover table-bordered" style="font-family: Helvetica, Arial, sans-serif;max-width: 100%;text-align: left;margin-top: 5px !important" width="100%">

          <thead style="font-family: Helvetica, Arial, sans-serif;width: 100%;text-align: center;font-size: 12px;" class="bg-dark">
            <tr>
            <th><input type="checkbox" id="select-all-desp" class="form-check-label"></th>
            <th>DUI</th>
            <th>PACIENTE</th>
          </tr></thead>
          <tbody id="result_despacho" style="font-size: 12px"></tbody>
        </table>

        </div>
        <!-- Modal footer -->
       
      </div>
    </div>
  </div>
  <!---Modal laboratorio --->
  <div class="modal" id="modal_laboratorio" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="max-width: 35%">
    <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header" style="background: #162e41;color: white">
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <h5>Total de ordenes : <span id="totalOrdenLab_ingreso">0</span></h5>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="tipo_acciones">Tipo acción: </label>
              <select name="tipo_acciones" id="tipo_acciones" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                <option value="INGRESO LABORATORIO">Ingreso Lab</option>
                <option value="REENVIO A LAB">Reenvio a Lab</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="laboratorio">Laboratorio: </label>
              <select name="laboratorio" id="laboratorio_ingreso" class="form-control" required>
                <option value="" disabled selected>Seleccionar</option>
                <option value="LENTI 1">LENTI </option>
                <option value="AV Plus Lab">AV Plus Lab</option>
              </select>
            </div>
          </div>

          <button class="btn btn-primary btn-block" onclick="ingreso_lab()">Enviar</button>

        </div>
        <!-- Modal footer -->
       
      </div>
    </div>
  </div>
   
  <input type="hidden" id="cat_data_barcode" value="finalizar_lab">
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
<script type="text/javascript" src="../js/laboratorios.js"></script>
<script type="text/javascript" src="../js/ordenes.js"></script>

</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>
