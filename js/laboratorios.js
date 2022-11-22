var old_despachos_lab = []
var new_despachos_lab = []
function init() {
  listar_ordenes_procesando_lab();
  get_ordenes_procesando();
  ///get_ordenes_recibidas_lab();
  listar_ordenes_rec_vet();
  listar_ordenes_entregas_vet()
  get_ordenes_procesando_envios();
  listar_ordenes_de_envio();
  listar_ingreso_lab();
}
init();

/*========RECIBIR E IMPRIMIR=======*/



$(".modal-header").on("mousedown", function (mousedownEvt) {
  let $draggable = $(this);
  let x = mousedownEvt.pageX - $draggable.offset().left,
    y = mousedownEvt.pageY - $draggable.offset().top;
  $("body").on("mousemove.draggable", function (mousemoveEvt) {
    $draggable.closest(".modal-dialog").offset({
      "left": mousemoveEvt.pageX - x,
      "top": mousemoveEvt.pageY - y
    });
  });
  $("body").one("mouseup", function () {
    $("body").off("mousemove.draggable");
  });
  $draggable.closest(".modal").one("bs.modal.hide", function () {
    $("body").off("mousemove.draggable");
  });

});
/////////////////detectar clic en acciones labs
document.querySelectorAll(".barcode_actions").forEach(i => i.addEventListener("click", e => {
  items_barcode = [];
  getCorrelativoAccionVet();
  document.getElementById('reportes_vets').style.display = 'none';
  document.getElementById('items-ordenes-barcode').innerHTML = '';
  input_focus_clearb();
}));

/******************/
document.querySelectorAll(".barcode_actions_chk").forEach(i => i.addEventListener("click", e => {
  getCorrelativoAccionVet();
}));


///////////////// detectar clic en acciones veteranos
document.querySelectorAll(".barcode_actions_vets").forEach(i => i.addEventListener("click", e => {
  items_barcode = [];
  input_focus_clearb();
  getCorrelativoAccionVet();
  show_items_barcode_lab();

}));
listar_ordenes_pend_lab()
function listar_ordenes_pend_lab(buscar = "no",estado_ordenes="") {

  let inicio_fecha = $("#desde_orders_lab_pend").val();
  let hasta_fecha = $("#hasta_orders_lab_pend").val();

  let estado_proceso = estado_ordenes;
  
 if(buscar === "si" && estado_ordenes != ""){
  if ((inicio_fecha == undefined || inicio_fecha == null || inicio_fecha == "") || (hasta_fecha == undefined || hasta_fecha == null || hasta_fecha == "")) {
    Swal.fire({
      position: 'top-center',
      icon: 'error',
      title: 'Especificar todos los filtros',
      showConfirmButton: true,
      timer: 2500
    });
    return false
  }
 }

  tabla_ordenes = $('#ordenes_pendientes_lab').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
      'excelHtml5',
    ],
    "ajax": {
      url: "../ajax/laboratorios.php?op=get_ordenes_pendientes_lab",
      type: "POST",
      dataType: "json",
      data: { inicio: inicio_fecha, hasta: hasta_fecha, estado_proceso: estado_proceso },
      error: function (e) {
        console.log(e.responseText);
      },
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 48,//Por cada 10 registros hace una paginación
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
  });
}

function verImg(img, codigo, paciente) {
  document.getElementById("imagen_aro_v").src = "";
  $("#imagen_aro_orden").modal("show");
  document.getElementById("imagen_aro_v").src = "images/" + img;
  $("#cod_orden_lab").html(codigo);
  $("#paciente_ord_lab").html(paciente);
}


/**************************
  ARREGLO ORDENES RECIBIR
***************************/
var ordenes_recibir = [];
$(document).on('click', '.ordenes_recibir_lab', function () {
  let id_orden = $(this).attr("value");
  let id_item = $(this).attr("id");
  let codigo = $(this).attr("name");

  let checkbox = document.getElementById(id_item);
  let check_state = checkbox.checked;

  if (check_state) {
    let obj = {
      id_orden: id_orden,
      codigo: codigo
    }
    ordenes_recibir.push(obj);
    $("input[aria-controls='ordenes_pendientes_lab']").val('');
    let inputs = document.getElementsByClassName('form-control-sm');
    for (let i = 0; i < inputs.length; i++) { inputs[i].id = "input_enviar" }
    document.getElementById('input_enviar').autofocus = true;

  } else {
    let indice = ordenes_recibir.findIndex((objeto, indice, ordenes_recibir) => {
      return objeto.id_orden == id_orden
    });
    ordenes_recibir.splice(indice, 1);
    $("input[aria-controls='ordenes_pendientes_lab']").val('');
  }
  orders = [];
  for (var i = 0; i < ordenes_recibir.length; i++) {
    orders.push(ordenes_recibir[i].id_orden);
  }
  let codes = orders.reverse();
  let rec = codes.toString();
  let fecha_ini = $('#desde_orders_lab_pend').val();
  let fecha_fin = $('#hasta_orders_lab_pend').val();
  $('#inicio_rec').val(fecha_ini);
  $('#fin_rec').val(fecha_fin);
  document.getElementById("ordenes_imp").value = rec;
});


