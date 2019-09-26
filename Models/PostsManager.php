<?php

class PostsManager extends MainModel {

    public function getPosts() {
        $this->getAll('Posts', 'Post');
    }

}