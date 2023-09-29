<?php
/**
 *
 */
class Menu{
  // Variables de la tabla "cat_menu"
  private $idMenu;
  private $nombreMenu;
  private $descripcionMenu;
  private $referenciaMenu;
  private $iconoMenu;
  private $posicionMenu;
  private $estatusMenu;

  //Variables de la tabla "cat_submenu"
  private $idSubmenu;
  private $fkMenu;
  private $nombreSubmenu;
  private $descripcionSubmenu;
  private $referenciaSubmenu;
  private $estatusSubmenu;

  function __construct(){
  }

  public function getMenu(){
    $con = new Database();
    try {
      $query = $con->pdo->prepare("
        SELECT * FROM cat_menu cm
        where cm.estatus_menu in (1)
        AND tipo_usuario in (:tipoUsuario,3)
        ORDER BY cm.posicion_menu ASC
      ");
      $query->execute([':tipoUsuario' => $_SESSION['tipo_usuario-'.constant('Sistema')]]);
      $items = $query->fetchAll();
      return $items;
    } catch (PDOException $e) {
      echo "error: " . $e->getMessage();
      return [];
    }
  }

  public function getMenuLogin(){
    $con = new Database();
    try {
      $query = $con->pdo->query("SELECT * FROM cat_menu WHERE nombre_menu IN('Iniciar sesión','Registrarme')");
      $items = $query->fetchAll();
      return $items;
    } catch (PDOException $e) {
      echo "error: " . $e->getMessage();
      return [];
    }
  }

  public function getByIdMenuSubmenu($id){
    $con = new Database();
    try {
      $query = $con->pdo->prepare("
        SELECT * FROM cat_submenu 
        WHERE fk_id_menu = :fkMenu 
        and estatus_submenu in (1)
        ORDER BY nombre_submenu ASC;
      ");
      $query->execute(['fkMenu'=>$id]);
      return $query->fetchAll();
    } catch (PDOException $e) {
      echo "error: " . $e->getMessage();
      return false;
    }
  }
  //
  // public function getSubMenu($id){
  //   try {
  //     $query = $this->con->pdo->prepare("SELECT * FROM submenu WHERE matricula = :matricula");
  //     $query->execute(['matricula'=>$id]);
  //     while ($row=$query->fetch()) {
  //       $item->matricula = $row['matricula'];
  //       $item->nombre = $row['nombre'];
  //       $item->apellido = $row['apellido'];
  //     }
  //   } catch (PDOException $e) {
  //
  //   }
  //
  // }

}

 ?>
