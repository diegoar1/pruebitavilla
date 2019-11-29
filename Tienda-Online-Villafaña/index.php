<?php
include 'Global/config.php';
include 'Global/conexion.php';
include 'carrito.php';
include 'Templates/cabecera.php';
?>
<br>
<br>
<br>
<br>

<!-- <?php
        $sentencia = $pdo->prepare("SELECT * FROM `productos`");
        $sentencia->execute();
        $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        ?>
<?php { ?>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="<?php echo $producto['Imagen']; ?>" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?php echo $producto['Imagen']; ?>" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?php echo $producto['Imagen']; ?>" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
<?php } ?> -->
<div class="row">
    <?php
    $sentencia = $pdo->prepare("SELECT * FROM `productos`");
    $sentencia->execute();
    $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    // print_r($listaProductos);
    ?>
    <?php foreach ($listaProductos as $producto) { ?>
        <div class="col-3" style="margin-bottom: 10px;">
            <div class="card">
                <img class="card-img-top" src="<?php echo $producto['Imagen']; ?>" alt="<?php echo $producto['Nombre']; ?>" title="<?php echo $producto['Nombre']; ?>" data-toggle="popover" data-trigger="hover" height="317px" data-content="<?php echo $producto['Descripcion']; ?>">
                <div class="card-body">
                    <span><?php echo $producto['Nombre']; ?></span>
                    <h5 class="card-title"><?php echo $producto['Precio']; ?></h5>
                    <!-- <p class="card-text"><?php echo $producto['Descripcion']; ?></p> -->
                    <form method="post" action="">
                        <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['Id'], COD, KEY); ?>">
                        <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                        <button class="btn btn-primary col-12" type="submit" name="btnAccion" value="Agregar"><i class="fas fa-plus-square"></i> Add</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
<script>
    $(function() {
        $('[data-toggle="popover"]').popover()
    })
</script>
<?php
include 'Templates/pie.php';
?>