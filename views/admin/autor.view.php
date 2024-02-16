<?php require('views/headervertical.view.php'); ?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <h3>Autor altas, bajas, modificación</h3>
            <p>¡Bienvenido a esta sección! Te informamos que la información aquí presente es exclusiva para administradores.
                Si deseas dar de alta de un autor, haz clic en "Agregar".
                Si deseas modificar un autor, simplemente haz doble clic en la tabla.
                Para eliminar un autor, selecciona el botón rojo. ¡Gracias por tu labor administrativa!
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
    <script src="<?= constant('URL') ?>public/js/paginas/admin/home.autor.js"></script>
    <div class="modal fade" id="modalEventos" aria-hidden="true" aria-labelledby="modalEventosLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEventosLabel">AGREGAR UN NUEVO AUTOR</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-new-event" action="javascript:;" name="form-usuario" class="needs-validation" novalidate method="post">
                        <input type="hidden" name="id_autor" id="id_autor">
                        <div class="row">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="nombre">Nombre del autor <small class="text-danger">*</small></label>
                                    <input title="Ingresa el nombre del autor." type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
                                    <div class="invalid-feedback">
                                        Ingresa tu nombre por favor
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="APaterno">Apellido Paterno del autor <small class="text-danger">*</small></label>
                                    <input title="Ingresa tu apellido paterno del autor." type="text" class="form-control" name="APaterno" id="APaterno" placeholder="Apellido paterno" required>
                                    <div class="invalid-feedback">
                                        Ingresa tu apellido paterno
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="AMaterno">Apellido Materno</label>
                                    <input title="Ingresa tu apellido materno si es extrajero no es necesario que lo ingreses." type="text" class="form-control" name="AMaterno" id="AMaterno" placeholder="Apellido materno">
                                    <div class="invalid-feedback">
                                        Ingresa tu Apellido Materno
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="AMaterno">Resumen Biblografia a 150 caracteres</label>
                                    <textarea class="form-control" id="biblografia" name="biblografia" rows="3" required></textarea>
                                    <div class="invalid-feedback">
                                        Ingresa el resumen de la biblografia del autor.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <label for="AMaterno">Foto del autor.</label>
                                    <input type="file" class="form-control-file" id="foto" name = "foto">
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    <label for="">Estatus <small class="text-danger">*</small></label>
                                    <select title="Ingresa el nuevo estatus." class="form-select" aria-label="Default select example" name="estatus" id="estatus" required>
                                        <option value="0">Deshabilitado</option>
                                        <option value="1">habilitado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button data-formulario="form-new-event" type="button" class="btn btn-primary btn-evento">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>