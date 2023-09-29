<?php
/**
 *
 */
class Database extends PDO
{
  private $host;
  public $db;
  private $user;
  private $password;
  private $charset;

  public $pdo;

  public function __construct()
  {
    $this->host = constant("HOST");
    $this->db = constant("DB");
    $this->user = constant("USER");
    $this->password = constant("PASSWORD");
    $this->charset = constant("CHARSET");
    try {
      $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset; //Mysql
      /* $connection = "pgsql:host=".$this->host.";port=5432;dbname=".$this->db.";";//Postgres */
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
      ];
      $this->pdo = new PDO($connection, $this->user, $this->password, $options);

      //return $pdo;
    } catch (PDOException $e) {
      print_r("Error de conexión: " . $e->getMessage());
    }
  }

  /* public function connect()
  {
  } */
  /* public function resetear($tabla){
    try {
      $query_datos_socio = $this->pdo->prepare("
        ALTER TABLE $tabla auto_increment = 0;
    ");
    $query_datos_socio->execute();
    } catch (PDOException $e) {
      echo "Error recopilado :".$e->getMessage();
      return false;
    }
  } */
}

?>