function buscarCitado(){
    let fecha = document.getElementById("fecha_act").value;
    console.log(fecha)
    $("#modal_citados").modal();
    dtTemplateCitas("datatable_citados","listar_pacientes_citados","")
}

function dtTemplateCitas(table,route,...Args){
    console.log(Args)
    tabla = $('#'+table).DataTable({      
      "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      dom: 'Bfrtip',//Definimos los elementos del control de tabla
      buttons: [     
        'excelHtml5',
      ],
  
      "ajax":{
        url:"../ajax/citados.php?op="+ route,
        type : "POST",
        data: {Args:Args},
        dataType : "json",         
        error: function(e){
        console.log(e.responseText);
      },      
    },
  
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength": 2000,//Por cada 10 registros hace una paginación
        "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
        "language": { 
        "sProcessing":     "Procesando...",       
        "sLengthMenu":     "Mostrar _MENU_ registros",       
        "sZeroRecords":    "No se encontraron resultados",       
        "sEmptyTable":     "Ningún dato disponible en esta tabla",       
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",       
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",       
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",    
        "sInfoPostFix":    "",       
        "sSearch":         "Buscar:",       
        "sUrl":            "",       
        "sInfoThousands":  ",",       
        "sLoadingRecords": "Cargando...",       
        "oPaginate": {       
            "sFirst":    "Primero",       
            "sLast":     "Último",       
            "sNext":     "Siguiente",       
            "sPrevious": "Anterior"       
        },   
        "oAria": {       
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",       
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"   
        }}, //cerrando language
    });

     
}

function getCitados(id_cita){

    $.ajax({
        url:"../ajax/citados.php?op=get_data_cita",
        method:"POST",
        cache:false,
        data :{id_cita:id_cita},
        dataType:"json",
        success:function(data){
            document.getElementById("paciente").innerHTML=data.paciente;
            document.getElementById("dui_pac").innerHTML=data.dui;
            document.getElementById("edad_pac").innerHTML=data.edad;
            document.getElementById("telef_pac").innerHTML=data.telefono;
            document.getElementById("ocupacion_pac").innerHTML=data.ocupacion;
            document.getElementById("instit").innerHTML=data.sector;
            document.getElementById("genero_pac").innerHTML=data.genero;
            document.getElementById("departamento_pac").innerHTML=data.depto;
            document.getElementById("munic_pac_data").innerHTML=data.municipio;
            document.getElementById("id_cita_ord").value=data.id_cita;
            $("#modal_citados").modal('hide');
        }
    });      
}

function getcitadosAtendidos(){
  let tipo_rep = document.getElementById("tipo_rep").value;
  let sucursal = document.getElementById("suc-rep-citas").value;
  let desde = document.getElementById("desde").value;
  let hasta = document.getElementById("hasta").value;
  dtTemplateCitas("data-citados-atend","get_citados_atend",tipo_rep,sucursal,desde,hasta)
}