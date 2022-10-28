<!DOCTYPE html>
<html lang="es">
<?php
require_once("../config/conexion.php");
if(isset($_SESSION["user"])){
require_once("../vistas/links_plugin.php");
require_once("modales/listarCitas.php");
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Citas</title>
    
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/main.min.css">
</head>

<body>

<div class="wrapper">
<!-- top-bar -->
  <?php require_once('../vistas/top_menu.php')?>
  <!-- Main Sidebar Container -->
  <?php require_once('side_bar.php'); ?>
  <div class="content-wrapper">
   
    <button class="btn btn-outline-primary btn-xs" style="margin-left:25px"><i class="fas fa-calendar"></i> Citas diarias</button>
    <button class="btn btn-outline-dark btn-xs" style="margin-left:25px" onClick="showModalGestion()"><i class="fas fa-cog"></i> Gestion de citas</button>
    <div class="container">
        <div id="calendar"></div>
    </div>


        <!--MODAL GESTION CITAS -->

<div class="modal" id="gestion-citas">
  <div class="modal-dialog" style="max-width:55%">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-primary" style="padding:10px;">
        <h4 class="modal-title  w-100 text-center position-absolute" style="font-size:16px">GESTIONAR CITAS</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table-bordered table-hover" width="100%" id="data-gest-citas" style="font-family: Helvetica, Arial, sans-serif;font-size: 12px;text-align: center">

        <thead style="color:white;" class='bg-dark'>
            <tr>
                <th style="width:40%">Paciente</th>
                <th style="width:20%">DUI</th>
                <th style="width:20%">Sector</th>
                <th style="width:10%">Editar</th>
                <th style="width:10%">Eliminar</th>
            </tr>
        </thead>

        </table>
      </div>


    </div>
  </div>
</div>
 
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
        <div class="modal-dialog" style="max-width:80%">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="titulo" style="color: white">Registro citas</h5>
                    <span aria-hidden="true" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</span>
                </div>
                <form id="formulario" autocomplete="off">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="row">

                        <div class="col-md-4">
                            <label for="start">Fecha</label>
                            <input class="form-control" id="fecha-cita" type="date" name="fecha-cita" readonly>
                        </div>

                        <div class="col-md-4">
                            <label for="start">Sucursal</label>
                            <select class="form-control" id="sucursal-cita" name="sucursal-cita">
                                <option value="0">Seleccionar sucursal</option>
                                <option value="Metrocentro">Metrocentro</option>
                                <option value="Cascadas">Cascadas</option>
                                <option value="Santa Ana">Santa Ana</option>
                                <option value="Chalatenango">Chalatenango</option>
                                <option value="Ahuachapan">Ahuachapan</option>
                                <option value="Sonsonate">Sonsonate</option>
                                <option value="Ciudad Arce">Ciudad Arce</option>                                   
                                <option value="Opico">Opico</option>
                                <option value="Apopa">Apopa</option>
                                <option value="San Vicente Centro">San Vicente Centro</option>
                                <option value="San Vicente">San Vicente</option>
                                <option value="Gotera">Gotera</option>
                                <option value="San Miguel">San Miguel</option>
                            </select>
                        </div>                  

                        <div class="col-md-4 select2-primary">
                            <label for="hora" >Hora</label>
                            <select class="select2 form-control clear_input" id="hora" name="hora" multiple="multiple" data-placeholder="Seleccionar hora" data-dropdown-css-class="select2-primary" style="width: 100%;height: ">
                            <option value="0">Seleccione hora...</option>
                            </select> 
                        </div>

                        <div class="col-md-6">
                            <label for="title">Paciente</label>
                            <input id="paciente-vet" type="text" class="form-control" name="paciente-vet">
                        </div>

                        <div class="col-md-3">
                            <label for="dui">DUI</label>
                            <input id="dui-vet" type="text" class="form-control" name="dui-vet">
                        </div>

                        <div class="col-md-3">
                            <label for="dui">Telefono</label>
                            <input id="telefono-pac" type="text" class="form-control" name="telefono-pac">
                        </div>

                        <div class="col-md-2">
                            <label for="dui">Edad</label>
                            <input id="edad-pac" type="text" class="form-control" name="edad-pac">
                        </div>


                        <div class="col-md-6">
                            <label for="ocupacion-pac">Ocupación</label>
                            <input id="ocupacion-pac" type="text" class="form-control" name="ocupacion-pac">
                        </div>

                        <div class="col-md-4">
                        <label for="usuario-lente">Genero</label>
                        <select class="form-control" id="genero-pac" name="genero-pac">
                            <option>Seleccionar...</option>
                            <option>Masculino</option>
                            <option>Femenino</option>
                        </select>
                        </div>
                       
                        <div class="col-md-2">
                            <label for="dui">Sector</label>
                            <select class="form-control" id="sector-pac" name="sector-pac">
                            <option option="0">Seleccionar...</option>
                            <option option="FAES">FAES</option>
                            <option option="FMLN">FMLN</option>
                            <option option="CONYUGE">CONYUGE</option>
                        </select>
                        </div>
                        
                        <div class=" form-group col-sm-4 select2-purple">
                        <label for="" class="etiqueta">Departamento </label> <span id="departamento_pac_data" style="color: red"></span>
                        <select class="select2 form-control clear_input" id="departamento_pac" name="departamento_pac" multiple="multiple" data-placeholder="Seleccionar Departamento" data-dropdown-css-class="select2-purple" style="width: 100%;height: ">              
                            <option value="0">Seleccione Depto.</option>
                            <option value="San Salvador">San Salvador</option>
                            <option value="La Libertad">La Libertad</option>
                            <option value="Santa Ana">Santa Ana</option>
                            <option value="San Miguel">San Miguel</option>
                            <option value="Sonsonate">Sonsonate</option>
                            <option value="Usulutan">Usulután</option>
                            <option value="Ahuachapan">Ahuachapán</option>
                            <option value="La Union">La Unión</option>
                            <option value="La Paz">La Paz</option>
                            <option value="Chalatenango">Chalatenango</option>
                            <option value="Morazan">Morazán</option>
                            <option value="Cuscatlan">Cuscatlán</option>
                            <option value="San Vicente">San Vicente</option>
                            <option value="Cabanas">Cabañas</option>
                        </select>               
                        </div>

                        <div class=" form-group col-sm-6 select2-purple">
                            <label for="" class="etiqueta">Municipio </label> <span id="munic_pac_data" style="color: red"></span>
                            <select class="select2 form-control clear_input" id="munic_pac" name="munic_pac" multiple="multiple" data-placeholder="Seleccionar Municipio" data-dropdown-css-class="select2-purple" style="width: 100%;height: ">
                                <option value="0">Seleccione Municipio.</option>
                            </select>               
                       </div>

                        <input type="hidden" id="start">
                        </div>
                    </div>
                    <input type="hidden" id="id_usuario_vet" name="id_usuario_vet" value="<?php echo $_SESSION["id_user"]?>">
                    <input type="hidden" id="usuario-lente" name="usuario-lente" value="0">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark btn-block" id="btnAccion">Guardar</button>
                       
                    </div>
                </form>
                <button class="btn btn-outline-info btn-flat" id="btnEdit" style="display:none;" onClick="editarCitaSendData()"><i class="fas fa-edit"></i> EDITAR</button>
            </div>
        </div>
    </div>




</div>
</div>
<?php 
require_once("../vistas/links_js.php");
?>
  
    <script src="<?php echo base_url; ?>Assets/js/main.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/es.js"></script>
    <script>
        const base_url = '<?php echo base_url; ?>';
    </script>
   
    <script src="<?php echo base_url; ?>Assets/js/app.js"></script>
    <script src='../js/cleave.js'></script>
    <script src='../js/citados.js'></script>
    <script>
        let telefono = new Cleave('#telefono-pac', {
        delimiter: '-',
        blocks: [4,4],
        uppercase: true
        });
    
        let dui = new Cleave('#dui-vet', {
        delimiter: '-',
        blocks: [8,1],
        uppercase: true
        });
    </script>

</body>

</html>

<?php } else{
echo "Acceso denegado";
  } ?>