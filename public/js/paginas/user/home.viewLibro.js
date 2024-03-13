$(function () {
    async function cardsEventos(id_libro) {
        try {
            $("#container-eventos").empty();
            $('#comentario').val("");
            $('#form-new-event').removeClass('was-validated');
            let peticion = await fetch(servidor + `usuario/viewComentario/${id_libro}`);
            let response = await peticion.json();
            moment.locale('es');
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin comentarios</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            let idUsuarioLogeado = $('#id_usuario').val();
            response.forEach((item, index) => {
                let tiempoTranscurrido = moment(item.Fecha_publicacion).fromNow();
                let idComentario = item.id_comentario;
                let botones = '';
            
                if (item.id_usuario == idUsuarioLogeado) {
                    botones = `
                        <div class="col-12 d-flex justify-content-between">
                            <button data-id="${btoa(btoa(item.id_comentario))}" class="btn btn-danger form-control me-2 btn-borrar">
                                <i class="fa-solid fa-trash"></i> Borrar
                            </button>
                            <button data-id="${btoa(btoa(item.id_comentario))}" class="btn btn-primary form-control btn-editar">
                                Editar <i class="fa-solid fa-edit ms-2"></i>
                            </button>
                        </div>`;
                }
            
                let estrellasHtml = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= item.Puntaje) {
                        estrellasHtml += `<i class="fa-solid fa-star text-warning"></i>`;
                    } else {
                        estrellasHtml += `<i class="fa-regular fa-star text-warning"></i>`;
                    }
                }
            
                jQuery(`
                    <div class="col-12 col-md-6 col-lg-4 mb-3 w-100">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 d-flex align-items-between">
                                        <i class="fa-solid fa-smile text-primary mx-auto"></i>
                                        <h5 class="card-title mx-auto">${item.Nombre} ${item.Apellido_paterno} ${item.Apellido_materno}</h5>
                                        <small class="card-title mx-auto">${tiempoTranscurrido}</small>
                                    </div>
                                    <div class="col-12">
                                        <div class="rating">${estrellasHtml}</div><br>
                                        <p class="card-text">${item.Comentario}</p>
                                    </div>
                                    ${botones} <!-- Agregar los botones según la condición -->
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
    cardsEventos(id_libro);
    $(document).on('click', '.btn-editar', function() {
        var id_comentario = $(this).data('id');
        buscarComentarioEditar(id_comentario);
    });
    async function buscarComentarioEditar(id_comentario) {
        try {
            let peticion = await fetch(servidor + `usuario/buscarComentarioEditar/${id_comentario}`);
            let response = await peticion.json();
            $('#id_comentario').val(response.id_comentario);
            $('#comentario').val(response.Comentario);
            $('input[name="estrellas"]').prop('checked', false);
            if (response.Puntaje && response.Puntaje >= 1 && response.Puntaje <= 5) {
                for (let i = 1; i <= response.Puntaje; i++) {
                    $(`#radio${6 - i}`).prop('checked', true);
                }
            }
            $('#tipo').val("1");
        } catch (error) {
            console.error('Error al buscar comentario para editar:', error);
        }
    }
    $(document).on('click', '.btn-borrar', function() {
        var id_comentario = $(this).data('id');
        eliminarComentario(id_comentario);
    });    
    
    function eliminarComentario(id_comentario) {
        $.ajax({
            type: "POST",
            url: servidor + `usuario/eliminarComentario/${id_comentario}`,
            dataType: "json",
            beforeSend: function () {
                $("#loading").addClass("loading");
            },
            success: function (data) {
                console.log(data);
                    setTimeout(() => {
                    cardsEventos(id_libro);
                }, 1000);
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
    // Catalogo de informacion de libro

    async function cardsProgramas(id_libro) {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `usuario/infoLibro/${id_libro}`);
            let response = await peticion.json();
            console.log(response);
            console.log(peticion);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Error al encontrar el libro</h3>`).appendTo("#container-info").addClass('text-danger');
                return false;
            }
            let container = jQuery("#container-info");
            let totalPages = response.reduce((total, item) => total + item.numero_de_paginas, 0);
            let currentPage = 0;
            for (const item of response) {
                let cardElement = jQuery(`
                    <div class="clic card mb-3" style="max-width: 100%;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="${servidor}${item.Imagen}" style="width: 40%;" class="img-fluid rounded-start" alt="libro">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${item.Titulo}</h5>
                                    <p class="card-text">${item.Descripcion}</p>
                                    <p class="card-text">Fecha de publicacion</p>
                                    <p class="card-text"><small class="text-muted">${item.Fecha_publicacion}</small></p>
                                    <p id="generadorApa">
                                    Fuente apa: ${item.NombreAutor} ${item.ApellidoPaternoAutor} ${item.ApellidoMaternoAutor},${item.Fecha_publicacion},${item.Titulo},${item.NombreEditorial}
                                    </p>
                                    <a href="#" onclick="copiarTexto()" class="btn-burbujas btn-burbujas-bubble" styele="color: #fff;">Copiar apa</a>
                                </div>
                            </div>
                        </div>
                        <script>
                            var animateButton = function(e) {

                                e.preventDefault;
                                //reset animation
                                e.target.classList.remove('animate');
                    
                                e.target.classList.add('animate');
                                setTimeout(function(){
                                    e.target.classList.remove('animate');
                                },700);
                            };
                    
                            var bubblyButtons = document.getElementsByClassName("bubbly-button");
                    
                            for (var i = 0; i < bubblyButtons.length; i++) {
                                bubblyButtons[i].addEventListener('click', animateButton, false);
                            }
                            function copiarTexto() {
                                var textoParaCopiar = document.getElementById("generadorApa");
                                var seleccion = document.createRange();
                                seleccion.selectNodeContents(textoParaCopiar);
                                window.getSelection().removeAllRanges();
                                window.getSelection().addRange(seleccion);
                                document.execCommand("copy");
                                window.getSelection().removeAllRanges();
                            }
                        </script>
                        <div class="row g-0">
                            <div class="progress orange">
                                <div class="progress-bar" style="width:0%; background:#fe3b3b;">
                                </div>
                            </div>
                            <embed id="pdf-embed-${item.id}" src="${servidor}${item.documento}#toolbar=0" type="application/pdf" width="100%" height="600px" />
                        </div>
                    </div>
                `).appendTo(container);
                await loadPdfWithProgress(item.documento, `#pdf-embed-${item.id}`, (progress) => {
                    let progressBar = cardElement.find('.progress-bar');
                    progressBar.width(progress + '%');
                });
                currentPage += item.numero_de_paginas;
            }
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsProgramas(id_libro);
    const toolbar = document.getElementById("toolbar");
    if (toolbar) {
        toolbar.style.display = "none";
    }
    $(".btn-Comenario").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            if ($('#comentario').val().length == 0) {
                Swal.fire("Por favor llenar todos los campos por favor!");
                return false;
            }else{
                $.ajax({
                    type: "POST",
                    url: servidor + "usuario/RegistroComentario",
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
                        setTimeout(() => {
                            cardsEventos(id_libro);
                        }, 1000);
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
});
function updatePuntaje(valor) {
    $('#puntaje').val(valor);
}