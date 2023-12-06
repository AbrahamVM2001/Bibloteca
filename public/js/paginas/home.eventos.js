$(function () {
    $(".btn-evento").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: servidor + "admin/guardarEvento",
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
    async function cardsEventos() {
        try {
            let peticion = await fetch(servidor + `admin/eventos`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin eventos asignados</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3 h-100">
                                    <img class="w-100 border-radius-md" src="${servidor}public/img/calendario.gif">
                                <h5 class="mt-3 mb-1 d-md-block ">${item.nombre_evento}</h5>
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.descripcion_evento}</p>
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <button data-id="${btoa(btoa(item.id_evento))}" class="btn btn-info form-control btn-edit-event"><i class="fa-solid fa-edit"></i> Editar</button>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                        <a href="${servidor}admin/programas/${btoa(btoa(item.id_evento))}/${btoa(item.nombre_evento)}" class="btn btn-dark form-control">Administrar <i class="fa-solid fa-gear"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).appendTo("#container-eventos");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsEventos();
    $('.btn-agregar-evento').click(function(){
        $('#modalEventosLabel').text('Crear nuevo evento');
        $('#id_evento').val('')
        $("#form-new-event")[0].reset();
        $('#tipo').val('nuevo');
    });
    $('#container-eventos').on('click','.btn-edit-event',function(){
        $('#modalEventosLabel').text('Editar evento');
        $("#form-new-event")[0].reset();
        $('#tipo').val('editar');
        editarEvento($(this).data('id'));
    });
    async function editarEvento(idevento){
        let peticion = await fetch(servidor + `admin/buscarEvento/${idevento}`);
        let response = await peticion.json();
        console.log(response);
        $('#nombre_evento').val(response['nombre_evento']);
        $('#descripcion_evento').val(response['descripcion_evento']);
        $('#fecha_inicio').val(response['fecha_inicio_evento']);
        $('#fecha_fin').val(response['fecha_fin_evento']);
        $('#id_evento').val(response['id_evento'])
        $('#modalEventos').modal('show');
    }
});