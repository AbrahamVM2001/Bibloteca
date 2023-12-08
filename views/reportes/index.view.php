<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
    <div class="card-header d-flex justify-content-center flex-wrap">
      <h3>Reportes | Eventos</h3>
    </div>
    <div class="card-body">
      <div class="row" id="container-eventos"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/cartas.eventos.js"></script>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Crear nuevo evento</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-new-event" action="javascript:;" class="needs-validation" novalidate method="post">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Nombre evento</label>
              <input type="text" class="form-control" name="nombre_evento" id="nombre_evento"
                placeholder="Nombre evento..." required>
              <div class="invalid-feedback">
                Ingrese un nombre de evento, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Descripción evento <small>(opcional)</small></label>
              <input type="text" class="form-control" name="descripcion_evento" id="descripcion_evento"
                placeholder="Descripción...">
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Fecha inicial</label>
              <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required>
              <div class="invalid-feedback">
                Ingrese una fecha inicial, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Fecha final</label>
              <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" required>
              <div class="invalid-feedback">
                Ingrese una fecha final, por favor.
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