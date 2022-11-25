<?php

require_once("../config/conexion.php");  

  class Laboratorios extends Conectar{
   
    public function get_ordenes_filter_date($inicio,$fin,$estado_proceso){
    $conectar= parent::conexion();
    
    $sql= "select*from orden_lab where fecha between ? and ? and estado=? order by id_orden DESC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $inicio);
    $sql->bindValue(2, $fin);
    $sql->bindValue(3, $estado_proceso);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function get_rango_fechas_ordenes(){
  $conectar = parent::conexion();
  $sql= "select * from orden_lab";
  $sql=$conectar->prepare($sql);
  $sql->execute();
  return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
}

  public function recibirOrdenesLab(){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $detalle_recibidos = array();
    $detalle_recibidos = json_decode($_POST["arrayRecibidos"]);
    $usuario = $_POST["usuario"];

    foreach ($detalle_recibidos as $k => $v) {
      
      $codigoOrden = $v->codigo;
      $accion = "Recibir Lab";
      $destino = "-";

      $sql2 = "update orden_lab set estado_aro='2' where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->execute();

      $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1, $hoy);
      $sql->bindValue(2, $usuario);
      $sql->bindValue(3, $codigoOrden);
      $sql->bindValue(4, $accion);
      $sql->bindValue(5, $destino);
      $sql->execute();
    }
  }

  public function get_ordenes_procesando_lab(){
    $conectar= parent::conexion();
    parent::set_names();
    $sql= "select id_orden,codigo,paciente,dui,tipo_lente,fecha from orden_lab where estado=2";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

    public function finalizarOrdenesLab($usuario){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $fecha_creacion = date("Y-m-d");
    $detalle_finalizados = array();
    $detalle_finalizados = json_decode($_POST["arrayOrdenesBarcode"]);

    foreach ($detalle_finalizados as $k => $v) {
      
      $codigoOrden = $v->n_orden;
      $dui_paciente = $v->dui;
      $paciente = $v->paciente;
      $tipo_accion = "Finalizada orden Lab";
      $observaciones = "-";
      $destino = "-";

      $sql2 = "update orden_lab set estado=3 where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->execute();
       //para obtener el codigo
      $sql = "SELECT cod_ingreso FROM `acciones_lab` ORDER BY id_acc_lab DESC LIMIT 1;";
      $sql=$conectar->prepare($sql);
      $sql->execute();
      $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
      if(count($resultado) > 0){
        //ENV-1
        $cod_ingreso = $resultado[0]['cod_ingreso'];
        $cod_ingreso = explode("-",$cod_ingreso);
        $numero_unico = $cod_ingreso[1];
        $numero_unico += 1;
        $cod_ingreso = "INGR-".$numero_unico;
      }else{
        $cod_ingreso = "INGR-1";
      }

      //Insertado a acciones lab
      $acciones = "finalizada_orden_lab";
      
      $sql = "insert into acciones_lab values (null,?,?,?,?,?,?,?,?,?)";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1,$cod_ingreso);
      $sql->bindValue(2,$dui_paciente);
      $sql->bindValue(3,$paciente);
      $sql->bindValue(4,$acciones);
      $sql->bindValue(5,$tipo_accion);
      $sql->bindValue(6,"-");
      $sql->bindValue(7,$_SESSION['id_user']);
      $sql->bindValue(8,$hoy);
      $sql->bindValue(9,$fecha_creacion);
      $sql->execute();

      $sql = "insert into acciones_orden values(null,?,?,?,?,?,?);";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $hoy);
        $sql->bindValue(2, $usuario);
        $sql->bindValue(3, $codigoOrden);
        $sql->bindValue(4, $tipo_accion);
        $sql->bindValue(5, $observaciones);
        $sql->bindValue(6, $destino);
        $sql->execute();
    }
  }

