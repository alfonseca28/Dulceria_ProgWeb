<?php
require '../config/config.php';
require_once("../config/database.php");

$pdo = conectar();

// Consulta SQL para obtener todas las compras
$sql = "SELECT * FROM compra";
$stmt = $pdo->query($sql);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Reporte de Compras</h1>
<table>
  <tr>
    <th>ID Transacción</th>
    <th>Fecha</th>
    <th>Status</th>
    <th>Email</th>
    <th>ID Cliente</th>
    <th>Total</th>
  </tr>
  <?php foreach ($compras as $compra): ?>
    <tr>
      <td><?php echo $compra['id_transaccion']; ?></td>
      <td><?php echo $compra['fecha']; ?></td>
      <td><?php echo $compra['status']; ?></td>
      <td><?php echo $compra['email']; ?></td>
      <td><?php echo $compra['id_cliente']; ?></td>
      <td><?php echo $compra['total']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>
