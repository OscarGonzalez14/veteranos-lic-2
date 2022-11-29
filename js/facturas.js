document.addEventListener('DOMContentLoaded',()=>{
  listar_facturas_manuales();
})
var items_factura = [];
var total_manual = 0;
//Button Nueva factura

function ingreso_factura_manual() {
  $("#modal_factura_manual").modal('show');
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
      listar_items_man();
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

function listar_items_man() {
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
  console.log(total_manual)
  $('#totales_man').html("$" + total_manual);
}

function eliminarFila(index) {
  $("#fila" + index).remove();
  drop_index(index);
}

function drop_index(position_element) {
  items_factura.splice(position_element, 1);
  //recalcular(position_element);
  listar_items_man();

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
    info: JSON.stringify(data),
    cliente: paciente,
    direccion: direccion,
    telefono: telefono,
    retencion: retencion,
    fecha: fecha,
    subtotal: total_manual,
    cod_factura: num_factura
  }
  console.log(objData)
  $.ajax({
    url: "../ajax/facturas.php?op=guardar_factura_manual",
    method: "POST",
    data: { dataCliente: objData,info: JSON.parse(objData.info) },
    cache: false,
    dataType: "json",
    success: function (data) {
      if(data == "exito"){
        Swal.fire({
          position: 'top-center',
          icon: 'success',
          title: 'Factura ingresada. No. ' + cod_factura,
          showConfirmButton: true,
          timer: 2500
        });
      }
      console.log(data)
    }
  });
  imprimir_factura_manual(objData) //Genera reporte
  clear_input();
  $('#det_manual').html('');
  items_factura = [] // clear array
}

window.onkeydown = EnterEvent;
///// FUNCTION GENERAR FACTURA MANUAL //////
function imprimir_factura_manual(objData) {

  var form = document.createElement("form");
  form.target = "blank";
  form.method = "POST";
  form.action = "imprimir_factura_manual.php";

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

function listar_facturas_manuales(){
  $('#datatable_factura_manual').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
      'excelHtml5',
    ],

    "ajax": {
      url: "../ajax/facturas.php?op=listar_facturas_manuales",
      type: "POST",
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