////////////////////////////ORDENES FINALIZADAS  LABORATORIOS////////////////////
    public function finalizarOrdenesLabEnviar($usuario,$correlativo_envio){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador');
    $hoy = date("d-m-Y H:i:s");
    $fecha_creacion = date('Y-m-d');
    $detalle_finalizados = array();
    $detalle_finalizados = json_decode($_POST["arrayOrdenesBarcode"]);
    $ubicacion = '-';
    foreach ($detalle_finalizados as $k => $v) {
      
      $codigoOrden = $v->n_orden;
      $dui_paciente = $v->dui;
      $paciente = $v->paciente;
      $tipo_accion = "Enviada a optica";
      $destino = "-";
      $observaciones = "-";
      $sql2 = "update orden_lab set estado=4 where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      if($sql2->execute()){
        //para obtener el codigo
      $sql = "SELECT cod_ingreso FROM `acciones_lab` ORDER BY id_acc_lab DESC LIMIT 1;";
      $sql=$conectar->prepare($sql);
      $sql->execute();
      $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
      if(count($resultado) > 0){
        //ENV-1
        $cod_ingreso = $resultado[0]['cod_ingreso'];
        $cod_ingreso = explode("-",$cod_ingreso);
        $numero_unico = $cod_ingreso[1];
        $numero_unico += 1;
        $cod_ingreso = "INGR-".$numero_unico;
      }else{
        $cod_ingreso = "INGR-1";
      }
      //Insertando en detalle envio lab
        $sql_envio = "insert into detalle_ordenes_envio values (NULL,?,?,?,?)";
        $sql_envio = $conectar->prepare($sql_envio);
        $sql_envio->bindValue(1,$correlativo_envio);
        $sql_envio->bindValue(2,$codigoOrden);
        $sql_envio->bindValue(3,$_SESSION['id_user']);
        $sql_envio->bindValue(4,$fecha_creacion);
        $sql_envio->execute();
        //Insertado a acciones lab
        $acciones = "enviada_optica";
        
        $sql = "insert into acciones_lab values (null,?,?,?,?,?,?,?,?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$cod_ingreso);
        $sql->bindValue(2,$dui_paciente);
        $sql->bindValue(3,$paciente);
        $sql->bindValue(4,$acciones);
        $sql->bindValue(5,$tipo_accion);
        $sql->bindValue(6,"-");
        $sql->bindValue(7,$_SESSION['id_user']);
        $sql->bindValue(8,$hoy);
        $sql->bindValue(9,$fecha_creacion);
        $sql->execute();
        
        $sql = "insert into acciones_orden values(null,?,?,?,?,?,?);";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $hoy);
        $sql->bindValue(2, $usuario);
        $sql->bindValue(3, $codigoOrden);
        $sql->bindValue(4, $tipo_accion);
        $sql->bindValue(5, $observaciones);
        $sql->bindValue(6, $destino);
        $sql->execute();
      }
    }
  }


  public function get_ordeOrdenesFinalizadasEnviar(){
    $conectar= parent::conexion();
    parent::set_names();
    $sql= "select o.id_orden,o.codigo,o.fecha,o.paciente,o.tipo_lente from orden_lab as o WHERE estado=4";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get_ordenesFinalEnviadaLab(){
    $conectar= parent::conexion();
    parent::set_names();
    $sql= "select o.id_orden,o.codigo,o.fecha,o.dui,o.paciente,o.tipo_lente from orden_lab as o WHERE estado=4";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get_ordeOrdenesFinalizadas(){
    $conectar= parent::conexion();
    parent::set_names();
    $sql= "select o.id_orden,o.codigo,o.fecha,o.dui,o.paciente,o.tipo_lente from orden_lab as o WHERE estado=3";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function get_correlativo_detalle_envio(){
    $conectar= parent::conexion();
    parent::set_names();
    
    $sql = 'select cod_despacho from detalle_ordenes_envio order by id_ordenes_envio DESC limit 1;';
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
      
  }

  public function compruebaCorrelativo($correlativo_accion){
    $conectar= parent::conexion();
    parent::set_names();
    $sql = 'select correlativo_accion from acciones_ordenes_veteranos where correlativo_accion=?;';
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $correlativo_accion);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function recibirOrdenesVeteranos(){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); 
    $hoy = date("Y-m-d");
    $hora = date('H:i:s');
    $detalle_recibidos = array();
    $detalle_recibidos = json_decode($_POST["arrayOrdenesBarcode"]);

    $usuario = $_POST["usuario"];
    $tipo_accion = $_POST['tipo_accion'];
    $ubicacion = $_POST['ubicacion_orden'];
    $correlativo = $_POST["correlativo_accion"];

    //$tipo_accion == 'recibir_veteranos'? ($estado ='Recibido'; $accion = 'Ingreso'): ($estado='Entregado'; $accion='Entrega');
    if ($tipo_accion=='recibir_veteranos') {
      $estado ='Recibido'; $accion = 'Ingreso INABVE';
    }elseif ($tipo_accion=='entregar_veteranos') {
      $estado='Entregado'; $accion='Entrega INABVE';
    }
    

    $sql = 'insert into acciones_ordenes_veteranos values(null,?,?,?,?,?,?);';
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $correlativo);
    $sql->bindValue(2, $hoy);
    $sql->bindValue(3, $hora);
    $sql->bindValue(4, $usuario);
    $sql->bindValue(5, $accion);
    $sql->bindValue(6, $ubicacion);
    $sql->execute();

    foreach ($detalle_recibidos as $k => $v) {      
      $codigoOrden = $v->n_orden;

      $sql2 = "insert into detalle_acciones_veteranos values(null,?,?,?);";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->bindValue(2, $correlativo);
      $sql2->bindValue(3, $estado);
      $sql2->execute();
    }
    if ($tipo_accion=='entregar_veteranos') {
      $sql3 = 'update detalle_acciones_veteranos set estado="Entregado" where codigo_orden=?;';
      $sql3=$conectar->prepare($sql3);
      $sql3->bindValue(1, $codigoOrden);
      $sql3->execute();
    }

      $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1, $hoy." ".$hora);
      $sql->bindValue(2, $usuario);
      $sql->bindValue(3, $codigoOrden);
      $sql->bindValue(4, $accion);
      $sql->bindValue(5, $estado);
      $sql->execute();
  }
  
  public function listarOrdenesRecibidasVeteranos(){
       $conectar= parent::conexion();
    parent::set_names();
    $sql = 'select o.paciente,o.dui,d.codigo_orden,a.fecha,a.hora,a.usuario,a.ubicacion,o.tipo_lente,d.id_detalle_accion from orden_lab as o inner join detalle_acciones_veteranos as d on  o.codigo=d.codigo_orden INNER join acciones_ordenes_veteranos as a on a.correlativo_accion=d.correlativo_accion where d.estado="Recibido";';
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC); 
  }

  public function listarOrdenesEntregadasVeteranos(){
    $conectar= parent::conexion();
    parent::set_names();
    $sql = 'select o.paciente,o.dui,d.codigo_orden,a.fecha,a.hora,a.usuario,a.ubicacion,o.tipo_lente,d.id_detalle_accion from orden_lab as o inner join detalle_acciones_veteranos as d on  o.codigo=d.codigo_orden INNER join acciones_ordenes_veteranos as a on a.correlativo_accion=d.correlativo_accion where a.tipo_acccion="Entrega INABVE" and d.estado="Entregado";';
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC); 
  }
  
  public function listarOrdenesEnvio(){
  $conectar= parent::conexion();
  parent::set_names();

  $sql = 'SELECT det_o.id_ordenes_envio,det_o.cod_despacho,usuarios.usuario,COUNT(det_o.cod_despacho) as cant,o.codigo,det_o.fecha FROM `detalle_ordenes_envio` as det_o INNER JOIN orden_lab as o ON det_o.cod_orden_lab=o.codigo INNER JOIN usuarios ON det_o.id_usuario=usuarios.id_usuario GROUP by det_o.cod_despacho order by det_o.id_ordenes_envio DESC';
  $sql=$conectar->prepare($sql);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);

}

