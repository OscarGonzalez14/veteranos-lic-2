
<?php ob_start();
use Dompdf\Dompdf;
use Dompdf\Options;

require_once '../dompdf/autoload.inc.php';
require_once ('../config/conexion.php');
require_once ('../modelos/Reporteria.php');
require_once ('../modelos/Ordenes.php');
date_default_timezone_set('America/El_Salvador'); 
$hoy = date("d-m-Y");
$dateTime= date("d-m-Y H:i:s");
$hora = date("H:i");
$citas = new Reporteria();
$orden = new Ordenes();

$codigo=$_POST["codigo"];
$paciente = $_POST["paciente"];
$tipo_receptor = $_POST["tipo-receptor"];
$receptor = $_POST["receptor"];
$dui_receptor = $_POST["dui-receptor"];
$id_acta = $_POST["id_acta"];
$correlativo_suc = $_POST["correlativo_suc"];

$data_orden = $orden->get_data_orden($codigo,$paciente);
$sector = $data_orden[0]["institucion"];
$dui = $data_orden[0]["dui"];
$genero = $data_orden[0]["genero"];
if($sector=="FAES"){
    $sector = "veterano";
}elseif($sector=="FMLN"){
    $sector="ex-combatiente";
}elseif($sector=="CONYUGE"){
    $sector = "conyuge";
}
?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>.::Actas - Veteranos::.</title>
   <link rel="stylesheet" href="../estilos/styles.css">
  <style>

  body{
    font-family: Helvetica, Arial, sans-serif;
    font-size: 12px;
  }

  html{
    margin-top: 2px;
    margin-left: 10px;
    margin-right:10px; 
    margin-bottom: 0px;
  }
 
.input-report{
    font-family: Helvetica, Arial, sans-serif;
    border: none;
    border-bottom: 2.2px dotted #C8C8C8;
    text-align: left;
    background-color: transparent;
    font-size: 14px;
    width: 100%;
    padding: 10px
  } 

  #watermark {
        position: fixed;
        top: 15%;
        margin-left: 5.2%;
        width: 100%;
        opacity: .20;    
        z-index: -1000;
  }
  </style>

</head>

<body>

<html>
<div id="watermark">
<img src="../dist/img/Logo_Gobierno.jpg" width="700" height="700"/>
</div>

<table style="width: 100%;margin-top:2px" width="100%">
<td width="15%" style="width:15%;margin:0px">
  <img src='../dist/img/inabve.jpg' width="120" height="90"/>
</td>
  
<td width="60%" style="width:75%;margin:0px">
<table style="width:100%; margin-top:15px" >
  <br>
  <tr >
    <td  style="text-align: center;margin-top: 0px;font-size:14px;font-family: Helvetica, Arial, sans-serif;"><b>DEPARTAMENTO DE PROGRAMAS DE SALUD E INSUMOS MEDICOS</b></td>
  </tr>


  <tr>
    <td  style="text-align:center;margin-top:0px;font-size:18px;font-family: Helvetica, Arial, sans-serif;text-transform: uppercase"><b>ACTA DE ENTREGA <span style="color:#ee6b6e"> # <?php echo $id_acta?></span> </b></td>
  </tr>
</table>
</td>

<td style="width:15%;">
  <img src='../dist/img/logo_avplus.jpg' width="85" height="55" style="margin-top:20px;">
</td>
</table><!--fin tabla-->
<?php if($tipo_receptor=="beneficiario"){?>
<p style="font-family: Helvetica, Arial, sans-serif;font-size: 14 px;padding: 5px;line-height: 180%">A las <b><?php echo $hora?></b> horas del <b><?php echo $hoy?> </b> en <span><b>San Salvador, El Salvador</b></span>  se hace la entrega formal a <b><?php echo $paciente;?></b>,<br> con DUI: <b><?php echo $dui?></b>, genero <?php echo $genero?> sector <b><?php echo $sector;?></b>.</p> <br>
<?php }?>

<br>

<?php if($tipo_receptor=="tercero"){?>

<?php if($tipo_receptor=="tercero"){?>
<p style="font-family: Helvetica, Arial, sans-serif;font-size: 14 px;padding: 5px;line-height: 180%">A las <b><?php echo $hora?></b> horas del <b><?php echo $hoy?> </b> en <span><b>San Salvador, El Salvador</b></span>  se hace la entrega formal a <b><?php echo $receptor;?></b> con DUI: <b><?php echo $dui_receptor?></b>.<br>

Los lentes de <b><?php echo $paciente;?></b> con DUI: <b><?php echo $dui?></b>, genero <?php echo $genero?> sector <b><?php echo $sector;?></b>.</p> <br>
<?php }?>

<?php }?>
    <span style="font-size:14px">Dicho suministro se entrega de acuerdo con el siguiente detalle: 
</span><br><br>

<table width="100%" style="width: 100%;margin-top: 30px !important;"  class="tabla_reporte_citas">
<tr>
   <th colspan="25" style="width:25%">CANTIDAD</th>
   <th colspan="25" style="width:25%">UNIDAD DE MEDIDA</th>
   <th colspan="50" style="width:50%">DESCRIPCION</th>   

 </tr>
 <tr style="background: none ">
   <td colspan="25" style="width:25%">1</td>
   <td colspan="25" style="width:25%">UNIDAD</td>
   <td colspan="50" style="width:50%">
   <ul style="text-align:left">
  <li>ARO AND VAS A2021</li>
  <li>LENTE BIFOCAL</li>
  <li>TRATAMIENTO PHOTOCROMATICO</label></li>
  <li>ESTUCHE</li>
  <li>FRANELA</li>
  <li>SPRAY DE LIMPIEZA</li>
</ul></td>   
 </tr>
</table>
<br><br><br><br>
Hago constar que que he recibido el servicio 
<br>
<span style="font-family: Helvetica, Arial, sans-serif;font-size: 14 px;padding: 5px">
    Y no habiendo mas que hacer constar en la presente acta firmamos: 
</span>
<br><br><br>
<table width="100%" style="width: 100%;margin-top: 20px i !important " class="tabla_reporte_citas">
  <tr>
    <td colspan="45" style="width: 45%"><input type="text" class="input-report" value="Entrega:"></td>
    <td colspan="10" style="width: 10%"><input type="text" class="" value=""></td>
    <td colspan="45" style="width: 45%;"><input type="text" class="input-report" value="Recibe: "></td>
  
  </tr>
  <tr style="margin-top:40px">
    <td colspan="45" style="width: 45%"><input type="text" class="input-report" value="F."></td>
    <td colspan="10" style="width: 10%"><input type="text" class="" value=""></td>
    <td colspan="45" style="width: 45%;"><input type="text" class="input-report" value="F. "></td>
  
  </tr>

</table>
</body>
</html>

<?php
$salida_html = ob_get_contents();
ob_end_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($salida_html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('document', array('Attachment'=>'0'));
?>