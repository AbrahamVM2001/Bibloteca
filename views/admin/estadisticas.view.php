<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h3>Estadísticas</h3>
    </div>
    <div class="card-body">
      <div class="row table-responsive" id="container-estadisticas"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/home.estadisticas.js"></script>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Crear carpeta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-carpetas" action="javascript:;" class="needs-validation" novalidate method="post">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Nombre de autor</label>
              <input type="text" class="form-control" name="nombre_autor" id="nombre_autor"
                placeholder="Nombre de autor..." required>
              <div class="invalid-feedback">
                Ingrese un nombre de autor, por favor.
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button data-formulario="form-carpetas" type="button" class="btn btn-primary btn-carpeta">Guardar</button>
      </div>
    </div>
  </div>
</div>