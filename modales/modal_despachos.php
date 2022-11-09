<div class="modal" id="modal-despachos">
  <div class="modal-dialog" style="max-width:70%">
    <div class="modal-content">
      <div class="modal-header bg-dark" style="padding:10px">
        <h5 class="modal-title w-100 text-center position-absolute">DESPACHAR ORDENES A LABORATORIOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">

        <div class="col-sm-4" style=" margin-bottom: 3px">

            <input class="form-control" id="fecha-cita" type="date" >
        </div>

        <div class="form-group clearfix" style="margin:6px">

        <div class="icheck-success d-inline">
            <input type="radio" name="receptor-acta" id="ben-acta" class="chk-recept" value="beneficiario">
            <label for="ben-acta">Citas
            </label>
        </div>

        <div class="icheck-warning d-inline" style="margin:6px">
            <input type="radio" name="receptor-acta" id="terc-acta" class="chk-recept" value="tercero">
            <label for="terc-acta">Expedientes
            </label>
        </div>
</div>
        </div>
        <table width="100%" class="table-hover table-bordered" id="datatable_citas_suc"  data-order='[[ 0, "desc" ]]' style="font-size: 12px">
            <thead style="text-align:center;font-size:12" class="style_th bg-primary">
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Sector</th>
                <th>Dia</th>
                <th>Sucursal</th>
                <th>Estado</th>
            </thead>
            <tbody style="text-align:center;font-size:14px"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>