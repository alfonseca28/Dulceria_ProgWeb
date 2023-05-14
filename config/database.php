<?php
function conectar() {
    $host = "localhost"; // Dirección del servidor de la base de datos
    $dbname = "dulceriaweb"; // Nombre de la base de datos
    $user = "root"; // Nombre de usuario de la base de datos
    $pass = "12345"; // Contraseña de la base de datos

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>
