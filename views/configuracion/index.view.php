<?php require('views/headervertical.view.php'); ?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <h3>Usuario altas, bajas, modificación</h3>
            <button title="Agregar nuveo usuario" class="btn btn-success btn-agregar-evento" data-bs-target="#modalEventos" data-bs-toggle="modal">Agregar <i
                class="fa-solid fa-circle-plus"></i></button>
            </div>
            <div class="card-body">
                <div class="row table-responsive" id="container-eventos"></div>
            </div>
        </div>
    </div>
    <?php require('views/footer.view.php'); ?>
    <script src="<?= constant('URL') ?>public/js/paginas/home.usuario.js"></script>
    <div class="modal fade" id="modalEventos" aria-hidden="true" aria-labelledby="modalEventosLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEventosLabel">AGREGAR UN NUEVO USUARIO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-new-event" action="javascript:;" name="form-usuario" class="needs-validation" novalidate method="post">
                        <input type="hidden" name="tipo" id="tipo" value="nuevo">
                        <input type="hidden" name="idUsuario" id="idUsuario">
                        <div class="row">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="nombre">Nombre <small class="text-danger">*</small></label>
                                    <input title="Ingresa tu nombre." type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre de usuario">
                                    <div class="invalid-feedback">
                                        Ingresa tu nombre por favor
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="APaterno">Apellido Paterno <small class="text-danger">*</small></label>
                                    <input title="Ingresa tu apellido paterno." type="text" class="form-control" name="APaterno" id="APaterno" placeholder="Apellido paterno" >
                                    <div class="invalid-feedback">
                                        Ingresa tu apellido paterno
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="AMaterno">Apellido Materno</label>
                                    <input title="Ingresa tu apellido materno si eres extrajero no es necesario que lo ingreses." type="text" class="form-control" name="AMaterno" id="AMaterno" placeholder="Apellido materno">
                                    <div class="invalid-feedback">
                                        Ingresa tu Apellido Materno
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="genero">Genero <small class="text-danger">*</small></label>
                                    <select title="Ingresa tu genero" class="form-select" aria-label="Default select example" name="genero" id="genero">
                                        <option>Sin genero</option>
                                        <option>Hombre</option>
                                        <option>Mujer</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Ingresa tu genero.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Correo <small class="text-danger">*</small></label>
                                    <input title="Ingresa tu correo electronico donde podrás recibir algunas cosas." type="email" class="form-control" name="email" id="email" placeholder="correo" >
                                    <div class="invalid-feedback">
                                        Ingresa tu correo electrnonico
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Contraseña <small class="text-danger">*</small></label>
                                    <input title="Ingresa tu contraseña" type="password" class="form-control" name="password" id="password" placeholder="password">
                                    <div class="invalid-feedback">
                                        Ingresaste una contraseña
                                    </div>
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
<!-- contenedor de actualizar -->
<div class="modal fade" id="modalUsuario" aria-hidden="true" aria-labelledby="modalUsuarioLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="form-usuario" name="form-usuario" action="javascript:;" class="needs-validation" novalidate
            method="post">
            <input type="hidden" name="idUsuario" id="idUsuario" readonly>
            <input type="hidden" name="formulario" id="formulario" value="usuario" readonly>
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUsuarioLabel">-</h1>
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