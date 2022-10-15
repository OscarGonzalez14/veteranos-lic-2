<?php
 require_once("../config/conexion.php");  

   class Productos extends Conectar{

   	public function valida_existe_aro($modelo,$color,$marca){
    	   $conectar=parent::conexion();
        parent::set_names();

        $sql ="select*from aros where modelo=? and color=? and marca=?;";
        $sql= $conectar->prepare($sql);
        $sql->bindValue(1, $modelo);
        $sql->bindValue(2, $color);
        $sql->bindValue(3, $marca);
        $sql->execute();
        return $resultado=$sql->fetchAll();
   	}

   	public function crear_aro($marca,$modelo,$color,$material){
        $conectar=parent::conexion();
        parent::set_names();

        $sql = "insert into aros values(null,?,?,?,?)";
        $sql= $conectar->prepare($sql);
        $sql->bindValue(1, $marca);
        $sql->bindValue(2, $modelo);
        $sql->bindValue(3, $color);
        $sql->bindValue(4, $material);
        $sql->execute();

        echo json_encode(["msj"=>"ok"]);
        
   	}

   	public function get_aros(){
   	   $conectar=parent::conexion();
        parent::set_names();

        $sql="select*from aros ORDER BY id_aro DESC;";
        $sql= $conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();


   	}

   	public function get_data_aro_id($id_aro){
   		$conectar=parent::conexion();
        parent::set_names();

        $sql = "select*from aros where id_aro=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_aro);
        $sql->execute();
        return $resultado=$sql->fetchAll();

   	}

   	public function eliminar_aro($id_aro){
   		$conectar=parent::conexion();
        parent::set_names();

        $sql ="delete from aros where id_aro=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_aro);
        $sql->execute();

   	}

}//Fin de la clase