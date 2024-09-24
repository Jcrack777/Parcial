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
}

if (!isset($_SESSION['taller'])) {
    $_SESSION['taller'] = new Taller();
}

$ordenes = $_SESSION['taller']->listarOrdenes();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placas = $_POST['placas'];
    $resultado = $_SESSION['taller']->buscarPorPlacas($placas);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Consultar Órdenes</title>
</head>
<body>
    <h1>Consultar Órdenes</h1>
    <form action="" method="POST">
        Placas: <input type="text" name="placas" required><br>
        <input type="submit" value="Buscar">
    </form>

    <h2>Resultados</h2>
    <ul>
        <?php if (isset($resultado) && !empty($resultado)): ?>
            <?php foreach ($resultado as $orden): ?>
                <li>ID: <?php echo $orden->getId(); ?>, Cliente: <?php echo $orden->getCliente()['nombre']; ?>, Estado: <?php echo $orden->getEstado(); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No se encontraron órdenes con esas placas.</li>
        <?php endif; ?>
    </ul>
    <a href="index.php">Volver</a>
</body>
</html>
