<main>
<br>
<!--
<br><br>
-->
<?php

//array_debug($arrResponsePedido);
//array_debug($arrCabecera);
//array_debug($arrDetalle);
//array_debug($arrMedioPago);
//echo base_url();

//$phone = "51" . $arrCabecera['cliente']['Nu_Celular_Entidad'];
$codigo_pais="51";
$numero_celular="932531441";
$phone = $codigo_pais . $numero_celular;

//Preparar array para envío de data de pedido para la aplicación
$message = "*¡Hola ProBusiness*! 😁";
$message .= "\n🚢 Acabo de realizar el siguiente pedido.";

$message .= "\n\n👤 *CONTACTO*\n";
$message .= "=============";
$message .= "\n*Cliente:* " . $arrCabecera['cliente']['No_Entidad'];
$message .= "\n*" . $arrCabecera['documento']['tipo_documento_identidad'] . "*: " . $arrCabecera['cliente']['Nu_Documento_Identidad'];

$message .= "\n*Nro. Pedido:* " . $arrCabecera['documento']['id_pedido'];
$message .= "\n*Fecha:* " . ToDateHourBD($arrCabecera['documento']['fecha_registro']);

//Detalle de pedido
$message .= "\n\n🛍️ *DETALLE DE PEDIDO*\n";
$message .= "====================\n";
foreach($arrDetalle as $row) {
  $row = (array)$row;
  $message .= "✅ " . round($row['cantidad_item'], 2) . " x *" . $row['nombre_item'] . "* - S/ " . number_format($row['total_item'], 2, '.', ',') . "\n";
}

//Totales
$message .= "\n*💁🏻‍♀️ Separa con (50%): " . $arrCabecera['documento']['signo_moneda'] . " " . number_format($arrCabecera['documento']['importe_total'] / 2, 2, '.', ',') . "*";
$message .= "\n💰 Total: " . $arrCabecera['documento']['signo_moneda'] . " " . number_format($arrCabecera['documento']['importe_total'], 2, '.', ',');

//🛵 Tipo de envío: Delivery a Agencia
//📍Ubigeo: Áncash - Huaraz - Huaraz
if( $arrCabecera['documento']['tipo_envio'] == '6' ){
  $message .= "\n\n🛵 Tipo de envío: " . $arrCabecera['documento']['nombre_tipo_envio'];
  $message .= "\n📍 Ubigeo: " . $arrCabecera['documento']['departamento_cliente'] . " - " . $arrCabecera['documento']['provincia_cliente'] . " - " . strtoupper($arrCabecera['documento']['distrito_cliente']);
} else if( $arrCabecera['documento']['tipo_envio'] == '7' ){
  $message .= "\n\n🛎️ Tipo de envío: " . $arrCabecera['documento']['nombre_tipo_envio'];
  $message .= "\n📍 Dirección: CAL. ALBERTO BARTON NRO 527 URB. SANTA CATALINA - LIMA - LIMA - La Victoria ";
}

//enviar cuentas bancarias
//array_debug($arrMedioPago);
//Cuentas bancarias
if($arrMedioPago['status']=='success') {
  $message .= "\n\n 🏦 *FORMA DE PAGO*\n";
  $message .= "==================\n";
  foreach($arrMedioPago['result'] as $row) {
    $sTipoCuenta = '';
    if( $arrCabecera['documento']['id_medio_pago'] == $row->ID_Medio_Pago ) {
      if ($row->Nu_Tipo_Cuenta==1){
        $sTipoCuenta = ' Cuenta Corriente';
      }
      $message .= "☑️ *Banco: " . $row->No_Medio_Pago_Tienda_Virtual . $sTipoCuenta . '*';
      //$message .= "\n*Moneda:* " . $row->No_Moneda;
      $message .= "\n*Titular:* " . $row->No_Titular_Cuenta;
      $message .= "\n*Número de cuenta:* " . $row->No_Cuenta_Bancaria;
    }
  }
}

$message = urlencode($message);

