
document.querySelectorAll(".acc-acciones-opt").forEach(i => i.addEventListener("click", e => {
    let accion = i.dataset.acciones;
    $("#acc-optica").val(accion);
    if(accion=='ingreso_orden_optica'){
        $('#modal_acciones_veteranos').on('shown.bs.modal', function() {
            $("#get_data_orden").val("");
            $('#get_data_orden').focus();
        });
    }
}));

/* function alerts(){
    Swal.fire(msj
        'Orden editada!!',
        'Existosamente',
        'success'
    )
} */


var ordenes_ingresar = [];

function getOrdenAct() {
    let paciente_dui = $("#get_data_orden").val();
    paciente_dui = paciente_dui.replace("'","-");
    paciente_dui = document.getElementById('get_data_orden').value = paciente_dui
    let tipo_accion = $("#acc-optica").val();
  
    $.ajax({
      url: "../ajax/acciones_optica.php?op=get_data_orden_barcode",
      method: "POST",
      data: { paciente_dui: paciente_dui, tipo_accion: tipo_accion },
      cache: false,
      dataType: "json",
      success: function (data) {
      console.log(data.msj)
      if(data.msj=="ok"){
        let indice = ordenes_ingresar.findIndex((objeto, indice, ordenes_ingresar) => {
            return objeto.dui == data.datos.dui;
          });
         if(indice<0){
            let obj = {
                dui: data.datos.dui,
                paciente: data.datos.paciente,
                sucursal: data.datos.sucursal,
                fecha: data.datos.fecha,
                accion: tipo_accion
             }
            ordenes_ingresar.push(obj);
            $("#get_data_orden").val("");
            $('#get_data_orden').focus();
            listar_ordenes_registrar();
         }else{
            Swal.fire('Orden existe en la lista!!','Advertencia','warning');
            $("#get_data_orden").val("");
            $('#get_data_orden').focus();
         }
         
        }else if(data.msj=="vacio"){
            Swal.fire('Codigo invalido!!','Advertencia','error');
            $("#get_data_orden").val("");
            $('#get_data_orden').focus();
        }else if(data.msj=="error"){
            
            Swal.fire({
                title: 'Orden ya ha sido Ingresada',
                text: "Cofirmar que se trata de rectificación!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ingresar',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.isConfirmed) {
                    let indice = ordenes_ingresar.findIndex((objeto, indice, ordenes_ingresar) => {
                        return objeto.dui == data.datos.dui;
                      });
                    if(indice<0){
                    let obj = {
                        dui: data.datos.dui,
                        paciente: data.datos.paciente,
                        sucursal: data.datos.sucursal,
                        fecha: data.datos.fecha,
                        accion: 'ingreso_rectificacion'
                     }
                    ordenes_ingresar.push(obj);
                    $("#get_data_orden").val("");
                    $('#get_data_orden').focus(); 
                    listar_ordenes_registrar()
                   }else{
                    Swal.fire('Orden existe en la lista!!','Advertencia','warning')
                 }
              }
              })
        }
        
        
  
      }//Fin success
    });//Fin Ajax 

  }

  function listar_ordenes_registrar() {

    $("#items-ordenes-registrar").html('');
  
    let filas = "";
    let length_array = parseInt(ordenes_ingresar.length) - 1;
    for (let i = length_array; i >= 0; i--) {
  
      filas = filas +
        "<tr style='text-align:center' id='item_t" + i + "'>" +
        "<td>" + i + "</td>" +
        "<td>" + ordenes_ingresar[i].dui + "</td>" +
        "<td>" + ordenes_ingresar[i].fecha + "</td>" +
        "<td>" + ordenes_ingresar[i].paciente + "</td>" +
        "<td>" + ordenes_ingresar[i].sucursal + "</td>" +
        "<td>" + "<button type='button'  class='btn btn-sm bg-light' onClick='eliminarItemBarcodeOpt(" + i + ")'><i class='fa fa-times-circle' aria-hidden='true' style='color:red'></i></button>" + "</td>" +
        "</tr>";
    }
  
    $("#items-ordenes-registrar").html(filas);
  
  }

  function eliminarItemBarcodeOpt(index) {
    $("#item_t" + index).remove();
    ordenes_ingresar.splice(index, 1);
    $('#reg_ingresos_barcode').focus();
    listar_ordenes_registrar()    
  }

function registrarIngresoOrdenOpt(){
    $("#btn-acc-opt").attr('disabled',true);
    let tam_array = ordenes_ingresar.length;
    if(tam_array==0){Swal.fire('Lista vacia!!','Agregar ordenes de ingreso','warning'); return false}

    
    $.ajax({
      url: "../ajax/acciones_optica.php?op=registrar_accion",
      method: "POST",
      data: { 'arrayOrdenesAccOpt': JSON.stringify(ordenes_ingresar)},
      cache: false,
      dataType: "json",
      success: function (data) {
        console.log(data)
        if(data.msj=="success-act"){
          $("#btn-acc-opt").attr('disabled',false);
        }
      }//Fin success
    });

}