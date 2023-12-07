<main>
  <div id="carouselExampleDark" class="carousel carousel-dark slide mt-5" data-bs-ride="carousel" style="margin-top: 4rem !important;">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="width: 10px;height: 10px;border-radius: 100%;"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2" style="width: 10px;height: 10px;border-radius: 100%;"></button>
    </div>
    
    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="3000">
        <img src="<?php echo base_url("assets/images/banner_importacion_grupal.jpg?ver=1.0.0"); ?>" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="3000">
        <img src="<?php echo base_url("assets/images/banner_importacion_grupal_carga.png?ver=1.0.0"); ?>" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
    </div>
  </div>
  
  <div class="container mt-5">
    <?php
    if ($arrImportacionGrupalProducto['status'] == 'success') {
      $arrImportacionGrupalProducto = $arrImportacionGrupalProducto['result'];

      //array_debug($arrImportacionGrupalProducto);
    ?>
      <h1 class="text-center"><?php echo $arrImportacionGrupalProducto[0]->No_Importacion_Grupal; ?></h1>
      <p class="text-center lead mb-5">
        Fecha de Inicio: <?php echo ToDateBD($arrImportacionGrupalProducto[0]->Fe_Inicio); ?> y
        Fecha de Cierre: <?php echo ToDateBD($arrImportacionGrupalProducto[0]->Fe_Fin); ?>
        <br>
        <?php echo nl2br($arrImportacionGrupalProducto[0]->Txt_Importacion_Grupal); ?>
      </p>

      <!-- diseño de item -->
      <?php foreach ($arrImportacionGrupalProducto as $row) { ?>
      <div class="card border-0 rounded shadow mt-5">
        <div class="row g-0">
          <div class="col-sm-4 position-relative">
            <div class="col-sm-12 p-4">
              <h5 class="card-title mb-3 fw-bold">
                <span class="link-dark text-decoration-none" href="#" target="_blank">
                  <?php echo $row->No_Producto; ?>
                </span>
              </h5>

              <div class="h-100">
                <?php
                $imgSvg = '';
                $videoHtml = '';
                $data_allowfullscreen = 'data-allowfullscreen="true"';
                if(!empty($row->Txt_Url_Video_Lae_Shop)){
                  $data_allowfullscreen = 'data-allowfullscreen="false"';
                  $videoHtml = '<a href="'.$row->Txt_Url_Video_Lae_Shop.'" data-video="true"></a>';
                }
                ?>
                <div class="fotorama" data-nav="thumbs" data-width="100%" data-maxwidth="100%" data-ratio="700/467" data-minheight="350" data-maxheight="100%" <?php echo $data_allowfullscreen; ?> data-loop="true" data-thumbwidth="100" data-thumbheight="100" data-arrows="true" data-click="false" data-swipe="true">
                  <?php
                  foreach ($row->imagenes as $row_imagen) {
                  ?>
                    <a href="<?php echo $row_imagen->No_Producto_Imagen;?>">
                      <img src="<?php echo $row_imagen->No_Producto_Imagen;?>" class="img-thumbnail border-0 rounded float-start" alt="<?php echo quitarCaracteresEspeciales($row->No_Producto); ?>" style="cursor: grab !important;">
                    </a>
                  <?php
                  }
                  echo $videoHtml;
                  ?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-8">
            <div class="card-body">
              <!--
              <h2 class="card-title mb-0">
                <a class="link-dark text-decoration-none" href="#" target="_blank">
                  <?php echo $row->No_Producto; ?>
                </a>
              </h2>
                -->
              <!--<div class="table-responsive">-->
                

                <table id="table_item-<?php echo $row->ID_Producto; ?>" class="table table-hover">
                  <thead>
                    <tr>
                      <th class="pb-3 pb-sm-2" scope="col">Unidad</th>
                      <th scope="col">Cantidad Mínima</th>
                      <th scope="col">Precio Unitario</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="d-none td-precio_item"><?php echo $row->precio_item; ?></td>
                      <td><?php echo $row->No_Unidad_Medida; ?></td>
                      <td class="td-cantidad_item"><?php echo $row->cantidad_item; ?></td>
                      <td><?php echo $row->No_Signo . ' ' . $row->precio_item; ?></td>
                      <td>
                      </td>
                    </tr>
                    <tr>
                      <td class="d-none td-precio_item"><?php echo $row->precio_item_2; ?></td>
                      <td><?php echo $row->No_Unidad_Medida_2; ?></td>
                      <td class="td-cantidad_item"><?php echo $row->cantidad_item_2; ?></td>
                      <td><?php echo $row->No_Signo . ' ' . $row->precio_item_2; ?></td>
                      <td>
                        <!--
                        <div id="div-agregar_item-<?php echo $row->ID_Producto . $row->ID_Unidad_Medida_2; ?>" class="d-grid">
                          <button id="btn-agregar_item-<?php echo $row->ID_Producto . $row->ID_Unidad_Medida_2; ?>" data-id_unidad_medida="" data-id_unidad_medida_2="<?php echo $row->ID_Unidad_Medida_2; ?>" data-id_item_bd="<?php echo $row->ID_Producto; ?>" data-id_item="<?php echo $row->ID_Producto . $row->ID_Unidad_Medida_2; ?>" data-cantidad_item="<?php echo $row->cantidad_item_2; ?>" data-precio_item="<?php echo $row->precio_item_2; ?>" data-nombre_item="<?php echo $row->No_Producto; ?>" data-url_imagen_item="<?php echo $row->No_Imagen_Item . '?ver=' . $row->Nu_Version_Imagen; ?>" class="btn btn-success btn-agregar_item position-relative" type="button">Agregar</button>
                        </div>
                        -->
                      </td>
                    </tr>
                  </tbody>
                </table>
                
                <div class="col-12 col-sm-5 col-xl-12 col-md-12 number-input md-number-input item-unitario">
                  <!-- background: #92dda9; --><button style="width: 30%; height: 30px; " class="plus" onclick="subir(<?php echo $row->ID_Producto . $row->ID_Unidad_Medida; ?>)"><i style="font-size: .5rem;" class="fas fa-plus"></i></button>
                  <input style="width: 40%;" onkeyup="validateStockNow(event);" class="text-center mb-2 pt-0 pb-1 input-cantidad_item input-decimal form-control" id="input_cantidad_item-<?php echo $row->ID_Producto . $row->ID_Unidad_Medida; ?>" data-id_item="<?php echo $row->ID_Producto . $row->ID_Unidad_Medida; ?>" data-cantidad_item_minima="<?php echo $row->cantidad_item; ?>" value="<?php echo $row->cantidad_item; ?>">
                  <!-- background: #92dda9; --><button style="width: 30%; height: 30px;" class="minus" onclick="bajar(<?php echo $row->ID_Producto . $row->ID_Unidad_Medida; ?>)"><i style="font-size: .5rem;" class="fas fa-minus"></i></button>
                </div>
                <div id="div-agregar_item-<?php echo $row->ID_Producto . $row->ID_Unidad_Medida; ?>" class="d-grid">
                  <button id="btn-agregar_item-<?php echo $row->ID_Producto . $row->ID_Unidad_Medida; ?>" data-id_unidad_medida_2="" data-id_unidad_medida="<?php echo $row->ID_Unidad_Medida; ?>" data-id_item_bd="<?php echo $row->ID_Producto; ?>" data-id_item="<?php echo $row->ID_Producto . $row->ID_Unidad_Medida; ?>" data-cantidad_item="<?php echo $row->cantidad_item; ?>" data-precio_item="<?php echo $row->precio_item; ?>" data-nombre_item="<?php echo $row->No_Producto; ?>" data-url_imagen_item="<?php echo $row->No_Imagen_Item . '?ver=' . $row->Nu_Version_Imagen; ?>" class="btn btn-success btn-agregar_item position-relative" type="button">Agregar</button>
                </div>
              <!--</div>-->
              <p class="card-text">
                <?php echo nl2br($row->Txt_Producto); ?>
              </p>

              <!-- oculto falta agregar solucion amarrada a los pedidos para saber cuanto se está vendiendo en tiempo real style="width: 80%;" --->
              <?php
              $fPorcentajeVentas='';
              $row->total_cantidad_vendida=0;
              if($row->total_cantidad_vendida>0) {
                $row->total_cantidad_vendida = round($row->total_cantidad_vendida, 0);
                $fPorcentajeVentas = ($row->total_cantidad_vendida*100);
                $fPorcentajeVentas = ($fPorcentajeVentas / $row->Qt_Pedido_Minimo_Proveedor);
              }
              ?>

              <div class="mb-4">
                <span><strong>Vendidos</strong></span>
                <div class="progress" style="height: 35px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $fPorcentajeVentas; ?>%;" aria-valuenow="<?php echo $row->total_cantidad_vendida; ?>" aria-valuemin="0" aria-valuemax="100"><span class="text-white"><strong><?php echo $row->total_cantidad_vendida; ?> / <?php echo $row->Qt_Pedido_Minimo_Proveedor; ?></strong></span></div>
                </div>
              </div>

              <?php
              $codigo_pais="51";
              $numero_celular="932531441";
              $phone = $codigo_pais . $numero_celular;
              $sSignoMoneda = $arrImportacionGrupalProducto[0]->No_Signo;
              
              $sNombreUnidadMedidaWhatsApp = "*" . trim($row->No_Unidad_Medida) . "* 📦";
              $fTotalItem = ($row->cantidad_item * $row->precio_item);
              $message_wp = "Hola *ProBusiness*. Me gustaría comprar el producto de tu tienda: \n\n";
              $message_wp .= "✅ Producto: *" . quitarCaracteresEspeciales($row->No_Producto) . "*\n\n";
              $message_wp .= "🅰️ " . $sNombreUnidadMedidaWhatsApp . "\n";
              $message_wp .= "Contiene *" . round($row->cantidad_item, 2) . "* unidades\n";
              $message_wp .= "Precio (c/u): *" . $sSignoMoneda . " " . number_format($row->precio_item, 2, '.', ',') . "*\n";
              $message_wp .= "Total: *" . $sSignoMoneda . " " . number_format($fTotalItem, 2, '.', ',') . "*\n";
              $message_wp .= "_(Puede separar con el 50% " . $sSignoMoneda . " " . number_format(($fTotalItem / 2), 2, '.', ',') . ")_\n\n";
              
              $sNombreUnidadMedida2WhatsApp = "*" . trim($row->No_Unidad_Medida_2) . "* 📦";
              $fTotalItem = ($row->cantidad_item_2 * $row->precio_item_2);
              $message_wp .= "🅱️ " . $sNombreUnidadMedida2WhatsApp . "\n";
              $message_wp .= "Contiene *" . round($row->cantidad_item_2, 2) . "* unidades\n";
              $message_wp .= "Precio (c/u): *" . $sSignoMoneda . " " . number_format($row->precio_item_2, 2, '.', ',') . "*\n";
              $message_wp .= "Total: *" . $sSignoMoneda . " " . number_format($fTotalItem, 2, '.', ',') . "*\n";
              $message_wp .= "_(Puede separar con el 50% " . $sSignoMoneda . " " . number_format(($fTotalItem / 2), 2, '.', ',') . ")_\n\n";

              $message_wp .= "¿Qué opción eliges 🅰️ ó 🅱️?";
              
              $message_wp = urlencode($message_wp);
              $sURLSendMessageWhatsapp = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . $message_wp;
              ?>
              <a class="btn btn-outline-success btn-lg btn-block mb-3" style="width:100%" href="<?php echo $sURLSendMessageWhatsapp; ?>" target="_blank" rel="noopener noreferrer">Pedir por WhatsApp</a>

            </div>
          </div>
        </div>
      </div>
      <!-- fin de diseño de item -->
      <?php } ?>
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
        <!--<div id="" class="text-left fw-bold fs-5 div-cart_total_adelanto d-block d-sm-none" style="font-size: 1.10rem !important;"></div>-->
        <div id="" class="mb-1 text-center fw-bold fs-6 div-cart_total_adelanto d-block d-sm-none" style="font-size: .95rem !important;"></div>
        <div class="d-grid mt-0 mt-sm-3">
          <button id="btn-ver-cart_shop" class="btn btn-success me-md-2 btn-lg" type="button">Ver pedido</button>
        </div>
      </div>
    </div>
  </div>
</div>