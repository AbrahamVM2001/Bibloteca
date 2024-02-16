<?php require('views/headervertical.view.php'); ?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <div class="card-body">
                <div class="row table-responsive" id="container-info"></div>
            </div>
        </div>
        <h3><center>Comentarios</center></h3>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div id="detalleseleccion" name="detalleseleccion" class="este">
                    <div class="card-body">
                        <div class="row table-responsive" id="container-eventos"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <form id="form-new-event" action="javascript:;" name="form-usuario" class="needs-validation" novalidate method="post">
                    <input type="hidden" name="id_libro" id="id_libro" value="<?=$this->evento;?>">
                    <input type="hidden" name="tipo" id="tipo">
                    <input type="hidden" name="id_comentario" id="id_comentario">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo isset($_SESSION['id_usuario-' . constant('Sistema')]) ? $_SESSION['id_usuario-' . constant('Sistema')] : ''; ?>">
                    <p>Ingresa que opinas del Libro</p>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                            <div class="rating">
                                <input id="radio1" type="radio" name="estrellas" value="5" onclick="updatePuntaje(5)">
                                <label for="radio1">★</label>
                                <input id="radio2" type="radio" name="estrellas" value="4" onclick="updatePuntaje(4)">
                                <label for="radio2">★</label>
                                <input id="radio3" type="radio" name="estrellas" value="3" onclick="updatePuntaje(3)">
                                <label for="radio3">★</label>
                                <input id="radio4" type="radio" name="estrellas" value="2" onclick="updatePuntaje(2)">
                                <label for="radio4">★</label>
                                <input id="radio5" type="radio" name="estrellas" value="1" onclick="updatePuntaje(1)">
                                <label for="radio5">★</label>
                            </div>
                            <br><br>
                            <label for="Comentario">Comentario </label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Ingresa tu comentario.
                            </div>
                            
                            <button data-formulario="form-new-event" type="button" class="btn btn-primary btn-Comenario">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require('views/footer.view.php'); ?>
    <script>
        let id_libro = '<?=$this->evento;?>';
    </script>
    <script src="<?= constant('URL') ?>public\js\paginas\user\home.viewLibro.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
</div>