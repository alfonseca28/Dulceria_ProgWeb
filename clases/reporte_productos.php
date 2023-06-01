<?php
require '../config/config.php';
require_once("../config/database.php");

$pdo = conectar();

// Consulta SQL para obtener todos los productos con la categoría, el stock y el estado
$sql = "SELECT PRODUCTO_ID, PRODUCTO_NOMBRE, PRODUCTO_PRECIO, PRODUCTO_CATEGORIA, PRODUCTO_STOCK, PRODUCTO_STATUS FROM producto WHERE PRODUCTO_STATUS=1";
$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dulcería - Purrfections</title>
  <!-- Se crea el link para que la página pueda utilizar las utilidades de Bootstrap y poder tomar algunos ejemplos de CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <!-- Se incluye la hoja de estilos en la página -->
  <link rel="stylesheet" href="../styles/reporte.css">
</head>

<body>
  <header data-bs-theme="dark">
    <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
      <div class="container">
        <a href="index.php" class="navbar-brand">
          <img src="../img/logo/logo_completo.png" width="150">
          <strong>Dulcería - Purrfections</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarHeader">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a href="index.php" class="nav-link active">Productos</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <h1>Reporte de Productos</h1>
  <table>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Precio</th>
      <th>Categoría</th>
      <th>Stock</th>
      <th>Estado</th>
    </tr>
    <?php foreach ($productos as $producto) : ?>
      <tr>
        <td><?php echo $producto['PRODUCTO_ID']; ?></td>
        <td><?php echo $producto['PRODUCTO_NOMBRE']; ?></td>
        <td><?php echo $producto['PRODUCTO_PRECIO']; ?></td>
        <td><?php echo $producto['PRODUCTO_CATEGORIA']; ?></td>
        <td><?php echo $producto['PRODUCTO_STOCK']; ?></td>
        <td><?php echo $producto['PRODUCTO_STATUS']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>