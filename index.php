<?php
if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
if (!isset($_SESSION["carrito"]))
    $_SESSION["carrito"] = array();

$root = './';
$title = 'The Game Store : Novedades';
$titulo_cabecera = 'Novedades';
$tamaño_pagina = '14';

require($root . 'db/conexion_db.php');
require($root . 'articulo/acciones_articulos_db.php');
require($root . 'categorias/acciones_categorias_db.php');
$conn = connectBBDD();

$categorias = recuperar_todas_las_categorias_padre($conn);

if (isset($_GET['pagina'])) {
    $pagina = htmlspecialchars($_GET['pagina']);
}
if (isset($_GET['busqueda'])) {
    $busqueda = htmlspecialchars($_GET['busqueda']);
    $title = 'The Game Store : Busqueda';
    $titulo_cabecera = 'Busqueda';
}
if (isset($_GET['cat'])) {
    $id_cat = htmlspecialchars($_GET['cat']);
    $categorias = recuperar_categorias_por_id_padre($conn, $id_cat);
    $categoria_padre = recuperar_la_categoria_padre($conn, $id_cat);
    $categoria_selec = recuperar_categoria_por_id($conn, $id_cat);
}
if (isset($_GET['precio_maximo'])) {
    $precio_maximo = htmlspecialchars($_GET['precio_maximo']);
}
if (isset($_GET['stock'])) {
    $stockParam = htmlspecialchars($_GET['stock']);
    $stock = $stockParam === 'on';
}

if (isset($busqueda) || isset($id_cat) || isset($precio_maximo) || isset($stock)) {
    $busqueda = isset($busqueda) ? $busqueda : null;
    $id_cat = isset($id_cat) ? $id_cat : null;
    $precio_maximo = isset($precio_maximo) ? $precio_maximo : null;
    $stock = isset($stock) ? $stock : null;

    $total = contar_articulos_nombre_filtro($conn, $busqueda, $id_cat, $precio_maximo, $stock, " ORDER BY FECHA_SALIDA DESC");
    if ($total > 0) {
        $paginas = ceil($total / $tamaño_pagina);
    } else {
        $paginas = 1;
    }
    if (isset($pagina)) {
        $articulos = buscar_articulos_nombre_filtro($conn, $busqueda, $id_cat, $precio_maximo, $stock, " ORDER BY FECHA_SALIDA DESC LIMIT " . (($pagina - 1) * $tamaño_pagina) . ',' . $tamaño_pagina);
    } else {
        $articulos = buscar_articulos_nombre_filtro($conn, $busqueda, $id_cat, $precio_maximo, $stock, " ORDER BY FECHA_SALIDA DESC LIMIT " . $tamaño_pagina);
    }
} else {
    $total = recuperar_total_articulos($conn, " WHERE STOCK > 0", " ORDER BY FECHA_SALIDA DESC");

    if ($total > 0) {
        $paginas = ceil($total / $tamaño_pagina);
    } else {
        $paginas = 1;
    }

    if (isset($pagina)) {
        $articulos = recuperar_todos_los_articulos($conn, " WHERE STOCK > 0", " ORDER BY FECHA_SALIDA DESC LIMIT " . (($pagina - 1) * $tamaño_pagina) . ',' . $tamaño_pagina);
    } else {
        $articulos = recuperar_todos_los_articulos($conn, " WHERE STOCK > 0", " ORDER BY FECHA_SALIDA DESC LIMIT " . $tamaño_pagina);
    }
}

if (isset($_GET['add'])) {
    $id = htmlspecialchars($_GET['add']);
    $_SESSION["carrito"][] = recuperar_un_articulo($conn, $id);
    $page = $_SERVER['REQUEST_URI'];
    $page = preg_replace("/(&|\?)add=" . $id . "/", '', $page);
    header('Location: ' . $page);
}
include($root . 'paginas_comunes/header.php');



?>

