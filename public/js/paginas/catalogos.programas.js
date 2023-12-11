$(function () {
    async function cardsProgramas() {
        console.log("Entras");
        try {
            let peticion = await fetch(servidor + `catalogos/infoProgramas/${evento}`);
            let response = await peticion.json();
            console.log(response);
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin programas disponibles</h3>`).appendTo("#container-programas").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                    <a href="${servidor}catalogos/catalogos/${btoa(btoa(item.id_programa))}/${btoa(item.nombre_programa)}/${btoa(btoa(item.nombre_evento+"-"+item.nombre_programa))}" class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="h-100 card card-profile card-plain move-on-hover border border-dark">
                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                            <img class="w-100 border-radius-md" src="${servidor}public/img/libro.gif">
                                <p class="mb-0 text-xs font-weight-bolder text-primary text-gradient text-uppercase">${item.nombre_programa}</p>
                            </div>
                        </div>
                    </a>
                `).appendTo("#container-programas");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsProgramas();
});