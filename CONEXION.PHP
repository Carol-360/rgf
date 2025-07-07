<?php
$conexion = new mysqli("localhost", "root", "", "pasteleria");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

// Recibir datos
$accion = isset($_POST["accion"]) ? $_POST["accion"] : null;
$pasteldeseado = isset($_POST["pasteldeseado"]) ? $_POST["pasteldeseado"] : null;
$tamaño = isset($_POST["Tamaño"]) ? $_POST["Tamaño"] : null;
$diseño = isset($_POST["Diseño"]) ? $_POST["Diseño"] : null;
$Numerodepedido = isset($_POST["Numerodepedido"]) ? $_POST["Numerodepedido"] : null;

if ($accion === "eliminar" && !empty($Numerodepedido)) {
    $stmt = $conexion->prepare("DELETE FROM ventas WHERE Numerodepedido = ?");
    $stmt->bind_param("s", $Numerodepedido);

    if ($stmt->execute()) {
        echo "El pedido se eliminó correctamente.";
    } else {
        echo "Error al eliminar pedido: " . $stmt->error;
    }

    $stmt->close();

} elseif ($accion === "insertar" && $pasteldeseado && $tamaño && $diseño && $Numerodepedido) {
    $stmt = $conexion->prepare("INSERT INTO ventas (pasteldeseado, Tamaño, Diseño, Numerodepedido) 
    VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $pasteldeseado, $tamaño, $diseño, $Numerodepedido);

    if ($stmt->execute()) {
        echo "Pedido guardado correctamente.";
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "Acción no válida o datos incompletos.";
}

$conexion->close();
?>
