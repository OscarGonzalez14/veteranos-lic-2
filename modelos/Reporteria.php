<?php
require_once("../config/conexion.php");

class Reporteria extends Conectar{

public function print_orden($codigo){

    $conectar= parent::conexion();
    parent::set_names(); 

    $sql = "select o.id_orden,o.fecha,o.paciente,o.dui,o.edad,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.avsc,o.avfinal,o.modelo_aro,o.marca_aro,o.horizontal_aro,o.vertical_aro,o.puente_aro,o.tipo_lente,o.codigo,o.codigo_lenti from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.codigo=?;";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);    
}

public function get_ordenes_recibir_lab($codigo){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "select*from orden_lab where id_orden=?;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$codigo);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function getItemsReporteOrdenes($correlativo){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "select o.telefono,o.paciente,o.dui,o.fecha as fecha_o,o.tipo_lente,o.codigo,d.codigo_orden,a.fecha,a.hora,a.usuario,a.ubicacion,o.tipo_lente,d.id_detalle_accion from orden_lab as o inner join detalle_acciones_veteranos as d on o.codigo=d.codigo_orden INNER join acciones_ordenes_veteranos as a on a.correlativo_accion=d.correlativo_accion where d.correlativo_accion=? order by o.fecha ASC;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$correlativo);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function getItemsSelect(){
$conectar= parent::conexion();
  parent::set_names();
  $sql = "select marca_aro,modelo_aro,horizontal_aro,vertical_aro,puente_aro,COUNT(modelo_aro) as cant,img from orden_lab where fecha between '2021-12-01' and '2022-05-09' GROUP by modelo_aro,marca_aro order by cant desc;";
  $sql=$conectar->prepare($sql);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);

}

//obterner citas segun día seleccionado
public function get_pacientes_citados($fecha,$sucursal){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "select*from citas where fecha = ? and sucursal=? order by id_cita ASC;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$fecha);
  $sql->bindValue(2,$sucursal);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}
public function datosIngresoBodega($correlativo){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "SELECT u.nombres,i.fecha,i.hora,i.bodega from ingreso_aros as i INNER join usuarios as u on u.id_usuario=i.id_usuario where i.n_ingreso=?;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$correlativo);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function detalle_ingresoBodega($id_ingreso){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "SELECT a.modelo,a.marca,a.color,a.material,i.cantidad from aros as a INNER JOIN detalle_ingreso_aros as i on a.id_aro=i.id_aro where i.n_ingreso=? order by material DESC;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$id_ingreso);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function stockSucursales($bodega){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "SELECT a.modelo,a.marca,a.color,a.material,s.stock from aros as a INNER JOIN stock_aros as s on a.id_aro=s.id_aro where s.bodega=? order by material DESC";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$bodega);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function getDetalleDespacho($n_despacho){
  $conectar = parent::conexion();
  parent::set_names();
  $sql = "SELECT * FROM `det_despacho_lab` where n_despacho=?;";
  $sql = $conectar->prepare($sql);
  $sql->bindValue(1, $n_despacho);
  $sql->execute();
  return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function getDataOrdenDui($dui){
  
    $conectar= parent::conexion();
    parent::set_names(); 

    $sql = "select o.id_orden,o.fecha,o.paciente,o.dui,o.edad,o.color,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.avsc,o.avfinal,o.tipo_lente,o.codigo,o.codigo_lenti,o.sucursal from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.dui=?;";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1,$dui);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 
       
}


public function get_data_ordenPac($codigo,$paciente){
  $conectar = parent::conexion();

  //Verificador para ver si tiene ingresado un aro en manuales
  $sql = "select *from orden_lab where codigo=? and paciente=?;";
  $sql = $conectar->prepare($sql);
  $sql->bindValue(1,$codigo);
  $sql->bindValue(2,$paciente);
  $sql->execute();
  $data = $sql->fetchAll(PDO::FETCH_ASSOC);

}

}///FIN DE LA CLASE





