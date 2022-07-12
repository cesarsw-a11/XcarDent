<?php $this->load->view('head'); ?>
<link rel="stylesheet" href="<?= base_url("estilos/login.css") ?>">
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">
                    <div>
                        <img class="rounded mx-auto d-block" src="<?= base_url("imagenes/logo_administracion.png") ?>" alt="H. Ayuntamiento">
                    </div>
                    <h5 class="card-title text-center mb-5 fw-light fs-5">Sistema de Compras</h5>
                    <form id="login-form">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="usuario" placeholder="name@example.com">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="pass" placeholder="Password">
                            <label for="floatingPassword">Contraseña</label>
                        </div>


                        <div class="d-grid">
                            <button class="btn btn-dark btn-login text-uppercase fw-bold" type="submit">
                                Acceder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/scripts/login.js') ?>"></script>