function recibirOrdenesLab() {

  let count = ordenes_recibir.length;
  if (count == 0) {
    Swal.fire({
      position: 'top-center',
      icon: 'error',
      title: 'Orden de recibidos vacio',
      showConfirmButton: true,
      timer: 2500
    });
    return false
  }

  $("#count_select").html(count);
  $("#modal_ingreso_lab").modal('show');
  console.log(ordenes_recibir);
  orders = [];
  for (var i = 0; i < ordenes_recibir.length; i++) {
    orders.push(ordenes_recibir[i].id_orden);
  }
}

function confirmarIngresoLab() {
  let usuario = $("#usuario").val();
  let n_ordenes = ordenes_recibir.length;
  $.ajax({
    url: "../ajax/laboratorios.php?op=recibir_ordenes_laboratorio",
    method: "POST",
    data: { 'arrayRecibidos': JSON.stringify(ordenes_recibir), 'usuario': usuario },
    cache: false,
    dataType: "json",
    success: function (data) {
      $("#ordenes_pendientes_lab").DataTable().ajax.reload();
      ordenes_recibir = [];
      $("#modal_ingreso_lab").modal("hide");
      Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Se han recibido ' + n_ordenes + ' ordenes',
        showConfirmButton: true,
        timer: 50500
      });

    }
  });
}
function listar_ordenes_procesando_lab() {
  tabla_ordenes = $('#ordenes_procesando_lab').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
      'excelHtml5',
    ],

    "ajax": {
      url: "../ajax/laboratorios.php?op=get_ordenes_procesando_lab",
      type: "POST",
      //dataType: "json",
      //data:{inicio:inicio,hasta:hasta},           
      error: function (e) {
        console.log(e.responseText);
      },
    },

    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 30,//Por cada 10 registros hace una paginación
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

/*******************************
  ARREGLO ORDENES PROCESANDO
********************************/
var ordenes_procesando = [];
$(document).on('click', '.ordenes_procesando_lab', function () {
  let id_orden = $(this).attr("value");
  let id_item = $(this).attr("id");
  let codigo = $(this).attr("name");

  let checkbox = document.getElementById(id_item);
  let check_state = checkbox.checked;

  if (check_state) {
    let obj = {
      id_orden: id_orden,
      codigo: codigo
    }
    ordenes_procesando.push(obj);
    $("input[aria-controls='ordenes_pendientes_lab']").val('');
    let inputs = document.getElementsByClassName('form-control-sm');
    for (let i = 0; i < inputs.length; i++) { inputs[i].id = "input_enviar" }
    document.getElementById('input_enviar').autofocus = true;
  } else {
    let indice = ordenes_procesando.findIndex((objeto, indice, ordenes_procesando) => {
      return objeto.id_orden == id_orden;
      $("input[aria-controls='ordenes_pendientes_lab']").val('');
      let inputs = document.getElementsByClassName('form-control-sm');
      for (let i = 0; i < inputs.length; i++) { inputs[i].id = "input_enviar" }
      document.getElementById('input_enviar').autofocus = true;
    });
    ordenes_procesando.splice(indice, 1)
  }

  orders_entregas = [];
  for (var i = 0; i < ordenes_procesando.length; i++) {
    orders_entregas.push(ordenes_procesando[i].id_orden);
  }

  let rec = orders_entregas.toString();
  document.getElementById("ordenes_imp_finish").value = rec;

});

////////ENVIAR ORDENES LAB /////////
function finalizarOrdenesLab() {

  let count = ordenes_procesando.length;
  if (count == 0) {
    Swal.fire({
      position: 'top-center',
      icon: 'error',
      title: 'Orden de finalizados vacio',
      showConfirmButton: true,
      timer: 2500
    });
    return false
  }

  $("#count_select").html(count);
  $("#modal_procesando_lab").modal('show');

}

function confirmarSalidaLab() {
  let usuario = $("#usuario").val();
  let n_ordenes = ordenes_procesando.length;
  $.ajax({
    url: "../ajax/laboratorios.php?op=finalizar_ordenes_laboratorio",
    method: "POST",
    data: { 'arrayFinalizadasLab': JSON.stringify(ordenes_procesando), 'usuario': usuario },
    cache: false,
    dataType: "json",
    success: function (data) {
      $("#ordenes_procesando_lab").DataTable().ajax.reload();
      ordenes_procesando = [];
      $("#modal_procesando_lab").modal("hide");
      Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Se han finalizados ' + n_ordenes + ' ordenes',
        showConfirmButton: true,
        timer: 50500
      });

    }
  });
}

