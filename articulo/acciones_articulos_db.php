<?php
function recuperar_todos_los_articulos(PDO|bool $conn, string $filtro = '', string $orden = ''): array
{
    $data = null;


    $select = "SELECT * FROM articulos";
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
    $sql = "SELECT * FROM articulos WHERE ID_ARTICULO=:id";
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
    $nombre = '%'.$nombre.'%';
    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre , PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}
?>