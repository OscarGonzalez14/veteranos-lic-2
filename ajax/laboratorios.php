<?php

require_once("../config/conexion.php");
//llamada al modelo categoria
require_once("../modelos/Laboratorios.php");

$ordenes = new Laboratorios();

switch ($_GET["op"]){

case 'get_ordenes_pendientes_lab':
  
  if($_POST['inicio'] != "" AND $_POST['hasta'] != "" AND $_POST['estado_proceso'] != ""){
  $datos = $ordenes->get_ordenes_filter_date($_POST["inicio"],$_POST["hasta"],$_POST["estado_proceso"]); 
  }else{
    $datos = $ordenes->get_rango_fechas_ordenes();
  }

  $data = Array();
  $i=1;
  foreach ($datos as $row) { 
    $sub_array = array();

    switch ($row['estado']){
      case 0:
        $estado = "Digitada";
      break;
      case 1:
        $estado = "Enviada Lab";
      break;
      case 2:
        $estado = "Recibida Lab";
      break;
      case 3:
        $estado = "En proceso";
      break;
      case 4:
        $estado = "Finalizada";
      break;
      case 5:
        $estado = "Despachada en Lab";
      break;
      case 6:
        $estado = "Recibida en optica";
      break;
      case 7:
        $estado = "Entregada";
      break;
    }


  $sub_array = array();
  $sub_array[] = $i;
  $sub_array[] = $row["id_orden"];  
  $sub_array[] = date("d-m-Y",strtotime($row["fecha"])); 
  $sub_array[] = $row["dui"];
  $sub_array[] = strtoupper($row["paciente"]);
  $sub_array[] = $row["tipo_lente"];
  $sub_array[] = $row["institucion"];
  $sub_array[] = $estado;
  $sub_array[] = $row["sucursal"];
  $sub_array[] = '<button type="button" class="btn btn-sm bg-light" onClick="verOrdenLaboratorio(\'' . $row["dui"] . '\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';
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

  case 'recibir_ordenes_laboratorio':
    $ordenes->recibirOrdenesLab();
    $mensaje = "Ok";
  echo json_encode($mensaje);    
  break;

 case 'get_ordenes_procesando_lab':
  $data = Array();
  $i=0;
  $datos = $ordenes->get_ordenes_procesando_lab();
  foreach ($datos as $row) { 
  $sub_array = array();

  $sub_array[] = $row["id_orden"];
  $sub_array[] = $row["codigo"];  
  $sub_array[] = date("d-m-Y",strtotime($row["fecha"]));
   $sub_array[] = '<input type="checkbox"class="form-check-input ordenes_procesando_lab" value="'.$row["id_orden"].'" name="'.$row["codigo"].'" id="orden_enviar'.$i.'">'."Rec.".'';
  $sub_array[] = strtoupper($row["paciente"]);
  $sub_array[] = $row["tipo_lente"];
  $sub_array[] = '<button type="button"  class="btn btn-sm bg-light" onClick="verEditar(\''.$row["codigo"].'\',\''.$row["paciente"].'\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';  
  $sub_array[] = '<i class="fas fa-image fa-2x" aria-hidden="true" style="color:blue" onClick="verImg(\''.$row["img"].'\',\''.$row["codigo"].'\',\''.$row["paciente"].'\')">';               
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

  case 'get_ordenes_procesando_lab_envios':
  $data = Array();
  $i=0;
  $datos = $ordenes->get_ordeOrdenesFinalizadasEnviar();
  foreach ($datos as $row) { 
  $sub_array = array();

  $sub_array[] = $row["id_orden"];
  $sub_array[] = $row["codigo"];  
  $sub_array[] = date("d-m-Y",strtotime($row["fecha"]));
   $sub_array[] = strtoupper($row["paciente"]);
  $sub_array[] = $row["tipo_lente"];
  $sub_array[] = '<button type="button"  class="btn btn-sm bg-light" onClick="verEditar(\''.$row["codigo"].'\',\''.$row["paciente"].'\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';  
  $sub_array[] = '<i class="fas fa-image fa-2x" aria-hidden="true" style="color:blue" onClick="verImg(\''.$row["img"].'\',\''.$row["codigo"].'\',\''.$row["paciente"].'\')">';               
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

  case 'finalizar_ordenes_laboratorio':
    $ordenes->finalizarOrdenesLab();
    $mensaje = "Ok";
    echo json_encode($mensaje); 
    
    break;

////////////////// 

    case 'get_ordenes_finalizadas_lab':
      $data = Array();
      $datos = $ordenes->get_ordeOrdenesFinalizadas();
      $cont = 0;
      foreach ($datos as $row) { 
      $sub_array = array();

      $sub_array[] = $row["id_orden"];
      $sub_array[] = $row["codigo"]; 
      $sub_array[] = '<div style="text-align:center"><input type="checkbox" class="form-check-input ordenes_enviar_inabve" style="text-align: center" value="'.$row["fecha"].','.$row["codigo"].','.$row["paciente"].'" id="n_item'.$cont.'"><span style="color:white">.</span></div>'; 
      $sub_array[] = date("d-m-Y",strtotime($row["fecha"]));
      $sub_array[] = strtoupper($row["paciente"]);
      $sub_array[] = $row["tipo_lente"];
      $sub_array[] = '<button type="button"  class="btn btn-sm bg-light" onClick="verEditar(\''.$row["codigo"].'\',\''.$row["paciente"].'\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';  
      $sub_array[] = '<i class="fas fa-image fa-2x" aria-hidden="true" style="color:blue" onClick="verImg(\''.$row["img"].'\',\''.$row["codigo"].'\',\''.$row["paciente"].'\')">';                                       
      $data[] = $sub_array;
      $cont++;
      
      }
      
      $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
      echo json_encode($results);
    
    break;


  case 'get_data_orden_barcode':

  if ($_POST["tipo_accion"]=="ing_lab") {
    $datos = $ordenes->get_ordenes_barcode_lab_id($_POST["cod_orden_act"],$_POST["tipo_accion"]);
  }else{
    $datos = $ordenes->get_ordenes_barcode_lab($_POST["cod_orden_act"]);
  }

    

  if(is_array($datos)==true and count($datos)>0){
      foreach($datos as $row){
      $output["id_orden"] = $row["id_orden"];
      $output["codigo"] = $row["codigo"];
      $output["fecha"] = date("d-m-Y",strtotime($row["fecha"]));
      $output["paciente"] = $row["paciente"];   
    }
    }else{
      $output = $datos;
    }
    
    echo json_encode($output);

    break;

    ///////////////BARCODE PROCESOS //////////

    case 'get_correlativo_accion_vet':

    $correlativo = $ordenes->get_correlativo_accion_veteranos();

    if (is_array($correlativo)==true and count($correlativo)>0) {
      foreach($correlativo as $row){                  
        $codigo = $row["correlativo_accion"];
        $cod = (substr($codigo,2,11))+1;
        $output["correlativo"] = "A-".$cod;
      }
    }else{
        $output["correlativo"] = "A-1";
    }
    echo json_encode($output);
    break;

//////////////////PROCESAR ORDENES BARCODE /////////////
    case 'procesar_ordenes_barcode':

    if ($_POST['tipo_accion']=='ing_lab') {
      $ordenes->recibirOrdenesLabBarcode();
      $mensaje = "Ok";
    }elseif ($_POST['tipo_accion']=='finalizar_lab') {///FINALIZAR LAB
      $ordenes->finalizarOrdenesLab();
      $mensaje = "Ok";
    }elseif ($_POST['tipo_accion']=='recibir_veteranos' or $_POST['tipo_accion']=='entregar_veteranos') {
      $comprobar_correlativo = $ordenes->compruebaCorrelativo($_POST['correlativo_accion']);
      if(is_array($comprobar_correlativo)==true and count($comprobar_correlativo)==0){
         $ordenes->recibirOrdenesVeteranos();
         $mensaje = "Ok";
      }else{
         $mensaje = 'Error';
      }     
    }elseif($_POST['tipo_accion']=='finalizar_orden_lab_completo') {
      $ordenes->finalizarOrdenesLabEnviar();
      $mensaje = "Ok";
    }

    echo json_encode($mensaje);    
    break;

    case 'listar_ordenes_recibidas_veteranos':
    $data = Array();
    $i=0;
    $datos = $ordenes->listarOrdenesRecibidasVeteranos();
    foreach ($datos as $row) { 
    $sub_array = array();

    $sub_array[] = $row["id_detalle_accion"];
    $sub_array[] = date("d-m-Y",strtotime($row["fecha"]))." ".$row["hora"];
    $sub_array[] = $row["codigo_orden"];
    $sub_array[] = $row["paciente"];
    $sub_array[] = $row["dui"];
    $sub_array[] = $row["tipo_lente"];
    $sub_array[] = '<button type="button"  class="btn btn-block bg-light" onClick="verEditar(\''.$row["codigo_orden"].'\',\''.$row["paciente"].'\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';  
    $sub_array[] = '<button type="button"  class="btn btn-block bg-light" onClick="modalImprimirActa(\''.$row["codigo_orden"].'\',\''.$row["paciente"].'\')"><i class="fa fa-file-pdf" aria-hidden="true" style="color:red"></i></button>';        
                                          
    $data[] = $sub_array;
    }
    
    $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
      echo json_encode($results);
    break;

    case 'listar_ordenes_entregadas_veteranos':
    $data = Array();
    $i=0;
    $datos = $ordenes->listarOrdenesEntregadasVeteranos();
    foreach ($datos as $row) { 
    $sub_array = array();

    $sub_array[] = $row["id_detalle_accion"];
    $sub_array[] = date("d-m-Y",strtotime($row["fecha"]))." ".$row["hora"];
    $sub_array[] = $row["codigo_orden"];
    $sub_array[] = $row["usuario"];
    $sub_array[] = $row["paciente"];
    $sub_array[] = $row["dui"];
    $sub_array[] = $row["tipo_lente"];
    $sub_array[] = '<button type="button"  class="btn btn-sm bg-light" onClick="verEditar(\''.$row["codigo_orden"].'\',\''.$row["paciente"].'\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';  
            
                                          
    $data[] = $sub_array;
    }
    
    $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
      echo json_encode($results);
    break;
    
  case 'listar_ordenes_de_envio':
    $data = Array();
    $i=0;
    $datos = $ordenes->listarOrdenesEnvio();
    foreach ($datos as $row) { 
    $sub_array = array();

    $sub_array[] = $row["id_orden_rec"];
    $sub_array[] = $row["correlativo_accion"];
    $sub_array[] = date("d-m-Y",strtotime($row["fecha"]))." ".$row["hora"];
    $sub_array[] = $row["usuario"];
    $sub_array[] = $row["cant"]." ordenes";
    $sub_array[] = '<form action="imprimirDespachoLabPdf.php" method="POST" target="_blank">
    <input type="hidden" name="correlativos_acc" value="'.$row['correlativo_accion'].'">
    <button type="submit"  class="btn btn-sm" style="background:#6d0202;color:white"><i class="fas fa-file-pdf"></i></button>
    </form>';  
            
                                          
    $data[] = $sub_array;
    }
    
    $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
      echo json_encode($results);
    break;


    case 'buscar_orden_graduacion':
       $orden = $ordenes->getOrdenesGraduaciones($_POST["od_esfera"],$_POST["od_cilindro"],$_POST["od_eje"],$_POST["od_adi"],$_POST["oi_esfera"],$_POST["oi_cilindro"],$_POST["oi_eje"],$_POST["oi_adi"]);
      $data = array();
      $results = array();
      $estado ='';
      $badge="";
      if (is_array($orden)==true and count($orden)>0) {
        foreach ($orden as $key) {
        if ($key["estado_aro"]=="0") {
          $estado ='Sin procesar';
          $badge="danger";
        }elseif($key["estado_aro"]=="2"){
          $estado ='Recibido en laboratorio';
          $badge="warning";
        }elseif($key["estado_aro"]=="3"){
          $estado ='En proceso';
          $badge="info";
        }else if($key[""]=="4"){
           $estado ='Despachado de laboratorio';
          $badge="success";
        }
        $output["id_orden"] = $key["id_orden"];
        $output["codigo"] = $key["codigo"];
        $output["fecha"] = date("d-m-Y",strtotime($key["fecha"]));
        $output["paciente"] = $key["paciente"];
        $output["estado_aro"] = '<span class="right badge badge-'.$badge.'" style="font-size:12px">'.$estado.'</span>';
        array_push($results,$output);
      }
      $data = $results;
      }else{
        $data = "Vacio";
      }
      
       echo json_encode($data);
      break;


    case 'cambiar_estado_aro_print':
        $ordenes->cambiaEstadoAroPrint();
    break;        
    case 'get_despacho_lab':

      $data = $ordenes->get_despacho_lab($_POST['n_despacho']);

      if(count($data) > 0){
        echo json_encode($data);
      }else{
        $mensaje = "vacio";
        echo json_encode($mensaje);
      }
    break;
    case 'set_ingreso_lab':
      
      $data = $_POST['data'];
      $ACCIONES = "ingresos_lab";
      foreach($data as $row){
        $ordenes->set_ingreso_lab($row['n_despacho'],$row['dui'],$row['paciente'],$ACCIONES,$_POST['tipo_acciones'],$_POST['laboratorio']);
      }
      $mensaje = "exito";
      echo json_encode($mensaje);
      break;
    case 'listar_ingreso_lab':
      $data = array();

      $datos = $ordenes->get_acciones_lab();
      // $sub_array[] = date("d-m-Y", strtotime($row["fecha"]));
      $contador = 0;
      foreach ($datos as $row) {
        $sub_array = array();
        $sub_array[] = $row["id_acc_lab"];
        $sub_array[] = $row["n_despacho"];
        $sub_array[] = $row["fecha_creacion"];
        $sub_array[] = $row["tipo_accion"];
        $sub_array[] = $row["laboratorio"];
        $sub_array[] = $row["dui"];
        $sub_array[] = $row["paciente"];
        $sub_array[] = '<button type="button" class="btn btn-sm bg-light" onClick="verOrdenLaboratorio(\'' . $row["dui"] . '\')"><i class="fa fa-eye" aria-hidden="true" style="color:blue"></i></button>';
        $data[] = $sub_array;
      }

      $results = array(
        "sEcho" => 1, //Información para el datatables
        "iTotalRecords" => count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
        "aaData" => $data
      );
      echo json_encode($results);
    break;
    case 'get_data_orden':
      $datos = $ordenes->get_data_orden($_POST["dui"]);
      echo json_encode($datos[0]);
    break;
}