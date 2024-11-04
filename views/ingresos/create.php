<!-- views/ingresos/create.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Ingreso</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>Registrar Ingreso</h1>
    <form action="../../index.php" method="POST">
        <label for="codigoEstudiante">Código del Estudiante:</label>
        <input type="text" id="codigoEstudiante" name="codigoEstudiante" required>

        <label for="nombreEstudiante">Nombre del Estudiante:</label>
        <input type="text" id="nombreEstudiante" name="nombreEstudiante" required>

        <label for="idPrograma">Programa:</label>
        <select id="idPrograma" name="idPrograma">
            <?php
            require_once '../../config/database.php';
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
</body>
</html>
