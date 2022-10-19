<style>
 .modal-header{
        background-color: #7A92A1;
        color: white;
        text-align: center;
    }


  #tamModalAros{
    max-width: 90%;
  }
</style>
  
<div class="modal fade bd-example" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="newMarca" style="border-radius:0px !important;">
    
    <div class="modal-dialog modal-md" id="tanModal">
      <!-- cabecera de la modal-->
      <div class="modal-content" >
        <div class="modal-header" style="justify-content: space-between;background:#008080;color:white">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-square"></i> NUEVA MARCA</h5>
          <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row" autocomplete="on">
            <div class="form-group col-md-12">
              <input type="text"  class="form-control" name="" placeholder="Ingrese marca" required="" id="marca" onkeyup="mayus(this);" placeholder="Nombre marca">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
