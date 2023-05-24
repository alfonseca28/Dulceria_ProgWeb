<?php
require 'config/config.php';
require_once("config/database.php"); // Incluye el archivo database.php
require 'clases/clienteFunciones.php';

$pdo = conectar(); // Llama a la función conectar() y almacena el objeto de conexión en una variable

// La consulta de abajo es dinamica en el sentido de que mientras los productos registrados en la base de datos esten arctivo estos se mostraran en la pagina (PRODUCTO_STATUS=1)
// $query = "SELECT PRODUCTO_ID, PRODUCTO_NOMBRE, PRODUCTO_PRECIO, PRODUCTO_DETALLES FROM producto WHERE PRODUCTO_STATUS=1";
// $stmt = $pdo->prepare($query);
// $stmt->execute();
// $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if (!empty($_POST)) {
    $nombre = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    // Funciones para las validaciones
    if (esNulo([$nombre, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword])) {
        $errors[] = "Debes de rellenar todos los campos para registrarte";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es valida";
    }

    if (validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (usuarioExiste($usuario, $pdo)) {
        $errors[] = "El nombre de usuario $usuario ya existe";
    }

    if (emailExiste($email, $pdo)) {
        $errors[] = "El correo electronico $email ya esta asociado a una cuenta";
    }

    if (count($errors) == 0) {

        // Aqui comienza a registrar el cliente en la base de datos siempre y cuando escriba bien sus credenciales
        $id = registraCliente([$nombre, $apellidos, $email, $telefono, $dni], $pdo);

        if ($id > 0) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $token = generarToken();
            if (registraUsuario([$usuario, $pass_hash, $token, $id], $pdo)) {
                $errors[] = "Error al registrar el usuario";
            }
        } else {
            $errors[] = "Error al registrar el cliente";
        }
    }
    // if (count($errors) == 0) {
    // } else {
    //     print_r($errors);
    // }
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

    <main>
        <div class="container">
            <h2>Datos del cliente</h2>
            <!-- Aqui se van a mostrar los posibles errores en las validaciones del formulario -->
            <?php mostrarMensajes($errors); ?>

            <form class="row g-3" action="registro.php" method="post" autocomplete="off">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-danger"></span> Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger"></span> Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email"><span class="text-danger"></span> Correo electronico</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="telefono"><span class="text-danger"></span> Telefono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="dni"><span class="text-danger"></span> DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger"></span> Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="password"><span class="text-danger"></span> Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="repassword"><span class="text-danger"></span> Repetir contraseña</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" required>
                </div>

                <i><b>Nota:</b>Los campos con asterisco son obligatorios</i>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
    </main>

    <!-- Con el siguiente script se nos dara la facilidad de darle funcionalidad de javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>

</html>