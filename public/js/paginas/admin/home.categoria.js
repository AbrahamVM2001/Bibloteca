$(function () {
    $(".btn-evento").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            if ($('#categoria').val().length == 0) {
                Swal.fire("Por favor llenar todos los campos por favor!");
                return false;
            }else{
                if($('#id_categoria').val().length == 0){
                    $.ajax({
                        type: "POST",
                        url: servidor + "admin/RegistroCategoria",
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
                        url: servidor + "admin/actualizarCategoria",
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
    async function cardsEventos() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarCategoria`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin categorias para mostrar</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            $("#container-eventos").empty();
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result">
                <thead><tr>
                <th class="text-uppercase">CATEGORIA</th>
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
                    { "data": "Categoria", className: 'text-vertical text-center' },
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
                            <button data-id="${btoa(btoa(data.id_categoria))}" data-bs-toggle="tooltip" title="Eliminar idioma" type="button" class="btn btn-danger btn-eliminar-categoria"><i class="fa-solid fa-trash-can"></i></button>
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
    $(document).on('click', '.btn-eliminar-categoria', function() {
        var id_categoria = $(this).data('id');
        eliminarCategoria(id_categoria);
    });    
    function eliminarCategoria(id_categoria) {
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
                        url: servidor + `admin/eliminarCategoria/${id_categoria}`,
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
                    text: "La categoria fue salvado.",
                    icon: "error"
                });
            }
        });
    }
    $('body').on('dblclick', '#info-table-result tbody tr', function () {
        var data = $('#info-table-result').DataTable().row(this).data();
        if (data['id_categoria'] == 0) {
            registroNoEditar();
        } else {
            $("#form-new-event")[0].reset();
            $('#modalEventosLabel').text('Editar idioma');
            $('#modalEventos').modal('show');
            buscarCategoria(data['id_categoria']);
        }
    });
    async function buscarCategoria(id_categoria) {
        try {
            let peticion = await fetch(servidor + `admin/buscarCategoria/${id_categoria}`);
            let response = await peticion.json();
            $('#id_categoria').val(response['id_categoria']);
            $('#categoria').val(response['Categoria']);
            $('#estatus').val(response['Estatus']);
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
});