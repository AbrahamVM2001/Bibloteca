$(function () {
    async function cardsEventos() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarLibrosView`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <div class="col-md-3">
                        <div class="Libro-card-view">
                            <img src="${servidor}${item.Imagen}" class="img img-responsive img-thumbnail"><a style="color: #fff; text-decoretion: none;" href="${servidor}admin/pdf/${btoa(btoa(item.id_libro))}/${btoa(item.documento)}">
                            <div class="profile-name"><h1 class="libro-titulo">${item.Titulo}</h1>
                                <br><p class="libro-des">${item.Descripcion}</p></div></a>
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
    async function cardsRomance() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarLibrosView`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-romance").addClass('text-danger');
                return false;
            }
            let carouselContainer = $("#container-romance");
            let imagesHtml = ''; // String para almacenar todas las imágenes
            response.forEach((item, index) => {
                imagesHtml += `
                    <div class="col-md-3">
                        <div class="Libro-card-view libro-card-view-horizontal">
                            <img src="${servidor}${item.Imagen}" class="img img-responsive img-thumbnail">
                            <a style="color: #fff; text-decoration: none;" href="${servidor}admin/pdf/${btoa(btoa(item.id_libro))}/${btoa(item.documento)}">
                                <div class="profile-name">
                                    <h1 class="libro-titulo">${item.Titulo}</h1>
                                    <br><p class="libro-des">${item.Descripcion}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                `;
            });
            carouselContainer.html(imagesHtml); // Añadir todas las imágenes al contenedor
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsRomance();
    async function cardsBusqueda(libros) {
        try {
            $("#container-libros").empty();
            if (libros.length === 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-libros").addClass('text-danger');
                return false;
            }
    
            libros.forEach((item, index) => {
                jQuery(`
                    <div class="col-md-3">
                        <div class="Libro-card-view">
                            <img src="${servidor}${item.Imagen}" class="img img-responsive" width="19000">
                            <a style="color: #fff; text-decoretion: none;" href="${servidor}admin/pdf/${btoa(btoa(item.id_libro))}/${btoa(item.documento)}">
                                <div class="profile-name">
                                    <h1 class="libro-titulo">${item.Titulo}</h1>
                                    <br><p class="libro-des">${item.Descripcion}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                `).appendTo("#container-libros");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    $("#buscar").on("input", function () {
        let query = $(this).val();
        if (query.trim() === "") {
            cardsEventos();
            cardsRomance();
            cardsBusqueda().empty();
        } else {
            buscarLibrosEnTiempoReal(query);
        }
    });

    async function buscarLibrosEnTiempoReal(query) {
        try {
            let peticion = await fetch(servidor + `admin/BuscarLibrosEnTiempoReal`, {
                method: 'POST',
                body: JSON.stringify({ buscar: query }),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            let response = await peticion.json();
            cardsBusqueda(response.respuesta);
            $("#container-eventos").empty();
            $("#container-romance").empty();
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }

    $(".btn-buscar").on("click", async function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: servidor + "admin/BuscarLibros",
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
                    console.log(data)
                    cardsBusqueda(data.respuesta);
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
        form.addClass("was-validated");
    });
});