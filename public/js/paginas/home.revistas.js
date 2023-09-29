$(function () {
    $(".btn-carpeta").on("click", function () {
        let form = $("#" + $(this).data("formulario"));
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            $.ajax({
                type: "POST",
                url: servidor + "admin/guardarCarpeta",
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
    async function cardsRevistas() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `admin/revistas`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase"></h3>`).appendTo("#container-clientes").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}admin/documentos/${btoa(btoa(item.id_revista))}" class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                                    <img class="w-100 border-radius-md" src="${servidor}public/img/carpeta.gif">
                                <h5 class="mt-3 mb-1 d-md-block ">${item.anio_revista}</h5>
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.autor_revista}</p>
                            </div>
                        </div>
                    </a>
                `).appendTo("#container-clientes");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsRevistas();
});