<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
    <div class="card-header d-flex justify-content-between">
    <button class="btn btn-info" onclick="window.history.back();"><i class="fa-solid fa-arrow-left"></i> Regresar</button>
      <h3>Programas</h3>
      <button id="add-document" class="btn btn-success" data-bs-target="#modalNuevoPrograma"
        data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
    </div>
    <div class="card-body">
      <div class="row" id="container-programas"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script>let evento = '<?= $this->evento; ?>';</script>
<script src="<?= constant('URL') ?>public/js/paginas/home.programas.js"></script>
<div class="modal fade" id="modalNuevoPrograma" aria-hidden="true" aria-labelledby="modalNuevoProgramaLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-programa" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="evento" id="evento" value="<?= $this->evento; ?>" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoProgramaLabel">Agregar nuevo programa</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Nombre programa</label>
              <input type="text" class="form-control" name="nombre_programa" id="nombre_programa"
                placeholder="Nombre del programa..." required>
              <div class="invalid-feedback">
                Ingrese un nombre de programa, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-programa" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save-programa">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <i class="fa-solid fa-link"></i> LINK -->
<!-- <i class="fa-solid fa-qrcode"></i> QR -->
<!-- <i class="fa-solid fa-pen-to-square"></i> EDIT -->
<!-- <i class="fa-solid fa-power-off"></i> POWER -->