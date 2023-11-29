$(function () {
    $(".btn-save-capitulos").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarCapitulos' : 'actualizarDocumento';
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
    async function cardsCapitulos() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `admin/infoCapitulos/${fechas}/${salon}`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin capitulos asignados</h3>`).appendTo("#container-capitulos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}admin/actividades/${btoa(btoa(item.fk_id_fechas))}/${btoa(btoa(item.fk_id_programa))}/${btoa(btoa(item.fk_id_salon))}/${btoa(btoa(item.id_capitulo))}/${btoa(item.nombre_capitulo)}" class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                            <img class="w-100 border-radius-md" src="${servidor}public/img/capitulo.png">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.nombre_capitulo}</p>
                            </div>
                        </div>
                    </a>
                `).appendTo("#container-capitulos");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsCapitulos();
    $('#asignar_capitulo').change(function(){
        if ($(this).val() == "agregar_capitulo") {
            $('#contenedor-agregar').removeClass('d-none');
            $('#nuevo_capitulo').attr('disabled',false);
            $('#nuevo_capitulo').attr('required',true);
        }else{
            $('#contenedor-agregar').addClass('d-none');
            $('#nuevo_capitulo').val("");
            $('#nuevo_capitulo').attr('disabled',true);
            $('#nuevo_capitulo').attr('required',false);
        }
    });
    async function capitulos(identificador) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/cat_capitulos/${salon}/${fechas}/${programa}`);
            let response = await peticion.json();
            console.log(response);
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar capitulo...';
            let option_select2 = document.createElement("option")
            option_select2.value = 'agregar_capitulo';
            option_select2.text = 'Crear nuevo capitulo';
            $(identificador).append(option_select);
            $(identificador).append(option_select2);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_capitulo;
                option.text = item.nombre_capitulo
                console.log(item.asignado);
                if (item.asignado == 1) {
                    option.disabled = true;
                }
                $(identificador).append(option)
            }
            console.log('cargando capitulos ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    capitulos('#asignar_capitulo');
});