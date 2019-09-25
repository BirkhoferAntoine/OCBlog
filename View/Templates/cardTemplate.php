<?php

    ob_start()
?>


    <div class="py-5" style="background-image: url(https://static.pingendo.com/cover-bubble-dark.svg); background-position: right bottom;  background-size: cover; background-repeat: repeat; background-attachment: fixed;">
        <div class="container">
            <div class="row m-0">
                <div class="ml-auto bg-white col-md-4 p-4 border border-right-0 border-dark">
                    <div class="bg-primary card"> <img class="img-fluid rounded-circle w-75 mx-auto mt-3" src="../Vendor/assets/styleguide/people_5.jpg" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title text-center">Jean Forteroche</h4>
                            <p class="card-text text-center">Je suis écrivain&nbsp;<br>et vraiment très beau</p>
                        </div>
                    </div>
                </div>
                <div class="p-3 col-md-7 mr-auto bg-white text-dark justify-content-between d-inline-flex border border-left-0 border-dark">
                    <div class="blockquote mb-0 flex-column align-items-end justify-content-center d-inline-flex bg-primary">
                        <p class="bg-primary"><?= $cardTextContent ?></p>
                        <div class="blockquote-footer"> <b>Jean Forteroche</b>, écrivain d'intérieur.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    $cardTemplate = ob_get_clean();


?>
