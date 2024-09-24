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

$ordenes = $_SESSION['taller']->listarOrdenes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Listar Órdenes</title>

</head>
<body>
    <h1>Listar Todas las Órdenes</h1>
    <ul>
        <?php if (!empty($ordenes)): ?>
            <?php foreach ($ordenes as $orden): ?>
                <li>ID: <?php echo $orden->getId(); ?>, Cliente: <?php echo $orden->getCliente()['nombre']; ?>, Estado: <?php echo $orden->getEstado(); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No hay órdenes registradas.</li>
        <?php endif; ?>
    </ul>
    <a href="index.php">Volver</a>
</body>
</html>
