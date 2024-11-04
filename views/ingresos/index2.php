<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Ingresos</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>Consulta de Ingresos</h1>
    <form action="../../index.php" method="GET">
        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio">

        <label for="fechaFin">Fecha de Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin">

        <label for="codigoEstudiante">Código del Estudiante:</label>
        <input type="text" id="codigoEstudiante" name="codigoEstudiante">

        <button type="submit" name="action" value="consultarIngresos">Consultar</button>
    </form>

    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'consultarIngresos') {
        require_once '../../controllers/IngresoController.php';
        $controller = new IngresoController();
        $ingresos = $controller->consultarIngresos($_GET);
        
        if ($ingresos) {
            echo "<table><tr><th>Código Estudiante</th><th>Nombre</th><th>Programa</th><th>Sala</th><th>Responsable</th><th>Fecha</th><th>Hora de Ingreso</th><th>Hora de Salida</th></tr>";
            foreach ($ingresos as $ingreso) {
                echo "<tr><td>{$ingreso['codigoEstudiante']}</td><td>{$ingreso['nombreEstudiante']}</td><td>{$ingreso['programa']}</td><td>{$ingreso['sala']}</td><td>{$ingreso['responsable']}</td><td>{$ingreso['fechaIngreso']}</td><td>{$ingreso['horaIngreso']}</td><td>{$ingreso['horaSalida']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron ingresos para los filtros aplicados.</p>";
        }
    }
    ?>
</body>
</html>