public function get_ordenes_barcode_lab($dui_paciente){

  $conectar = parent::conexion();
  $sql= "select orden_lab.id_orden,det_despacho_lab.id_det,det_despacho_lab.estado,det_despacho_lab.n_despacho,orden_lab.codigo,orden_lab.dui,orden_lab.paciente,orden_lab.fecha,orden_lab.sucursal from `det_despacho_lab` inner join orden_lab on det_despacho_lab.dui = orden_lab.dui where orden_lab.dui = ? and orden_lab.estado=3";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1, $dui_paciente);
  $sql->execute();
  return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

}
public function get_ordenes_despacho($dui_paciente){

  $conectar = parent::conexion();
  $sql= "select orden_lab.id_orden,det_despacho_lab.id_det,det_despacho_lab.estado,det_despacho_lab.n_despacho,orden_lab.codigo,orden_lab.dui,orden_lab.paciente,orden_lab.fecha,orden_lab.sucursal from `det_despacho_lab` inner join orden_lab on det_despacho_lab.dui = orden_lab.dui where orden_lab.dui = ? and orden_lab.estado=1 and det_despacho_lab.estado = 0";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1, $dui_paciente);
  $sql->execute();
  return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

}

public function get_ordenes_barcode_lab_id($dui_paciente){  

    $conectar = parent::conexion();
    $sql2 = "select orden_lab.id_orden,det_despacho_lab.id_det,det_despacho_lab.estado,det_despacho_lab.n_despacho,orden_lab.codigo,orden_lab.dui,orden_lab.paciente,orden_lab.fecha,orden_lab.sucursal from `det_despacho_lab` inner join orden_lab on det_despacho_lab.dui = orden_lab.dui where orden_lab.dui = ? and orden_lab.estado=2";
    $sql2=$conectar->prepare($sql2);
    $sql2->bindValue(1,$dui_paciente);
    $sql2->execute();
    $resultado = $sql2->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
    
  }

  public function getOrdenesGraduaciones($od_esfera,$od_cilindro,$od_eje,$od_adi,$oi_esfera,$oi_cilindro,$oi_eje,$oi_adi){
    $conectar = parent::conexion();
    parent::set_names();

    $eje_derecho = "%".$od_eje."%";
    $eje_izq= "%".$oi_eje."%";


    $sql2 = "select o.fecha,o.paciente,o.codigo,rx.codigo,o.id_orden,o.estado_aro from orden_lab as o INNER join rx_orden_lab as rx on o.codigo=rx.codigo where rx.od_esferas=? and rx.od_cilindros=? and rx.od_eje like ? and rx.od_adicion=? and rx.oi_esferas=? and rx.oi_cilindros=? and rx.oi_eje like ? and rx.oi_adicion=? and o.estado_aro='0' order by o.fecha ASC;";
    $sql2=$conectar->prepare($sql2);
    $sql2->bindValue(1, $od_esfera);
    $sql2->bindValue(2, $od_cilindro);
    $sql2->bindValue(3, $eje_derecho);
    $sql2->bindValue(4, $od_adi);
    $sql2->bindValue(5, $oi_esfera);
    $sql2->bindValue(6, $oi_cilindro);
    $sql2->bindValue(7, $eje_izq);
    $sql2->bindValue(8, $oi_adi);
    $sql2->execute();
    return $resultado = $sql2->fetchAll(PDO::FETCH_ASSOC);   

  }

  public function cambiaEstadoAroPrint(){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $detalle_recibidos = array();
    $detalle_recibidos = json_decode($_POST["arrayRCB"]);
    $usuario = $_POST["usuario"];

    foreach ($detalle_recibidos as $k) {
      
      $codigoOrden = $k;
      $accion = "Recibido en laboratorio";
      $destino = "A proceso";

      $sql2 = "update orden_lab set estado_aro='2' where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->execute();

      $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1, $hoy);
      $sql->bindValue(2, $usuario);
      $sql->bindValue(3, $codigoOrden);
      $sql->bindValue(4, $accion);
      $sql->bindValue(5, $destino);
      $sql->execute();
    }

  if($sql->rowCount() > 0 and $sql2->rowCount() > 0) {
      echo json_encode("Received");
  }

  }

  public function get_despacho_lab($n_despacho){
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "select orden_lab.id_orden,det_despacho_lab.id_det,det_despacho_lab.estado,det_despacho_lab.n_despacho,orden_lab.codigo,orden_lab.dui,orden_lab.paciente,orden_lab.fecha,orden_lab.sucursal from `det_despacho_lab` inner join orden_lab on det_despacho_lab.dui = orden_lab.dui where det_despacho_lab.n_despacho=? AND det_despacho_lab.estado = 0";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $n_despacho);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function ingreso_lab($n_despacho,$dui,$paciente,$acciones,$tipo_accion,$laboratorio){
    $conectar = parent::conexion();
    //$conexion_lenti = parent::conexion_lenti();
    $id_usuario = $_SESSION["id_user"];
    $user = $_SESSION['user'];
    $hoy = date("d-m-Y H:i:s");
    $fecha_creacion = date("Y-m-d");
    parent::set_names();
    //para obtener el codigo
    $sql = "SELECT cod_ingreso FROM `acciones_lab` ORDER BY id_acc_lab DESC LIMIT 1;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    if(count($resultado) > 0){
      //ENV-1
      $cod_ingreso = $resultado[0]['cod_ingreso'];
      $cod_ingreso = explode("-",$cod_ingreso);
      $numero_unico = $cod_ingreso[1];
      $numero_unico += 1;
      $cod_ingreso = "INGR-".$numero_unico;
    }else{
      $cod_ingreso = "INGR-1";
    }

    $sql = "insert into acciones_lab values (null,?,?,?,?,?,?,?,?,?)";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1,$cod_ingreso);
    $sql->bindValue(2,$dui);
    $sql->bindValue(3,$paciente);
    $sql->bindValue(4,$acciones);
    $sql->bindValue(5,$tipo_accion);
    $sql->bindValue(6,$laboratorio);
    $sql->bindValue(7,$id_usuario);
    $sql->bindValue(8,$hoy);
    $sql->bindValue(9,$fecha_creacion);
    if($sql->execute()){
      //Buscar orden para registrarlo en acciones orden
      $sql = "select codigo,sucursal from orden_lab where dui=?";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$dui);
      $sql->execute();
      $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
      $correlativo_op = $resultado[0]['codigo'];
      $sucursal = $resultado[0]['sucursal'];
      //Update a Orden
      $sql = "update orden_lab set estado=2 where dui=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1,$dui);
      $sql->execute();

      //Update det_despacho_lab
      $sql = "update det_despacho_lab set estado=1 where dui=? and n_despacho=?";
      $sql = $conectar->prepare($sql);
      $sql->bindValue(1,$dui);
      $sql->bindValue(2,$n_despacho);
      $sql->execute();

      //Inseted a acciones_orden
      $accion = "Ingreso a Laboratorio ".$laboratorio;
      if($tipo_accion == "REENVIO A LAB"){
        //Inserted lenti
        $accion = "Reenvio a Laboratorio ".$laboratorio;
      }

      $sql7 = "insert into acciones_orden values(null,?,?,?,?,?,?);";
      $sql7 = $conectar->prepare($sql7);
      $sql7->bindValue(1, $hoy);
      $sql7->bindValue(2, $_SESSION['user']);
      $sql7->bindValue(3, $correlativo_op);
      $sql7->bindValue(4, $accion);
      $sql7->bindValue(5, $accion);
      $sql7->bindValue(6, $sucursal);
      $sql7->execute();
    }
  }

  public function get_acciones_lab($dui = ""){
    $conectar = parent::conexion();
    parent::set_names();
    if($dui == ""){
      $sql = "select * from acciones_lab order by id_acc_lab DESC";
    }else{
      $sql = "select * from acciones_lab where dui=? order by id_acc_lab DESC";
    }
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$dui);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get_data_orden($dui){
    $conectar = parent::conexion();

    //Traer datos y relleno
    $sql = "select codigo,id_aro,institucion from orden_lab where dui=?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1,$dui);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $institucion = $result[0]['institucion'];
    $codigo = $result[0]['codigo'];
    $id_aro = $result[0]['id_aro'];

    //Verificador para ver si tiene ingresado un aro en manuales
    $sql = "select id_aro from aros_manuales where codigo_orden=?";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    if($institucion == "CONYUGE"){
        if($id_aro == 0){
          if(count($data) > 0){
            $sql = "select am.marca,am.modelo,am.color,am.material,titulares.id_titulares,titulares.titular,titulares.dui_titular,o.id_orden,o.id_cita,o.genero,o.sucursal,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.patologias,o.lente_oi,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.color as colorTratamiento,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo INNER JOIN titulares ON titulares.codigo=o.codigo INNER JOIN aros_manuales as am ON o.codigo=am.codigo_orden where o.codigo = ? and rx.codigo = ? ";
          }else{
            $sql = "select titulares.id_titulares,titulares.titular,titulares.dui_titular,o.id_orden,o.id_cita,o.genero,o.sucursal,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.patologias,o.lente_oi,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.color as colorTratamiento,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo INNER JOIN titulares ON titulares.codigo=o.codigo where o.codigo = ? and rx.codigo = ? ";
          }

        }else{
            $sql = "select titulares.id_titulares,titulares.titular,titulares.dui_titular,o.id_orden,o.id_cita,o.genero,o.sucursal,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,aros.marca,aros.modelo,aros.color,aros.material,aros.id_aro,o.patologias,o.lente_oi,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.color as colorTratamiento,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo INNER JOIN titulares ON titulares.codigo=o.codigo INNER JOIN aros ON o.id_aro = aros.id_aro where o.codigo = ? and rx.codigo = ? ";
        }

    }else if($id_aro == 0){
      if(count($data) > 0){
        $sql = "select am.marca,am.modelo,am.color,am.material,o.id_orden,o.id_cita,o.genero,o.sucursal,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.patologias,o.lente_oi,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.color as colorTratamiento,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo INNER JOIN aros_manuales as am ON o.codigo=am.codigo_orden where o.codigo = ? and rx.codigo = ? ";
      }else{
        $sql = "select o.id_orden,o.id_cita,o.genero,o.sucursal,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.patologias,o.lente_oi,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.color as colorTratamiento,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.codigo = ? and rx.codigo = ? ";
      }
      
    }else{
      $sql = "select o.id_orden,o.id_cita,o.genero,o.sucursal,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.patologias,o.lente_oi,aros.marca,aros.modelo,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,aros.id_aro,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,aros.color,o.color as colorTratamiento,aros.material,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo INNER JOIN aros ON o.id_aro = aros.id_aro where o.codigo = ? and rx.codigo = ? ";
    }
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->bindValue(2,$codigo);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataOrdenLenti($dui){
    $conectar= parent::conexion();
    parent::set_names();
    $sql = 'select*from orden_lab where dui=?;';
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$dui);    
    $sql->execute();
    $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
    $id_aro = $resultado[0]["id_aro"];
    if($id_aro=="0"){
      $sql="select o.genero,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion,a.marca,a.modelo,a.color,a.material,o.color as trat from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo INNER JOIN aros_manuales as a on a.codigo_orden=o.codigo where o.dui =?;";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$dui);
      $sql->execute();
      return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
    }else {
      $sql="select o.genero,o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi,o.depto,o.municipio,o.institucion,a.marca,a.modelo,a.color,a.material,o.color as trat from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo INNER JOIN aros as a on a.id_aro=o.id_aro where o.dui =?;";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$dui);
      $sql->execute();
      return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
    }
  }

}

