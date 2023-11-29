$(function () {
    $(".btn-save-fechas").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarFechas' : 'actualizarDocumento';
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
    async function cardsFechas() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `admin/infoFechas/${fechas}`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin fechas asignadas</h3>`).appendTo("#container-fechas").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}admin/salones/${btoa(btoa(item.id_fecha_programa))}/${btoa(btoa(item.fk_id_programa))}/${btoa(item.fecha_programa)}" class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.fecha_programa}</p>
                            </div>
                        </div>
                    </a>
                `).appendTo("#container-fechas");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsFechas();
});