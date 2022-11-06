<?php

require_once("../config/conexion.php");

class Actas extends Conectar{
    
    public function getCorrelativoactaSuc($sucursal){
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "select correlativo_sucursal from actas where sucursal=? order by id_acta DESC limit 1;";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $sucursal);
        $sql->execute();
        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);    
        if (is_array($resultado) == true and count($resultado) > 0) {
            foreach ($resultado as $row) {
              $corr = substr($row["correlativo_sucursal"], 2, 15) + 1;
              $correlativo = "A-". $corr;
            }
          } else {
            $correlativo = "A-1";
          }
        return $correlativo;
    }

    public function registrarActa($codigo_orden,$titular,$nombre_receptor,$receptor,$sucursal,$id_usuario){

        $conectar = parent::conexion();
        parent::set_names();

        date_default_timezone_set('America/El_Salvador'); 
        $hoy = date("d-m-Y");
        $hora = date(" H:i:s");
        $correlativo=$this->getCorrelativoactaSuc($sucursal);
        $sql = "insert actas values (null,?,?,?,?,?,?,?,?,?);";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $codigo_orden);
            $sql->bindValue(2, $titular);
            $sql->bindValue(3, $hoy);
            $sql->bindValue(4, $hora);
            $sql->bindValue(5, $receptor);
            $sql->bindValue(6, $nombre_receptor);
            $sql->bindValue(7, $id_usuario);
            $sql->bindValue(8, $sucursal);
            $sql->bindValue(9, $correlativo);
            $sql->execute();
        
            $sql2 = "select*from actas where codigo_orden=? and beneficiario=? order by id_acta desc limit 1;";
            $sql2 = $conectar->prepare($sql2);
            $sql2->bindValue(1, $codigo_orden);
            $sql2->bindValue(2, $titular);
            $sql2->execute();
            $data=$sql2->fetchAll(PDO::FETCH_ASSOC);
            $id_acta = $data[0]["id_acta"];
            $correlativo_sucursal = $data[0]["correlativo_sucursal"];

            $msj = array("id"=>$id_acta,"correlativo_sucursal"=>$correlativo_sucursal);
            echo json_encode($msj);

                
    }
}

