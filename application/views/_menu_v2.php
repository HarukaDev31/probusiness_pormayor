<body>
  <header>
    <nav class="fixed-top navbar bg-light menu-shadow">
      <div class="container-fluid">
        <a class="navbar-brand">
          <img class="mb-2" src="<?php echo base_url("assets/images/logo_horizontal_probusiness_claro_2.png?ver=1.0.0"); ?>" alt="" height="45">
        </a>
        
        <button type="button" class="btn btn-primary position-relative">
          <i class="fa-solid fa-bag-shopping fa-2x"></i>
          <span id="span-cart-global_cantidad" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            0
          </span>
        </button>
      </div>
    </nav>
  </header>

  <!-- Modal carrito de compras -->
  <div class="modal fade modal-cart_shop" id="modal_cart_shop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-cart_shop-dialog">
      <div class="modal-content modal-cart_shop-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold">Carrito de Compras</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-cart-items">
          <!--  
          <div class="container py-5 px-5 text-center">
            <i class="mb-3 fa-solid fa-cart-shopping fa-3x"></i><br>
            <span class="mb-3">Tu carrito de compras está vacío</span><br>
            <a type="button" href="<?php echo base_url(); ?>" rel="noopener noreferrer" class="mt-3 btn btn-secondary">Comenzar a comprar</a>
          </div>
          -->

          <div class="row div-line pb-2">
            <div class="col-12">
              <div class="modal-cart_shop-div_item" id="delete_item_562260">
                <a href="#" class="modal-cart_shop-img_item">
                  <img src="https://ecxpresslae.com/assets/images/productos/468149/Para_Juntoz,_SagaFalabella,-166jp.jpg">
                </a>
                <div class="modal-cart_shop-body_item">
                  <h3 class="modal-cart_shop-title_item">Depilador Coorporal Yes</h3>
                  <div class="modal-cart_shop-div-precio_item">
                    <span class="fw-bold">
                      S/ <span data-total_producto="80" id="total-por-producto_562260">80.00</span>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="modal-cart_shop-div-eliminar_item">
                    <button class="btn btn-default text-danger">
                      <i aria-hidden="true" class="fas fa-trash-alt text-danger"></i> Eliminar
                    </button>
                  </div>
                </div>
                <div class="col-6">
                  <div class="modal-cart_shop-cantidad_item text-right">
                    <button class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i></button>
                    &nbsp;<p class="fs-5 text px-1 mt-1 mb-1">1</p>&nbsp;
                    <button class="btn btn-primary btn-sm"><i class="fa-solid fa-minus"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="col-12 d-grid">
            <button type="button" class="btn btn-primary btn-lg">Finalizar pedido</button>
          </div>
        </div>
      </div>
    </div>
  </div>
