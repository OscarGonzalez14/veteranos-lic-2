<?php

require_once("../config/conexion.php");  

class Facturas extends Conectar{

    public function guardar_factura_manual($cod_factura,$cliente,$direccion,$telefono,$retencion,$fecha,$subtotal,$arrayInfo){
        $conectar= parent::conexion();
        date_default_timezone_set('America/El_Salvador');
        $fecha_hora = date("d-m-Y H:i:s");
        $date = date('Y-m-d');
        $sql1 = "insert into facturas values(null,?,?,?,?,?,?,?)";
        $sql1 = $conectar->prepare($sql1);
        $sql1->bindValue(1,$cod_factura);
        $sql1->bindValue(2,$cliente);
        $sql1->bindValue(3,$telefono);
        $sql1->bindValue(4,$direccion);
        $sql1->bindValue(5,$retencion);
        $sql1->bindValue(6,$fecha);
        $sql1->bindValue(7,$fecha_hora);
        if($sql1->execute()){
            $id_factura = $conectar->lastInsertId();
            foreach($arrayInfo as $row){
                $sql2 = "insert into det_facturas values(null,?,?,?,?)";
                $sql2 = $conectar->prepare($sql2);
                $sql2->bindValue(1,$row['cantidad']);
                $sql2->bindValue(2,$row['desc']);
                $sql2->bindValue(3,$row['punit']);
                $sql2->bindValue(4,$id_factura);
                $sql2->execute();
            }
            return true;
        }else{
            return false;
        }

    }

    public function listar_facturas_manuales(){
        $conectar = parent::conexion();
        $sql = "select * from facturas order by id_factura";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show_factura($array_data){
        $conectar = parent::conexion();
        //DONDE SEAN SOLO FACTURA
        $sql = "SELECT * FROM `facturas` WHERE id_factura=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1,$array_data['id_factura']);
        $sql->execute();
        $datosFactura = $sql->fetchAll(PDO::FETCH_ASSOC);
        //DATOS DE LA FACTURA
        $sql2 = "SELECT * FROM `det_facturas` WHERE factura_id=?";
        $sql2 = $conectar->prepare($sql2);
        $sql2->bindValue(1,$array_data['id_factura']);
        $sql2->execute();
        $det_factura = $sql2->fetchAll(PDO::FETCH_ASSOC);
        //Structura para entregar al controller
        $data = [
            "factura" => $datosFactura[0],
            "det_factura_manual" => $det_factura
        ];
        return $data;
    }

    public function update_factura_manual($id_factura,$cod_factura,$cliente,$direccion,$telefono,$retencion,$fecha,$subtotal,$arrayInfo){

        $conectar= parent::conexion();
        date_default_timezone_set('America/El_Salvador');
        $fecha_hora = date("d-m-Y H:i:s");
        $date = date('Y-m-d');
        $sql1 = "update facturas set num_factura=?,cliente=?,telefono=?,direccion=?,retencion=?,fecha=? where id_factura=?";
        $sql1 = $conectar->prepare($sql1);
        $sql1->bindValue(1,$cod_factura);
        $sql1->bindValue(2,$cliente);
        $sql1->bindValue(3,$telefono);
        $sql1->bindValue(4,$direccion);
        $sql1->bindValue(5,$retencion);
        $sql1->bindValue(6,$fecha);
        $sql1->bindValue(7,$id_factura);
        if($sql1->execute()){
            //Eliminación
            $sql_del_fact = "delete from det_facturas where factura_id=?";
            $sql_del_fact = $conectar->prepare($sql_del_fact);
            $sql_del_fact->bindValue(1,$id_factura);
            $sql_del_fact->execute();

            foreach($arrayInfo as $row){
                $sql2 = "insert into det_facturas values(null,?,?,?,?)";
                $sql2 = $conectar->prepare($sql2);
                $sql2->bindValue(1,$row['cantidad']);
                $sql2->bindValue(2,$row['desc']);
                $sql2->bindValue(3,$row['punit']);
                $sql2->bindValue(4,$id_factura);
                $sql2->execute();
            }
            return true;
        }else{
            return false;
        }

    }

    public function delete_factura($id_factura){
        $conectar = parent::conexion();
        $sql1 = "delete from facturas where id_factura=?";
        $sql1 = $conectar->prepare($sql1);
        $sql1->bindValue(1,$id_factura);
        if($sql1->execute()){
            return true;
        }else{
            return false;
        }
    }

}