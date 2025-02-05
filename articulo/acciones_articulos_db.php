<?php
function recuperar_todos_los_articulos(PDO|bool $conn, string $filtro = '', string $orden = ''): array
{
    $data = null;


    $select = "SELECT * FROM ARTICULOS";
    $sql = $select . $filtro . $orden;
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}
function recuperar_total_articulos(PDO|bool $conn, string $filtro = '', string $orden = ''): int
{
    $total = 0;


    $select = "SELECT COUNT(ID_ARTICULO) AS TOTAL FROM ARTICULOS";
    $sql = $select . $filtro . $orden;
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetch();
            if (is_array($res) && count($res) > 0) {
                $total = $res['TOTAL'];
            }

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }

    return $total;
}
function recuperar_todos_los_articulos_categoria(PDO|bool $conn, string $categoria, string $orden = ''): array
{
    $data = null;


    $select = "SELECT * FROM ARTICULOS ";
    $sql = $select . "WHERE CATEGORIA = :categoria " . $orden;
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}
function recuperar_un_articulo(PDO|bool $conn, string $id): array
{
    $data = null;
    $sql = "SELECT * FROM ARTICULOS WHERE ID_ARTICULO=:id";
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch();
        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');

        }
    }
    return $data;
}


function buscar_articulos_nombre(PDO|bool $conn, string $nombre, string $orden = ''): array
{
    $data = null;


    $select = "SELECT * FROM ARTICULOS ";
    $sql = $select . "WHERE NOMBRE LIKE :nombre " . $orden;
    $nombre = '%' . $nombre . '%';
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}


function buscar_articulos_nombre_filtro(PDO|bool $conn, string|null $nombre, int|null $categoria = null, int|null $precio_maximo = 0, bool|null $stock = true, string|null $orden = ''): array|null
{
    $data = null;


    $select = "SELECT A.ID_ARTICULO AS ID_ARTICULO, A.NOMBRE AS NOMBRE, A.PRECIO AS PRECIO, A.IMAGEN AS IMAGEN FROM ARTICULOS A INNER JOIN CATEGORIAS C ON A.CATEGORIA = C.ID_CATEGORIA WHERE ";

    if ($nombre) {
        $nombre = '%' . $nombre . '%';
        $select .= "A.NOMBRE LIKE :nombre AND ";
    }
    if ($categoria) {
        $select .= "(A.CATEGORIA = :categoria OR C.ID_CATEGORIA_PADRE = :categoria) AND ";
    }
    if ($precio_maximo) {
        $select .= "A.PRECIO < :precio_max AND ";
    }
    if ($stock) {
        $select .= "A.STOCK > 0 ";
    }

    if (str_ends_with($select, 'AND ')) {
        $select = rtrim($select, 'AND ');
    }
    $select .= $orden;
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            if ($nombre) {
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            }
            if ($categoria) {
                $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            }
            if ($precio_maximo) {
                $stmt->bindParam(':precio_max', $precio_maximo, PDO::PARAM_INT);
            }
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}

function contar_articulos_nombre_filtro(PDO|bool $conn, string|null $nombre, int|null $categoria = null, int|null $precio_maximo = 0, bool|null $stock = true, string|null $orden = ''): int|null
{
    $data = null;


    $select = "SELECT COUNT(A.ID_ARTICULO) AS TOTAL FROM ARTICULOS A INNER JOIN CATEGORIAS C ON A.CATEGORIA = C.ID_CATEGORIA WHERE ";

    if ($nombre) {
        $nombre = '%' . $nombre . '%';
        $select .= "A.NOMBRE LIKE :nombre AND ";
    }
    if ($categoria) {
        $select .= "(A.CATEGORIA = :categoria OR C.ID_CATEGORIA_PADRE = :categoria) AND ";
    }
    if ($precio_maximo) {
        $select .= "A.PRECIO < :precio_max AND ";
    }
    if ($stock) {
        $select .= "A.STOCK > 0 ";
    }

    if (str_ends_with($select, 'AND ')) {
        $select = rtrim($select, 'AND ');
    }
    $select .= $orden;
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            if ($nombre) {
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            }
            if ($categoria) {
                $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            }
            if ($precio_maximo) {
                $stmt->bindParam(':precio_max', $precio_maximo, PDO::PARAM_INT);
            }
            $stmt->execute();
            $res = $stmt->fetch();
            if (is_array($res) && count($res) > 0) {
                $data = $res['TOTAL'];
            }
        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}
?>