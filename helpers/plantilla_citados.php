
<table style="width: 100%;margin-top:2px" width="100%">
<td width="25%" style="width:10%;margin:0px">
  <img src='../dist/img/inabve.jpg' width="90" height="70"/>
</td>
  
<td width="60%" style="width:75%;margin:0px">
<table style="width:100%">
  <br>
  <tr>
    <td  style="text-align: center;margin-top: 0px;font-size:18px;font-family: Helvetica, Arial, sans-serif;"><b>CITAS DE PACIENTES - INAVBE</b></td>
  </tr>
  <tr>
    <td  style="text-align:center;margin-top:0px;font-size:14px;font-family: Helvetica, Arial, sans-serif;"><b>FECHA: <?php echo date("d-m-Y",strtotime($fecha_cita)); ?></b></td>
  </tr>
  <tr>
    <td  style="text-align:center;margin-top:0px;font-size:15px;font-family: Helvetica, Arial, sans-serif;text-transform: uppercase"><u><b>SUCURSAL: <?php echo $sucursal?> </u></b></td>
  </tr>
</table>
</td>

<td width="25%" style="width:15%;margin:0px">
  <img src='../dist/img/logo_avplus.jpg' width="60" height="35" style="margin-top:25px;"></td>
</table><!--fin tabla-->

<table width="100%" style="width: 100%;margin-top: 0px i !important " >
  <tr>
    <td colspan="25" style="width: 38%"><input type="text" class="input-report" value="Revisado por:"></td>
    <td colspan="38" style="width: 25%;text-align: left;"><input type="text" class="input-report" value="Firma: "></td>
    <td colspan="37" style="width: 37%;text-align: left;"><input type="text" class="input-report" value="Sello: "></td>    
  </tr>
</table>
<table width="100%" id="tabla_reporte_citas" data-order='[[ 0, "desc" ]]' style="margin: 3px">        
 <tr>
   <th colspan="5" style="width:5%">#</th>
   <th colspan="10" style="width:10%">DUI</th>
   <th colspan="10" style="width:10%">Teléfono</th>   
   <th colspan="40" style="width:40%">Nombre</th>
   <th colspan="20" style="width:20%">Firma</th>
   <th colspan="15" style="width:15%">Observaciones</th>
 </tr>
 <tbody class="style_th" style="font-size:11px">
 <?php
 $data = $citas->get_pacientes_citados($fecha_cita,$sucursal);
  $i=1;
  foreach ($data as $value) { ?>
    <tr> 
     <td colspan="5" style="padding:3px;width:5%;padding:10px"><?php echo $i;?></td>
     <td colspan="10" style="padding:3px;width:10%"><?php echo $value["dui"]; ?></td>
     <td colspan="10" style="padding:3px;width:10%"><?php echo $value["telefono"]; ?></td>
     <td colspan="40" style="padding:3px;width:40%"><?php echo $value["paciente"]; ?></td>
     <td colspan="20" style="padding:3px;width:20%"></td>
     <td colspan="15" style="padding:3px;width:15%"></td>
    </tr> 

  <?php $i++; } ?>  
 </tbody>
</table>
<div style="page-break-after:always;"></div>
