<?php
require 'config/config.php';
require_once("config/database.php"); // Incluye el archivo database.php

$pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id ==  '' || $token == '') {
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if ($token == $token_tmp) {

        $query = "SELECT PRODUCTO_ID, PRODUCTO_NOMBRE, PRODUCTO_PRECIO, PRODUCTO_DETALLES FROM producto WHERE PRODUCTO_ID=? AND PRODUCTO_STATUS=1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['PRODUCTO_NOMBRE'];
            $precio = $row['PRODUCTO_PRECIO'];
            $detalles = $row['PRODUCTO_DETALLES'];


            $id = $row['PRODUCTO_ID'];
            $imagen = "img/productos/{$id}/principal.jpg";

            if (!file_exists($imagen)) {
                $imagen = "img/productos/no-photo.jpg";
            }
        } else {
            echo 'Producto no encontrado';
            exit;
        }
    } else {
        echo 'Error al procesar la petición';
        exit;
    }
}

$query = "SELECT PRODUCTO_ID, PRODUCTO_NOMBRE, PRODUCTO_PRECIO FROM producto WHERE PRODUCTO_STATUS=1 AND PRODUCTO_ID != ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <!-- Menu de navegacion -->
    <?php include 'menu.php'; ?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <!-- Aqui es para mostrar de manera dinamica las imagenes correspondientes al id del producto -->
                    <img src="<?php echo $imagen; ?>" style="width: 80%;">
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre; ?></h2>
                    <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>
                    <p class="lead">
                        <?php echo $detalles; ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar ahora</button>
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp ?>')">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Con el siguiente script se nos dara la facilidad de darle funcionalidad de javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: "cors"
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart")
                        elemento.innerHTML = data.numero
                    }
                })
        }
    </script>
</body>

</html>