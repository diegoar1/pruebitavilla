<?php
include 'Global/config.php';
include 'carrito.php';
include 'Templates/cabecera.php';
?>
<br>
<br>
<br>
<br>
<h3 style="color: white;">Articulos del carrito</h3>
<?php
if (!empty($_SESSION['CARRITO'])) { ?>
    <table class="table table-black table-bordered" style="color: white;">
        <tbody>
            <tr>
                <th width="40%" class="text-center">Producto</th>
                <th width="15%" class="text-center">Cantidad</th>
                <th width="20%" class="text-center">Precio</th>
                <th width="20%" class="text-center">Total</th>
                <th width="5%">--</th>
            </tr>
            <?php $total = 0; ?>
            <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                <tr>
                    <td width="40%"><?php echo $producto['NOMBRE'] ?></td>
                    <td width="15%" class="text-center"><?php echo $producto['CANTIDAD'] ?></td>
                    <td width="20%" class="text-center">$<?php echo $producto['PRECIO'] ?></td>
                    <td width="20%" class="text-center">$<?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></td>
                    <td width="5%">
                        <form action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                            <button class="btn btn-danger" type="submit" name="btnAccion" value="Eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']); ?>
            <?php } ?>
            <tr>
                <td colspan="3" align="right">
                    <h3>Total</h3>
                </td>
                <td colspan="2" align="right">
                    <h3>$<?php echo number_format($total, 2); ?></h3>
                </td>
                <!-- <td></td> -->
            </tr>
            <tr>
                <td colspan="5">
                    <form action="pagar.php" method="post">
                        <div class="alert alert-success" role="alert">
                            <div class="form-group">
                                <label for="my-input">Correo:</label>
                                <input id="email" class="form-control" type="email" name="email" placeholder="Ingrese su correo de contacto" required>
                            </div>
                            <small id="direccionHelp" class="form-text text-muted">Su pedido se realizara a traves de este correo</small>
                            <div class="form-group">
                                <label for="my-input">Direccion de envio:</label>
                                <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Ingrese su direccion de recepcion" required>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnAccion" value="proceder">Realizar Pago >></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
<?php } else { ?>
    <div class="alert alert-success">
        No hay productos seleccionados
    </div>
<?php } ?>


<?php include 'Templates/pie.php'; ?>