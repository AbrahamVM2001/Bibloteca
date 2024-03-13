<?php require('views/estilos.view.php');?>
  <body class="body-error">
    <div class="text">
      <div>ERROR</div>
        <h1 style="color:#fff;">404</h1>
        <hr>
        <div>
          Ups, te haz perdido lo siento
          regresa por donde vienes<br>
          <button class="btn btn-info btn-block" type="button" onclick="window.history.back();">Regresar</button>
        </div>
      </div>
    <div class="astronaut">
      <img src="public/img/astronauta.png" alt="" class="src">
    </div>
  <script src="public/js/paginas/error.js">
  </script>
</body>
<?php require "views/footer.view.php";?>