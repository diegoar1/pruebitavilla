<?php
include 'Global/config.php';
include 'Global/conexion.php';
include 'carrito.php';
include 'Templates/cabecera.php';
?>

<?php
if ($_POST) {
    $total = 0;
    $SID = session_id();
    $Correo = $_POST['email'];
    $Direccion = $_POST['direccion'];
    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
        $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']);
    }
    $sentencia = $pdo->prepare("INSERT INTO `tblVentas` 
    (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
    VALUES (NULL, :ClaveTransaccion, '', Now(), :Correo, :Total, 'pendiente');");
    $sentencia->bindParam(":ClaveTransaccion", $SID);
    $sentencia->bindParam(":Correo", $Correo);
    $sentencia->bindParam(":Total", $total);
    $sentencia->execute();
    $idVenta  = $pdo->lastInsertId();
    foreach ($_SESSION['CARRITO'] as $indice => $producto) {
        $sentencia = $pdo->prepare("INSERT INTO `tbldetalleventa` 
        (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `Direccion`) 
        VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, :Direccion);");
        $sentencia->bindParam(":IDVENTA", $idVenta);
        $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
        $sentencia->bindParam(":CANTIDAD", $producto['CANTIDAD']);
        $sentencia->bindParam(":Direccion", $Direccion);
        $sentencia->execute();
    }
}
?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<style>
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }

    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 250px;
            display: inline-block;
        }
    }
</style>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="jumbotron text-center">
    <h1 class="display-4">¡Ultimo paso!</h1>
    <hr class="my-4">
    <p class="lead">Se te hara un cargo por la cantidad de:
        <h4>$<?php echo number_format($total, 2); ?></h4>
        <div id="paypal-button-container"></div>
    </p>
    <!-- <hr class="my-4"> -->
    <!-- <p>Content</p> -->
</div>
<script>
    paypal.Button.render({
        env: 'production', // sandbox | production
        style: {
            label: 'checkout', // checkout | credit | pay | buynow | generic
            size: 'responsive', // small | medium | large | responsive
            shape: 'pill', // pill | rect
            color: 'blue' // gold | blue | silver | black
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox: 'AYVlDsglAEIFy_tZgoggd3aCH-NRzDM9zG9zRrSa2PiBDScwb5ViOeUvF2y5opHL8LqEKd3EiYubHRS9',
            production: 'AX5PIUlstgf6pdiN0c9REhr2B1VDX_pHx2nmfkxipBT7m2wV0porcDRdkOjOMPe0Vj9At99xjlXsI5rt'
        },

        // Wait for the PayPal button to be clicked

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [{
                        amount: {
                            total: '<?php echo $total; ?>',
                            currency: 'MXN'
                        },
                        description: "Compra de productos a Retorika:$<?php echo number_format($total, 2); ?>",
                        custom: "<?php echo $SID; ?>#<?php echo openssl_encrypt($idVenta, COD, KEY); ?>"
                    }]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log(data);
                window.location = "verificador.php?paymentToken=" + data.paymentToken + "&paymentID=" + data.paymentID;
            });
        }

    }, '#paypal-button-container');
</script>
<?php
include 'Templates/pie.php';
?>