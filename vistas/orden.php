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
 $ordenes = new Ordenes();

 require_once('../modales/nueva_orden_lab.php');
 require_once('../modales/aros_en_orden.php');
 require_once('../modales/modal_rectificaciones.php');
 require_once('../modales/estadisticas.php');
 require_once('../modales/modal_citas.php');

 date_default_timezone_set('America/El_Salvador');
 $hoy = date("Y-m-d");

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
      <input type="hidden" name="sucursal" id="sucursal" value="<?php echo $_SESSION["sucursal"];?>"/>
      <div style="border-top: 0px">      
      </div>
      <br>
      <button class="btn btn-outline-primary btn-sm btn-flat" data-toggle="modal" data-target="#nueva_orden_lab" onClick='get_numero_orden();' id="order_new"><i class="fa fa-glasses" style="margin-top: 2px"> Crear Orden</i></button>


      <div class="card card-dark card-outline" style="margin: 2px;">
       <table width="100%" class="table-hover table-bordered" id="datatable_ordenes"  data-order='[[ 0, "desc" ]]'>    
         <thead class="style_th bg-dark" style="color: white">
           <th>Correlativo</th>
           <th>ID orden</th>
           <th>Fecha</th>
           <th>Paciente</th>
           <th>DUI</th>
           <th>Telefono</th>
           <th>Tipo lente</th>
           <th>Ver y Editar</th>
           <th>Eliminar</th>
         </thead>
         <tbody class="style_th"></tbody>
       </table>
      </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /..content -->
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
  <input type="hidden" id="fecha_act" value="<?php echo $hoy;?>">
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
<script type="text/javascript" src="../js/ordenes.js"></script>
<script type="text/javascript" src="../js/productos.js"></script>
<script type="text/javascript" src="../js/cleave.js"></script>
<script type="text/javascript" src="../js/citados.js"></script>
<script>
  var dui = new Cleave('#dui_pac', {
  delimiter: '-',
  blocks: [8,1],
  uppercase : true
});

var dui_titular = new Cleave('#dui_titular', {
  delimiter: '-',
  blocks: [8,1],
  uppercase : true
});

var telefono = new Cleave('#telef_pac', {
  delimiter: '-',
  blocks: [4,4],
  uppercase : true
});
</script>

<script>
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
    //Formulario orden
    $("#departamento_pac").select2({
    maximumSelectionLength: 1
    });
  
    $("#munic_pac").select2({
    maximumSelectionLength: 1
    });
  })
</script>

</body>
</html>
 <?php } else{
echo "Acceso denegado";
  } ?>
