<?php
 $cat_usuario = $_SESSION["categoria"];
 require_once('../modales/modal_det_rectificaciones.php');
 ?>
 <script>
  var names_permisos  = <?php echo json_encode($_SESSION["names_permisos"])?>;
 </script>
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a class="brand-link">
    </a>
     <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        

          <li class="nav-item">
            <a href=''class="nav-link" style="color: white">
              <i class="nav-icon fas fa-file"></i>
              <p style="#">Ordenes</p><i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="orden.php" class="nav-link">
                <i class="far fa-circle nav-icon text-info"></i>
                  <p>Ordenes</p>
                </a>
            </li>
            <li class="nav-item">
              <a href="despachos_lab.php" class="nav-link">
                <i class="fas fa-shipping-fast"></i>
                  <p>Despachos lab</p>
                </a>
            </li>
            <li class="nav-item">
              <a href="ordenes_recibidas_veteranos.php" class="nav-link">
                <i class="far fa-circle nav-icon text-success"></i>
                  <p>Recibir ordenes</p>
                </a>
              </li>
            <li class="nav-item">
              <a href="rectificaciones.php" class="nav-link">
                <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Rectificaciones</p>
                </a>
              </li>
            </ul>  
            </li>

          <?php if($cat_usuario=="Admin"){ ?>
          <li class="nav-item">
            <a href='inventarios.php' class="nav-link" style="color: white">
              <i class="nav-icon fas fa-file"></i>
              <p>Inventarios</p>
            </a>
          </li>
          <?php } ?>


          <?php if($cat_usuario=="Admin" or $cat_usuario=='suc' or $_SESSION["citas_callcenter"]==1){ ?>
          <li class="nav-item">
            <a href='#' class="nav-link" style="color: white">
              <i class="nav-icon fas fa-file"></i>
              <p>Citas</p><i class="fas fa-angle-left right"></i>
            </a>

          <ul class="nav nav-treeview">
          <?php if($_SESSION["citas_callcenter"]==1){ ?>
          <li class="nav-item">
              <a href="../citas/index.php" class="nav-link">
                <i class="far fa-circle nav-icon text-success"></i>
                  <p>Agendar citas</p>
                </a>
          <?php }?>
          <?php if($_SESSION["citas_sucursal"]==1){ ?>
          <li class="nav-item">
              <a href="../print-citas/index.php" class="nav-link">
                <i class="far fa-circle nav-icon text-success"></i>
                  <p>Citas Diarias</p>
                </a>
              </li>
            <?php }?>
            <li class="nav-item">
              <a href="rectificaciones.php" class="nav-link">
                <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Reporteria Citas</p>
                </a>
              </li>
          </ul>
          </li>
          <?php } ?>

          <?php if($cat_usuario==1){ ?>
          <li class="nav-item">
            <a href='envios_ord.php' class="nav-link" style="color: white">
              <i class="nav-icon  fas fa-exchange-alt"></i>
              <p>Gestionar Lentes</p>
            </a>
          </li>

          <li class="nav-item">
            <a href='lenses.php'class="nav-link" style="color: white">
              <i class="nav-icon fab fa-tripadvisor"></i>
              <p>Lenses</p>
            </a>
          </li>

          <li class="nav-item">
            <a href='orders.php'class="nav-link" style="color: white">
              <i class="nav-icon fas fa-glasses"></i>
              <p>Aros</p>
            </a>
          </li>
          <?php } ?>
          <?php if(in_array("ver_laboratorio",$_SESSION['names_permisos']) OR $cat_usuario=="Admin"):?>
          <li class="nav-item">
            <a href='ingreso_lab.php' class="nav-link" style="color: white">
              <i class="nav-icon fas fa-file"></i>
              <p>Laboratorio</p>
            </a>
          </li>
          <?php endif ?>

          <?php if(in_array("ver_laboratorio",$_SESSION['names_permisos']) OR $cat_usuario=="Admin"):?>
          <li class="nav-item">
            <a href=''class="nav-link" style="color: white">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p >Facturas</p><i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="factura_manual.php" class="nav-link">
              <i class="far fa-circle nav-icon text-success"></i>
                  <p>Factura manual</p>
                </a>
            </li>
            <li class="nav-item">
              <a href="credito_fiscal.php" class="nav-link">
                <i class="far fa-circle nav-icon text-success"></i>
                  <p>Crédito fiscal</p>
                </a>
            </li>
            </ul>  
            </li>
          <?php endif ?>

          <?php if($cat_usuario==1 or $cat_usuario==4){ ?>
          <li class="nav-item">
            <a href='stock_term.php' class="nav-link" style="color: white">
              <i class="nav-icon fas fa-file"></i>
              <p>Bodegas</p>
              <i class="fas fa-angle-left right"></i>
            </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="stock_term.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-info"></i>
                  <p>Gestionar bodegas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ingresos_bodega.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-success"></i>
                  <p>Ingresos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="descargos_bodega.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>Inv. Bases</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>

          <li class="nav-item">
                <a href="j.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-success"></i>
                  <p>Reporteria Admin.</p>
                </a>
              </li>

        </ul>
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <input type="hidden" id="categoria-usuer-hist" value="<?php echo $_SESSION["categoria"];?>">
  </aside>