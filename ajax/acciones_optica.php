<?php

require_once("../config/conexion.php");
//llamada al modelo categoria
require_once("../modelos/AccionesOrden.php");

$acciones = new AccionesOptica();

switch ($_GET["op"]){
    case 'get_data_orden_barcode':
        $acciones->get_dataOrden($_POST["paciente_dui"],$_POST["tipo_accion"]);
        break;
}
