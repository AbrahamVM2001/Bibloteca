$(function () {
    $(".btn-evento").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            if ($('#prefijo').val().length == 0 || $('#nombre').val().length == 0 || $('#APaterno').val().length == 0 || $('#estado').val().length == 0 || $('#email').val().length == 0 || $('#pais').val().length == 0 || $('#titulo_documento').val().length == 0 || $('#documento').val().length == 0) {
                Swal.fire("Por favor llenar todos los campos por favor!");
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: servidor + "admin/guardarEvento",
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
                        /* console.log(data.log); */
                    },
                    complete: function () {
                        $("#loading").removeClass("loading");
                    },
                });
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
            let peticion = await fetch(servidor + `admin/eventos`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin eventos asignados</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            $("#container-eventos").empty();
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result">
                <thead><tr>
                <th class="text-uppercase">NOMBRE COMPLETO</th>
                <th class="text-uppercase">CORREO</th>
                <th class="text-uppercase">PAIS</th>
                <th class="text-uppercase">NUMERO</th>
                <th class="text-uppercase">ESTADO</th>
                <th class="text-uppercase">DOCUMENTO</th>
                <th class="text-uppercase">Acciones</th>
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
                    // { "data": "idUsuario", className: 'text-vertical text-center' },
                    /* { "data": "nombre_completo", className: 'text-vertical text-center' }, */
                    {
                        data: null,
                        render: function (data) {
                            let prefijo;
                            switch (data.prefijo) {
                            case '1':prefijo = 'SP.'; break;
                            case '2':prefijo = 'Dr.'; break;
                            case '3':prefijo = 'Dra.'; break;
                            case '4':prefijo = 'Lic.'; break;
                            case '5':prefijo = 'Dr. Rehab.'; break;
                            case '6':prefijo = 'Dra. Rehab.'; break;
                            case '7':prefijo = 'Enf.'; break;
                            case '8':prefijo = 'Ing.'; break;
                            default:prefijo ='Mtf.'; break;
                        }
                        nombre = `${prefijo} ${(data.nombre != null)?data.nombre:''} ${data.apellido_paterno} ${data.apellido_materno}`;
                        return nombre;
                    },
                    className: 'text-vertical text-center'
                },
                { "data": "correo", className: 'text-vertical text-center' },
                { "data": "pais", className: 'text-vertical text-center' },
                { "data": "numero", className: 'text-vertical text-center' },
                { "data": "estado", className: 'text-vertical text-center' },
                { "data": "titulo_documento", className: 'text-vertical text-center' },
                {
                    data: null,
                    render: function (data) {
                        botones = `<div class="col-sm-12 col-md-12 col-lg-12 col-<xl-12 d-flex justify-content-between align-items-center" >
                            <button data-id="${btoa(btoa(data.idUsuario))}" data-bs-toggle="tooltip" title="Eliminar Usuario" type="button" class="btn btn-danger btn-eliminar-usuario"><i class="fa-solid fa-trash-can"></i></button>
                            <button data-id="${btoa(btoa(data.idUsuario))}" data-bs-toggle="tooltip" title="Visualizar documento" type="button" class="btn btn-info btn-descargar"><i class="fa-solid fa-file-alt"></i></button>
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
    /* Cargar catalogo de prefijos */
    async function prefijos(identificador, actual = null) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_prefijos`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar prefijo...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_prefijo;
                option.text = item.siglas_prefijo + ' - ' + item.nombre_prefijo
                if (actual != null) {
                    if (item.id_prefijo == actual) {
                        option.selected = true;
                    }
                }
                $(identificador).append(option)
            }
            console.log('cargando prefijos ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    /* catalogo de paises */

    prefijos('#prefijo', actual = null)
        $('.btn-agregar-evento').click(function () {
        $('#modalEventosLabel').text('Crear nuevo evento');
        $('#id_evento').val('')
        $("#form-new-event")[0].reset();
        $('#tipo').val('nuevo');
    });
    $('#container-eventos').on('click', '.btn-edit-event', function () {
        $('#modalEventosLabel').text('Editar evento');
        $("#form-new-event")[0].reset();
        $('#tipo').val('editar');
        editarEvento($(this).data('id'));
    });
});
$(document).on('click', '.btn-eliminar-usuario', function() {
    var idUsuario = $(this).data('id');
    eliminarUsuario(idUsuario);
});    
function eliminarUsuario(idUsuario) {
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
            url: servidor + `admin/eliminarUsuario/${idUsuario}`,
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
            text: "Tu archivo imaginario está a salvo :)",
            icon: "error"
        });
    }
    });
}
    $('body').on('dblclick', '#info-table-result tbody tr', function () {
        var data = $('#info-table-result').DataTable().row(this).data();
        if (data['idUsuario'] == 0) {
            registroNoEditar();
        } else {
            $("#form-usuario")[0].reset();
            $('#modalUsuarioLabel').text('Editar usuario');
            $('#modalUsuario').modal('show');
            buscarUsuario(data['idUsuario']);
        }
    });
    async function buscarUsuario(idUsuario) {
        try {
            let peticion = await fetch(servidor + `admin/buscarUsuario/${idUsuario}`);
            let response = await peticion.json();
            $('#ac_id_usuario').val(response['idUsuario']);
            $('#ac_prefijo').val(response['prefijo']);
            $('#ac_nombre').val(response['nombre']);
            $('#ac_apellido_paterno').val(response['apellido_paterno']);
            $('#ac_apellido_materno').val(response['apellido_materno']);
            $('#ac_pais').val(response['pais']);
            $('#ac_estado').val(response['estado']);
            $('#ac_numero').val(response['numero']);
            $('#ac_correo').val(response['correo']);
            $('#ac_documento').val(response['nombre_documento']);
            $('#ac_nombreDocumento').val(response['titulo_documento']);
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    $(document).on('click', '.btn-actualizar-usuario', function() {
        var idUsuario = $(this).data('id');
        var formData = new FormData($('#form-usuario')[0]);
        formData.append('idUsuario', idUsuario);
    
        console.log(formData);
        actualizarUsuario(formData);
    });
    
    function actualizarUsuario(formData) {
        if ($('#ac_nombre').val().length == 0 || $('#ac_apellido_paterno').val().length == 0 || $('#ac_correo').val().length == 0 || $('#ac_pais').val().length == 0 || $('#ac_estado').val().length == 0 || $('#ac_nombreDocumento').val().length == 0) {
            Swal.fire("Por favor llenar todos los campos por favor!");
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: servidor + 'admin/actualizarUsuario',
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function () {
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
    }
    $("#ac_documento").on("change", (e) => {
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
    }
    $(document).on('click', '.btn-descargar', function() {
        var idUsuario = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'admin/obtenerDocumentoPorId',
            data: { idUsuario: idUsuario },
            dataType: 'json',
            success: function(response) {
            if (response.error) {
                alert('Error: ' + response.error);
            } else {
                if (response.tipo === 'pdf') {
                    window.open(atob(response.enlace), '_blank');
                } else if (response.tipo === 'descarga') {
                    window.location.href = response.path;
                } else {
                    alert('Tipo de documento no reconocido');
                }
            }
        },
        error: function() {
        alert('Error al comunicarse con el servidor');
        }
    });
});