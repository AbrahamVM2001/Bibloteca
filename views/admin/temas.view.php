<?php require('views/headervertical.view.php'); ?>
<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex justify-content-between">
    <button class="btn btn-info" onclick="window.history.back();"><i class="fa-solid fa-arrow-left"></i> Regresar</button>
      <h3>Temas</h3>
      <button id="add-document" class="btn btn-success" data-bs-target="#modalNuevoTema"
        data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
    </div>
    <div class="card-body">
      <div class="row table-responsive" id="container-temas"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script>
let fechas = '<?= $this->idfecha; ?>';
let programa = '<?= $this->idprograma; ?>';
let salon = '<?= $this->idsalon; ?>';
let capitulo = '<?= $this->idcapitulo; ?>';
let actividad = '<?= $this->idactividad; ?>';
</script>
<script src="<?= constant('URL') ?>public/js/paginas/home.temas.js"></script>
<div class="modal fade" id="modalNuevoTema" aria-hidden="true" aria-labelledby="modalNuevoTemaLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-temas" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="idfecha" id="idfecha" value="<?= $this->idfecha; ?>" readonly>
      <input type="hidden" name="idprograma" id="idprograma" value="<?= $this->idprograma; ?>" readonly>
      <input type="hidden" name="idsalon" id="idsalon" value="<?= $this->idsalon; ?>" readonly>
      <input type="hidden" name="idcapitulo" id="idcapitulo" value="<?= $this->idcapitulo; ?>" readonly>
      <input type="hidden" name="idactividad" id="idactividad" value="<?= $this->idactividad; ?>" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoTemaLabel">Agregar nuevo tema</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Tema</label>
              <select class="form-control" name="asignar_tema" id="asignar_tema" required>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div id="contenedor-agregar" class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
              <label for="">Nuevo tema</label>
              <input type="text" class="form-control" name="nuevo_tema" id="nuevo_tema" disabled="true">
              <div class="invalid-feedback">
                Ingrese un nombre de tema, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Hora inicial</label>
              <input type="time" class="form-control campos-asignacion" name="hora_inicial" id="hora_inicial" required>
              <div class="invalid-feedback">
                Ingrese una hora inicial, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Hora final</label>
              <input type="time" class="form-control campos-asignacion" name="hora_final" id="hora_final" required>
              <div class="invalid-feedback">
                Ingrese una hora final, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Profesor</label>
              <select class="form-control campos-asignacion" name="profesor" id="profesor" required>
                <option value="">Seleccionar profesor...</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Modalidad</label>
              <select class="form-control campos-asignacion" name="modalidad" id="modalidad" required>
                <option value="">Seleccionar modalidad...</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-temas" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save-temas">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Nuevo profesor -->
<div class="modal fade" id="modalNuevoTema" aria-hidden="true" aria-labelledby="modalNuevoTemaLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-temas" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="idfecha" id="idfecha" value="<?= $this->idfecha; ?>" readonly>
      <input type="hidden" name="idprograma" id="idprograma" value="<?= $this->idprograma; ?>" readonly>
      <input type="hidden" name="idsalon" id="idsalon" value="<?= $this->idsalon; ?>" readonly>
      <input type="hidden" name="idcapitulo" id="idcapitulo" value="<?= $this->idcapitulo; ?>" readonly>
      <input type="hidden" name="idactividad" id="idactividad" value="<?= $this->idactividad; ?>" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoTemaLabel">Agregar nuevo tema</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Nombre</label>
              <select class="form-control" name="asignar_tema" id="asignar_tema" required>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div id="contenedor-agregar" class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-none">
              <label for="">Apellido paterno</label>
              <input type="text" class="form-control" name="nuevo_tema" id="nuevo_tema" disabled="true">
              <div class="invalid-feedback">
                Ingrese un nombre de tema, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Apellido materno</label>
              <input type="time" class="form-control campos-asignacion" name="hora_inicial" id="hora_inicial" required>
              <div class="invalid-feedback">
                Ingrese una hora inicial, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Hora final</label>
              <input type="time" class="form-control campos-asignacion" name="hora_final" id="hora_final" required>
              <div class="invalid-feedback">
                Ingrese una hora final, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Profesor</label>
              <select class="form-control campos-asignacion" name="profesor" id="profesor" required>
                <option value="">Seleccionar profesor...</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 contenedor-asignacion">
              <label for="">Modalidad</label>
              <select class="form-control campos-asignacion" name="modalidad" id="modalidad" required>
                <option value="">Seleccionar modalidad...</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-temas" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save-temas">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <i class="fa-solid fa-link"></i> LINK -->
<!-- <i class="fa-solid fa-qrcode"></i> QR -->
<!-- <i class="fa-solid fa-pen-to-square"></i> EDIT -->
<!-- <i class="fa-solid fa-power-off"></i> POWER -->