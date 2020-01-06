<?php


class ControllerAdminPanel
{

    private $_view;
    private $_postsManager;
    private $_commentsManager;
    private $_postslist;
    private $_post;
    private $_urlPost;
    private $_controllerIntegration;
    private $_viewIntegration;
    private $_postTitle = [];
    private $_postId = [];
    private $_commentText = [];
    private $_commentId = [];
    private $_safeUri;
    private $_safeGet;
    private $_safePost;

    public function __construct()
    {
        $this->_setSecurity();
        $this->_securityCheck();
        var_dump($this->_safeGet);
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

        /*if ($this->_safeGet['post'] === 'list') {
            $this->_controllerIntegration = new ControllerHome(null);
        }*/

        if ($_GET['editor']) {

            if ($_GET['editor'] !== 'new' && $_GET['post'] === 'list') {
                $panelContent = $this->_listBuild();
            } elseif ($_GET['editor'] === 'edit' && $_GET['post'] !== 'list') {
                $panelContent = $this->_view->_tinyMCEBuild('edit');
            } elseif ($_GET['editor'] === 'new') {
                $panelContent = $this->_tinyMCEBuild('new');
                if ($this->_safeGet['submit']) {
                    $this->_insertNewPost();
                }
            }
        } elseif ($_GET['markdown']) {
            $panelContent = $this->_markdownBuild();
        } elseif ($_GET['comments']) {
            if ($_GET['post'] === 'list') {
                $panelContent = $this->_listBuild();
            } elseif (isset($_GET['post'])) {
                $panelContent = $this->_setPost();
            } elseif ($_GET['comments'] === 'list') {
                if ($_GET['flag'] === 'true') {
                    $panelContent = $this->_commentsListBuild('9');
                } else {
                    $panelContent = $this->_commentsListBuild('0');
                }
            }
        } elseif ($_GET['execution'] === 'board'){
            $panelContent = $this->_executionBoard();

        } else {
            $panelContent = $this->_view->dashboard();
        }

        return $this->_view->mainBuild($panelContent);
    }

    private function _executionBoard()
    {

        $this->_postsManager = new PostsManager();
        $this->_commentsManager = new PostCommentsManager();

        $posts = $this->_postsManager->getPosts('`id` DESC ', null);

        foreach ($posts['Post'] as $post) {
            $this->_postTitle .= $post->title();
            $this->_postId .= $post->id();
        }

        $comments = $this->_commentsManager->getComments('`id`', '`billet_id` = ' . $this->_postId);

        foreach ($comments['PostComments'] as $comment) {
            $this->_commentText .= $comment->content();
            $this->_commentId .= $comment->id();
        }
    }

    private function _commentsListBuild($type)
    {
        $this->_commentsManager = new PostCommentsManager();
        $commentsList = $this->_commentsManager->getComments('`billet_id`', '`accepted` = ' . $type);

        return $this->_view->commentsListBuild();
    }
    private function _setPost() {

        if (isset($_GET['post']) && $_GET['post'] !== 'list') {
            $this->_urlPost = $_GET['post'];

            $this->_controllerIntegration = new ControllerPost($this->_urlPost);

            $this->_post = $this->_controllerIntegration->getPost();
            $this->_viewIntegration = $this->_controllerIntegration->getView();

            //TODO MAKE IT WORK BITCH!
            if (!empty($_POST['postTitle'] && $_POST['postText'])) {
                return $this->_view->cardBuilder(strip_tags($_POST['postText']), null, $_POST['urlImage']);
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
            var_dump($this->_safePost);
            $preview = $this->_view->cardBuilder(strip_tags($this->_safePost['postContent']), null, $this->_safePost['postUrlImage']);
        } elseif ($type === 'edit') {
            $preview = $this->_setPost();
            $post = $this->_post[0];
        }

        return $this->_view->tinyMCEBuild($preview, $post);

    }
    private function _markdownBuild()
    {

        include(ROOT_FOLDER . '/Vendor/assets/Markdown/Parsedown.php');
        $Parsedown = new Parsedown();
        $this->_parsedownText = $_POST['markdown'];

        return $this->_view->markdownBuild();
    }

    private function _insertNewPost() {
        $this->_postsManager = new PostsManager();

    }
}