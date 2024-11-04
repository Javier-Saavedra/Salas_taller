<?php
require_once 'controllers/IngresoController.php';

$controller = new IngresoController();
$mensaje = "";

// Manejo de acciones del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["action"] === "createIngreso") {
        // Recoger datos y registrar el ingreso
        $data = [
            "codigoEstudiante" => $_POST["codigoEstudiante"],
            "nombreEstudiante" => $_POST["nombreEstudiante"],
            "idPrograma" => $_POST["idPrograma"],
            "idSala" => $_POST["idSala"],
            "idResponsable" => $_POST["idResponsable"],
            "fechaIngreso" => date("Y-m-d"),
            "horaIngreso" => date("H:i:s")
        ];
        $mensaje = $controller->createIngreso($data);
    } elseif ($_POST["action"] === "consultarIngresos") {
        // Recoger filtros y consultar ingresos
        $filtros = [
            "fechaInicio" => $_POST["fechaInicio"] ?? null,
            "fechaFin" => $_POST["fechaFin"] ?? null,
            "codigoEstudiante" => $_POST["codigoEstudiante"] ?? null,
            "idPrograma" => $_POST["idPrograma"] ?? null,
            "idResponsable" => $_POST["idResponsable"] ?? null
        ];
        $ingresos = $controller->consultarIngresos($filtros);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Sala de Cómputo</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Sistema de Registro de Sala de Cómputo</h1>

    <!-- Mensaje de éxito o error -->
    <?php if ($mensaje): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <!-- Opciones del Menú -->
    <nav>
        <button onclick="mostrarSeccion('registroIngreso')">Registrar Ingreso</button>
        <button onclick="mostrarSeccion('consultaIngreso')">Consultar Ingresos</button>
    </nav>

    <!-- Sección de Registro de Ingreso -->
    <section id="registroIngreso" style="display: none;">
        <h2>Registrar Ingreso</h2>
        <form action="index.php" method="POST">
            <label for="codigoEstudiante">Código del Estudiante:</label>
            <input type="text" id="codigoEstudiante" name="codigoEstudiante" required>

            <label for="nombreEstudiante">Nombre del Estudiante:</label>
            <input type="text" id="nombreEstudiante" name="nombreEstudiante" required>

            <label for="idPrograma">Programa:</label>
            <select id="idPrograma" name="idPrograma">
                <?php
                require_once 'config/database.php';
                $db = (new Database())->getConnection();
                $query = "SELECT id, nombre FROM programas";
                $stmt = $db->prepare($query);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>

            <label for="idSala">Sala:</label>
            <select id="idSala" name="idSala">
                <?php
                $query = "SELECT id, nombre FROM salas";
                $stmt = $db->prepare($query);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>

            <label for="idResponsable">Responsable:</label>
            <select id="idResponsable" name="idResponsable">
                <?php
                $query = "SELECT id, nombre FROM responsables";
                $stmt = $db->prepare($query);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>

            <button type="submit" name="action" value="createIngreso">Registrar</button>
        </form>
    </section>

    <!-- Sección de Consulta de Ingresos -->
    <section id="consultaIngreso" style="display: none;">
        <h2>Consultar Ingresos</h2>
        <form action="index.php" method="POST">
            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio">

            <label for="fechaFin">Fecha de Fin:</label>
            <input type="date" id="fechaFin" name="fechaFin">

            <label for="codigoEstudiante">Código del Estudiante:</label>
            <input type="text" id="codigoEstudiante" name="codigoEstudiante">

            <label for="idPrograma">Programa:</label>
            <select id="idPrograma" name="idPrograma">
                <option value="">Todos</option>
                <?php
                $query = "SELECT id, nombre FROM programas";
                $stmt = $db->prepare($query);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>

            <label for="idResponsable">Responsable:</label>
            <select id="idResponsable" name="idResponsable">
                <option value="">Todos</option>
                <?php
                $query = "SELECT id, nombre FROM responsables";
                $stmt = $db->prepare($query);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>

            <button type="submit" name="action" value="consultarIngresos">Consultar</button>
        </form>

        <?php if (isset($ingresos) && !empty($ingresos)): ?>
            <h3>Resultados de la Consulta:</h3>
            <table>
                <tr>
                    <th>Código Estudiante</th>
                    <th>Nombre</th>
                    <th>Programa</th>
                    <th>Sala</th>
                    <th>Responsable</th>
                    <th>Fecha</th>
                    <th>Hora de Ingreso</th>
                    <th>Hora de Salida</th>
                </tr>
                <?php foreach ($ingresos as $ingreso): ?>
                    <tr>
                        <td><?php echo $ingreso['codigoEstudiante']; ?></td>
                        <td><?php echo $ingreso['nombreEstudiante']; ?></td>
                        <td><?php echo $ingreso['programa']; ?></td>
                        <td><?php echo $ingreso['sala']; ?></td>
                        <td><?php echo $ingreso['responsable']; ?></td>
                        <td><?php echo $ingreso['fechaIngreso']; ?></td>
                        <td><?php echo $ingreso['horaIngreso']; ?></td>
                        <td><?php echo $ingreso['horaSalida']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (isset($ingresos)): ?>
            <p>No se encontraron resultados para los filtros aplicados.</p>
        <?php endif; ?>
    </section>

    <script>
        function mostrarSeccion(id) {
            document.getElementById('registroIngreso').style.display = 'none';
            document.getElementById('consultaIngreso').style.display = 'none';
            document.getElementById(id).style.display = 'block';
        }
    </script>
</body>
</html>
