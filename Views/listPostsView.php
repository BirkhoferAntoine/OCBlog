<?php

    ob_start();
?>

    <div class="py-5 text-center" style="background-image: url('https://static.pingendo.com/cover-bubble-dark.svg');background-size:cover;">
        <div class="container" style="	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="	background-image: url(https://pingendo.com/site-assets/cover.jpg);	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
                        <div class="mx-auto p-5 my-5 col-md-12 bg-primary" style="">
                            <h1 class="display-4">Blog écrivain</h1>
                            <p class="lead">Parce que Skyblog était une bonne chose pour l'humanité (sic)</p>
                            <a class="btn btn-outline-dark" href="#">Lâchez vos comms wesh!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    $homeHeroContent = ob_get_clean();


    $cardTextContent = "A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.";
    require_once('Templates/CardTemplate.php');

    ob_start()
?>


    <div class="text-center">
        <div class="container-fluid">
            <div class="row px-2">
                <div class="col mx-2 bg-dark pt-5 px-5 mb-3">
                    <h2 class="mt-3"><b><?= $postTitle ?></b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
                <div class="col mx-2 pt-5 px-5 bg-primary mb-3">
                    <h2 class="mt-3"><b>Billet numéro 2</b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
            </div>
            <div class="row px-2">
                <div class="col mx-2 pt-5 px-5 mb-3 bg-light">
                    <h2 class="mt-3"><b>Another headline</b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
                <div class="col mx-2 pt-5 px-5 mb-3 bg-secondary">
                    <h2 class="mt-3"><b>Another headline</b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
            </div>
            <div class="row px-2">
                <div class="col mx-2 pt-5 px-5 mb-3 bg-info">
                    <h2 class="mt-3"><b>Another headline</b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
                <div class="col mx-2 pt-5 px-5 mb-3 bg-primary">
                    <h2 class="mt-3"><b>Another headline</b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
            </div>
            <div class="row px-2">
                <div class="col mx-2 pt-5 px-5 mb-3 bg-light">
                    <h2 class="mt-3"><b>Another headline</b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
                <div class="col mx-2 pt-5 px-5 mb-3 bg-light">
                    <h2 class="mt-3"><b>Another headline</b></h2>
                    <p class="lead mb-5">And an even wittier subheading.</p>
                    <img class="img-fluid d-block" src="https://pingendo.com/assets/photos/wireframe/photo-1.jpg" width="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"> <a class="page-link" href="#">Prev</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">2</a> </li>
                        <li class="page-item active"> <a class="page-link" href="#">3</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">4</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">Next</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php
    $listPostsContent = ob_get_clean();

?>