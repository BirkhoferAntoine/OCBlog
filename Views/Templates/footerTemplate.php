<?php

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
                                        <p class="lead mb-2"><b>Follow us</b></p>
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