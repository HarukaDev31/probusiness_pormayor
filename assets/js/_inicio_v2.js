var signo_moneda='S/';
$(document).ready(function () {
  $('#div-footer-cart').hide();
  
  signo_moneda = $('#hidden-global-signo_moneda').val();

  $(document).on('click', '.btn-agregar_item', function() {
    const type_action = 'add';
    const id_item = $( this ).data('id_item');
    const id_unidad_medida = $( this ).data('id_unidad_medida');
    const id_unidad_medida_2 = $( this ).data('id_unidad_medida_2');
    const nombre_item = $( this ).data('nombre_item');
    const url_imagen_item = $( this ).data('url_imagen_item');
    const cantidad_item = parseFloat($( this ).data('cantidad_item'));
    const precio_item = parseFloat($( this ).data('precio_item'));
    const total_item = (cantidad_item * precio_item);
    
    var arrParams = {
      type_action : type_action,
      id_item : id_item,
      id_unidad_medida : id_unidad_medida,
      id_unidad_medida_2 : id_unidad_medida_2,
      url_imagen_item : url_imagen_item,
      nombre_item : nombre_item,
      cantidad_item : cantidad_item,
      precio_item : precio_item,
      total_item : total_item
    };
    requestAddCart(arrParams);
  });
  
  $(document).on('click', '.btn-quitar_item', function() {
    const type_action = 'remove';
    const id_item = $(this).attr('data-id_item');
    const id_unidad_medida = $( this ).data('id_unidad_medida');
    const id_unidad_medida_2 = $( this ).data('id_unidad_medida_2');
    const nombre_item = $( this ).data('nombre_item');
    const url_imagen_item = $( this ).data('url_imagen_item');
    const cantidad_item = parseFloat($( this ).data('cantidad_item'));
    const precio_item = parseFloat($( this ).data('precio_item'));
    const total_item = (cantidad_item * precio_item);

    var arrParams = {
      type_action : type_action,
      id_item : id_item,
      id_unidad_medida : id_unidad_medida,
      id_unidad_medida_2 : id_unidad_medida_2,
      url_imagen_item : url_imagen_item,
      nombre_item : nombre_item,
      cantidad_item : cantidad_item,
      precio_item : precio_item,
      total_item : total_item
    };
    requestRemoveCart(arrParams);
    
  });

  $(document).on('click', '#btn-ver-cart_shop', function() {
    modalCartShop();
  });
  
  $(document).on('click', '#icon-ver-cart_shop', function() {
    modalCartShop();
  });
  
  $(document).on('click', '#btn-completar_pedido', function() {
    var arrParams = {
      'cantidad_total' : $( '#hidden-cart_shop-cantidad_total' ).val(),
      'importe_total' : $( '#hidden-cart_shop-importe_total' ).val(),
      'Nu_Documento_Identidad' : $( '[name="Nu_Documento_Identidad"]' ).val(),
      'No_Entidad' : $( '[name="No_Entidad"]' ).val(),
      'Nu_Celular_Entidad' : $( '[name="Nu_Celular_Entidad"]' ).val(),
      'Txt_Email_Entidad' : $( '[name="Txt_Email_Entidad"]' ).val(),
      'Txt_Direccion' : $( '[name="Txt_Direccion"]' ).val(),
    };
    addPedido(arrParams);
  })
});

function requestAddCart(arrParams) {
  console.log(arrParams);

  $.post(base_url + 'Inicio/agregarItem', {arrParams}, function(response) {
    console.log(response);
    if( response.status == 'success' ){
      const sCaracterPalabra = (response.count > 1 ? 's' : '');
      
      $('#span-cart-global_cantidad').html(response.count);
      $('#div-cart_items').html(response.count + ' producto' + sCaracterPalabra);
      $('#div-cart_total').html(signo_moneda + ' ' + response.total_item);

      $('#div-footer-cart').show();
    } else {
      alert(response.message);
    }
  },'json');
}

