<?php

/**
 *
 */
class AdminModel extends ModelBase
{

    public function __construct()
    {
        parent::__construct();
    }
    public static function eventos(){
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
    public static function guardarEvento($datos){
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
    public static function guardarPrograma($datos){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO cat_programa (fk_id_evento,nombre_programa,creado_por) VALUES (:fkEvento,:nombrePrograma,:creadoPor)");
            $query->execute([
                
                ':fkEvento' => base64_decode(base64_decode($datos['evento'])),
                ':nombrePrograma' => $datos['nombre_programa'],
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
    public static function infoProgramas($evento){
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
    public static function guardarFechas($datos){
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
    public static function infoFechas($modulo){
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
    public static function guardarSalones($datos){
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
    public static function asignarSalonPrograma($idfecha,$idprograma,$idsalon){
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
    public static function cat_salones($idfecha,$idprograma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cs.*,(CASE WHEN (SELECT asp.id_asignacion_salon FROM asignacion_salones_programa asp WHERE asp.fk_id_fechas = :idFechas) IS NULL THEN 0 ELSE 1 END) AS asignado FROM cat_salones cs WHERE cs.fk_id_programa = :idPrograma AND cs.estatus_salon = 1;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma)),
                ':idFechas' => base64_decode(base64_decode($idfecha))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoSalones: " . $e->getMessage();
            return;
        }
    }
    public static function infoSalones($modulo){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_salones WHERE fk_id_fechas = :idFecha AND estatus_salon = 1");
            $query->execute([
                ':idFecha' => base64_decode(base64_decode($modulo))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoSalones: " . $e->getMessage();
            return;
        }
    }

















    /* Metodos anteriores */
    public static function revistas()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM revistas WHERE estatus_revista = 1");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function infoDocumentos($idRevista)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM documentos WHERE fk_id_revista = :idRevista AND estatus_documento = 1");
            $query->execute([
                ':idRevista' => $idRevista
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function infoEstadisticas(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT d.nombre_documento,(SELECT COUNT(*) FROM rastreo r WHERE r.tipo_rastreo = 1 AND r.fk_token_documento = d.token_documento) AS conteo_link,(SELECT COUNT(*) FROM rastreo r2 WHERE r2.tipo_rastreo = 0 AND r2.fk_token_documento = d.token_documento) AS conteo_qr FROM documentos d;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function documento($token)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM documentos WHERE token_documento = :token");
            $query->execute([
                ':token' => $token
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function verificarToken($token)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM documentos WHERE token_documento = :token");
            $query->execute([
                ':token' => $token
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function subirDocumento($datos, $doc, $token, $liga, $qr)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO documentos (fk_id_revista,nombre_documento,ruta_documento,token_documento,liga_documento,codigo_qr,creado_por) VALUES (:idRevista,:nombreDocumento,:rutaDocumento,:token,:liga,:codigoQr,:creadoPor)");
            $query->execute([
                ':idRevista' => base64_decode(base64_decode($datos['revista'])),
                ':nombreDocumento' => $datos['nombre_documento'],
                ':rutaDocumento' => $doc,
                ':token' => $token,
                ':liga' => $liga,
                ':codigoQr' => $qr,
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $idDocumento = $con->pdo->lastInsertId();
            $con->pdo->commit();
            return $idDocumento;
        } catch (PDOException $e) {
            echo "Error recopilado model subirDocumento: " . $e->getMessage();
            return false;
        }
    }
    public static function guardarCarpeta($datos){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO revistas (anio_revista,autor_revista,creado_por) VALUES (:anio,:autor,:creadoPor)");
            $query->execute([
                ':autor' => $datos['nombre_autor'],
                ':anio' => date('Y'),
                ':creadoPor' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error recopilado model guardarCarpeta: " . $e->getMessage();
            return false;
        }
    }
    public static function actualizarDocumento($datos, $doc)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE documentos SET nombre_documento = :nombreDocumento, ruta_documento = :documento WHERE id_documento = :idDocumento");
            $query->execute([
                ':idDocumento' => $datos['id_documento'],
                ':nombreDocumento' => $datos['nombre_documento'],
                ':documento' => $doc,
            ]);
            $idDocumento = $con->pdo->lastInsertId();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error recopilado model actualizarDocumento: " . $e->getMessage();
            return false;
        }
    }
    public static function getDocumento($idDocumento)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM documentos WHERE id_documento = :idDocumento");
            $query->execute([
                ':idDocumento' => $idDocumento
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function rastreo($token,$tipo){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("INSERT INTO rastreo (fk_token_documento,tipo_rastreo) VALUES (:token,:tipo)");
            $query->execute([
                ':token' => $token,
                ':tipo' => $tipo
            ]);
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error recopilado model guardarCarpeta: " . $e->getMessage();
            return false;
        }
    }
}