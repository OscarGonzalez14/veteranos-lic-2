<!-- The Modal -->
  <div class="modal" id="barcode_ingresos_lab" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">    
    <div class="modal-dialog" style="max-width: 85%">
      <div class="modal-content">      
        <!-- Modal Header -->
        <div class="modal-header" style="background: #162e41;color: white">
          <h4 class="modal-title" style="font-size: 14px;font-family: Helvetica, Arial, sans-serif;"><b><span id="c_accion"></span></b></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <input type="text" class="form-control" id="reg_ingresos_barcode" onchange="getOrdenBarcode()">

          <button type="button" class="btn btn-default float-right btn-sm " onClick="registrarBarcodeOrdenes()" style='margin: 3px'><i class=" fas fa-file-export" style="color: #0275d8"></i> Registrar</button>

          <a id="reportes_vets"><button type="button" class="btn btn-default float-right btn-sm" style='margin: 3px;' onClick='imprimirEnviosLabPDF()'><i class="fas fa-file-pdf" style="color: red"></i> Imprimir</button></a>

          <table class="table-hover table-bordered" style="font-family: Helvetica, Arial, sans-serif;max-width: 100%;text-align: left;margin-top: 5px !important" width="100%" id="tabla_acciones_veterans">

          <thead style="font-family: Helvetica, Arial, sans-serif;width: 100%;text-align: center;font-size: 12px;" class="bg-dark">
            <th>ID</th>
            <th>#Orden</th>
            <th>Fecha</th>
            <th>Paciente</th>
            <th>Eliminar</th>
          </thead>
          <tbody id="items-ordenes-barcode" style="font-size: 12px"></tbody>
        </table>

        </div> 
        
        <audio id="success_sound"><source src="../Beep.mp3" type="audio/mp3"></audio>
        <audio id="error_sound"><source src="../error-beep.wav" type="audio/wav"></audio> 
        <!-- Modal footer -->
       
      </div>
    </div>
  </div>