/////////////// GET ORDNES FINALIZADAS   //////////////////////
function get_ordenes_procesando() {
  table_proces = $('#ordenes_finalizadas_lab').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'frtip',//Definimos los elementos del control de tabla
    //buttons: ['excelHtml5'],
    "ajax": {
      url: "../ajax/laboratorios.php?op=get_ordenes_finalizadas_lab",
      type: "POST",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 600,//Por cada 600 registros hace una paginación
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
        "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }, //cerrando language
  });
}

/////////////////////////ORDENES ENVIADAS PARA VETERANOS /////////
function get_ordenes_procesando_envios() {
  table_proces = $('#ordenes_finalizadas_lab_envs').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'frtip',//Definimos los elementos del control de tabla
    //buttons: ['excelHtml5'],
    "ajax": {
      url: "../ajax/laboratorios.php?op=get_ordenes_procesando_lab_envios",
      type: "POST",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 20,//Por cada 10 registros hace una paginación
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
        "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }, //cerrando language
  });
}

//////////////////////CONTROL DE INGRESOS LAB Y VETERANOS UES ///////////
var items_barcode = [];

function getCorrelativoAccionVet() {
  $.ajax({
    url: "../ajax/laboratorios.php?op=get_correlativo_accion_vet",
    method: "POST",
    cache: false,
    dataType: "json",
    success: function (data) {
      console.log(data)
      $("#correlativo_acc_vet").val(data.correlativo);
      $("#c_accion").html('OP ' + data.correlativo);
    }
  })
}

function getOrdenBarcode() {

  let paciente_dui = $("#reg_ingresos_barcode").val();
  let tipo_accion = $("#cat_data_barcode").val();

  $.ajax({
    url: "../ajax/laboratorios.php?op=get_data_orden_barcode",
    method: "POST",
    data: { paciente_dui: paciente_dui, tipo_accion: tipo_accion },
    cache: false,
    dataType: "json",
    success: function (data) {
      let resultados = typeof data;
      $("#reg_ingresos_barcode").focus()
      if (resultados == 'object') {
        getDataOrdenes(resultados, data);
      }

    }//Fin success
  });//Fin Ajax 

}


function getDataOrdenes(resultados, data) {

  let longitudObject = data.length;

  if (resultados != "string" && longitudObject != 0) {
    let codigo = data.codigo;
    let indice = items_barcode.findIndex((objeto, indice, items_tallado) => {
      return objeto.n_orden == codigo;
    });

    if (indice >= 0) {
      Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: 'Orden ya existe en la lista',
        showConfirmButton: true,
        timer: 1000
      });
      input_focus_clearb();
    } else {
      let items_ingresos = {
        n_orden: data.codigo,
        paciente: data.paciente,
        fecha: data.fecha,
        id_orden: data.id_orden
      }
      items_barcode.push(items_ingresos);
      orders.push(data.codigo);
      show_items_barcode_lab();
      input_focus_clearb();
    }
  } else {
    Swal.fire({
      position: 'top-center',
      icon: 'error',
      title: 'Código no valido',
      showConfirmButton: true,
      timer: 1000
    });
    input_focus_clearb();
  }
}

function input_focus_clearb() {
  $("#reg_ingresos_barcode").val("");

  $('#reg_ingresos_barcode').focus();
}

function show_items_barcode_lab() {

  $("#items-ordenes-barcode").html('');

  let filas = "";
  let length_array = parseInt(items_barcode.length) - 1;
  for (let i = length_array; i >= 0; i--) {

    filas = filas +
      "<tr style='text-align:center' id='item_t" + i + "'>" +
      "<td>" + items_barcode[i].id_orden + "</td>" +
      "<td>" + items_barcode[i].n_orden + "</td>" +
      "<td>" + items_barcode[i].fecha + "</td>" +
      "<td>" + items_barcode[i].paciente + "</td>" +
      "<td>" + "<button type='button'  class='btn btn-sm bg-light' onClick='eliminarItemBarcodeLab(" + i + ")'><i class='fa fa-times-circle' aria-hidden='true' style='color:red'></i></button>" + "</td>" +
      "</tr>";
  }

  $("#items-ordenes-barcode").html(filas);

}

function eliminarItemBarcodeLab(index) {
  $("#item_t" + index).remove();
  drop_index(index);
}

