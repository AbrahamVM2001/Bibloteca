<?php require('views/headervertical.view.php'); ?>
<div class="container">
  <div class="card">
    <div class="card-header d-flex justify-content-between flex-wrap">
      <img src="public\img\encabezado.jpg" style="width: 100%;">
      <h3>Sistema de bibloteca LAHE</h3>
      <h4>Buen día administrador</h4>
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
        <div class="card-body">
          <div class="row table-responsive" id="container-eventos"></div>
        </div>
        <div class="card-body">
          <div class="row table-responsive" id="container-libros"></div>
        </div>
        <div class="esteCategorias">
          <div class="card-body">
            <div class="row table-responsive" id="container-romance"></div>
          </div>
        </div>
        <h1>ksklslsk</h1>
      </div>
    </form>
    </div>
  </div>
<?php require('views/footer.view.php'); ?>
<script src="<?= constant('URL') ?>public/js/paginas/admin/home.index.js"></script>