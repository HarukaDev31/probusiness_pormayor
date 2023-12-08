<body class="bg-light">
  <header>
    <nav class="fixed-top navbar bg-light menu-shadow p-0 pt-0 pt-sm-2">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo base_url(); ?>" rel="noopener noreferrer">
          <img class="mb-0 mb-sm-1" src="<?php echo base_url("assets/images/logo_probusiness.png?ver=5.0.0"); ?>" alt="Logo ProBusiness" height="45">
        </a>
        
        <?php
        $sClassCartShopHidden = '';
        if(isset($bCartShop) && $bCartShop==false) {
          $sClassCartShopHidden = 'd-none';
        }
        ?>
        
        <div class="d-flex <?php echo $sClassCartShopHidden; ?>">
          <div class="mb-3 mt-2 mt-sm-0">
            <button type="button" id="btn-user" class="btn btn-success btn-lg me-3" data-bs-toggle="modal" data-bs-target="#modalUser">
              <div class="d-none d-sm-block"><i class="fa-solid fa-user"></i>&nbsp; Ingresar</div>
              <div class="d-block d-sm-none">Ingresar</div>
            </button>
          </div>

          <div class="position-relative mt-3 mt-sm-2 me-2">
            <button type="button" id="icon-ver-cart_shop" class="btn btn-none position-relative p-0 m-0" data-bs-toggle="modal" data-bs-target="#modal_cart_shop">
              <i class="fa-solid fa-bag-shopping fa-2x"></i>
              <span id="span-cart-global_cantidad" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo (isset($_SESSION['cart']) ? countBooks($_SESSION['cart']) : '0'); ?>
              </span>
            </button>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- Modal carrito de compras -->
  <div class="modal fade modal-cart_shop" id="modal_cart_shop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-cart_shop-dialog">
      <div class="modal-content modal-cart_shop-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold">Carrito de Compras</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="modal-cart-items" class="modal-body modal-cart_shop-body" style="">
        </div>
        <div class="modal-footer modal-cart_shop-footer fixed-bottom bg-white border border-0 shadow-new">
          <div id="modal-footer_total" class="d-grid" style="width: 100%;">
          </div>

          <div class="d-grid" style="width: 100%;">
            <a type="button" href="<?php echo base_url('payment'); ?>" rel="noopener noreferrer" class="btn btn-success btn-lg">Completar pedido</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- User -->
  <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUser" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fw-bold" id="">Iniciar sesión</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
          <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
              <label class="fw-bold">Usuario</label>
              <div class="form-group">
                <input type="text" id="user" inputmode="email" name="user" class="form-control required" placeholder="Ingresar" autocomplete="on">
                <span class="help-block text-danger" id="error"></span>
              </div>
            </div>
            
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
              <label class="fw-bold">Contraseña</label>
              <div class="form-group">
                <input type="password" id="password" inputmode="password" name="password" class="form-control required" placeholder="Ingresar" autocomplete="on">
                <span class="help-block text-danger" id="error"></span>
              </div>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
              <button type="button" class="btn btn-secondary btn-lg btn-block" style="width: 100%;">Iniciar Sesión</button>
            </div>
            
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
              <button type="button" class="btn btn-success btn-lg btn-block" style="width: 100%;">Crear cuenta</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  //echo "<br><br>";
  //var_dump($arrImportacionGrupalProducto['status']);
  if (isset($arrImportacionGrupalProducto) && $arrImportacionGrupalProducto['status'] == 'success') {
    $arrImportacionGrupalProducto = $arrImportacionGrupalProducto['result'];
  ?>
    <input type="hidden" id="hidden-global-id_importacion_grupal" class="form-control" value="<?php echo $arrImportacionGrupalProducto[0]->ID_Importacion_Grupal; ?>">
    <input type="hidden" id="hidden-global-id_empresa" class="form-control" value="<?php echo $arrImportacionGrupalProducto[0]->ID_Empresa; ?>">
    <input type="hidden" id="hidden-global-id_organizacion" class="form-control" value="<?php echo $arrImportacionGrupalProducto[0]->ID_Organizacion; ?>">
    <input type="hidden" id="hidden-global-id_pais" class="form-control" value="<?php echo $arrImportacionGrupalProducto[0]->ID_Pais; ?>">
    <input type="hidden" id="hidden-global-id_moneda" class="form-control" value="<?php echo $arrImportacionGrupalProducto[0]->ID_Moneda; ?>">
    <input type="hidden" id="hidden-global-signo_moneda" class="form-control" value="<?php echo $arrImportacionGrupalProducto[0]->No_Signo; ?>">
  <?php
    }
  ?>