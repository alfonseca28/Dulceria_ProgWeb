<?php
require '../config/config.php';
require_once("../config/database.php"); // Incluye el archivo database.php

$pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable

// Obtiene los datos JSON enviados mediante la función file_get_contents y los decodifica en un array asociativo
$json=file_get_contents('php://input');
$datos=json_decode($json,true);

// Imprime los datos recibidos para verificarlos
echo '<pre>';
print_r($datos);
echo '</pre>';

// Verifica si los datos son un array y luego extrae los valores relevantes del array para utilizarlos en la inserción en la base de datos
if(is_array($datos)){
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
}
?>