function drop_index(position_element) {
  items_barcode.splice(position_element, 1);
  $('#reg_ingresos_barcode').focus();
  show_items_barcode_lab()
}
//========EN DESARROLLO============
function registrarBarcodeOrdenes() {

  let tipo_accion = $("#cat_data_barcode").val();
  var ubicacion_orden = ''
  let usuario = $("#usuario").val();
  let correlativo_accion = $("#correlativo_acc_vet").val();
  let n_ordenes = items_barcode.length;
  //console.log(correlativo_accion);
  if (n_ordenes == 0) {
    Swal.fire({
      position: 'top-center',
      icon: 'error',
      title: 'Lista vacia',
      showConfirmButton: true,
      timer: 1500
    });
    return false;
  }

  $.ajax({
    url: "../ajax/laboratorios.php?op=procesar_ordenes_barcode",
    method: "POST",
    data: { 'arrayOrdenesBarcode': JSON.stringify(items_barcode), 'usuario': usuario, 'tipo_accion': tipo_accion, 'ubicacion_orden': ubicacion_orden, 'correlativo_accion': correlativo_accion },
    cache: false,
    dataType: "json",
    success: function (data) {
      console.log(data);
      if (tipo_accion == 'finalizar_lab') {
        $("#ordenes_procesando_lab").DataTable().ajax.reload();
        msj = ' ordenes en proceso exitosamente';
        $("#reg_ingresos_barcode").focus();
        $("#items-ordenes-barcode").html('');

      } else if (tipo_accion == 'recibir_veteranos') {
        msj = ' ordenes recibidas exitosamente';
        $('#modal_acciones_veteranos').modal('hide');
        $("#ordenes_recibidas_veteranos_data").DataTable().ajax.reload();
      } else if (tipo_accion == 'entregar_veteranos') {
        msj = ' ordenes entregadas exitosamente';
        $('#barcode_ingresos_lab').modal('hide');
        $("#ordenes_entregados_veteranos_data").DataTable().ajax.reload();
      } else if (tipo_accion == 'finalizar_orden_lab_completo') {
        msj = ' ordenes enviadas';
        document.getElementById('reportes_vets').style.display = 'block';
        $("#ordenes_finalizadas_lab").DataTable().ajax.reload();

      }

      items_barcode = [];
      //$("#barcode_ingresos_lab").modal("hide");
      Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: n_ordenes + msj,
        showConfirmButton: true,
        timer: 1500
      });

    }//Fin success
  });
}

function listar_ordenes_rec_vet() {
  table_proces = $('#ordenes_recibidas_veteranos_data').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'frtip',//Definimos los elementos del control de tabla
    //buttons: ['excelHtml5'],
    "ajax": {
      url: "../ajax/laboratorios.php?op=listar_ordenes_recibidas_veteranos",
      type: "POST",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 20,//Por cada 10 registros hace una paginación
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
        "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }, //cerrando language
  });
}

function listar_ordenes_entregas_vet() {
  table_proces = $('#ordenes_entregados_veteranos_data').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'frtip',//Definimos los elementos del control de tabla
    //buttons: ['excelHtml5'],
    "ajax": {
      url: "../ajax/laboratorios.php?op=listar_ordenes_entregadas_veteranos",
      type: "POST",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 20,//Por cada 10 registros hace una paginación
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
        "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }, //cerrando language
  });
}

function input_focus_clearb() {
  $("#reg_ingresos_barcode").val("");
  $("#reg_ingresos_barcode").focus()
}

function downloadExcelEntregas(title, fecha) {
  let titulo = fecha + "_" + title;
  let tablaExport = document.getElementById("tabla_acciones_veterans");

  if (tablaExport == null || tablaExport == undefined) {
    alerts_productos("warning", "Debe desplegar la tabla para poder ser descargada");
    return false;
  }

  let table2excel = new Table2Excel();
  table2excel.export(document.getElementById('tabla_acciones_veterans'), titulo);
}


function downloadExcelRecibidosVet(title, fecha) {
  let titulo = fecha + "_" + title;
  let tablaExport = document.getElementById("recibidas_ordenes_lab");
  //console.log(tablaExport);
  if (tablaExport == null || tablaExport == undefined) {
    alerts_productos("warning", "Debe desplegar la tabla para poder ser descargada");
    return false;
  }
  let table2excel = new Table2Excel();
  table2excel.export(document.getElementById('recibidas_ordenes_lab'), titulo);
}

function listar_ordenes_de_envio() {
  table_proces = $('#ordenes-de-envio').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'frtip',//Definimos los elementos del control de tabla
    //buttons: ['excelHtml5'],
    "ajax": {
      url: "../ajax/laboratorios.php?op=listar_ordenes_de_envio",
      type: "POST",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 20,//Por cada 10 registros hace una paginación
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
        "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }, //cerrando language
  });
}

function selectOrdenesEnviar() {
  let items_barcode_selected = document.getElementsByClassName('ordenes_enviar_inabve');
  let checkbox = document.getElementById("select-all-env-chk");
  let check_state = checkbox.checked;
  if (check_state) {

    for (var i = 0; i < items_barcode_selected.length; i++) {
      let data = items_barcode_selected[i].value;
      let items = data.split(',');

      let items_ingresos = {
        n_orden: items[1],
        paciente: items[2],
        fecha: items[0]
      }
      items_barcode.push(items_ingresos);
      document.getElementById(items_barcode_selected[i].id).checked = true;

    }

  } else {
    items_barcode = [];
    for (var i = 0; i < items_barcode_selected.length; i++) {
      document.getElementById(items_barcode_selected[i].id).checked = false;
    }
  }



}

