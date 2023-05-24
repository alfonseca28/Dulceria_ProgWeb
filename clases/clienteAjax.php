<?php
require_once("../config/database.php"); // Incluye el archivo database.php
require_once 'clienteFunciones.php';

$datos = [];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'existeUsuario') {
        $pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable
        $resultado = usuarioExiste($_POST['usuario'], $pdo);
        $datos['ok'] = $resultado;
    }
}
echo json_encode($datos);
?>