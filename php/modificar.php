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
            echo "El estado de la orden con ID $id se ha cambiado a $estado.";
        } else {
            echo "Orden no encontrada con ID: $id.";
        }
    }

    public function listarOrdenes() {
        return $this->ordenes;
    }
}

if (!isset($_SESSION['taller'])) {
    $_SESSION['taller'] = new Taller();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id']; 
    $nuevoEstado = $_POST['estado'];
    
    if (isset($_SESSION['taller']->listarOrdenes()[$id])) {
        $_SESSION['taller']->modificarEstado($id, $nuevoEstado);
    } else {
        echo "No se encontró la orden con ID: $id.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Modificar Estado</title>
</head>
<body>
    <h1>Modificar Estado de una Orden</h1>
    <form action="" method="POST">
        ID de la Orden: <input type="text" name="id" required><br>
        Nuevo Estado: 
        <select name="estado" required>
            <option value="iniciando">Iniciando</option>
            <option value="en proceso">En Proceso</option>
            <option value="finalizado">Finalizado</option>
        </select><br>
        <input type="submit" value="Modificar Estado">
    </form>
</body>
</html>
