
<?php ob_start();
use Dompdf\Dompdf;
use Dompdf\Options;

require_once '../dompdf/autoload.inc.php';
require_once ('../config/conexion.php');
require_once ('../modelos/Reporteria.php');
date_default_timezone_set('America/El_Salvador'); 
//$hoy = date("d-m-Y");
//$dateTime= date("d-m-Y H:i:s");

$citas = new Reporteria();
$fecha_cita = $_POST["fecha-cita"];
?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>.::Citas - Veteranos::.</title>
   <link rel="stylesheet" href="../estilos/styles.css">
  <style>

  body{
    font-family: Helvetica, Arial, sans-serif;
    font-size: 12px;
  }

  html{
    margin-top: 5px;
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
    font-size: 13px;
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
  hr {
  page-break-after: always;
  border: 0;
  margin: 0;
  padding: 0;
}
  </style>

</head>

<html>
<body>

<?php 

$tam_array = count($sucursales_array);
for ($i = 0 ;$i < $tam_array; $i++) {
  echo $sucursales_array[$i]."<br>";
}
/*   foreach ($citados as $key){
    $sucursal =  $key["sucursal"];
    $fecha_cita =  $key["fecha"];
    include '../helpers/plantilla_citados.php';
  } */


?>

  

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