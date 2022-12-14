<?php

require_once("../config/conexion.php");

class Citados extends Conectar
{

    public function listar_pacientes_citados($user_sucursal)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT * FROM `citas` WHERE citas.sucursal=:sucursal AND citas.estado != 1";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':sucursal', $user_sucursal);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_citados_pend()
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "select * from citas where estado='0';";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDataCitaId($id_cita){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from citas where id_cita=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cita);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDataCitasSucursal($sucursal, $fecha){
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "select * from citas where id_cita=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cita);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDataCitadosSucursal($fecha)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from citas where fecha=? order by sucursal;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fecha);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDataCitadosSucursalPrint($sucursal,$fecha){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from citas where sucursal=? and fecha=?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $sucursal);
        $sql->bindValue(2, $fecha);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHorasSelect($fecha,$sucursal){
        $conectar = parent::conexion();
        parent::set_names();
        $sql2 = "SELECT hora FROM `citas` where fecha = ? and sucursal = ?;";
        $sql2 = $conectar->prepare($sql2);
        $sql2->bindValue(1, $fecha);
        $sql2->bindValue(2, $sucursal);
        $sql2->execute();
        return  $resultado = $sql2->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCitadosAtendAll($fecha)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql2 = "select * FROM `citas` where fecha = ? order by sucursal DESC;";
        $sql2 = $conectar->prepare($sql2);
        $sql2->bindValue(1, $fecha);
        $sql2->execute();
        return  $resultado = $sql2->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateCitas(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update citas set paciente=?,dui=?,fecha=?,sucursal=?,telefono=?,edad=?,ocupacion=?,genero=?,sector=?,depto=?,municipio=?,hora=?,vet_titular=?,dui_titular=?,tel_opcional=?,tipo_paciente=? where id_cita=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $_POST["paciente"]);
        $sql->bindValue(2, $_POST["dui"]);
        $sql->bindValue(3, $_POST["fecha"]);
        $sql->bindValue(4, $_POST["sucursal"]);
        $sql->bindValue(5, $_POST["telefono"]);
        $sql->bindValue(6, $_POST["edad"]);
        $sql->bindValue(7, $_POST["ocupacion"]);
        $sql->bindValue(8, $_POST["genero"]);
        $sql->bindValue(9, $_POST["sector"]);
        $sql->bindValue(10, $_POST["depto"]);
        $sql->bindValue(11, $_POST["municipio"]);
        $sql->bindValue(12, $_POST["hora"]);
        $sql->bindValue(13, $_POST["titular"]);
        $sql->bindValue(14, $_POST["dui_titular"]);
        $sql->bindValue(15, $_POST["tel_opcional"]);
        $sql->bindValue(16, $_POST["tipo_paciente"]);
        $sql->bindValue(17, $_POST["id_cita"]);
        $sql->execute();

        echo json_encode(["msj"=>"Ok"]);


}

public function getDisponibilidadCitas($fecha){
    $conectar=parent::conexion();    
    parent::set_names();
    $sql = "select nombre from sucursales";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    $sucursales=$sql->fetchAll(PDO::FETCH_ASSOC);
    $data_disponibilidad = array();
    foreach($sucursales as $s){
        
        $cita = "SELECT count(*) as citados from citas WHERE fecha=? and sucursal=?";
        $cita=$conectar->prepare($cita);
        $cita->bindValue(1, $fecha);
        $cita->bindValue(2, $s["nombre"]);
        $cita->execute();
        $total_citas=$cita->fetchAll(PDO::FETCH_ASSOC);
        $citados =  $total_citas[0]['citados'];

        $cupo = "select cupos,direccion,referencia,optica from sucursales where nombre=?";
        $cupo=$conectar->prepare($cupo);
        $cupo->bindValue(1, $s["nombre"]);
        $cupo->execute();
        $total_cupos=$cupo->fetchAll(PDO::FETCH_ASSOC);
        $cupo_disp =  $total_cupos[0]['cupos'];
        $direccion =  strtoupper($total_cupos[0]['direccion']);
        $referencia =  strtoupper($total_cupos[0]['referencia']);
        $optica =  strtoupper($total_cupos[0]['optica']);


        $disponibilidad = ($cupo_disp-$citados)."/".$cupo_disp;
        $disp_act= $cupo_disp-$citados;
        $dias = array('Domingo', 'Lunes', 'Martes', 'Mi??rcoles','Jueves', 'Viernes', 'S??bado');
        $fechats = strtotime($fecha); //fecha en yyyy-mm-dd
        $dia= $dias[date('w', $fechats)];
        if($disp_act>0){
            if(($s["nombre"] == "Sonsonate" and $dia =="Jueves")){

            }else{
                array_push($data_disponibilidad,array("sucursal"=>$s["nombre"],"cupos"=>$disponibilidad,"direccion"=>$direccion,"referencia"=>$referencia,"optica"=>$optica));
            }
        }
    }

        echo json_encode($data_disponibilidad);

        //echo json_encode(["msj" => "OLK"]);
}

    public function updateEstadoCita($id_cita){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE citas SET estado = '1' WHERE citas.id_cita = :id_cita";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':id_cita',$id_cita);
        if($sql->execute()){
            return true;
        }
        //echo json_encode(["msj" => "OLK"]);
    }

    public function comprobarImpresion($dui){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select dui from hoja_atencion where dui=?;";
        $sql= $conectar->prepare($sql);
        $sql->bindValue(1, $dui);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    public function getCorrelativoImpAsistencia($sucursal,$fecha){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select corr_diario from hoja_atencion where sucursal=? and fecha_imp=? order by id_imp DESC limit 1;";
        $sql= $conectar->prepare($sql);
        $sql->bindValue(1, $sucursal);
        $sql->bindValue(2, $fecha);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(count($resultado)==0){
            $correlativo = 1;
        }else{
            foreach($resultado as $r){
             $correlativo = (int)$r["corr_diario"]+1;
            }
        }

        return $correlativo;

    }

    public function getDataAsistencia($dui,$fecha,$sucursal){
        $conectar = parent::conexion();
        parent::set_names();
        $data_validacion = $this->comprobarImpresion($dui);
       if(count($data_validacion)>0){
        echo  json_encode(["msj"=>"existe"]);
       }else{
        $correlativo = $this->getCorrelativoImpAsistencia($sucursal,$fecha);
        $sql = "insert into hoja_atencion values(null,?,?,?,?)";
       }
    }

}////Fin de la clase