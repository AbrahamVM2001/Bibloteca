<?php require('views/headervertical.view.php'); ?>
<div class="container-fluid">
  <div class="card">
  <div class="card card-body blur shadow-blur mx-2 mt-n4 overflow-hidden" style="background-color: #e9ecef !important;">
      <div class="row gx-4">
      <h5 class="text-center"><?= $_SESSION['evento_seleccionado'] ?></h5>
      <small class="text-center">
          <?= $_SESSION['programa_seleccionado'] ?> |
          <?= $_SESSION['fecha_seleccionado'] ?> |
          <?= $_SESSION['salon_seleccionado'] ?> |
          <?= $_SESSION['capitulo_seleccionado'] ?> |
          <?= $_SESSION['actividad_seleccionado'] ?>
        </small>
      </div>
    </div>
    <div class="card-header d-flex justify-content-between flex-wrap">
    <button class="btn btn-info mx-auto" onclick="window.history.back();"><i class="fa-solid fa-arrow-left"></i> Regresar</button>
      <h3 class="mx-auto">Temas</h3>
      <button id="add-document" class="btn btn-success mx-auto" data-bs-target="#modalNuevoTema"
        data-bs-toggle="modal">Agregar <i class="fa-solid fa-circle-plus"></i></button>
        <p class="mx-auto">Para editar o eliminar una asignación de tema, haga doble clic en el registro a editar.</p>
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
      <input type="hidden" name="tipo" id="tipo" value="nuevo">
      <input type="hidden" name="id_asignacion_tema" id="id_asignacion_tema">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoTemaLabel">Agregar/Asignar nuevo tema</h1>
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
          <button id="" type="button" class="btn btn-danger eliminar-asignacion">Eliminar <i class="fa-solid fa-trash"></i></button>
          <button data-formulario="form-temas" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save-temas">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Nuevo profesor -->
<div class="modal fade" id="modalNuevoProfesor" aria-hidden="true" aria-labelledby="modalNuevoProfesorLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-profesor-nuevo" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="idfecha" id="idfecha" value="<?= $this->idfecha; ?>" readonly>
      <input type="hidden" name="idprograma" id="idprograma" value="<?= $this->idprograma; ?>" readonly>
      <input type="hidden" name="idsalon" id="idsalon" value="<?= $this->idsalon; ?>" readonly>
      <input type="hidden" name="idcapitulo" id="idcapitulo" value="<?= $this->idcapitulo; ?>" readonly>
      <input type="hidden" name="idactividad" id="idactividad" value="<?= $this->idactividad; ?>" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalNuevoProfesorLabel">Agregar nuevo profesor</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
              <label for="">Prefijo <small class="text-danger">*</small></label>
              <select class="form-control" name="prefijo" id="prefijo" required>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
          <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
              <label for="">Nombre <small class="text-danger">*</small></label>
              <input class="form-control" type="text" name="nombre_profesor" id="nombre_profesor" required>
              <div class="invalid-feedback">
                Ingrese un nombre, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Apellido paterno <small class="text-danger">*</small></label>
              <input type="text" class="form-control" name="apellidop_profesor" id="apellidop_profesor" required>
              <div class="invalid-feedback">
                Ingrese un apellido paterno, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Apellido materno</label>
              <input type="text" class="form-control" name="apellidom_profesor" id="apellidom_profesor">
              <div class="invalid-feedback">
                Ingrese un apellido materno, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">País <small class="text-danger">*</small></label>
              <select class="form-control" name="pais" id="pais" required>
                <option value="">Seleccionar país...</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Estado <small class="text-danger">*</small></label>
              <select class="form-control" name="estado" id="estado" required>
                <option value="">Seleccionar estado...</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Lada</label>
              <select class="form-control" name="lada" id="lada">
                <option value="">Seleccionar lada...</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Teléfono</label>
              <input class="form-control" type="tel" name="telefono_profesor" id="telefono_profesor">
              <div class="invalid-feedback">
                Ingrese un teléfono, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Rol <small class="text-danger">*</small></label>
              <select class="form-control" name="rol_profesor" id="rol_profesor" required>
                <option value="">Seleccionar rol...</option>
                <option value="0">Profesor</option>
                <option value="1">Coordinador</option>
                <option value="2">Profesor/Coordinador</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Correo <small class="text-danger">*</small></label>
              <input class="form-control" type="email" name="correo_profesor" id="correo_profesor" required>
              <div class="invalid-feedback">
                Ingrese un correo, por favor.
              </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
              <label for="">Idioma cartas</label>
              <select class="form-control" name="idioma_cartas" id="idioma_cartas" required>
                <option value="">Seleccionar idioma...</option>
                <option value="1">Español</option>
                <option value="2">Inglés</option>
              </select>
              <div class="invalid-feedback">
                Seleccione una opción, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-profesor-nuevo" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save-profesores">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- <i class="fa-solid fa-link"></i> LINK -->
<!-- <i class="fa-solid fa-qrcode"></i> QR -->
<!-- <i class="fa-solid fa-pen-to-square"></i> EDIT -->
<!-- <i class="fa-solid fa-power-off"></i> POWER -->