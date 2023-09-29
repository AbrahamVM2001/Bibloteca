</div>
</main>
<!--   Core JS Files   -->
<script>
    let servidor = '<?= constant("URL"); ?>';
</script>
<script src="<?= constant("URL") ?>public/js/plugins/jquery/jquery.min.js"></script>
<script src="<?= constant('URL') ?>public/js/core/popper.min.js"></script>
<script src="<?= constant('URL') ?>public/js/core/bootstrap.min.js"></script>
<script src="<?= constant('URL') ?>public/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= constant('URL') ?>public/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?= constant('URL') ?>public/js/jquery.dataTables.min.js"></script>
<!-- Kanban scripts -->
<script src="<?= constant('URL') ?>public/js/plugins/dragula/dragula.min.js"></script>
<script src="<?= constant('URL') ?>public/js/plugins/jkanban/jkanban.js"></script>
<script src="<?= constant('URL') ?>public/js/plugins/multistep-form.js"></script>
<script src="<?= constant('URL') ?>public/js/plugins/choices.min.js"></script>
<!-- Select2 -->
<script src="<?php echo constant("URL");?>public/plugins/select2/js/select2.full.min.js"></script>
<!-- Github buttons -->
<script async defer src="<?= constant('URL') ?>public/js/github.buttons.js"></script>
<script src="<?= constant('URL') ?>public/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
<script src="<?= constant('URL') ?>public/js/fontawesome-4f9827e774.js"></script>
<script src="<?= constant('URL') ?>public/js/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.3/clipboard.min.js"></script>


<!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script> -->
<script>
  if (document.getElementById('state1')) {
    const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
  if (document.getElementById('state2')) {
    const countUp = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
  if (document.getElementById('state3')) {
    const countUp = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
  if (document.getElementById('state4')) {
    const countUp = new CountUp('state4', document.getElementById("state4").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
</script>
<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<script>
  $(function () {
    $('[data-bs-toggle="tooltip"]').tooltip()
    $("body").addClass('g-sidenav-show bg-gray-100 g-sidenav-hidden');
    $("#hamburguesa").click(function () {
      if ($(this).hasClass('mostrar')) {
        console.log("Tiene la clase mostrar");
        $(this).addClass('ocultar')
        $(this).removeClass('mostrar')
        $("body").removeClass('g-sidenav-show bg-gray-100 g-sidenav-hidden');
        $("body").addClass('g-sidenav-show bg-gray-100  g-sidenav-pinned')
      } else {
        console.log("Tiene la clase ocultar");
        $(this).addClass('mostrar')
        $(this).removeClass('ocultar')

        $("body").addClass('g-sidenav-show bg-gray-100 g-sidenav-hidden');
        $("body").removeClass('g-sidenav-show bg-gray-100  g-sidenav-pinned')
      }
    });
    function mayusculas(e) {
      e.value = e.value.toUpperCase();
    }
    function minusculas(e) {
      e.value = e.value.toLowerCase();
    }
    $(".mayusculas").on('keyup', function () {
      /* console.log("mayus"); */
      mayusculas(this);
    });
    $(".minusculas").on('keyup', function () {
      minusculas(this);
    });
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>