$(function () {
    $(".btn-evento").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            if ($('#id_libro').val().length == 0) {
                if ($('#titulo').val().length == 0 || $('#Numero_pagina').val().length == 0 || $('#fecha_publicacion').val().length == 0 || $('#palabra_clave').val().length == 0 || $('#estatus').val().length == 0 || $('#documento').val().length == 0 || $('#portada').val().length == 0 || $('#descripcion').val().length == 0) {
                    Swal.fire("Por favor llenar todos los campos por favor!");
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: servidor + "admin/RegistroLibro",
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
                if ($('#titulo').val().length == 0 || $('#Numero_pagina').val().length == 0 || $('#fecha_publicacion').val().length == 0  || $('#palabra_clave').val().length == 0 || $('#estatus').val().length == 0 || $('#descripcion').val().length == 0) {
                    Swal.fire("Por favor llenar todos los campos por favor!");
                    return false;
                }else{
                    $.ajax({
                        type: "POST",
                        url: servidor + "admin/actualizarLibro",
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
        }
        form.addClass("was-validated");
    });
    $("#portada").on("change", (e) => {
        const archivo = $(e.target)[0].files[0];
    
        if (archivo) {
            const nombArchivo = archivo.name;
            const extension = nombArchivo.split(".").slice(-1)[0].toLowerCase();
            const extensionesPermitidas = [".jpg"];
    
            if (extensionesPermitidas.indexOf("." + extension) === -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Extensión NO permitida',
                    text: 'Por favor, selecciona un archivo jpg.',
                });
                $("#portada").val("");
            } else {}
        }
    });
    $("#documento").on("change", (e) => {
        const archivo = $(e.target)[0].files[0];
    
        if (archivo) {
            const nombArchivo = archivo.name;
            const extension = nombArchivo.split(".").slice(-1)[0].toLowerCase();
            const extensionesPermitidas = [".pdf"];
    
            if (extensionesPermitidas.indexOf("." + extension) === -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Extensión NO permitida',
                    text: 'Por favor, selecciona un archivo PDF.',
                });
                $("#documento").val("");
            } else {}
        }
    });
    async function categoria(identificador, actual = null) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/mostrarCategoriaLibros`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar categoria...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_categoria;
                option.text = item.Categoria;
                if (actual != null) {
                    if (item.id_categoria == actual) {
                        option.selected = true;
                    }
                }
                $(identificador).append(option)
            }
            console.log('cargando categoria ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    categoria('#categoria', actual = null)
        $('.btn-agregar-evento').click(function () {
        $('#modalEventosLabel').text('Crear nuevo evento');
        $('#id_categoria').val('')
        $("#form-new-event")[0].reset();
        $('#tipo').val('nuevo');
    });
    async function idioma(identificador, actual = null) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/mostrarIdiomaLibros`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar idioma...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_idioma;
                option.text = item.Idioma;
                if (actual != null) {
                    if (item.id_idioma == actual) {
                        option.selected = true;
                    }
                }
                $(identificador).append(option)
            }
            console.log('cargando idiomas...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    idioma('#idioma', actual = null)
        $('.btn-agregar-evento').click(function () {
        $('#modalEventosLabel').text('Crear nuevo evento');
        $('#id_categoria').val('')
        $("#form-new-event")[0].reset();
        $('#tipo').val('nuevo');
    });
    async function editorial(identificador, actual = null) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/mostrarEditorialLibros`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar editorial...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_editorial;
                option.text = item.Nombre;
                if (actual != null) {
                    if (item.id_editorial == actual) {
                        option.selected = true;
                    }
                }
                $(identificador).append(option)
            }
            console.log('cargando editoriales...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    editorial('#editorial', actual = null)
        $('.btn-agregar-evento').click(function () {
        $('#modalEventosLabel').text('Crear nuevo evento');
        $('#id_editorial').val('')
        $("#form-new-event")[0].reset();
        $('#tipo').val('nuevo');
    });
    async function autor(identificador, actual = null) {
        try {
            $(identificador).empty();
            let peticion = await fetch(servidor + `admin/mostrarAutorLibros`);
            let response = await peticion.json();
            let option_select = document.createElement("option")
            option_select.value = '';
            option_select.text = 'Seleccionar autor...';
            $(identificador).append(option_select);
            for (let item of response) {
                let option = document.createElement("option")
                option.value = item.id_autor;
                option.text = item.Nombre + ' - ' + item.Apellido_paterno + ' - ' + item.Apellido_materno;
                if (actual != null) {
                    if (item.id_categoria == actual) {
                        option.selected = true;
                    }
                }
                $(identificador).append(option)
            }
            console.log('cargando autor ...');
        } catch (err) {
            if (err.name == 'AbortError') { } else { throw err; }
        }
    }
    autor('#autor', actual = null)
        $('.btn-agregar-evento').click(function () {
        $('#modalEventosLabel').text('Crear nuevo evento');
        $('#id_autor').val('')
        $("#form-new-event")[0].reset();
        $('#tipo').val('nuevo');
    });
    async function cardsEventos() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarLibro`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                    <div class="Libro-card-admin text-center"><img src="${servidor}${item.Imagen}" style="width: 50%;" class="img img-responsive">
                        <div class="profile-content">
                            <div class="profile-name">${item.Titulo}
                            </div>
                            <div class="profile-description">
                            <p styele="font-size: 8px;">${item.Descripcion}</p>
                                <div class="row">
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-md-6">
                                            <button data-id="${btoa(btoa(item.id_libro))}" class="btn btn-info form-control btn-editar">Editar</button>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <button data-id="${btoa(btoa(item.id_libro))}" class="btn btn-danger form-control btn-borrar">Borrar</button>
                                        </div>
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
        var id_libro = $(this).data('id');
        eliminarLibro(id_libro);
    });    
    function eliminarLibro(id_libro) {
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
                        url: servidor + `admin/eliminarLibro/${id_libro}`,
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
                    text: "El libro se ha salvado",
                    icon: "error"
                });
            }
        });
    }
    $(document).on('click', '.btn-editar', function() {
        $("#form-new-event")[0].reset();
        $('#modalEventosLabel').text('Actualizar Libro');
        $('#modalEventos').modal('show');
        buscarLibro($(this).data('id'));
    });
    
    async function buscarLibro(id_libro){
        let peticion = await fetch(servidor + `admin/buscarLibro/${id_libro}`);
        let response = await peticion.json();
        console.log(response);
        $('#id_libro').val(response['id_libro']);
        $('#titulo').val(response['Titulo']);
        $('#Numero_pagina').val(response['Numero_paginas']);
        $('#fecha_publicacion').val(response['Fecha_publicacion']);
        $('#palabra_clave').val(response['Palabra_clave']);
        $('#estatus').val(response['Estatus']);
        $('#descripcion').val(response['Descripcion']);
        $('#categoria').val(response['id_fk_categoria']);
        $('#editorial').val(response['id_fk_editorial']);
        $('#idioma').val(response['id_fk_idioma']);
        $('#autor').val(response['id_fk_autor']);
        $('#modalEventos').modal('show');
    }
});