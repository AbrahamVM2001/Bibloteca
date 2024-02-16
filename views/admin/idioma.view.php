<?php require('views/headervertical.view.php'); ?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <h3>Idiomas altas, bajas, modificación</h3>
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
    <script src="<?= constant('URL') ?>public/js/paginas/admin/home.idioma.js"></script>
    <div class="modal fade" id="modalEventos" aria-hidden="true" aria-labelledby="modalEventosLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEventosLabel">AGREGAR UN NUEVO IDIOMA</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-new-event" action="javascript:;" name="form-usuario" class="needs-validation" novalidate method="post">
                        <input type="hidden" name="id_idioma" id="id_idioma">
                        <div class="row">
                            <div class = "row">
                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                        <label for="nombre">Idioma <small class="text-danger">*</small></label>
                                        <input title="Ingresa el idioma." type="text" class="form-control" name="idioma" id="idioma" placeholder="Idioma del libros">
                                        <div class="invalid-feedback">
                                            Ingresa tu idioma.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                        <label for="estatus">Estatus <small class="text-danger">*</small></label>
                                        <select title="Ingresa el estatus del usuario." class="form-select" aria-label="Default select example" name="estatus" id="estatus">
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
<!-- contenedor de actualizar -->
<div class="modal fade" id="modalUsuario" aria-hidden="true" aria-labelledby="modalIdiomaLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="form-idioma" name="form-idiomaa" action="javascript:;" class="needs-validation" novalidate
            method="post">
            <input type="hidden" name="idUsuario" id="id" readonly>
            <input type="hidden" name="formulario" id="formulario" value="usuario" readonly>
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalIdiomaLabel">-</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                            <label style="display:none;">Identificador del usuario<small class="text-danger">*</small></label>
                            <input class="form-control" type="hidden" name="ac_id_usuario" id="ac_id_usuario" required  readonly>
                            <div class="invalid-feedback">
                                Ingrese un nombre, por favor.
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Nombre <small class="text-danger">*</small></label>
                            <input title="Ingresa tu nombre." class="form-control" type="text" name="ac_nombre" id="ac_nombre" required>
                            <div class="invalid-feedback">
                                Ingrese un nombre, por favor.
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Apellido paterno <small class="text-danger">*</small></label>
                            <input title="Ingresa tu apellido paterno." type="text" class="form-control" name="ac_apellido_paterno" id="ac_apellido_paterno" required>
                            <div class="invalid-feedback">
                                Ingrese un apellido paterno, por favor.
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Apellido materno</label>
                            <input title="Ingresa tu apellido materno, si eres extrangero no estan necesario." type="text" class="form-control" name="ac_apellido_materno" id="ac_apellido_materno">
                            <div class="invalid-feedback">
                                Ingrese un apellido materno, por favor.
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Correo <small class="text-danger">*</small></label>
                            <input title="Ingresa el nuevo correo." type="email" class="form-control" name="ac_correo" id="ac_correo" required>
                            <div class="invalid-feedback">
                                Ingrese el nuevo correo, por favor.
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Contraseña <small class="text-danger">*</small></label>
                            <input title="Ingresa la nueva contraseña." type="text" class="form-control" name="ac_password" id="ac_password" required>
                            <div class="invalid-feedback">
                                Ingrese un Estado, por favor.
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Tipo de usuario <small class="text-danger">*</small></label>
                            <select title="Ingresa el nuevo rol de usuario." class="form-select" aria-label="Default select example" name="ac_tipo_usuario" id="ac_tipo_usuario">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Genero <small class="text-danger">*</small></label>
                            <select title="Ingresa el nuevo genero." class="form-select" aria-label="Default select example" name="ac_genero" id="ac_genero">
                                <option>Sin genero</option>
                                <option>Hombre</option>
                                <option>Mujer</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="">Estatus <small class="text-danger">*</small></label>
                            <select title="Ingresa el nuevo estatus." class="form-select" aria-label="Default select example" name="ac_estatus" id="ac_estatus">
                                <option>0</option>
                                <option>1</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button data-formulario="form-profesores" data-tipo="nuevo" type="button"
                    class="btn btn-success btn-actualizar-usuario">Actualizar</button>
            </div>
            </div>
        </form>
    </div>
</div>