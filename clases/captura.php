<?php
require '../config/config.php';
require_once("../config/database.php"); // Incluye el archivo database.php

$pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable

// Obtiene los datos JSON enviados mediante la función file_get_contents y los decodifica en un array asociativo
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

// Imprime los datos recibidos para verificarlos
// echo '<pre>';
// print_r($datos);
// echo '</pre>';

// Datos del usuario de prueba para las compras en paypal
// Correo: sb-7dypv25799975@personal.example.com
// Contraseña: d_6zEv4C

// Verifica si los datos son un array y luego extrae los valores relevantes del array para utilizarlos en la inserción en la base de datos
if (is_array($datos)) {
    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

    $sql = "INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);

    $id = $pdo->lastInsertId();

    if ($id > 0) {
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {
                $query = "SELECT PRODUCTO_ID, PRODUCTO_NOMBRE, PRODUCTO_PRECIO FROM producto WHERE PRODUCTO_ID=? AND PRODUCTO_STATUS=1";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$clave]);
                $row_prod = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row_prod) {
                    $_precio = $row_prod['PRODUCTO_PRECIO'];

                    $sql_insert = $pdo->prepare("INSERT INTO detalle_compra (id_compra, PRODUCTO_ID, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
                    $sql_insert->execute([$id, $clave, $row_prod['PRODUCTO_NOMBRE'], $_precio, $cantidad]);
                }
                include 'enviar_email.php';
            }
            unset($_SESSION['carrito']);
        }
    }
}
?>