<section class="container-max-width p-3">
    <div class="row text-center justify-content-center">
        <div class="col-sm-12">
            <h1>
                <?php echo $titulo_cabecera ?>
            </h1>
            <hr class="hr" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-auto">
            <div class="d-flex justify-content-between">
                <p class="m-1">
                    <button class="btn btn-primary btn-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFiltro" aria-expanded="true" aria-controls="collapseFiltro">
                        <i data-feather="filter"></i>
                    </button>
                </p>
                <nav class="m-1" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <?php

                        if (
                            isset($categoria_selec) &&
                            $categoria_selec &&
                            count($categoria_selec) > 0 &&
                            (!isset($categoria_padre) || !$categoria_padre || count($categoria_padre) === 0)
                        ) {
                            echo '<li class="breadcrumb-item "><a href="' . $root . 'index.php">Inicio</a></li>';
                            echo '<li class="breadcrumb-item text-capitalize active" aria-current="page">' . strtolower($categoria_selec['NOMBRE']) . '</li>';
                        } else if (
                            isset($categoria_selec) &&
                            $categoria_selec &&
                            count($categoria_selec) > 0 &&
                            isset($categoria_padre) &&
                            $categoria_padre &&
                            count($categoria_padre) > 0
                        ) {
                            echo '<li class="breadcrumb-item "><a href="' . $root . 'index.php">Inicio</a></li>';
                            echo '<li class="breadcrumb-item text-capitalize" ><a href="' . $root . 'index.php?cat=' . $categoria_padre['ID_CATEGORIA'] . '">' . strtolower($categoria_padre['NOMBRE']) . '</a></li>';
                            echo '<li class="breadcrumb-item active text-capitalize" aria-current="page">' . strtolower($categoria_selec['NOMBRE']) . '</li>';
                        } else {
                            echo '<li class="breadcrumb-item  active" aria-current="page">Inicio</li>';
                        }




                        ?>
                    </ol>
                </nav>
            </div>


            <div>
                <div class="collapse card show collapse-horizontal text-bg-light p-3" id="collapseFiltro">
                    <h2>Filtros</h2>
                    <hr class="hr" />
                    <div>
                        <a class="btn btn-primary dropdown-toggle" data-bs-toggle="collapse"
                            data-bs-target="#collapseCategorias" aria-expanded="true"
                            aria-controls="collapseCategorias">Categoria</a>
                        <div class="collapse show" id="collapseCategorias">
                            <div class="list-group">
                                <?php

                                if (isset($categorias) && count($categorias) > 0) {

                                    foreach ($categorias as $categoria) {
                                        $page = $_SERVER['REQUEST_URI'];

                                        if (isset($id_cat)) {
                                            $page = str_replace('cat=' . $id_cat, 'cat=' . $categoria['ID_CATEGORIA'], $page);
                                        } else {
                                            $page = str_contains($_SERVER['REQUEST_URI'], '?') ? $_SERVER['REQUEST_URI'] . '&' : $_SERVER['REQUEST_URI'] . '?';
                                            $page .= 'cat=' . $categoria['ID_CATEGORIA'];
                                        }
                                        echo '<a href="' . $page . '" class="list-group-item list-group-item-action text-capitalize">' . strtolower($categoria['NOMBRE']) . '</a>';
                                    }
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                    <hr class="hr" />
                    <form class="d-flex flex-column text-center justify-content-center">
                        <div class="my-1">
                            <label for="precio_maximo" class="form-label">Precio máximo:</label>
                            <input type="range" value="<?php if (isset($precio_maximo))
                                echo $precio_maximo; ?>" class="form-range" min="0" max="100" name="precio_maximo"
                                id="precio_maximo">
                        </div>

                        <div class="form-check form-switch text-start my-1">
                            <input class="form-check-input" type="checkbox" <?php if (isset($stockParam))
                                echo 'checked' ?> role="switch" name="stock" id="stock">
                                <label class="form-check-label" for="stock">En stock</label>
                            </div>
                            <div class="my-1">
                                <input class="btn btn-primary" type="submit" value="Filtrar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col">
                <div class="d-flex flex-row flex-wrap m-4">
                    <?php
                            $page = $_SERVER['REQUEST_URI'];
                            $page = str_contains($_SERVER['REQUEST_URI'], '?') ? $_SERVER['REQUEST_URI'] . '&' : $_SERVER['REQUEST_URI'] . '?';
                            if (isset($articulos) && count($articulos) > 0) {
                                foreach ($articulos as $articulo) {
                                    echo '
                    <a href="' . $root . 'articulo/detalle_articulo.php?id=' . $articulo['ID_ARTICULO'] . '">
                        <div class="card text-bg-primary m-2 p-2" style="width: 12rem;">
                            <img style="height:18rem;"src="./imgs/' . $articulo['IMAGEN'] . '" class="card-img-top" alt="' . $articulo['NOMBRE'] . '">
                            <div  class="card-body text-bg-primary text-center d-flex flex-column justify-content-between">
                                <h5 class="card-title text-bg-primary">' . $articulo['NOMBRE'] . '</h5>
                                <h5 class="card-title text-bg-primary">' . $articulo['PRECIO'] . '€</h5>
                                <div class="d-flex justify-content-center">
                                    <a class="link-light mx-1" href="' . $page . 'add=' . $articulo['ID_ARTICULO'] . '"><i data-feather="shopping-cart"></i></a>
                                </div>
                            </div>
                        </div>
                    </a>';
                                }
                            }
                            ?>
            </div>
            <nav class="d-flex justify-content-center " aria-label="...">
                <ul class="pagination">
                    <?php

                    if (isset($pagina)) {
                        $page = $_SERVER['REQUEST_URI'];

                        $page = str_replace('pagina=' . $pagina, ('pagina=' . (($pagina - 1) < 1 ? 1 : $pagina - 1)), $page);
                        if (($pagina - 1) >= 1) {
                            echo '<li class="page-item">
                            <a class="page-link" href="' . $page . '">Atras</a>
                        </li>';
                        }

                    }
                    if (isset($paginas)) {
                        for ($i = 0; $i < $paginas; $i++) {
                            $page = $_SERVER['REQUEST_URI'];

                            if (isset($pagina)) {
                                $page = str_replace('pagina=' . $pagina, 'pagina=' . ($i + 1), $page);
                            } else {
                                $page = str_contains($_SERVER['REQUEST_URI'], '?') ? $_SERVER['REQUEST_URI'] . '&' : $_SERVER['REQUEST_URI'] . '?';
                                $page .= 'pagina=' . ($i + 1);
                            }

                            $disabled = isset($pagina) ?
                                ($pagina == ($i + 1) ? 'disabled' : '') :
                                (($i + 1) === 1 ? 'disabled' : '');
                            echo '<li class="page-item"><a class="page-link ' . $disabled . '" href="' . $page . '">' . ($i + 1) . '</a></li>';
                        }
                    }
                    if ((isset($pagina) && $pagina < $paginas) || (!isset($pagina) && $paginas > 1)) {
                        $proxima_pagina = (isset($pagina) ? $pagina + 1 : 2);
                        $page = $_SERVER['REQUEST_URI'];
                        if (isset($pagina)) {
                            $page = str_replace('pagina=' . $pagina, ('pagina=' . $proxima_pagina), $page);
                        } else {
                            $page = str_contains($_SERVER['REQUEST_URI'], '?') ? $_SERVER['REQUEST_URI'] . '&' : $_SERVER['REQUEST_URI'] . '?';
                            $page .= 'pagina=' . $proxima_pagina;
                        }

                        echo '<li class="page-item">
                            <a class="page-link" href="' . $page . '">Siguiente</a>
                        </li>';
                    }
                    ?>

                </ul>
            </nav>
        </div>

    </div>

</section>



<?php include($root . 'paginas_comunes/footer.php'); ?>