<main><br><br>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-7 col-lg-8">
        <div class="col-12 col-sm-12 col-md-12">
          <h2 class="text-left mb-3 fw-bold">Información de contacto</h2>
          <form>
            <div class="card" style="border: none;">
              <div class="card-body shadow p-3 bg-body rounded">
                <div class="row">
                  <div class="col-12 col-sm-6 col-md-12 col-lg-6 mb-3">
                    <label class="fw-bold">DNI / RUC / OTROS <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <input type="text" id="payment-documento_identidad" inputmode="numeric" name="Nu_Documento_Identidad" class="form-control required input-number" placeholder="Ingresar" maxlength="15" autocomplete="on">
                      <span class="help-block text-danger" id="error"></span>
                    </div>
                  </div>
                  
                  <div class="col-12 col-sm-6 col-md-12 col-lg-6 mb-3">
                    <label class="fw-bold">Nombres y Apellidos <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <input type="text" inputmode="text" id="payment-nombre_cliente" name="name" class="form-control required" placeholder="Ingresar" maxlength="100" autocomplete="name">
                      <span class="help-block text-danger" id="error"></span>
                    </div>
                  </div>
                  
                  <div class="col-12 col-sm-6 col-md-12 col-lg-6 mb-3">
                    <label class="fw-bold">Celular <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <input type="tel" inputmode="tel" id="payment-celular_cliente" name="tel" class="form-control required input-number" placeholder="Ingresar" maxlength="9" autocomplete="tel">
                      <span class="help-block text-danger" id="error"></span>
                    </div>
                  </div>
                  
                  <div class="col-12 col-sm-6 col-md-12 col-lg-6 mb-3">
                    <label class="fw-bold">Email <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <input type="text" id="payment-email" inputmode="email" name="email" class="form-control required" placeholder="Ingresar" maxlength="100" autocomplete="email" autocapitalize="none">
                      <span class="help-block text-danger" id="error"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <?php
        //array_debug($arrDepartamento);
        //array_debug($arrProvincia);
        //array_debug($arrDistrito);
        //array_debug($arrShipping);
        //array_debug($arrWhareHouse);
        ?>

        <div class="container-fluid div-finalizar_compra-tipo_entrega div-tipo_compra-invitado mt-2 mb-3">
					<div class="box-tipo-envio">
            <h2 class="text-left mb-3 fw-bold">¿Donde recibirás tú compra?</h2>
						<?php if ( $arrShipping->status=='success' ) { ?>
							<div class="box-interno-envio px-1 d-flex col-12 justify-content-center">
                <?php
                //$sInstruccionesRecojoDelivery='';
                //$sInstruccionesRecojoTienda='';
                foreach ($arrShipping->result as $row) {
                  if ( $row->Nu_Valor == 6) {//delivery ?>
                  <label class="payment tipo_compra-invitado-envio-domi me-3 border border-radius rounded mb-0 py-4 col-md-4 col-lg-3 col-6 d-flex flex-column justify-content-center" for="invitadodelivery" style="cursor:pointer">
                    <input type="radio" class="d-none" name="radio-tipo_compra-invitado-tipo-recojo" id="invitadodelivery" data-name="<?php echo $row->No_Tipo_Envio; ?>" data-nu_valor="<?php echo $row->Nu_Valor; ?>" value="<?php echo $row->ID; ?>">
                    <i class="fas tipo_compra-invitado-ico-domi fa-truck h1 mx-auto"></i>
                    <h3 class="text-center h6 mt-2 tipo_compra-invitado-h3-tipo-recepcion-delivery"><?php echo $row->No_Tipo_Envio; ?></h3>
                  </label>
                  <?php
                    //$sInstruccionesRecojoDelivery=$row->Txt_Instrucciones_Recojo_Tienda_Lae_Shop;
                  }
                  if ( $row->Nu_Valor == 7) {//recojo en tienda ?>
                  <label class="payment tipo_compra-invitado-tienda-reco me-3 rounded border border-radius mb-0 py-4 col-md-4 col-lg-3 col-6 d-flex flex-column justify-content-center" for="invitadorecojo" style="cursor:pointer">
                    <input type="radio" class="d-none" name="radio-tipo_compra-invitado-tipo-recojo" id="invitadorecojo" data-name="<?php echo $row->No_Tipo_Envio; ?>" data-nu_valor="<?php echo $row->Nu_Valor; ?>" value="<?php echo $row->ID; ?>">
                    <i class="fas fa-store tipo_compra-invitado-ico-tienda h1 mx-auto"></i>
                    <h3 class="text-center h6 mt-2 tipo_compra-invitado-h3-tipo-recepcion-tienda"><?php echo $row->No_Tipo_Envio; ?></h3>
                  </label>
                  <?php
                    //$sInstruccionesRecojoTienda=$row->Txt_Instrucciones_Recojo_Tienda_Lae_Shop;
                  }
                } ?>
							</div>
						<?php } else { ?>
							<h4 class="h4-finalizar_compra-direccion_usuario-title"><?php echo $arrTiposEnvio->message; ?></h4>
						<?php } ?>
					</div>
				</div>

				<div class="dire_cb div-tipo_compra-invitado-finalizar_compra-recojo_tienda div-finalizar_compra-recojo_tienda d-none mt-0 mb-3" style="">
          <div class="card" style="border: none;">
            <div class="card-body shadow p-3 bg-body rounded">
              <h4 class="text-left mb-3 fw-bold">Recojo en tienda</h4>
              <?php if ( $arrWareHouse->status=='success' ) {
                $arrWareHouse = $arrWareHouse->result[0]; ?>
                <input type="hidden" id="hidden-global-moneda_signo-tipo_compra-invitado" value="<?php echo $arrWareHouse->No_Signo; ?>">
                <input type="hidden" id="hidden-id_almacen_retiro_tienda-tipo_compra-invitado" value="<?php echo $arrWareHouse->ID_Almacen; ?>">
                <span class="span-finalizar_compra-comprobante-texto"><strong>Dirección:</strong> <?php echo $arrWareHouse->Txt_Direccion_Almacen . ' - ' . $arrWareHouse->No_Departamento . ' - ' . $arrWareHouse->No_Provincia . ' - ' . $arrWareHouse->No_Distrito; ?></span>
                  <?php if(!empty($sInstruccionesRecojoTienda)){ ?>
                    <span class="span-finalizar_compra-comprobante-texto">
                      <div style="margin-top: .5rem !important;">
                        <strong>Instrucciones:</strong><br>
                        <?php echo nl2br($sInstruccionesRecojoTienda); ?>
                      </div>
                    </span>
                  <?php } ?>
              <?php } else { ?>
                <input type="hidden" id="hidden-global-moneda_signo-tipo_compra-invitado" value="S/">
                <input type="hidden" id="hidden-id_almacen_retiro_tienda-tipo_compra-invitado" value="0">
                <span class="span-finalizar_compra-comprobante-texto"><?php echo $arrWareHouse->message; ?></span>
              <?php } ?>
            </div>
          </div>
				</div>

        <div class="div-tipo_compra-invitado-finalizar_compra-direccion_usuario col-12 col-sm-12 col-md-12 d-none">
          <!--direccion-->
          <h2 class="text-left mb-3 fw-bold">Dirección</h2>
          <form>
            <div class="card" style="border: none;">
              <div class="card-body shadow p-3 bg-body rounded">
                <div class="row">
                  <div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-3">
                    <label class="fw-bold">Departamento <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <select name="cbo-departamento" id="cbo-departamento" class="form-select">
                        <option value="0" selected="selected">- Seleccionar -</option>
                        <?php foreach ($arrDepartamento['result'] as $row) { ?>
                          <option value="<?php echo $row->ID_Departamento; ?>"><?php echo $row->No_Departamento; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <span class="help-block text-danger" id="error"></span>
                  </div>
                  
                  <div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-3">
                    <label class="fw-bold">Provincia <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <select name="cbo-provincia" id="cbo-provincia" class="form-select">
                        <option value="0" selected="selected">- Seleccionar -</option>
                      </select>
                    </div>
                    <span class="help-block text-danger" id="error"></span>
                  </div>

                  <div class="col-12 col-sm-4 col-md-12 col-lg-4 mb-3">
                    <label class="fw-bold">Distrito <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <select name="cbo-distrito" id="cbo-distrito" class="form-select">
                        <option value="0" selected="selected">- Seleccionar -</option>
                      </select>
                    </div>
                    <span class="help-block text-danger" id="error"></span>
                  </div>

                  <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3 d-none">
                    <label class="fw-bold">Dirección <span class="label-advertencia text-danger"> *</span></label>
                    <div class="form-group">
                      <input type="text" id="payment-direccion" inputmode="text" name="address" class="form-control required" placeholder="Ingresar" maxlength="100" autocomplete="address">
                      <span class="help-block text-danger" id="error"></span>
                    </div>
                  </div>
                  
                  <div class="col-12 col-sm-12 col-md-12" id="div-delivery_extra_provincia">
                    <div class="alert alert-warning" role="alert">
                      Para los <strong>socios de provincia</strong> se enviará su carga por agencia <strong>Shalom o Marvisur</strong>. Flete de Almacén - Agencia desde <strong>S/20.00</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        
        <div class="col-12 col-sm-12 col-md-12">
          <!--direccion-->
          <h2 class="text-left mb-3 fw-bold">Medios de Pago</h2>
          
          <?php
          if($arrMedioPago['status']=='success') {
            foreach($arrMedioPago['result'] as $row){
              //array_debug($row);
            ?>
            
            <label id="label-medio_pago-<?php echo $row->ID_Medio_Pago; ?>" for="<?php echo $row->ID_Medio_Pago; ?>" data-id="<?php echo $row->ID_Medio_Pago; ?>" class="payment payment-medio_pago me-3 rounded border border-radius mb-0 py-4 col-12 d-flex flex-column justify-content-center" style="cursor:pointer">
              <input type="radio" class="d-none" name="radio-medio_pago" id="<?php echo $row->ID_Medio_Pago; ?>" data-id="<?php echo $row->ID_Medio_Pago; ?>" value="<?php echo $row->ID_Medio_Pago; ?>">
              <div class="d-flex p-3">
                <div class="flex-shrink-0 text-center" style="width:20%;display: flex;flex-direction: column;justify-content: center;">
                  <img style="height: auto;max-height: 60px;" class="img-medio_pago shadow-sm bg-body rounded" src="<?php echo $row->Txt_Url_Imagen . '?ver=1.0.0'; ?>">
                </div>
                <div class="mb-2 ps-3">
                  <h6 class="ps-2"><?php echo ($row->Nu_Tipo_Cuenta == 1 ? 'Cuenta Corriente Soles' : ''); ?></h6>
                  <div class="modal-cart_shop-div-precio_item ps-2">
                    <span class="fw-bold">
                      <span><?php echo $row->No_Titular_Cuenta; ?></span><br>
                      <span><?php echo $row->No_Cuenta_Bancaria; ?></span>
                    </span>
                  </div>
                </div>
              </div>
            </label>

            <!--
            <div class="card mb-3" style="border: none;">
              <div class="payment card-body shadow p-3 bg-body rounded pb-0 pt-0" data-id="<?php echo $row->ID_Medio_Pago; ?>">
                <div class="row">
                  <div class="col-12">
                    <div class="form-check ps-0" style="cursor: pointer;flex-wrap: wrap-reverse;display: flex;">
                      <label style="cursor: pointer;" class="payment-medio_pago col-12" for="<?php echo $row->ID_Medio_Pago; ?>" data-id="<?php echo $row->ID_Medio_Pago; ?>">
                        <div class="d-flex p-3">
                          <div class="flex-shrink-0 text-center" style="width:20%;display: flex;flex-direction: column;justify-content: center;">
                            <img style="height: auto;max-height: 60px;" class="img-medio_pago shadow-sm bg-body rounded" src="<?php echo $row->Txt_Url_Imagen . '?ver=1.0.0'; ?>">
                          </div>
                          <div class="mb-2 ps-3">
                            <h6 class="ps-2"><?php echo ($row->Nu_Tipo_Cuenta == 1 ? 'Cuenta Corriente Soles' : ''); ?></h6>
                            <div class="modal-cart_shop-div-precio_item ps-2">
                              <span class="fw-bold">
                                <span><?php echo $row->No_Titular_Cuenta; ?></span><br>
                                <span><?php echo $row->No_Cuenta_Bancaria; ?></span>
                              </span>
                            </div>
                          </div>
                        </div>
                      </label>

                      <input style="cursor: pointer;margin-bottom: 2.5rem !important;" class="form-check-input" type="radio" name="arrMedioPago" id="<?php echo $row->ID_Medio_Pago; ?>" data-id="<?php echo $row->ID_Medio_Pago; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            -->

            <?php
            }
          } else {

          }
          ?>
        </div>
        
      </div>
      
      <div class="col-12 col-sm-12 col-md-5 col-lg-4">
        <div class="col-12 col-sm-12 col-md-12 sticky-top">
          <h2 class="text-center mb-3 fw-bold">Resumen</h2>
            <div class="card" style="border: none;">
            <div class="card-body shadow p-3 bg-body rounded pt-0">
              <?php
              $fTotalCantidadPedido = 0;
              $fTotalImportePedido = 0;
              foreach($_SESSION['cart'] as $row){
                $fTotalCantidadPedido += $row['cantidad_item'];
                $fTotalImportePedido += $row['total_item'];
              ?>
              <div class="row div-line">
                <div class="col-12">
                  <div class="modal-cart_shop-div_item" id="delete_item_562260">
                    <a href="#" class="modal-cart_shop-img_item">
                      <img class="shadow-sm bg-body" src="<?php echo $row['url_imagen_item']; ?>">
                    </a>
                    <div class="modal-cart_shop-body_item">
                      <h6 class="ps-2"><?php echo $row['nombre_item']; ?></h6>
                      <div class="modal-cart_shop-div-precio_item ps-2">
                        <span class="fw-bold">
                          Cant: <span data-total_producto="80" id="total-por-producto_562260"><?php echo $row['cantidad_item']; ?></span>
                        </span>

                        <span class="fw-bold float-right">
                          S/ <span data-total_producto="80" id="total-por-producto_562260"><?php echo $row['total_item']; ?></span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="d-block d-sm-none">
                <br><br><br><br><br><br><br>
              </div>

              <div class="d-none d-sm-block">
                <div class="col-12 d-grid mt-3">
                  <div class="modal-cart_shop-div-precio_item pb-3">
                    <span class="fw-normal">
                      Total
                    </span>

                    <span class="fw-normal float-right">
                      <input type="hidden" id="hidden-cart_shop-cantidad_total" class="form-control" value="<?php echo $fTotalCantidadPedido; ?>">
                      <input type="hidden" id="hidden-cart_shop-importe_total" class="form-control" value="<?php echo $fTotalImportePedido; ?>">
                      S/ <span><?php echo $fTotalImportePedido; ?></span>
                    </span>
                  </div>
                </div>

                <div class="col-12 d-grid">
                  <div class="modal-cart_shop-div-precio_item pb-3">
                    <span class="fw-bold fs-6">
                      Separa con el (50%)
                    </span>

                    <span class="fw-bold float-right fs-5">
                      <input type="hidden" id="hidden-cart_shop-cantidad_total" class="form-control" value="<?php echo $fTotalCantidadPedido; ?>">
                      <input type="hidden" id="hidden-cart_shop-importe_total" class="form-control" value="<?php echo $fTotalImportePedido; ?>">
                      S/ <span><?php echo round(($fTotalImportePedido / 2), 2); ?></span>
                    </span>
                  </div>
                </div>
                
                <div class="col-12 d-grid">
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="check-terminos" style="cursor:pointer;">
                    <label class="form-check-label" for="check-terminos" style="font-size: .8rem;">
                      He leído y estoy de acuerdo con los <button type="button" style="text-decoration: none !important; font-size: .8rem;" data-bs-toggle="modal" data-bs-target="#modal-terminos" class="btn btn-link p-0 mb-1">términos y condiciones</button> de la web.
                    </label>
                  </div>
                </div>

                <div class="col-12 d-grid">
                  <button type="button" class="btn btn-success btn-lg btn-completar_pedido">Finalizar pedido</button>
                </div>
              </div>

              <div class="d-block d-sm-none totales-payment fixed-bottom bg-white shadow-new p-3 pt-0">
                <div class="col-12 d-grid mt-2">
                  <div class="modal-cart_shop-div-precio_item pb-2">
                    <span class="fw-normal">
                      Total
                    </span>

                    <span class="fw-normal float-right">
                      <input type="hidden" id="hidden-cart_shop-cantidad_total" class="form-control" value="<?php echo $fTotalCantidadPedido; ?>">
                      <input type="hidden" id="hidden-cart_shop-importe_total" class="form-control" value="<?php echo $fTotalImportePedido; ?>">
                      S/ <span><?php echo $fTotalImportePedido; ?></span>
                    </span>
                  </div>
                </div>

                <div class="col-12 d-grid">
                  <div class="modal-cart_shop-div-precio_item pb-2">
                    <span class="fw-bold fs-5">
                      Separa con el (50%)
                    </span>

                    <span class="fw-bold float-right fs-5">
                      <input type="hidden" id="hidden-cart_shop-cantidad_total" class="form-control" value="<?php echo $fTotalCantidadPedido; ?>">
                      <input type="hidden" id="hidden-cart_shop-importe_total" class="form-control" value="<?php echo $fTotalImportePedido; ?>">
                      S/ <span><?php echo round(($fTotalImportePedido / 2), 2); ?></span>
                    </span>
                  </div>
                </div>
                
                <div class="col-12 d-grid">
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="check-terminos2">
                    <label class="form-check-label" for="check-terminos2" style="font-size: .65rem;">
                      He leído y acepto los <button type="button" style="text-decoration: none !important; font-size: .65rem;margin-bottom: .2rem !important;" data-bs-toggle="modal" data-bs-target="#modal-terminos" class="btn btn-link p-0 mb-0">términos y condiciones</button> de la web.
                    </label>
                  </div>
                </div>

                <div class="col-12 d-grid">
                  <button type="button" class="btn btn-success btn-lg btn-completar_pedido">Finalizar pedido</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal-terminos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center fw-bold" id="exampleModalLabel">Términos y condiciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-sm-12">
              <p>
              - La importación llegará a nombre de Pro Business.<br><br>
              - Se notificará al cliente, los productos que no lleguen
              al pedido min. para modificar su pedido.<br><br>
              - Se le brindará una orden de compra para formalizar
              su pedido.<br><br>
              - Se creará un grupo privado con los participantes.
              - Informaremos el proceso de importación.<br><br>
              - El pago se realiza en soles.<br><br>
              - No se admiten reembolsos.<br><br>
              - La fecha de entrega es aprox., ya que se actualizará
              luego del zarpe de la carga.<br><br>
              - Es una importación y puede haber una merma del
              5%.<br><br>
              - El cliente podrá notificar fallas de fabrica en un
              plazo máximo de 4 días, después de la entrega.<br><br>
              - Los productos al por mayor son de alta rotación por
              ende no se puede ampliar el plazo de notificar.<br><br>
              - La entrega se realizará en nuestro almacén Jr. Alberto Barton N°527 - Santa Catalina - La Victoria.<br><br>
              - Se emitirá boleta o factura después de la entrega.<br><br>
              - Para los socios de provincia se enviará su carga por
              agencia Shalom o Marvisur. Flete de Almacén -
              Agencia desde S/20.00
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary col" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
