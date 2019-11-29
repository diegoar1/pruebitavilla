<?php
include 'Global/config.php';
include 'Global/conexion.php';
include 'carrito.php';
include 'Templates/cabecera.php';
?>
<?php
// print_r($_GET);

// $ClientID = "AYVlDsglAEIFy_tZgoggd3aCH-NRzDM9zG9zRrSa2PiBDScwb5ViOeUvF2y5opHL8LqEKd3EiYubHRS9";
// $Secret = "EDTa2SdfaI7Kk_tJUBS7ecnBpGQoJ3HFQiz3rODzdbhwn-P3VYkenAtpfWopbPkjIJWntZJp0sJZL8vI";

$Login = curl_init(LINKAPI . "/v1/oauth2/token");
curl_setopt($Login, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($Login, CURLOPT_USERPWD, CLIENTID . ":" . SECRET);
curl_setopt($Login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
$Respuesta = curl_exec($Login);
$objRespuesta = json_decode($Respuesta);
$AccessToken = $objRespuesta->access_token;
$venta = curl_init(LINKAPI . "/v1/payments/payment/" . $_GET['paymentID']);
curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $AccessToken));
curl_setopt($venta, CURLOPT_RETURNTRANSFER, TRUE);
$RespuestaVenta = curl_exec($venta);
// print_r($RespuestaVenta);

$objDatosTransaccion = json_decode($RespuestaVenta);
$state = $objDatosTransaccion->state;
$email = $objDatosTransaccion->payer->payer_info->email;
$total = $objDatosTransaccion->transactions[0]->amount->total;
$currency = $objDatosTransaccion->transactions[0]->amount->currency;
$custom = $objDatosTransaccion->transactions[0]->custom;
$clave = explode("#", $custom);
$SID = $clave[0];
$claveVenta = openssl_decrypt($clave[1], COD, KEY);
curl_close($venta);
curl_close($Login);
// echo $claveVenta;
if ($state == "approved") {
    $mensajePaypal = "<h3>Pago realizado con exito.</h3>";
    $sentencia = $pdo->prepare("UPDATE `tblventas` 
    SET `PaypalDatos` = :PaypalDatos, `status` = 'aprobado' 
    WHERE `tblventas`.`ID` = :ID;");
    $sentencia->bindParam(":ID", $claveVenta);
    $sentencia->bindParam(":PaypalDatos", $RespuestaVenta);
    $sentencia->execute();

    $sentencia = $pdo->prepare("UPDATE tblventas SET status = 'completo'
    WHERE ClaveTransaccion = :ClaveTransaccion
    AND Total = :TOTAL
    AND ID = :ID");
    $sentencia->bindParam(':ClaveTransaccion', $SID);
    $sentencia->bindParam(':TOTAL', $total);
    $sentencia->bindParam(':ID', $claveVenta);
    $sentencia->execute();
    $completado = $sentencia->rowCount();
    session_destroy();
} else {
    $mensajePaypal = "<h3>Hubo un problema con el pago, intente más tarde.</h3>";
}
// echo $mensajePaypal;
?>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="jumbotron">
    <h1 class="display-4">¡Listo!</h1>
    <hr class="my-4">
    <p class="lead"><?php echo $mensajePaypal; ?></p>
    <p>
        <?php
        if ($completado >= 1) { ?>
            <div class="alert alert-success">
                Los siguientes productos han sido procesados para su envio.
                <a href="index.php" class="badge badge-success">Regresar al catalogo</a>
            </div>

        <?php }
        if ($completado >= 1) {
            $sentencia = $pdo->prepare("SELECT * FROM tbldetalleventa, productos 
WHERE tbldetalleventa.IDPRODUCTO = productos.Id 
AND tbldetalleventa.IDVENTA=:ID");
            $sentencia->bindParam(':ID', $claveVenta);
            $sentencia->execute();
            $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        }

        ?>
        <div class="row">
            <?php foreach ($listaProductos as $producto) { ?>
                <div class="col-2">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $producto['Imagen']; ?>" alt="">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Title</h5> -->
                            <p class="card-text"><?php echo $producto['Nombre']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </p>
</div>
<?php
include 'Templates/pie.php';
?>