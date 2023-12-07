$(function () {
    $(".btn-save-salones").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarSalones' : 'actualizarDocumento';
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
    async function cardsSalones() {
        try {
            let peticion = await fetch(servidor + `admin/infoSalones/${fechas}`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin salones asignados</h3>`).appendTo("#container-salones").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                            <img class="w-100 border-radius-md" src="${servidor}public/img/salon.gif">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.nombre_salon}</p>
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <button data-idsalon="${btoa(btoa(item.id_salon))}" data-id="${btoa(btoa(item.id_asignacion_salon))}" data-salon="${item.nombre_salon}" class="btn btn-info form-control btn-reasignar-salon" ><i class="fa-solid fa-arrows-rotate"></i> Reasignar</button>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <a href="${servidor}admin/capitulos/${btoa(btoa(item.fk_id_fechas))}/${btoa(btoa(item.fk_id_programa))}/${btoa(btoa(item.id_salon))}/${btoa(item.nombre_salon)}" class="btn btn-dark form-control">Administrar <i class="fa-solid fa-gear"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).appendTo("#container-salones");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsSalones();
    $('#asignar_salon').change(function () {
        if ($(this).val() == "agregar_salon") {
            $('#contenedor-agregar').removeClass('d-none');
            $('#nuevo_salon').attr('disabled', false);
            $('#nuevo_salon').attr('required', true);
        } else {
            $('#contenedor-agregar').addClass('d-none');
            $('#nuevo_salon').val("");
            $('#nuevo_salon').attr('disabled', true);
            $('#nuevo_salon').attr('required', false);
        }
    });
    async function salones(identificador, filtro = null, actual = null) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_salones/${fechas}/${programa}`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar salón...';
            $(identificador).append(option_select);
            if (filtro == null) {
                let option_select2 = document.createElement("option")
                option_select2.value = 'agregar_salon';
                option_select2.text = 'Crear nuevo salón';
                $(identificador).append(option_select2);
            }
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_salon;
                option.text = item.nombre_salon
                if (item.asignado == 1 && filtro == null) {
                    option.disabled = true;
                }
                if (actual != null) {
                    if (item.id_salon == atob(atob(actual))) {
                        option.disabled = true;
                    }
                }
                $(identificador).append(option)
            }
            console.log('cargando salones ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    salones('#asignar_salon');
    $('#container-salones').on('click', '.btn-reasignar-salon', function () {
        $('#salon_seleccionado').text($(this).data('salon'))
        $('#modalReasignar').modal('show');
        $('#id_asignacion_salon').val($(this).data('id'))
        salones('#reasignar_salon', 'NoNulo', $(this).data('idsalon'));
    });
    async function editarSalon(idsalon) {
        let peticion = await fetch(servidor + `admin/buscarSalon/${idsalon}`);
        let response = await peticion.json();
        console.log(response);
        $('#nombre_evento').val(response['nombre_evento']);
        $('#descripcion_evento').val(response['descripcion_evento']);
        $('#fecha_inicio').val(response['fecha_inicio_evento']);
        $('#fecha_fin').val(response['fecha_fin_evento']);
        $('#id_salon').val(response['id_evento'])
        $('#modalEventos').modal('show');
    }
    /* 
        Nos quedamos pendiente en está sección
        Preguntar si es mejor reasignar o editar el salón seleccionado, esto por si es un salón sin asignación
    */
});