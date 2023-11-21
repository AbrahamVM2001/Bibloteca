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