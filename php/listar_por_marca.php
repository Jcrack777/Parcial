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

    public function listarPorMarca($marca) {
        return array_filter($this->ordenes, function($orden) use ($marca) {
            return $orden->getAuto()['marca'] === $marca;
        });
    }
}

if (!isset($_SESSION['taller'])) {
    $_SESSION['taller'] = new Taller();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $resultado = $_SESSION['taller']->listarPorMarca($marca);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Listar Órdenes por Marca</title>
</head>
<body>
    <h1>Listar Órdenes por Marca</h1>
    <form action="" method="POST">
        Marca: <input type="text" name="marca" required><br>
        <input type="submit" value="Buscar">
    </form>

    <h2>Resultados</h2>
    <ul>
        <?php if (isset($resultado) && !empty($resultado)): ?>
            <?php foreach ($resultado as $orden): ?>
                <li>ID: <?php echo $orden->getId(); ?>, Cliente: <?php echo $orden->getCliente()['nombre']; ?>, Estado: <?php echo $orden->getEstado(); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No se encontraron órdenes para esa marca.</li>
        <?php endif; ?>
    </ul>
    <a href="index.php">Volver</a>
</body>
</html>
