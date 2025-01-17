<main>
  <!-- banners -->
  <?php
  if ($arrBanner['status'] == 'success') {
  ?>
  <div id="carouselExampleDark" class="carousel carousel-dark slide mt-5" data-bs-ride="carousel" style="margin-top: 4rem !important;">
    <div class="carousel-indicators">
      <?php
      $iCounter = 0;
      foreach ($arrBanner['result'] as $row) {
        $row->No_Imagen_Url_Inicio_Slider = 'https://intranet.probusiness.pe/assets/images/sliders/20603287721/31a010478548a03d95e20b1a4bef0b35.jpg';
        if( $row->Nu_Tipo_Inicio==1 ) {//1=pc y 3=mobile
      ?>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?php echo $iCounter; ?>" class="<?php echo ($iCounter==0 ? 'active' : ''); ?>" aria-label="<?php echo $row->No_Slider; ?>" style="width: 10px;height: 10px;border-radius: 100%;"></button>
      <?php
        ++$iCounter;
        }
      }
      ?>
    </div>
    
    <div class="carousel-inner">
      <?php
      foreach ($arrBanner['result'] as $row) {
        $row->No_Imagen_Url_Inicio_Slider = 'https://intranet.probusiness.pe/assets/images/sliders/20603287721/31a010478548a03d95e20b1a4bef0b35.jpg';
        if( $row->Nu_Tipo_Inicio==1 ) {//1=pc y 3=mobile
      ?>
      <div class="carousel-item active" data-bs-interval="5000">
        <img src="<?php echo $row->No_Imagen_Url_Inicio_Slider; ?>" class="d-block w-100" alt="<?php echo $row->No_Slider; ?>">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
  <?php } ?>

  <?php
  //array_debug($arrCategorias);
  ?>
  <!-- categorias -->
  
  <?php
  if($arrCategorias['status']=='success'){
  ?>
  <div class="container mb-2 mt-4">
    <div class="home-div-card mv espacio-total p-0 py-3 px-3 mb-4">
      <div class="row">
        <div class="col-sm-12">
          <h4 class="p-0 m-0">
            <span class="fw-bold">Categorías</span>
          </h4>
        </div>
      </div>
    </div>

    <div class="carro px-2">
      <?php $iCounter = 0;
      foreach($arrCategorias['result'] as $row) {
        //comentar
        //$row->No_Imagen_Url_Categoria = 'https://images.falabella.com/v3/assets/bltf4ed0b9a176c126e/bltf0da18330b0710bd/6564d1a4867c0b7a80389712/CAT-02-DK-Jugueteria-221123-RN.jpg?disable=upscale&format=webp&quality=70&width=1280';
        if ( $iCounter == 6 ) break; ?>
          <div class="px-2 me-3 div-categoria_a">
            <a class="text-decoration-none" href="<?php echo base_url("categoria/" . $row->ID_Familia . "/" . urlencode($row->No_Familia)); ?>">
              <div class="alto-fijo radius">
                <div class="rounded-circle bg-white radius template-categoria-inicio template-categoria-size template-box_shadow">
                  <img class="rounded-circle img-categoria-size" src="<?php echo $row->No_Imagen_Url_Categoria; ?>?nocache=<?php echo $row->Nu_Version_Imagen; ?>" alt="<?php echo $row->No_Familia; ?>">
                </div>
              </div>
              <p class="text-center mt-3 text-black-50" title="<?php echo $row->No_Familia; ?>"><?php echo (strlen($row->No_Familia) ? $row->No_Familia : substr($row->No_Familia, 0, 23) . '...'); ?></p>
            </a>
          </div>
        <?php ++$iCounter;
      }
      if ($iCounter == 6) { ?>
        <div class="px-2">
          <div class="py-1 bg-white radius home-div-card alto-fijo template-box_shadow">
            <a href="<?php echo base_url(); ?>categoria" class="col-5 col-sm-3 item-ct  d-flex flex-column justify-content-center mx-auto">
              <div class="d-flex justify-content-center">
                  <i style="font-size: 3rem; color: <?php echo $sColorHtml; ?> !important; display: block;margin: auto;" class="categorie-top-ver_more fas fa-th"></i>
              </div>
              <p class="text-center">Ver más</p>
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <?php } ?>

  <!--productos-->
  <div class="container mt-3">
    <div class="home-div-card mv espacio-total p-0 py-3 px-3 mb-1">
      <div class="row">
        <div class="col-sm-12">
          <h4 class="p-0 m-0">
            <span class="fw-bold">Novedades</span>
          </h4>
        </div>
      </div>
    </div>

    <?php
    if ($arrImportacionGrupalProducto['status'] == 'success') {
      $arrImportacionGrupalProducto = $arrImportacionGrupalProducto['result'];
    ?>
      <!-- diseño de item -->
      <div class="row">
        <?php foreach ($arrImportacionGrupalProducto as $row) {
        //comentar cloud
        //$row->No_Imagen_Item = 'https://intranet.probusiness.pe/assets/images/productos/20603287721/SCOOTER_ELECTRICO__01pn3.png';
        ?>
          <div class="col-6 col-sm-3">
            <a class="text-decoration-none text-black" href="<?php echo base_url("products/" . $row->ID_Producto . "/" . urlencode($row->No_Producto)); ?>">
              <div class="card border-0 rounded shadow-sm mt-3 p-3">
                <img src="<?php echo $row->No_Imagen_Item; ?>" class="img-thumbnail border-0 float-start" alt="<?php echo urlencode($row->No_Producto); ?>">

                <h6 class="card-title mt-3 fw-normal name_item height-titulo_item">
                  <?php echo $row->No_Producto; ?>
                </h6>
                
                <div class="mt-2">
                  <div class="fw-bold d-none">
                    <div class="d-none d-sm-block">
                      Precio China: <?php echo $row->No_Signo . ' ' . $row->precio_item; ?>
                    </div>
                    <div class="d-block d-sm-none">
                      <p class="mb-1">Precio China</p>
                      <?php echo $row->No_Signo . ' ' . $row->precio_item; ?>
                    </div>
                  </div>
                  <div class="fw-bold">
                    <div class="d-none d-sm-block">
                      Perú 🇵🇪 <?php echo $row->No_Signo . ' ' . $row->precio_item_2; ?>
                    </div>
                    <div class="d-block d-sm-none">
                      <p class="mt-2 mb-1">Perú 🇵🇪</p>
                      <?php echo $row->No_Signo . ' ' . $row->precio_item_2; ?>
                    </div>
                  </div>
                </div>
                
                <div class="mt-2">
                  <div>Cantidad mín.: <?php echo $row->Qt_Pedido_Minimo_Proveedor; ?></div>
                </div>
              </div>
            </a>
          </div>
        <?php } ?>
      </div>
    <?php } else { ?>
      <div class="alert alert-warning" role="alert">
        <h5 class="text-center"><?php echo $arrImportacionGrupalProducto['message']; ?></h5>
      </div>
    <?php } ?>
  </div>
  
  <?php
  $codigo_pais="51";
  $numero_celular="932531441";
  $phone = $codigo_pais . $numero_celular;
  $message_wp = "Hola *ProBusiness*. Me gustaría comprar el producto de tu tienda.";
  $sURLSendMessageWhatsapp = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . $message_wp;
  ?>
  <a class="flotante-wp" href="<?php echo $sURLSendMessageWhatsapp; ?>" target="_blank" rel="noopener noreferrer"><img class="size-wp" src="<?php echo base_url("assets/images/whatsapp.png?ver=2.0"); ?>" alt="ProBusiness WhastApp"></a>

</main>

<div id="div-footer-cart" class="fixed-bottom mt-auto py-3 bg-white footer-cart-shadow" data-bs-toggle="modal" data-bs-target="#modal_cart_shop">
  <div class="container">
    <div class="row">
      <div class="col-5 col-sm-6">
        <div id="div-cart_items"></div>
        <div id="div-cart_total" class="fw-bold fs-6"></div>
        <div id="" class="text-left fw-bold fs-5 div-cart_total_adelanto d-none d-sm-block" style="font-size: 1.10rem !important;"></div>
      </div>
      <div class="col-7 col-sm-6">
        <div id="" class="mb-1 text-center fw-bold fs-6 div-cart_total_adelanto d-block d-sm-none" style="font-size: .95rem !important;"></div>
        <div class="d-grid mt-0 mt-sm-3">
          <button id="btn-ver-cart_shop" class="btn btn-success me-md-2 btn-lg" type="button">Ver pedido</button>
        </div>
      </div>
    </div>
  </div>
</div>