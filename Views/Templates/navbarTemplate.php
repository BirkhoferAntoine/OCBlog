<?php

ob_start();
?>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark align-items-baseline d-flex flex-nowrap flex-row justify-content-between sticky-top p-1" style=""><a class="navbar-brand d-none d-md-block ml-4 mr-2" href="#" style="">
            <span class="fa d-inline fa-lg fa-circle"></span>
            <b> BRAND</b>
        </a>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="navbar-nav d-flex flex-nowrap flex-row">
                        <li class="nav-item mx-1"> <a class="nav-link" href="<?= URL ?>"><span class="fas fa-home mx-1"></span>
                                <span id="homeTxt">Accueil</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="d-flex flex-row flex-nowrap col-md-12 justify-content-around align-items-baseline" style="">
                <ul class="navbar-nav flex-row flex-nowrap mx-1">
                    <li class="nav-item px-1"> <a class="nav-link text-primary" href="<?= URL ?>User/Login">Connexion</a> </li>
                    <li class="nav-item px-1"> <a class="nav-link text-primary" href="<?= URL ?>User/Register">Inscription</a> </li>
                </ul>
                <ul class="nav nav-pills d-flex align-items-center justify-content-center" style="">
                    <li class="nav-item">
                        <div class="btn-group m-2"> <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="fa fa-lg fa-cog"></span> </button>
                            <div class="dropdown-menu" id="navDrop">
                                <h6 class="dropdown-header">Gestion</h6> <a class="dropdown-item" href="<?= URL ?>User/Panel">Mon compte</a> <a class="dropdown-item" href="<?= URL ?>Home?logout=true">Deconnexion</a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Messages</h6>
                                <a class="dropdown-item" href="#">Inbox</a> <a class="dropdown-item" href="#">Nouveau Message</a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Commentaires</h6>
                                <a class="dropdown-item" href="#">Editer</a> <a class="dropdown-item" href="#">Réagir</a>
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
