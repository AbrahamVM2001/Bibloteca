$(function () {
    async function tablaEstadisticas() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `admin/infoEstadisticas`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase"></h3>`).appendTo("#container-estadisticas").addClass('text-danger');
                return false;
            }
            $("#container-estadisticas").empty();
            if (response.length == 0) {
                jQuery(`<h2>No existe información aún</h2>`).appendTo("#container-estadisticas").addClass('text-danger');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered"  id="info-table-result">
            <thead><tr>
            <th class="text-uppercase">Documento</th><th class="text-uppercase">Visitas por QR</th><th class="text-uppercase">Visitas por Link</th>
            </tr></thead>
            </table>`).appendTo("#container-estadisticas").removeClass('text-danger');

            $('#info-table-result').DataTable({
                "drawCallback": function (settings) {
                    $('.current').addClass("btn bg-gradient-pink text-white btn-rounded").removeClass("paginate_button");
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass("m-4");
                    $('.dataTables_info').addClass("mx-4");
                    $('.dataTables_filter').addClass("m-4");
                    $('input').addClass("form-control");
                    $('select').addClass("form-control");
                    $('.previous.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2");
                    $('.next.disabled').addClass("btn-outline-info opacity-5 btn-rounded mx-2");
                    $('.previous').addClass("btn-outline-info btn-rounded mx-2");
                    $('.next').addClass("btn-outline-info btn-rounded mx-2");
                    $('a.btn').addClass("btn-rounded");
                    tooltipsButton();
                },
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                "pageLength": 5,
                "lengthMenu": [[5, 10, -1], [5, 10, "All"]],
                data: response,
                "columns": [
                    {
                        data: null,
                        render: function (data) {
                            return data.nombre_documento;
                        },
                        className: 'text-vertical text-center'
                    },
                    {
                        data: null,
                        render: function (data) {
                            return data.conteo_qr;
                        },
                        className: 'text-vertical text-center'
                    },
                    {
                        data: null,
                        render: function (data) {
                            return data.conteo_link;
                        },
                        className: 'text-vertical text-center'
                    }
                ]
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    tablaEstadisticas();
});