<?php

require_once("../config/conexion.php");
//llamada al modelo categoria
require_once("../modelos/Productos.php");

$productos = new Productos();

switch ($_GET["op"]){
   case 'listar_aros':

    $data= Array();
    $datos = $productos->get_aros();
    foreach($datos as $row){
        $sub_array = array();
        $sub_array[] = $row["id_aro"];
        $sub_array[] = $row["marca"];
        $sub_array[] = $row["modelo"];
        $sub_array[] = $row["color"];
        $sub_array[] = $row["material"];
        $sub_array[] = '<i class="fas fa-angle-double-right fa-2x" aria-hidden="true" style="color:blue" onClick="agregarAroListaBod('.$row["id_aro"].')">';

        $data[] = $sub_array;
      }

      $results = array(
      "sEcho"=>1, //Información para el datatables
      "iTotalRecords"=>count($data), //enviamos el total registros al datatable
      "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
      "aaData"=>$data);
      echo json_encode($results); 
	break;

	case 'crear_aro':
    $validate = $productos->valida_existe_aro($_POST["modelo"],$_POST["color"],$_POST["marca"]);

    if(is_array($validate)==true and count($validate)==0){
      $productos->crear_aro($_POST["marca"],$_POST["modelo"],$_POST["color"],$_POST["material"]);
      
    }else{
      echo json_encode($msj=["msj"=>"error"]);
    }
   ///fin mensaje error
	break;

	//////////////REPORTE INGRESOS BODEGA
    case "get_aros_orden":

        $datos=$productos->get_aros($_POST["marca"],$_POST["modelo"],$_POST["color"],$_POST["medidas"],$_POST["material"]);
        //Vamos a declarar un array
        $data= Array();
        foreach($datos as $row){
        $sub_array = array(); 
        $sub_array[] = $row["modelo"];
        $sub_array[] = $row["marca"];
        $sub_array[] = $row["color_varillas"];
        $sub_array[] = $row["color_frente"];
        $sub_array[] = "<i class='fas fa-plus-circle fa-2x' onClick='selectAro(".$row["id_aro"].")'></i>";
        $data[] = $sub_array;
    }

 // print_r($_POST);

    $results = array(
      "sEcho"=>1, //Información para el datatables
      "iTotalRecords"=>count($data), //enviamos el total registros al datatable
      "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
      "aaData"=>$data);
    echo json_encode($results);

break;

case 'buscar_data_aro_id':
   
  $data = $productos->get_data_aro_id($_POST["id_aro"]);
	foreach ($data as $row) {
    $output["id_aro"] = $row["id_aro"];
    $output["marca"] = $row["marca"];
    $output["modelo"] = $row["modelo"];
    $output["color"] = $row["color"];
    $output["material"] = $row["material"];
	}
	echo json_encode($output);
	
  break;

  case 'eliminar_aro':

	$productos->eliminar_aro($_POST["id_aro"]);
    $messages[]='ok';
	if (isset($messages)){
     ?>
       <?php
         foreach ($messages as $message) {
             echo json_encode($message);
           }
         ?>
   <?php
 }
    //mensaje error
      if (isset($errors)){

   ?>

         <?php
           foreach ($errors as $error) {
               echo json_encode($error);
             }
           ?>
   <?php
   }
   ///fin mensaje error
break;

case 'enviar_aros';
$correlativo = $productos->getCorrelativoIngreso();
    
    if(is_array($correlativo)==true and count($correlativo)>0){
        foreach($correlativo as $c){
          $num_corr = $c["n_ingreso"];               
        }
        $corr = substr($num_corr,2,20);
        $correlativoi = "I-".((int)$corr +(int)1);
    }else{
      $correlativoi = "I-1";
    }

    $validaCorrelativo = $productos->comprobarExisteCorrelativo($correlativoi);
    if (is_array($validaCorrelativo)==true and count($validaCorrelativo)==0 ){
    $productos->registrarIngreso($correlativoi);
    }else{
    $msj = ["msj"=>'Error'];
     echo json_encode($msj);
    }
     
   break;




}


