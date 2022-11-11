<?php

require_once("../config/conexion.php");
//llamada al modelo categoria
require_once("../modelos/Despachos.php");

$despachos = new Despachos();

switch ($_GET["op"]){

    case "get_ordenes_despachar";
    $args = $_POST["Args"];
    if($args[0]=='citas'){
        require_once("../modelos/Citados.php");
        $citas = new Citados();
        $ordenes = $citas->getDataCitadosSucursalPrint($args[2], $args[1]);
    }else{
        require_once("../modelos/Ordenes.php");
        $ord = new Ordenes();
        $ordenes =  $ord->getOrdenesSucursalDia($args[2], $args[1]);
    } 
    
    $data = Array();
    $i = 0;
    foreach($ordenes as $row){
        $sub_array = array();
        $sub_array[] = '<input type="checkbox"class="form-check-input enviosuclab" value="'.$row["dui"].'" name="'.$row["paciente"].'"  id="env'.$i.'">'."enviar.".'';
        $sub_array[] = $row["paciente"]; 
        $sub_array[] = $row["dui"];
        $sub_array[] = date("d-m-Y",strtotime($row["fecha"])); 
        $sub_array[] = $row["sector"];

        $data[] = $sub_array;
        $i++;
    }

    $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
        echo json_encode($results);       


    break;

    case 'registrar_despacho_lab':
       $despachos->registrarDespachos();
    break;


}