$(function () {
    $(".btn-evento").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            if ($('#id_autor').val().length == 0) {
                if ($('#nombre').val().length == 0 || $('#APaterno').val().length == 0 || $('#biblografia').val().length == 0 || $('#foto').val().length == 0 || $('#estatus').val().length == 0) {
                    Swal.fire("Por favor llenar todos los campos por favor!");
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: servidor + "admin/RegistroAutor",
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
                            console.log(data.log);
                        },
                        complete: function () {
                            $("#loading").removeClass("loading");
                        },
                    });
                }
            }else{
                $.ajax({
                    type: "POST",
                    url: servidor + "admin/actualizarAutor",
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
                        console.log(data.log);
                    },
                    complete: function () {
                        $("#loading").removeClass("loading");
                    },
                });
            }
        }
        form.addClass("was-validated");
    });
    $("#foto").on("change", (e) => {
        const archivo = $(e.target)[0].files[0];
    
        if (archivo) {
            const nombArchivo = archivo.name;
            const extension = nombArchivo.split(".").slice(-1)[0].toLowerCase();
            const extensionesPermitidas = [".jpg"];
    
            if (extensionesPermitidas.indexOf("." + extension) === -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Extensión NO permitida',
                    text: 'Por favor, selecciona un archivo .jpg',
                });
                $("#foto").val("");
            } else {}
        }
    });
    
    async function cardsEventos() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarAutor`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin autores asignados</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <div class="col-md-4">
                        <div class="card profile-card-3">
                            <div class="background-block">
                                <img src="${servidor}public/img/fondo_card.jpg" alt="profile-sample1" class="background"/>
                            </div>
                            <div class="profile-thumb-block">
                                <img src="${servidor}${item.Foto}" alt="profile-image" class="profile img-thumbnail"/>
                            </div>
                            <div class="card-content">
                                <h2>${item.Nombre + " " + item.Apellido_paterno + " " + item.Apellido_materno} <small>${item.Resumen_biblografia}</small></h3>
                            <div class="row">
                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-6">
                                        <button data-id="${btoa(btoa(item.id_autor))}" class="btn btn-info form-control btn-editar">Editar</button>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <button data-id="${btoa(btoa(item.id_autor))}" class="btn btn-danger form-control btn-borrar">Borrar</button>
                                    </div>
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
    $(document).on('click', '.btn-borrar', function() {
        var id_autor = $(this).data('id');
        eliminarAutor(id_autor);
    });    
    function eliminarAutor(id_autor) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
            buttonsStyling: false
        });    
        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro?",
            text: "No podrás revertir esto",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminarlo",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: servidor + `admin/eliminarAutor/${id_autor}`,
                        dataType: "json",
                        beforeSend: function () {
                            $("#loading").addClass("loading");
                        },
                        success: function (data) {
                            console.log(data);
                            swalWithBootstrapButtons.fire({
                                title: data.titulo,
                                text: data.respuesta,
                                icon: data.estatus
                            });    
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        },
                        error: function (xhr, status, error) {
                            console.log("Error ajax");
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        },
                        complete: function () {
                            $("#loading").removeClass("loading");
                        },
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "El autor fue salvado correctamente. ",
                    icon: "error"
                });
            }
        });
    }
    $(document).on('click', '.btn-editar', function() {
        $("#form-new-event")[0].reset();
        $('#modalEventosLabel').text('Actualizar Autor');
        $('#modalEventos').modal('show');
        buscarAutor($(this).data('id'));
    });
    
    async function buscarAutor(id_autor){
        let peticion = await fetch(servidor + `admin/buscarAutor/${id_autor}`);
        let response = await peticion.json();
        console.log(response);
        $('#id_autor').val(response['id_autor']);
        $('#nombre').val(response['Nombre']);
        $('#APaterno').val(response['Apellido_paterno']);
        $('#AMaterno').val(response['Apellido_materno']);
        $('#biblografia').val(response['Resumen_biblografia']);
        $('#estatus').val(response['Estatus']);
        $('#modalEventos').modal('show');
    }
    
    function actualizarAutor(formData) {
        if ($('#nombre').val().length == 0 || $('#APaterno').val().length == 0 || $('#AMaterno').val().length == 0 || $('#biblografia').val().length == 0 || $('#estatus').val().length == 0) {
            Swal.fire("Por favor llenar todos los campos por favor!");
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: servidor + 'admin/actualizarAutor',
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function () {
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
                error: function (xhr, status, error) {
                    console.log("Error ajax");
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                },
                complete: function () {
                    $("#loading").removeClass("loading");
                },
            });
        }
    }
});