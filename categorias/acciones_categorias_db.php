<?php
function recuperar_todas_las_categorias_padre(PDO|bool $conn): array
{
    $data = null;

    $select = "SELECT * FROM CATEGORIAS WHERE ID_CATEGORIA_PADRE IS NULL ORDER BY NOMBRE";

    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}

function recuperar_la_categoria_padre(PDO|bool $conn,int $categoria): array|bool
{
    $data = null;

    $select = "SELECT * FROM CATEGORIAS WHERE ID_CATEGORIA = (SELECT ID_CATEGORIA_PADRE FROM CATEGORIAS WHERE ID_CATEGORIA = :categoria) ORDER BY NOMBRE;";

    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            $stmt->bindParam('categoria',$categoria,PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}


function recuperar_categorias_por_id_padre(PDO|bool $conn, int $categoria): array {
    $data = null;

    $select = "SELECT * FROM CATEGORIAS WHERE ID_CATEGORIA_PADRE = :categoria ORDER BY NOMBRE";

    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            $stmt->bindParam('categoria',$categoria,PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}

function recuperar_categoria_por_id(PDO|bool $conn, int $categoria): array {
    $data = null;

    $select = "SELECT * FROM CATEGORIAS WHERE ID_CATEGORIA = :categoria ORDER BY NOMBRE";

    if (is_a($conn, 'PDO')) {
        try {
            $stmt = $conn->prepare($select);
            $stmt->bindParam('categoria',$categoria,PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch();
            $data = $res;

        } catch (PDOException $e) {
            header('Location: ' . $GLOBALS['root'] . 'error/pagina_error.php');
        }
    }
    return $data;
}

?>