<?php

require_once("../config/conexion.php");

class Citados extends Conectar{

    public function listar_pacientes_citados(){
	    $conectar=parent::conexion();
        parent::set_names();

        $sql = "select * from citas;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);        
    }

    public function listar_citados_pend(){
	    $conectar=parent::conexion();
        parent::set_names();

        $sql = "select * from citas where estado='0';";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);        
    }

    public function getDataCitaId($id_cita){
	    $conectar=parent::conexion();
        parent::set_names();

        $sql = "select * from citas where id_cita=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$id_cita);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);        
    }

    public function getDataCitasSucursal($sucursal,$fecha){
        $conectar=parent::conexion();
        parent::set_names();

        $sql = "select * from citas where id_cita=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$id_cita);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDataCitadosSucursal($sucursal,$fecha){
        $conectar=parent::conexion();
        parent::set_names();
        $sucursal = substr($sucursal,2);
        $sql = "select * from citas where sucursal=? and fecha=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$sucursal);
        $sql->bindValue(2,$fecha);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function getDataCitadosSucursalPrint($sucursal,$fecha){
        $conectar=parent::conexion();
        parent::set_names();
         $sql = "select * from citas where sucursal=? and fecha=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$sucursal);
        $sql->bindValue(2,$fecha);
        $sql->execute();
        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function getHorasSelect($fecha){
        $conectar=parent::conexion();
        parent::set_names();
        $sql2 = "SELECT hora FROM `citas` where fecha = ?;";
        $sql2=$conectar->prepare($sql2);
        $sql2->bindValue(1,$fecha);
        $sql2->execute();
        return  $resultado=$sql2->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getCitadosAtendAll($fecha){
    $conectar=parent::conexion();
    parent::set_names();
    $sql2 = "select * FROM `citas` where fecha = ? order by sucursal DESC;";
    $sql2=$conectar->prepare($sql2);
    $sql2->bindValue(1,$fecha);
    $sql2->execute();
    return  $resultado=$sql2->fetchAll(PDO::FETCH_ASSOC);
}


public function updateCitas(){
    $conectar=parent::conexion();
    parent::set_names();
    $sql = "update citas set paciente=?,dui=?,fecha=? where id_cita=?";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$_POST["paciente"]);
    $sql->bindValue(2,$_POST["dui"]);
    $sql->bindValue(3,$_POST["fecha"]);
    $sql->bindValue(4,$_POST["id_cita"]);
    $sql->execute();

    echo json_encode(["msj"=>"OLK"]);

}
}////Fin de la clase