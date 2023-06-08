<?php
require 'config/config.php';
require_once("config/database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulcería - Purrfections</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-cZkXAVCNOm1wlnw8yMO3acNFbcZBD1vMQAOc8iFsHvvYBf7TN9z2Ji2U7H77csSRVhM8Ks3b8dMO/ZLxQ7GFFg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Se crea el link para que la pagina pueda realizar las utilidades de bootstrap y poder tomar algunos ejemplos de css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Se incluye la hoja de estilos a la pagina -->
    <link rel="stylesheet" href="styles/admin.css">
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
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <a href="clases\reporte_compras.php" class="btn btn-primary btn-lg">Ver compras</a>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <a href="clases\reporte_productos.php" class="btn btn-primary btn-lg">Ver productos</a>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <a href="clases\add_productos.php" class="btn btn-primary btn-lg">Agregar productos</a>
                </div>
            </div>
        </div>


    </main>

    <!-- Con el siguiente script se nos dara la facilidad de darle funcionalidad de javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4UTjmlbUdyyw2Dz6c0+oPWVZKil/8Oqtn" crossorigin="anonymous"></script>
</body>

</html>