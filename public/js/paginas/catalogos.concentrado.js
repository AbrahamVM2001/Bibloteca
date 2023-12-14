$(function () {
    /* Guardar formularios */
    $(".btn-save").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: servidor + "catalogos/actualizarCatalogo",
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
                },
                complete: function () {
                    $("#loading").removeClass("loading");
                },
            });
        }
        form.addClass("was-validated");
    });
    /* Tablas */
    async function tablaProfesores() {
        try {
            let peticion = await fetch(servidor + `catalogos/infoProfesores`);
            let response = await peticion.json();
            $("#container-profesores").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin profesores creados</h2>`).appendTo("#container-profesores").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result-profesores">
        <thead><tr>
        <th class="text-uppercase">Profesor</th><th class="text-uppercase">Correo</th><th class="text-uppercase">Teléfono</th><th class="text-uppercase">País</th><th class="text-uppercase">Estado</th>
        </tr></thead>
        </table>`).appendTo("#container-profesores").removeClass('text-danger');

            $('#info-table-result-profesores').DataTable({
                "drawCallback": function (settings) {
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass('pull-left');
                    $('#info-table-result-profesores_filter').addClass('pull-right');
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
                    { "data": "correo_profesor", className: 'text-vertical text-center' },
                    { "data": "telefono_profesor", className: 'text-vertical text-center' },
                    { "data": "pais", className: 'text-vertical text-center' },
                    { "data": "estado", className: 'text-vertical text-center' }
                ],
                createdRow: function (row, data, dataIndex) {
                    // Agrega la clase 'miClase' a todas las filas
                    $(row).addClass('tr-profesores');
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    tablaProfesores();
    async function tablaSalones() {
        try {
            let peticion = await fetch(servidor + `catalogos/infoSalones/${programa}`);
            let response = await peticion.json();
            $("#container-salones").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin salones creados</h2>`).appendTo("#container-salones").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result-salones">
        <thead><tr>
        <th class="text-uppercase">Nombre salón</th>
        </tr></thead>
        </table>`).appendTo("#container-salones").removeClass('text-danger');

            $('#info-table-result-salones').DataTable({
                "drawCallback": function (settings) {
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass('pull-left');
                    $('#info-table-result-salones_filter').addClass('pull-right');
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
                    { "data": "nombre_salon", className: 'text-vertical text-center' }
                ],
                createdRow: function (row, data, dataIndex) {
                    // Agrega la clase 'miClase' a todas las filas
                    $(row).addClass('tr-salones');
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    tablaSalones();
    async function tablaCapitulos() {
        try {
            let peticion = await fetch(servidor + `catalogos/infoCapitulos/${programa}`);
            let response = await peticion.json();
            $("#container-capitulos").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin capítulos creados</h2>`).appendTo("#container-capitulos").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result-capitulos">
        <thead><tr>
        <th class="text-uppercase">Nombre capítulo</th>
        </tr></thead>
        </table>`).appendTo("#container-capitulos").removeClass('text-danger');

            $('#info-table-result-capitulos').DataTable({
                "drawCallback": function (settings) {
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass('pull-left');
                    $('#info-table-result-capitulos_filter').addClass('pull-right');
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
                    { "data": "nombre_capitulo", className: 'text-vertical text-center' }
                ],
                createdRow: function (row, data, dataIndex) {
                    // Agrega la clase 'miClase' a todas las filas
                    $(row).addClass('tr-capitulos');
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    tablaCapitulos();
    async function tablaActividades() {
        try {
            let peticion = await fetch(servidor + `catalogos/infoActividades/${programa}`);
            let response = await peticion.json();
            $("#container-actividades").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin actividades creadas</h2>`).appendTo("#container-actividades").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result-actividades">
        <thead><tr>
        <th class="text-uppercase">Nombre capítulo</th>
        </tr></thead>
        </table>`).appendTo("#container-actividades").removeClass('text-danger');

            $('#info-table-result-actividades').DataTable({
                "drawCallback": function (settings) {
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass('pull-left');
                    $('#info-table-result-actividades_filter').addClass('pull-right');
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
                    { "data": "nombre_actividad", className: 'text-vertical text-center' }
                ],
                createdRow: function (row, data, dataIndex) {
                    // Agrega la clase 'miClase' a todas las filas
                    $(row).addClass('tr-actividades');
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    tablaActividades();
    async function tablaTemas() {
        try {
            let peticion = await fetch(servidor + `catalogos/infoTemas/${programa}`);
            let response = await peticion.json();
            $("#container-temas").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin temas creados</h2>`).appendTo("#container-temas").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result-temas">
        <thead><tr>
        <th class="text-uppercase">Nombre tema</th>
        </tr></thead>
        </table>`).appendTo("#container-temas").removeClass('text-danger');

            $('#info-table-result-temas').DataTable({
                "drawCallback": function (settings) {
                    $('.paginate_button').addClass("btn").removeClass("paginate_button");
                    $('.dataTables_length').addClass('pull-left');
                    $('#info-table-result-temas_filter').addClass('pull-right');
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
                    { "data": "nombre_tema", className: 'text-vertical text-center' }
                ],
                createdRow: function (row, data, dataIndex) {
                    // Agrega la clase 'miClase' a todas las filas
                    $(row).addClass('tr-temas');
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
    tablaTemas();
    /* Catálogos */
    async function prefijos(identificador) {
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
                $(identificador).append(option)
            }
            console.log('cargando profesores ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    prefijos('#prefijo');
    async function ladas(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_ladas`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar lada...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_lada;
                option.text = item.numero_lada + ' - ' + item.nombre_lada
                $(identificador).append(option)
            }
            console.log('cargando ladas ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    ladas('#lada');
    async function cat_paises(identificador) {
        try {
            $("#" + identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_paises`);
            let response = await peticion.json();
            let option_select = document.createElement("option");
            option_select.value = "";
            option_select.text = "Seleccionar País...";
            $("#" + identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option");
                option.value = item.id_pais;
                option.text = item.pais;
                $("#" + identificador).append(option);
            }
            console.log("cargando países ...");
        } catch (err) {
            if (err.name == "AbortError") {
            } else {
                throw err;
            }
        }
    }
    cat_paises('pais');
    async function cat_estados(identificador, bus = null) {
        try {
            $("#" + identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_estados/${bus}`);
            let response = await peticion.json();
            /* console.log(response); */
            let option_select = document.createElement("option");
            option_select.value = "";
            option_select.text = "Seleccionar estado...";
            $("#" + identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option");
                option.value = item.id_estado;
                option.text = item.estado;
                $("#" + identificador).append(option);
            }
            console.log("cargando estados ...");
        } catch (err) {
            if (err.name == "AbortError") {
            } else {
                throw err;
            }
        }
    }
    $('#pais').change(function () {
        cat_estados('estado', $(this).val());
    })
    /* Métodos de funcionamiento */
    /* Profesores */
    $('#container-profesores').on('dblclick', '#info-table-result-profesores .tr-profesores', function () {
        var data = $('#info-table-result-profesores').DataTable().row(this).data();
        if (data['id_profesor'] == 0) {
            registroNoEditar();
        } else {
            $("#form-profesores")[0].reset();
            $('#modalProfesoresLabel').text('Editar profesor');
            $('#modalProfesores').modal('show');
            buscarProfesor(data['id_profesor']);
        }
    });
    async function buscarProfesor(idprofesor) {
        let peticion = await fetch(servidor + `catalogos/buscarProfesor/${idprofesor}`);
        let response = await peticion.json();
        cat_estados('estado', response['fk_id_pais']);
        $('#idprofesor').val(response['id_profesor']);
        $('#prefijo').val(response['fk_id_prefijo'])
        $('#nombre_profesor').val(response['nombre_profesor'])
        $('#apellidop_profesor').val(response['apellidop_profesor'])
        $('#apellidom_profesor').val(response['apellidom_profesor'])
        $('#pais').val(response['fk_id_pais'])
        setTimeout(() => {
            $('#estado').val(response['fk_id_estado'])
        }, 100);
        $('#lada').val(response['fk_id_lada'])
        $('#telefono_profesor').val(response['telefono_profesor'])
        $('#rol_profesor').val(response['rol_profesor'])
        $('#correo_profesor').val(response['correo_profesor'])
    }
    /* Salones */
    $('#container-salones').on('dblclick', '#info-table-result-salones .tr-salones', function () {
        var data = $('#info-table-result-salones').DataTable().row(this).data();
        if (data['id_salon'] == 0) {
            registroNoEditar()
        } else {
            $("#form-salones")[0].reset();
            $('#modalSalonesLabel').text('Editar salón');
            $('#modalSalones').modal('show');
            /* buscarSalon(data['id_profesor']); */
        }
    });
    async function buscarSalon(idsalon) {
        let peticion = await fetch(servidor + `catalogos/buscarSalon/${idsalon}`);
        let response = await peticion.json();
        cat_estados('estado', response['fk_id_pais']);
        $('#prefijo').val(response['fk_id_prefijo'])
        $('#nombre_profesor').val(response['nombre_profesor'])
        $('#apellidop_profesor').val(response['apellidop_profesor'])
        $('#apellidom_profesor').val(response['apellidom_profesor'])
        $('#pais').val(response['fk_id_pais'])
        setTimeout(() => {
            $('#estado').val(response['fk_id_estado'])
        }, 100);
        $('#lada').val(response['fk_id_lada'])
        $('#telefono_profesor').val(response['telefono_profesor'])
        $('#rol_profesor').val(response['rol_profesor'])
        $('#correo_profesor').val(response['correo_profesor'])
    }
    /* Capitulos */
    $('#container-capitulos').on('dblclick', '#info-table-result-capitulos .tr-capitulos', function () {
        var data = $('#info-table-result-capitulos').DataTable().row(this).data();
        if (data['id_capitulo'] == 0) {
            registroNoEditar()
        } else {
            $("#form-capitulos")[0].reset();
            $('#modalCapitulosLabel').text('Editar capítulo');
            $('#modalCapitulos').modal('show');
            /* buscarCapitulo(data['id_profesor']); */
        }
    });
    async function buscarCapitulo(idcapitulo) {
        let peticion = await fetch(servidor + `catalogos/buscarCapitulo/${idcapitulo}`);
        let response = await peticion.json();
        cat_estados('estado', response['fk_id_pais']);
        $('#prefijo').val(response['fk_id_prefijo'])
        $('#nombre_profesor').val(response['nombre_profesor'])
        $('#apellidop_profesor').val(response['apellidop_profesor'])
        $('#apellidom_profesor').val(response['apellidom_profesor'])
        $('#pais').val(response['fk_id_pais'])
        setTimeout(() => {
            $('#estado').val(response['fk_id_estado'])
        }, 100);
        $('#lada').val(response['fk_id_lada'])
        $('#telefono_profesor').val(response['telefono_profesor'])
        $('#rol_profesor').val(response['rol_profesor'])
        $('#correo_profesor').val(response['correo_profesor'])
    }
    /* Actividades */
    $('#container-actividades').on('dblclick', '#info-table-result-actividades .tr-actividades', function () {
        var data = $('#info-table-result-actividades').DataTable().row(this).data();
        if (data['id_actividad'] == 0) {
            registroNoEditar()
        } else {
            $("#form-actividades")[0].reset();
            $('#modalActividadesLabel').text('Editar actividad');
            $('#modalActividades').modal('show');
            /* buscarActividad(data['id_profesor']); */
        }
    });
    async function buscarActividad(idactividad) {
        let peticion = await fetch(servidor + `catalogos/buscarActividad/${idactividad}`);
        let response = await peticion.json();
        cat_estados('estado', response['fk_id_pais']);
        $('#prefijo').val(response['fk_id_prefijo'])
        $('#nombre_profesor').val(response['nombre_profesor'])
        $('#apellidop_profesor').val(response['apellidop_profesor'])
        $('#apellidom_profesor').val(response['apellidom_profesor'])
        $('#pais').val(response['fk_id_pais'])
        setTimeout(() => {
            $('#estado').val(response['fk_id_estado'])
        }, 100);
        $('#lada').val(response['fk_id_lada'])
        $('#telefono_profesor').val(response['telefono_profesor'])
        $('#rol_profesor').val(response['rol_profesor'])
        $('#correo_profesor').val(response['correo_profesor'])
    }
    /* Temas */
    $('#container-temas').on('dblclick', '#info-table-result-temas .tr-temas', function () {
        var data = $('#info-table-result-temas').DataTable().row(this).data();
        if (data['id_tema'] == 0) {
            registroNoEditar()
        } else {
            $("#form-temas")[0].reset();
            $('#modalTemasLabel').text('Editar tema');
            $('#modalTemas').modal('show');
            /* buscarTema(data['id_profesor']); */
        }
    });
    async function buscarTema(idactividad) {
        let peticion = await fetch(servidor + `catalogos/buscarTema/${idactividad}`);
        let response = await peticion.json();
        cat_estados('estado', response['fk_id_pais']);
        $('#prefijo').val(response['fk_id_prefijo'])
        $('#nombre_profesor').val(response['nombre_profesor'])
        $('#apellidop_profesor').val(response['apellidop_profesor'])
        $('#apellidom_profesor').val(response['apellidom_profesor'])
        $('#pais').val(response['fk_id_pais'])
        setTimeout(() => {
            $('#estado').val(response['fk_id_estado'])
        }, 100);
        $('#lada').val(response['fk_id_lada'])
        $('#telefono_profesor').val(response['telefono_profesor'])
        $('#rol_profesor').val(response['rol_profesor'])
        $('#correo_profesor').val(response['correo_profesor'])
    }
    function registroNoEditar() {
        Swal.fire({
            icon: 'warning',
            title: 'Registro no editable',
            text: 'El registro seleccionado no se puede editar.',
            showConfirmButton: false,
            timer: 2000,
        });
    }
});
