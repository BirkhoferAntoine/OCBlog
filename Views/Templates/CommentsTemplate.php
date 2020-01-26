<?php

    // Classe de template pour l'affichage des commentaires de billets

class CommentsTemplate extends ViewPost
{

    private $_safeGet;
    private $_safeUri;
    private $_submitUri;

    /**
     * CommentsTemplate constructor.
     * @param $commentsInjection
     */
    public function __construct($commentsInjection)
    {

        $this->_setSecurity();
        if (!isset($this->_safeGet['comments']) && isset($this->_safeGet['editor'])) {
        } else {
            echo $this->_postCommentsBuilder($commentsInjection);
        }
    }

    /**
     * Appel de la global $security et récupération des données filtrées
     *
     * @return void
     */
    private function _setSecurity() {
        global $security;
        $this->_safeGet = $security->getFilteredGet();
        $this->_safeUri = $security->getFilteredUri(2);
        $this->_safeGet['submit'] === 'true' ? $this->_submitUri = $this->_safeUri : $this->_submitUri = $this->_safeUri . '&submit=true';
        }

    /**
     * @param $commentsInjection
     * @return false|string
     */
    private function _postCommentsBuilder($commentsInjection) {
        ob_start();
        ?>

        <section id="comments">
            <div class="text-center bg-light">
                <div class="container-fluid bg-primary commentContainer">

                    <div>
                        <h2 class="lead p-4 m-4 bg-dark commentTitle">Commentaires</h2>
                    </div>

                    <?php
                    foreach ($commentsInjection as $commentContent) {
                        echo $this->_rowBuilder($commentContent);
                    }

                    echo $this->_commentForm();
                    ?>

                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * @param $comment
     * @return false|string
     */
    private function _rowBuilder($comment) {
        ob_start();
        ?>
        <div class="row px-2 m-2">

            <?php echo $this->_commentBuilder($comment) ?>

        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * @param $comment
     * @return false|string
     */
    private function _commentBuilder($comment) {
        $commentId = $comment->id();
        $commentUser = $comment->user();
        $commentContent = $comment->comment();
        $commentDate = $comment->comment_date();

        if ($this->_safeGet['comments'] === 'list') {
            $commentPostId = $comment->billet_id();
            $commentInfo = 'Publié le ' . $commentDate . ' pour le billet id #' . $commentPostId;

            $commandBox = $this->_commandBox('admin', $commentId);
        } else {
            $commentInfo = 'Publié le ' . $commentDate;

            $commandBox = $this->_commandBox('user', $commentId);
        }

        ob_start();
        ?>
            <div class="commentCol col mx-2 bg-dark p-2 mb-1">
                <div class="bg-primary card w-25 cardComm"> <img class="img-fluid rounded-circle w-50 mx-auto mt-3 avatarComm" src="../../Vendor/assets/wright.jfif" alt="Card image">
                    <div class="card-body commCardBody">
                        <span class="card-title commCardTitle font-weight-light text-center"><?= $commentUser ?></span>
                    </div>
                </div>
                <div class="commentText px-2 col mr-auto text-light justify-content-between d-inline-flex flex-column">
                    <div class="blockquote w-100 h-100 mb-0 justify-content-center d-inline-flex">
                        <p class="lead font-weight-light m-auto d-inline-flex align-items-center h-100 text-light"><?= $commentContent ?></p>
                    </div>
                    <p class="justify-content-end m-0"><?= $commentInfo ?></p>
                </div>
                <?= $commandBox ?>
            </div>

        <?php
        return ob_get_clean();
    }

    /**
     * @param $type
     * @param $id
     * @return false|string
     */
    private function _commandBox($type, $id) {
        if ($type === 'admin') {

            ob_start();
            ?>

                    <form class="commandBox p-2 col mr-auto text-light justify-content-between d-inline-flex flex-column" id="commentBox_<?= $id ?>" method="post" action="<?= $this->_submitUri?>">
                        <button class="commandBoxButton text-primary" type="submit" name="accept" value="<?= $id ?>"><i class="far fa-check-square"></i> ACCEPTER</button>
                        <button class="commandBoxButton text-primary" type="submit" name="edit" value="<?= $id ?>"><i class="fas fa-edit"></i> EDITER</button>
                        <button class="commandBoxButton text-primary" type="submit" name="delete" value="<?= $id ?>"><i class="fas fa-ban"></i> SUPPRIMER</button>
                    </form>

            <?php
            return ob_get_clean();

        } elseif ($type === 'user' && isset($_SESSION['level'])) {

            ob_start();
            ?>


            <form class="commandBox p-2 col mr-auto text-light justify-content-end d-inline-flex flex-column" id="commentBox_<?= $id ?>" method="post" action="?flag=submit">
                <div class="form-group flagBoxDiv">
                    <button class="commandBoxButton text-primary" type="submit" name="flag" value="<?= $id ?>"><i class="fas fa-bullhorn"></i> <span class="flagBoxText">SIGNALER</span></button>
                </div>
            </form>

            <?php
            return ob_get_clean();
            //onclick="alert('Voulez vous signaler ce message en tant que contenu indésirable?')"
        }
    }

    /**
     * @return false|string
     */
    private function _commentForm() {

        if ($this->_safeGet['comments'] !== 'list') {

            if (isset($_SESSION['logedin'])) {

                ob_start();
                ?>

                <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
                <script type="text/javascript">
                        tinymce.init({
                        selector: '#commentEditor',
                        plugins: 'autolink code link preview',
                        toolbar: 'code link preview',
                        menubar: 'tools insert view'
                    });</script>

                <div class="my-4">
                    <h3 class="lead p-4 m-4 bg-dark commentTitle">Laisser un commentaire</h3>
                </div>

                <div>
                    <form class="w-100" method="post" action=?comment=submit>
                        <fieldset>

                            <legend>Nouveau message</legend>
                            <div class="form-group">
                                <label for="commentEditor"></label>
                                <textarea class="form-control" id="commentEditor" name="commentUser"></textarea>
                            </div>

                            <input type="text" name="user" value="<?= $_SESSION['username'] ?>" hidden>

                            <div class="form-group text-center">
                                <input type="submit" class="align-self-center justify-content-center w-50 text-center">
                            </div>

                        </fieldset>
                    </form>
                </div>

                <?php
                return ob_get_clean();

            } else {

                ob_start();
                ?>

                <div class="my-4">
                    <h3 class="lead p-4 m-4 bg-dark commentTitle">
                        Veuillez vous <a class="text-danger" href="<?= URL ?>User/Login"><u>connecter</u></a>
                        ou vous <a class="text-danger" href="<?= URL ?>User/Register"><u>inscrire</u></a>
                        pour laisser un commentaire</h3>
                </div>

                <?php
                return ob_get_clean();
            }
        }
    }

}