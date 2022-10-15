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

}////Fin de la clase