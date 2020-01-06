<?php

class PostsManager extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Posts
    public function getPosts($order, $where) {
        return $this->getTableContent('Posts', 'Post', $order, $where);
    }

    public function deletePost($text) {
        $this->deleteTableContent('`Content` = ' . $text, 'Posts');
    }

    public function insertNewPost($content) {
        $this->newPost($content);
    }
}

