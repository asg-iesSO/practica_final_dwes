<?php
$root = '../';
$title = 'The Game Store : Error';
include($root . 'paginas_comunes/header.php')
    ?>
<section class="container-max-width  text-center m-3">
    <div class="row">
        <div class="column">
            <img src="<?php echo $root ?>imgs/imagen_error.png" class="w-auto" alt="Imagen de error">
        </div>
    </div>
    <div class="row">
        <h1>Algo ha ido mal, contacta con el administrador</h1>
    </div>
</section>
<?php include($root . 'paginas_comunes/footer.php'); ?>