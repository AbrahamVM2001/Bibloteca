<?php if (isset($_SESSION['id_usuario-'.constant('Sistema')]) && !empty($_SESSION['id_usuario-'.constant('Sistema')])):?>

<nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky border" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="" href="<?=constant('URL')?>">Inicio</a></li>
            <?php $cadena = (isset($_SERVER['REDIRECT_QUERY_STRING']))?$_SERVER['REDIRECT_QUERY_STRING']:'';$sep = str_replace("url=", "", $cadena);$page = explode("/",$sep);?>
            <?php foreach ($page as $key => $value) :
              ?>
              <?php if (end($page) != $value) { ?>
                <?php if($key == 0 || $key == 1):?>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><a  href="javascript:;"><?=$value?></a></li>
                <?php endif;?>
              <?php }else{ ?>
                <!-- $activo = 'opacity-5 text-dark'; -->
                <!-- <li class="breadcrumb-item text-sm opacity-5 text-dark" aria-current="page"><?=str_replace("_"," ",$value)?></li> -->
              <?php }
              endforeach;?>
          </ol>
          <!-- <h6 class="font-weight-bolder mb-0">Referral</h6> -->
        </nav>
        <div id="hamburguesa" class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none mostrar">
          <a href="javascript:;" class="nav-link p-0">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </a>
        </div>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <button class="nav-link text-body font-weight-bold px-0 border-0 bg-transparent">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?=$_SESSION['nombre_usuario-'.constant('Sistema')]?></span>
              </button>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<?php else:?>
  <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky border" id="navbarBlur" data-scroll="true">
      <div class="container-fluid ">
        <div class="sidenav-header">
          <a class="navbar-brand m-0" href="<?=constant('URL')?>" target="">
            <img src="<?=constant('URL').$this->logotipo;?>" class="navbar-brand-img h-100 img-fluid" alt="main_logo">
            <!-- <span class="ms-1 font-weight-bold">Academia Mexicana de Neurología, A.C.</span> -->
          </a>
        </div>
      </div>
    </nav>
<?php endif;?>