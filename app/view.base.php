<?php
/**
 *
 */
class ViewBase{
  public $icono;
  public $logotipo;
  public $sociedad;
  public $nombresistema;
  public $descripcionsistema;
  public $correosoporte;
  public $evento;
  function __construct(){
    // echo "<p>Vista base</p>";
    
  }

  function render($vista){
      require("views/".$vista.".view.php");
  }
}

 ?>
