$(function () {
  async function tablaConcentradoCartas() {
    try {
      let peticion = await fetch(
        servidor + `reportes/temasAsignadosProfesores/${programa}`
      );
      let response = await peticion.json();
      $("#container-concentrado").empty();
      if (response.length == 0) {
        jQuery(`<h2>Sin temas asignados</h2>`)
          .appendTo("#container-concentrado")
          .addClass("text-danger text-center text-uppercase");
        return false;
      }
      jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result">
            <thead><tr>
            <th class="text-uppercase">Día</th>
            <th class="text-uppercase">Salón</th>
            <th class="text-uppercase">Capítulo</th>
            <th class="text-uppercase">Actividad</th>
            <th class="text-uppercase">Horario Inicio</th>
            <th class="text-uppercase">Horario Fin</th>
            <th class="text-uppercase">Tema</th>
            <th class="text-uppercase">Modalidad</th>
            <th class="text-uppercase">Profesor</th>
            <th class="text-uppercase">País profesor</th>
            <th class="text-uppercase">Estado profesor</th>
            </tr></thead>
            </table>`)
        .appendTo("#container-concentrado")
        .removeClass("text-danger");

      $("#info-table-result").DataTable({
        drawCallback: function (settings) {
          $(".paginate_button").addClass("btn").removeClass("paginate_button");
          $(".dataTables_length").addClass("pull-left");
          $("#info-table-result_filter").addClass("pull-right");
          $("input").addClass("form-control");
          $("select").addClass("form-control");
          $(".previous.disabled").addClass(
            "btn-outline-info opacity-5 btn-rounded mx-2 mt-3"
          );
          $(".next.disabled").addClass(
            "btn-outline-info opacity-5 btn-rounded mx-2 mt-3"
          );
          $(".previous").addClass("btn-outline-info btn-rounded mx-2 mt-3");
          $(".next").addClass("btn-outline-info btn-rounded mx-2 mt-3");
        },
        scrollX: true,
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
            // For each column
            api.columns().eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function (e) {
                            e.stopPropagation();
                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
        language: {
          url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
        },
        dom: "Bfrtip",
        buttons: [
            {
                extend: 'excel',
                text: 'Exportar a Excel', // Cambia el texto del botón de exportación a Excel
                titleAttr: 'Exportar a Excel',
                filename: atob(atob(exportable)),
            },
        ],
        pageLength: 10,
        lengthMenu: [
          [10, 20, -1],
          [10, 20, "All"],
        ],
        data: response,
        columns: [
          { data: "fecha_programa", className: "text-vertical text-center" },
          { data: "nombre_salon", className: "text-vertical text-center" },
          { data: "nombre_capitulo", className: "text-vertical text-center" },
          { data: "nombre_actividad", className: "text-vertical text-center" },
          { data: "hora_inicial", className: "text-vertical text-center" },
          { data: "hora_final", className: "text-vertical text-center" },
          { data: "nombre_tema", className: "text-vertical text-center" },
          { data: "nombre_modalidad", className: "text-vertical text-center" },
          { data: "profesor", className: "text-vertical text-center" },
          { data: "pais", className: "text-vertical text-center" },
          { data: "estado", className: "text-vertical text-center" },
        ],
      });
      $('body #info-table-result thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('body #info-table-result thead');
    } catch (error) {
      console.log(error);
    }
  }
  tablaConcentradoCartas();
  async function tablaConcentradoCartas2() {
    try {
        let peticion = await fetch(servidor + `reportes/temasAsignadosProfesores2/${programa}`);
        let response = await peticion.json();
        $("#container-concentrado2").empty();
        if (response.length == 0) {
            jQuery(`<h2>Sin temas asignados</h2>`).appendTo("#container-concentrado2").addClass('text-danger text-center text-uppercase');
            return false;
        }
        jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result2">
        <thead><tr>
        <th class="text-uppercase">Profesor</th><th class="text-uppercase">Evento</th><th class="text-uppercase">Programa</th><th class="text-uppercase">Asignaciones</th><th class="text-uppercase">Acciones</th>
        </tr></thead>
        </table>`).appendTo("#container-concentrado2").removeClass('text-danger');

        $('#info-table-result2').DataTable({
            "drawCallback": function (settings) {
                $('.paginate_button').addClass("btn").removeClass("paginate_button");
                $('.dataTables_length').addClass('pull-left');
                $('#info-table-result_filter').addClass('pull-right');
                $('input').addClass("form-control");
                $('select').addClass('form-control');
                $('.previous.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2 mt-3");
                $('.next.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2 mt-3");
                $('.previous').addClass("btn-outline-info btn-rounded mx-2 mt-3");
                $('.next').addClass("btn-outline-info btn-rounded mx-2 mt-3");
            },
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "pageLength": 5,
            "lengthMenu": [[5, 10, -1], [5, 10, "All"]],
            data: response,
            "columns": [
                { "data": "profesor", className: 'text-vertical text-center' },
                { "data": "nombre_evento", className: 'text-vertical text-center' },
                { "data": "nombre_programa", className: 'text-vertical text-center' },
                { "data": "asignaciones", className: 'text-vertical text-center' },
                {
                    data: null,
                    render: function (data) {
                        botones = `<div class="col-sm-12 col-md-12 col-lg-12 col-<xl-12 d-flex justify-content-between align-items-center" >
                            <button data-id="${btoa(btoa(data.id_profesor))}" data-prof="${data.profesor}" data-programa="${btoa(btoa(data.fk_id_programa))}" data-bs-toggle="tooltip" title="Temas asignados" type="button" class="btn btn-info temas-asignados"><i class="fa-solid fa-list"></i></button>
                            <!--<a href="${servidor}cartas/previewCartas/${btoa(btoa(data.id_profesor))}/${btoa(btoa(data.fk_id_programa))}" target="_blank" data-bs-toggle="tooltip" title="Previsualizar Cartas" type="button" class="btn btn-secondary visualizar-cartas"><i class="fa-solid fa-magnifying-glass"></i></a>
                            <a href="${servidor}cartas/sendCartas/${btoa(btoa(data.id_profesor))}/${btoa(btoa(data.fk_id_programa))}" target="_blank" data-bs-toggle="tooltip" title="Enviar cartas" type="button" class="btn btn-success enviar-cartas"><i class="fa-solid fa-envelope-open-text"></i></a>-->
                            </div>`;
                        return botones;
                    },
                    className: 'text-vertical text-center'
                }
            ]
        });
    } catch (error) {
        console.log(error);
    }
}
tablaConcentradoCartas2();
  
  async function buscarTemasAsignados(idprof, idprog) {
    let peticion = await fetch(
      servidor + `reportes/buscarTemasAsignados/${idprof}/${idprog}`
    );
    let response = await peticion.json();
    console.log(response);
    $("#container-table-temas").empty();
    if (response.length == 0) {
      jQuery(`<h2>no se encontraron temas asignados</h2>`)
        .appendTo("#container-table-temas")
        .addClass("text-danger text-center text-uppercase");
      return false;
    }
    jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-temas">
        <thead><tr>
        <th class="text-uppercase">Fecha</th>
        <th class="text-uppercase">Hora inicial</th>
        <th class="text-uppercase">Hora final</th>
        <th class="text-uppercase">Salón</th>
        <th class="text-uppercase">Capítulo</th>
        <th class="text-uppercase">Actividad</th>
        <th class="text-uppercase">Tema</th>
        <th class="text-uppercase">Modalidad</th>
        </tr></thead>
        </table>`)
      .appendTo("#container-table-temas")
      .removeClass("text-danger");

    $("#info-table-temas").DataTable({
      drawCallback: function (settings) {
        $(".paginate_button").addClass("btn").removeClass("paginate_button");
        $(".dataTables_length").addClass("pull-left");
        $("#info-table-temas_filter").addClass("pull-right");
        $("input").addClass("form-control");
        $("select").addClass("form-control");
        $(".previous.disabled").addClass(
          "btn-outline-info opacity-5 btn-rounded mx-2 mt-3"
        );
        $(".next.disabled").addClass(
          "btn-outline-info opacity-5 btn-rounded mx-2 mt-3"
        );
        $(".previous").addClass("btn-outline-info btn-rounded mx-2 mt-3");
        $(".next").addClass("btn-outline-info btn-rounded mx-2 mt-3");
      },
      language: {
        url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
      },
      pageLength: 5,
      lengthMenu: [
        [5, 10, -1],
        [5, 10, "All"],
      ],
      data: response,
      columns: [
        /* { "data": "fecha_programa", className: 'text-vertical text-center' }, */
        {
          data: null,
          render: function (data) {
            return moment(data.fecha_programa).format("DD/MM/YYYY");
          },
          className: "text-vertical text-center",
        },
        { data: "hora_inicial", className: "text-vertical text-center" },
        { data: "hora_final", className: "text-vertical text-center" },
        { data: "nombre_salon", className: "text-vertical text-center" },
        { data: "nombre_capitulo", className: "text-vertical text-center" },
        { data: "nombre_actividad", className: "text-vertical text-center" },
        { data: "nombre_tema", className: "text-vertical text-center" },
        { data: "nombre_modalidad", className: "text-vertical text-center" },
      ],
    });
  }
  $("#container-concentrado2").on("click", ".temas-asignados", function () {
    $("#modalListaTemas").modal("show");
    $("#profesor-seleccionado").text($(this).data("prof"));
    buscarTemasAsignados($(this).data("id"), $(this).data("programa"));
  });
  $("#container-concentrado").on("click", ".visualizar-cartas", function () {
    verificarBloqueadorVentanasEmergentes();
    /* console.log("Click Preview de carta"); */
  });
  $("#container-concentrado").on("click", ".enviar-cartas", function () {
    console.log("Click Enviar cartas");
  });
  function verificarBloqueadorVentanasEmergentes() {
    var ventanaEmergente = window.open("", "", "width=1,height=1");
    var bloqueadorActivo =
      ventanaEmergente === null || typeof ventanaEmergente === "undefined";
    ventanaEmergente.close();
  }
  /*$('.visualizar-cartas').click(function () {
        console.log("Click Preview de carta");
    })
    $('.enviar-cartas').click(function () {
        console.log("Click Enviar cartas");
    }) */
});
