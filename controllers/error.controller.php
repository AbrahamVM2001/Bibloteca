<?php
/**
 *
 */
class Errores extends ControllerBase
{

  function __construct()
  {
    parent::__construct();
    $this->view->render('error/index');
  }
}

?>