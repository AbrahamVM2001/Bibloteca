$(function () {
    async function cardsDispositivos() {
        try {
            let id_usuario = document.getElementById('id_usuario').value || 0;
            let peticion = await fetch(servidor + `admin/mostrarDispositivos?id_usuario=${id_usuario}`);
            let response = await peticion.json();
            if (response.length == 0) {
                jQuery(`<h3 class="mt-4 text-center text-uppercase">Sin libros que mostrar</h3>`).appendTo("#container-dispositivos").addClass('text-danger');
                return false;
            }
            response.forEach((item, index) => {
                let tiempoTranscurrido = moment(item.FechaMasReciente).fromNow();
                let tipodispositivo = item.infoModelo.toLowerCase();
                let imagenDispositivo = "";
                if (tipodispositivo.includes("windows")) {
                    imagenDispositivo = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMjQgMjQiPjxwYXRoIGZpbGw9IiM2NjY2NjYiIGQ9Ik05IDIwdi0xaDJ2LTJIM1Y0aDE4djEzaC04djJoMnYxeiIvPjwvc3ZnPg==";
                } else if (tipodispositivo.includes("linux")) {
                    imagenDispositivo = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMjQgMjQiPjxwYXRoIGZpbGw9IiM2NjY2NjYiIGQ9Ik05IDIwdi0xaDJ2LTJIM1Y0aDE4djEzaC04djJoMnYxeiIvPjwvc3ZnPg==";
                } else if (tipodispositivo.includes("mac")) {
                    imagenDispositivo = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMjQgMjQiPjxwYXRoIGZpbGw9IiM2NjY2NjYiIGQ9Ik05IDIwdi0xaDJ2LTJIM1Y0aDE4djEzaC04djJoMnYxeiIvPjwvc3ZnPg==";
                } else if (tipodispositivo.includes("android")) {
                    imagenDispositivo = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgNTEyIDUxMiI+PHBhdGggZmlsbD0iIzY2NjY2NiIgZD0iTTM4NCA1MTJIMTI4YTY0LjA3IDY0LjA3IDAgMCAxLTY0LTY0VjY0YTY0LjA3IDY0LjA3IDAgMCAxIDY0LTY0aDI1NmE2NC4wNyA2NC4wNyAwIDAgMSA2NCA2NHYzODRhNjQuMDcgNjQuMDcgMCAwIDEtNjQgNjRNMTI4IDMyYTMyIDMyIDAgMCAwLTMyIDMydjM4NGEzMiAzMiAwIDAgMCAzMiAzMmgyNTZhMzIgMzIgMCAwIDAgMzItMzJWNjRhMzIgMzIgMCAwIDAtMzItMzJaIi8+PHBhdGggZmlsbD0iIzY2NjY2NiIgZD0iTTM4NCAwYTY0LjA3IDY0LjA3IDAgMCAxIDY0IDY0djM4NGE2NC4wNyA2NC4wNyAwIDAgMS02NCA2NEgxMjhhNjQuMDcgNjQuMDcgMCAwIDEtNjQtNjRWNjRhNjQuMDcgNjQuMDcgMCAwIDEgNjQtNjR6TTEyOCA0ODBoMjU2YTMyIDMyIDAgMCAwIDMyLTMyVjY0YTMyIDMyIDAgMCAwLTMyLTMySDEyOGEzMiAzMiAwIDAgMC0zMiAzMnYzODRhMzIgMzIgMCAwIDAgMzIgMzJtMC0xNmExNiAxNiAwIDAgMS0xNi0xNlY2NGExNiAxNiAwIDAgMSAxNi0xNmgyNTZhMTYgMTYgMCAwIDEgMTYgMTZ2Mzg0YTE2IDE2IDAgMCAxLTE2IDE2WiIvPjwvc3ZnPg==";
                } else if (tipodispositivo.includes("ios")) {
                    imagenDispositivo = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgNTEyIDUxMiI+PHBhdGggZmlsbD0iIzY2NjY2NiIgZD0iTTM4NCA1MTJIMTI4YTY0LjA3IDY0LjA3IDAgMCAxLTY0LTY0VjY0YTY0LjA3IDY0LjA3IDAgMCAxIDY0LTY0aDI1NmE2NC4wNyA2NC4wNyAwIDAgMSA2NCA2NHYzODRhNjQuMDcgNjQuMDcgMCAwIDEtNjQgNjRNMTI4IDMyYTMyIDMyIDAgMCAwLTMyIDMydjM4NGEzMiAzMiAwIDAgMCAzMiAzMmgyNTZhMzIgMzIgMCAwIDAgMzItMzJWNjRhMzIgMzIgMCAwIDAtMzItMzJaIi8+PHBhdGggZmlsbD0iIzY2NjY2NiIgZD0iTTM4NCAwYTY0LjA3IDY0LjA3IDAgMCAxIDY0IDY0djM4NGE2NC4wNyA2NC4wNyAwIDAgMS02NCA2NEgxMjhhNjQuMDcgNjQuMDcgMCAwIDEtNjQtNjRWNjRhNjQuMDcgNjQuMDcgMCAwIDEgNjQtNjR6TTEyOCA0ODBoMjU2YTMyIDMyIDAgMCAwIDMyLTMyVjY0YTMyIDMyIDAgMCAwLTMyLTMySDEyOGEzMiAzMiAwIDAgMC0zMiAzMnYzODRhMzIgMzIgMCAwIDAgMzIgMzJtMC0xNmExNiAxNiAwIDAgMS0xNi0xNlY2NGExNiAxNiAwIDAgMSAxNi0xNmgyNTZhMTYgMTYgMCAwIDEgMTYgMTZ2Mzg0YTE2IDE2IDAgMCAxLTE2IDE2WiIvPjwvc3ZnPg==";
                } else if (tipodispositivo.includes("HarmonyOS")) {
                    imagenDispositivo = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgNTEyIDUxMiI+PHBhdGggZmlsbD0iIzY2NjY2NiIgZD0iTTM4NCA1MTJIMTI4YTY0LjA3IDY0LjA3IDAgMCAxLTY0LTY0VjY0YTY0LjA3IDY0LjA3IDAgMCAxIDY0LTY0aDI1NmE2NC4wNyA2NC4wNyAwIDAgMSA2NCA2NHYzODRhNjQuMDcgNjQuMDcgMCAwIDEtNjQgNjRNMTI4IDMyYTMyIDMyIDAgMCAwLTMyIDMydjM4NGEzMiAzMiAwIDAgMCAzMiAzMmgyNTZhMzIgMzIgMCAwIDAgMzItMzJWNjRhMzIgMzIgMCAwIDAtMzItMzJaIi8+PHBhdGggZmlsbD0iIzY2NjY2NiIgZD0iTTM4NCAwYTY0LjA3IDY0LjA3IDAgMCAxIDY0IDY0djM4NGE2NC4wNyA2NC4wNyAwIDAgMS02NCA2NEgxMjhhNjQuMDcgNjQuMDcgMCAwIDEtNjQtNjRWNjRhNjQuMDcgNjQuMDcgMCAwIDEgNjQtNjR6TTEyOCA0ODBoMjU2YTMyIDMyIDAgMCAwIDMyLTMyVjY0YTMyIDMyIDAgMCAwLTMyLTMySDEyOGEzMiAzMiAwIDAgMC0zMiAzMnYzODRhMzIgMzIgMCAwIDAgMzIgMzJtMC0xNmExNiAxNiAwIDAgMS0xNi0xNlY2NGExNiAxNiAwIDAgMSAxNi0xNmgyNTZhMTYgMTYgMCAwIDEgMTYgMTZ2Mzg0YTE2IDE2IDAgMCAxLTE2IDE2WiIvPjwvc3ZnPg=="
                } else {
                    imagenDispositivo = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMTQgMTQiPjxwYXRoIGZpbGw9IiM2NjY2NjYiIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTggMmExIDEgMCAwIDAtMSAxdi40NjloLjVhMi43NSAyLjc1IDAgMCAxIDIuNzUgMi43NXYuMTU2SDE0VjNhMSAxIDAgMCAwLTEtMXptLS4xMDkgMTEuODcxYTEuOTk3IDEuOTk3IDAgMCAwIC4wODgtLjk0NGEyLjc1IDIuNzUgMCAwIDAgMi4yNzEtMi43MDhWNy42MjVIMTRWMTNhMSAxIDAgMCAxLTEgMUg4LjVhMS40OSAxLjQ5IDAgMCAxLS42MDktLjEyOW00Ljc4LTkuNjg0YS43NjYuNzY2IDAgMSAxLTEuNTMgMGEuNzY2Ljc2NiAwIDAgMSAxLjUzIDBNMCA2LjIyYTEuNSAxLjUgMCAwIDEgMS41LTEuNWg2QTEuNSAxLjUgMCAwIDEgOSA2LjIydjRhMS41IDEuNSAwIDAgMS0xLjUgMS41SDUuMjV2Ljc1SDZhLjc1Ljc1IDAgMSAxIDAgMS41SDNhLjc1Ljc1IDAgMCAxIDAtMS41aC43NXYtLjc1SDEuNWExLjUgMS41IDAgMCAxLTEuNS0xLjV6IiBjbGlwLXJ1bGU9ImV2ZW5vZGQiLz48L3N2Zz4=";
                }

                jQuery(`
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <p><img src="${imagenDispositivo}" width="6%">${item.infoModelo}<br>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <p>${item.Direccion}<br>
                        <small class="card-title mx-auto">${tiempoTranscurrido}</small></p>
                    </div>
                `).appendTo("#container-dispositivos");
            });
        } catch (error) {
            if (error.name == 'AbortError') { } else { throw error; }
        }
    }
    cardsDispositivos();
});