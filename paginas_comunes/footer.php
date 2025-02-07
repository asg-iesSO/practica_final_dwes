<!-- Footer -->
<footer class="container-fluid container-max-width bg-primary py-2" data-bs-theme="dark">
    <div class="d-flex justify-content-center">
        <a class="active p-2" aria-current="page" href="<?php echo $root ?>">Quienes somos</a>
        <a class="active p-2" aria-current="page" href="<?php echo $root ?>">Contacto</a>
        <a class="active p-2" aria-current="page" href="<?php echo $root ?>">Envio</a>
        <a class="active p-2" aria-current="page" href="<?php echo $root ?>">Condiciones Generales</a>
        <a class="active p-2" aria-current="page" href="<?php echo $root ?>">Devoluciones</a>
    </div>
</footer>

<!-- END Footer -->

<script>
    const modal = document.getElementById('modal');
    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const recipient = button.getAttribute('data-bs-whatever')
        })
    }
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
</script>
</body>
<script>
    feather.replace();
</script>

</html>