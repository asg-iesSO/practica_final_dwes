<?php
$root = '../';
$title = 'The Game Store : Articulo';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require($root . 'db/conexion_db.php');
require($root . 'articulo/acciones_articulos_db.php');
$conn = connectBBDD();
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $articulo = recuperar_un_articulo($conn, $id);
    $articulos_relacionados = recuperar_todos_los_articulos_categoria($conn, $articulo['CATEGORIA'], " ORDER BY FECHA_SALIDA DESC LIMIT 6");

}

if (isset($_GET['añadir'])) {
    $añadir = htmlspecialchars($_GET['añadir']);
    $_SESSION["carrito"][] = recuperar_un_articulo($conn, $añadir);
}

include($root . 'paginas_comunes/header.php')
    ?>
<section class="container py-4">
    <div class="d-flex flex-row-reverse">
        <button type="button" class="btn position-relative">
            <a href="<?php echo $root ?>index.php"> <i data-feather="x"></i></a>
        </button>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-4">
            <img src="<?php echo $root ?>imgs/<?php echo $articulo['IMAGEN'] ?>" class="img-fluid" alt="...">
        </div>
        <div class="col-sm-6 ">
            <h3>
                <?php echo $articulo['NOMBRE'] ?>
            </h3>
            <div class="d-flex flex-row">
                <h4 class="me-2">
                    <?php echo $articulo['PRECIO'] ?> €
                </h4>
                <h4 class="me-2">
                    <?php echo $articulo['STOCK'] ? $articulo['STOCK'] . ' Unidades en Stock' : 'No hay Stock' ?>
                </h4>
            </div>

            <article>
                <?php echo $articulo['DESCRIPCION'] ?>
            </article>
            <div class="py-4">
                <a class="btn btn-primary"
                    <?php 
                    echo 'href="' . $root . 'articulo/detalle_articulo.php?id='.$articulo['ID_ARTICULO'].'&añadir=' . $articulo['ID_ARTICULO'] . '"';
                    ?>>Añadir al
                    carrito</a>
            </div>
        </div>
    </div>
    <hr class="hr" />

    <div class="row my-4 justify-content-center">
        <h4>Otros productos de esta categoria</h4>
        <div class="col m-4">
            <div class="d-flex">
                <?php
                foreach ($articulos_relacionados as $articulo_relacionado) {
                    echo '
                    <a href="' . $root . 'articulo/detalle_articulo.php?id=' . $articulo_relacionado['ID_ARTICULO'] . '">
                        <div class="card text-bg-primary m-2 p-2" style="width: 12rem;">
                            <img style="height:18rem;"src="' . $root . 'imgs/' . $articulo_relacionado['IMAGEN'] . '" class="card-img-top" alt="' . $articulo_relacionado['NOMBRE'] . '">
                            <div  class="card-body text-bg-primary text-center d-flex flex-column justify-content-between">
                                <h5 class="card-title text-bg-primary">' . $articulo_relacionado['NOMBRE'] . '</h5>
                                <h5 class="card-title text-bg-primary">' . $articulo_relacionado['PRECIO'] . '€</h5>
                                <div class="d-flex justify-content-center">
                                    <a class="link-light mx-1" href="' . $root . 'articulo/detalle_articulo.php?id='.$articulo['ID_ARTICULO'].'&añadir=' . $articulo_relacionado['ID_ARTICULO'] . '"><i data-feather="shopping-cart"></i></a>
                                </div>
                            </div>
                        </div>
                    </a>';
                }

                ?>
            </div>
        </div>
    </div>
</section>
<?php include($root . 'paginas_comunes/footer.php'); ?>