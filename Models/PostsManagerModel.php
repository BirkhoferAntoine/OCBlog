<?php

class PostsManagerModel extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Posts
    public function getPosts($order, $where) {
        return $this->getTableContent('Posts', 'Post', $order, $where);
    }
}