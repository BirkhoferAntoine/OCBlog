<?php

    // Classe de gestion des billets

class PostsManager extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Posts
    /**
     * @param $order
     * @param $where
     * @return array
     */
    public function getPosts($order, $where) {
        return $this->getTableContent('Posts', 'Post', $order, $where);
    }

    /**
     * @param $id
     * @return void
     */
    public function deletePost($id) {
        return $this->dropPost($id);
    }

    /**
     * @param $title
     * @param $content
     * @param $urlImage
     * @return void
     */
    public function insertNewPost($title, $content, $urlImage) {
        return $this->newPost($title, $content, $urlImage);
    }

    /**
     * @param $title
     * @param $content
     * @param $urlImage
     * @param $id
     * @return void
     */
    public function editPost($title, $content, $urlImage, $id) {
        return $this->updatePost($title, $content, $urlImage, $id);
    }
}

