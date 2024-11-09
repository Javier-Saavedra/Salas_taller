<?php
require_once 'controllers/IngresoController.php';
$controller = new IngresoController();

// Obtener el filtro seleccionado
$filtro = $_GET['filtro_fecha'] ?? 'hoy';
$datosIngresos = $controller->obtenerIngresosPorFiltro($filtro);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Registro de Sala de Cómputo</title>
    <!-- Asegúrate de que la ruta al CSS sea correcta -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Sistema de Registro de Sala de Cómputo</h1>

    <!-- Botones de navegación -->
    <nav>
        <button onclick="window.location.href='registro.php'">Registrar Ingreso</button>
        <button onclick="window.location.href='consulta.php'">Consultar Ingresos</button>
    </nav>

    <!-- Sección de filtro e ingresos -->
    <div class="ingresos-diarios">
        <h2>Ingresos del Día</h2>
        
        <div class="filtro-fecha">
            <form method="GET" class="form-filtro">
                <select name="filtro_fecha" onchange="this.form.submit()">
                    <option value="hoy" <?php echo ($filtro == 'hoy') ? 'selected' : ''; ?>>Hoy</option>
                    <option value="ayer" <?php echo ($filtro == 'ayer') ? 'selected' : ''; ?>>Ayer</option>
                    <option value="semana" <?php echo ($filtro == 'semana') ? 'selected' : ''; ?>>Última semana</option>
                </select>
            </form>
        </div>

        <div class="resumen-diario">
            <h3><?php echo $datosIngresos['titulo']; ?></h3>
            <p>Total de ingresos: <strong><?php echo $datosIngresos['total']; ?></strong></p>
            
            <?php if ($datosIngresos['total'] > 0): ?>
                <table class="tabla-ingresos">
                    <tr>
                        <th>Código</th>
                        <th>Estudiante</th>
                        <th>Programa</th>
                        <th>Sala</th>
                        <th>Responsable</th>
                        <th>Hora Ingreso</th>
                        <th>Hora Salida</th>
                    </tr>
                    <?php foreach ($datosIngresos['ingresos'] as $ingreso): ?>
                        <tr>
                            <td><?php echo $ingreso['codigoEstudiante']; ?></td>
                            <td><?php echo $ingreso['nombreEstudiante']; ?></td>
                            <td><?php echo $ingreso['programa']; ?></td>
                            <td><?php echo $ingreso['sala']; ?></td>
                            <td><?php echo $ingreso['responsable']; ?></td>
                            <td><?php echo $ingreso['horaIngreso']; ?></td>
                            <td><?php echo $ingreso['horaSalida'] ?? 'Aún no sale'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No hay ingresos registrados para el período seleccionado.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($mensaje)): ?>
        <div class="mensaje"><?php echo $mensaje; ?></div>
    <?php endif; ?>
</body>
</html>
