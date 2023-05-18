<?php
require '../config/config.php';
require '../config/database.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    // $action = isset($_POST['id']) ? $_POST['id'] : 0;
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;

    if ($action == 'agregar') {
        $action = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);
        if ($respuesta > 0) {
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }
        $datos['sub'] = MONEDA . number_format($respuesta, 2, '.', '.');
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

echo json_encode($datos);

function agregar($id, $cantidad)
{
    $res = 0;
    if ($id > 0 && $cantidad > 0 && is_numeric(($cantidad))) {
        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] = $cantidad;

            // $db = new Database();
            $pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable
            $query = "SELECT PRODUCTO_PRECIO FROM producto WHERE PRODUCTO_ID=? AND PRODUCTO_STATUS=1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $precio = $row['PRODUCTO_PRECIO'];
                $id = $row['PRODUCTO_ID'];
                $res = $cantidad * $precio;
                return $res;
            }
        } else {
            return $res;
        }
    }
}
