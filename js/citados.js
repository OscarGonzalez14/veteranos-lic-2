function buscarCitado(){

    let fecha = document.getElementById("fecha_act").value;
    let user_sucursal = document.getElementById('user_sucursal').value;
    $("#modal_citados").modal();
    dtTemplateCitas("datatable_citados","listar_pacientes_citados",user_sucursal)

}

function dtTemplateCitas(table,route,...Args){
    //console.log(Args) //ARGUMENTOS
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
        data: {user_sucursal: Args[0]},
        dataType : "json",         
        error: function(e){
        console.log(e.responseText);
      },      
    },
  
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength": 25,//Por cada 10 registros hace una paginación
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
          document.getElementById("paciente_t").textContent=data.paciente;
          document.getElementById("dui_pac_t").innerHTML=data.dui;
          document.getElementById("edad_pac_t").innerHTML=data.edad;
          document.getElementById("telef_pac_t").innerHTML=data.telefono;
          document.getElementById("ocupacion_pac_t").innerHTML=data.ocupacion;
          document.getElementById("instit_t").innerHTML=data.sector;
          document.getElementById("genero_pac_t").innerHTML=data.genero;
          document.getElementById("departamento_pac_t").innerHTML=data.depto;
          document.getElementById("munic_pac_data_t").innerHTML=data.municipio;
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

function showModalGestion(){
  console.log("showModal");
  $("#gestion-citas").modal();
  dtTemplateCitas("data-gest-citas","get_citados_pend","0")
}

function editarCita(id_cita){
 console.log(permisos)
 let permiso_edita_cita = permisos.includes('3'); 

  $.ajax({
    url:"../ajax/citados.php?op=get_data_cita",
    method:"POST",
    cache:false,
    data :{id_cita:id_cita},
    dataType:"json",
    success:function(data){
      
      $("#myModal").modal();
      document.getElementById("sucursal-cita").value=data.sucursal;
      document.getElementById("fecha-cita").readOnly = false;
      document.getElementById("btnEdit").style.display="block";
      document.getElementById("btnAccion").style.display="none";   
      document.getElementById("fecha-cita").value=data.fecha;
      document.getElementById("telefono-pac").value=data.telefono;
      document.getElementById("edad-pac").value=data.edad;
      document.getElementById("genero-pac").value=data.genero;
      document.getElementById("ocupacion-pac").value=data.ocupacion;
      document.getElementById("sector-pac").value=data.sector;
      $("#hora").val(data.hora).trigger('change');
      $("#departamento_pac").val(data.depto).trigger('change');
      $("#munic_pac").val(data.municipio).trigger('change');      
      document.getElementById("paciente-vet").value=data.paciente
      document.getElementById("dui-vet").value=data.dui;
      document.getElementById("id_citado").value=id_cita;      
      //consultarDisponibilidad(data.fecha)
      document.getElementById("sucursal-cita").innerHTML='<option value="'+data.sucursal+'" selected>'+data.sucursal+'</option>';

      //let id_user = document.getElementById("id_usuario_vet").value;
      if(permiso_edita_cita==false) {
        document.getElementById("paciente-vet").readOnly = true;
        document.getElementById("dui-vet").readOnly = true;
        document.getElementById("telefono-pac").readOnly = true;
        document.getElementById("edad-pac").readOnly = true;
        document.getElementById("ocupacion-pac").readOnly = true;
        document.getElementById("genero-pac").disabled = true;
        document.getElementById("sector-pac").disabled = true;
        document.getElementById("munic_pac").disabled = true;
        document.getElementById("departamento_pac").disabled = true;
      }else{
        document.getElementById("paciente-vet").readOnly = false;
        document.getElementById("dui-vet").readOnly = false;
        document.getElementById("telefono-pac").readOnly = false;
        document.getElementById("edad-pac").readOnly = false;
        document.getElementById("ocupacion-pac").readOnly = false;
        document.getElementById("genero-pac").disabled = false;
        document.getElementById("sector-pac").disabled = false;
        document.getElementById("munic_pac").disabled = false;
        document.getElementById("departamento_pac").disabled = false;
      }
      

    }
});

}

function editarCitaSendData(){
  let id_cita= document.getElementById('id_citado').value;
  let paciente = document.getElementById('paciente-vet').value;
  let dui = document.getElementById('dui-vet').value;
  let fecha = document.getElementById('fecha-cita').value;
  let sucursal = document.getElementById('sucursal-cita').value;
  let sector = document.getElementById("sector-pac").value;
  let depto = document.getElementById("sector-pac").value;
  let municipio = document.getElementById("sector-pac").value;
  let hora = "-";
  let telefono = document.getElementById("telefono-pac").value;
  let edad = document.getElementById("edad-pac").value;
  let ocupacion = document.getElementById("ocupacion-pac").value;
  let genero = document.getElementById("genero-pac").value;

  $.ajax({
    url:"../ajax/citados.php?op=editar_cita",
    method:"POST",
    data:{paciente:paciente,dui:dui,fecha:fecha,sucursal:sucursal,sector:sector,depto:depto,municipio:municipio,hora:hora,telefono:telefono,edad:edad,ocupacion:ocupacion,genero:genero,id_cita:id_cita},
    cache: false,
    dataType:"json",
    success:function(data){
      console.log(data)
      Swal.fire(
        'Orden editada!!',
        'Existosamente',
        'success'
    )
      calendar.refetchEvents();
      $("#myModal").modal('hide')
      $("#gestion-citas").modal('hide')
    }
  });///fin ajax
  
}

function imprimirCitados(){
  let fecha = document.getElementById("fecha_print").value;
  let sucursal = document.getElementById("sucursal_print").value;
  let form = document.createElement("form");
  form.target = "print_blank";
  form.method = "POST";
  form.action = "../vistas/imprimir_citas_pdf.php";

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "fecha-cita";
  input.value = fecha;
  form.appendChild(input);

  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "sucursal";
  input.value = sucursal;
  form.appendChild(input);


  document.body.appendChild(form);//"width=600,height=500"
  form.submit();
  document.body.removeChild(form);

}

function imprimirCitadosAll(){
  let fecha = document.getElementById("fecha_print").value;
  let form = document.createElement("form");
  form.target = "print_blank";
  form.method = "POST";
  form.action = "../vistas/listar_citas_all.php";
  var input = document.createElement("input");
  input.type = "hidden";
  input.name = "fecha-cita";
  input.value = fecha;
  form.appendChild(input);

  document.body.appendChild(form);//"width=600,height=500"
  form.submit();
  document.body.removeChild(form);

}

function getDisponibilidadSucursales(fecha){
  const dias = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo']
  let diaInt = new Date(fecha).getDay();
  const nombreDia = dias[diaInt];
  consultarDisponibilidad(fecha);
}

function consultarDisponibilidad(fecha){
  
  $.ajax({
    url:"../ajax/citados.php?op=get_disponilidad_citas",
    method:"POST",
    data:{fecha:fecha},
    cache: false,
    dataType:"json",
    success:function(data){
      console.log(data)
      document.getElementById("sucursal-cita").innerHTML='<option value="0">Seleccionar sucursal</option>';
      for(var i=0; i<data.length; i++){
        let sucursal=data[i].sucursal;
        document.getElementById("sucursal-cita").innerHTML += "<option value='"+data[i].sucursal+"' data-toggle='tooltip' data-placement='left' data-html='true' title='"+sucursal.toUpperCase()+ "\n" +data[i].direccion+"\n"+data[i].referencia+"\n"+data[i].optica+"'>"+data[i].sucursal+" "+data[i].cupos+"</option>"; 

      }
    }
  });///fin ajax
}


