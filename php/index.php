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

    public function modificarEstado($id, $estado) {
        if (isset($this->ordenes[$id])) {
            $this->ordenes[$id]->setEstado($estado);
        }
    }

    public function listarOrdenes() {
        return $this->ordenes;
    }

    public function buscarPorPlacas($placas) {
        return array_filter($this->ordenes, function($orden) use ($placas) {
            return $orden->getAuto()['placas'] === $placas;
        });
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

$ordenes = $_SESSION['taller']->listarOrdenes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Taller Mecánico</title>

</head>
<body>
    <h1>Bienvenido al Taller Mecánico</h1>

    <h2>Órdenes</h2>
    <ul>
        <?php foreach ($ordenes as $orden): ?>
            <li>ID: <?php echo $orden->getId(); ?>, Cliente: <?php echo $orden->getCliente()['nombre']; ?>, Estado: <?php echo $orden->getEstado(); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2><a href="agregar.php">Agregar Nueva Orden</a></h2>
    <h2><a href="modificar.php">Modificar Estado de una Orden</a></h2>
    <h2><a href="consultar.php">Consultar Órdenes</a></h2>
    <h2><a href="listar_por_marca.php">Listar Órdenes por Marca</a></h2>
    <h2><a href="listar.php">Listar ordenes</a></h2>
</body>
</html>