function requestRemoveCart(arrParams) {
  console.log(arrParams);

  const id_item_temporal = arrParams.id_item;

  $.post(base_url + 'Inicio/quitarItem', {arrParams}, function(response) {
    console.log('item temporal : ' + id_item_temporal);
    console.log(response);
    if( response.status == 'success' ){
      $('#modal-cart_shop-id_item' + id_item_temporal).remove();

      const sCaracterPalabra = (response.count > 1 ? 's' : '');
      
      $('#span-cart-global_cantidad').html(response.count);
      $('#div-cart_items').html(response.count + ' producto' + sCaracterPalabra);
      $('#div-cart_total').html(signo_moneda + ' ' + response.total_item);

      $('#div-footer-cart').show();
    } else {
      alert(response.message);
    }
  },'json');
}

function modalCartShop(){
  var sHmtlModalCartShopSinItem = '';
  $.ajax({
    url: base_url + 'Inicio/modalCartShop',
    type: "POST",
    dataType: 'json',
    data: {},
    success: function (response) {
      console.log(response);
      if(response.status=='success'){
        $('.modal-cart_shop-footer').removeClass('d-none');
        $('#modal-cart-items').html('');
        for(i in response.result){
          var row = response.result[i];
          console.log(row);

          sHmtlModalCartShopSinItem += '<div class="row div-line pb-2" id="modal-cart_shop-id_item' + row.id_item + '">';
            sHmtlModalCartShopSinItem += '<div class="col-12">';
              sHmtlModalCartShopSinItem += '<div class="modal-cart_shop-div_item" id="">';
                sHmtlModalCartShopSinItem += '<a href="#" class="modal-cart_shop-img_item">';
                  sHmtlModalCartShopSinItem += '<img src="' + row.url_imagen_item + '">';
                sHmtlModalCartShopSinItem += '</a>';
                sHmtlModalCartShopSinItem += '<div class="modal-cart_shop-body_item ps-3">';
                  sHmtlModalCartShopSinItem += '<h3 class="modal-cart_shop-title_item text-secondary">' + row.nombre_item + '</h3>';
                  sHmtlModalCartShopSinItem += '<div class="modal-cart_shop-div-precio_item">';
                    sHmtlModalCartShopSinItem += '<span class="fw-bold">';
                    sHmtlModalCartShopSinItem += signo_moneda + ' <span data-total_item="" data-id_item="">' + row.total_item + '</span>';
                    sHmtlModalCartShopSinItem += '</span>';
                  sHmtlModalCartShopSinItem += '</div>';
                  
                  sHmtlModalCartShopSinItem += '<div class="row">';
                    sHmtlModalCartShopSinItem += '<div class="col-6">';
                      sHmtlModalCartShopSinItem += '<div class="modal-cart_shop-cantidad_item" style="float: left;">';
                        sHmtlModalCartShopSinItem += '<p class="fs-6 mt-1 mb-1">Cant: ' + row.cantidad_item +  '</p>';
                      sHmtlModalCartShopSinItem += '</div>';
                    sHmtlModalCartShopSinItem += '</div>';

                    sHmtlModalCartShopSinItem += '<div class="col-6">';
                      sHmtlModalCartShopSinItem += '<div class="modal-cart_shop-div-eliminar_item">';
                        sHmtlModalCartShopSinItem += '<button class="btn btn-default text-danger btn-quitar_item" data-id_unidad_medida_2="' + row.id_unidad_medida_2 + '" data-id_unidad_medida="' + row.id_unidad_medida + '" data-id_item="' + row.id_item + '" data-cantidad_item="' + row.cantidad_item + '" data-precio_item="' + row.precio_item + '" data-nombre_item="' + row.nombre_item + '" data-url_imagen_item="' + row.url_imagen_item + '">';
                        sHmtlModalCartShopSinItem += '<i aria-hidden="true" class="fas fa-trash-alt text-danger"></i> Eliminar';
                        sHmtlModalCartShopSinItem += '</button>';
                      sHmtlModalCartShopSinItem += '</div>';
                    sHmtlModalCartShopSinItem += '</div>';
                sHmtlModalCartShopSinItem += '</div>';
                sHmtlModalCartShopSinItem += '</div>';
              sHmtlModalCartShopSinItem += '</div>';

              /*
              sHmtlModalCartShopSinItem += '<div class="row">';
                sHmtlModalCartShopSinItem += '<div class="col-6">';
                  sHmtlModalCartShopSinItem += '<div class="modal-cart_shop-div-eliminar_item">';
                    sHmtlModalCartShopSinItem += '<button class="btn btn-default text-danger btn-quitar_item" data-id_item="' + row.id_item + '" data-cantidad_item="' + row.cantidad_item + '" data-precio_item="' + row.precio_item + '" data-nombre_item="' + row.nombre_item + '" data-url_imagen_item="' + row.url_imagen_item + '">';
                    sHmtlModalCartShopSinItem += '<i aria-hidden="true" class="fas fa-trash-alt text-danger"></i> Eliminar';
                    sHmtlModalCartShopSinItem += '</button>';
                  sHmtlModalCartShopSinItem += '</div>';
                sHmtlModalCartShopSinItem += '</div>';
                
                sHmtlModalCartShopSinItem += '<div class="col-6">';
                  sHmtlModalCartShopSinItem += '<div class="modal-cart_shop-cantidad_item text-right">';
                    sHmtlModalCartShopSinItem += '<button class="btn btn-primary btn-sm" data-id_item="' + row.id_item + '" data-cantidad_item="' + row.cantidad_item + '" data-precio_item="' + row.precio_item + '" data-nombre_item="' + row.nombre_item + '" data-url_imagen_item="' + row.url_imagen_item + '"><i class="fa-solid fa-minus"></i></button>';
                    sHmtlModalCartShopSinItem += '&nbsp;<p class="fs-5 text px-1 mt-1 mb-1">' + row.cantidad_item +  '</p>&nbsp;';
                    sHmtlModalCartShopSinItem += '<button class="btn btn-primary btn-sm" data-id_item="' + row.id_item + '" data-cantidad_item="' + row.cantidad_item + '" data-precio_item="' + row.precio_item + '" data-nombre_item="' + row.nombre_item + '" data-url_imagen_item="' + row.url_imagen_item + '"><i class="fa-solid fa-plus"></i></button>';
                  sHmtlModalCartShopSinItem += '</div>';
                sHmtlModalCartShopSinItem += '</div>';
              sHmtlModalCartShopSinItem += '</div>';
              */
            sHmtlModalCartShopSinItem += '</div>';
          sHmtlModalCartShopSinItem += '</div>';
        }

        $('#modal-cart-items').html(sHmtlModalCartShopSinItem);
      } else {
        $('.modal-cart_shop-footer').addClass('d-none');

        sHmtlModalCartShopSinItem += '<div class="container py-5 px-5 text-center">';
        sHmtlModalCartShopSinItem += '<i class="mb-3 fa-solid fa-cart-shopping fa-3x"></i><br>';
        sHmtlModalCartShopSinItem += '<span class="mb-3">Tu carrito de compras está vacío</span><br>';
        sHmtlModalCartShopSinItem += '<a type="button" href="<?php echo base_url(); ?>" rel="noopener noreferrer" class="mt-3 btn btn-secondary">Comenzar a comprar</a>';
        sHmtlModalCartShopSinItem += '</div>';
      
        $('#modal-cart-items').html(sHmtlModalCartShopSinItem);

        console.log(response.message);
      }
    }
  })
}

function addPedido(arrParams){
  $( '#btn-completar_pedido' ).text('');
  $( '#btn-completar_pedido' ).attr('disabled', true);
  $( '#btn-completar_pedido' ).append( 'Guardando <i class="fa fa-refresh fa-spin fa-lg fa-fw"></i>' );

  console.log(arrParams);
  $.ajax({
    url: base_url + 'Payment/addPedido',
    type: "POST",
    dataType: 'json',
    data: {
      arrParams
    },
    success: function (response) {
      console.log(response);

      if( response.status == 'success' ){
        alert(response.message);
        
        setTimeout(function () {
          window.location = base_url + "Payment/thank";
        }, 1200);
      } else {

      }

      $( '#btn-completar_pedido' ).text('');
      $( '#btn-completar_pedido' ).append( 'Completar pedido' );
      $( '#btn-completar_pedido' ).attr('disabled', false);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert('Problemas al registrar. Intentar más tarde.')
      
      //Message for developer
      console.log(jqXHR.responseText);
      
      $( '#btn-completar_pedido' ).text('');
      $( '#btn-completar_pedido' ).append( 'Completar pedido' );
      $( '#btn-completar_pedido' ).attr('disabled', false);
    }
  });
}