<?php
/**
 *
 */
class ControllerBase{
  public $model;
  public $view;
  public $sociedadEmail;
  public $correoEmail;
  public $passwordEmail;
  public $logoEmail;
  function __construct(){
    // echo "<p>Controlador base</p>";
    $this->view = new ViewBase();
    $this->view->icono= "<link rel='shortcut icon' href='".constant('URL').constant("ICONO")."'>";
    $this->view->logotipo = constant('LOGOTIPO');
    $this->view->sociedad = constant('SOCIEDAD');
    $this->view->nombresistema = constant('NOMBRESISTEMA');
    $this->view->descripcionsistema = constant('DESCRIPCIONSISTEMA');
    $this->view->correosoporte = constant('CORREOSOPORTE');
    /* Variables para correo electronico */
    $this->sociedadEmail = constant('SOCIEDAD');
    $this->correoEmail = constant('CORREOSOPORTE');
    $this->passwordEmail = constant('PASSWORDCORREOSOPORTE');
    $this->logoEmail = constant('URL').constant('LOGOTIPO');
  }

  function loadModel($model){
    $url = "models/".$model.".model.php";

    if (file_exists($url)) {
      require $url;

      $modelName = $model."Model";
      $this->model = new $modelName;
    }
  }
  function verificarAdmin()
  {
    if (isset($_SESSION['tipo_usuario-' . constant('Sistema')]) && $_SESSION['tipo_usuario-' . constant('Sistema')] == 1) {
      return true;
    } else {
      return false;
    }
  }
  function recargar(){
    header('Location:'.constant('URL'));
  }
}

 ?>
