<?php
require 'config/config.php';
require_once("config/database.php"); // Incluye el archivo database.php

$pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulcería - Purrfections</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <?php include 'menu.php'; ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div id="choco">
                        <img src="img/logo/logo_fondo.png" class="img-fluid rounded" alt="Imagen de chocolate" width="600">
                    </div>

                </div>
                <div class="col-md-6">
                    <h2 id="inicio" style="color: rgb(138, 68, 68);"><u><strong>Sobre nosotros</strong></u></h2>
                    <div class="textini">
                        <p style="text-align: justify;">Somos una empresa 100% Mexicana especializada en la venta de materias primas ubicados en Boca del Río Ver. Estamos posicionados como una de las mejores comercializadoras de artículos de fiesta, productos biodegradables, dulces, piñatas, chocolates, botanas, cacahuates, desechables y mucho más.</p>
                        <p style="text-align: justify;">Visítanos en nuestra sucursal o a través de nuestra página web y podrás encontrar productos de temporada de marcas reconocidas.</p>
                        <p style="text-align: justify;">Tenemos un gran catálogo de dulces, un amplio surtido de desechables y artículos como globos y decoraciones para fiestas.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>