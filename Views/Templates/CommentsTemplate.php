<?php


class CommentsTemplate extends ViewPost
{

    public function __construct($commentsInjection)
    {
        parent::__construct();

        echo $this->_commentsBuilder($commentsInjection);

    }

    private function _commentsBuilder($commentsInjection) {
        ob_start();
        ?>

        <div class="text-center">
            <div class="container-fluid">

                <?php
                foreach ($commentsInjection as $commentContent) {
                    echo $this->_rowBuilder($commentContent);
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

    private function _rowBuilder($comment) {
        ob_start();
        ?>
        <div class="row px-2">

            <?php echo $this->_commentBuilder($comment) ?>

        </div>
        <?php
        return ob_get_clean();
    }

    private function _commentBuilder($comment) {
        $commentColor = $this->_setColor(random_int(1, 3));
        $commentUser = $comment->user();
        $commentContent = $comment->comment();
        $commentDate = $comment->comment_date();

        ob_start();
        ?>
        <div class="col mx-2 bg-<?= $commentColor ?> pt-5 px-5 mb-3">
            <div class="blockquote mb-0 flex-column justify-content-center d-inline-flex">
                <p class="mt-3"><b><?= $commentUser ?></b></p>
                <p class="lead mb-5 text-white"><?= $commentContent ?></p>
                <p><?= $commentDate ?></p>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

}