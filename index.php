<?php
$root = './';
$title = 'The Game Store : Novedades';
include('paginas_comunes/header.php') ?>

<section class="container-max-width p-3">
    <div class="row text-center justify-content-center">
        <div class="col-sm-12">
            <h1>Novedades</h1>
            <hr class="hr" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-auto">
            <p>
                <button class="btn btn-primary btn-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseWidthExample" aria-expanded="true" aria-controls="collapseWidthExample">
                    <i data-feather="filter"></i>
                </button>
            </p>

            <div>
                <div class="collapse show collapse-horizontal" id="collapseWidthExample">
                    <div class="card card-body text-bg-primary" style="width: 300px;">
                        This is some placeholder content for a horizontal collapse. It's hidden by default and shown
                        when triggered.
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="d-flex flex-row flex-wrap m-4">
                <?php
                for ($i = 0; $i < 20; $i++) {
                    echo '
                            <a href="' . $root . 'articulo/detalle_articulo.php"><div class="card text-bg-primary m-2 p-2" style="width: 12rem;">
                                <img src="./imgs/z_echoes_.jpg" class="card-img-top" alt="...">
                                <div class="card-body text-bg-primary">
                                    <h5 class="card-title text-bg-primary">Card title</h5>
                                    <h5 class="card-title text-bg-primary">50€</h5>
                                    <div class="d-flex justify-content-center">
                                        <a class="link-light mx-1" href="#"><i data-feather="shopping-cart"></i></a>
                                    </div>
                                </div>
                            </div></a>';
                }

                ?>
            </div>
            <nav class="d-flex justify-content-center " aria-label="...">
                <ul class="pagination">
                    <li class="page-item ">
                        <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item " aria-current="page">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>

</section>



<?php include('paginas_comunes/footer.php'); ?>