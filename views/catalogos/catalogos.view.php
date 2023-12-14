<?php require('views/headervertical.view.php'); ?>
<style>
  thead input {
    width: 100%;
  }
</style>
<div class="container-fluid">
  <div class="card">
    <div class="card card-body blur shadow-blur mx-2 mt-n4 overflow-hidden"
      style="background-color: #e9ecef !important;">
      <div class="row gx-4">
        <h5 class="text-center">
          <?= $_SESSION['evento_catalogos_seleccionado'] ?>
        </h5>
        <small class="text-center">
          <?= $_SESSION['programa_catalogos_seleccionado'] ?>
        </small>
      </div>
    </div>
    <div class="card-header d-flex justify-content-center flex-wrap">
      <h3>Catálogos</h3>
      <small class="text-center">Para editar un registro, deberá de dar <strong>doble click</strong> en el registro deseado y se mostrara un formulario con la información a editar.</small>
    </div>
    <div class="card-body">
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="profesores">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#accordion-profesores" aria-expanded="true" aria-controls="accordion-profesores">
              Profesores
            </button>
          </h2>
          <div id="accordion-profesores" class="accordion-collapse collapse" aria-labelledby="profesores"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="row table-responsive" id="container-profesores"></div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="salones">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#accordion-salones" aria-expanded="false" aria-controls="accordion-salones">
              Salones
            </button>
          </h2>
          <div id="accordion-salones" class="accordion-collapse collapse" aria-labelledby="salones"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="row table-responsive" id="container-salones"></div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="capitulos">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#accordion-capitulos" aria-expanded="false" aria-controls="accordion-capitulos">
              Capítulos
            </button>
          </h2>
          <div id="accordion-capitulos" class="accordion-collapse collapse" aria-labelledby="capitulos"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="row table-responsive" id="container-capitulos"></div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="actividades">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#accordion-actividades" aria-expanded="false" aria-controls="accordion-actividades">
              Actividades
            </button>
          </h2>
          <div id="accordion-actividades" class="accordion-collapse collapse" aria-labelledby="actividades"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="row table-responsive" id="container-actividades"></div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="temas">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#accordion-temas" aria-expanded="false" aria-controls="accordion-temas">
              Temas
            </button>
          </h2>
          <div id="accordion-temas" class="accordion-collapse collapse" aria-labelledby="temas"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="row table-responsive" id="container-temas"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/catalogos.concentrado.js"></script>
<script>
  let programa = '<?= $this->programa; ?>'
</script>
<!-- Modal profesores -->
<div class="modal fade" id="modalProfesores" aria-hidden="true" aria-labelledby="modalProfesoresLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-profesores" name="form-profesores" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="idprofesor" id="idprofesor" readonly>
      <input type="hidden" name="formulario" id="formulario" value="profesores" readonly>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalProfesoresLabel">Titulo profesores</h1>
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
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-profesores" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal salones -->
<div class="modal fade" id="modalSalones" aria-hidden="true" aria-labelledby="modalSalonesLabel" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-salones" action="javascript:;" class="needs-validation" novalidate method="post">
    <input type="hidden" name="formulario" id="formulario" value="salones" readonly>
      <input type="hidden" name="idsalon" id="idsalon">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalSalonesLabel">Agregar nuevo salón</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Salón</label>
              <input type="text" class="form-control" name="nombre_salon" id="nombre_salon" required>
              <div class="invalid-feedback">
                Escriba un nombre de salón, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-salones" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal capitulo -->
<div class="modal fade" id="modalCapitulos" aria-hidden="true" aria-labelledby="modalCapitulosLabel" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-capitulos" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="tipo" id="tipo" value="nuevo">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalCapitulosLabel">Agregar nuevo capitulo</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Capitulo</label>
              <input type="text" class="form-control" name="nombre_capitulo" id="nombre_capitulo" required>
              <div class="invalid-feedback">
                Ingrese un nombre de capítulo, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-capitulos" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal actividades -->
<div class="modal fade" id="modalActividades" aria-hidden="true" aria-labelledby="modalActividadesLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-actividades" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="idfecha" id="idfecha" value="<?= $this->idfecha; ?>" readonly>
      <input type="hidden" name="idprograma" id="idprograma" value="<?= $this->idprograma; ?>" readonly>
      <input type="hidden" name="idsalon" id="idsalon" value="<?= $this->idsalon; ?>" readonly>
      <input type="hidden" name="idcapitulo" id="idcapitulo" value="<?= $this->idcapitulo; ?>" readonly>
      <input type="hidden" name="tipo" id="tipo" value="nuevo">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalActividadesLabel">Agregar nueva actividad</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Actividad</label>
              <input type="text" class="form-control" name="nombre_actividad" id="nombre_actividad" required>
              <div class="invalid-feedback">
                Ingrese un nombre de actividad, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-actividades" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal temas -->
<div class="modal fade" id="modalTemas" aria-hidden="true" aria-labelledby="modalTemasLabel"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form-temas" action="javascript:;" class="needs-validation" novalidate method="post">
      <input type="hidden" name="idfecha" id="idfecha" value="<?= $this->idfecha; ?>" readonly>
      <input type="hidden" name="idprograma" id="idprograma" value="<?= $this->idprograma; ?>" readonly>
      <input type="hidden" name="idsalon" id="idsalon" value="<?= $this->idsalon; ?>" readonly>
      <input type="hidden" name="idcapitulo" id="idcapitulo" value="<?= $this->idcapitulo; ?>" readonly>
      <input type="hidden" name="tipo" id="tipo" value="nuevo">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalTemasLabel">Agregar nueva actividad</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="">Tema</label>
              <input type="text" class="form-control" name="nombre_actividad" id="nombre_actividad" required>
              <div class="invalid-feedback">
                Ingrese un nombre de actividad, por favor.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button data-formulario="form-temas" data-tipo="nuevo" type="button"
            class="btn btn-success btn-save">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>