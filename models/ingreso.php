<?php
// models/Ingreso.php

require_once 'config/database.php';

class Ingreso {
    private $conn;
    private $table_name = "ingresos";

    public $id;
    public $codigoEstudiante;
    public $nombreEstudiante;
    public $idPrograma;
    public $fechaIngreso;
    public $horaIngreso;
    public $horaSalida;
    public $idResponsable;
    public $idSala;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET codigoEstudiante=:codigoEstudiante, nombreEstudiante=:nombreEstudiante, idPrograma=:idPrograma, fechaIngreso=:fechaIngreso, horaIngreso=:horaIngreso, idResponsable=:idResponsable, idSala=:idSala, created_at=NOW()";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":codigoEstudiante", $this->codigoEstudiante);
        $stmt->bindParam(":nombreEstudiante", $this->nombreEstudiante);
        $stmt->bindParam(":idPrograma", $this->idPrograma);
        $stmt->bindParam(":fechaIngreso", $this->fechaIngreso);
        $stmt->bindParam(":horaIngreso", $this->horaIngreso);
        $stmt->bindParam(":idResponsable", $this->idResponsable);
        $stmt->bindParam(":idSala", $this->idSala);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
