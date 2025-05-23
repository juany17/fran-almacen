

require 'includes/funciones.php';
incluirTemplates('header', $inicio = true);
?>
    <main class="contenedor seccion">
        <h1>titulo</h1>
        <form class="formulario" id="formulario-producto">
            <fieldset>
                <legend>Datos del Producto</legend>

                <div class="campo">
                    <label for="nombre">Nombre del Producto:</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        placeholder="Ej: Arroz" 
                        required
                    >
                </div>

                <div class="campo">
                    <label for="precio">Precio (USD):</label>
                    <input 
                        type="number" 
                        id="precio" 
                        name="precio" 
                        placeholder="Ej: 2.99" 
                        min="0" 
                        step="0.01" 
                        required
                    >
                </div>
                <button type="submit" class="boton">Registrar</button>
            </fieldset>
        </form>

        <!-- Contenedor Independiente: Formulario de Cierre de Caja -->
        <div class="formulario-container">
            <h2>Cierre de Caja</h2>
            <form id="form-cierre" class="formulario" method="POST" action="index.php">
                <fieldset>
                <div class="campo">
                    <label for="cierre-fecha">Fecha:</label>
                    <input type="date" id="cierre-fecha" name="fecha" required>
                </div>
                <div class="campo">
                    <label for="cierre-hora">Hora:</label>
                    <input type="time" id="cierre-hora" name="hora" required>
                </div>
                <div class="campo">
                    <label for="cierre-total">Total (USD):</label>
                    <input type="number" id="cierre-total" name="total" min="0" step="0.01" required placeholder="Ej: 150.75">
                </div>
                <button type="submit" class="boton">Registrar Cierre</button>
                </fieldset>
            </form>
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="contactos.">contactos</a>
            </nav>
        </div>

        <p class="copyright">Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;</p>
    </footer>
    <script src="../../build/js/bundle.min.js"></script>
</body>
</html>