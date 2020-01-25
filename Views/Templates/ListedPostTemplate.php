<?php

    // Classe de template pour l'affichage de la liste des billets

class ListedPostTemplate
{
    private $_postNumber = 1;
    private $_postPair = [];
    private $_postEnd;
    private $_safeGet;

    /**
 * ListedPostTemplate constructor.
* @param $postsInjection
*/public function __construct($postsInjection)
    {

        $this->_setSecurity();

        if (!empty($postsInjection['posts'])) {
            $posts = $postsInjection['posts'];
            $this->_postEnd = count($posts);
            echo $this->_postListBuilder($posts);
        }

        echo $this->_listIndex();

    }

    /**
     * Appel de la global $security et récupération des données filtrées
     *
     * @return void
     */
    private function _setSecurity() {
        global $security;
        $this->_safeGet = $security->getFilteredGet();
    }

    /**
    * @param $postsInjection
    * @return false|string
    */
    private function _postListBuilder($postsInjection) {
        ob_start();
        ?>

        <section id="listedPosts">
            <div class="text-center">
                <div class="container-fluid">

                    <div>
                        <h3 class="lead p-3 m-3 bg-dark commentTitle">Liste des billets</h3>
                    </div>

                    <?php
                    foreach ($postsInjection as $postContent) {
                        $this->_postNumber++;
                        if ( $this->_postNumber % 3 === 1) {
                            $this->_postPair[3] = $postContent;
                            echo $this->_rowBuilder($this->_postPair[2], $this->_postPair[3]);
                        } else {
                            $this->_postPair[2] = $postContent;
                            if ($this->_postNumber === $this->_postEnd) {
                                echo $this->_rowBuilder($this->_postPair[2], null);
                            }
                        }
                    }
                    ?>

                </div>
            </div>
        </section>

        <?php
        return ob_get_clean();
    }

    /**
    * @param $randNumber
    * @return string
    */
    private function _setColor($randNumber) {
        switch ($randNumber) {
            case ($randNumber === 4):
                return 'secondary';
                break;
            case ($randNumber === 3):
                return 'primary';
                break;
            case ($randNumber  === 2):
                return 'dark';
                break;
            default:
                return 'primary';
                break;
        }
    }

    /**
    * @param $postOdd
    * @param $postEven
    * @return false|string
    */
    private function _rowBuilder($postOdd, $postEven) {
        ob_start();
        ?>
            <div class="row px-1">

                <?php echo $this->_postBuilder($postOdd) ?>
                <?php echo $this->_postBuilder($postEven) ?>

            </div>
        <?php
        return ob_get_clean();
    }

    /**
    * @param $post
    * @return false|string|null
    * @throws Exception
    */
    private function _postBuilder($post)
    {
        if ($post !== null) {
            $postColor = $this->_setColor(random_int(2, 4));
            $postTitle = $post->title();
            $postContent = substr($post->content(), 1, 101);
            $postImg = $post->image();
            $postId = $post->id();

            if($this->_safeGet['post'] === 'list') {
                if ($this->_safeGet['editor'] === 'edit') {
                    $postUrl = 'Panel?editor=edit&post=' . urlencode($postTitle);
                } elseif ($this->_safeGet['editor'] === 'delete') {
                    $postUrl = 'Panel?editor=delete&post=list&submit=' . $postId;
                } elseif (isset($this->_safeGet['comments'])) {
                    $postUrl = 'Panel?comments=' . $this->_safeGet['comments'] . '&post=' . urlencode($postTitle);
                }
            } else {
                $postUrl = 'Post/' . $postTitle;
            }

            ob_start();

            if ($postImg !== null) {
                ?>
                    <div class="postCol col d-flex flex-column align-items-center mx0 pt-4 mb-2" style="background-image: url(<?= $postImg ?>); background-size: cover;">
                <?php
            } else {
                ?>
                    <div class="postCol col d-flex flex-column align-items-center mx0 bg-<?= $postColor ?> pt-4 mb-2">
                <?php
            }
            ?>
                        <div class="col-md-3 mw-99 d-flex justify-content-center">
                            <h4 class="mt-2 bg-light p-1 align-self-center">
                                <a href='<?= $postUrl ?>' class="text-decoration-none text-dark">
                                    <b><?= $postTitle ?></b>
                                </a>
                            </h4>
                        </div>
                        <div class="col-md-3 mw-99 d-flex justify-content-center">
                        <p class="lead mb-4 text-white"><?= $postContent ?></p>
                        </div>
                    </div>
            <?php
            return ob_get_clean();
        } else {
            return null;
        }
    }

    /**
     * @return false|string
     */
    private function _listIndex() {

            $this->_safeGet['post'] === 'list' ? $urlRange = 'Panel?editor=' . $this->_safeGet['editor'] . '&post=list&listrange='
            : $urlRange = '?listrange=';
            $prev = $this->_safeGet['listrange'] - 2;
            $prev <= 2 ? $disabledFlag = 'disabled' : $disabledFlag = '';
            $next = $this->_safeGet['listrange'] + 2;



            ob_start();
            ?>
                <div class="row">
                    <div class="col-md-11">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $disabledFlag ?> "> <a class="page-link" href="<?= $urlRange . $prev ?>">Prev</a> </li>
                            <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>2">2</a> </li>
                            <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>3">3</a> </li>
                            <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>4">4</a> </li>
                            <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>5">5</a> </li>
                            <li class="page-item"> <a class="page-link" href="<?= $urlRange . $next ?>">Next</a> </li>
                        </ul>
                    </div>
                </div>
            <?php
            return ob_get_clean();
        }
}
?>