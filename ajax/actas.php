<?php

require_once("../config/conexion.php");
//llamada al modelo categoria
require_once("../modelos/Actas.php");

$actas = new Actas();

switch ($_GET["op"]){
    case 'crear_acta':
        $actas->registrarActa($_POST["codigo_orden"],$_POST["titular"],$_POST["nombre_receptor"],$_POST["receptor"],$_POST["sucursal"],$_POST["id_usuario"]);
        break;
}

