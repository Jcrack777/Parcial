<?php
session_start();

class Orden {
    private static $contador = 1;
    private $id;
    private $cliente;
    private $auto;
    private $estado;

    public function __construct($cliente, $auto) {
        $this->id = self::$contador++;
        $this->cliente = $cliente;
        $this->auto = $auto;
        $this->estado = 'iniciando';
    }

    public function getId() {
        return $this->id;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getAuto() {
        return $this->auto;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

class Taller {
    private $ordenes = [];

    public function agregarOrden($cliente, $auto) {
        $orden = new Orden($cliente, $auto);
        $this->ordenes[$orden->getId()] = $orden;
    }

    public function listarOrdenes() {
        return $this->ordenes;
    }
}

if (!isset($_SESSION['taller'])) {
    $_SESSION['taller'] = new Taller();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = [
        'nombre' => $_POST['nombre'],
        'direccion' => $_POST['direccion'],
        'telefono' => $_POST['telefono']
    ];
    $auto = [
        'marca' => $_POST['marca'],
        'modelo' => $_POST['modelo'],
        'color' => $_POST['color'],
        'placas' => $_POST['placas']
    ];
    $_SESSION['taller']->agregarOrden($cliente, $auto);
    echo "Orden agregada exitosamente. <a href='index.php'>Volver</a>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Agregar Orden</title>
</head>
<body>
    <h1>Agregar Nueva Orden</h1>
    <form action="" method="POST">
        Nombre: <input type="text" name="nombre" required><br>
        Dirección: <input type="text" name="direccion" required><br>
        Teléfono: <input type="text" name="telefono" required><br>
        Marca: <input type="text" name="marca" required><br>
        Modelo: <input type="text" name="modelo" required><br>
        Color: <input type="text" name="color" required><br>
        Placas: <input type="text" name="placas" required><br>
        <input type="submit" value="Agregar Orden">
    </form>
</body>
</html>
