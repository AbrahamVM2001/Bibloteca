<?php require('views/headervertical.view.php'); ?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <h3>Categoria altas, bajas, modificación</h3>
            <p>¡Bienvenido a esta sección! Te informamos que la información aquí presente es exclusiva para administradores.
                Si deseas dar de alta un idioma, haz clic en "Agregar".
                Si deseas modificar un idioma, simplemente haz doble clic en la tabla.
                Para eliminar un usuario, selecciona el botón rojo. ¡Gracias por tu labor administrativa!
            </p>
            <button title="Agregar nuveo usuario" class="btn btn-success btn-agregar-evento" data-bs-target="#modalEventos" data-bs-toggle="modal">Agregar <i
                class="fa-solid fa-circle-plus"></i></button>
            </div>
            <div class="card-body">
                <div class="row table-responsive" id="container-eventos"></div>
            </div>
        </div>
    </div>
    <?php require('views/footer.view.php'); ?>
    <script src="<?= constant('URL') ?>public/js/paginas/admin/home.categoria.js"></script>
    <div class="modal fade" id="modalEventos" aria-hidden="true" aria-labelledby="modalEventosLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEventosLabel">AGREGAR UN NUEVO CATEGORIA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-new-event" action="javascript:;" name="form-usuario" class="needs-validation" novalidate method="post">
                        <input type="hidden" name="id_categoria" id="id_categoria">
                        <div class="row">
                            <div class = "row">
                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                        <label for="nombre">Categoria <small class="text-danger">*</small></label>
                                        <input title="Ingresa la categoria." type="text" class="form-control" name="categoria" id="categoria" placeholder="Categoria de libros" required>
                                        <div class="invalid-feedback">
                                            Ingresa la categoria.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                        <label for="estatus">Estatus <small class="text-danger">*</small></label>
                                        <select title="Ingresa el estatus del usuario." class="form-select" aria-label="Default select example" name="estatus" id="estatus" required>
                                            <option value="0">Deshabilitado</option>
                                            <option value="1">Habilitado</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Ingresa el estatus del idioma.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button data-formulario="form-new-event" type="button" class="btn btn-primary btn-evento">Guardar</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>