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
            <button title="Agregar nuveo usuario" class="btn btn-success btn-agregar-evento" data-bs-target="#modalEventos" data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Campana">
                <i class="fa-regular fa-bell"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row table-responsive" id="container-eventos"></div>
        </div>
    </div>
</div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/admin/home.autor.js"></script>
<div class="modal fade" id="modalEventos" aria-hidden="true" aria-labelledby="modalEventosLabel" tabindex="-1">
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
                                <input type="file" class="form-control-file" id="foto" name="foto">
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tutorial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="" class="d-block w-100" alt="...">
                                <div class="d-none d-md-block">
                                    <p>Funciones para agregar, modificar y borrar.</p>
                                    <ul style="list-style-type: decimal; font-size: 12px;">
                                        <li>Para agregar un nuevo autor, simplemente haz clic en el botón verde 'Agregar'.</li>
                                        <li>Si deseas eliminar un autor, solo necesitas hacer clic en el botón rojo.</li>
                                        <li>Para editar al autor, haz clic en el botón azul.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="" class="d-block w-100" alt="...">
                                <div class="d-none d-md-block">
                                    <p>Funciones de búsqueda.</p>
                                    <ul style="list-style-type: decimal; font-size: 12px;">
                                        <li>Deberás completar todos los campos requeridos del usuario (*).</li>
                                        <li>Una vez completados, deberás hacer clic en el botón 'Guardar'.</li>
                                        <li>Si estás actualizando los datos, simplemente completa todos los campos y haz clic en 'Guardar'.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev" style="background-color: rgba(0, 0, 0, 0.293);">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next" style="background-color: rgba(0, 0, 0, 0.293);">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>