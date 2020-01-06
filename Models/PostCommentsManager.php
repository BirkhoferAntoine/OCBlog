<?php


class PostCommentsManager extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Commentaires
    public function getComments($order, $where) {
        return $this->getTableContent('Comments', 'PostComments', $order, $where);
    }

    public function deleteComment($text) {
        $this->deleteTableContent('`comment` = ' . $text, 'Comments');
    }
}