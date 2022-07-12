<?php $this->load->view('head'); ?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url("administrador") ?>">
            <img src="<?= base_url("imagenes/logo.png") ?>" alt="..." height="65">
            <img src="<?= base_url("imagenes/logo_administracion.png") ?>" alt="..." height="60">
        </a>
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <?php if ($this->session->userdata("rol") == 1 && $this->session->userdata("logged")) { ?>
        <?php } ?>

        <ul class="nav navbar-nav navbar-right">
            <li><a class="nav-link" href="<?= base_url('login/logout') ?>"><span class="fa fa-sign-out"></span>Cerrar Sesión</a></li>
        </ul>
    </div>
</nav>
<script>
    $(document).ready(function() {
        $(".dropdown-toggle").dropdown();
    });
</script>