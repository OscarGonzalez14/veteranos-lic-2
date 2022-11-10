<?php

require_once("../config/conexion.php");

class Despachos extends Conectar{
  
    public function getDespachos(){
        $conectar = parent::conexion();
        parent::set_names();
    }

    public function getCorrelativoEnvio(){
        $conectar = parent::conexion();
        $sql= "select n_despacho from despachos_lab order by id_despacho DESC limit 1;";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);

        if(count($resultado)==0){
            $correlativo = "ENV-1";
        }else{
            foreach($resultado as $row){
                $corr = $row["n_despacho"];
            }
            $nuevo_corr = substr($corr,4,20);
            $correlativo = "ENV-".((int)$nuevo_corr +(int)1);
        }
        return $correlativo;
    }

    public function registrarDespachos(){
        $conectar = parent::conexion();
        parent::set_names();

        date_default_timezone_set('America/El_Salvador');
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");

        $sucursal = $_POST['sucursal'];
        $id_usuario = $_POST["id_usuario"];

        $ordenes = array();
        $ordenes = json_decode($_POST["ordenes_desp"]);

        $correlativo = $this->getCorrelativoEnvio();

        $sql = "insert into despachos_lab values(null,?,?,?,?,?)";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $correlativo);
        $sql->bindValue(2, $hoy);
        $sql->bindValue(3, $hora);
        $sql->bindValue(4, $id_usuario);
        $sql->bindValue(5, $sucursal);
        $sql->execute();

        foreach($ordenes as $key=>$v){
            $sql2 = "insert into det_despacho_lab values(null,?,?,?);";
            $sql2 = $conectar->prepare($sql2);
            $sql2->bindValue(1, $correlativo);
            $sql2->bindValue(2, $v->dui);
            $sql2->bindValue(3, $v->paciente);
            $sql2->execute();
        } 
        $msj = ["correlativo"=>$correlativo];
        echo json_encode($msj);
    }

}