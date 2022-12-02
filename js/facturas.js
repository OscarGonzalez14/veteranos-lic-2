document.addEventListener('DOMContentLoaded',()=>{
  listar_facturas_manuales();
  listar_facturas_ccf_manual();
})
var items_factura = [];
var total_manual = 0;
//Button Nueva factura

function ingreso_factura_manual() {
  $("#modal_factura_manual").modal('show');
  clear_input();
  items_factura = [];
  $("#det_manual").html('')
  $("#txt_num_factura").html("")
}


function EnterEvent(event) {
  if (event.keyCode == 13) {
    let cantidad = document.getElementById("cantfac").value;
    let desc = document.getElementById("desc_fact").value;
    let punit = document.getElementById("p_unit_fact").value;

    if (cantidad != "" && desc != "" && punit != "") {
      let item = {
        cantidad: cantidad,
        desc: desc,
        punit: punit,
        subt: 0
      }
      items_factura.push(item);
      document.getElementById("cantfac").value = "";
      document.getElementById("desc_fact").value = "";
      document.getElementById("p_unit_fact").value = "";
      $('#cantfac').focus();
      listar_items_man(items_factura);
    } else {
      Swal.fire({
        position: 'top-center',
        icon: 'warning',
        title: 'Debe completar los detalles del formulario',
        showConfirmButton: true,
        timer: 9500
      });
      return false;
    }
  }

}//Fin enter event

function listar_items_man(items_factura = []) {
  $('#det_manual').html('');
  let filas = "";
  var totales = 0;
  for (var i = 0; i < items_factura.length; i++) {
    let subt = parseFloat(items_factura[i].cantidad) * parseFloat(items_factura[i].punit);
    let subtotal = subt.toFixed(2);
    items_factura[i].subt = subtotal;
    filas = filas + "<tr id='fila" + i + "'>" +
      "<td style='text-align:center;' colspan='15'>" + items_factura[i].cantidad + "</td>" +
      "</td><td style='text-align:center;' colspan='50'>" + items_factura[i].desc + "</td>" +
      "</td><td style='text-align:center;' colspan='10'>$" + parseFloat(items_factura[i].punit).toFixed(2) + "</td>" +
      "</td><td style='text-align:center;' colspan='10'>$" + parseFloat(subtotal).toFixed(2) + "</td>" +
      "<td style='text-align:center' colspan='15'><i class='nav-icon fas fa-times-circle' onClick='eliminarFila(" + i + ");' style='color:red'></i></td>" +
      "</tr>"

  }
  $('#det_manual').html(filas);
  total_manual = items_factura.reduce((sum, value) => (sum + parseFloat(value.subt)), 0);
  //console.log(total_manual)
  $('#totales_man').html("$" + total_manual);
}

function eliminarFila(index) {
  $("#fila" + index).remove();
  drop_index(index);
}

function drop_index(position_element) {
  items_factura.splice(position_element, 1);
  //recalcular(position_element);
  listar_items_man(items_factura);

}

function sendDataFact() {
  //let contribuyente = $("input[type='radio'][name='contribuyente']:checked").val();
  let tam_array = items_factura.length;
  if (tam_array < 1) {
    Swal.fire({
      position: 'top-center',
      icon: 'warning',
      title: 'Por favor, rellenar el formulario!',
      showConfirmButton: true,
      timer: 9500
    });
    return false;
  }
  let telefono = $("#tel").val();
  let direccion = $("#dir").val();
  let retencion = $("#retencion").val();
  let fecha = $("#fecha_fac").val()
  let num_factura = $("#num_factura").val()
  let id_factura = $("#id_factura").val()
  if(validacion_input()){
    Swal.fire({
      position: 'top-center',
      icon: 'warning',
      title: 'Existen campos vacios!!',
      showConfirmButton: true,
      timer: 9500
    });
    return false;
  }
  if (retencion == "" || fecha == "") {
    Swal.fire({
      position: 'top-center',
      icon: 'error',
      title: 'Monto retencion es obligatorio',
      showConfirmButton: true,
      timer: 9500
    });
    return false;
  }

  let paciente = document.getElementById("cliente").value;
  data = Object.values(items_factura);
  //[window.location = ('imp_factura_manual.php?info='+ JSON.stringify(data));
  let objData = {
    info: data,
    cliente: paciente,
    direccion: direccion,
    telefono: telefono,
    retencion: retencion,
    fecha: fecha,
    subtotal: total_manual,
    cod_factura: num_factura,
    id_factura: id_factura
  }
  $.ajax({
    url: "../ajax/facturas.php?op=guardar_factura_manual",
    method: "POST",
    data: objData,
    cache: false,
    dataType: "json",
    success: function (data) {
      if(data == "exito"){
        Swal.fire({
          position: 'top-center',
          icon: 'success',
          title: '¡Factura ingresada!',
          showConfirmButton: true,
          timer: 2500
        });
        clear_input();
        $('#det_manual').html('');
        items_factura = [] // clear array
      }else if(data == "edit"){
        Swal.fire({
          position: 'top-center',
          icon: 'success',
          title: '¡Factura modificada!',
          showConfirmButton: true,
          timer: 2500
        });
      }
      $("#datatable_factura_manual").DataTable().ajax.reload(null, false);
      
    }
  });
  imprimir_factura_manual(objData) //Genera report
}

