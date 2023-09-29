<?php
/**
 *
 */
class ModelBase{
  public $con;
  function __construct(){
    $this->con = new Database();
  }
}

 ?>
