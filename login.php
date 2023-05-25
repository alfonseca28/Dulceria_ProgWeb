<?php
require 'config/config.php';
require_once("config/database.php"); // Incluye el archivo database.php
require 'clases/clienteFunciones.php';

$pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable

$proceso = isset($_GET['pago']) ? 'pago' : 'login';

// La consulta de abajo es dinamica en el sentido de que mientras los productos registrados en la base de datos esten arctivo estos se mostraran en la pagina (PRODUCTO_STATUS=1)
// $query = "SELECT PRODUCTO_ID, PRODUCTO_NOMBRE, PRODUCTO_PRECIO, PRODUCTO_DETALLES FROM producto WHERE PRODUCTO_STATUS=1";
// $stmt = $pdo->prepare($query);
// $stmt->execute();
// $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if (!empty($_POST)) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $proceso = $_POST['proceso'] ?? 'login';

    // Funciones para las validaciones
    if (esNulo([$usuario, $password])) {
        $errors[] = "Debes de rellenar todos los campos para registrarte";
    }

    if (count($errors) == 0) {
        $errors[] = login($usuario, $password, $pdo, $proceso);
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
    <!-- Se crea el link para que la pagina pueda realizar las utilidades de bootstrap y poder tomar algunos ejemplos de css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Se incluye la hoja de estilos a la pagina -->
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <!-- Menu de navegacion -->
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
                            <a href="#" class="nav-link active">Productos</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">Sobre nosotros</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">Contacto</a>
                        </li>
                    </ul>
                    <a href="checkout.php" class="btn btn-primary">
                        Carrito<span id="num_cart" class="badge bg-secondary"> <?php echo $num_cart; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido -->
    <main class="form-login m-auto pt-4 text-center">

        <h2>Iniciar sesion</h2>
        <?php mostrarMensajes($errors); ?>
        <form class="row g-3" action="login.php" method="post" autocomplete="off">

            <input type="hidden" name="proceso" value="<?php echo $proceso; ?>

            <div class=" form-floating">
            <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Usuario" required>
            <label for="usuario">Usuario</label>
            </div>

            <div class="form-floating">
                <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" required>
                <label for="password">Contraseña</label>
            </div>

            <!-- Aqui es para el apartado de recuperar la contraseña -->
            <div class="col-12">
                <a href="recupera.php">¿Olvidaste tu contraseña?</a>
            </div>

            <div class="d-grid gap-3 col-12">
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
            <hr>
            <div class="col-12">
                ¿No tienes una cuenta? <a href="registro.php">Registrate aqui :D</a>
            </div>
        </form>
    </main>

    <!-- Con el siguiente script se nos dara la facilidad de darle funcionalidad de javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>

</html>