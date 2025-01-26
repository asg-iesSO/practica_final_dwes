<?php
$root = '../';
$title = 'The Game Store : Articulo';
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
            <img src="<?php echo $root ?>imgs/z_echoes.jpg" class="img-fluid" alt="...">
        </div>
        <div class="col-sm-6 ">
            <h3>The Legend of zelda ....</h3>
            <div class="d-flex flex-row">
                <h4 class="me-2">40 €</h4>
                <h4 class="me-2">Unidades en Stock / Ultimas unidades</h4>
            </div>

            <article>
                Suspendisse potenti. Nunc in leo urna. In pharetra, felis non hendrerit elementum, felis nunc laoreet
                erat, eget faucibus mi neque id massa. Vivamus venenatis turpis vel ex laoreet, luctus sagittis nisi
                varius. Integer luctus hendrerit magna, ac ornare ex cursus sed. Nunc eu egestas risus, a vulputate
                quam. Mauris sit amet erat congue, semper enim et, sodales leo. Vestibulum pulvinar pulvinar semper. Nam
                pharetra laoreet metus, at laoreet nibh accumsan a. Mauris in posuere nisi. Interdum et malesuada fames
                ac ante ipsum primis in faucibus. Aliquam non risus bibendum, consectetur libero in, tempor augue. Donec
                eu quam metus. Curabitur consectetur nisi vitae lacus accumsan, quis mollis nunc dictum. Integer
                tristique cursus nisi at placerat.
            </article>
            <div class="py-4">
                <button class="btn btn-primary">Añadir al carrito</button>
            </div>
        </div>
    </div>
    <div class="row my-4 justify-content-center">
        <h4>Otros productos de esta categoria</h4>
        <div class="col m-4">
            <div class="row min-width-content">
                <?php
                for ($i = 0; $i < 6; $i++) {
                    echo '
                    <div class="card col-sm-1 m-2" style="width: 12rem;">
                        <img src="' . $root . 'imgs/z_echoes.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>';
                }

                ?>
            </div>
        </div>
    </div>
</section>
<?php include($root . 'paginas_comunes/footer.php'); ?>