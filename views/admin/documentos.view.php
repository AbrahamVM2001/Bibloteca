<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h3>Documentos</h3>
      <button id="add-document" class="btn btn-success" data-bs-target="#exampleModalToggle"
        data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
    </div>
    <div class="card-body">
      <div class="row" id="container-documentos"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script>let rev = '<?= $this->revista; ?>';</script>
<script src="<?= constant('URL') ?>public/js/paginas/home.documentos.js"></script>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="form-documentos" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="revista" id="revista" value="<?= $this->revista; ?>" readonly>
      <input type="hidden" name="id_documento" id="id_documento" value="" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Agregar documento</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Nombre documento</label>
              <input type="text" class="form-control" name="nombre_documento" id="nombre_documento"
                placeholder="Nombre del documento..." required>
              <div class="invalid-feedback">
                Ingrese un nombre de documento, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Documento</label>
              <input type="file" class="form-control" name="documento" id="documento" accept=".pdf" required>
              <div class="invalid-feedback">
                Seleccione un documento, por favor.
              </div>
              <input type="hidden" name="documento_ant" id="documento_ant" value="">
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-documentos" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <i class="fa-solid fa-link"></i> LINK -->
<!-- <i class="fa-solid fa-qrcode"></i> QR -->
<!-- <i class="fa-solid fa-pen-to-square"></i> EDIT -->
<!-- <i class="fa-solid fa-power-off"></i> POWER -->