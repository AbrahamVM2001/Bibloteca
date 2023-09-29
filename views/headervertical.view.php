<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="<?=constant('DESCRIPCIONSISTEMA');?>">
    <?=$this->icono?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=constant('SOCIEDAD')?></title>
    <?php require('views/estilos.view.php');?>
  </head>
  <body>
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main" style="">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="<?=constant('URL');?>" target="">
        <img src="<?=constant('URL').$this->logotipo?>" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold"><?=$this->nombresistema;?></span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto h-100" id="sidenav-collapse-main">
    <div id="loading"></div>
    <?php $menu = new Menu();?>
      <ul class="navbar-nav">
      <?php foreach ($menu->getMenu() as $item): ?>
        <?php if ($menu->getByIdMenuSubmenu($item['id_menu']) == false): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?=constant("URL").$item['referencia_menu'];?>" title="<?=$item['descripcion_menu'];?>">
            <div class="icon icon-sm shadow border-radius-md bg-white text-center  me-2 d-flex align-items-center justify-content-center">
                <?=$item['icono_menu'];?>
            </div>
            <span class="nav-link-text ms-1"><?=$item['nombre_menu'];?></span>
          </a>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#menu<?=$item['id_menu'];?>" class="nav-link " aria-controls="menu<?=$item['id_menu'];?>" role="button" aria-expanded="false">
            <div class="icon icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                <?=$item['icono_menu'];?>
            </div>
            <span class="nav-link-text ms-1"><?=$item['nombre_menu'];?></span>
          </a>
          <div class="collapse " id="menu<?=$item['id_menu'];?>">
            <ul class="nav ms-4 ps-3">
            <?php foreach ($menu->getByIdMenuSubmenu($item['id_menu']) as $submenu): ?>
              <li class="nav-item ">
                <a class="nav-link " href="<?=constant("URL").$submenu['referencia_submenu'];?>" title="<?=$submenu['descripcion_submenu'];?>">
                  <span class="sidenav-mini-icon"> <?=substr($submenu['nombre_submenu'],0,1);?> </span>
                  <span class="sidenav-normal"> <?=$submenu['nombre_submenu'];?> </span>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
        <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </div>
    <!-- El siguiente fragmento puede servir para boton de ayuda -->
    <!-- <div class="sidenav-footer mx-3 mt-3 pt-3">
      <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
        <div class="full-background" style="background-image: url('<?=constant('URL')?>public/img/curved-images/white-curved.jpg')"></div>
        <div class="card-body text-start p-3 w-100">
          <div class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
            <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true" id="sidenavCardIcon"></i>
          </div>
          <div class="docs-info">
            <h6 class="text-white up mb-0">Need help?</h6>
            <p class="text-xs font-weight-bold">Please check our docs</p>
            <a href="https://www.creative-tim.com/learning-lab/bootstrap-marketplace/overview/soft-ui-dashboard" target="_blank" class="btn btn-white btn-sm w-100 mb-0">Documentation</a>
          </div>
        </div>
      </div>
    </div> -->
  </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <?php require "views/header.view.php";?>
  <div class="container-fluid py-4" style="">