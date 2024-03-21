<?php require('views/headervertical.view.php'); ?>
<style>

</style>
<div class="container">
  <div class="card">
    <div class="card-header d-flex justify-content-between flex-wrap">
      <img src="public\img\encabezado.jpg" style="width: 100%;">
      <h3>Sistema de bibloteca LAHE</h3>
      <h4>Buen día administrador</h4>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Campana">
        <i class="fa-regular fa-bell animated-bell"></i>
      </button>
      <p>¡Bienvenido(a) a nuestra biblioteca digital! Aquí, el conocimiento y las historias se entrelazan para llevarte a un fascinante
        viaje literario. Explora nuestra colección, sumérgete en mundos imaginarios y descubre un universo de lectura a tu alcance. ¡Tu
        aventura literaria comienza ahora!. Si quieres conocer el resumen del libro solo pasa raton sobre la imagen</p>
    </div>
    <form id="form-new-event" action="javascript:;" name="form-usuario" class="needs-validation" novalidate method="post">
      <div class="row">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <label for="buscar">Si no logras ver tu libro favorito solo busca con su titulo </label>
            <input type="text" class="form-control w-100" id="buscar" name="buscar">
            <div class="invalid-feedback">
              Ingresa tu búsqueda.
            </div>
          </div>
          <div class="col-sm-12 col-md-6"><br>
            <button data-formulario="form-new-event" type="button" class="btn btn-primary btn-buscar"><i class="fa-solid fa-search"></i></button>
          </div>
        </div>
      </div>
    </form>
    <!-- <div class="card-body">
          <div class="row table-responsive" id="container-eventos"></div>
        </div> -->
    <div class="card-body">
      <div class="row table-responsive" id="container-libros"></div>
    </div>
    <div class="card-body">
      <div class="row table-responsive" id="container-categoria1">
        <center>
          <h4>Libros más populares</h4>
        </center>
        <div class="wrapper">
          <!-- <i id="left" class="fa-solid fa-angle-left"></i> -->
          <div class="carousel">
          </div>
          <!-- <i id="right" class="fa-solid fa-angle-right"></i> -->
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row table-responsive" id="container-J-K">
        <center>
          <h4>Libros de J. K. Rowling</h4>
        </center>
        <div class="wrapper-J-K">
          <div class="carousel-J-K">
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row table-responsive" id="container-ASCII-Media-Works">
        <center>
          <h4 >Libros de ASCII Media Works</h4>
        </center>
        <div class="wrapper-ASCII-Media-Works">
          <div class="carousel-ASCII-Media-Works">
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tutorial</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="carouselExampleCaptions" class="carousel slide">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/tutorial_model/1.jpg" class="d-block w-100" alt="...">
              <div class="d-none d-md-block">
                <p>Si no ves tu libro favorito, puedes buscarlo.</p>
                <ul style="list-style-type: decimal;font-size: 12px;">
                  <li>Puedes presionar el botón rosa para iniciar la búsqueda del libro.</li>
                  <li>En esta sección, agrega el título, autor o editorial de tu libro favorito para buscarlo en tiempo real.</li>
                </ul>
              </div>
            </div>
            <div class="carousel-item">
              <img src="img/tutorial_model/2.jpg" class="d-block w-100" alt="...">
              <div class="d-none d-md-block">
                <p>Función de deslizamiento de libros.</p>
                <p>Para ver la lista de libros, simplemente desliza hacia la derecha.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="img/tutorial_model/3.jpg" class="d-block w-100" alt="...">
              <div class="d-none d-md-block">
                <p>Función de leer libro</p>
                <p>Para comenzar a leer tu libro, simplemente presiona sobre él.</p>
              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" style="background-color: rgba(0, 0, 0, 0.0.293);">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" style="background-color: rgba(0, 0, 0, 0.0.293);">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/admin/home.index.js"></script>