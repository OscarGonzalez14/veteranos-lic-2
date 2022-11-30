<?php

  require_once("../config/conexion.php");
  

   class AccionesOptica extends Conectar{
   ///////////////////////GET DATA //////////////
   public function verificarExisteAccion($dui,$accion){
    $conectar= parent::conexion();
    $sql= "select * from acciones_optica where dui=? and accion=?";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$dui);
    $sql->bindValue(2,$accion);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
   }


   public function get_dataOrden($dui,$tipo_accion){
    $conectar= parent::conexion();
    $resp_accion = $this->verificarExisteAccion($dui,$tipo_accion);

        $sql= "select * from orden_lab where dui=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$dui);
        $sql->execute();
        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);   

    if(count($resp_accion)==0 and count($resultado)>0){
        echo json_encode(["msj"=>"ok","datos"=>$resultado[0]]);
    }elseif(count($resp_accion)>0 and count($resultado)>0){
        echo json_encode(["msj"=>"error","datos"=>$resultado[0]]);
    }elseif(count($resultado)==0){
        echo json_encode(["msj"=>"vacio"]);
    }
   }
    
}
