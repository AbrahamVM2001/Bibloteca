<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
  <div class="card card-body blur shadow-blur mx-2 mt-n4 overflow-hidden" style="background-color: #e9ecef !important;">
      <div class="row gx-4">
      <h5 class="text-center"><?= $_SESSION['evento_seleccionado'] ?></h5>
      <small class="text-center">
          <?= $_SESSION['programa_seleccionado'] ?> |
          <?= $_SESSION['fecha_seleccionado'] ?> |
          <?= $_SESSION['salon_seleccionado'] ?> |
          <?= $_SESSION['capitulo_seleccionado'] ?> 
        </small>
      </div>
    </div>
    <div class="card-header d-flex justify-content-between flex-wrap">
    <button class="btn btn-info mx-auto" onclick="window.history.back();"><i class="fa-solid fa-arrow-left"></i> Regresar</button>
      <h3 class="mx-auto">Actividades</h3>
      <button id="add-document" class="btn btn-success mx-auto" data-bs-target="#modalNuevoSalon"
        data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
    </div>
    <div class="card-body">
      <div class="row" id="container-actividades"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script>
let fechas = '<?= $this->idfecha; ?>';
let programa = '<?= $this->idprograma; ?>';
let salon = '<?= $this->idsalon; ?>';
let capitulo = '<?= $this->idcapitulo; ?>';
</script>
<script src="<?= constant('URL') ?>public/js/paginas/home.actividades.js"></script>
<div class="modal fade" id="modalNuevoSalon" aria-hidden="true" aria-labelledby="modalNuevoSalonLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-actividades" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="idfecha" id="idfecha" value="<?= $this->idfecha; ?>" readonly>
      <input type="hidden" name="idprograma" id="idprograma" value="<?= $this->idprograma; ?>" readonly>
      <input type="hidden" name="idsalon" id="idsalon" value="<?= $this->idsalon; ?>" readonly>
      <input type="hidden" name="idcapitulo" id="idcapitulo" value="<?= $this->idcapitulo; ?>" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoSalonLabel">Agregar nueva actividad</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Actividad</label>
              <select class="form-control" name="asignar_actividad" id="asignar_actividad" required>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div id="contenedor-agregar" class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
              <label for="">Actividad</label>
              <input type="text" class="form-control" name="nueva_actividad" id="nueva_actividad" disabled="true">
              <div class="invalid-feedback">
                Ingrese un nombre de actividad, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-actividades" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save-actividades">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <i class="fa-solid fa-link"></i> LINK -->
<!-- <i class="fa-solid fa-qrcode"></i> QR -->
<!-- <i class="fa-solid fa-pen-to-square"></i> EDIT -->
<!-- <i class="fa-solid fa-power-off"></i> POWER -->