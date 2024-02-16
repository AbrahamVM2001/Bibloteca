$(function () {
    $(document).ready(function () {
        var id_libro = $('#id_libro').val();

        $('#linkView').click(function (e) {
            e.preventDefault();
            console.log('id_libro:', id_libro);
            var iframe = document.createElement("iframe");
            iframe.width = '100%';
            iframe.height = '700px';
            iframe.src = 'http://localhost/bibloteca/public/docLibros/G3RJO3CW1H.pdf'; // Modifica esto según tu lógica
            $('.showPDF').append(iframe);
        });
    });
    async function cardsEventos() {
        try {
            let peticion = await fetch(servidor + `admin/MostrarComentarios`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin comentarios para mostrar</h3>`).appendTo("#container-eventos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                jQuery(`
                <div class="container">
                    <form>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                            ${servidor}${item.Nombre + ' - ' + item.Apellido_paterno + ' - ' + item.Apellido_materno}
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <p>${servidor}${item.Comentario}</p>
                            </div>
                        </div>
                    </form>
                </div>
                `).appendTo("#container-eventos");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsEventos();
});