<?php

    // Trait de génération de cartes de présentation des billets

trait CardTemplate
{
    /**
     * Intègre l'image demandée par l'admin, sinon utilise le background par défaut
     *
     * @param $bgImage
     * @return string
     */
    private function _setBgImage($bgImage) {
        if ($bgImage !== null) {
            return 'background-image: url(' . $bgImage . ')';
        } else {
            return 'background-image: url(../../Vendor/assets/styleguide/cover-bubble-dark.svg); background-position: right bottom; background-repeat: repeat';
        }
    }
    // Créé la carte en fonction du texte inséré dans l'argument
    /**
     * @param $cardTextContent
     * @param $cardDate
     * @param $bgImage
     * @return false|string
     */
    protected function cardBuilder($cardTextContent, $cardDate, $bgImage) {
        ob_start()
            ?>

        <article class="postCard">
            <div class="py-5" style="<?= $this->_setBgImage($bgImage)?>; background-size: cover; background-attachment: fixed;">
                <div class="container">
                    <div class="row m-0">
                        <div class="ml-auto bg-white col-md-4 p-4 border border-right-0 border-dark">
                            <div class="bg-primary card"> <img class="img-fluid rounded-circle w-75 mx-auto mt-3" src="../Vendor/assets/styleguide/people_5.jpg" alt="Card image">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Jean Forteroche</h4>
                                    <p class="card-text text-center">Je suis écrivain&nbsp;<br>et vraiment très malin</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 col-md-7 mr-auto bg-white text-dark justify-content-between d-inline-flex border border-left-0 border-dark">
                            <div class="blockquote mb-0 p-2 flex-column align-items-end justify-content-center d-inline-flex bg-primary" style="width: 100%">
                                <p class="bg-primary align-self-center"><?= htmlspecialchars($cardTextContent) ?></p>
                                <p class="justify-content-end"><?= htmlspecialchars($cardDate) ?></p>
                                <div class="blockquote-footer"><b>Jean Forteroche</b>, écrivain d'intérieur.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
            <?php

        return ob_get_clean();
    }
}
?>


