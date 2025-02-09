<?php
require $GLOBALS['root'] . 'vendor/autoload.php';
use GuzzleHttp\Client;

function realizar_pago(PDO|bool $conn, string $num_tarjeta, string $fecha_caducidad_tarjeta, string $cvv_tarjeta): bool
{
    $pago_ok = false;
    $options = [
        'auth' => ['sk_test_CGGvfNiIPwLXiDwaOfZ3oX6Y', ''],
        'form_params' => [
            'amount' => '123',
            'currency' => 'eur',
            'payment_method' => 'pm_card_visa',
            'payment_method_types[]' => 'card'
        ]
    ];
    $url = 'https://api.stripe.com/v1/payment_intents';

    $client = new Client();
    try {
        $response = $client->request('POST', $url, $options);
        $pago_ok = $response->getStatusCode() === 200;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $pago_ok;
}

function guardar_pedido_nuevo(PDO|bool $conn, array $datos_pedido, array $productos): bool
{
    $datos_cliente_insertados_ok = guardar_cliente($conn, $datos_pedido);
    $datos_direccion_factura_insertados_ok = false;
    $datos_direccion_envio_insertados_ok = false;
    $datos_pedido_insertados_ok = false;
    $datos_pedido_articulo_insertados_ok = false;
    if ($datos_cliente_insertados_ok) {
        $datos_direccion_factura_insertados_ok = guardar_direccion($conn, $datos_pedido, 'FACTURA');
        $datos_direccion_envio_insertados_ok = guardar_direccion($conn, $datos_pedido, 'ENVIO');
        if ($datos_direccion_factura_insertados_ok && $datos_direccion_envio_insertados_ok) {
            $datos_pedido_insertados_ok = guardar_indormacion_pedido($conn, $datos_pedido);

            if ($datos_pedido_insertados_ok) {
                $datos_pedido_articulo_insertados_ok = guardar_articulos_pedido($conn, $datos_pedido, $productos);
            }
        }
    }
    // echo $num_tarjeta;
    // echo $fecha_caducidad_tarjeta;
    // echo $cvv_tarjeta;

    return $datos_pedido_articulo_insertados_ok;
}


function guardar_cliente(PDO|bool $conn, array $datos_cliente): bool
{
    $insert = false;
    if (is_a($conn, 'PDO')) {
        $sql = "INSERT INTO CLIENTES (DNI, CLAVE, EMAIL, NOMBRE, APELLIDO1, APELLIDO2, ROL, ACTIVO, TELEFONO) 
            VALUES (:dni, :clave, :email, :nombre, :apellido1, :apellido2, :rol, :activo, :telefono)";
        $activo = $datos_cliente['password'] ? true : false;
        $rol = isset($datos_cliente['rol']) ? $datos_cliente['rol'] : ROL_USUARIO;
        echo 'pass ' . $datos_cliente['password'];


        try {
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':dni', $datos_cliente['dni'], PDO::PARAM_STR);
            $stmt->bindParam(':clave', $datos_cliente['password'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $datos_cliente['email'], PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $datos_cliente['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellido1', $datos_cliente['apellido1'], PDO::PARAM_STR);
            $stmt->bindParam(':apellido2', $datos_cliente['apellido2'], PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);
            $stmt->bindParam(':telefono', $datos_cliente[''], PDO::PARAM_STR);
            $insert = $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            // header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }

    }
    return $insert;
}
function guardar_direccion(PDO|bool $conn, array $datos_cliente, string $tipo_direccion): bool|int
{
    $insert = false;
    if (is_a($conn, 'PDO')) {
        $sql = "INSERT INTO DIRECCIONES (LOCALIDAD,PROVINCIA,DIRECCION,TIPO,DNI_CLIENTE,FAVORITA) 
            VALUES (:localidad,:provincia,:direccion,:tipo,:dni,:fav)";
        $tipo = $tipo_direccion;

        $fav = isset($datos_cliente['fav_' . strtolower($tipo)]) ? $datos_cliente['fav_' . strtolower($tipo)] : false;



        try {
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':localidad', $datos_cliente['localidad_' . strtolower($tipo)], PDO::PARAM_STR);
            $stmt->bindParam(':provincia', $datos_cliente['provincia_' . strtolower($tipo)], PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $datos_cliente['direccion_' . strtolower($tipo)], PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':dni', $datos_cliente['dni'], PDO::PARAM_STR);
            $stmt->bindParam(':fav', $fav, PDO::PARAM_BOOL);
            $insert = $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();

            // header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }

    }
    return $insert;
}

function guardar_indormacion_pedido(PDO|bool $conn, array $datos_cliente): bool
{
    $insert = false;
    if (is_a($conn, 'PDO')) {
        $sql = "INSERT INTO PEDIDOS (FECHA,DNI_CLIENTE,DIRECCION_ENVIO,DIRECCION_FACTURA,METODO_PAGO,INFO_PAGO,METODO_ENVIO,PRECIO_ENVIO) 
            VALUES (:fecha,:dni,:envio,:factura,:metodo_pago,:info_pago,:metodo_envio,:precio_envio)";
        $metodo_pago = 'TARJ';
        $metodo_envio = 'CORREO';
        $precio_envio = 10.2;
        $id_direccion_factura = recuperar_id_direccion(
            $conn,
            $datos_cliente['localidad_factura'],
            $datos_cliente['provincia_factura'],
            $datos_cliente['direccion_factura'],
            $datos_cliente['dni']
        );
        $id_direccion_envio = recuperar_id_direccion(
            $conn,
            $datos_cliente['localidad_envio'],
            $datos_cliente['provincia_envio'],
            $datos_cliente['direccion_envio'],
            $datos_cliente['dni']
        );

        try {
            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':fecha', date('y-m-j'), PDO::PARAM_STR);
            $stmt->bindParam(':dni', $datos_cliente['dni'], PDO::PARAM_STR);
            $stmt->bindParam(':envio', $id_direccion_envio, PDO::PARAM_INT);
            $stmt->bindParam(':factura', $id_direccion_factura, PDO::PARAM_INT);
            $stmt->bindParam(':metodo_pago', $metodo_pago, PDO::PARAM_STR);
            $stmt->bindValue(':info_pago', substr($datos_cliente['num_tarjeta'], -4), PDO::PARAM_STR);
            $stmt->bindParam(':metodo_envio', $metodo_envio, PDO::PARAM_STR);
            $stmt->bindParam(':precio_envio', $precio_envio, PDO::PARAM_STR);
            $insert = $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();

            // header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }

    }
    return $insert;
}


function guardar_articulos_pedido($conn, array $datos_pedido, array $productos): bool
{
    $insert = false;
    if (is_a($conn, 'PDO')) {
        $sql = "INSERT INTO ARTICULO_PEDIDO (ID_PEDIDO,ID_ARTICULO_PEDIDO,ARTICULO,CANTIDAD,PRECIO,DESCUENTO) 
            VALUES (:pedido,:articulo_pedido,:articulo,:cantidad,:precio,:descuento)";
        $id_pedido = recuperar_id_pedido(
            $conn,
            $datos_pedido['dni']
        );
        foreach ($productos as $producto) {
            $id_articulo_pedido = ($id_pedido . $producto['ID_ARTICULO'].date('his'));
            echo 'id_articulo_pedido ' . $id_articulo_pedido;
            echo 'id_pedido ' . $id_pedido;
            echo 'producto ' . $producto['ID_ARTICULO'];
            try {
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':pedido', $id_pedido, PDO::PARAM_STR);
                $stmt->bindValue(':articulo_pedido', $id_articulo_pedido, PDO::PARAM_STR);
                $stmt->bindParam(':articulo', $producto['ID_ARTICULO'], PDO::PARAM_INT);
                $stmt->bindValue(':cantidad', 1, PDO::PARAM_INT);
                $stmt->bindParam(':precio', $producto['PRECIO'], PDO::PARAM_STR);
                $stmt->bindValue(':descuento', $producto['DESCUENTO'], PDO::PARAM_STR);
                $insert = $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();

                // header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
            }
        }


    }
    return $insert;
}


function recuperar_id_pedido(PDO|bool $conn, string $dni): int
{
    $id = -1;


    $select = "SELECT ID_PEDIDO FROM PEDIDOS WHERE DNI_CLIENTE = :dni ORDER BY FECHA DESC LIMIT 1";
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);

            $stmt->execute();
            $id = $stmt->fetch()['ID_PEDIDO'];

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }

    return $id;
}
function recuperar_id_direccion(PDO|bool $conn, string $localidad, string $provincia, string $direccion, string $dni): int
{
    $id = -1;


    $select = "SELECT ID_DIRECCION FROM DIRECCIONES WHERE DNI_CLIENTE = :dni AND LOCALIDAD = :localidad AND PROVINCIA = :provincia AND DIRECCION = :direccion";
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':localidad', $localidad, PDO::PARAM_STR);
            $stmt->bindParam(':provincia', $provincia, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);

            $stmt->execute();
            $id = $stmt->fetch()['ID_DIRECCION'];

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }

    return $id;
}
?>