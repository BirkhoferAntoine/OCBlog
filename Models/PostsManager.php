<?php

class PostsManager extends MainModel {

    // Lien entre la BDD (MainModel) et le controller pour instancier les Posts
    public function getPosts() {
        return $this->getTableContent('Posts', 'Post');
    }

}