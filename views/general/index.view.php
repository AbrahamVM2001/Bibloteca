<?php require('views/headervertical.view.php'); ?>
<style>
  .arrow {
    display: flex;
    justify-content: space-between;
    width: 100%;
  }

  .header {
    display: flex;
    justify-content: space-between;
  }
</style>
<div class="container">
  <div class="card">
    <div class="card-header justify-content-between flex-wrap">
      <div class="header">
        <h3>Cuenta</h3>
        <img src="${servidor}/../../public/img/configuracion.jpg" style="width: 100px;">
      </div>
      <h4>Saludos, <span class="d-sm-inline d-none"><?= $_SESSION['nombre_usuario-' . constant('Sistema')] ?></span>. Es un placer tenerte por esta sección</h4>
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <div class="arrow">
                <div class="arrow-title"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMjQgMjQiPjxwYXRoIGZpbGw9IiM2NjY2NjYiIGQ9Ik0xNiAySDRhMSAxIDAgMCAwLTEgMXYxOGExIDEgMCAwIDAgMSAxaDguMjU1QTcgNyAwIDAgMSAyMSAxMS42NzRWN3ptLTIuMjE0IDEzLjMyN2MuMDM5LS43MjcuNi0xLjMxOSAxLjMyNC0xLjM5NmwuODctLjA5MmEuNDk1LjQ5NSAwIDAgMCAuMjc5LS4xMjRsLjY1MS0uNTg1YTEuNDgzIDEuNDgzIDAgMCAxIDEuOTIzLS4wNWwuNjgyLjU1Yy4wOC4wNjUuMTguMTAzLjI4NC4xMDlsLjg3NC4wNDdjLjcyNy4wMzkgMS4zMTkuNiAxLjM5NiAxLjMyNGwuMDkyLjg3YS40OTQuNDk0IDAgMCAwIC4xMjQuMjc5bC41ODUuNjUxYy40ODcuNTQyLjUwOCAxLjM1Ny4wNSAxLjkyM2wtLjU1LjY4MmEuNDk1LjQ5NSAwIDAgMC0uMTA5LjI4NGwtLjA0Ny44NzRhMS40ODMgMS40ODMgMCAwIDEtMS4zMjQgMS4zOTZsLS44Ny4wOTJhLjQ5NS40OTUgMCAwIDAtLjI3OS4xMjRsLS42NTEuNTg1YTEuNDgzIDEuNDgzIDAgMCAxLTEuOTIzLjA1bC0uNjgyLS41NWEuNDk1LjQ5NSAwIDAgMC0uMjg0LS4xMDlsLS44NzQtLjA0N2ExLjQ4MyAxLjQ4MyAwIDAgMS0xLjM5Ni0xLjMyNGwtLjA5Mi0uODdhLjQ5NS40OTUgMCAwIDAtLjEyNC0uMjc5bC0uNTg1LS42NTFhMS40ODMgMS40ODMgMCAwIDEtLjA1LTEuOTIzbC41NS0uNjgyYS40OTUuNDk1IDAgMCAwIC4xMDktLjI4NHptNy4yNDQgMS43MDNsLTEuMDYtMS4wNmwtMi40NyAyLjQ3bC0xLjQ3LTEuNDdsLTEuMDYgMS4wNmwyIDJsLjUzLjUzbC41My0uNTN6Ii8+PC9zdmc+" width="7%">Términos y condiciones</div>
                <div class="arrow-icon"> <i class="fas fa-arrow-down"></i></div>
              </div>
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <ul style="list-style-type: decimal;">
                <li>Aceptación de Términos:<br>
                  Al acceder y utilizar nuestro sistema de biblioteca, usted acepta los siguientes términos y condiciones. Si no está de acuerdo con alguno de estos términos, le rogamos que no utilice nuestro sistema.
                </li>
                <li>Uso Apropiado:<br>
                  El sistema de biblioteca se proporciona únicamente con fines educativos y de investigación. Se prohíbe el uso del sistema para cualquier actividad ilegal o que infrinja derechos de propiedad intelectual.
                </li>
                <li>Registro de Usuarios:<br>
                  Para acceder a ciertas funciones del sistema, puede ser necesario registrarse como usuario. Usted es responsable de mantener la confidencialidad de su información de inicio de sesión y acepta notificarnos de inmediato cualquier uso no autorizado de su cuenta.
                </li>
                <li>Derechos de Propiedad Intelectual:<br>
                  Todos los derechos de propiedad intelectual del sistema de biblioteca, incluyendo pero no limitado a software, contenido y diseño, son propiedad de Sistema Bibloteca LAHE y están protegidos por las leyes de derechos de autor y otras leyes aplicables.
                </li>
                <li>Préstamos y Devoluciones:<br>
                  Los usuarios podrán realizar préstamos de materiales conforme a las políticas establecidas por la biblioteca. Se aplicarán multas por devoluciones tardías. La pérdida o daño de materiales prestados deberá ser reportada y compensada según las normativas de la biblioteca.
                </li>
                <li>Conducta del Usuario:<br>
                  Se espera que los usuarios del sistema de biblioteca se comporten de manera respetuosa con el personal y otros usuarios. Cualquier comportamiento disruptivo o inapropiado puede resultar en la suspensión del acceso al sistema.
                </li>
                <li>Privacidad:<br>
                  La información personal recopilada durante el registro y el uso del sistema se tratará de acuerdo con nuestra política de privacidad. Nos comprometemos a proteger la privacidad de los usuarios y a no compartir información personal con terceros sin su consentimiento.
                </li>
                <li>Modificaciones de Términos:<br>
                  Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigencia tan pronto como se publiquen en el sistema de biblioteca. Se recomienda revisar periódicamente los términos y condiciones para estar al tanto de cualquier actualización.
                </li>
                <li>Terminación del Servicio:<br>
                  Nos reservamos el derecho de suspender o terminar el acceso al sistema de biblioteca en cualquier momento y por cualquier razón, sin previo aviso.
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <div class="arrow">
                <div class="arrow-title"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMjQgMjQiPjxwYXRoIGZpbGw9IiM2NjY2NjYiIGQ9Ik0yMiAzSDJhMiAyIDAgMCAwLTIgMnYxNGEyIDIgMCAwIDAgMiAyaDIwYTIgMiAwIDAgMCAyLTJWNWEyIDIgMCAwIDAtMi0ybTAgMTZIMlY1aDIwek0yMSA2aC03djVoN3ptLTEgMmwtMi41IDEuNzVMMTUgOFY3bDIuNSAxLjc1TDIwIDd6TTkgMTJhMyAzIDAgMCAwIDMtM2EzIDMgMCAwIDAtMy0zYTMgMyAwIDAgMC0zIDNhMyAzIDAgMCAwIDMgM20wLTRhMSAxIDAgMCAxIDEgMWExIDEgMCAwIDEtMSAxYTEgMSAwIDAgMS0xLTFhMSAxIDAgMCAxIDEtMW02IDguNTljMC0yLjUtMy45Ny0zLjU5LTYtMy41OXMtNiAxLjA5LTYgMy41OVYxOGgxMnpNNS41IDE2Yy43Mi0uNSAyLjItMSAzLjUtMWMxLjMgMCAyLjc3LjUgMy41IDF6Ii8+PC9zdmc+" width="7%"> Inforsmación personal</div>
                <div class="arrow-icon"> <i class="fas fa-arrow-down"></i></div>
              </div>
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
            </div>
          </div>
        </div> -->
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <div class="arrow">
                <div class="arrow-title"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMTAyNCAxMDI0Ij48cGF0aCBmaWxsPSIjNjY2NjY2IiBkPSJNODY2LjkgMTY5LjlMNTI3LjEgNTQuMUM1MjMgNTIuNyA1MTcuNSA1MiA1MTIgNTJzLTExIC43LTE1LjEgMi4xTDE1Ny4xIDE2OS45Yy04LjMgMi44LTE1LjEgMTIuNC0xNS4xIDIxLjJ2NDgyLjRjMCA4LjggNS43IDIwLjQgMTIuNiAyNS45TDQ5OS4zIDk2OGMzLjUgMi43IDggNC4xIDEyLjYgNC4xczkuMi0xLjQgMTIuNi00LjFsMzQ0LjctMjY4LjZjNi45LTUuNCAxMi42LTE3IDEyLjYtMjUuOVYxOTEuMWMuMi04LjgtNi42LTE4LjMtMTQuOS0yMS4yTTgxMCA2NTQuM0w1MTIgODg2LjVMMjE0IDY1NC4zVjIyNi43bDI5OC0xMDEuNmwyOTggMTAxLjZ6bS00MDUuOC0yMDFjLTMtNC4xLTcuOC02LjYtMTMtNi42SDMzNmMtNi41IDAtMTAuMyA3LjQtNi41IDEyLjdsMTI2LjQgMTc0YTE2LjEgMTYuMSAwIDAgMCAyNiAwbDIxMi42LTI5Mi43YzMuOC01LjMgMC0xMi43LTYuNS0xMi43aC01NS4yYy01LjEgMC0xMCAyLjUtMTMgNi42TDQ2OC45IDU0Mi40eiIvPjwvc3ZnPg==" width="13%">Seguridad</div>
                <div class="arrow-icon"> <i class="fas fa-arrow-down"></i></div>
              </div>
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <h5>Tus Dispositivos</h5>
              <p>Los dispositivos que haz iniciado sesión</p>
              <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo isset($_SESSION['id_usuario-' . constant('Sistema')]) ? $_SESSION['id_usuario-' . constant('Sistema')] : ''; ?>">
              <div class="card-body">
                <div class="row table-responsive" id="container-dispositivos">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/config.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
</div>