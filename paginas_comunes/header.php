<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}
if (isset($_GET['vaciar'])) {
    $_SESSION["carrito"] = array();
    $url = preg_replace("/(&|\?)vaciar=true/", '', $_SERVER['REQUEST_URI']);

    header('Location: ' . $url);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>
        <?php echo $title; ?>
    </title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/feather-icons"></script>

</head>

<body>

    <!-- Header/Navbar-->

    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $root ?>index.php">The Game Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo $root; ?>index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Outlet</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside">Login</a>
                            <div class="dropdown-menu">
                                <form class="px-4 py-3">
                                    <div class="mb-3">
                                        <label for="exampleDropdownFormEmail1" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="exampleDropdownFormEmail1"
                                            placeholder="email@example.com">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleDropdownFormPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleDropdownFormPassword1"
                                            placeholder="Password">
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="dropdownCheck">
                                            <label class="form-check-label" for="dropdownCheck">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                </form>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-bs-whatever="@mdo">New around here? Sign up</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-bs-whatever="@fat">Forgot password?</a>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn mx-3" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <i data-feather="shopping-cart"></i>

                    <?php
                    if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"])) {
                        echo '<span class="badge text-bg-danger">' . count($_SESSION["carrito"]) . '</span>';
                    }
                    ?>
                </button>

                <div style="width:14rem" class="dropdown-menu" data-bs-theme="light">
                    <div class="px-4 py-3">
                        <h4>Carrito</h4>
                    </div>
                    <div class="d-flex flex-column m-2 overflow-auto" style="height: 20rem;">
                        <?php
                        if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"])) {
                            foreach ($_SESSION["carrito"] as $producto) {
                                echo ' 
                                <div class="d-flex my-2">
                                    <div class="flex-shrink-0">
                                        <img src="' . $root . 'imgs/' . $producto['IMAGEN'] . '" style="width:3rem" alt="...">
                                    </div>
                                    <div class="flex-grow-1 ms-1">
                                    ' . $producto['NOMBRE'] . ' - ' . $producto['PRECIO'] . ' €
                                    </div>
                                </div>
                            ';
                            }
                        }

                        ?>

                    </div>
                    <div class="px-4 py-3">
                        <div class="d-flex justify-content-between">
                            <p>Total </p>
                            <h4>
                                <?php
                                if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"])) {
                                    $precio = 0;
                                    foreach ($_SESSION["carrito"] as $producto) {
                                        $precio += $producto['PRECIO'];
                                    }
                                    echo $precio . ' €';
                                } ?>
                            </h4>
                        </div>

                        <div class="dropdown-divider"></div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-outline-danger btn-sm <?php echo count($_SESSION["carrito"]) == 0 ? 'disabled' : '' ?>"
                                href="<?php echo str_contains($_SERVER['REQUEST_URI'], '?') ? $_SERVER['REQUEST_URI'] . '&' : $_SERVER['REQUEST_URI'] . '?' ?>vaciar=true">Vaciar
                                carrito</a>
                            <a href="<?php echo $root . 'checkout/checkout.php'; ?>"
                                class="btn btn-primary btn-sm <?php echo count($_SESSION["carrito"]) == 0 ? 'disabled' : '' ?>">Checkout</a>
                        </div>
                    </div>

                </div>

            </div>
            <form class="d-flex" role="search" action="<?php echo $root ?>index.php" method="get" data-bs-theme="light">
                <input class="form-control me-2" id="busqueda" name="busqueda" type="text" placeholder="Busqueda"
                    aria-label="Busqueda">
                <button class="btn btn-outline-light" type="submit">Busqueda</button>
            </form>
        </div>


    </nav>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>

   


    <!-- End header/navbar-->