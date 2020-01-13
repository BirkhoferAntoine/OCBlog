<?php

class PostsManager extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Posts
    public function getPosts($order, $where) {
        return $this->getTableContent('Posts', 'Post', $order, $where);
    }

    public function deletePost($id) {
        $this->dropPost($id);
    }

    public function insertNewPost($title, $content, $urlImage) {
        $this->newPost($title, $content, $urlImage);
    }

    public function editPost($title, $content, $urlImage, $id) {
        $this->updatePost($title, $content, $urlImage, $id);
    }
}

