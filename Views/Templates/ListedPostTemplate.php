<?php


class ListedPostTemplate
{
    private $_postNumber = 0;
    private $_postPair = [];
    private $_postEnd;
    private $_safeGet;

    public function __construct($postsInjection)
    {

        $this->_setSecurity();

        if (!empty($postsInjection['posts'])) {
            $posts = $postsInjection['posts'];
            $this->_postEnd = count($posts);
            echo $this->_postListBuilder($posts);
        }

        echo $this->_listIndex();


    }

    private function _setSecurity() {
        global $security;
        $this->_safeGet = $security->getFilteredGet();
    }

    private function _postListBuilder($postsInjection) {
        ob_start();
        ?>

        <section id="listedPosts">
            <div class="text-center">
                <div class="container-fluid">

                    <div>
                        <h2 class="lead p-4 m-4 bg-dark commentTitle">Liste des billets</h2>
                    </div>

                    <?php
                    foreach ($postsInjection as $postContent) {
                        $this->_postNumber++;
                        if ( $this->_postNumber % 2 === 0) {
                            $this->_postPair[2] = $postContent;
                            echo $this->_rowBuilder($this->_postPair[1], $this->_postPair[2]);
                        } else {
                            $this->_postPair[1] = $postContent;
                            if ($this->_postNumber === $this->_postEnd) {
                                echo $this->_rowBuilder($this->_postPair[1], null);
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

    private function _setColor($randNumber) {
        switch ($randNumber) {
            case ($randNumber === 3):
                return 'secondary';
                break;
            case ($randNumber === 2):
                return 'primary';
                break;
            case ($randNumber  === 1):
                return 'dark';
                break;
            default:
                return 'primary';
                break;
        }
    }

    private function _rowBuilder($postOdd, $postEven) {
        ob_start();
        ?>
            <div class="row px-2">

                <?php echo $this->_postBuilder($postOdd) ?>
                <?php echo $this->_postBuilder($postEven) ?>

            </div>
        <?php
        return ob_get_clean();
    }

    private function _postBuilder($post)
    {
        if ($post !== null) {
            $postColor = $this->_setColor(random_int(1, 3));
            $postTitle = $post->title();
            $postContent = $post->content();
            $postImg = $post->image();
            $postId = $post->id();

            if($this->_safeGet['post'] === 'list') {
                if ($this->_safeGet['editor'] === 'edit') {
                    $postUrl = 'Panel?editor=edit&post=' . $postTitle;
                } elseif ($this->_safeGet['editor'] === 'delete') {
                    $postUrl = 'Panel?editor=delete&post=list&submit=' . $postId;
                } elseif (isset($this->_safeGet['comments'])) {
                    $postUrl = 'Panel?comments=' . $this->_safeGet['comments'] . '&post=' . $postTitle;
                }
            } else {
                $postUrl = 'Post/' . $postTitle;
            }

            ob_start();

            if ($postImg !== null) {
                ?>
                    <div class="col d-flex flex-column align-items-center pt-5 px-5 mb-3" style="background-image: url(<?= $postImg ?>); background-size: cover;">
                <?php
            } else {
                ?>
                    <div class="col d-flex flex-column align-items-center bg-<?= $postColor ?> pt-5 px-5 mb-3">
                <?php
            }
            ?>
                        <div class="col-md-4 d-flex justify-content-center">
                            <h3 class="mt-3 bg-light p-2 align-self-center">
                                <a href='<?= $postUrl ?>' class="text-decoration-none text-dark">
                                    <b><?= $postTitle ?></b>
                                </a>
                            </h3>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                        <p class="lead mb-5 text-white"><?= $postContent ?></p>
                        </div>
                    </div>
            <?php
            return ob_get_clean();
        } else {
            return null;
        }
    }

    private function _listIndex() {

        $this->_safeGet['post'] === 'list' ? $urlRange = 'Panel?editor=' . $this->_safeGet['editor'] . '&post=list&listrange='
        : $urlRange = '?listrange=';
        $prev = $this->_safeGet['listrange'] - 1;
        $prev <= 1 ? $disabledFlag = 'disabled' : $disabledFlag = '';
        $next = $this->_safeGet['listrange'] + 1;



        ob_start();
        ?>
            <div class="row">
                <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $disabledFlag ?> "> <a class="page-link" href="<?= $urlRange . $prev ?>">Prev</a> </li>
                        <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>1">1</a> </li>
                        <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>2">2</a> </li>
                        <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>3">3</a> </li>
                        <li class="page-item"> <a class="page-link" href="<?= $urlRange ?>4">4</a> </li>
                        <li class="page-item"> <a class="page-link" href="<?= $urlRange . $next ?>">Next</a> </li>
                    </ul>
                </div>
            </div>
        <?php
        return ob_get_clean();
    }
}
?>