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
<script src="<?= constant('URL') ?>public/js/paginas/admin/home.categoria.js"></script>
<div class="modal fade" id="modalEventos" aria-hidden="true" aria-labelledby="modalEventosLabel" tabindex="-1">
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
                        <div class="row">
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
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
                                    <li>Para agregar una categoría, haz clic en el botón verde 'Agregar'.</li>
                                    <li>Si deseas borrar una categoría, simplemente haz clic en el botón rojo 'Borrar'.</li>
                                    <li>Para modificar una categoría, simplemente haz doble clic en cualquier categoría.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="" class="d-block w-100" alt="...">
                            <div class="d-none d-md-block">
                                <p>Funciones de búsqueda.</p>
                                <ul style="list-style-type: decimal; font-size: 12px;">
                                    <li>Puedes buscar la categoría por nombre de la categoría y estado.</li>
                                    <li>Puedes ver todas las categorías registradas o filtrar por 5, 10 y 15.</li>
                                    <li>También puedes ver los siguientes datos haciendo clic en 'Siguiente'.</li>
                                    <li>Puedes moverte por los números de la tabla para ver los datos siguientes.</li>
                                    <li>Si necesitas regresar al anterior, simplemente haz clic en 'Anterior'.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="" class="d-block w-100" alt="...">
                            <div class="d-none d-md-block">
                                <p>Funciones para guardar datos o modificarlos.</p>
                                <ul style="list-style-type: decimal; font-size: 12px;">
                                    <li>Por favor, registra todos los datos de la categoría que sean necesarios (*).</li>
                                    <li>Una vez que hayas terminado de ingresar todos los datos, simplemente haz clic en 'Guardar'.</li>
                                    <li>Si previamente has presionado para modificar, simplemente modifica los datos deseados y haz clic en 'Guardar'.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" style="background-color: rgba(0, 0, 0, 0.293);">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" style="background-color: rgba(0, 0, 0, 0.293);">
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