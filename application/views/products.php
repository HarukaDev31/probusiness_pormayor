<main><br><br>
  <div class="mt-5">
    <div class="container">
        <!-- row -->
        <div class="row">
          <!-- col -->
          <div class="col-12">
              <!-- breadcrumb -->
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="<?php echo base_url('inicio'); ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="#"><?php echo $item->No_Familia; ?></a></li>

                    <li class="breadcrumb-item active" aria-current="page"><?php echo $item->No_Producto; ?></li>
                </ol>
              </nav>
          </div>
        </div>
    </div>
  </div>
  <?php
  //array_debug($item);
  //comentar
  //$item->No_Imagen_Item = 'https://intranet.probusiness.pe/assets/images/productos/20603287721/SCOOTER_ELECTRICO__01pn3.png';
  ?>
  <section class="mt-4">
    <div class="container">
        <div class="row">
          <div class="col-md-6">            
            <div class="h-100 bg-white p-4 rounded shadow-sm">
              <?php
              $imgSvg = '';
              $videoHtml = '';
              $data_allowfullscreen = 'data-allowfullscreen="true"';
              if(!empty($item->Txt_Url_Video_Lae_Shop)){
                $data_allowfullscreen = 'data-allowfullscreen="false"';
                $videoHtml = '<a href="'.$item->Txt_Url_Video_Lae_Shop.'" data-video="true"></a>';
              }
              ?>
              <div class="fotorama" data-nav="thumbs" data-width="100%" data-maxwidth="100%" data-ratio="700/467" data-minheight="350" data-maxheight="100%" <?php echo $data_allowfullscreen; ?> data-loop="true" data-thumbwidth="100" data-thumbheight="100" data-arrows="true" data-click="false" data-swipe="true">
                <?php
                $bPintoVideo = false;
                $i=1;
                foreach ($item->imagenes as $row_imagen) {
                ?>
                  <a href="<?php echo $row_imagen->No_Producto_Imagen;?>">
                    <img src="<?php echo $row_imagen->No_Producto_Imagen;?>" class="img-thumbnail border-0 float-start" alt="<?php echo quitarCaracteresEspeciales($item->No_Producto); ?>" style="cursor: grab !important;">
                  </a>
                <?php
                  if($i == 1 && !empty($videoHtml) && $bPintoVideo!=true){
                    echo $videoHtml;
                    $bPintoVideo = true;
                  }
                  ++$i;
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="ps-lg-10 mt-6 mt-md-0 bg-white p-4 rounded shadow-sm">
              <!-- content -->
              <div class="mb-2"><a class="text-decoration-none" href="#!" class="mb-4 d-block"><?php echo $item->No_Familia; ?></a></div>
              <!-- heading -->
              <h2 class="mb-1 fw-semibold"><?php echo $item->No_Producto; ?></h2>
              <div class="mt-2">
                <div class="fw-bold">Precio China: <?php echo $arrImportacionGrupalProducto[0]->No_Signo . ' ' . $item->precio_item; ?></div>
                <div class="fw-bold">Precio Perú: <?php echo $arrImportacionGrupalProducto[0]->No_Signo . ' ' . $item->precio_item_2; ?></div>
              </div>
              <!-- hr -->
              <hr class="my-6">
              <div class="mt-3 row justify-content-start g-2 align-items-center">
                <div class="row">
                  <div class="ps-3 pe-3 pb-2 pb-sm-0 col-12 col-sm-6 col-md-6 col-xl-6 number-input md-number-input item-unitario">
                    <!-- background: #92dda9; --><button style="width: 30%; height: auto; " class="border bg-light plus" onclick="subir(<?php echo $item->ID_Producto . $item->ID_Unidad_Medida; ?>)"><i style="font-size: .5rem;" class="fas fa-plus"></i></button>
                    <input style="width: 40%;" onkeyup="validateStockNow(event);" inputmode="numeric" class="text-center input-cantidad_item input-decimal form-control" id="input_cantidad_item-<?php echo $item->ID_Producto . $item->ID_Unidad_Medida; ?>" data-id_item="<?php echo $item->ID_Producto . $item->ID_Unidad_Medida; ?>" data-cantidad_item_minima="<?php echo $item->cantidad_item; ?>" value="<?php echo $item->cantidad_item; ?>">
                    <!-- background: #92dda9; --><button style="width: 30%; height: auto;" class="border bg-light minus" onclick="bajar(<?php echo $item->ID_Producto . $item->ID_Unidad_Medida; ?>)"><i style="font-size: .5rem;" class="fas fa-minus"></i></button>
                  </div>
                  <div id="div-agregar_item-<?php echo $item->ID_Producto . $item->ID_Unidad_Medida; ?>" class="d-grid col-12 col-sm-6 col-md-6 col-xl-6">
                    <button id="btn-agregar_item-<?php echo $item->ID_Producto . $item->ID_Unidad_Medida; ?>" data-id_unidad_medida_2="" data-id_unidad_medida="<?php echo $item->ID_Unidad_Medida; ?>" data-id_item_bd="<?php echo $item->ID_Producto; ?>" data-id_item="<?php echo $item->ID_Producto . $item->ID_Unidad_Medida; ?>" data-cantidad_item="<?php echo $item->cantidad_item; ?>" data-precio_item="<?php echo $item->precio_item; ?>" data-nombre_item="<?php echo $item->No_Producto; ?>" data-url_imagen_item="<?php echo $item->No_Imagen_Item . '?ver=' . $item->Nu_Version_Imagen; ?>" class="btn btn-success btn-agregar_item position-relative" type="button">Agregar</button>
                  </div>
                </div>
              </div>
              <!-- hr -->
              <hr class="my-6">
              <div class="accordion accordion-flush border rounded mt-3" id="<?php echo $item->ID_Producto; ?>">
                <div class="accordion-item rounded">
                  <h2 class="accordion-header" id="flush-headingOne-<?php echo $item->ID_Producto; ?>">
                    <button class="accordion-button rounded collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?php echo $item->ID_Producto; ?>" aria-expanded="false" aria-controls="flush-collapseOne">
                      <h5 class="card-title fw-bold">
                        Características
                      </h5>
                    </button>
                  </h2>
                  <div id="flush-<?php echo $item->ID_Producto; ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne-<?php echo $item->ID_Producto; ?>" data-bs-parent="#<?php echo $item->ID_Producto; ?>">
                    <div class="accordion-body">
                      <?php echo nl2br($item->Txt_Producto); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </section>
</main>