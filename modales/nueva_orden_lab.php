      
<style>
  .etiqueta{
    color: black;font-family: Helvetica, Arial, sans-serif;font-size: 13px;text-align: center;
  }
</style>
      <div class="modal fade" id="nueva_orden_lab" style="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width: 95%">
          <div class="modal-content">
            <div class="modal-header bg-dark" style="padding: 5px;">
              <h4 class="modal-title" style="font-size: 15px"><button class="btn btn-xs btn-dark" onClick="buscarCitado()"><i class="fas fa-search"></i></button><span id="correlativo_op"></span><h5 style="text-align: center; font-size:14px" class="modal-title w-100 text-center">NUEVA ORDEN</h5>  </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"><!--START MODAL BODY--> 
            <table width="100%" class="table-bordered" style="text-align:center; text-transform:uppercase;font-size:11px">
            <thead style="color:white;font-family: Helvetica, Arial, sans-serif;font-size: 11px;text-align: center;background: #073763">
              <tr>
                <th  style="width:40%">PACIENTE</th>
                <th  style="width:15%">DUI</th>
                <th  style="width:10%">EDAD</th>
                <th  style="width:20%">TELEFONO</th>
                <th  style="width:15%">GENERO</th>
              </tr>
            </thead>
            <tr>
              <td id="paciente"  style="width:40%"></td>
              <td id="dui_pac" style="width:15%"></td>
              <td id="edad_pac" style="width:10%"></td>
              <td id="telef_pac" style="width:20%"></td>
              <td id="genero_pac" style="width:15%"></td>
            </tr>
            </table>

            <table width="100%" class="table-bordered" style="text-align:center;text-transform:uppercase;font-size:11px">
            <thead style="color:white;font-family: Helvetica, Arial, sans-serif;font-size: 11px;text-align: center;background: #073763">
              <tr>
                <th  style="width:20%">OCUPACIÓN</th>
                <th  style="width:20%">SECTOR</th>
                <th  style="width:25%">DEPARTAMENTO</th>
                <th  style="width:35%">MUNICIPIO</th>
              </tr>
            </thead>
            <tr>
              <td id="ocupacion_pac"  style="width:20%"></td>
              <td id="instit" style="width:20%"></td>
              <td id="departamento_pac" style="width:25%"></td>
              <td id="munic_pac_data" style="width:35%"></td>

            </tr>
            </table>
            <div class="row">

              <div class="col-sm-3" style="margin-top:3px;">

                 <select class="form-control oblig" id="patologias-ord" style="border: 1px solid orange" name="usuario">
                  <option value="">Seleccionar patologias...</option>
                  <option value="No">No</option>
                  <option value="Cataratas">Cataratas</option>
                  <option value="Pterigión">Pterigión</option>
                  <option value="Retinopatía">Retinopatía</option>
                  <option value="Glaucoma">Glaucoma</option>
                </select>

               </div>

               <div class="col-sm-5" style="margin-top:3px;background:#f8f8f8">
               <div class="row">
               <div class="col-sm-4" class="d-flex justify-content-center" style="display:flex;justify-content: center;margin-top:0px;">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input chk_element" type="radio" id="VisionSencilla" value="Visión Sencilla" name="tipo_lente">
                      <label class="form-check-label" for="inlineCheckbox2" id="lentevs">VS</label>
                    </div>
                  </div>
                  <div class="col-sm-4" style="display:flex;justify-content: center;margin-top:0px;">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input chk_element" type="radio" id="Flaptop" value="Flaptop" name="tipo_lente">
                      <label class="form-check-label" for="inlineCheckbox2" id="lentebf">Flaptop</label>
                    </div>
                  </div>
                  <div class="col-sm-4" style="display:flex;justify-content: center;margin-top:0px;">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input chl_element" type="radio" id="Progresive" value="Progresive" name="tipo_lente">
                      <label class="form-check-label" for="inlineCheckbox2" id="lentemulti">Progresive</label>
                    </div>
                  </div>
               </div>  
             </div>

             <div class="col-sm-4" style="margin-top:3px;background:#E3EFF9">
               <div class="row">
               <div class="col-sm-4" class="d-flex justify-content-center" style="display:flex;justify-content: center;margin-top:0px;">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input chk_element" type="radio" id="blanco" value="Blanco" name="colors">
                      <label class="form-check-label" for="inlineCheckbox2" id="lentevs">Blanco</label>
                    </div>
                  </div>
                  <div class="col-sm-4" style="display:flex;justify-content: center;margin-top:0px;">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input chk_element" type="radio" id="photo" value="Photocromatico" name="colors">
                      <label class="form-check-label" for="inlineCheckbox2" id="lentebf">Photocroma</label>
                    </div>
                  </div>
                  <div class="col-sm-4" style="display:flex;justify-content: center;margin-top:0px;">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input chl_element" type="radio" id="alto-indice" value="Progresive" name="indice" disabled="disabled">
                      <label class="form-check-label" for="alto-indice" id="label-index">Alto indice</label>
                    </div>
                  </div>
               </div>  
             </div>
            </div>

            <!--################ RX final + medidas #############-->
            <div class="eight">
              <strong><h1 style="color: #034f84">GRADUACIÓN(Rx Final)</h1></strong>
              <div class="row">
                <div class="col-sm-12">    
                  <table style="margin:0px;width:100%">
                    <thead class="thead-light" style="color: black;font-family: Helvetica, Arial, sans-serif;font-size: 11px;text-align: center;background: #f8f8f8">
                      <tr>
                        <th style="text-align:center">OJO</th>
                        <th style="text-align:center">ESFERAS</th>
                        <th style="text-align:center">CILIDROS</th>
                        <th style="text-align:center">EJE</th>      
                        <th style="text-align:center">ADICION</th>
        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>OD</td>
                        <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="odesferasf"  style="text-align: center"></td>
                        <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="odcilindrosf"  style="text-align: center"></td>
                        <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="odejesf"  style="text-align: center"></td>             
                       <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="oddicionf"  style="text-align: center"></td>
              
                      </tr>
                      <tr>
                        <td>OI</td>
                        <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="oiesferasf"   style="text-align: center">                        
                      </td>
                        <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="oicilindrosf"   style="text-align: center"></td>
                        <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="oiejesf"   style="text-align: center"></td>              
                        <td> <input type="text" class="form-control clear_orden_i rx_f oblig"  id="oiadicionf"  style="text-align: center"></td>    
                      </tr>
                    </tbody>
                  </table>
                  </div>
              </div>
            </div>