$sURLSendMessageWhatsapp = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . $message;
?>

  <div class="container mt-5">
    <h2 class="text-center mb-4 pt-3 text-success"><i class="fa-solid fa-circle-check fa-3x text-green"></i></h2>
    <h2 class="text-center mb-4">Nro. Pedido <?php echo $arrCabecera['documento']['id_pedido']; ?> creado</h2>

    <h3 class="text-center mb-4 fw-bold">Separa con (50%) S/ <?php echo round(($arrCabecera['documento']['importe_total'] / 2), 2); ?></h3>

    <div class="row">
      <?php
      if($arrMedioPago['status']=='success') { ?>
        <div class="col-12">
          <h2 class="text-left mb-4 fw-bold">Cuentas Bancarias</h2>
                <div class="row">
          <?php foreach($arrMedioPago['result'] as $row){ ?>
            <div class="card mb-3 col-4 bg-transparent" style="border: none;">
              <div class="card-body shadow-sm p-3 bg-body rounded pb-0 pt-0">
                    <div class="modal-cart_shop-div_item">
                      <div class="modal-cart_shop-img_item">
                        <img style="height: auto;   max-height: 60px;" class="img-medio_pago shadow-sm bg-body rounded" src="<?php echo $row->Txt_Url_Imagen . '?ver=1.0.0'; ?>">
                      </div>
                      <div class="modal-cart_shop-body_item ps-3">
                        <h6 class="ps-2"><?php echo ($row->Nu_Tipo_Cuenta == 1 ? 'Cuenta Corriente Soles' : ''); ?></h6>
                        <div class="modal-cart_shop-div-precio_item ps-2">
                          <span class="fw-bold">
                            <span><?php echo $row->No_Titular_Cuenta; ?></span><br>
                            <span><?php echo $row->No_Cuenta_Bancaria; ?></span>
                          </span>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
          <?php } //for each medio de pago ?>
            </div>
        </div>
      <?php
      }//if each medio de pago
      ?>
    </div>

    <form class="form row g-3" role="form" id="attachform" enctype="multipart/form-data">
      <input type="hidden" class="form-control" id="id_pedido" name="id_pedido" value="<?php echo $arrCabecera['documento']['id_pedido']; ?>">
      <div class="col-12 col-sm-8" style="cursor: pointer">
        <div class="input-group custom-file-voucher">
          <label class="input-group-text" for="voucher">Subir archivo</label>
          <input class="form-control form-control-lg" id="voucher" type="file" name="voucher" placeholder="sin archivo" accept="image/*">
        </div>
      </div>
      <div class="col-12 col-sm-4">
        <button type="submit" id="btn-file_voucher" class="btn btn-success btn-lg btn-block shadow-sm" style="width:100%">Enviar</button>
      </div>
    </form>
    
    <a class="btn btn-outline-success btn-lg btn-block mb-4 shadow-sm" style="width:100%" href="<?php echo $sURLSendMessageWhatsapp; ?>" target="_blank" rel="noopener noreferrer">Pedir por WhatsApp</a>

    <div class="row">
      <?php
      if($arrMedioPago['status']=='success') { ?>
        <div class="col-12 col-sm-6 col-md-6">
          <h2 class="text-left mb-4 fw-bold">Cuentas Bancarias</h2>
          <?php foreach($arrMedioPago['result'] as $row){ ?>
            <div class="card mb-3" style="border: none;">
              <div class="card-body shadow-sm p-3 bg-body rounded pb-0 pt-0">
                <div class="row">
                  <div class="col-12">
                    <div class="modal-cart_shop-div_item">
                      <div class="modal-cart_shop-img_item">
                        <img style="height: auto;   max-height: 60px;" class="img-medio_pago shadow-sm bg-body rounded" src="<?php echo $row->Txt_Url_Imagen . '?ver=1.0.0'; ?>">
                      </div>
                      <div class="modal-cart_shop-body_item ps-3">
                        <h6 class="ps-2"><?php echo ($row->Nu_Tipo_Cuenta == 1 ? 'Cuenta Corriente Soles' : ''); ?></h6>
                        <div class="modal-cart_shop-div-precio_item ps-2">
                          <span class="fw-bold">
                            <span><?php echo $row->No_Titular_Cuenta; ?></span><br>
                            <span><?php echo $row->No_Cuenta_Bancaria; ?></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } //for each medio de pago ?>
        </div>
      <?php
      }//if each medio de pago
      ?>
      
      <div class="col-12 col-sm-6 col-md-6 mt-3 mt-sm-0">
        <h2 class="text-left mb-4 fw-bold">Resumen</h2>
          <div class="card" style="border: none;background: transparent !important;">
          <div class="card-body shadow-sm p-3 bg-body rounded pt-0 mb-3">
            <?php //aqui borrar session carrito ?>
            <?php
            $fTotalCantidadPedido = 0;
            $fTotalImportePedido = 0;
            foreach($arrDetalle as $row){
              //array_debug($row);
              $row = (array)$row;
              $fTotalCantidadPedido = $row['cantidad_item'];
              $fTotalImportePedido = $row['total_item'];
            ?>
            <div class="row div-line">
              <div class="col-12">
                <div class="modal-cart_shop-div_item">
                  <a href="#" class="modal-cart_shop-img_item">
                    <img class="shadow-sm bg-body" src="<?php echo $row['url_imagen_item']; ?>">
                  </a>
                  <div class="modal-cart_shop-body_item ps-2">
                    <h6 class="ps-2 fw-semibold ps-2"><?php echo $row['nombre_item']; ?></h6>
                    <div class="modal-cart_shop-div-precio_item ps-2 mb-1">
                      <span class="fw-semibold">
                        S/ <span ><?php echo number_format($row['total_item'], 2, '.', ','); ?></span>
                      </span>
                    </div>
                    <div class="modal-cart_shop-div-precio_item ps-2">
                      <span class="fw-semibold">
                        Cant: <span><?php echo round($row['cantidad_item'], 2); ?></span>
                      </span>

                      <span class="fw-semibold float-right">
                        S/ <span><?php echo number_format($row['precio_item'], 2, '.', ','); ?></span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            
            <div class="col-12 d-grid mt-3">
              <div class="modal-cart_shop-div-precio_item pb-3">
                <span class="fw-bold fs-5">
                  Total
                </span>

                <span class="fw-bold float-right fs-5">
                  S/ <span><?php echo number_format($arrCabecera['documento']['importe_total'], 2, '.', ','); ?></span>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  /*
  setTimeout(function () {
    window.open("<?php echo $sURLSendMessageWhatsapp; ?>", "_blank");
    //window.location = '<?php echo $sURLSendMessageWhatsapp; ?>';
  }, 2100);
  */
</script>
