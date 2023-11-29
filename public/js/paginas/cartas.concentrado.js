$(function () {
    async function tablaConcentradoCartas() {
        try {
            let peticion = await fetch(servidor + `admin/infoTemas/${programa}/${fechas}`);
            let response = await peticion.json();
            $("#container-concentrado").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin temas asignados</h2>`).appendTo("#container-concentrado").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result">
            <thead><tr>
            <th class="text-uppercase">Tema</th><th class="text-uppercase">Hora inicial</th><th class="text-uppercase">Horal final</th><th class="text-uppercase">Profesor</th><th class="text-uppercase">Modalidad</th>
            </tr></thead>
            </table>`).appendTo("#container-concentrado").removeClass('text-danger');

            $('#info-table-result').DataTable({
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
                    { "data": "nombre_tema", className: 'text-vertical text-center' },
                    { "data": "hora_inicial", className: 'text-vertical text-center' },
                    { "data": "hora_final", className: 'text-vertical text-center' },
                    { "data": "nombreprofesor", className: 'text-vertical text-center' },
                    { "data": "nombre_modalidad", className: 'text-vertical text-center' },
                ]
            });
        } catch (error) {
            console.log(error);
        }
    }
    tablaConcentradoCartas();
});