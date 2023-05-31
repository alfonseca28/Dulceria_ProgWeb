<?php
require 'config/config.php';
require_once("config/database.php");
$pdo = conectar();

$id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';
$error = '';

if ($id_transaccion == '') {
    $error = 'Error al procesar la petición';
} else {
    $query = "SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_transaccion, 'COMPLETED']);

    if ($stmt->rowCount() > 0) {
        $query = "SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND status=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_transaccion, 'COMPLETED']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $id_compra = $row['id'];
        $total = $row['total'];
        $fecha = $row['fecha'];

        $query = "SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_compra]);
    } else {
        $error = 'Error al comprobar la compra';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulcería - Purrfections</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <img src="img/logo/logo_completo.png" width="150">
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

                        <li class="nav-item">
                            <a href="about.php" class="nav-link">Sobre nosotros</a>
                        </li>

                        <li class="nav-item">
                            <a href="about.php" class="nav-link">Contacto</a>
                        </li>
                    </ul>
                    <a href="checkout.php" class="btn btn-primary">
                        Carrito<span id="num_cart" class="badge bg-secondary"> <?php echo $num_cart; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if (strlen($error) > 0) { ?>
                <div class="row">
                    <div class="col">
                        <h3><?php echo $error; ?></h3>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col">
                        <b>Folio de la compra: </b><?php echo $id_transaccion; ?><br>
                        <b>Fecha: </b><?php echo $fecha; ?><br>
                        <b>Total: </b><?php echo MONEDA . number_format($total, 2, '.', ','); ?><br>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row_det = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $importe = $row_det['precio'] * $row_det['cantidad']; ?>
                                    <tr>
                                        <td><?php echo $row_det['cantidad']; ?></td>
                                        <td><?php echo $row_det['nombre']; ?></td>
                                        <td><?php echo $importe; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>

</html>