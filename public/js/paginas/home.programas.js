$(function () {
    $(".btn-save-programa").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        let tipo_form = $(this).data("tipo");
        let url = (tipo_form == 'nuevo') ? 'guardarPrograma' : 'actualizarDocumento';
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
    async function cardsProgramas() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `admin/infoProgramas/${evento}`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin programas disponibles</h3>`).appendTo("#container-programas").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                            <img class="w-100 border-radius-md" src="${servidor}public/img/libro.gif">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.nombre_programa}</p>
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <button data-id="${btoa(btoa(item.id_programa))}" class="btn btn-info form-control btn-edit-event"><i class="fa-solid fa-edit"></i> Editar</button>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="${servidor}admin/fechas/${btoa(btoa(item.id_programa))}/${btoa(item.nombre_programa)}" class="btn btn-dark form-control">Administrar <i class="fa-solid fa-gear"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).appendTo("#container-programas");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsProgramas();
    $('.btn-agregar-programa').click(function(){
        $('#modalNuevoProgramaLabel').text('Agregar nuevo programa');
        $('#id_programa').val('')
        $("#form-programa")[0].reset();
        $('#tipo').val('nuevo');
    });
    $('#container-programas').on('click','.btn-edit-event',function(){
        $('#modalNuevoProgramaLabel').text('Editar programa');
        $("#form-programa")[0].reset();
        $('#tipo').val('editar');
        editarPrograma($(this).data('id'));
    });
    async function editarPrograma(idprograma){
        let peticion = await fetch(servidor + `admin/buscarPrograma/${idprograma}`);
        let response = await peticion.json();
        console.log(response);
        $('#nombre_programa').val(response['nombre_programa']);
        $('#id_programa').val(response['id_programa'])
        $('#modalNuevoPrograma').modal('show');
    }
});