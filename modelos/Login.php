<?php

require_once("config/conexion.php");

class Login extends Conectar{

  public function listar_permisos_por_usuario($id_usuario){
    $conectar=parent::conexion();
    $sql="select * from usuario_permiso where id_usuario=?";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $id_usuario);
    $sql->execute();
    return $resultado=$sql->fetchAll();
 }
  
public function login_users(){
  $conectar=parent::conexion();
  parent::set_names();
  if(isset($_POST["enviar"])){
//********VALIDACIONES  DE ACCESO*****************
  $password = $_POST["pass"];
  $usuario = $_POST["usuario"];
  $sucursal = $_POST["sucursal-user"];

  if(empty($usuario) or empty($password)){
      header("Location:index.php?m=2");
      exit();
    }else { 
      
    $sql= "select * from usuarios where usuario=? and pass=? and sucursal=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $usuario);
        $sql->bindValue(2, $password);
        $sql->bindValue(3, $sucursal);
        $sql->execute();
        $results = $sql->fetch();

    if(is_array($results) and count($results)>0){
        $_SESSION["id_user"] = $results["id_usuario"];           
        $_SESSION["user"] = $results["usuario"];
        $_SESSION["categoria"] = $results["categoria"];
        $_SESSION["sucursal"] = $results["sucursal"];

        $marcados = $this->listar_permisos_por_usuario($results["id_usuario"]);
        print_r($marcados);
        $valores=array();
        foreach($marcados as $row){
          $valores[]= $row["id_permiso"];
        }
        $_SESSION['permisos'] = $valores;
       
      header("Location:vistas/home.php");
      exit();
    } else {                         
    //si no existe el registro entonces le aparece un mensaje
    header("Location:index.php?m=1");
    exit();
    } 
  }//cierre del else
  }//condicion enviar
}///FIN FUNCION LOGIN

}