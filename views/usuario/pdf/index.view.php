<?php require('views/headervertical.view.php'); ?>
<style>
    .btn-burbujas-bubble {
        color: #fff;
        background-color: #001F3F;
        background-repeat: no-repeat;
    }
    .btn-burbujas-bubble:hover, .btn-burbujas-bubble:focus {
        -webkit-animation: bubbles 1s forwards ease-out;
        animation: bubbles 1s forwards ease-out;
        background: radial-gradient(circle at center, rgba(0, 31, 63, 1) 30%, #6E0B6E 60%, #eeeeff 65%, rgba(0, 31, 63, 1) 70%) 98% 138% / 0.77em 0.77em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #6E0B6E 60%, #6E0B6E 65%, rgba(0, 0, 0, 0) 70%) 76% 130% / 0.86em 0.86em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #6E0B6E 60%, #6E0B6E 65%, rgba(0, 0, 0, 0) 70%) 19% 142% / 0.54em 0.54em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #6E0B6E 60%, #6E0B6E 65%, rgba(0, 0, 0, 0) 70%) 52% 102% / 0.88em 0.88em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #6E0B6E 60%, #6E0B6E 65%, rgba(0, 0, 0, 0) 70%) 93% 128% / 0.54em 0.54em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #eeeeff 60%, #eeeeff 65%, rgba(0, 0, 0, 0) 70%) 75% 86% / 0.92em 0.92em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #eeeeff 60%, #eeeeff 65%, rgba(0, 0, 0, 0) 70%) 16% 104% / 0.95em 0.95em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #eeeeff 60%, #eeeeff 65%, rgba(0, 0, 0, 0) 70%) 93% 116% / 1.15em 1.15em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #eeeeff 60%, #eeeeff 65%, rgba(0, 0, 0, 0) 70%) 54% 149% / 0.68em 0.68em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #eeeeff 60%, #eeeeff 65%, rgba(0, 0, 0, 0) 70%) -10% 124% / 0.56em 0.56em, radial-gradient(circle at center, rgba(0, 0, 0, 0) 30%, #eeeeff 60%, #eeeeff 65%, rgba(0, 0, 0, 0) 70%) 80% 142% / 0.72em 0.72em;
        background-color: #6E0B6E;
        color: #fff;
        background-repeat: no-repeat;
    }

    @-webkit-keyframes bubbles {
        100% {
            background-position: 106% -51%, 67% 55%, 16% -70%, 53% 3%, 94% -14%, 74% -8%, 10% -391%, 88% -132%, 59% -106%, -9% 20%, 87% -106%;
            box-shadow: inset 0 -6.5em 0 #fff;
            color: #6E0B6E;
        }
    }

    @keyframes bubbles {
        100% {
            background-position: 106% -51%, 67% 55%, 16% -70%, 53% 3%, 94% -14%, 74% -8%, 10% -391%, 88% -132%, 59% -106%, -9% 20%, 87% -106%;
            box-shadow: inset 0 -6.5em 0 #7305f1;
            color: #fff;
        }
    }

    .btn-burbujas {
        color: #fff;
        font-size: 12px;
        display: inline-block;
        text-decoration: none;
        border-radius: 5px;
        padding: 0.5em 1em;
        width: 85px;
        height: 35px;
    }
</style>
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