window.onkeydown = EnterEvent;
///// FUNCTION GENERAR FACTURA MANUAL //////
function imprimir_factura_manual(objData,type_factura = "") {

  var form = document.createElement("form");
  form.target = "blank";
  form.method = "POST";
  if(type_factura == "CCF_manual"){
    form.action = "imprimir_CCF_manual.php";
  }else{
    form.action = "imprimir_factura_manual.php";
  }

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "data";
  input.value = JSON.stringify(objData);
  form.appendChild(input);
  document.body.appendChild(form);

  form.submit();
  document.body.removeChild(form);
}

function clear_input(){
  let elements = document.getElementsByClassName("clear_input");

  $("#totales_man").html('')
  for (i = 0; i < elements.length; i++) {
    let id_element = elements[i].id;
    document.getElementById(id_element).value = "";
  }
}

function mayus(e) {
  e.value = e.value.toUpperCase();
}
function template_dt(id_dt,url,data = {}){
  $('#' + id_dt).DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
      'excelHtml5',
    ],

    "ajax": {
      url: url,
      type: "POST",
      data: data,
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },

    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 25,//Por cada 10 registros hace una paginación
    "order": [[0, "desc"]],//Ordenar (columna,orden)

    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }, //cerrando language
    //"scrollX": true
  });
}
function listar_facturas_manuales(){
  template_dt('datatable_factura_manual','../ajax/facturas.php?op=listar_facturas_manuales',{})
}
function listar_facturas_ccf_manual(){
  template_dt('datatable_factura_ccf_manual','../ajax/facturas.php?op=listar_facturas_ccf_manual',{});
}

function show_factura(id_factura){
  items_factura = []
  clear_input();
  $("#modal_factura_manual").modal('show');
  $.ajax({
    url: "../ajax/facturas.php?op=show_factura",
    method: "POST",
    data: { id_factura:id_factura },
    cache: false,
    dataType: "json",
    success: function (data) {
      $("#cliente").val(data.factura.cliente)
      $("#dir").val(data.factura.direccion)
      $("#tel").val(data.factura.telefono)
      $("#fecha_fac").val(data.factura.fecha)
      $("#num_factura").val(data.factura.num_factura)
      $("#txt_num_factura").html("No. Factura: " + data.factura.num_factura)
      $("#id_factura").val(data.factura.id_factura)
      $("#retencion").val(data.factura.retencion)
      for(let i = 0; i < data.det_factura_manual.length; i++){
        let item = {
          cantidad: data.det_factura_manual[i].cantidad,
          desc: data.det_factura_manual[i].descripcion,
          punit: data.det_factura_manual[i].p_unitario,
          subt: 0
        }

        items_factura.push(item)

      }
      listar_items_man(items_factura);
    }
  });
}

function show_factura_CCF_manual(id_factura){
  items_factura = []
  clear_input();
  $("#modal_CCF_manual").modal('show');
  //datatable_factura_ccf_manual
  $.ajax({
    url: "../ajax/facturas.php?op=show_factura",
    method: "POST",
    data: { id_factura:id_factura },
    cache: false,
    dataType: "json",
    success: function (data) {
      console.log(data)
      $("#cliente").val(data.factura.cliente)
      $("#dir").val(data.factura.direccion)
      $("#tel").val(data.factura.telefono)
      $("#fecha_fac").val(data.factura.fecha)
      $("#num_factura").val(data.factura.num_factura)
      $("#txt_num_factura").html("No. Factura: " + data.factura.num_factura)
      $("#id_factura").val(data.factura.id_factura)
      $("#retencion").val(data.factura.retencion)
      $("#giro").val(data.factura.giro)
      $("#nit").val(data.factura.nit)
      $("#num_registro").val(data.factura.no_registro)
      if(data.factura.gran_contribuyente == "SI"){
        $("#contribuyente").attr('checked',true)
      }else{
        $("#contribuyente").attr('checked',false)
      }
      for(let i = 0; i < data.det_factura_manual.length; i++){
        let item = {
          cantidad: data.det_factura_manual[i].cantidad,
          desc: data.det_factura_manual[i].descripcion,
          punit: data.det_factura_manual[i].p_unitario,
          subt: 0
        }

        items_factura.push(item)

      }
      listar_items_man(items_factura);
    }
  });
}

