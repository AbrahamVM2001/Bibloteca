<!DOCTYPE html>
<html lang="es">
<?php $meses = array(
  'January' => 'enero',
  'February' => 'febrero',
  'March' => 'marzo',
  'April' => 'abril',
  'May' => 'mayo',
  'June' => 'junio',
  'July' => 'julio',
  'August' => 'agosto',
  'September' => 'septiembre',
  'October' => 'octubre',
  'November' => 'noviembre',
  'December' => 'diciembre'
); ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php include('./views/estilos.view.php') ?>
  <link rel="stylesheet" href="<?= constant('URL') ?>public/css/estilos-programa.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card card-body blur shadow-blur mx-2 mt-n4 overflow-hidden" style="background-color: #e9ecef !important;">
            <div class="row gx-4">
              <h5 class="text-center">
                <?= ($this->datos != 'Error') ? $this->datos['nombre_evento'] : 'Programa no encontrado'; ?>
              </h5>
              <small class="text-center">
                <?= ($this->datos != 'Error') ? $this->datos['nombre_programa'] : 'Programa no encontrado'; ?>
              </small>
            </div>
          </div>
          <div class="body">
            <div class="cd-horizontal-timeline loaded">
              <div class="timeline sticky-top">
                <div class="events-wrapper">
                  <div class="events" style="width: 800px;">
                    <ol>
                      <li><a href="javascript:;" data-date="portada" class="selected" style="left: 10px;">
                          Portada
                        </a></li>
                      <?php if ($this->fechasPrograma != 'Error') : ?>
                        <?php $pixeles = 120;
                        foreach ($this->fechasPrograma as $key => $value) : ?>
                          <li><a href="javascript:;" data-id="<?= base64_encode(base64_encode($value['id_fecha_programa'])); ?>" data-date="<?= $value['fecha_programa']; ?>" class="older-event fecha-seleccionada" style="left: <?= $pixeles ?>px;">
                              <?= date('j ', strtotime($value['fecha_programa'])) . $meses[date('F', strtotime($value['fecha_programa']))]; ?>
                            </a></li>
                        <?php $pixeles += 120;
                        endforeach; ?>
                      <?php endif; ?>
                    </ol>
                    <span class="filling-line" aria-hidden="true" style="transform: scaleX(0);"></span>
                  </div>
                  <!-- .events -->
                </div>
                <!-- .events-wrapper -->
                <ul class="cd-timeline-navigation">
                  <li><a href="javascript:;" class="prev inactive">Prev</a></li>
                  <li><a href="javascript:;" class="next">Next</a></li>
                </ul>
                <!-- .cd-timeline-navigation -->
              </div>
              <!-- .timeline -->
              <div class="events-content">
                <ol>
                  <li class="selected" data-date="portada">
                    <hr class="mb-5">
                    <?php if ($this->datos != 'Error') : ?>
                      <h3 class="text-center">
                        BIENVENIDO<br>
                        <small>al</small>
                      </h3>
                    <?php endif; ?>
                    <h2 class="text-center"><?= ($this->datos != 'Error') ? $this->datos['nombre_evento'] : 'Programa no encontrado'; ?></h2>
                    <hr class="mt-5">
                  </li>
                  <?php if ($this->fechasPrograma != 'Error') : ?>
                    <?php foreach ($this->fechasPrograma as $key => $value) : ?>
                      <li data-borrar="true" id="<?= $value['fecha_programa']; ?>" data-date="<?= $value['fecha_programa']; ?>">
                      </li>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php include('./views/footer.view.php') ?>
<script>
  let idprograma = '<?= $this->programa; ?>'
</script>
<script src="<?= constant('URL') ?>public/js/paginas/programa.index.js"></script>

</html>