function envioOrrdenesCheck() {
  $("#envios_chk").modal();
  $("#items-ordenes-barcode-chk").html('');

  let filas = "";
  let length_array = parseInt(items_barcode.length) - 1;
  for (let i = length_array; i >= 0; i--) {

    filas = filas +
      "<tr style='text-align:center' id='item_t" + i + "'>" +
      "<td>" + (i + 1) + "</td>" +
      "<td>" + items_barcode[i].n_orden + "</td>" +
      "<td>" + items_barcode[i].fecha + "</td>" +
      "<td>" + items_barcode[i].paciente + "</td>" +
      "<td>" + "<button type='button'  class='btn btn-sm bg-light' onClick='eliminarItemBarcodeLab(" + i + ")'><i class='fa fa-times-circle' aria-hidden='true' style='color:red'></i></button>" + "</td>" +
      "</tr>";

  }

  $("#items-ordenes-barcode-chk").html(filas);

}

document.querySelectorAll(".ingresa_ordenes_id").forEach(i => i.addEventListener("click", e => {
  orders = [];
}));

document.querySelectorAll(".recibe-orden").forEach(i => i.addEventListener("click", e => {
  document.getElementById("ubicacion").value = "N";
  document.getElementById("ubicacion").style.visibility = "hidden";
}));


function buscarGraduacion() {
  let od_esfera = $("#odesferas_search").val();
  let od_cilindro = $("#odcilindros_search").val();
  let od_eje = $("#odejes_search").val();
  let od_adi = $("#oddicion_search").val();

  let oi_esfera = $("#oiesferas_search").val();
  let oi_cilindro = $("#oicilindros_search").val();
  let oi_eje = $("#oiejes_search").val();
  let oi_adi = $("#oiadicion_search").val();

  $.ajax({
    url: "../ajax/laboratorios.php?op=buscar_orden_graduacion",
    method: "POST",
    data: { od_esfera: od_esfera, od_cilindro: od_cilindro, od_eje: od_eje, od_adi: od_adi, oi_esfera: oi_esfera, oi_cilindro: oi_cilindro, oi_eje: oi_eje, oi_adi: oi_adi },
    cache: false,
    dataType: "json",
    success: function (data) {
      console.log(data)


      if (data == "Vacio") {
        Swal.fire({
          position: 'top-center',
          icon: 'error',
          title: 'No existen coincidencias',
          showConfirmButton: true,
          timer: 2500
        });
      } else {

        $("#resultados_grads").html("");
        let filas = '';
        for (var i = 0; i < data.length; i++) {
          filas = filas + "<tr id='fila" + i + "'>" +
            "<td colspan='15' style='width:15%'>" + data[i].id_orden + "</td>" +
            "<td colspan='15' style='width:15%'>" + data[i].codigo + "</td>" +
            "<td colspan='15' style='width:15%'>" + data[i].fecha + "</td>" +
            "<td colspan='40' style='width:40%'>" + data[i].paciente + "</td>" +
            "<td colspan='15' style='width:15%'>" + data[i].estado_aro + "</td>" +
            "</tr>";
        }
        $("#resultados_grads").html(filas);
      }
    }
  });

}


$(document).on('click', '#busquedas_graduaciones', function () {

  let elements = document.getElementsByClassName("clear_orden_i");

  for (i = 0; i < elements.length; i++) {
    let id_element = elements[i].id;
    document.getElementById(id_element).value = "";
  }

});

//new codigo
function ingreso_laboratorio() {
  $("#modal_ingreso_laboratorio").modal('show')
  document.getElementById('n_despacho').focus()
  document.getElementById('showModalEnviarLab').disabled = true
  $("#result_despacho").html("");
  $("#totalOrdenLab").html("")
  old_despachos_lab = []
  new_despachos_lab = []
  $("#totalOrdenLab").html(new_despachos_lab.length)

  document.getElementById('n_despacho').value = ""
  document.getElementById('n_despacho').style.display = "block"
  document.getElementById('dui_despacho').style.display = "none"
}

