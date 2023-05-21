<?php
define("CLIENT_ID", "AZNkKB0lE0eee5PHguiAyqhdDvDNCAQDjDms638xSwxMVpzfZPwwnu9SKSgOhisUDIswRwkyTUfuV4dI&");
define("CURRENCY", "MXN");
define("KEY_TOKEN", "APR.wqc-354*");
define("MONEDA", "$");

session_start();

$num_cart = 0;
if (isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>