<?php
$fecha = "2022-11-13";
$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves', 'Viernes', 'Sábado');
$fechats = strtotime($fecha); //fecha en yyyy-mm-dd
$dia= $dias[date('w', $fechats)];
echo $dia;