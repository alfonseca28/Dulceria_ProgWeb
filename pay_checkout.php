<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulceria - Metodos de pago</title>
    <!-- Con este script mandamos a llamar las credenciales del API de Paypal, para esto se pone el client ID y con esto tenemos la funcionalidad de realizar pagos con Paypal -->
    <script src="https://www.paypal.com/sdk/js?client-id=AZNkKB0lE0eee5PHguiAyqhdDvDNCAQDjDms638xSwxMVpzfZPwwnu9SKSgOhisUDIswRwkyTUfuV4dI&currency=MXN"></script>
</head>
<body>
    <!-- Aqui se crea el boton del metodo de pago con Paypal, ademas le agrego un estilo para que tenga esquinas redondeadas -->
    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            style:{
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 100
                        }
                    }]
                });
            },
            // A partir de aqui comienza lo que es la transacion al momento de pagar y que por consola del navegador nos muestre todos los detalles de la transacion
            onApprove: function(data, actions){
                actions.order.capture().then(function(detalles){
                    console.log(detalles);
                    // Finalmente aqui se redirecciona a otra ventana para mostrar que se realizo correctamente el pago
                    window.location.href="pay_completed.html"
                });
            },
            // Esta funcion es para que al momento de cerrar la ventana emergente del pago, se cancele y nos muestre una alerta de que se cancelo el pago
            onCancel: function(data){
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>