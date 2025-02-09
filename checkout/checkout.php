<?php
$root = '../';
$title = 'The Game Store : Checkout';
$titulo_pagina = 'Checkout';
require($root . 'db/conexion_db.php');
require($root . 'pedidos/acciones_pedidos_db.php');
$conn = connectBBDD();
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_POST) && count($_POST) > 0) {
    $datos_formulario = array(
        'email' => '',
        'dni' => '',
        'telefono' => '',
        'password' => '',
        'nombre' => '',
        'apellido1' => '',
        'apellido2' => '',
        'localidad_factura' => '',
        'provincia_factura' => '',
        'direccion_factura' => '',
        'localidad_envio' => '',
        'provincia_envio' => '',
        'direccion_envio' => '',
        'num_tarjeta' => '',
        'fecha_caducidad_tarjeta' => '',
        'cvv_tarjeta' => ''
    );

    echo 'pass : ' . $_POST['password'];
    $datos_personales_ok = validar_datos_personales($_POST);
    if ($datos_personales_ok) {
        $datos_formulario['email'] = htmlspecialchars($_POST['email']);
        $datos_formulario['dni'] = htmlspecialchars($_POST['dni']);
        $datos_formulario['telefono'] = htmlspecialchars($_POST['telefono']);
        $datos_formulario['password'] = isset($_POST['password']) && $_POST['password'] ? password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT) : '';
        $datos_formulario['nombre'] = htmlspecialchars($_POST['nombre']);
        $datos_formulario['apellido1'] = htmlspecialchars($_POST['apellido1']);
        $datos_formulario['apellido2'] = htmlspecialchars($_POST['apellido2']);
    }
    $datos_direccion_ok = validar_datos_direccion($_POST);
    if ($datos_direccion_ok) {
        $datos_formulario['localidad_factura'] = htmlspecialchars($_POST['localidad-factura']);
        $datos_formulario['provincia_factura'] = htmlspecialchars($_POST['provincia-factura']);
        $datos_formulario['direccion_factura'] = htmlspecialchars($_POST['direccion-factura']);
        $datos_formulario['localidad_envio'] = htmlspecialchars($_POST['localidad-envio']);
        $datos_formulario['provincia_envio'] = htmlspecialchars($_POST['provincia-envio']);
        $datos_formulario['direccion_envio'] = htmlspecialchars($_POST['direccion-envio']);
    }
    $datos_pago_ok = validar_datos_pago($_POST);
    if ($datos_pago_ok) {
        $datos_formulario['num_tarjeta'] = htmlspecialchars($_POST['num-tarjeta']);
        $datos_formulario['fecha_caducidad_tarjeta'] = htmlspecialchars($_POST['fecha-caducidad-tarjeta']);
        $datos_formulario['cvv_tarjeta'] = htmlspecialchars($_POST['cvv-tarjeta']);
    }

    if ($datos_personales_ok && $datos_direccion_ok && $datos_pago_ok) {
        $pedido_ok = guardar_pedido($conn, $datos_formulario, $_SESSION["carrito"]);

        if ($pedido_ok) {
            echo 'todo OK';
            //header('Location: ' . $root . 'checkout/checkout_ok.php');
        }
    }
}


function validar_datos_personales(array $post_data): bool
{
    $email_ok = true;
    $dni_ok = true;
    $datos_ok = true;

    $email = htmlspecialchars($post_data['email']);
    $dni = htmlspecialchars($post_data['dni']);
    $telefono = htmlspecialchars($post_data['telefono']);
    $nombre = htmlspecialchars($post_data['nombre']);
    $apellido1 = htmlspecialchars($post_data['apellido1']);
    $apellido2 = htmlspecialchars($post_data['apellido2']);

    $datos_ok = $email && $dni && $telefono && $nombre && $apellido1 && $apellido2;

    return $email_ok && $dni_ok && $datos_ok;
}

function validar_datos_direccion(array $post_data): bool
{
    $datos_ok = true;
    $localidad_factura = htmlspecialchars($post_data['localidad-factura']);
    $provincia_factura = htmlspecialchars($post_data['provincia-factura']);
    $direccion_factura = htmlspecialchars($post_data['direccion-factura']);
    $localidad_envio = htmlspecialchars($post_data['localidad-envio']);
    $provincia_envio = htmlspecialchars($post_data['provincia-envio']);
    $direccion_envio = htmlspecialchars($post_data['direccion-envio']);

    $datos_ok = $localidad_factura && $provincia_factura && $direccion_factura && $localidad_envio && $provincia_envio && $direccion_envio;

    return $datos_ok;

}

function validar_datos_pago(array $post_data): bool
{
    $datos_ok = true;
    $num_tarjeta = htmlspecialchars($post_data['num-tarjeta']);
    $fecha_caducidad_tarjeta = htmlspecialchars($post_data['fecha-caducidad-tarjeta']);
    $cvv_tarjeta = htmlspecialchars($post_data['cvv-tarjeta']);

    $datos_ok = $num_tarjeta && $fecha_caducidad_tarjeta && $cvv_tarjeta;

    return $datos_ok;
}

