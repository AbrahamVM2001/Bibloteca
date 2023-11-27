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
                    <a href="${servidor}admin/actividades/${btoa(btoa(item.fk_id_fechas))}/${btoa(btoa(item.fk_id_programa))}/${btoa(btoa(item.fk_id_salon))}/${btoa(btoa(item.fk_id_capitulo))}/${btoa(btoa(item.id_actividad))}" class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
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
    }
    cardsActividades();
    $('#asignar_actividad').change(function(){
        if ($(this).val() == "agregar_actividad") {
            $('#contenedor-agregar').removeClass('d-none');
            $('#nueva_actividad').attr('disabled',false);
            $('#nueva_actividad').attr('required',true);
        }else{
            $('#contenedor-agregar').addClass('d-none');
            $('#nueva_actividad').val("");
            $('#nueva_actividad').attr('disabled',true);
            $('#nueva_actividad').attr('required',false);
        }
    });
    async function actividades(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_actividades/${salon}/${fechas}/${programa}/${capitulo}`);
            let response = await peticion.json();
            console.log(response);
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar actividad...';
            let option_select2 = document.createElement("option")
            option_select2.value = 'agregar_actividad';
            option_select2.text = 'Crear nueva actividad';
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
            console.log('cargando actividades ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    actividades('#asignar_actividad');






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