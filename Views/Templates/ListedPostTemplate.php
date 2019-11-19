<?php


class ListedPostTemplate extends ViewHome
{
    private $_postNumber = 0;
    private $_postPair = [];
    private $_postEnd;

    public function __construct($postsInjection)
    {
        parent::__construct();

        $posts = $postsInjection['posts'];

        $this->_postEnd = count($posts);
        echo $this->_postListBuilder($posts);
        echo $this->_listIndex();

    }

    private function _postListBuilder($postsInjection) {
        ob_start();
        ?>

        <div class="text-center">
            <div class="container-fluid">

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
            $postUrl = '?name=' . $postTitle;
            $postImg = $post->image();

            ob_start();

            if ($postImg !== null) {
                ?>
                    <div class="col mx-2 pt-5 px-5 mb-3 d-flex flex-column align-items-center" style="background-image: url(<?= $postImg ?>); background-size: cover;">
                <?php
            } else {
                ?>
                    <div class="col d-flex flex-column align-items-center bg-<?= $postColor ?> pt-5 px-5 mb-3">
                <?php
            }
            ?>
                        <div class="col-md-4">
                            <h3 class="mt-3 bg-light">
                                <a href='Post<?= $postUrl ?>' class="text-decoration-none text-dark">
                                    <b><?= $postTitle ?></b>
                                </a>
                            </h3>
                        </div>
                        <div class="col-md-4">
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
        ob_start();
        ?>
            <div class="row">
                <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"> <a class="page-link" href="#">Prev</a> </li>
                        <li class="page-item active"> <a class="page-link" href="#">1</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">2</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">4</a> </li>
                        <li class="page-item"> <a class="page-link" href="#">Next</a> </li>
                    </ul>
                </div>
            </div>
        <?php
        return ob_get_clean();
    }
}
              /*  <picture>
                    <source srcset="<?= $postImg ?>" type="image">
                    <img class="img-fluid d-block" src="<?= $postImg ?>" alt="Image du billet">
                </picture>
                <?php // width="">
            }*/

              ?>