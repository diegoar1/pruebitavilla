<?php
session_start();
$mensaje = "";

if (isset($_POST['btnAccion'])) {
    switch ($_POST['btnAccion']) {
        case 'Agregar':
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
            } else {
                $message = "not ok";
            }
            if (is_string(openssl_decrypt($_POST['nombre'], COD, KEY))) {
                $NOMBRE = openssl_decrypt($_POST['nombre'], COD, KEY);
            } else {
                $message = "not ok";
                break;
            }
            if (is_numeric(openssl_decrypt($_POST['cantidad'], COD, KEY))) {
                $CANTIDAD = openssl_decrypt($_POST['cantidad'], COD, KEY);
            } else {
                $message = "not ok";
                break;
            }
            if (is_numeric(openssl_decrypt($_POST['precio'], COD, KEY))) {
                $PRECIO = openssl_decrypt($_POST['precio'], COD, KEY);
            } else {
                $message = "not ok";
                break;
            }
            if (!isset($_SESSION['CARRITO'])) {
                $producto = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'CANTIDAD' => $CANTIDAD,
                    'PRECIO' => $PRECIO
                );
                $_SESSION['CARRITO'][0] = $producto;
            } else {
                $numerodeproductos = count($_SESSION['CARRITO']);
                $producto = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'CANTIDAD' => $CANTIDAD,
                    'PRECIO' => $PRECIO
                );
                $_SESSION['CARRITO'][$numerodeproductos] = $producto;
            }
            break;
        case "Eliminar":
            if (is_numeric(openssl_decrypt($_POST['id'], COD, KEY))) {
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                foreach ($_SESSION['CARRITO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID) {
                        unset($_SESSION['CARRITO'][$indice]);
                        echo "<script>alert('Elemento borrado');</script>";
                    }
                }
            } else {
                $message = "not ok";
            }
            break;
    }
}
