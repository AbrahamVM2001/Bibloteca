<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
  <div class="card card-body blur shadow-blur mx-2 mt-n4 overflow-hidden" style="background-color: #e9ecef !important;">
      <div class="row gx-4">
      <h5 class="text-center"><?= $_SESSION['evento_seleccionado'] ?></h5>
      <small class="text-center"><?= $_SESSION['programa_seleccionado'] ?></small>
      </div>
    </div>
    <div class="card-header d-flex justify-content-between flex-wrap">
    <button class="btn btn-info mx-auto" onclick="window.history.back();"><i class="fa-solid fa-arrow-left"></i> Regresar</button>
      <h3 class="mx-auto">Fechas</h3>
      <button id="add-document" class="btn btn-success mx-auto" data-bs-target="#modalNuevoFechas"
        data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
    </div>
    <div class="card-body">
      <div class="row" id="container-fechas"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script>let fechas = '<?= $this->fechas; ?>';</script>
<script src="<?= constant('URL') ?>public/js/paginas/home.fechas.js"></script>
<div class="modal fade" id="modalNuevoFechas" aria-hidden="true" aria-labelledby="modalNuevoFechasLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-fechas" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="programa" id="programa" value="<?= $this->fechas; ?>" readonly>
      <input type="hidden" name="evento" id="evento" value="<?= $this->evento; ?>" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoFechasLabel">Agregar nuevo modulo</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Fecha</label>
              <input type="date" class="form-control" name="fecha" id="fecha" required>
              <div class="invalid-feedback">
                Ingrese una fecha, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-fechas" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save-fechas">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <i class="fa-solid fa-link"></i> LINK -->
<!-- <i class="fa-solid fa-qrcode"></i> QR -->
<!-- <i class="fa-solid fa-pen-to-square"></i> EDIT -->
<!-- <i class="fa-solid fa-power-off"></i> POWER -->