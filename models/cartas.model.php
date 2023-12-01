<?php

/**
 *
 */
class CartasModel extends ModelBase
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
            $query = $con->pdo->prepare("SELECT * FROM cat_programa WHERE fk_id_evento = :idEvento AND estatus_programa = 1");
            $query->execute([
                ':idEvento' => base64_decode(base64_decode($evento))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function temasAsignadosProfesores($idprograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cp.id_profesor,atp.fk_id_programa,concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) AS profesor,(SELECT COUNT(*) FROM asignacion_temas_programa atp2 WHERE atp2.fk_id_profesor = cp.id_profesor) AS asignaciones,cpa.nombre_programa,ce.nombre_evento FROM asignacion_temas_programa atp INNER JOIN cat_profesores cp ON cp.id_profesor = atp.fk_id_profesor INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo INNER JOIN cat_programa cpa ON cpa.id_programa = atp.fk_id_programa INNER JOIN cat_eventos ce ON ce.id_evento = cpa.fk_id_evento WHERE atp.fk_id_programa = :idPrograma GROUP BY atp.fk_id_profesor;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function buscarTemasAsignados($idprofesor,$idprograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cp.id_profesor,atp.fk_id_programa,concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) AS profesor,(SELECT COUNT(*) FROM asignacion_temas_programa atp2 WHERE atp2.fk_id_profesor = cp.id_profesor) AS asignaciones,cpa.nombre_programa,ce.nombre_evento FROM asignacion_temas_programa atp INNER JOIN cat_profesores cp ON cp.id_profesor = atp.fk_id_profesor INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo INNER JOIN cat_programa cpa ON cpa.id_programa = atp.fk_id_programa INNER JOIN cat_eventos ce ON ce.id_evento = cpa.fk_id_evento WHERE atp.fk_id_programa = :idPrograma GROUP BY atp.fk_id_profesor;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
}