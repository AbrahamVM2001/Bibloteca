<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
    <div class="card card-body blur shadow-blur mx-2 mt-n4 overflow-hidden"
      style="background-color: #e9ecef !important;">
      <div class="row gx-4">
        <h5 class="text-center">
          <?= $_SESSION['evento_carta_seleccionado'] ?>
        </h5>
        <small class="text-center">
          <?= $_SESSION['programa_carta_seleccionado'] ?>
        </small>
      </div>
    </div>
    <div class="card-header d-flex justify-content-center flex-wrap">
      <h3>Concentrado</h3>
    </div>
    <div class="card-body">
      <div class="row table-responsive" id="container-concentrado"></div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/cartas.concentrado.js"></script>
<script>
  let programa = '<?= $this->idprograma; ?>'
</script>
<div class="modal fade" id="modalListaTemas" aria-hidden="true" aria-labelledby="modalListaTemasLabel" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalListaTemasLabel">Lista de temas asignados</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
            <h5 id="profesor-seleccionado"></h5>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive" id="container-table-temas">
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-end">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>