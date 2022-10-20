<?php

require_once("../config/conexion.php");
//llamada al modelo categoria
require_once("../modelos/Citados.php");

$citas = new Citados();

switch ($_GET["op"]){

    case 'listar_pacientes_citados':

        $citados = $citas->listar_pacientes_citados();
        $data = Array();
        foreach($citados as $c){
            $sub_array = array();
            $sub_array[] = $c["dui"]; 
            $sub_array[] = $c["paciente"]; 
            $sub_array[] = $c["sector"];
            $sub_array[] = "<i class='fas fa-plus-circle fa-2x' onClick='getCitados(".$c["id_cita"].")'></i>"; 
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
          echo json_encode($results);

        break;
    
    case 'get_data_cita':

        $data = $citas->getDataCitaId($_POST["id_cita"]);
        foreach ($data as $row) {
            $output["paciente"] = $row["paciente"];
            $output["dui"] = $row["dui"];
            $output["edad"] = $row["edad"]; 
            $output["telefono"] = $row["telefono"];
            $output["usuario_lente"] = $row["usuario_lente"];
            $output["ocupacion"] = $row["ocupacion"];
            $output["sector"] = $row["sector"];
            $output["genero"] = $row["genero"];
            $output["depto"] = $row["depto"];
            $output["municipio"] = $row["municipio"];  
        }
        echo json_encode($output);

        break;

        case 'get_citados_sucursal':

            $citados = $citas->getDataCitadosSucursal($_POST["sucursal"],$_POST["fecha"]);

            $data = Array();

            foreach($citados as $c){

                if($c["estado"]=="0"){
                    $estado="Pendiente";
                }elseif($c["estado"]=="1"){
                    $estado="Evaluado";
                }

                $sub_array = array();
                $sub_array[] = $c["paciente"]; 
                $sub_array[] = $c["dui"]; 
                $sub_array[] = $c["sector"];
                $sub_array[] = $c["fecha"];
                $sub_array[] = $c["sucursal"];
                $sub_array[] = $c["estado"];
                $data[] = $sub_array;
            }
    
            $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

            echo json_encode($results);

        break;

        case 'get_horas_select':
            
            $data = $citas->getHorasSelect($_POST["fecha"]);
            $horas = array();
            foreach($data as $m){
                $hora = $m["hora"];
                array_push($horas,$hora);
             }
      
             echo json_encode($horas);

            break;

        case 'get_citados_atend':

            
            $args = $_POST["Args"];
            $tipo = $args[0];
            $sucursal = $args[1];
            $desde = $args[2];
            $hasta = $args[3];

            if($sucursal=="All"){
                $datos = $citas->getCitadosAtendAll($desde);
            }

            $data = Array();

            foreach($datos as $c){

                if($c["estado"]=="0"){
                    $estado="Pendiente";
                }elseif($c["estado"]=="1"){
                    $estado="Evaluado";
                }

                $sub_array = array();
                $sub_array[] = $c["sucursal"]; 
                $sub_array[] = $c["paciente"]; 
                $sub_array[] = $c["dui"];
                $sub_array[] = date("d-m-Y",strtotime($c["fecha"]))." ".$c["hora"];
                $sub_array[] = $c["sector"];
                $sub_array[] = $c["estado"];
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
