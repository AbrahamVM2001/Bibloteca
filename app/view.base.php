<?php

/**
 *
 */
class ViewBase
{
  public $icono;
  public $logotipo;
  public $sociedad;
  public $nombresistema;
  public $descripcionsistema;
  public $correosoporte;
  public $evento;
  public $fechas;
  public $idfecha;
  public $idprograma;
  public $idsalon;
  public $idcapitulo;
  public $idactividad;
  public $exportable;
  public $programa;
  public $datos;
  public $fechasPrograma;
  function __construct()
  {
    // echo "<p>Vista base</p>";

  }

  function render($vista)
  {
    require("views/" . $vista . ".view.php");
  }
}
