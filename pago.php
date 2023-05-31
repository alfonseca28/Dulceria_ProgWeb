<?php
require 'config/config.php';
require_once("config/database.php");

$pdo = conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_carrito = array();
$stock_suficiente = true; // Variable para verificar si hay suficiente stock para los productos en el carrito

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        // Obtener información del producto
        $query = "SELECT PRODUCTO_ID, PRODUCTO_NOMBRE, PRODUCTO_PRECIO, PRODUCTO_DETALLES, PRODUCTO_STOCK FROM producto WHERE PRODUCTO_ID=? AND PRODUCTO_STATUS=1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$clave]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar el stock del producto
        if ($producto && $producto['PRODUCTO_STOCK'] >= $cantidad) {
            $producto['cantidad'] = $cantidad;
            $lista_carrito[] = $producto;

            // Restar la cantidad de productos comprados de la base de datos
            $sql_update = "UPDATE producto SET PRODUCTO_STOCK = PRODUCTO_STOCK - :cantidad WHERE PRODUCTO_ID = :id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':cantidad', $cantidad);
            $stmt_update->bindParam(':id', $clave);
            $stmt_update->execute();
        } else {
            // No hay suficiente stock para el producto
            $stock_suficiente = false;
            header("Location: no_stock.php");
            break;
        }
    }
} else {
    header("Location: index.php");
    exit;
}

if (!$stock_suficiente) {
    // Guardar los productos en una variable de sesión
    $_SESSION['carrito']['productos'] = $productos;

    // Mostrar mensaje de stock insuficiente
    echo "<script>alert('No hay suficiente stock para uno o más productos.');</script>";
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
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>

    <!-- Menu de navegacion -->
    <?php include 'menu.php'; ?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class=""text-center><b>Lista vacia</b></td> </tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $_id = $producto['PRODUCTO_ID'];
                                        $_nombre = $producto['PRODUCTO_NOMBRE'];
                                        $_precio = $producto['PRODUCTO_PRECIO'];
                                        $_cantidad = $producto['cantidad'];
                                        $_subtotal = $_precio * $producto['cantidad'];
                                        $total += $_subtotal;
                                ?>
                                        <tr>
                                            <td><?php echo $_nombre; ?></td>
                                            <td>
                                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($_subtotal, 2, '.', ','); ?></div>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="2">
                                            <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                        </td>
                                    </tr>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Con el siguiente script se nos dara la facilidad de darle funcionalidad de javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>currency=<?php echo CURRENCY; ?>"></script>

    <script>
        paypal.Buttons({
            style: {
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total; ?>'

                        }
                    }]
                });
            },
            // A partir de aqui comienza lo que es la transacion al momento de pagar y que por consola del navegador nos muestre todos los detalles de la transacion
            onApprove: function(data, actions) {
                let URL = 'clases/captura.php'
                actions.order.capture().then(function(detalles) {
                    console.log(detalles);
                    // let URL = 'clases/captura.php'
                    return fetch(URL, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(response) {
                        window.location.href = "completado.php?key=" + detalles['id'];
                    })
                });
            },
            // Esta funcion es para que al momento de cerrar la ventana emergente del pago, se cancele y nos muestre una alerta de que se cancelo el pago
            onCancel: function(data) {
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>