function getDespachoLab(id) {
  let n_despacho = document.getElementById(id).value
  n_despacho = n_despacho.replace("'","-")
  n_despacho = document.getElementById(id).value = n_despacho
  $.ajax({
    url: "../ajax/laboratorios.php?op=get_despacho_lab",
    method: "POST",
    data: { n_despacho: n_despacho },
    cache: false,
    dataType: "json",
    success: function (data) {
      new_despachos_lab = []
      old_despachos_lab = data

      if (data == "vacio") {
        document.getElementById('n_despacho').value = ""
        document.getElementById('n_despacho').focus()
        Swal.fire({
          position: 'top-center',
          icon: 'error',
          title: 'No existen despachos',
          showConfirmButton: true,
          timer: 2500
        });
      } else {

        document.getElementById('n_despacho').style.display = "none"
        document.getElementById('dui_despacho').style.display = "block"
        document.getElementById('dui_despacho').focus()

        $("#result_despacho").html("");
        let filas = '';
        let indexTable = old_despachos_lab.length;
        for (var i = 0; i < old_despachos_lab.length; i++) {
          filas = filas + "<tr id='fila" + i + "'>" +
            "<td>" + indexTable + "</td>" +
            "<td><input type='checkbox' name='checkDespacho' class='form-check-label checkDespacho' id='chkenv" + i + "' data-dui='" + old_despachos_lab[i].dui + "' onClick='selectedUnico(this.id)'></td>" +
            "<td>" + old_despachos_lab[i].dui + "</td>" +
            "<td>" + old_despachos_lab[i].paciente + "</td>" +
            "</tr>";
            indexTable --;
        }
        $("#result_despacho").html(filas);
      }
    }
  });
}

//Selected all chk despacho
$(document).ready(function () {
  $('#select-all-desp').click(function () {
    let chk_fila = $('input[name="checkDespacho"]').prop('checked', this.checked);
    if (document.getElementById('select-all-desp').checked) {
      new_despachos_lab = []
      for (let i = 0; i < chk_fila.length; i++) {
        old_dui_pac = chk_fila[i].dataset.dui

        const data_pac = old_despachos_lab.filter(despacho => despacho.dui == old_dui_pac)
        new_despachos_lab = [...new_despachos_lab, ...data_pac]
      }
      $("#totalOrdenLab").html(new_despachos_lab.length)
      estado_btn_ingreso_lab(new_despachos_lab);
      //console.log(new_despachos_lab)
    } else {
      new_despachos_lab = []
      $("#totalOrdenLab").html('')
    }
  })
});
function selectedUnico(id_det) {
  let dui_pac = document.getElementById(id_det).dataset.dui

  let checkDespacho = document.getElementById(id_det).checked
  if (checkDespacho) {
    const despachos_lab = old_despachos_lab.filter((despacho) => despacho.dui == dui_pac)
    new_despachos_lab = [...new_despachos_lab, ...despachos_lab]
  } else {
    new_despachos_lab = new_despachos_lab.filter((despacho) => despacho.dui != dui_pac)
  }
  //console.log(new_despachos_lab)
  document.getElementById('totalOrdenLab').textContent = new_despachos_lab.length
  estado_btn_ingreso_lab(new_despachos_lab);
}

function buscar_dui_table(id) {
  let dui_pac_scan = document.getElementById(id).value

  dui_pac_scan = dui_pac_scan.replace("'","-")
  dui_pac_scan = document.getElementById(id).value = dui_pac_scan

  let chk_fila = document.getElementsByClassName('checkDespacho')
  let no_existe = true
  for (let i = 0; i < chk_fila.length; i++) {
    if (chk_fila[i].dataset.dui === dui_pac_scan) {
      //cambiamos el estado para mensaje
      no_existe = false
      //clear input
      document.getElementById('dui_despacho').value = ""
      document.getElementById('dui_despacho').focus()
      chk_fila[i].checked = true
      const data_pac = old_despachos_lab.filter(despacho => despacho.dui == dui_pac_scan)
      new_despachos_lab = [...new_despachos_lab, ...data_pac]
      
      //Validacion para evitar duplicacion
      let counter = 0
      array_paciente_unico = new_despachos_lab.filter((paciente)=>{
        if(paciente.dui === dui_pac_scan ){
          counter ++;
        }
        return paciente.dui != dui_pac_scan
      })

      //mensaje
      if(counter > 1){
        Swal.fire({
          position: 'top-center',
          icon: 'warning',
          title: 'El paciente ya esta seleccionado!',
          timer: 1500
        });
      }
      new_despachos_lab = [...array_paciente_unico,...data_pac]
      $("#totalOrdenLab").html(new_despachos_lab.length)
      estado_btn_ingreso_lab(new_despachos_lab);
    }
  }
  if(no_existe){
    document.getElementById('dui_despacho').value = ""
      document.getElementById('dui_despacho').focus()
      Swal.fire({
        position: 'top-center',
        icon: 'warning',
        title: 'No existe el paciente!',
        timer: 1000
      });
  }
  //console.log(new_despachos_lab)
}

$("#showModalEnviarLab").click(() => {
  $("#totalOrdenLab_ingreso").html(new_despachos_lab.length)
  $("#modal_laboratorio").modal('show')
})

