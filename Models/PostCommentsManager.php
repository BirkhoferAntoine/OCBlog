<?php

    // Classe de gestion des commentaires de billets

class PostCommentsManager extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Commentaires
    /**
     * @param $order
     * @param $where
     * @return array
     */
    public function getComments($order, $where) {
        return $this->getTableContent('Comments', 'PostComments', $order, $where);
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteComment($id) {
        return $this->dropComment($id);
    }

    /**
     * @param $id
     * @return void
     */
    public function acceptComment($id) {
        return $this->levelComment($id, '2');
    }

    /**
     * @param $id
     * @return void
     */
    public function flagComment($id) {
        return $this->levelComment($id, '1');
    }

    /**
     * @param $comment
     * @param $user
     * @param $postId
     * @return void
     */
    public function addComment($comment, $user, $postId) {
        return $this->newComment($comment, $user, $postId);
    }
}