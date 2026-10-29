<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL AVIADOR S.A. | Formulario</title>
</head>

<body>
    <h2>Bienvenido al formulario de EL AVIADOR S.A.</h2>

    <p>Para calcular el precio final de su viaje, complete los siguientes campos:</p>

    <form action="procesar.php" method="POST">
        <label for="id">ID:</label>
        <input type="number" id="id" name="id" min="0" required>
        <br><br>

        <label for="nombre">Nombre del cliente:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="tipo">Tipo de avión:</label>
        <select id="tipo" name="tipo" required>
            <option value="" selected disabled>Seleccione un tipo</option>
            <option value="0">Tipo 0</option>
            <option value="1">Tipo 1</option>
            <option value="2">Tipo 2</option>
            <option value="3">Tipo 3</option>
        </select>
        <br><br>

        <label for="cantidad">Cantidad de hectáreas:</label>
        <input type="number" id="cantidad" name="cantidad" min="0.01" step="any" required>
        <br><br>

        <button type="submit">Calcular precio</button>
    </form>
</body>

</html>