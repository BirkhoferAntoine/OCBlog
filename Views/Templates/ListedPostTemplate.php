<?php


class ListedPostTemplate extends ViewHome
{
    private $_postNumber = 0;
    private $_postPair = [];
    private $_postEnd;

    public function __construct($postInjection)
    {
        parent::__construct();

        $postReturn = $postInjection['posts'];

        $this->_postEnd = count($postReturn);

        echo $this->_postListBuilder($postReturn);

    }

    private function _postListBuilder($postInjection) {
        ob_start();
        ?>

        <div class="text-center">
            <div class="container-fluid">

                <?php
                foreach ($postInjection as $postContent) {
                    $this->_postNumber++;
                    $this->postArray{$this->_postNumber} = new ArrayObject($postContent);
                    echo '<pre>' . print_r($this->postArray{$this->_postNumber}) . '</pre>';
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
            case ($randNumber === 5):
                return 'info';
                break;
            case ($randNumber === 4):
                return 'secondary';
                break;
            case ($randNumber === 3):
                return 'light';
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

    private function _postBuilder($post) {
        $postColor = $this->_setColor(random_int(1, 5));
        $postTitle = $post->title();
        $postContent = $post->content();
        //$postUrl = $postTitle;
        $postId = $post->id();
        //$postImg = $post->image();
        // $this->_view = new View('Post');

        ob_start();
        ?>

        <div class="col mx-2 bg-<?= $postColor ?> pt-5 px-5 mb-3">
            <h2 class="mt-3 ">
                <a href='post=<?= $postId ?>'>
                    <b><?= $postTitle ?></b>
                </a>
            </h2>
            <p class="lead mb-5"><?= $postContent ?></p>
           <img class="img-fluid d-block" src="<?= '$post->image()' ?>" width="">
        </div>

        <?php
        return ob_get_clean();
    }

}
