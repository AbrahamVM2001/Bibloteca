$(function () {
    $(".btn-save-actividades").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarActividades' : 'actualizarDocumento';
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
    async function cardsActividades() {
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
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                            <img class="w-100 border-radius-md" src="${servidor}public/img/capitulo.png">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.nombre_actividad}</p>
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <button data-idactividad="${btoa(btoa(item.id_actividad))}" data-id="${btoa(btoa(item.id_asignacion_actividad))}" data-actividad="${item.nombre_actividad}" class="btn btn-info form-control btn-reasignar-actividad" ><i class="fa-solid fa-arrows-rotate"></i> Reasignar</button>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <a href="${servidor}admin/temas/${btoa(btoa(item.fk_id_fechas))}/${btoa(btoa(item.fk_id_programa))}/${btoa(btoa(item.fk_id_salon))}/${btoa(btoa(item.fk_id_capitulo))}/${btoa(btoa(item.id_actividad))}/${btoa(item.nombre_actividad)}" class="btn btn-dark form-control">Administrar <i class="fa-solid fa-gear"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).appendTo("#container-actividades");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsActividades();
    $('#asignar_actividad').change(function () {
        if ($(this).val() == "agregar_actividad") {
            $('#contenedor-agregar').removeClass('d-none');
            $('#nueva_actividad').attr('disabled', false);
            $('#nueva_actividad').attr('required', true);
        } else {
            $('#contenedor-agregar').addClass('d-none');
            $('#nueva_actividad').val("");
            $('#nueva_actividad').attr('disabled', true);
            $('#nueva_actividad').attr('required', false);
        }
    });
    async function actividades(identificador, filtro = null, actual = null) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_actividades/${salon}/${fechas}/${programa}/${capitulo}`);
            let response = await peticion.json();
            console.log(response);
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar actividad...';
            $(identificador).append(option_select);
            if (filtro == null) {
                let option_select2 = document.createElement("option")
                option_select2.value = 'agregar_actividad';
                option_select2.text = 'Crear nueva actividad';
                $(identificador).append(option_select2);
            }
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_actividad;
                option.text = item.nombre_actividad
                console.log(item.asignado);
                if (item.asignado == 1 && filtro == null) {
                    option.disabled = true;
                }
                if (actual != null) {
                    if (item.id_actividad == atob(atob(actual))) {
                        option.disabled = true;
                    }
                }
                $(identificador).append(option)
            }
            console.log('cargando actividades ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    actividades('#asignar_actividad');
    $('#container-actividades').on('click', '.btn-reasignar-actividad', function () {
        $('#actividad_seleccionado').text($(this).data('actividad'))
        $('#modalReasignar').modal('show');
        $('#id_asignacion_actividad').val($(this).data('id'))
        actividades('#reasignar_actividad','NoNulo',$(this).data('idactividad'));
    });
});