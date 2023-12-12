<?php

/**
 *
 */
class CatalogosModel extends ModelBase
{

    public function __construct()
    {
        parent::__construct();
    }
    /* Eventos */
    public static function eventos()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_eventos WHERE estatus_evento = 1");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function infoProgramas($evento)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_programa cp INNER JOIN cat_eventos ce ON ce.id_evento = cp.fk_id_evento WHERE cp.fk_id_evento = :idEvento AND cp.estatus_programa = 1;");
            $query->execute([
                ':idEvento' => base64_decode(base64_decode($evento))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    /* Profesores */
    public static function infoProfesores(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cp.id_profesor,concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) AS profesor,cp.correo_profesor,cp.telefono_profesor,p.pais,e.estado FROM cat_profesores cp INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo INNER JOIN paises p ON p.id_pais = cp.fk_id_pais INNER JOIN estados e ON e.id_estado = cp.fk_id_estado;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoProfesores: " . $e->getMessage();
            return;
        }
    }
    public static function buscarProfesor($idprofesor){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_profesores cp WHERE cp.id_profesor = :idProfesor;");
            $query->execute([
                ':idProfesor' => $idprofesor
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarProfesor: " . $e->getMessage();
            return;
        }
    }
    /* Catálogos */
    public static function cat_estados($id)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM estados WHERE id_pais = :idPais;");
            $query->execute([
                ':idPais' => $id
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_estados: " . $e->getMessage();
            return;
        }
    }
}