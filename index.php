<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>The Game Store : Inicio</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        const exampleModal = document.getElementById('exampleModal')
        if (exampleModal) {
            exampleModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const recipient = button.getAttribute('data-bs-whatever')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const modalTitle = exampleModal.querySelector('.modal-title')
                const modalBodyInput = exampleModal.querySelector('.modal-body input')

                modalTitle.textContent = `New message to ${recipient}`
                modalBodyInput.value = recipient
            })
        }</script>

    <!-- Header/Navbar-->

    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">The Game Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Outlet</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-auto-close="outside">Login</a>
                            <div class="dropdown-menu">
                                <form class="px-4 py-3">
                                    <div class="mb-3">
                                        <label for="exampleDropdownFormEmail1" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="exampleDropdownFormEmail1"
                                            placeholder="email@example.com">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleDropdownFormPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleDropdownFormPassword1"
                                            placeholder="Password">
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="dropdownCheck">
                                            <label class="form-check-label" for="dropdownCheck">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                </form>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-bs-whatever="@mdo">New around here? Sign up</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    data-bs-whatever="@fat">Forgot password?</a>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>


    </nav>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>

    <!-- End header/navbar-->
    <section class="container-max-width" data-bs-theme="dark">
        <div class="row">
            <div class="col-md-auto">
                <p>
                    <button class="btn btn-primary btn-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseWidthExample" aria-expanded="true"
                        aria-controls="collapseWidthExample">
                        <span class="navbar-toggler-icon"></span>
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
                            <div class="card m-2" style="width: 12rem;">
                                <img src="./imgs/z_echoes_.jpg" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>';
                    }

                    ?>
                </div>
                <nav class="d-flex justify-content-center" aria-label="...">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
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



    <!-- Footer -->
    <footer class="container-fluid container-max-width bg-primary py-2" data-bs-theme="dark">
        <div class="d-flex justify-content-center">
            <a class="active p-2" aria-current="page" href="#">Quienes somos</a>

            <a class="active p-2" aria-current="page" href="#">Contacto</a>
            <a class="active p-2" aria-current="page" href="#">Envio</a>
            <a class="active p-2" aria-current="page" href="#">Condiciones Generales</a>
            <a class="active p-2" aria-current="page" href="#">Devoluciones</a>
        </div>
    </footer>

    <!-- END Footer -->
</body>

</html>