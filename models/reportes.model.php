<?php

/**
 *
 */
class ReportesModel extends ModelBase
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
    public static function temasAsignadosProfesores($idprograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cfp.fecha_programa,cs.nombre_salon,cc.nombre_capitulo,ca.nombre_actividad,atp.hora_inicial,atp.hora_final,ct.nombre_tema,cm.nombre_modalidad,concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) AS profesor,p.pais,e.estado FROM asignacion_temas_programa atp INNER JOIN cat_modalida cm ON cm.id_modalidad = atp.fk_id_modalidad INNER JOIN cat_profesores cp ON cp.id_profesor = atp.fk_id_profesor INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo INNER JOIN cat_temas ct ON ct.id_tema = atp.fk_id_tema INNER JOIN cat_actividades ca ON ca.id_actividad = atp.fk_id_actividad INNER JOIN cat_capitulos cc ON cc.id_capitulo = atp.fk_id_capitulo INNER JOIN cat_salones cs ON cs.id_salon = atp.fk_id_salon INNER JOIN cat_fechas_programa cfp ON cfp.id_fecha_programa = atp.fk_id_fechas INNER JOIN paises p ON p.id_pais = cp.fk_id_pais INNER JOIN estados e ON e.id_estado = cp.fk_id_estado WHERE atp.fk_id_programa = :idPrograma AND atp.estatus_asignacion = 1 ORDER BY cfp.fecha_programa,atp.hora_inicial ASC;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function temasAsignadosProfesores2($idprograma){
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
            $query = $con->pdo->prepare("
                SELECT cfp.fecha_programa,cs.nombre_salon,cp.nombre_capitulo,ca.nombre_actividad, cm.nombre_tema,atp.hora_inicial,atp.hora_final,cmo.nombre_modalidad 
                FROM asignacion_temas_programa atp 
                INNER JOIN cat_temas cm ON cm.id_tema = atp.fk_id_tema 
                INNER JOIN cat_actividades ca ON ca.id_actividad = atp.fk_id_actividad 
                INNER JOIN cat_capitulos cp ON cp.id_capitulo = atp.fk_id_capitulo 
                INNER JOIN cat_salones cs ON cs.id_salon = atp.fk_id_salon 
                INNER JOIN cat_fechas_programa cfp ON cfp.id_fecha_programa = atp.fk_id_fechas 
                INNER JOIN cat_modalida cmo ON cmo.id_modalidad = atp.fk_id_modalidad 
                WHERE atp.fk_id_programa = :idPrograma AND atp.fk_id_profesor = :idProfesor;
            ");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idProfesor' => base64_decode(base64_decode($idprofesor)),
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function buscarTemasAsignadosVirtuales($idprofesor,$idprograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("
                SELECT cfp.fecha_programa,cs.nombre_salon,cp.nombre_capitulo,ca.nombre_actividad, cm.nombre_tema,atp.hora_inicial,atp.hora_final,cmo.nombre_modalidad,atp.fk_id_programa 
                FROM asignacion_temas_programa atp 
                INNER JOIN cat_temas cm ON cm.id_tema = atp.fk_id_tema 
                INNER JOIN cat_actividades ca ON ca.id_actividad = atp.fk_id_actividad 
                INNER JOIN cat_capitulos cp ON cp.id_capitulo = atp.fk_id_capitulo 
                INNER JOIN cat_salones cs ON cs.id_salon = atp.fk_id_salon 
                INNER JOIN cat_fechas_programa cfp ON cfp.id_fecha_programa = atp.fk_id_fechas 
                INNER JOIN cat_modalida cmo ON cmo.id_modalidad = atp.fk_id_modalidad 
                WHERE atp.fk_id_programa = :idPrograma AND atp.fk_id_profesor = :idProfesor AND atp.fk_id_modalidad = 2;
            ");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idProfesor' => base64_decode(base64_decode($idprofesor)),
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function buscarTemasAsignadosPresenciales($idprofesor,$idprograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("
                SELECT cfp.fecha_programa,cs.nombre_salon,cp.nombre_capitulo,ca.nombre_actividad, cm.nombre_tema,atp.hora_inicial,atp.hora_final,cmo.nombre_modalidad,atp.fk_id_programa 
                FROM asignacion_temas_programa atp 
                INNER JOIN cat_temas cm ON cm.id_tema = atp.fk_id_tema 
                INNER JOIN cat_actividades ca ON ca.id_actividad = atp.fk_id_actividad 
                INNER JOIN cat_capitulos cp ON cp.id_capitulo = atp.fk_id_capitulo 
                INNER JOIN cat_salones cs ON cs.id_salon = atp.fk_id_salon 
                INNER JOIN cat_fechas_programa cfp ON cfp.id_fecha_programa = atp.fk_id_fechas 
                INNER JOIN cat_modalida cmo ON cmo.id_modalidad = atp.fk_id_modalidad 
                WHERE atp.fk_id_programa = :idPrograma AND atp.fk_id_profesor = :idProfesor AND atp.fk_id_modalidad = 1;
            ");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idProfesor' => base64_decode(base64_decode($idprofesor)),
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function buscarProfesor($idprofesor){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("
                SELECT concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) as profesor,cp.correo_profesor,cp.id_profesor FROM cat_profesores cp INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo WHERE cp.id_profesor = :idProfesor AND cp.estatus_profesor = 1;
            ");
            $query->execute([
                ':idProfesor' => base64_decode(base64_decode($idprofesor))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function buscarEvento($idPrograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("
                SELECT ce.* FROM cat_programa cp INNER JOIN cat_eventos ce ON ce.id_evento = cp.fk_id_evento WHERE cp.id_programa = :idPrograma AND cp.estatus_programa = 1;
            ");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idPrograma))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function buscarPrograma($idPrograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("
                SELECT * FROM cat_programa WHERE id_programa = :idPrograma
            ");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idPrograma))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarCorreoEnviado($profesor,$programa,$cartapresencial,$cartavirtual){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO log_correos (fk_id_profesor,fk_id_programa,carta_presencial,carta_virtual,enviado_por) VALUES (:fkProfesor,:fkPrograma,:cartaPresencial,:cartaVirtual,:enviadoPor)");
            $query->execute([
                ':fkProfesor' => $profesor,
                ':fkPrograma' => $programa,
                ':cartaPresencial' => (!empty($cartapresencial))?$cartapresencial:'null',
                ':cartaVirtual' => (!empty($cartavirtual))?$cartavirtual:'null',
                ':enviadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarPrograma: " . $e->getMessage();
            return false;
        }
    }
}