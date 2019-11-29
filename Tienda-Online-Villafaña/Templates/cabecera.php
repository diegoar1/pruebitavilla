<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Retorika</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body style="background-color: black;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <!-- <a class="navbar-brand" href="index.php">Logo de la tienda</a> -->
        <h1 class="ma0 mr5-l mr6-xl"><a href="index.php" class="router-link-active flex flex-row flex-nowrap items-center justify-center link color-inherit router-link-active hover-primary4 pt1-l outline-0-focus relative top--025-l hover-blue5">
                <span class="dn db-ns dn-l db-xl b f5 mt1 tracked0 ml1">Retorika</span></a></h1>
        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="my-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php"><i class="fas fa-tshirt"></i>Catalogo</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="verCarrito.php"><i class="fas fa-shopping-cart"></i>(<?php
                                                                                                    echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']);
                                                                                                    ?>)</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">