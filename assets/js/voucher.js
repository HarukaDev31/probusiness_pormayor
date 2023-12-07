$(document).ready(function () {
  //subir archivo
  $("#attachform").on('submit',function(e){
    e.preventDefault();
    
    $('#btn-file_voucher').prop('disabled', true);
    $('#btn-file_voucher').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando');

    var postData = new FormData($("#attachform")[0]);
    console.log(postData);
    $.ajax({
      url: base_url + 'Payment/enviarSegundoVoucherArchivo',
      type: "POST",
      dataType: "JSON",
      data: postData,
      processData: false,
      contentType: false
    })
    .done(function(response) {
      $('#btn-file_voucher').prop('disabled', false);
      $('#btn-file_voucher').html('Enviar voucher');

      console.log(response);
      if(response.status=='success'){
        //alert(response.message);
        window.open(response.link_whatsapp, "_blank");
      } else {
        alert(response.message);
      }
      //$('#myAttachModal').modal('hide');
    });
  });
})