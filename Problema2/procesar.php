<?php

function calcularImpuesto($costo)
{
    return $costo * 0.07;
}

class Avion
{
    public $id;
    public $nombre;
    public $tipo;
    public $cantidad;

    public function __construct($id, $nombre, $tipo, $cantidad)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public function calcularCostoPorTipo()
    {
        switch ($this->tipo) {
            case 0:
                return 1000;
            case 1:
                return 800;
            case 2:
                return 600;
            case 3:
                return 400;
            default:
                throw new Exception("Tipo de avión inválido.");
        }
    }

    public function calcularDescuento($precioBase)
    {
        if ($this->tipo == 0 || $this->tipo == 1) {
            return $precioBase * 0.10;
        }

        return $precioBase * 0.05;
    }

    public function precio()
    {
        $base = $this->cantidad * $this->calcularCostoPorTipo();
        $descuento = $this->calcularDescuento($base);
        $subtotal = $base - $descuento;
        $impuesto = calcularImpuesto($subtotal);
        $final = $subtotal + $impuesto;

        return [
            "base" => $base,
            "impuesto" => $impuesto,
            "descuento" => $descuento,
            "final" => $final
        ];
    }
}

function validarId($id)
{
    if ($id === "") {
        throw new Exception("El ID es obligatorio.");
    }

    if (!ctype_digit($id)) {
        throw new Exception("El ID debe ser un entero no negativo.");
    }
}

function validarNombre($nombre)
{
    if (trim($nombre) === "") {
        throw new Exception("El nombre del cliente es obligatorio.");
    }

    if (strlen($nombre) < 3) {
        throw new Exception("El nombre debe tener al menos 3 caracteres.");
    }

    if (is_numeric($nombre)) {
        throw new Exception("El nombre del cliente no puede ser numérico.");
    }
}

function validarTipo($tipo)
{
    if ($tipo === "" || !in_array($tipo, ["0", "1", "2", "3"], true)) {
        throw new Exception("Debe seleccionar un tipo de avión válido.");
    }
}

function validarCantidad($cantidad)
{
    if ($cantidad === "" || !is_numeric($cantidad)) {
        throw new Exception("La cantidad de hectáreas debe ser numérica.");
    }

    if ((float) $cantidad <= 0) {
        throw new Exception("La cantidad de hectáreas debe ser mayor que cero.");
    }
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Acceso no válido. Envíe el formulario primero.");
}

try {
    $id = trim($_POST["id"] ?? "");
    $nombre = trim($_POST["nombre"] ?? "");
    $tipo = $_POST["tipo"] ?? "";
    $cantidad = trim($_POST["cantidad"] ?? "");

    validarId($id);
    validarNombre($nombre);
    validarTipo($tipo);
    validarCantidad($cantidad);

    $avion = new Avion(
        (int) $id,
        $nombre,
        (int) $tipo,
        (float) $cantidad
    );

    $resultado = $avion->precio();

    $precioBase = $resultado["base"];
    $impuesto = $resultado["impuesto"];
    $descuento = $resultado["descuento"];
    $precioFinal = $resultado["final"];

    // Crear un registro de texto con los datos procesados.
    $registro = "ID: $id\n"
        . "Nombre: $nombre\n"
        . "Tipo de avión: $tipo\n"
        . "Hectáreas: $cantidad\n"
        . "Precio base: B/. " . number_format($precioBase, 2) . "\n"
        . "Impuesto (7%): B/. " . number_format($impuesto, 2) . "\n"
        . "Descuento: B/. " . number_format($descuento, 2) . "\n"
        . "Precio final: B/. " . number_format($precioFinal, 2) . "\n"
        . "------------------------------\n";

    $guardado = file_put_contents(
        __DIR__ . "/registro.txt",
        $registro,
        FILE_APPEND | LOCK_EX
    );

    if ($guardado === false) {
        throw new Exception("No se pudo guardar el registro en el archivo.");
    }

} catch (Throwable $e) {
    echo "<h2>Error</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8") . "</p>";
    echo '<p><a href="index.html">Volver al formulario</a></p>';
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado | EL AVIADOR S.A.</title>
</head>

<body>
    <h2>Resultado de la fumigación</h2>

    <p>ID: <?= htmlspecialchars((string) $id, ENT_QUOTES, "UTF-8") ?></p>
    <p>Nombre del cliente: <?= htmlspecialchars($nombre, ENT_QUOTES, "UTF-8") ?></p>
    <p>Cantidad de hectáreas: <?= number_format((float) $cantidad, 2) ?></p>
    <p>Tipo de avión: <?= (int) $tipo ?></p>
    <p>Precio base: B/. <?= number_format($precioBase, 2) ?></p>
    <p>Impuesto (7%): B/. <?= number_format($impuesto, 2) ?></p>
    <p>Descuento: B/. <?= number_format($descuento, 2) ?></p>
    <h3>Precio a pagar: B/. <?= number_format($precioFinal, 2) ?></h3>

    <p>Los datos se guardaron en el archivo de texto.</p>
    <a href="formulario.php">Volver al formulario</a>
</body>

</html>