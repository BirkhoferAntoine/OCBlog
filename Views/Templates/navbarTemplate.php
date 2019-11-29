<?php

ob_start();
?>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark align-items-baseline d-flex justify-content-between sticky-top p-1" style=""><a class="navbar-brand d-none d-md-block ml-4 mr-2" href="#" style="">
            <span class="fa d-inline fa-lg fa-circle"></span>
            <b> BRAND</b>
        </a>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="navbar-nav d-flex">
                        <li class="nav-item mx-1"> <a class="nav-link" href="<?= URL ?>"><span class="fa fa-newspaper-o mx-1"></span>Accueil</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#"><span class="fa fa-pencil-square-o mx-1"></span>Livre d'or</a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid"> <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbar12">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar12">
                <ul class="navbar-nav align-items-end justify-content-end d-inline-flex" style=""> </ul>
            </div>
        </div>
        <div class="container">
            <div class="d-flex col-md-12 justify-content-around align-items-baseline" style="">
                <ul class="navbar-nav m-0">
                    <li class="nav-item p-0"> <a class="nav-link" href="<?= URL ?>User/Login">Connexion</a> </li>
                    <li class="nav-item p-0"> <a class="nav-link text-primary" href="<?= URL ?>User/Register">Inscription</a> </li>
                </ul>
                <ul class="nav nav-pills d-flex align-items-center justify-content-center" style="">
                    <li class="nav-item"> <a href="" class="nav-link" data-toggle="pill" data-target="#tabone"><span class="fa fa-lg fa-envelope-open"></span> </a> </li>
                    <li class="nav-item"> <a class="nav-link" href="" data-target="#tabtwo" data-toggle="pill"><span class="fa fa-lg fa-comment"></span></a> </li>
                    <li class="nav-item">
                        <div class="btn-group m-2"> <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="fa fa-lg fa-cog"></span> </button>
                            <div class="dropdown-menu">
                                <h6 class="dropdown-header">Dropdown header</h6> <a class="dropdown-item" href="#">Mon compte</a> <a class="dropdown-item" href="#">Deconnexion</a> <a class="dropdown-item disabled" href="#">Disabled option</a>
                                <div class="dropdown-divider"></div> <a class="dropdown-item disabled" href="#">Page Admin</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
$navbarTemplate = ob_get_clean();

?>
