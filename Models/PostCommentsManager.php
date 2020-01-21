<?php


class PostCommentsManager extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Commentaires
    public function getComments($order, $where) {
        return $this->getTableContent('Comments', 'PostComments', $order, $where);
    }

    public function deleteComment($id) {
        $this->dropComment($id);
    }

    public function acceptComment($id) {
        $this->levelComment($id, '2');
    }

    public function flagComment($id) {
        $this->levelComment($id, '1');
    }

    public function addComment($comment, $user, $postId) {
        $this->newComment($comment, $user, $postId);
    }
}