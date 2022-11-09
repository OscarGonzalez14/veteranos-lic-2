<?php 
require_once("../config/conexion.php");
if(isset($_SESSION["user"])){
$categoria_usuario = $_SESSION["categoria"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
<?php require_once("links_plugin.php"); 
 require_once('../modelos/Ordenes.php');
 require_once('../modales/modal_despachos.php');
 ?>
<style>
  .buttons-excel{
      background-color: green !important;
      margin: 2px;
      max-width: 150px;

  }
  .odd:hover{
    background-color: lightyellow !important;
  }
  .even:hover{
    background-color: lightyellow !important;
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
      <div class="container-fluid">
      <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_user"];?>"/>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION["user"];?>"/>
      <input type="hidden" name="categoria" id="get_categoria" value="<?php echo $_SESSION["categoria"];?>"/>
      <div style="border-top: 0px">

      </div>
        <a class="btn btn-app" style="color: black;border: solid #5bc0de 1px;margin-top:5px" onClick="showModalDespachos()">
          <span class="badge bg-primary" id="alert_enviadas_ord"></span>
          <i class="fas fa-shipping-fast" style="color: #0275d8"></i> CREAR DESPACHO
        </a>
      <div class="card card-warning card-outline" style="margin: 2px;margin-top: 0px !important">
      <h5 style="text-align: center; font-size: 16px" align="center" class="bg-dark">LISTADO DE DESPACHOS A LABORATORIO</h5>
       <table width="100%" class="table-bordered" id="data_ordenes_sin_procesar"  data-order='[[ 0, "asc" ]]' style="font-size: 11px">
     
        <thead class="style_th bg-info" style="color: white">
           <th>ID</th>
           <th>Fecha</th>
           <th>Enviado por</th>
           <th>Cantidad</th>
           <th>Mensajero</th>
           <th style="text-align: center">Detalles</th>
         </thead>
         <tbody class="style_th" style="padding: 3px;text-align: left;font-size: 11px"></tbody>
       </table>

      </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <input type="hidden" value="<?php echo $categoria_usuario;?>" id="cat_users">

   <!--Modal Imagen Aro-->
   <div class="modal" id="imagen_aro_orden">
    <div class="modal-dialog" style="max-width: 45%">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <div style="  background-size: cover;background-position: center;display:flex;align-items: center;">
            <img src="" alt="" id="imagen_aro" style="width: 100%;border-radius: 8px;">
          </div>          
        </div>        
   
      </div>
    </div>
  </div>

  <!-----------MODAL COBNFIRMA ENVIO --------->
<div class="modal fade" id="confirmar_envio_ord">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación de envío</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
            <div class="modal-body">
              <h5 style="font-family: Helvetica, Arial, sans-serif;font-size: 18px;text-align: center;"><b>Confirmar el envío de <span id="n_trabajos_env" style="color: red"></span>&nbsp;trabajos</b></h5>
              <div class="dropdown-divider"></div>
              <div>
              <section class="input-group"> 
              <div class="form-group col-sm-4 select2-purple" style="margin: auto">
              <select class="select2 form-control" id="destino_envio" multiple="multiple" data-placeholder="Seleccionar destino" data-dropdown-css-class="select2-purple" style="width: 100%;height: ">              
                  <option value="">Seleccionar destino</option>
                  <option value="Jenny">Jenny</option>
                  <option value="Divel">Divel</option>
                  <option value="Lomed">Lomed</option>
                  <option value="Lenti">Lenti</option>
                  <option value="Arce">Arce</option>              
              </select>   
              </div>

              <div class="form-group col-sm-4 select2-purple" style="margin: auto">
              <select class="select2 form-control" id="cat_envio" multiple="multiple" data-placeholder="Seleccionar categoria" data-dropdown-css-class="select2-purple" style="width: 100%;height: ">              
                  <option value="">Seleccionar categoria</option>
                  <option value="Proceso">Proceso</option>
                  <option value="Terminado">Terminado</option>             
                </select>   
              </div>
            </section>
              </div>
              </div>
              <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" onClick="registrarEnvioVet()">Aceptar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <input type="hidden" id="user_act" value="<?php echo $_SESSION["usuario"];?>">
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>2021 Lenti || <b>Version</b> 1.0</strong>
     &nbsp;All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer>
</div>

<?php

require_once("links_js.php");

?>
<script type="text/javascript" src="../js/despachos.js"></script>
<script type="text/javascript" src="../js/cleave.js"></script>
<script>
  var dui = new Cleave('#dui_pac', {
  delimiter: '-',
  blocks: [8,1],
  uppercase : true
});

$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $(".select2").select2({
    maximumSelectionLength: 1
  });
})
</script>
</body>
</html>
 <?php } else{
echo "Acceso denegado";
} ?>
