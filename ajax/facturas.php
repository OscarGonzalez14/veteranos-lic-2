<?php

require_once("../config/conexion.php");
//llamada al modelo categoria
require_once("../modelos/Facturas.php");
$factura = new Facturas();

switch ($_GET["op"]){
    case 'guardar_factura_manual':
        $factura->guardar_factura_manual($_POST['dataCliente']['cod_factura'],$_POST['dataCliente']['cliente'],$_POST['dataCliente']['direccion'],$_POST['dataCliente']['telefono'],$_POST['dataCliente']['retencion'],$_POST['dataCliente']['fecha'],$_POST['dataCliente']['subtotal'],$_POST['info']);

        if($factura){
            echo json_encode("exito");
        }else{
            echo json_encode("error");
        }
    break;
    case 'listar_facturas_manuales':
        
        $data = Array();
        $i=1;
        $datos = $factura->listar_facturas_manuales();
        foreach ($datos as $row) { 
        $sub_array = array();
        $sub_array[] = $i;
        $sub_array[] = $row["id_factura"];
        $sub_array[] = $row["num_factura"]; 
        $sub_array[] = $row["cliente"];
        $sub_array[] = $row["direccion"];  
        $sub_array[] = $row["telefono"];     
        $sub_array[] = date("d-m-Y",strtotime($row["fecha"]));
        $sub_array[] = '<button disabled type="button"  class="btn btn-sm bg-light" onClick="verOrdenLaboratorio(\''.$row["id_factura"].'\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';

        $i++;                                             
        $data[] = $sub_array;
        }
        
        $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
        echo json_encode($results);

    break;
}


