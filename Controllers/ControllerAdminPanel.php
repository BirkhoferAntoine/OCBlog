<?php


class ControllerAdminPanel
{

    //TODO CLEAN VARS!
    private $_view;
    private $_postsManager;
    private $_commentsManager;
    private $_post;
    private $_urlPost;
    private $_controllerIntegration;
    private $_viewIntegration;
    private $_postTitle = [];
    private $_postId;
    private $_postIdArray = [];
    private $_commentText = [];
    private $_commentId = [];
    private $_safeUri;
    private $_safeGet;
    private $_safePost;

    public function __construct()
    {
        $this->_setSecurity();
        $this->_securityCheck();
    }

    private function _setSecurity() {
        global $security;
        $this->_safeUri = array_slice($security->getFilteredUri(2), 0);
        $this->_safeGet = $security->getFilteredGet();
        $this->_safePost = $security->getFilteredPost();
    }

    private function _securityCheck() {
        if ($_SESSION['level'] === '1') {

            $this->_view = new ViewAdminPanel();
            echo $this->_panelBuild();

        }
    }

    private function _panelBuild() {

        if ($this->_safeGet['editor']) {

            if ($this->_safeGet['post'] === 'list') {
                $panelContent = $this->_listBuild();
                if ($this->_safeGet['editor'] === 'delete' && isset($this->_safeGet['submit'])) {
                    $this->_deletePost($this->_safeGet['submit']);
                }
            } elseif ($this->_safeGet['editor'] === 'edit' && $this->_safeGet['post'] !== 'list') {
                $panelContent = $this->_tinyMCEBuild('edit');
                if ($this->_safeGet['submit'] === 'true') {
                    $this->_editPost();
                }
            } elseif ($this->_safeGet['editor'] === 'new') {
                $panelContent = $this->_tinyMCEBuild('new');
                if ($this->_safeGet['submit'] === 'true') {
                    $this->_newPost();
                }
            }
        } elseif ($this->_safeGet['comments']) {
            if ($this->_safeGet['post'] === 'list') {
                $panelContent = $this->_listBuild();
            } elseif (isset($this->_safeGet['post'])) {
                $panelContent = $this->_setPost();
            } elseif ($this->_safeGet['comments'] === 'list') {
                if ($this->_safeGet['flag'] === 'true') {
                    $panelContent = $this->_commentsListBuild('9');
                } else {
                    $panelContent = $this->_commentsListBuild('0');
                }
            }
        } else {
            $panelContent = $this->_view->dashboard();
        }

        return $this->_view->mainBuild($panelContent);
    }

    private function _listBuild() {
       return $this->_view->listBuild();
    }

    private function _commentsListBuild($type)
    {
        $this->_commentsManager = new PostCommentsManager();
        $commentsList = $this->_commentsManager->getComments('`billet_id`', '`accepted` = ' . $type);

        return $this->_view->commentsListBuild($type);
    }
    private function _setPost($postPreview=null) {

        if (isset($this->_safeGet['post']) && $this->_safeGet['post'] !== 'list') {
            $this->_urlPost = $this->_safeGet['post'];

            $this->_controllerIntegration = new ControllerPost($this->_urlPost);

            $this->_post = $this->_controllerIntegration->getPost();
            $this->_viewIntegration = $this->_controllerIntegration->getView();

            if ($postPreview !== null) {
                return $this->_viewIntegration->generatePost(
                    array(
                        'Post' => $this->_post,
                        'preview' => $postPreview
                    )
                );
            } else {
                return $this->_viewIntegration->generatePost(array('Post' => $this->_post));
            }
        } else {
            throw new Exception(' Erreur 404 billet introuvable');
        }
    }

    private function _tinyMCEBuild($type)
    {
        if ($type === 'new') {

            $post = array(
                'postTitle' => strip_tags($this->_safePost['postTitle']),
                'postContent' => strip_tags($this->_safePost['postContent']),
                'postUrlImage' => $this->_safePost['postUrlImage']);
            $preview = $this->_view->cardBuilder(
                strip_tags($this->_safePost['postContent']),
                null,
                $this->_safePost['postUrlImage']);

            return $this->_view->tinyMCEBuild($preview, $post, $type);

        } elseif ($type === 'edit') {

            if (isset($this->_safePost['postContent'], $this->_safePost['postContent'], $this->_safePost['postId'])) {

                $post = array(
                    'postTitle' => strip_tags($this->_safePost['postTitle']),
                    'postContent' => strip_tags($this->_safePost['postContent']),
                    'postUrlImage' => $this->_safePost['postUrlImage'],
                    'postId' => $this->_safePost['postId']
                );
                $preview = $this->_setPost($post);
                $postData = $this->_post[0];
                $edit = $type . '&post=' . $postData->title();

            } else {

                $preview = $this->_setPost();
                $postData = $this->_post[0];
                $post = array(
                    'postTitle' => $postData->title(),
                    'postContent' => $postData->content(),
                    'postUrlImage' => $postData->image(),
                    'postId' => $postData->id()
                );
                $edit = $type . '&post=' . $postData->title();
            }

            return $this->_view->tinyMCEBuild($preview, $post, $edit);
        }

    }
    private function _markdownBuild()
    {

        include(ROOT_FOLDER . '/Vendor/assets/Markdown/Parsedown.php');
        $Parsedown = new Parsedown();
        $this->_parsedownText = $this->_safePost['markdown'];

        return $this->_view->markdownBuild();
    }

    private function _newPost() {
        $this->_postsManager = new PostsManager();

        $postTitle = $this->_safePost['postTitle'];
        $postContent = $this->_safePost['postContent'];
        $postUrlImage = $this->_safePost['postUrlImage'];

        $this->_postsManager->insertNewPost($postTitle, $postContent, $postUrlImage);
    }

    private function _editPost() {
        $this->_postsManager = new PostsManager();

        $postTitle = $this->_safePost['postTitle'];
        $postContent = $this->_safePost['postContent'];
        $postUrlImage = $this->_safePost['postUrlImage'];
        $postId = $this->_safePost['postId'];

        $this->_postsManager->editPost($postTitle, $postContent, $postUrlImage, $postId);

    }

    private function _deletePost($id)
    {
        $this->_postsManager = new PostsManager();
        $this->_postsManager->deletePost($id);
    }
}