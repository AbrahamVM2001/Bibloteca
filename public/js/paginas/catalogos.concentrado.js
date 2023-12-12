$(function () {
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
                ]
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
                ]
            });
        } catch (error) {
            console.log(error);
        }
    }
    /* tablaSalones(); */
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
    /* Métodos de funcionamiento */
    /* Profesores */
    $('body').on('dblclick', '#info-table-result-profesores tbody tr', function () {
        var data = $('#info-table-result-profesores').DataTable().row(this).data();
        $("#form-profesores")[0].reset();
        $('#modalProfesoresLabel').text('Editar profesor');
        $('#modalProfesores').modal('show');
        buscarProfesor(data['id_profesor']);
    });
    async function buscarProfesor(idprofesor) {
        let peticion = await fetch(servidor + `catalogos/buscarProfesor/${idprofesor}`);
        let response = await peticion.json();
        cat_estados('estado',response['fk_id_pais']);
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
    $('body').on('dblclick', '#info-table-result-salones tbody tr', function () {
        var data = $('#info-table-result-salones').DataTable().row(this).data();
        $("#form-profesores")[0].reset();
        $('#modalProfesoresLabel').text('Editar profesor');
        $('#modalProfesores').modal('show');
        buscarProfesor(data['id_profesor']);
    });
    async function buscarProfesor(idprofesor) {
        let peticion = await fetch(servidor + `catalogos/buscarProfesor/${idprofesor}`);
        let response = await peticion.json();
        cat_estados('estado',response['fk_id_pais']);
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
});
