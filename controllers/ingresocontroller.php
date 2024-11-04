<?php
require_once 'config/database.php';

class IngresoController {

    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Método para registrar un ingreso
    public function createIngreso($data) {
        $sql = "INSERT INTO ingresos (codigoEstudiante, nombreEstudiante, idPrograma, fechaIngreso, horaIngreso, idSala, idResponsable, created_at, updated_at) 
                VALUES (:codigoEstudiante, :nombreEstudiante, :idPrograma, :fechaIngreso, :horaIngreso, :idSala, :idResponsable, NOW(), NOW())";
        
        $stmt = $this->db->prepare($sql);

        // Vincular los datos
        $stmt->bindParam(':codigoEstudiante', $data['codigoEstudiante']);
        $stmt->bindParam(':nombreEstudiante', $data['nombreEstudiante']);
        $stmt->bindParam(':idPrograma', $data['idPrograma']);
        $stmt->bindParam(':fechaIngreso', $data['fechaIngreso']);
        $stmt->bindParam(':horaIngreso', $data['horaIngreso']);
        $stmt->bindParam(':idSala', $data['idSala']);
        $stmt->bindParam(':idResponsable', $data['idResponsable']);

        if ($stmt->execute()) {
            return "Ingreso registrado exitosamente.";
        } else {
            return "Error al registrar el ingreso.";
        }
    }

    // Método para consultar ingresos con filtros
    public function consultarIngresos($filtros) {
        $sql = "SELECT i.codigoEstudiante, i.nombreEstudiante, p.nombre as programa, s.nombre as sala, r.nombre as responsable, 
                       i.fechaIngreso, i.horaIngreso, i.horaSalida 
                FROM ingresos i 
                INNER JOIN programas p ON i.idPrograma = p.id 
                INNER JOIN salas s ON i.idSala = s.id 
                INNER JOIN responsables r ON i.idResponsable = r.id 
                WHERE 1=1";

        // Aplicar filtros si existen
        if (!empty($filtros['fechaInicio'])) {
            $sql .= " AND i.fechaIngreso >= :fechaInicio";
        }
        if (!empty($filtros['fechaFin'])) {
            $sql .= " AND i.fechaIngreso <= :fechaFin";
        }
        if (!empty($filtros['codigoEstudiante'])) {
            $sql .= " AND i.codigoEstudiante = :codigoEstudiante";
        }
        if (!empty($filtros['idPrograma'])) {
            $sql .= " AND i.idPrograma = :idPrograma";
        }
        if (!empty($filtros['idResponsable'])) {
            $sql .= " AND i.idResponsable = :idResponsable";
        }

        $stmt = $this->db->prepare($sql);

        // Vincular los filtros si existen
        if (!empty($filtros['fechaInicio'])) {
            $stmt->bindParam(':fechaInicio', $filtros['fechaInicio']);
        }
        if (!empty($filtros['fechaFin'])) {
            $stmt->bindParam(':fechaFin', $filtros['fechaFin']);
        }
        if (!empty($filtros['codigoEstudiante'])) {
            $stmt->bindParam(':codigoEstudiante', $filtros['codigoEstudiante']);
        }
        if (!empty($filtros['idPrograma'])) {
            $stmt->bindParam(':idPrograma', $filtros['idPrograma']);
        }
        if (!empty($filtros['idResponsable'])) {
            $stmt->bindParam(':idResponsable', $filtros['idResponsable']);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
