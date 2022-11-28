<?php ob_start();
use Dompdf\Dompdf;
use Dompdf\Options;

require_once '../dompdf/autoload.inc.php';
require_once '../modelos/Reporteria.php';
date_default_timezone_set('America/El_Salvador');
$hoy = date("d-m-Y");
$dateTime= date("d-m-Y H:i:s");

$reporteria = new Reporteria();
$codigo_despacho = $_POST['cod_despacho'];
$data = $reporteria->get_detalle_ordenes_envio($codigo_despacho);
$arraySucursales = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <link rel="stylesheet" href="../estilos/styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>.::Reportes::.</title>
	<style>
	body{
      font-family: Helvetica, Arial, sans-serif;
      font-size: 12px;
    }
    html{
	    margin-top: 5px;
	    margin-left: 20px;
	    margin-right:20px; 
	    margin-bottom: 0px;
    }
    #pacientes {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
      font-size: 11px;
      text-align:center;
      text-transform: uppercase;
    }

    #pacientes td, #pacientes th {
      border: 1px solid #ddd;
      padding: 3px;
    }

    #pacientes tr:nth-child(even){background-color: #f2f2f2;}

    #pacientes tr:hover {background-color: #ddd;}

    #pacientes th {
      padding-top: 3px;
      padding-bottom: 3px;
      text-align: center;
      background-color: #4c5f70;
      color: white;
    }
	</style>
</head>
<body>
<?php
foreach($data as $row){
  array_push($arraySucursales, $row['sucursal']);
}
$arraySucursales = array_values(array_unique($arraySucursales));
$cont_array = count($arraySucursales);
for ($i = 0; $i < $cont_array; $i++){
  $sucursal = $arraySucursales[$i];
  $datosReporte = $reporteria->get_detalle_ordenes_envio_sucursal($codigo_despacho,$sucursal);
  $count_array = count($datosReporte);
  if($count_array > 0){
?>

<table style="width: 100%;margin-top:2px">
<tr>
<td width="25%" style="width: 10%;margin:0px">
	<img src='../dist/img/inabve.jpg'  width="100" height="80"/ style="margin-top: 7px">
	<img src='../dist/img/lenti_logo.jpg' width="80" height="60"/></td>
</td>
	
<td width="50%" style="width: 75%;margin:0px">
<table style="width:100%">
  <tr>
    <td  style="text-align: center;margin-top: 0px;font-size:15px;font-family: Helvetica, Arial, sans-serif;"><b>ORDENES FINALIZADAS</b></td>
  </tr>
</table><!--fin segunda tabla-->
</td>
<td width="25%" style="width: 30%;margin:0px">
<table>
  <tr>
    <td style="text-align:right; font-size:12px;color: #008C45"><strong>ORDEN</strong></td>
  </tr>
  <tr>
    <td style="color:red;text-align:right; font-size:12px;color: #CD212A"><strong >No.&nbsp;<span><?php echo $codigo_despacho; ?></strong></td>
  </tr>
</table><!--fin segunda tabla-->
</td> <!--fin segunda columna-->
</tr>
</table>

<table width="100%" style="width: 100%;margin-top: 0px i !important " >
  <tr>
    <td colspan="25" style="width: 25%"><input type="text" class="input-report" value="Fecha envio: <?php echo $hoy;?>"></td>
    <td colspan="38" style="width: 38%;text-align: left;"><input type="text" class="input-report" value="Enviado por: "></td>
    <td colspan="37" style="width: 37%;text-align: left;"><input type="text" class="input-report" value="Mensajero: "></td>    
  </tr>
  <tr>
    <td colspan="25" style="width: 25%"><input type="text" class="input-report" value="Cant. ordenes: <?php echo count($datosReporte);?>"></td>  
    <td colspan="38" style="width: 37%;text-align: left;"><input type="text" class="input-report" value="Firma-Sello: "></td>
    <td colspan="37" style="width: 38%;text-align: left;"><input type="text" class="input-report" value="Recibido por: "></td>    
  </tr>
</table>
<table style="width:100%">
 <tr style="text-align:center;margin-top:0px;font-size:15px;font-family: Helvetica, Arial, sans-serif;text-transform: uppercase"><td><u  style="text-align:center;">  <b>SUCURSAL: <?php echo $sucursal?> </u></b></td>
 </tr>
</table>
 <b><h5 style="font-size:12px;font-family: Helvetica, Arial, sans-serif;text-align: center;margin-bottom: 0px"> DETALLE DE ENVÍO</h5></b>
	<table width="100%" id="pacientes" style="margin-top: 0px">
    <tr>
    <th>#</th>
    <th>Cod. Orden</th>
    <th>Fecha</th>
    <th>Paciente</th>
    <th>Dui</th>
    <th>Telefono</th>
    <th>Tipo lente</th>
  </tr>  
  <?php
  $cont = 1;
  foreach ($datosReporte as $value) { ?>
    <tr> 
     <td><?php echo $cont; ?></td>
     <td><?php echo $value['codigo']; ?></td>
     <td><?php echo date("d-m-Y",strtotime($value["fecha"])); ?></td>
     <td><?php echo $value['paciente']; ?></td>
     <td><?php echo $value['dui']; ?></td>
     <td><?php echo $value['telefono']; ?></td>
     <td><?php echo $value['tipo_lente']; ?></td>
    </tr> 

  <?php $cont++; } ?>  
  </table>
  <?php 
  //Validación de pagina
  if($i < ($cont_array - 1) ){
    echo '<div style="page-break-after:always;"></div>';
  }
  }//Fin if
}//Fin for 

$salida_html = ob_get_contents();
ob_end_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($salida_html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$dompdf->stream('document', array('Attachment'=>'0'));

?>
</body>
</html>