function guardar_pedido(PDO|bool $conn, array $datos_formulario, array $productos): bool
{
    $pedido_ok = true;
    $pago_ok = true;
    $guardar_pedido_ok = true;
    $pago_ok = realizar_pago($conn, $datos_formulario['num_tarjeta'], $datos_formulario['fecha_caducidad_tarjeta'], $datos_formulario['cvv_tarjeta']);
    $guardar_pedido_ok = guardar_pedido_nuevo($conn, $datos_formulario, $productos);
    $pedido_ok = $pago_ok && $guardar_pedido_ok;

    return $pedido_ok;
}
include($root . 'paginas_comunes/header.php');

?>

<section class="container py-4">
    <h1>
        <?php echo $titulo_pagina; ?>
    </h1>
    <form class="needs-validation" action="<?php echo $root ?>checkout/checkout.php" method="POST" novalidate>

        <a class="link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="collapse"
            href="#collapse-datos-personales" role="button" aria-expanded="false"
            aria-controls="collapse-datos-personales">
            <h3 class="my-4 bg-light text-secondary-emphasis d-flex justify-content-between">Datos personales
                <i data-feather="chevron-down"></i>
            </h3>
        </a>
        <div class="collapse show container" id="collapse-datos-personales">
            <div class="row">
                <div class="col-3 m-3 ">
                    <label for="email" class="form-label">Email*</label>
                    <input required type="email" class="form-control" id="email" name="email"
                        aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Nunca compartiremos tu email con terceros</div>
                    <div class="invalid-feedback">
                        Comprueba el formato del email.
                    </div>

                </div>

                <div class="col-2 m-3">
                    <label for="dni" class="form-label">DNI*</label>
                    <input required maxlength="9" pattern="[0-9]{8}[A-z]{1}" type="text" class="form-control" name="dni"
                        id="dni" aria-describedby="dniHelp">
                    <div id="dniHelp" class="form-text">Introduce tu DNI con la letra (12345678Z)</div>
                    <div class="invalid-feedback">
                        El formato es incorrecto.
                    </div>
                </div>


                <div class="col-2 m-3">
                    <label for="telefono" class="form-label">Teléfono*</label>
                    <input required maxlength="9" type="tel" pattern="[0-9]{9}" class="form-control" name="telefono"
                        id="telefono" aria-describedby="telHelp">
                    <div id="telHelp" class="form-text">Introduce el teléfono en formato (666333666)</div>
                    <div class="invalid-feedback">
                        Formato de teléfono incorrecto.
                    </div>

                </div>
                <div class="col-3 m-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input minlength="5" maxlength="15" type="password" class="form-control" name="password"
                        id="password" aria-describedby="passwordHelp">
                    <div id="passwordHelp" class="form-text">Si quieres registrarte al mismo tiempo que haces el pedido,
                        introduce una contraseña para tu cuenta.</div>
                    <div class="invalid-feedback">
                        Formato erroneo, min 5 caracteres, max 15.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-3 m-3">
                    <label for="nombre" class="form-label">Nombre*</label>
                    <input required type="text" class="form-control" name="nombre" id="nombre">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>

                </div>
                <div class="col-2 m-3">
                    <label for="apellido1" class="form-label">Apellido 1*</label>
                    <input required type="text" class="form-control" name="apellido1" id="apellido1">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>

                </div>
                <div class="col-2 m-3">
                    <label for="apellido2" class="form-label">Apellido 2*</label>
                    <input required type="text" class="form-control" name="apellido2" id="apellido2">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>

                </div>
            </div>
        </div>

        <a class="link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="collapse"
            href="#collapse-datos-direccion-factura" role="button" aria-expanded="false"
            aria-controls="collapse-datos-direccion-factura">
            <h3 class="my-4 bg-light text-secondary-emphasis d-flex justify-content-between">Dirección de facturación
                <i data-feather="chevron-down"></i>
            </h3>
        </a>
        <div class="collapse container" id="collapse-datos-direccion-factura">
            <div class="row">
                <div class="col m-3 ">
                    <label for="localidad-factura" class="form-label">Localidad*</label>
                    <input required type="text" class="form-control" id="localidad-factura" name="localidad-factura">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>

                </div>

                <div class="col m-3">
                    <label for="provincia-factura" class="form-label">Provincia*</label>
                    <input required type="text" class="form-control" name="provincia-factura" id="provincia-factura">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>
                </div>

                <div class="col m-3">
                    <label for="direccion-factura" class="form-label">Dirección*</label>
                    <input required type="text" class="form-control" name="direccion-factura" id="direccion-factura">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>
                </div>
                <div class="row">
                    <div class="col m-3 align-middle">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="reutilizar-direccion">
                            <label class="form-check-label" for="reutilizar-direccion">
                                ¿Reutilizar dirección para envio?
                            </label>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <a class="link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="collapse"
            href="#collapse-datos-direccion-envio" role="button" aria-expanded="false"
            aria-controls="collapse-datos-direccion-envio">
            <h3 class="my-4 bg-light text-secondary-emphasis d-flex justify-content-between">Dirección de envío
                <i data-feather="chevron-down"></i>
            </h3>
        </a>
        <div class="collapse container" id="collapse-datos-direccion-envio">
            <div class="row">
                <div class="col m-3 ">
                    <label for="localidad-envio" class="form-label">Localidad*</label>
                    <input required type="text" class="form-control" id="localidad-envio" name="localidad-envio">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>

                </div>

                <div class="col m-3">
                    <label for="provincia-envio" class="form-label">Provincia*</label>
                    <input required type="text" class="form-control" name="provincia-envio" id="provincia-envio">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>
                </div>

                <div class="col m-3">
                    <label for="direccion-envio" class="form-label">Dirección*</label>
                    <input required type="text" class="form-control" name="direccion-envio" id="direccion-envio">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>
                </div>
            </div>
        </div>
        <a class="link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="collapse"
            href="#collapse-datos-resumen" role="button" aria-expanded="false" aria-controls="collapse-datos-resumen">
            <h3 class="my-4 bg-light text-secondary-emphasis d-flex justify-content-between">Resumen del pedido
                <i data-feather="chevron-down"></i>
            </h3>
        </a>
        <div class="collapse show container text-center " id="collapse-datos-resumen">

            <?php
            if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"]) > 0) {
                foreach ($_SESSION["carrito"] as $producto) {
                    echo '<div class="row m-3">
                            <div class="col-2 justify-content-center">
                                <img src="' . $root . 'imgs/' . $producto['IMAGEN'] . '" style="width:6rem;height:8rem" alt="...">
                            </div>
                            <div class="col">
                            <h4>' . $producto['NOMBRE'] . '</h4>
                            </div>
                            <div class="col-2">
                            <h4>' . $producto['PRECIO'] . '€</h4>
                            </div>
                        </div>';

                }
            }

            ?>
            <hr class="hr" />
            <div class="row m-3 ">
                <div class="col-2">
                    <h1 class="">Total</h1>
                </div>
                <div class="col">
                </div>
                <div class="col-2 text-left">
                    <h3 class="">
                        <?php
                        if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"])) {
                            $precio = 0;
                            foreach ($_SESSION["carrito"] as $producto) {
                                $precio += $producto['PRECIO'];
                            }
                            echo $precio . '€';
                        } ?>
                    </h3>
                </div>
            </div>
        </div>


        <a class="link-offset-2 link-underline link-underline-opacity-0" data-bs-toggle="collapse"
            href="#collapse-datos-pago" role="button" aria-expanded="false"
            aria-controls="collapse-datos-direccion-envio">
            <h3 class="my-4 bg-light text-secondary-emphasis d-flex justify-content-between">Pago
                <i data-feather="chevron-down"></i>
            </h3>
        </a>
        <div class="collapse container" id="collapse-datos-pago">
            <div class="row">
                <div class="col m-3 ">
                    <label for="num-tarjeta" class="form-label">Numero tarjeta*</label>
                    <input required type="text" class="form-control" id="num-tarjeta" name="num-tarjeta">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>

                </div>

                <div class="col m-3">
                    <label for="fecha-caducidad-tarjeta" class="form-label">Fecha de caducidad*</label>
                    <input required type="text" pattern="[0-9]{2}\/[0-9]{2}" class="form-control"
                        name="fecha-caducidad-tarjeta" id="fecha-caducidad-tarjeta">
                    <div class="invalid-feedback">
                        Formato incorrecto (DD/MM)
                    </div>
                </div>

                <div class="col m-3">
                    <label for="cvv-tarjeta" class="form-label">CVV*</label>
                    <input required type="text" class="form-control" name="cvv-tarjeta" id="cvv-tarjeta">
                    <div class="invalid-feedback">
                        Campo requerido.
                    </div>
                </div>
            </div>
        </div>






        <div class="d-flex justify-content-between">
            <a class="my-4 btn btn-danger" href="<?php echo $root ?>index.php">Cancelar</a>

            <button type="submit" class="my-4 btn btn-primary">Comprar</button>
        </div>


    </form>

</section>

<script>
    const reutilizar = document.getElementById("reutilizar-direccion");
    reutilizar.addEventListener("change", updateValue);
    const inputsFrom = document.getElementById('collapse-datos-direccion-factura').getElementsByTagName('input');

    const inputsTo = document.getElementById('collapse-datos-direccion-envio').getElementsByTagName('input');

    function updateValue(e) {
        if (e.target.checked) {
            for (let i = 0; i < inputsTo.length; i++) {
                const inputTo = inputsTo[i];
                const inputFrom = inputsFrom[i];
                inputTo.value = inputFrom.value;
                inputTo.readOnly = true;
            }
        } else {
            for (let i = 0; i < inputsTo.length; i++) {
                const inputTo = inputsTo[i];
                inputTo.value = '';
                inputTo.readOnly = false;
            }
        }
    }
</script>
<?php include($root . 'paginas_comunes/footer.php'); ?>