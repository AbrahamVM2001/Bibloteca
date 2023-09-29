$(function () {
    $(".btn-save").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'subirDocumento' : 'actualizarDocumento';
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
    async function cardsDocumentos() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `admin/infoDocumentos/${atob(atob(rev))}`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin documentos disponibles</h3>`).appendTo("#container-documentos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                                    <img class="w-100 border-radius-md" src="${servidor}${item.codigo_qr}">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.nombre_documento}</p>
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <p class="d-none" id="copiado-${item.id_revista}">Copiado!</p>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <button id="${item.id_revista}" data-clipboard-action="copy" data-clipboard-text="${item.liga_documento}" class="btn btn-secondary form-control copy"><i class="fa-solid fa-link"></i></button>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="${servidor}${item.codigo_qr}" id="${item.id_revista}" class="btn btn-dark form-control copy" download><i class="fa-solid fa-qrcode"></i></a>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <button data-doc="${item.id_documento}" class="btn btn-info form-control edit-document" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="${servidor}${item.ruta_documento}" class="btn btn-danger form-control delete-document" download><i class="fa-solid fa-file-pdf"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).appendTo("#container-documentos");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsDocumentos();
    $('#add-document').click(function () {
        $('#documento').attr('required', true);
        $('#nombre_documento').val('');
        $('#id_documento').val('');
        $('#documento_ant').val('');
        $('.btn-save').attr('data-tipo','nuevo').text('Guardar');
        $('#exampleModalToggleLabel').text('Agregar documento');
    });
    $('#container-documentos').on('click', '.edit-document', async function () {
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