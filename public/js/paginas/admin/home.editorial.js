$(function () {
    $(".btn-evento").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            if ($('#editorial').val().length == 0) {
                Swal.fire("Por favor llenar todos los campos por favor!");
                return false;
            }else{
                if($('#id_editorial').val().length == 0){
                    $.ajax({
                        type: "POST",
                        url: servidor + "admin/RegistroEditorial",
                        dataType: "json",
                        data: new FormData(form.get(0)),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function () {
                            // setting a timeout
                            $("#loading").addClass("loading");
                        },
                        success: function (data) {
                            console.log(data);
                            Swal.fire({
                                position: "top-end",
                                icon: data.estatus,
                                title: data.titulo,
                                text: data.respuesta,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        },
                        error: function (data) {
                            console.log("Error ajax");
                            console.log(data);
                            console.log(data.log);
                        },
                        complete: function () {
                            $("#loading").removeClass("loading");
                        },
                    });
                }else {
                    $.ajax({
                        type: "POST",
                        url: servidor + "admin/actualizarEditorial",
                        dataType: "json",
                        data: new FormData(form.get(0)),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function () {
                            // setting a timeout
                            $("#loading").addClass("loading");
                        },
                        success: function (data) {
                            console.log(data);
                            Swal.fire({
                                position: "top-end",
                                icon: data.estatus,
                                title: data.titulo,
                                text: data.respuesta,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        },
                        error: function (data) {
                            console.log("Error ajax");
                            console.log(data);
                            console.log(data.log);
                        },
                        complete: function () {
                            $("#loading").removeClass("loading");
                        },
                    });
                }
            }
        }
        form.addClass("was-validated");
    });
    $("#documento").on("change", (e) => {
        const archivo = $(e.target)[0].files[0];
    
        if (archivo) {
            const nombArchivo = archivo.name;
            const extension = nombArchivo.split(".").slice(-1)[0].toLowerCase();
            const extensionesPermitidas = [".pdf"];
    
            if (extensionesPermitidas.indexOf("." + extension) === -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Extensión NO permitida',
                    text: 'Por favor, selecciona un archivo PDF.',
                });
                $("#documento").val("");
            } else {}
        }
    });
    
    async function cardsEventos() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarEditorial`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin Editoriales asignados</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            $("#container-eventos").empty();
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result">
                <thead><tr>
                <th class="text-uppercase">EDITORIAL</th>
                <th class="text-uppercase">ESTATUS</th>
                <th class="text-uppercase">ACCIONES</th>
                </tr></thead>
                </table>
                `)
                .appendTo("#container-eventos")
                .removeClass("text-danger");
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
                "pageLength": 4,
                "lengthMenu": [[4, 8, 12], [4, 8, "All"]],
                data: response,
                "columns": [
                    { "data": "Nombre", className: 'text-vertical text-center' },
                    { 
                        data: null,
                        render: function (data){
                            let tipo_estatus = (data.Estatus == 1)?'Habilitado':'Deshabilitado';
                            return tipo_estatus;
                        },
                        className: 'text-vertical text-center'
                    },
                    {
                        data: null,
                        render: function (data) {
                        botones = `<div class="col-sm-12 col-md-12 col-lg-12 col-<xl-12 d-flex justify-content-between align-items-center" >
                            <button data-id="${btoa(btoa(data.id_editorial))}" data-bs-toggle="tooltip" title="Eliminar idioma" type="button" class="btn btn-danger btn-eliminar-editorial"><i class="fa-solid fa-trash-can"></i></button>
                            </div>`;
                            return botones;
                        },
                        className: 'text-vertical text-center'
                    }
                    ],
                    createRow: function(row, data, dataIndex){
                        $(row).addClass('tr-usuario')
                    }
                });
            } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsEventos();
    $('#container-eventos').on('click', '.btn-edit-event', function () {
        $('#modalEventosLabel').text('Editar evento');
        $("#form-new-event")[0].reset();
        $('#tipo').val('editar');
        editarEvento($(this).data('id'));
    });
});
$(document).on('click', '.btn-eliminar-editorial', function() {
    var id_editorial = $(this).data('id');
    eliminarEditorial(id_editorial);
});    
function eliminarEditorial(id_editorial) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
    },
        buttonsStyling: false
    });    
    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esto",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminarlo",
        cancelButtonText: "No, cancelar",
        reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: servidor + `admin/eliminarEditorial/${id_editorial}`,
                    dataType: "json",
                    beforeSend: function () {
                        $("#loading").addClass("loading");
                    },
                    success: function (data) {
                        console.log(data);
                        swalWithBootstrapButtons.fire({
                            title: data.titulo,
                            text: data.respuesta,
                            icon: data.estatus
                        });    
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    },
                    error: function (xhr, status, error) {
                        console.log("Error ajax");
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    },
                    complete: function () {
                        $("#loading").removeClass("loading");
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "La editorial fue salvada.",
                icon: "error"
            });
        }
    });
}
$('body').on('dblclick', '#info-table-result tbody tr', function () {
    var data = $('#info-table-result').DataTable().row(this).data();
    if (data['id_editorial'] == 0) {
        registroNoEditar();
    } else {
        $("#form-idioma")[0].reset();
        $('#modalEventosLabel').text('Editar editorial');
        $('#modalEventos').modal('show');
        buscarEditorial(data['id_editorial']);
    }
});
async function buscarEditorial(id_editorial) {
    try {
        let peticion = await fetch(servidor + `admin/buscarEditorial/${id_editorial}`);
        let response = await peticion.json();
        $('#id_editorial').val(response['id_editorial']);
        $('#editorial').val(response['Nombre']);
        $('#estatus').val(response['Estatus']);
    } catch (error) {
        if (error.name == 'AbortError') { } else { throw error; }
    }
}