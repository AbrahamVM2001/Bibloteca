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
                            <img src="${servidor}${item.Imagen}" class= "img  img-responsive   img-thumbnail"><a style="color: #fff; text-decoretion: none;" href="${servidor}admin/pdf/${btoa(btoa(item.id_libro))}/${btoa(item.documento)}">
                            <div class="profile-name"><h1 class="libro-titulo">${item.Titulo}</h1>
                                <br><p class="libro-des">${item.Descripcion}</p>
                            </div></a>
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
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-categoria1").addClass('text-danger');
                return false;
            }
            jQuery(`<div class="wrapper"></div>`).appendTo("#container-categoria1");
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}admin/pdf/${btoa(btoa(item.id_libro))}/${btoa(item.documento)}">
                        <img src="${servidor}${item.Imagen}" class= "img  img-responsive   img-thumbnail">
                    </a>
                `).appendTo(".wrapper .carousel");
            });
            $('.wrapper .carousel').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsRomance();
    
    // Inicio del carrusel para la segunda categoria
    
    const carousel = document.querySelector(".carousel"),
    firstImg = carousel.querySelectorAll(   "img")[0],
    arrowIcons = document.querySelectorAll(".wrapper i");

    let isDragStart = false,
        isDragging = false,
        prevPageX,
        prevScrollLeft,
        positionDiff;

    const showHideIcons = () => {
        let scrollWidth = carousel.scrollWidth - carousel.clientWidth;
        arrowIcons[0].style.display = "block";
        arrowIcons[1].style.display = "block";
        if (carousel.scrollLeft <= 0) {
            arrowIcons[0].style.display = "none";
        }
        if (carousel.scrollLeft >= scrollWidth) {
            arrowIcons[1].style.display = "none";
        }
    };

    arrowIcons.forEach((icon) => {
        icon.addEventListener("click", () => {
            let firstImgWidth = firstImg.clientWidth + 14;
            if (icon.id == "left" && carousel.scrollLeft <= 0) {
                // If at the beginning, scroll to the end
                carousel.scrollLeft = carousel.scrollWidth - carousel.clientWidth;
            } else if (icon.id == "right" && carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth) {
                // If at the end, scroll to the beginning
                carousel.scrollLeft = 0;
            } else {
                carousel.scrollLeft += icon.id == "left" ? -firstImgWidth : firstImgWidth;
            }
            setTimeout(() => showHideIcons(), 60);});
    });

    const autoSlide = () => {
        let firstImgWidth = firstImg.clientWidth + 14;
        if (carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth) {
            // If at the end, scroll to the beginning
            carousel.scrollLeft = 0;
        } else if (carousel.scrollLeft <= 0) {
            // If at the beginning, scroll to the end
            carousel.scrollLeft = carousel.scrollWidth - carousel.clientWidth;
        }
        positionDiff = Math.abs(positionDiff);
        let valDifference = firstImgWidth - positionDiff;
        if (carousel.scrollLeft > prevScrollLeft) {
            carousel.scrollLeft += positionDiff > firstImgWidth / 3 ? valDifference : -positionDiff;
        } else {
            carousel.scrollLeft -= positionDiff > firstImgWidth / 3 ? valDifference : -positionDiff;
        }
    };

    const dragStart = (e) => {
        isDragStart = true;
        prevPageX = e.pageX || e.touches[0].pageX;
        prevScrollLeft = carousel.scrollLeft;
    };

    const dragging = (e) => {
        if (!isDragStart) return;
        e.preventDefault();
        isDragging = true;
        carousel.classList.add("dragging");
        positionDiff = (e.pageX || e.touches[0].pageX) - prevPageX;
        carousel.scrollLeft = prevScrollLeft - positionDiff;
        showHideIcons();
    };

    const dragStop = () => {
        isDragStart = false;
        carousel.classList.remove("dragging");

        if (!isDragging) return;
        isDragging = false;
        autoSlide();
    };

    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("touchstart", dragStart);

    document.addEventListener("mousemove", dragging);
    carousel.addEventListener("touchmove", dragging);

    document.addEventListener("mouseup", dragStop);
    carousel.addEventListener("touchend", dragStop);
    
    // Fin del js para la primera categoria

    async function cardsHarry() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarLibrosViewHarry`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-J-K").addClass('text-danger');
                return false;
            }
            jQuery(`<div class="wrapper-J-K"></div>`).appendTo("#container-J-K");
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}admin/pdf/${btoa(btoa(item.id_libro))}/${btoa(item.documento)}"><img src="${servidor}${item.Imagen}" class= "img  img-responsive   img-thumbnail"></a>
                `).appendTo(".wrapper-J-K .carousel-J-K");
            });
            $('.wrapper-J-K .carousel-J-K').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsHarry();
    // INCIO SEGUNDO CARRUSEL CATEGORIA

    const carouselJK = document.querySelector(".carousel-J-K");
    const firstImgJK = carouselJK.querySelectorAll("img")[0];
    const arrowIconsJK = document.querySelectorAll(".wrapper-J-K i");

    let isDragStartJK = false,
        isDraggingJK = false,
        prevPageXJK,
        prevScrollLeftJK,
        positionDiffJK;

    const showHideIconsJK = () => {
        let scrollWidthJK = carouselJK.scrollWidth - carouselJK.clientWidth;
        arrowIconsJK[0].style.display = "block";
        arrowIconsJK[1].style.display = "block";
        if (carouselJK.scrollLeft <= 0) {
            arrowIconsJK[0].style.display = "none";
        }
        if (carouselJK.scrollLeft >= scrollWidthJK) {
            arrowIconsJK[1].style.display = "none";
        }
    };

    arrowIconsJK.forEach((icon) => {
        icon.addEventListener("click", () => {
            let firstImgWidthJK = firstImgJK.clientWidth + 14;
            if (icon.id == "left" && carouselJK.scrollLeft <= 0) {
                carouselJK.scrollLeft = carouselJK.scrollWidth - carouselJK.clientWidth;
            } else if (icon.id == "right" && carouselJK.scrollLeft >= carouselJK.scrollWidth - carouselJK.clientWidth) {
                carouselJK.scrollLeft = 0;
            } else {
                carouselJK.scrollLeft += icon.id == "left" ? -firstImgWidthJK : firstImgWidthJK;
            }
            setTimeout(() => showHideIconsJK(), 60);
        });
    });

    const autoSlideJK = () => {
        let firstImgWidthJK = firstImgJK.clientWidth + 14;
        if (carouselJK.scrollLeft >= carouselJK.scrollWidth - carouselJK.clientWidth) {
            carouselJK.scrollLeft = 0;
        } else if (carouselJK.scrollLeft <= 0) {
            carouselJK.scrollLeft = carouselJK.scrollWidth - carouselJK.clientWidth;
        }
        positionDiffJK = Math.abs(positionDiffJK);
        let valDifferenceJK = firstImgWidthJK - positionDiffJK;
        if (carouselJK.scrollLeft > prevScrollLeftJK) {
            carouselJK.scrollLeft += positionDiffJK > firstImgWidthJK / 3 ? valDifferenceJK : -positionDiffJK;
        } else {
            carouselJK.scrollLeft -= positionDiffJK > firstImgWidthJK / 3 ? valDifferenceJK : -positionDiffJK;
        }
    };

    const dragStartJK = (e) => {
        isDragStartJK = true;
        prevPageXJK = e.pageX || e.touches[0].pageX;
        prevScrollLeftJK = carouselJK.scrollLeft;
    };

    const draggingJK = (e) => {
        if (!isDragStartJK) return;
        e.preventDefault();
        isDraggingJK = true;
        carouselJK.classList.add("dragging");
        positionDiffJK = (e.pageX || e.touches[0].pageX) - prevPageXJK;
        carouselJK.scrollLeft = prevScrollLeftJK - positionDiffJK;
        showHideIconsJK();
    };

    const dragStopJK = () => {
        isDragStartJK = false;
        carouselJK.classList.remove("dragging");

        if (!isDraggingJK) return;
        isDraggingJK = false;
        autoSlideJK();
    };

    carouselJK.addEventListener("mousedown", dragStartJK);
    carouselJK.addEventListener("touchstart", dragStartJK);

    document.addEventListener("mousemove", draggingJK);
    carouselJK.addEventListener("touchmove", draggingJK);

    document.addEventListener("mouseup", dragStopJK);
    carouselJK.addEventListener("touchend", dragStopJK);

    // FIN DEL CARRUSEL SEGUNDA CATEGORIA

    async function cardsASCII() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarLibrosViewACII`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-ASCII-Media-Works").addClass('text-danger');
                return false;
            }
            jQuery(`<div class="wrapper-ASCII-Media-Works"></div>`).appendTo("#container-ASCII-Media-Works");
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}admin/pdf/${btoa(btoa(item.id_libro))}/${btoa(item.documento)}">
                        <img src="${servidor}${item.Imagen}" class="img img-responsive img-thumbnail">
                    </a>
                `).appendTo(".wrapper-ASCII-Media-Works .carousel-ASCII-Media-Works");
            });
            $('.wrapper-ASCII-Media-Works .carousel-ASCII-Media-Works').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsASCII();

    // Inicio tercera categoria carrusel

    const carouselASCII = document.querySelector(".carousel-ASCII-Media-Works");
    const firstImgASCII = carouselASCII.querySelectorAll("img")[0];
    const arrowIconsASCII = document.querySelectorAll(".wrapper-ASCII-Media-Works i");

    let isDragStartASCII = false,
        isDraggingASCII = false,
        prevPageXASCII,
        prevScrollLeftASCII,
        positionDiffASCII;

    const showHideIconsASCII = () => {
        let scrollWidthASCII = carouselASCII.scrollWidth - carouselASCII.clientWidth;
        arrowIconsASCII[0].style.display = "block";
        arrowIconsASCII[1].style.display = "block";
        if (carouselASCII.scrollLeft <= 0) {
            arrowIconsASCII[0].style.display = "none";
        }
        if (carouselASCII.scrollLeft >= scrollWidthASCII) {
            arrowIconsASCII[1].style.display = "none";
        }
    };

    arrowIconsASCII.forEach((icon) => {
        icon.addEventListener("click", () => {
            let firstImgWidthASCII = firstImgASCII.clientWidth + 14;
            if (icon.id == "left" && carouselASCII.scrollLeft <= 0) {
                carouselASCII.scrollLeft = carouselASCII.scrollWidth - carouselASCII.clientWidth;
            } else if (icon.id == "right" && carouselASCII.scrollLeft >= carouselASCII.scrollWidth - carouselASCII.clientWidth) {
                carouselASCII.scrollLeft = 0;
            } else {
                carouselASCII.scrollLeft += icon.id == "left" ? -firstImgWidthASCII : firstImgWidthASCII;
            }
            setTimeout(() => showHideIconsASCII(), 60);
        });
    });

    const autoSlideASCII = () => {
        let firstImgWidthASCII = firstImgASCII.clientWidth + 14;
        if (carouselASCII.scrollLeft >= carouselASCII.scrollWidth - carouselASCII.clientWidth) {
            carouselASCII.scrollLeft = 0;
        } else if (carouselASCII.scrollLeft <= 0) {
            carouselASCII.scrollLeft = carouselASCII.scrollWidth - carouselASCII.clientWidth;
        }
        positionDiffASCII = Math.abs(positionDiffASCII);
        let valDifferenceASCII = firstImgWidthASCII - positionDiffASCII;
        if (carouselASCII.scrollLeft > prevScrollLeftASCII) {
            carouselASCII.scrollLeft += positionDiffASCII > firstImgWidthASCII / 3 ? valDifferenceASCII : -positionDiffASCII;
        } else {
            carouselASCII.scrollLeft -= positionDiffASCII > firstImgWidthASCII / 3 ? valDifferenceASCII : -positionDiffASCII;
        }
    };

    const dragStartASCII = (e) => {
        isDragStartASCII = true;
        prevPageXASCII = e.pageX || e.touches[0].pageX;
        prevScrollLeftASCII = carouselASCII.scrollLeft;
    };

    const draggingASCII = (e) => {
        if (!isDragStartASCII) return;
        e.preventDefault();
        isDraggingASCII = true;
        carouselASCII.classList.add("dragging");
        positionDiffASCII = (e.pageX || e.touches[0].pageX) - prevPageXASCII;
        carouselASCII.scrollLeft = prevScrollLeftASCII - positionDiffASCII;
        showHideIconsASCII();
    };

    const dragStopASCII = () => {
        isDragStartASCII = false;
        carouselASCII.classList.remove("dragging");

        if (!isDraggingASCII) return;
        isDraggingASCII = false;
        autoSlideASCII();
    };

    carouselASCII.addEventListener("mousedown", dragStartASCII);
    carouselASCII.addEventListener("touchstart", dragStartASCII);

    document.addEventListener("mousemove", draggingASCII);
    carouselASCII.addEventListener("touchmove", draggingASCII);

    document.addEventListener("mouseup", dragStopASCII);
    carouselASCII.addEventListener("touchend", dragStopASCII);

    // Fin del carrusel 
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
                                <img src="${servidor}${item.Imagen}" class= "img  img-responsive" width="19000">
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
            location.reload();
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
            $("#container-categoria1").empty();
            $("#container-J-K").empty();
            $("#container-ASCII-Media-Works").empty();
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    // $("#buscar").on("input", function () {
    //     let query = $(this).val();
    //     if (query === "") {
    //         cardsEventos();
    //         cardsASCII();
    //         cardsHarry();
    //         cardsRomance();
    //         cardsBusqueda();
    //     } else {
    //         buscarLibrosEnTiempoReal(query);
    //     }
    // });

    // async function buscarLibrosEnTiempoReal(query) {
    //     try {
    //         let peticion = await fetch(servidor + `admin/BuscarLibrosEnTiempoReal`, {
    //             method: 'POST',
    //             body: JSON.stringify({ buscar: query }),
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             }
    //         });
    //         let response = await peticion.json();
    //         cardsBusqueda(response.respuesta);
    //         $("#container-categoria1").empty();
    //         $("#container-eventos").empty();
    //         $("#container-J-K").empty();
    //         $("#container-ASCII-Media-Works").empty();
    //     } catch (error) {
    //         if (error.name == 'AbortError') { } else { throw error; }
    //     }
    // }

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