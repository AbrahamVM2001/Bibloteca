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
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function buscarEvento($idevento)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_eventos WHERE id_evento = :idEvento");
            $query->execute([
                ':idEvento' => base64_decode(base64_decode($idevento))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarEvento: " . $e->getMessage();
            return;
        }
    }
    public static function guardarEvento($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_eventos (nombre_evento,descripcion_evento,fecha_inicio_evento,fecha_fin_evento,creado_por) VALUES (:nombreEvento,:descripcionEvento,:fechaInicio,:fechaFin,:creadoPor)");
            $query->execute([

                ':nombreEvento' => $datos['nombre_evento'],
                ':descripcionEvento' => $datos['descripcion_evento'],
                ':fechaInicio' => $datos['fecha_inicio'],
                ':fechaFin' => $datos['fecha_fin'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarEvento: " . $e->getMessage();
            return false;
        }
    }
    public static function actualizarEvento($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_eventos SET nombre_evento = :nombreEvento,descripcion_evento=:descripcionEvento,fecha_inicio_evento=:fechaInicio,fecha_fin_evento=:fechaFin  WHERE id_evento = :idEvento;");
            $query->execute([

                ':nombreEvento' => $datos['nombre_evento'],
                ':descripcionEvento' => $datos['descripcion_evento'],
                ':fechaInicio' => $datos['fecha_inicio'],
                ':fechaFin' => $datos['fecha_fin'],
                ':idEvento' => $datos['id_evento']
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model actualizarEvento: " . $e->getMessage();
            return false;
        }
    }
    /* Programas */
    public static function guardarPrograma($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_programa (fk_id_evento,nombre_programa,creado_por,responsable_programa,correo_responsable) VALUES (:fkEvento,:nombrePrograma,:creadoPor,:responsable,:correoResp)");
            $query->execute([

                ':fkEvento' => base64_decode(base64_decode($datos['evento'])),
                ':nombrePrograma' => $datos['nombre_programa'],
                ':responsable' => $datos['responsable'],
                ':correoResp' => $datos['correo_responsable'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function actualizarPrograma($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_programa SET nombre_programa=:nombrePrograma,responsable_programa = :responsable,correo_responsable=:correoResp WHERE id_programa = :idPrograma");
            $query->execute([

                ':idPrograma' => $datos['id_programa'],
                ':nombrePrograma' => $datos['nombre_programa'],
                ':responsable' => $datos['responsable'],
                ':correoResp' => $datos['correo_responsable']
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarPrograma($idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_programa WHERE id_programa = :idPrograma");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarPrograma: " . $e->getMessage();
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
    /* Fechas */
    public static function guardarFechas($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_fechas_programa (fk_id_programa,fecha_programa,creado_por) VALUES (:fkPrograma,:fechaPrograma,:creadoPor)");
            $query->execute([

                ':fkPrograma' => base64_decode(base64_decode($datos['programa'])),
                ':fechaPrograma' => $datos['fecha'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarFechas: " . $e->getMessage();
            return false;
        }
    }
    public static function eliminarFecha($idfecha)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            /* $check = $con->pdo->prepare("SET foreign_key_checks = 0;");
            $check->execute(); */
            $query = $con->pdo->prepare("DELETE FROM cat_fechas_programa WHERE id_fecha_programa = :idFecha;");
            $query->execute([
                ':idFecha' => base64_decode(base64_decode($idfecha))
            ]);
            /* $check2 = $con->pdo->prepare("SET foreign_key_checks = 1;");
            $check2->execute(); */
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model eliminarFecha: " . $e->getMessage();
            return false;
        }
    }
    public static function infoFechas($modulo)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_fechas_programa WHERE fk_id_programa = :idPrograma AND estatus_fecha_programa = 1");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($modulo))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoFechas: " . $e->getMessage();
            return;
        }
    }
    /* Salones */
    public static function guardarSalones($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_salones (fk_id_fechas,fk_id_programa,nombre_salon,creado_por) VALUES (:fkFechas,:fkPrograma,:nombreSalon,:creadoPor)");
            $query->execute([

                ':fkFechas' => base64_decode(base64_decode($datos['idfecha'])),
                ':fkPrograma' => base64_decode(base64_decode($datos['idprograma'])),
                ':nombreSalon' => $datos['nuevo_salon'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $idsalon_resp = $con->pdo->lastInsertId();
            $con->pdo->commit();
            return $idsalon_resp;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarSalones: " . $e->getMessage();
            return false;
        }
    }
    public static function reasignarSalon($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE asignacion_salones_programa SET fk_id_salon = :fkSalon, estatus_asignacion = 0 WHERE id_asignacion_salon = :idAsignacionSalon");
            $query->execute([
                ':fkSalon' => $datos['reasignar_salon'],
                ':idAsignacionSalon' => base64_decode(base64_decode($datos['id_asignacion_salon']))
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarAsignacionSalon($idsalon)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM asignacion_salones_programa WHERE fk_id_salon = :idSalon AND estatus_asignacion = 1");
            $query->execute([
                ':idSalon' => $idsalon
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarPrograma: " . $e->getMessage();
            return;
        }
    }
    public static function eliminarAsignacionesSalonesInactivas()
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $check = $con->pdo->prepare("SET foreign_key_checks = 0;");
            $check->execute();
            $query = $con->pdo->prepare("DELETE FROM asignacion_salones_programa WHERE estatus_asignacion = 0");
            $query->execute();
            $check2 = $con->pdo->prepare("SET foreign_key_checks = 1;");
            $check2->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model eliminarAsignacionesInactivas: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarSalon($idsalon)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_salones WHERE id_salon = :idSalon");
            $query->execute([
                ':idSalon' => base64_decode(base64_decode($idsalon))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarPrograma: " . $e->getMessage();
            return;
        }
    }
    public static function asignarSalonPrograma($idfecha, $idprograma, $idsalon)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO asignacion_salones_programa (fk_id_fechas,fk_id_programa,fk_id_salon,creado_por) VALUES (:fkFechas,:fkPrograma,:idSalon,:creadoPor)");
            $query->execute([

                ':fkFechas' => base64_decode(base64_decode($idfecha)),
                ':fkPrograma' => base64_decode(base64_decode($idprograma)),
                ':idSalon' => $idsalon,
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model asignarSalonPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function cat_salones($idfecha, $idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cs.*,(CASE WHEN (SELECT asp.id_asignacion_salon FROM asignacion_salones_programa asp WHERE asp.fk_id_fechas = :idFechas AND asp.fk_id_salon = cs.id_salon AND asp.estatus_asignacion = 1) IS NULL THEN 0 ELSE 1 END) AS asignado FROM cat_salones cs WHERE cs.fk_id_programa = :idPrograma AND cs.estatus_salon = 1 ORDER BY cs.nombre_salon ASC;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idFechas' => base64_decode(base64_decode($idfecha))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_salones: " . $e->getMessage();
            return;
        }
    }
    public static function infoSalones($modulo)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT asp.id_asignacion_salon,cs.id_salon,cs.nombre_salon,asp.* FROM asignacion_salones_programa asp INNER JOIN cat_salones cs ON cs.id_salon = asp.fk_id_salon WHERE asp.fk_id_fechas = :idFecha AND estatus_salon = 1 AND asp.estatus_asignacion = 1");
            $query->execute([
                ':idFecha' => base64_decode(base64_decode($modulo))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoSalones: " . $e->getMessage();
            return;
        }
    }
    /* Capitulos */
    public static function guardarCapitulos($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_capitulos (fk_id_salon,fk_id_fechas,fk_id_programa,nombre_capitulo,creado_por) VALUES (:fkSalon,:fkFechas,:fkPrograma,:nombreCapitulo,:creadoPor)");
            $query->execute([

                ':fkSalon' => base64_decode(base64_decode($datos['idsalon'])),
                ':fkFechas' => base64_decode(base64_decode($datos['idfecha'])),
                ':fkPrograma' => base64_decode(base64_decode($datos['idprograma'])),
                ':nombreCapitulo' => $datos['nuevo_capitulo'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $idcapitulo_resp = $con->pdo->lastInsertId();
            $con->pdo->commit();
            return $idcapitulo_resp;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarSalones: " . $e->getMessage();
            return false;
        }
    }
    public static function reasignarCapitulo($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE asignacion_capitulos_programa SET fk_id_capitulo = :fkCapitulo, estatus_asignacion = 0 WHERE id_asignacion_capitulo = :idAsignacionCapitulo");
            $query->execute([
                ':fkCapitulo' => $datos['reasignar_capitulo'],
                ':idAsignacionCapitulo' => base64_decode(base64_decode($datos['id_asignacion_capitulo']))
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarAsignacionCapitulo($idCapitulo)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM asignacion_capitulos_programa WHERE fk_id_capitulo = :idCapitulo AND estatus_asignacion = 1");
            $query->execute([
                ':idCapitulo' => $idCapitulo
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarPrograma: " . $e->getMessage();
            return;
        }
    }
    public static function eliminarAsignacionesCapitulosInactivos()
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $check = $con->pdo->prepare("SET foreign_key_checks = 0;");
            $check->execute();
            $query = $con->pdo->prepare("DELETE FROM asignacion_capitulos_programa WHERE estatus_asignacion = 0");
            $query->execute();
            $check2 = $con->pdo->prepare("SET foreign_key_checks = 1;");
            $check2->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model eliminarAsignacionesInactivas: " . $e->getMessage();
            return false;
        }
    }
    public static function asignarCapituloPrograma($idsalon, $idfecha, $idprograma, $idcapitulo)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO asignacion_capitulos_programa (fk_id_salon,fk_id_fechas,fk_id_programa,fk_id_capitulo,creado_por) VALUES (:fkSalon,:fkFechas,:fkPrograma,:idCapitulo,:creadoPor)");
            $query->execute([

                ':fkSalon' => base64_decode(base64_decode($idsalon)),
                ':fkFechas' => base64_decode(base64_decode($idfecha)),
                ':fkPrograma' => base64_decode(base64_decode($idprograma)),
                ':idCapitulo' => $idcapitulo,
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model asignarSalonPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function cat_capitulos($idsalon, $idfecha, $idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cp.*,(CASE WHEN (SELECT cpp.id_asignacion_capitulo FROM asignacion_capitulos_programa cpp WHERE cpp.fk_id_fechas = :idFechas AND cpp.fk_id_salon = :idSalon AND cpp.fk_id_capitulo = cp.id_capitulo AND cpp.estatus_asignacion = 1 GROUP BY cpp.fk_id_capitulo) IS NULL THEN 0 ELSE 1 END) AS asignado FROM cat_capitulos cp WHERE cp.fk_id_programa = :idPrograma AND cp.estatus_capitulo = 1 ORDER BY cp.nombre_capitulo;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idFechas' => base64_decode(base64_decode($idfecha)),
                ':idSalon' => base64_decode(base64_decode($idsalon)),
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_salones: " . $e->getMessage();
            return;
        }
    }
    public static function infoCapitulos($idfecha, $idsalon)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cp.id_capitulo,cp.nombre_capitulo,acp.* FROM asignacion_capitulos_programa acp INNER JOIN cat_capitulos cp ON cp.id_capitulo = acp.fk_id_capitulo WHERE acp.fk_id_fechas = :idFecha AND acp.fk_id_salon = :idSalon AND cp.estatus_capitulo = 1 AND acp.estatus_asignacion = 1;");
            $query->execute([
                ':idFecha' => base64_decode(base64_decode($idfecha)),
                ':idSalon' => base64_decode(base64_decode($idsalon))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoSalones: " . $e->getMessage();
            return;
        }
    }
    /* Actividades */
    public static function guardarActividades($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_actividades (fk_id_capitulo,fk_id_salon,fk_id_fechas,fk_id_programa,nombre_actividad,creado_por) VALUES (:fkCapitulo,:fkSalon,:fkFechas,:fkPrograma,:nombreActividad,:creadoPor)");
            $query->execute([

                ':fkCapitulo' => base64_decode(base64_decode($datos['idcapitulo'])),
                ':fkSalon' => base64_decode(base64_decode($datos['idsalon'])),
                ':fkFechas' => base64_decode(base64_decode($datos['idfecha'])),
                ':fkPrograma' => base64_decode(base64_decode($datos['idprograma'])),
                ':nombreActividad' => $datos['nueva_actividad'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $idactividad_resp = $con->pdo->lastInsertId();
            $con->pdo->commit();
            return $idactividad_resp;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarSalones: " . $e->getMessage();
            return false;
        }
    }
    public static function reasignarActividad($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE asignacion_actividades_programa SET fk_id_actividad = :fkActividad, estatus_asignacion = 0 WHERE id_asignacion_actividad = :idAsignacionActividad");
            $query->execute([
                ':fkActividad' => $datos['reasignar_actividad'],
                ':idAsignacionActividad' => base64_decode(base64_decode($datos['id_asignacion_actividad']))
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model reasignarActividad: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarAsignacionActividad($idActividad){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM asignacion_actividades_programa WHERE fk_id_actividad = :idActividad AND estatus_asignacion = 1");
            $query->execute([
                ':idActividad' => $idActividad
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarAsignacionActividad: " . $e->getMessage();
            return;
        }
    }
    public static function eliminarAsignacionesActividadesInactivas(){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $check = $con->pdo->prepare("SET foreign_key_checks = 0;");
            $check->execute();
            $query = $con->pdo->prepare("DELETE FROM asignacion_actividades_programa WHERE estatus_asignacion = 0");
            $query->execute();
            $check2 = $con->pdo->prepare("SET foreign_key_checks = 1;");
            $check2->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model eliminarAsignacionesActividadesInactivas: " . $e->getMessage();
            return false;
        }
    }
    public static function asignarActividadPrograma($idcapitulo, $idsalon, $idfecha, $idprograma, $idactividad)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO asignacion_actividades_programa (fk_id_capitulo,fk_id_salon,fk_id_fechas,fk_id_programa,fk_id_actividad,creado_por) VALUES (:fkCapitulo,:fkSalon,:fkFechas,:fkPrograma,:idActividad,:creadoPor)");
            $query->execute([

                ':fkCapitulo' => base64_decode(base64_decode($idcapitulo)),
                ':fkSalon' => base64_decode(base64_decode($idsalon)),
                ':fkFechas' => base64_decode(base64_decode($idfecha)),
                ':fkPrograma' => base64_decode(base64_decode($idprograma)),
                ':idActividad' => $idactividad,
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model asignarActividadPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function cat_actividades($idsalon, $idfecha, $idprograma, $idcapitulo)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT ca.*,(CASE WHEN (SELECT aap.id_asignacion_actividad FROM asignacion_actividades_programa aap WHERE aap.fk_id_fechas = :idFechas AND aap.fk_id_actividad = ca.id_actividad AND aap.fk_id_capitulo = :fkCapitulo AND aap.fk_id_salon = :fkSalon) IS NULL THEN 0 ELSE 1 END) AS asignado FROM cat_actividades ca WHERE ca.fk_id_programa = :idPrograma AND ca.estatus_actividad = 1 ORDER BY ca.nombre_actividad;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idFechas' => base64_decode(base64_decode($idfecha)),
                ':fkCapitulo' => base64_decode(base64_decode($idcapitulo)),
                ':fkSalon' => base64_decode(base64_decode($idsalon)),
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_actividades: " . $e->getMessage();
            return;
        }
    }
    public static function infoActividades($idfecha, $idsalon, $idcapitulo)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT ca.id_actividad,ca.nombre_actividad,aap.* FROM asignacion_actividades_programa aap INNER JOIN cat_actividades ca ON ca.id_actividad = aap.fk_id_actividad WHERE aap.fk_id_fechas = :idFecha AND aap.fk_id_salon = :idSalon AND aap.fk_id_capitulo = :idCapitulo AND ca.estatus_actividad = 1;");
            $query->execute([
                ':idFecha' => base64_decode(base64_decode($idfecha)),
                ':idSalon' => base64_decode(base64_decode($idsalon)),
                ':idCapitulo' => base64_decode(base64_decode($idcapitulo))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoActividades: " . $e->getMessage();
            return;
        }
    }
    /* Temas */
    public static function guardarTemas($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_temas (fk_id_actividad,fk_id_capitulo,fk_id_salon,fk_id_fechas,fk_id_programa,nombre_tema,creado_por) VALUES (:fkActividad,:fkCapitulo,:fkSalon,:fkFechas,:fkPrograma,:nombreTema,:creadoPor)");
            $query->execute([

                ':fkActividad' => base64_decode(base64_decode($datos['idactividad'])),
                ':fkCapitulo' => base64_decode(base64_decode($datos['idcapitulo'])),
                ':fkSalon' => base64_decode(base64_decode($datos['idsalon'])),
                ':fkFechas' => base64_decode(base64_decode($datos['idfecha'])),
                ':fkPrograma' => base64_decode(base64_decode($datos['idprograma'])),
                ':nombreTema' => $datos['nuevo_tema'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $idtema_resp = $con->pdo->lastInsertId();
            $con->pdo->commit();
            return $idtema_resp;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarTemas: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarTema($idtemaasignado)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM asignacion_temas_programa atp WHERE atp.id_asignacion_tema = :idAsignacionTema");
            $query->execute([
                ':idAsignacionTema' => $idtemaasignado
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarPrograma: " . $e->getMessage();
            return;
        }
    }
    public static function eliminarAsignacionTema($idtemaasignado){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("DELETE FROM asignacion_temas_programa WHERE id_asignacion_tema = :idAsignacion");
            $query->execute([
                ':idAsignacion' => $idtemaasignado
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model eliminarAsignacionTema: " . $e->getMessage();
            return false;
        }
    }
    public static function verificarAsignacion($idprofesor, $idfechas, $idprograma, $horainicial, $horafinal)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM asignacion_temas_programa WHERE fk_id_profesor = :fkProfesor AND fk_id_fechas = :fkFechas AND fk_id_programa = :fkPrograma AND ((hora_inicial BETWEEN '$horainicial' AND '$horafinal') OR (hora_final > '$horainicial'))");
            $query->execute([
                ':fkProfesor' => $idprofesor,
                ':fkFechas' => base64_decode(base64_decode($idfechas)),
                ':fkPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model verificarAsignacion: " . $e->getMessage();
            return;
        }
    }
    public static function asignarTemaPrograma($idcapitulo, $idsalon, $idfecha, $idprograma, $idactividad, $idtema, $datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO asignacion_temas_programa (fk_id_capitulo,fk_id_salon,fk_id_fechas,fk_id_programa,fk_id_actividad,fk_id_tema,hora_inicial,hora_final,fk_id_profesor,fk_id_modalidad,creado_por) VALUES (:fkCapitulo,:fkSalon,:fkFechas,:fkPrograma,:fkActividad,:idTema,:horaInicial,:horaFinal,:fkProfesor,:fkModalidad,:creadoPor)");
            $query->execute([

                ':fkCapitulo' => base64_decode(base64_decode($idcapitulo)),
                ':fkSalon' => base64_decode(base64_decode($idsalon)),
                ':fkFechas' => base64_decode(base64_decode($idfecha)),
                ':fkPrograma' => base64_decode(base64_decode($idprograma)),
                ':fkActividad' => base64_decode(base64_decode($idactividad)),
                ':idTema' => $idtema,
                ':horaInicial' => $datos['hora_inicial'],
                ':horaFinal' => $datos['hora_final'],
                ':fkProfesor' => $datos['profesor'],
                ':fkModalidad' => $datos['modalidad'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model asignarActividadPrograma: " . $e->getMessage();
            return false;
        }
    }
    public static function cat_temas($idfecha, $idsalon, $idcapitulo, $idactividad, $idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_temas ct WHERE fk_id_programa = :idPrograma AND estatus_tema = 1 ORDER BY ct.nombre_tema;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_actividades: " . $e->getMessage();
            return;
        }
    }
    public static function infoTemas($idfecha, $idsalon, $idcapitulo, $idactividad)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT ct.id_tema,ct.nombre_tema,atp.*,concat_ws(' ',cprr.siglas_prefijo,cpr.nombre_profesor,cpr.apellidop_profesor,cpr.apellidom_profesor) AS nombreprofesor,cm.nombre_modalidad FROM asignacion_temas_programa atp INNER JOIN cat_temas ct ON ct.id_tema = atp.fk_id_tema INNER JOIN cat_profesores cpr ON cpr.id_profesor = atp.fk_id_profesor INNER JOIN cat_modalida cm ON cm.id_modalidad = atp.fk_id_modalidad INNER JOIN cat_prefijos cprr ON cprr.id_prefijo = cpr.fk_id_prefijo WHERE atp.fk_id_fechas = :idFecha AND atp.fk_id_salon = :idSalon AND atp.fk_id_capitulo = :idCapitulo AND atp.fk_id_actividad = :idActividad AND ct.estatus_tema =1;");
            $query->execute([
                ':idFecha' => base64_decode(base64_decode($idfecha)),
                ':idSalon' => base64_decode(base64_decode($idsalon)),
                ':idCapitulo' => base64_decode(base64_decode($idcapitulo)),
                ':idActividad' => base64_decode(base64_decode($idactividad))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoActividades: " . $e->getMessage();
            return;
        }
    }
    /* Catalogos Generales*/
    public static function guardarProfesor($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_profesores (fk_id_prefijo,nombre_profesor,apellidop_profesor,apellidom_profesor,fk_id_pais,fk_id_estado,fk_id_lada,telefono_profesor,correo_profesor,creado_por) VALUES (:prefijo,:nombre,:apellidop,:apellidom,:pais,:estado,:lada,:telefono,:correo,:creadoPor)");
            $query->execute([

                ':prefijo' => $datos['prefijo'],
                ':nombre' => $datos['nombre_profesor'],
                ':apellidop' => $datos['apellidop_profesor'],
                ':apellidom' => $datos['apellidom_profesor'],
                ':pais' => $datos['pais'],
                ':estado' => $datos['estado'],
                ':lada' => (empty($datos['lada'])) ? '310' : $datos['lada'],
                ':telefono' => $datos['telefono_profesor'],
                ':correo' => $datos['correo_profesor'],
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $idtema_resp = $con->pdo->lastInsertId();
            $con->pdo->commit();
            return $idtema_resp;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model guardarTemas: " . $e->getMessage();
            return false;
        }
    }
    public static function cat_profesores()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cp.id_profesor,concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) as profesor,p.pais,e.estado FROM cat_profesores cp INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo INNER JOIN paises p ON p.id_pais = cp.fk_id_pais INNER JOIN estados e ON e.id_estado = cp.fk_id_estado WHERE cp.estatus_profesor = 1 ORDER BY profesor;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_actividades: " . $e->getMessage();
            return;
        }
    }
    public static function cat_modalidades()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_modalida WHERE estatus_modalidad = 1 ;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_actividades: " . $e->getMessage();
            return;
        }
    }
    public static function cat_prefijos()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_prefijos WHERE estatus_prefijo = 1 ;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_prefijos: " . $e->getMessage();
            return;
        }
    }
    public static function cat_ladas()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_ladas WHERE estatus_lada = 1 ;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_prefijos: " . $e->getMessage();
            return;
        }
    }
    public static function cat_paises()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM paises");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_paises: " . $e->getMessage();
            return;
        }
    }
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