function delete_factura(id_factura){
  Swal.fire({
    title: '¿Estas seguro de eliminar esta factura?',
    showCancelButton: true,
    confirmButtonText: 'Si',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      $.ajax({
        url: "../ajax/facturas.php?op=delete_factura",
        method: "POST",
        data: { id_factura:id_factura },
        cache: false,
        dataType: "json",
        success: function (data) {
          if(data === "eliminado"){
            Swal.fire({
              position: 'top-center',
              icon: 'success',
              title: '¡Factura eliminada!',
              showConfirmButton: true,
              timer: 2500
            });
          }else{
            Swal.fire({
              position: 'top-center',
              icon: 'error',
              title: '¡Upps, ha ocurrido un error!',
              showConfirmButton: true,
              timer: 2500
            });
          }
          $("#datatable_factura_manual").DataTable().ajax.reload(null, false);
          $("#datatable_factura_ccf_manual").DataTable().ajax.reload(null, false);
        }
      });
    }
  })
}

//Funcion para Validacion de input

function validacion_input(){
  let items_input = document.getElementsByClassName('oblig')

  for (let i = 0; i < items_input.length; i++){
    let input = document.getElementById(items_input[i].id).value
    if(input == ""){
      return true;
    }
  }
}

/**
 * 
 *  FUNCIONES PARA COMPROBANTE DE CREDITO FISCAL
 *  AUTOR: DEVJOSE99
 * 
*/

function CFF_manual(){
  $("#modal_CCF_manual").modal('show');
  clear_input();
  items_factura = [];
  $("#det_manual").html('')
  $("#txt_num_factura").html("")
}

function send_CCF_manual(){
  let cliente = $("#cliente").val()
  let dir = $("#dir").val()
  let tel = $("#tel").val()
  let fecha_fac = $("#fecha_fac").val()
  let giro = $("#giro").val()
  let nit = $("#nit").val()
  let num_registro = $("#num_registro").val()
  let num_factura = $("#num_factura").val()
  let retencion = $("#retencion").val();
  let contribuyente = document.getElementById('contribuyente')
  let id_factura = $("#id_factura").val()
  if(contribuyente.checked){
    contribuyente = "SI"
  }else{
    contribuyente = "NO"
  }
  //Validacion
  let tam_array = items_factura.length;
  if (tam_array < 1) {
    Swal.fire({
      position: 'top-center',
      icon: 'warning',
      title: 'Por favor, rellenar el formulario!',
      showConfirmButton: true,
      timer: 9500
    });
    return false;
  }
  if(validacion_input()){
    Swal.fire({
      position: 'top-center',
      icon: 'warning',
      title: 'Existen campos vacios!!',
      showConfirmButton: true,
      timer: 9500
    });
    return false;
  }
  if (retencion == "" || fecha_fac == "") {
    Swal.fire({
      position: 'top-center',
      icon: 'error',
      title: 'Monto retencion es obligatorio',
      showConfirmButton: true,
      timer: 9500
    });
    return false;
  }

  let paciente = document.getElementById("cliente").value;
  data = Object.values(items_factura);
  //[window.location = ('imp_factura_manual.php?info='+ JSON.stringify(data));
  let objData = {
    info: data,
    cliente: cliente,
    direccion: dir,
    telefono: tel,
    retencion: retencion,
    fecha: fecha_fac,
    subtotal: total_manual,
    giro: giro,
    nit: nit,
    num_registro: num_registro,
    cod_factura: num_factura,
    id_factura: id_factura,
    contribuyente: contribuyente
  }
  
  $.ajax({
    url: "../ajax/facturas.php?op=procesar_CCF_manual",
    method: "POST",
    data: objData,
    cache: false,
    dataType: "json",
    success: function (data) {
      if(data == "exito"){
        Swal.fire({
          position: 'top-center',
          icon: 'success',
          title: '¡Factura ingresada!',
          showConfirmButton: true,
          timer: 2500
        });
        clear_input();
        $('#det_manual').html('');
        items_factura = [] // clear array
      }else if(data == "edit"){
        Swal.fire({
          position: 'top-center',
          icon: 'success',
          title: '¡Factura modificada!',
          showConfirmButton: true,
          timer: 2500
        });
      }
      
      $("#datatable_factura_ccf_manual").DataTable().ajax.reload(null, false);
    }
  });
  imprimir_factura_manual(objData,"CCF_manual") //Genera report
}