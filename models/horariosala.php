<?php
// models/HorarioSala.php

require_once 'config/database.php';

class HorarioSala {
    private $conn;
    private $table_name = "horarios_salas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function verificarDisponibilidad($idSala, $fecha, $hora) {
        $diaSemana = date('l', strtotime($fecha)); // Nombre del día
        $query = "SELECT * FROM " . $this->table_name . " WHERE idSala = :idSala AND dia LIKE :dia AND horaInicio <= :hora AND horaFin >= :hora";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idSala', $idSala);
        $stmt->bindParam(':dia', $diaSemana);
        $stmt->bindParam(':hora', $hora);

        $stmt->execute();
        
        return $stmt->rowCount() == 0; // Si no hay registros, está disponible
    }
}
