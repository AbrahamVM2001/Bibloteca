<?php require('views/headervertical.view.php'); ?>
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <h3>Libro altas, bajas, modificación</h3>
            <p>¡Bienvenido a esta sección! Te informamos que la información aquí presente es exclusiva para administradores.
                Si deseas dar de alta un libro, haz clic en "Agregar".
                Si deseas modificar un libro, simplemente haz doble clic en la tabla.
                Para eliminar un libro, selecciona el botón rojo. ¡Gracias por tu labor administrativa!
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
    <script src="<?= constant('URL') ?>public/js/paginas/admin/home.libro.js"></script>
    <div class="modal fade" id="modalEventos" aria-hidden="true" aria-labelledby="modalEventosLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalEventosLabel">AGREGAR UN NUEVO LIBRO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-new-event" action="javascript:;" name="form-libro" class="needs-validation" novalidate method="post">
                        <input type="hidden" name="id_libro" id="id_libro" value="">
                        <div class="row">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="nombre">Titulo <small class="text-danger">*</small></label>
                                    <input title="Ingresa el titulo del libro." type="text" class="form-control" name="titulo" id="titulo" placeholder="Número de páginas" required>
                                    <div class="invalid-feedback">
                                        Ingresa el titulo del libro por favor.
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="APaterno">Número de páginas <small class="text-danger">*</small></label>
                                    <input title="Ingresa el número de páginas." type="number" class="form-control" name="Numero_pagina" id="Numero_pagina" placeholder="Numero de paginas" required>
                                    <div class="invalid-feedback">
                                        Ingresa el número de páginas del libro.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="AMaterno">Fecha publicación <small class="text-danger">*</small></label>
                                    <input title="Ingresa la fecha de publicación." type="date" class="form-control" name="fecha_publicacion" id="fecha_publicacion" placeholder="Fecha de publicación" required>
                                    <div class="invalid-feedback">
                                        Ingresa la fecha de publicacion.
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="Descripcion">Descripcion <small class="text-danger">*</small></label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                                    <div class="invalid-feedback">
                                        Ingresa la descripcion del libro.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Palabra clave <small class="text-danger">*</small></label>
                                    <input title="Ingresa la palabra clave." type="text" class="form-control" name="palabra_clave" id="palabra_clave" placeholder="palabra_clave" required>
                                    <div class="invalid-feedback">
                                        Ingresa la palabra clave del libro.
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Estatus <small class="text-danger">*</small></label>
                                    <select title="Ingresa el nuevo estatus." class="form-select" aria-label="Default select example" name="estatus" id="estatus" required>
                                        <option value="0">Deshabilitado</option>
                                        <option value="1">Habilitado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="AMaterno">Portada del libro. <small class="text-danger">*</small></label>
                                    <input type="file" class="form-control-file" id="portada" name = "portada">
                                    <div class="invalid-feedback">
                                        Ingresa la portada del libro
                                    </div>
                                    <div class="invalid-feedback">
                                        Ingresa la portada del libro.
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="AMaterno">Documento del libro. <small class="text-danger">*</small></label>
                                    <input type="file" class="form-control-file" id="documento" name = "documento">
                                    <div class="invalid-feedback">
                                        Ingresa el documento del libro.
                                    </div>
                                    <div class="invalid-feedback">
                                        Ingresa el documento del libro en formato .pdf.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Editorial <small class="text-danger">*</small></label>
                                    <select title="Ingresa el nuevo estatus." class="form-select" aria-label="Default select example" name="editorial" id="editorial" required>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Autor <small class="text-danger">*</small></label>
                                    <select title="Ingresa el nuevo autor." class="form-select" aria-label="Default select example" name="autor" id="autor" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Categoria <small class="text-danger">*</small></label>
                                    <select title="Ingresa el nuevo categoria." class="form-select" aria-label="Default select example" name="categoria" id="categoria" required>
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label for="">Idioma <small class="text-danger">*</small></label>
                                    <select title="Ingresa un nuevo idioma." class="form-select" aria-label="Default select example" name="idioma" id="idioma" required>
                                        <option></option>
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
<!-- contenedor de actualizar -->