function ingreso_lab() {
  let tipo_acciones = $("#tipo_acciones").val()
  let laboratorio = $("#laboratorio_ingreso").val()
  if (tipo_acciones === null || laboratorio === null) {
    Swal.fire({
      position: 'top-center',
      icon: 'warning',
      title: 'Por favor, rellenar el formulario!!',
      showConfirmButton: true,
      timer: 2500
    });
    return false;
  }
  if(tipo_acciones == "REENVIO A LAB"){
    imprimirEnviosLabPDF()
  }
  $.ajax({
    url: "../ajax/laboratorios.php?op=set_ingreso_lab",
    method: "POST",
    data: { tipo_acciones: tipo_acciones, laboratorio: laboratorio, data: new_despachos_lab },
    cache: false,
    dataType: "json",
    success: function (data) {
      //console.log(data)
      if (data == "exito") {
        Swal.fire({
          position: 'top-center',
          icon: 'success',
          title: 'Se registro el ingreso al Laboratorio',
          showConfirmButton: true,
          timer: 2500
        });
        $("#modal_laboratorio").modal('hide')
        $("#tipo_acciones").val('')
        $("#laboratorio_ingreso").val('')
        $("#ingreso_lab_ordenes").DataTable().ajax.reload()
        //actualizamos la tabla
        //element a eliminar 
        const ids_delete = new_despachos_lab.map((element) => element.id_det);

        old_despachos_lab = old_despachos_lab.filter((despacho, index) => !ids_delete.includes(despacho.id_det))

        let filas = '';
        let indexTable = old_despachos_lab.length;
        for (var i = 0; i < old_despachos_lab.length; i++) {
          filas = filas + "<tr id='fila" + i + "'>" +
            "<td>" + indexTable + "</td>" +
            "<td><input type='checkbox' name='checkDespacho' class='form-check-label checkDespacho' id='chkenv" + i + "' data-dui='" + old_despachos_lab[i].dui + "' onClick='selectedUnico(this.id)'></td>" +
            "<td>" + old_despachos_lab[i].dui + "</td>" +
            "<td>" + old_despachos_lab[i].paciente + "</td>" +
            "</tr>";
          indexTable --;
        }
        $("#result_despacho").html(filas);
        new_despachos_lab = []
        estado_btn_ingreso_lab(new_despachos_lab)
        $("#totalOrdenLab").html(new_despachos_lab.length)
      }
    }
  });
}

//activamos el boton si array > 0
document.getElementById('showModalEnviarLab').disabled = true
function estado_btn_ingreso_lab(new_despachos_lab) {
  if (new_despachos_lab.length > 0) {
    document.getElementById('showModalEnviarLab').disabled = false
  } else {
    document.getElementById('showModalEnviarLab').disabled = true
  }
}

