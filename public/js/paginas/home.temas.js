$(function () {
    $(".btn-save-temas").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarTemas' : 'actualizarDocumento';
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: servidor + "admin/" + url,
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
        form.addClass("was-validated");
    });
    async function tablaTemas() {
        try {
            let peticion = await fetch(servidor + `admin/infoTemas/${fechas}/${salon}/${capitulo}/${actividad}`);
            let response = await peticion.json();
            $("#container-temas").empty();
            if (response.length == 0) {
                jQuery(`<h2>Sin temas asignados</h2>`).appendTo("#container-temas").addClass('text-danger text-center text-uppercase');
                return false;
            }
            jQuery(`<table class="table align-items-center mb-0 table table-striped table-bordered" style="width:100%" id="info-table-result">
            <thead><tr>
            <th class="text-uppercase">Tema</th><th class="text-uppercase">Hora inicial</th><th class="text-uppercase">Horal final</th><th class="text-uppercase">Profesor</th><th class="text-uppercase">Modalidad</th>
            </tr></thead>
            </table>`).appendTo("#container-temas").removeClass('text-danger');

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
    tablaTemas();
    /* async function cardsActividades() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `admin/infoActividades/${fechas}/${salon}/${capitulo}`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin actividades asignadas</h3>`).appendTo("#container-actividades").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}admin/temas/${btoa(btoa(item.fk_id_fechas))}/${btoa(btoa(item.fk_id_programa))}/${btoa(btoa(item.fk_id_salon))}/${btoa(btoa(item.fk_id_capitulo))}/${btoa(btoa(item.id_actividad))}" class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                            <img class="w-100 border-radius-md" src="${servidor}public/img/capitulo.png">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.nombre_actividad}</p>
                            </div>
                        </div>
                    </a>
                `).appendTo("#container-actividades");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    } */
    //cardsActividades();
    $('#asignar_tema').change(function(){
        if ($(this).val() == "agregar_tema") {
            $('#contenedor-agregar').removeClass('d-none');
            $('#nuevo_tema').attr('disabled',false);
            $('#nuevo_tema').attr('required',true);
        }else{
            $('#contenedor-agregar').addClass('d-none');
            $('#nuevo_tema').val("");
            $('#nuevo_tema').attr('disabled',true);
            $('#nuevo_tema').attr('required',false);
        }
    });
    async function temas(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_temas/${fechas}/${salon}/${capitulo}/${actividad}/${programa}`);
            let response = await peticion.json();
            console.log(response);
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar actividad...';
            let option_select2 = document.createElement("option")
            option_select2.value = 'agregar_tema';
            option_select2.text = 'Crear nuevo tema';
            $(identificador).append(option_select);
            $(identificador).append(option_select2);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_actividad;
                option.text = item.nombre_actividad
                console.log(item.asignado);
                if (item.asignado == 1) {
                    option.disabled = true;
                }
                $(identificador).append(option)
            }
            console.log('cargando temas ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    temas('#asignar_tema');
    async function profesores(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_profesores`);
            let response = await peticion.json();
            console.log(response);
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar profesor...';
            let option_select2 = document.createElement("option")
            option_select2.value = 'agregar_profesor';
            option_select2.text = 'Crear nuevo profesor';
            $(identificador).append(option_select);
            $(identificador).append(option_select2);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_profesor;
                option.text = item.profesor + ' - (' + item.pais + '/' + item.nombre_estado + ')'
                $(identificador).append(option)
            }
            console.log('cargando profesores ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    profesores('#profesor');
    async function modalidades(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_modalidades`);
            let response = await peticion.json();
            console.log(response);
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar modalidad...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_modalidad;
                option.text = item.nombre_modalidad
                $(identificador).append(option)
            }
            console.log('cargando profesores ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    modalidades('#modalidad');





    $('#add-document').click(function () {
        $('#documento').attr('required', true);
        $('#nombre_documento').val('');
        $('#id_documento').val('');
        $('#documento_ant').val('');
        $('.btn-save').attr('data-tipo','nuevo').text('Guardar');
        $('#exampleModalToggleLabel').text('Agregar documento');
    });
    $('#container-actividades').on('click', '.edit-document', async function () {
        $('#documento').attr('required', false);
        let peticion = await fetch(servidor + `admin/getDocumento/${$(this).data('doc')}`);
        let response = await peticion.json();
        console.log(response);
        $('#nombre_documento').val(response.nombre_documento);
        $('#id_documento').val(response.id_documento);
        $('#documento_ant').val(response.ruta_documento);
        $('.btn-save').attr('data-tipo','editar').text('Actualizar');
        $('#exampleModalToggleLabel').text('Editar documento');
    });



    /* Copiar al portapapeles */
    var clipboard = new Clipboard('.copy');
    clipboard.on('success', function (e) {
        console.log(e);
        console.log(e.trigger.id);
        $('#copiado-' + e.trigger.id).removeClass('d-none').fadeOut(1600);
        setTimeout(() => {
            $('#copiado-' + e.trigger.id).addClass('d-none');
            $('#copiado-' + e.trigger.id).attr('style', '');
        }, 1700);
    });
    clipboard.on('error', function (e) {
        /* console.log(e); */
    });
});