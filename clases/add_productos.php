<?php
require '../config/config.php';
require_once("../config/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = conectar();

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $detalles = $_POST['detalles'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $status = $_POST['status'];

    // Preparar la consulta SQL para insertar el producto
    $sql = "INSERT INTO producto (PRODUCTO_NOMBRE, PRODUCTO_PRECIO, PRODUCTO_DETALLES, PRODUCTO_CATEGORIA, PRODUCTO_STOCK, PRODUCTO_STATUS) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta con los datos del producto
    $stmt->execute([$nombre, $precio, $detalles, $categoria, $stock, $status]);

    // Redireccionar a la página de productos
    header('Location: ../admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulcería - Purrfections</title>
    <!-- Se crea el link para que la pagina pueda realizar las utilidades de bootstrap y poder tomar algunos ejemplos de css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Se incluye la hoja de estilos a la pagina -->
    <link rel="stylesheet" href="../styles/admin.css">
</head>

<body>
    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="../index.php" class="navbar-brand">
                    <img src="../img/logo/logo_completo.png" width="150">
                    <strong>Dulcería - Purrfections</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link active">Productos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <h1>Agregar Producto</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="detalles" class="form-label">Detalles:</label>
                <input type="text" class="form-control" id="detalles" name="detalles" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Estado:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
    <!-- Con el siguiente script se nos dara la facilidad de darle funcionalidad de javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4UTjmlbUdyyw2Dz6c0+oPWVZKil/8Oqtn" crossorigin="anonymous"></script>
</body>

</html>