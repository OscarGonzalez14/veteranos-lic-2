
document.querySelectorAll(".chk-recept").forEach(i => i.addEventListener("click", e => {
    let receptor = $("input[type='radio'][name='receptor-acta']:checked").val();
    const receptores_section = document.getElementById("receptores-section");
    receptor=="tercero" ? receptores_section.style.display="flex" : receptores_section.style.display="none"
  }));
  
  function modalImprimirActa(codigo,paciente){
    $("#modal-actas").modal()
    document.getElementById("codigo-recep-orden").value=codigo;
    document.getElementById("pac-recep-orden").value=paciente;
  }
  
  let btn_print = document.getElementById('btn-print-acta');
  
  btn_print.addEventListener("click", function() {
    let receptor = $("input[type='radio'][name='receptor-acta']:checked").val();
    let nombre_receptor = document.getElementById('receptor-acta').value;
    let dui_receptor = document.getElementById('receptor-dui').value;
    let titular = document.getElementById('pac-recep-orden').value;
    let codigo_orden = document.getElementById('codigo-recep-orden').value;
    let sucursal = document.getElementById('sucursal').value;
    let id_usuario = document.getElementById('id_usuario').value;

    if(receptor==undefined){
      Swal.fire({position: 'top-center',icon: 'error',title: 'Especificar tipo de receptor',showConfirmButton: true,
        timer: 1500
    });
      return false;
    }

    if(receptor !="tercero"){nombre_receptor=titular}
  
    if(receptor=='tercero' && (nombre_receptor=='' || dui_receptor=='')){
      Swal.fire({position: 'top-center',icon: 'error',title: 'DUI y nombre de receptor son obligatorios',showConfirmButton: true,
        timer: 1500
      });
      return false;
    }
    
   
    $.ajax({
    url: "../ajax/actas.php?op=crear_acta",
    method: "POST",
    data: {codigo_orden:codigo_orden,titular:titular,nombre_receptor:nombre_receptor,receptor:receptor,sucursal:sucursal,id_usuario:id_usuario},
    dataType: "json",
    success: function (data) {
     let id_acta = data.id;
     let correlativo_suc = data.correlativo_sucursal;
     imprimirActa(nombre_receptor,dui_receptor,titular,codigo_orden,receptor,id_acta,correlativo_suc)
    }
  });//Fin Ajax
    
    
    //
  
  });
  
  function imprimirActa(nombre_receptor,dui_receptor,paciente,codigo,tipo_receptor,id_acta,correlativo_suc) {
    let form = document.createElement("form");
    form.target = "blank";
    form.method = "POST";
    form.action = "imprimir_acta.php";
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "codigo";
    input.value = codigo;
    form.appendChild(input);
  
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "paciente";
    input.value = paciente;
    form.appendChild(input);
  
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "receptor";
    input.value = nombre_receptor;
    form.appendChild(input);
  
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "dui-receptor";
    input.value = dui_receptor;
    form.appendChild(input);
  
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "tipo-receptor";
    input.value = tipo_receptor;
    form.appendChild(input);

    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "id_acta";
    input.value = id_acta;
    form.appendChild(input);
  
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "correlativo_suc";
    input.value = correlativo_suc;
    form.appendChild(input);
  
    document.body.appendChild(form);//"width=600,height=500"
    form.submit();
    document.body.removeChild(form);
  }
  