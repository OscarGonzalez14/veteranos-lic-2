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
    <style>
    option.suc-tooltip {
    position: relative;
}
 
option.suc-tooltip:hover::after {
    content: attr(data-title);
    background-color: #8fbc8f;
    color: #fff;
    padding: 8px;
    border-radius: 4px;
    font-size: 12px;
    line-height: 14px;
    display: block;
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    z-index: 1;
}

    </style>
</head>

<body>

<div class="wrapper">
<!-- top-bar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color:#343a40;color: white">
    <!-- Left navbar links -->
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color:white"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <h5 style="text-align:center;">AGENDAR CITAS</h5>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-slide="true" href="../vistas/logout.php" role="button" >
          <i class="fas fa-sign-out-alt" style="background-color: yelllow"></i>
        </a>
      </li>
    </ul>
  </nav>
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
                <th style="width:10%">fecha</th>
                <th style="width:10%">Sucursal</th>
                <th style="width:10%">Editar</th>
            </tr>
        </thead>

        </table>
      </div>


    </div>
  </div>
</div>
 
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="Label" aria-hidden="true">
        <div class="modal-dialog" style="max-width:95%">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="titulo" style="color: white">Registro citas</h5>
                    <span aria-hidden="true" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</span>
                </div>
                <form id="formulario" autocomplete="off">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="row">
                        <div class="col-md-5">
                            <label for="title">Paciente</label>
                            <input id="paciente-vet" type="text" class="form-control inp-citas" name="paciente-vet">
                        </div>

                        <div class="col-md-3">
                            <label for="dui">DUI</label>
                            <input id="dui-vet" type="text" class="form-control" name="dui-vet">
                        </div>

                        <div class="col-md-2">
                            <label for="dui">Telefono</label>
                            <input id="telefono-pac" type="text" class="form-control" name="telefono-pac">
                        </div>
                        <div class="col-md-2">
                            <label for="dui">Tel. opcional</label>
                            <input id="telefono-opcional" type="text" class="form-control" name="telefono-opcional" val="*">
                        </div>

                        <div class="col-md-2">
                            <label for="dui">Edad</label>
                            <input id="edad-pac" type="number" class="form-control" name="edad-pac" min="1" max="115">
                        </div>


                        <div class="col-md-5">
                            <label for="ocupacion-pac">Ocupación</label>
                            <input id="ocupacion-pac" type="text" class="form-control inp-citas" name="ocupacion-pac">
                        </div>

                        <div class="col-md-3">
                        <label for="usuario-lente">Genero</label>
                        <select class="form-control inp-citas" id="genero-pac" name="genero-pac">
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
                        <div class="col-sm-12" id="datos-titular" style="display:none">
                        <div class="col-md-7" id="nombre-tit">
                            <label for="ocupacion-pac">Veterano/Ex-combatiente titular *</label>
                            <input id="vet-titular" type="text" class="form-control inp-citas" placeholder="Veterano/Ex-combatiente titular" name="vet-titular">
                        </div>

                        <div class="col-md-5" id="dui-tit">
                            <label for="ocupacion-pac"> DUI Veterano/Ex-combatiente titular *</label>
                            <input id="dui-titular" type="text" class="form-control inp-citas" placeholder="DUI" name="dui-titular">
                        </div>
                        </div>

                        
                        <div class=" form-group col-sm-3 select2-purple">
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

                        <div class=" form-group col-sm-3 select2-purple">
                            <label for="" class="etiqueta">Municipio </label> <span id="munic_pac_data" style="color: red"></span>
                            <select class="select2 form-control clear_input" id="munic_pac" name="munic_pac" multiple="multiple" data-placeholder="Seleccionar Municipio" data-dropdown-css-class="select2-purple" style="width: 100%;height: ">
                                <option value="0">Seleccione Municipio.</option>
                            </select>               
                       </div>

                        <div class="col-md-2">
                            <label for="start">Sucursal</label>
                            <select class="form-control suc-tooltip" id="sucursal-cita" name="sucursal-cita"  onchange="gethorasDisponibles(this.value)"  onclick="gethorasDisponiblesSucursal(this.value)">
                                <option value="0">Seleccionar sucursal</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="start">Fecha</label>
                            <input class="form-control" id="fecha-cita" type="date" name="fecha-cita" onchange="consultarDisponibilidad(this.value)"  onclick="consultarDisponibilidad(this.value)">
                        </div>                  

                        <div class="col-md-2 select2-primary">
                            <label for="hora" >Hora</label>
                            <select class="select2 form-control clear_input" id="hora" name="hora" multiple="multiple" data-placeholder="Seleccionar hora" data-dropdown-css-class="select2-primary" style="width: 100%;height: ">
                            <option value="0">Seleccione hora...</option>
                            </select> 
                        </div>

                        <input type="hidden" id="start">

                        </div>
                    </div>
                    <input type="hidden" id="id_citado">
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
    
        let telefono_op = new Cleave('#telefono-opcional', {
        delimiter: '-',
        blocks: [4,4],
        uppercase: true
        });

        let duitit = new Cleave('#dui-titular', {
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