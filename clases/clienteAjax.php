<?php
require_once("../config/database.php"); // Incluye el archivo database.php
require_once 'clienteFunciones.php';

$datos = [];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable

    if ($action == 'existeUsuario') {
        $resultado = usuarioExiste($_POST['usuario'], $pdo);
        $datos['ok'] = $resultado;
    } elseif ($action = 'existeEmail') {
        $datos['ok'] = emailExiste($_POST['email'], $pdo);
    }
}
echo json_encode($datos);
?>