<!--################ FIN rx final + medidas #############-->
            <div class="row distancias">
              <div class="col-sm-3 dist_pupilar">
                <div class="eight" style="align-items: center">
                  <h1>DISTANCIA PUPILAR</h1>
                  <div class="d-flex justify-content-center">
                  <div class="form-group row">

                  <div class="col-md-6">
                   <label for="od_pupilar" class="etiqueta">OD</label>
                    <input type="text" class="form-control clear_orden_i oblig" placeholder="mm" id="od_pupilar">
                  </div>

                  <div class="col-md-6">
                   <label for="" class="etiqueta">OI</label>
                   <input type="text" class="form-control clear_orden_i oblig" placeholder="mm" id="oipupilar">
                  </div>

                 </div><!--FIN Form Row-->

                  </div>
                </div>
              </div><!--Fin distancia pupilar-->

              <!--###### ALTURA DE LENTE ########-->

              <div class="col-sm-3 dist_pupilar">
                <div class="eight" style="align-items: center">
                  <h1>ALTURA DE LENTE</h1>
                  <div class="d-flex justify-content-center">
                  <div class="form-row">

                  <div class="col-md-6">
                    <label for="" class="etiqueta">OD</label>
                      <input type="text" class="form-control clear_orden_i oblig" placeholder="mm" id="odlente" onClick=" validaAltoIndice()" onkeyup=" validaAltoIndice()">
                  </div>

                <div class="col-md-6">
                    <label for="" class="etiqueta">OI</label>
                      <input type="text" class="form-control clear_orden_i oblig" placeholder="mm" id="oilente">
                </div>

                 </div><!--FIN Form Row-->

                  </div>
                </div>
              </div><!--Fin distancia pupilar-->

              <div class="col-sm-6 agudeza">
                <div class="eight" style="align-items: center">
                  <h1>AGUDEZA VISUAL</h1>
                  <div class="d-flex justify-content-center">
                  <div class="form-row">

                  <div class="col-md-6">
                    <label for="" class="etiqueta" style="text-align: center">AVsc</label>
                    <div style="display: flex">
                      <input type="text" class="form-control clear_orden_i" placeholder="OD" id="avsc">
                      <input type="text" class="form-control clear_orden_i" placeholder="OI" id="avsc_oi">
                    </div>
                  </div>

                <div class="col-md-6">
                  <label for="" class="etiqueta" style="text-align: center">AVfinal</label>
                   <div style="display: flex">
                    <input type="text" class="form-control clear_orden_i" placeholder="OD" id="avfinal">
                    <input type="text" class="form-control clear_orden_i" placeholder="OI" id="avfinal_oi">
                </div>
                </div>

                 </div><!--FIN Form Row-->

                  </div>
                </div>
              </div><!--Fin distancia pupilar-->

            </div>
          <div class="row">
          <div class="col-sm-9">
          <div class="eight">
            <h1>ARO</h1>

            <div class="form-group row" style="margin: 4px">

            <div class="col-sm-3">
                <label class="etiqueta"> Modelo <span style="color: red">*</span></label>
              <div class="input-group">
              <input type="text" class="form-control clear_orden_i oblig" id="modelo_aro_orden" placeholder="Especificar aro">
              <div class="input-group-append" onClick="buscarAro()" id="buscar_aro">
                <span class="input-group-text bg-success"><i class="fas fa-search"> </i></span>
              </div>

              <div class="input-group-append" data-toggle="modal" data-target="#imagen_aro_orden" id="mostrar_imagen">
                <span class="input-group-text bg-primary"><i class="fas fa-file-image"> </i></span>
              </div>

             </div>
           </div>


              <div class="form-group col-sm-3">
                <label for="" class="etiqueta">Marca <span style="color:blue">(Opc.)</span></label>
                <input type="text" class="form-control clear_orden_i" id="marca_aro_orden">
              </div>


              <div class="form-group col-sm-2">
                <label for="" class="etiqueta">Horizontal <span style="color:blue">(Opc.)</span></label>
                <input type="text" class="form-control clear_orden_i" id="horizontal_aro_orden">
              </div>

              <div class="form-group col-sm-2">
                  <label for="" class="etiqueta">Vertical <span style="color:blue">(Opc.)</span></label>
                  <input type="text" class="form-control clear_orden_i" id="vertical_aro_orden">
              </div>       

              <div class="form-group col-sm-2">
                  <label for="" class="etiqueta">Puente <span style="color:blue">(Opc.)</span></label>
                  <input type="text" class="form-control clear_orden_i" id="puente_aro_orden">
              </div>

             </div>   
              </div>
            </div>

            <div class="col-sm-3">
            <div class="eight">
            <h1>COLOR ARO</h1>
            <div class="form-row align-items-center row" style="margin: 4px">
              <div class="form-group col-sm-6">
                <label for="" class="etiqueta">Varillas <span style="color:blue">(Opc.)</span></label>
                <input type="text" class="form-control clear_orden_i" id="color_varilla" placeholder="color varillas">
              </div>
              <div class="form-group col-sm-6">
                <label for="" class="etiqueta">Frente <span style="color:blue">(Opc.)</span></label>
                <input type="text" class="form-control clear_orden_i" id="color_frente" placeholder="color frente">
              </div>
            </div>
          </div>
          </div>

          </div><!--Fin Div Aros row-->
         
          <div class="form-group col-sm-12">            
            <label for="" class="etiqueta">Observaciones</label>
            <input type="text" class="form-control clear_orden_i oblig" id="observaciones_orden">
          </div>

          <p id="created"></p>

          <input type="hidden" id="codigoOrden" name="codigoOrden">
          <input type="hidden" id="img_ord">
          <input type="hidden" id="validate">
          </div><!--/END MODAL BODY-->

          <div class="eight" id="hist_orden">
          <h1>HISTORIAL</h1>
            <table width="100%" class="table-hover table-bordered display nowrap">
              <tr style="text-align: center;font-size: 12px;background: #162e41;color: white;margin-top: 5px">
                <td colspan="15" class="ord_1" style="width:10%">Fecha</td>
                <td colspan="25" class="ord_1" style="width:25%">Usuario</td>
                <td colspan="25" class="ord_1" style="width:25%">Acción</td>
                <td colspan="35" class="ord_1" style="width:35%">Observaciones</td>
              </tr>
             
              <tbody id="hist_orden_detalles" class="ord_2" style="text-align: center;font-size: 13px;"></tbody>
            </table>
          </div> 
           <input type="hidden" id="user_act" value="<?php echo $_SESSION["usuario"];?>">
          <div class="form-group justify-content-between" style="margin: 4px; display: flex;justify-content: space-between;">

            <button type="button" class="btn btn-dark" style="margin: 5px;" id="btn_rectificar" data-toggle="modal" data-target="#rectificacionesModal" data-index-number="12314Os"><i class="fas fa-wrench"></i> &nbsp;Rectificar</button>

            <button type="button" class="btn pull-rigth" onClick='guardar_orden();' id="order_create_edit" style="margin: 5px;background: #073763;color: white"><i class="fas fa-save"></i> Guardar</button>

          </div> 

          <section class="input-group" id="enviar_a">                   
          <div class="form-group col-sm-6">
            <select class="custom-select" id="categoria_lente" aria-label="Example select with button addon">
              <option value="0" selected>Seleccionar opcion...</option>
              <option value="Proceso">Proceso</option>
              <option value="Terminado">Terminado</option>
            </select>
          </div>

          <div class="form-group col-sm-6">
          <div class="input-group">
          <select class="custom-select" id="destino_orden_lente" aria-label="Example select with button addon">
            <option value="0" selected>Enviar a...</option>
            <option value="Jenny">Jenny</option>
            <option value="Divel">Divel</option>
            <option value="Lomed">Lomed</option>
            <option value="Lenti">Lenti</option>
            <option value="Arce">Arce</option>
          </select>
          <div class="input-group-append">
            <button class="btn btn-info" type="button" onClick='sendEdit()'>Enviar</button>
          </div>
        </div>
          </div>

          </section>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

</div>
 