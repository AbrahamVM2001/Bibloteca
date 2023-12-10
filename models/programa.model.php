<?php

/**
 *
 */
class ProgramaModel extends ModelBase
{

    public function __construct()
    {
        parent::__construct();
    }
    public static function datosPrograma($idPrograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT ce.nombre_evento,cp.nombre_programa FROM cat_programa cp INNER JOIN cat_eventos ce ON ce.id_evento = cp.fk_id_evento WHERE cp.id_programa = :idPrograma;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idPrograma))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function fechaPrograma($idPrograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cfp.id_fecha_programa,cfp.fecha_programa FROM asignacion_temas_programa atp INNER JOIN cat_fechas_programa cfp ON cfp.id_fecha_programa = atp.fk_id_fechas WHERE atp.fk_id_programa = :idPrograma GROUP BY atp.fk_id_fechas;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idPrograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function infoPrograma($idprograma, $idfecha)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("
                SELECT cfp.fecha_programa,cs.nombre_salon,cp.nombre_capitulo,ca.nombre_actividad, cm.nombre_tema,atp.hora_inicial,atp.hora_final,cmo.nombre_modalidad,concat_ws(' ',cpre.siglas_prefijo,cpr.nombre_profesor,cpr.apellidop_profesor,cpr.apellidom_profesor) AS profesor 
                FROM asignacion_temas_programa atp 
                INNER JOIN cat_profesores cpr ON cpr.id_profesor = atp.fk_id_profesor 
                INNER JOIN cat_prefijos cpre ON cpre.id_prefijo = cpr.fk_id_prefijo 
                INNER JOIN cat_temas cm ON cm.id_tema = atp.fk_id_tema 
                INNER JOIN cat_actividades ca ON ca.id_actividad = atp.fk_id_actividad 
                INNER JOIN cat_capitulos cp ON cp.id_capitulo = atp.fk_id_capitulo 
                INNER JOIN cat_salones cs ON cs.id_salon = atp.fk_id_salon 
                INNER JOIN cat_fechas_programa cfp ON cfp.id_fecha_programa = atp.fk_id_fechas 
                INNER JOIN cat_modalida cmo ON cmo.id_modalidad = atp.fk_id_modalidad 
                WHERE atp.fk_id_programa = :idPrograma AND atp.fk_id_fechas = :idFecha ORDER BY atp.hora_inicial ASC;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idFecha' => base64_decode(base64_decode($idfecha)),
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
}