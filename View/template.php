<?php

    ob_start();
    ?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta name="description" content="Blog Ecrivain">
            <meta name="keywords" content="Openclassrooms Blog Ecrivain Jean Forteroche">
            <meta name="author" content="Antoine Birkhofer">

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
            <link rel="stylesheet" href="../Vendor/wireframe.css">

            <script defer src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" style=""></script>

            <title><?= $title ?> Jean Forteroche Blog</title>

        </head>

<?php
    $headerTemplate = ob_get_clean();

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
                            <li class="nav-item mx-1"> <a class="nav-link" href="#"><span class="fa fa-newspaper-o mx-1"></span>Accueil</a> </li>
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
                        <li class="nav-item p-0"> <a class="nav-link" href="#">Log in</a> </li>
                        <li class="nav-item p-0"> <a class="nav-link text-primary" href="#">Register</a> </li>
                    </ul>
                    <ul class="nav nav-pills d-flex align-items-center justify-content-center" style="">
                        <li class="nav-item"> <a href="" class="nav-link" data-toggle="pill" data-target="#tabone"><span class="fa fa-lg fa-envelope-open"></span> </a> </li>
                        <li class="nav-item"> <a class="nav-link" href="" data-target="#tabtwo" data-toggle="pill"><span class="fa fa-lg fa-comment"></span></a> </li>
                        <li class="nav-item">
                            <div class="btn-group m-2"> <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="fa fa-lg fa-cog"></span> </button>
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header">Dropdown header</h6> <a class="dropdown-item" href="#">Option 1</a> <a class="dropdown-item" href="#">Option 2</a> <a class="dropdown-item disabled" href="#">Disabled option</a>
                                    <div class="dropdown-divider"></div> <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
<?php
    $navbarTemplate = ob_get_clean();

    ob_start();
?>

    <footer class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="mx-auto col-md-4">
                                    <p class="lead mb-2">Follow us</p>
                                    <div class="row">
                                        <div class="col-md-12 d-flex align-items-center justify-content-between"> <a href="#">
                                                <span class="d-block fa fa-twitter text-muted fa-2x"></span>
                                                </a> <a href="#">
                                                <span class="d-block fa fa-google-plus-official text-muted fa-2x"></span>
                                                </a> <a href="#">
                                                    <span class="d-block fa fa-instagram text-muted fa-2x"></span>
                                                </a> <a href="#">
                                                    <span class="d-block fa fa-pinterest-p text-muted fa-2x"></span>
                                                </a> <a href="#">
                                                    <span class="d-block fa fa-reddit text-muted fa-2x"></span>
                                                </a> <a href="#">
                                                    <span class="d-block fa fa-facebook-official text-muted fa-2x"></span>
                                                </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 mb-0">© 2019 Antoine Birkhofer. All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

<?php
$footerTemplate = ob_get_clean();

?>