function listar_ingreso_lab() {
  let permiso = "";
  let sucursal = "-";
  $('#ingreso_lab_ordenes').DataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
      'excelHtml5',
    ],

    "ajax": {
      url: "../ajax/laboratorios.php?op=listar_ingreso_lab",
      type: "POST",
      dataType: "json",
      data: { permiso: permiso, sucursal: sucursal },
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

function verOrdenLaboratorio(dui) {
  $("#nueva_orden_lab").modal('show');
  $.ajax({
    url: "../ajax/laboratorios.php?op=get_data_orden",
    method: "POST",
    cache: false,
    data: { dui: dui },
    dataType: "json",
    success: function (data) {
      //$("#fecha_creacion").val(data.fecha);
      $("#odesferasf").val(data.od_esferas);
      $("#odcilindrosf").val(data.od_cilindros);
      $("#odejesf").val(data.od_eje);
      $("#oddicionf").val(data.od_adicion);
      $("#oiesferasf").val(data.oi_esferas);
      $("#oicilindrosf").val(data.oi_cilindros);
      $("#oiejesf").val(data.oi_eje);
      $("#oiadicionf").val(data.oi_adicion);
      $("#od_pupilar").val(data.pupilar_od);
      $("#oipupilar").val(data.pupilar_oi);
      $("#odlente").val(data.lente_od);
      $("#oilente").val(data.lente_oi);
      $("#marca_aro_orden").val(data.marca);
      $("#modelo_aro_orden").val(data.modelo)
      $("#horizontal_aro_orden").val(data.horizontal_aro);
      $("#material_aro_orden").val(data.material);
      $("#observaciones_orden").val(data.puente_aro);
      $("#observaciones_orden").val(data.observaciones);
      $("#color_aro_orden").val(data.color);
      $("#categoria_lente").val(data.categoria);
      $("#destino_orden_lente").val(data.laboratorio);

      $("#usuario_pac").val(data.usuario_lente);
      $("#avsc").val(data.avsc);
      $("#avfinal").val(data.avfinal);
      $("#avsc_oi").val(data.avsc_oi);
      $("#avfinal_oi").val(data.avfinal_oi);

      $("#patologias-ord").val(data.patologias)

      $("#codigo_correlativo").val(data.codigo)
      $("#id_cita_ord").val(data.id_cita)
      $("#id_aro").val(data.id_aro)
      material_aro_orden
      $("#laboratorio").val(data.laboratorio)

      if (data.colorTratamiento == "Blanco") {
        document.getElementById("blanco").checked = true;
      }
      if (data.colorTratamiento == "Photocromatico") {
        document.getElementById("photo").checked = true;
      }
      $("#customSwitch1").prop('checked', true) // default en true
      let valueSwitch = $("input[name='customSwitch1']:checked").val();

      //Validation por cita
      if (data.id_cita != 0 || data.id_cita != "") {
        $("#customSwitch1").prop("checked", false);
        document.getElementById('show_form_manual').style.display = "none"
        document.getElementById('tables_cita').style.display = "block"
        $("#paciente_t").html(data.paciente);
        $("#dui_pac_t").html(data.dui);
        $("#edad_pac_t").html(data.edad);
        $("#correlativo_op").html("ORDEN:" + data.codigo);
        $("#telef_pac_t").html(data.telefono);
        $("#genero_pac_t").html(data.genero);
        $("#ocupacion_pac_t").html(data.ocupacion);
        $("#departamento_pac_t").html(data.depto);
        $("#munic_pac_data_t").html(data.municipio);
        $("#instit_t").html(data.institucion);

        $("#titular").val('');
        $("#dui_titular").val('')
        $("#titular_id").val('')

      } else {
        $("#customSwitch1").prop("checked", false);
        document.getElementById('tables_cita').style.display = "block"
        document.getElementById('id_cita_ord').value = 0
        document.getElementById('show_form_manual').style.display = "block"

        $("#paciente_t").html('');
        $("#dui_pac_t").html('');
        $("#edad_pac_t").html('');
        $("#correlativo_op").html("ORDEN:" + data.codigo);
        $("#telef_pac_t").html('');
        $("#genero_pac_t").html('');
        $("#ocupacion_pac_t").html('');
        $("#departamento_pac_t").html('');
        $("#munic_pac_data_t").html('');
        $("#instit_t").html('');

      }

      if (valueSwitch != null) {
        //Validacion si es por ingreso manual
        if (valueSwitch == "on") {
          paciente = $("#paciente").val(data.paciente)
          dui = $("#dui_pac").val(data.dui)
          edad = $("#edad_pac").val(data.edad)
          telefono = $("#telef_pac").val(data.telefono)
          genero = $("#genero_pac").val(data.genero)
          ocupacion = $("#ocupacion_pac").val(data.ocupacion)
          depto = $("#depto_pac").html(data.depto)
          municipio = $("#muni_pac_label").html(data.municipio)
          instit = $("#instit").val(data.institucion)
          $("#sucursal_optica").val(data.sucursal);
          //new
          $("#titular").val(data.titular);
          $("#dui_titular").val(data.dui_titular)
          $("#titular_id").val(data.id_titulares)
        }
      }
      if (data.institucion == "CONYUGE") {
        document.getElementById('titular_form').style.display = "block"
        $("#paciente_t").html(data.paciente);
        $("#dui_pac_t").html(data.dui);
        $("#edad_pac_t").html(data.edad);
        $("#correlativo_op").html("ORDEN:" + data.codigo);
        $("#telef_pac_t").html(data.telefono);
        $("#genero_pac_t").html(data.genero);
        $("#ocupacion_pac_t").html(data.ocupacion);
        $("#departamento_pac_t").html(data.depto);
        $("#munic_pac_data_t").html(data.municipio);
        $("#instit_t").html(data.institucion);
      } else {
        document.getElementById('titular_form').style.display = "none"
      }


      let tipo_lente = data.tipo_lente;
      const acentos = { 'á': 'a', 'é': 'e', 'í': 'i', 'ó': 'o', 'ú': 'u', 'Á': 'A', 'É': 'E', 'Í': 'I', 'Ó': 'O', 'Ú': 'U' };
      let lente = tipo_lente.split('').map(letra => acentos[letra] || letra).join('').toString();
      let cadena = lente.replace(/ /g, "");

      document.getElementById(cadena).checked = true;

      let imagen = data.img;
      //console.log(imagen);
      document.getElementById("imagen_aro").src = "images/" + imagen;



    }
  });
}
//select de buscar por filtro en ingreso_lab.php
$(document).ready(function(){
  $("#estado_proceso").change(function () {         
    $("#estado_proceso option:selected").each(function () {
     let estado_proceso = $(this).val();
     listar_ordenes_pend_lab("si",estado_proceso)
    });
  })
});

//Imprimi
function imprimirEnviosLabPDF() {

  var form = document.createElement("form");
  form.target = "blank";
  form.method = "POST";
  form.action = "imprimirReenvioLabPDF.php";

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "data";
  input.value = JSON.stringify(new_despachos_lab);
  form.appendChild(input);
  document.body.appendChild(form);//"width=600,height=500"

  form.submit();
  document.body.removeChild(form);

}