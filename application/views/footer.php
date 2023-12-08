    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b7119ee4cd.js" crossorigin="anonymous"></script>

    <script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>

    <!--interno-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

    <?php if (!isset($js_voucher)) { ?>
      <script src="<?php echo base_url("assets/js/inicio.js?ver=73.0.0"); ?>"></script>
      <script type="text/javascript" src="<?php echo base_url("assets/slick/slick.min.js?ver=14.0.14"); ?>"></script>
    <?php } ?>

    <?php if (isset($js_voucher)) { ?>
      <script src="<?php echo base_url("assets/js/voucher.js?ver=43.0.0"); ?>"></script>
    <?php } ?>
  </body>
</html>
