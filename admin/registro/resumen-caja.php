<?php

require '../../includes/funciones.php';
$auth = estaAutententicado();

if(!$auth) {
    header('Location: /');
}


require '../../includes/config/database.php';

$db = conectarDB();

$consulta = "SELECT id_registro, fecha, hora, total, estado, descripcion FROM cierre_caja";
$resultado = mysqli_query($db, $consulta);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_registro'] ?? null;
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if($id) {
        $query = "DELETE FROM cierre_caja WHERE id_registro = ${id}";
        $eliminado = mysqli_query($db, $query);

        if($eliminado){
            header('Location: resumen-caja.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Caja</title>
    <link rel="stylesheet" href="/build/css/app.css">
    <style>
        /* Estilos como ya tenías */
    </style>
</head>
<body>

    <div class="contenedor">
        <header>
        <div class="contenedor contenido-header">
        <div class="barra">
            <a href="/admin/index.php">
                    <H1 class="inicio">Despensa Francesca</H1>
                </a>
                <a href="/logout.php" class="login-link">Cerrar Sesión</a>
                </a>
            </div>
            </div>
        </header>

        <h1>Resumen de Caja</h1>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Monto</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td><?php echo $fila['hora']; ?></td>
                    <td>$<?php echo number_format($fila['total'], 2); ?></td>
                    <td class="<?php echo strtolower($fila['estado']) === 'ingreso' ? 'ingreso' : 'egreso'; ?>">
                        <?php echo ucfirst($fila['estado']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este registro?');">
                            <input type="hidden" name="id_registro" value="<?php echo $fila['id_registro']; ?>">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a href="/admin/index.php" class="volver">← Volver al inicio</a>

        <button onclick="exportarPDF()">Exportar a PDF</button>

        <script>
    async function exportarPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Agregar título
        doc.setFontSize(18);
        doc.text('Resumen de Caja', 14, 22);

        // Seleccionar la tabla y convertirla
        doc.autoTable({
            html: 'table', // Usa la tabla HTML existente
            startY: 30,    // Espacio desde arriba
            theme: 'grid',
            styles: {
                fontSize: 10
            }
        });

        // Descargar el PDF
        doc.save('resumen_caja.pdf');
    }
    </script>

        <footer class="footer seccion">
            <p class="copyright">Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;</p>
        </footer>
    </div>

    <script src="/build/js/bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>


</body>
</html>
