<?php
/**
 *
 */
class LoginModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }
    public static function user($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_usuarios WHERE usuario = :usuario");
            $query->execute([
                ':usuario' => $datos['user-login-masivos']
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model user: ".$e->getMessage();
            return;
        }
    }
}
