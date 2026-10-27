<?php
// Función que evalúa los requisitos
function academia($nombre, $edad, $estatura) {
    // Verificar si la edad está entre 18 y 25 años, y la estatura es mayor o igual a 1.85m
    if ($edad >= 18 && $edad <= 25 && $estatura >= 1.85) {
        return "<strong>¡Felicidades!</strong> $nombre, has sido aceptado en la academia.";
    } else {
        return "<strong>Lo sentimos</strong>, $nombre. No cumples con los requisitos para ingresar a la academia.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la solicitud</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Gracias Por tu Solicitud!</h1>
    </header>
    <main>
        <section>
            <h1>Datos ingresados:</h1>
            <?php
                $nombre = $_POST["nombre"];
                $edad = intval($_POST["edad"]);
                $estatura = floatval($_POST["estatura"]);    
            
            ?>
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
            <p><strong>Edad:</strong> <?php echo $edad; ?></p>
            <p><strong>Estatura:</strong> <?php echo $estatura; ?> m</p>

        </section>
        <section>
            <h1>Resultado de la solicitud</h1>
            <?php
                // Llamar a la función y guardar el mensaje de respuesta
                $mensaje = academia($nombre, $edad, $estatura);
                echo "<p>$mensaje</p>";
            ?>
            <br><a href="index.html">Volver al formulario</a>
        </section>
    </main>
</body>
</html>

