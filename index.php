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
                    data-bs-target="#collapseFiltro" aria-expanded="true" aria-controls="collapseFiltro">
                    <i data-feather="filter"></i>
                </button>
            </p>

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
                                <a href="#" class="list-group-item list-group-item-action">The current link item</a>
                                <a href="#" class="list-group-item list-group-item-action">A second link item</a>
                                <a href="#" class="list-group-item list-group-item-action">A third link item</a>
                                <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
                            </div>
                        </div>
                    </div>
                    <hr class="hr" />
                    <form>
                        <div class="my-2">
                            <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nombre">
                        </div>

                        <label for="customRange2" class="form-label">Precio máximo</label>
                        <input type="range" class="form-range" min="0" max="100" id="customRange2">

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">En stock</label>
                        </div>


                    </form>
                </div>
            </div>
        </div>



        <div class="col">
            <div class="d-flex flex-row flex-wrap m-4">
                <?php
                for ($i = 0; $i < 20; $i++) {
                    echo '
                            <a href="' . $root . 'articulo/detalle_articulo.php"><div class="card text-bg-primary m-2 p-2" style="width: 12rem;">
                                <img src="./imgs/z_echoes.jpg" class="card-img-top" alt="...">
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