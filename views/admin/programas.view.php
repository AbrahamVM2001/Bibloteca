<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
    <div class="card card-body blur shadow-blur mx-2 mt-n4 overflow-hidden" style="background-color: #e9ecef !important;">
      <div class="row gx-4">
        <h5 class="text-center"><?= $_SESSION['evento_seleccionado'] ?></h5>
      </div>
    </div>
    <div class="card-header d-flex justify-content-between flex-wrap">
      <button class="btn btn-info mx-auto" onclick="window.history.back();"><i class="fa-solid fa-arrow-left"></i>
        Regresar</button>
      <h3 class="mx-auto">Programas</h3>
      <button id="add-document" class="btn btn-success mx-auto btn-agregar-programa" data-bs-target="#modalNuevoPrograma" data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
    </div>
    <div class="card-body">
      <div class="row" id="container-programas"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script>
  let evento = '<?= $this->evento; ?>';
</script>
<script src="<?= constant('URL') ?>public/js/paginas/home.programas.js"></script>
<div class="modal fade" id="modalNuevoPrograma" aria-hidden="true" aria-labelledby="modalNuevoProgramaLabel" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-programa" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="evento" id="evento" value="<?= $this->evento; ?>" readonly>
      <input type="hidden" name="tipo" id="tipo" value="nuevo">
      <input type="hidden" name="id_programa" id="id_programa">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoProgramaLabel">Agregar nuevo programa</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Nombre programa</label>
              <input type="text" class="form-control" name="nombre_programa" id="nombre_programa" placeholder="Nombre del programa..." required>
              <div class="invalid-feedback">
                Ingrese un nombre de programa, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Responsable</label>
              <input type="text" class="form-control" name="responsable" id="responsable" placeholder="Nombre del responsable..." required>
              <div class="invalid-feedback">
                Ingrese un nombre, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Correo responsable</label>
              <input type="email" class="form-control" name="correo_responsable" id="correo_responsable" placeholder="Correo responsable..." required>
              <div class="invalid-feedback">
                Ingrese un nombre correo, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-programa" data-tipo="nuevo" type="button" class="btn btn-success btn-save-programa">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <i class="fa-solid fa-link"></i> LINK -->
<!-- <i class="fa-solid fa-qrcode"></i> QR -->
<!-- <i class="fa-solid fa-pen-to-square"></i> EDIT -->
<!-- <i class="fa-solid fa-power-off"></i> POWER -->