<?php


/**
 * Class ControllerAdminPanel
 */
class ControllerAdminPanel
{
    private $_view;
    private $_postsManager;
    private $_commentsManager;
    private $_post;
    private $_urlPost;
    private $_controllerIntegration;
    private $_viewIntegration;
    private $_safeUri;
    private $_safeGet;
    private $_safePost;

    /**
     * ControllerAdminPanel constructor.
     */
    public function __construct()
    {
        $this->_setSecurity();
        $this->_securityCheck();
    }

    /**
     *  Appel de la global $security et récupération des données filtrées
     *  @return void
     */
    private function _setSecurity() {
        global $security;
        $this->_safeUri = $security->getFilteredUri(2);
        $this->_safeGet = $security->getFilteredGet();
        $this->_safePost = $security->getFilteredPost();
    }

    /**
     *  Vérification du token administrateur
     */
    private function _securityCheck() {
        if ($_SESSION['level'] === '1') {

            $this->_view = new ViewAdminPanel();
            echo $this->_panelBuild();

        }
    }

    /**
     * @return mixed
     */
    private function _panelBuild() {

        if ($this->_safeGet['editor']) {
            $panelContent = $this->_editorPanel();
        } elseif ($this->_safeGet['comments']) {
            $panelContent = $this->_commentsPanel();
        } else {
            $panelContent = $this->_view->dashboard();
        }

        return $this->_view->mainBuild($panelContent);
    }

    /**
     * @return mixed
     */
    private function _editorPanel() {

        $this->_postsManager = new PostsManager();
        if (isset($this->_safeGet['submit']) && $this->_safeGet['submit'] !== 'preview') {
            $this->_submitPostOrder();
        } else {

            if ($this->_safeGet['post'] === 'list') {
                $panelContent = $this->_listBuild();

            } elseif ($this->_safeGet['editor'] === 'edit' && $this->_safeGet['post'] !== 'list') {
                $panelContent = $this->_tinyMCEBuild('edit');

            } elseif ($this->_safeGet['editor'] === 'new') {
                $panelContent = $this->_tinyMCEBuild('new');
            }
            return $panelContent;
        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function _commentsPanel() {

        $this->_commentsManager = new PostCommentsManager();
        if ($this->_safeGet['submit'] === 'true') {
            $this->_submitCommentOrder();
        }

        if ($this->_safeGet['post'] === 'list') {
            $panelContent = $this->_listBuild();

        } elseif (isset($this->_safeGet['post'])) {
            $panelContent = $this->_setPost();

        } elseif ($this->_safeGet['comments'] === 'list') {

            if ($this->_safeGet['flag'] === 'true') {
                $panelContent = $this->_commentsListBuild('1');
            } else {
                $panelContent = $this->_commentsListBuild('0');
            }
        }
        return $panelContent;
    }

    /**
     * @return mixed
     */
    private function _listBuild() {
       return $this->_view->listBuild();
    }

    /**
     * @param $type
     * @return mixed
     */
    private function _commentsListBuild($type) {

        $commentsList = $this->_commentsManager->getComments('`billet_id`', '`accepted` = ' . $type);
        return $this->_view->commentsListBuild($type, $commentsList);

    }

    /**
     * @param null $postPreview
     * @return mixed
     * @throws Exception
     */
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

    /**
     * @param $type
     * @return mixed
     * @throws Exception
     */
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

            $this->_safeGet['submit'] === 'preview' ? $token = true : $token = false;

            return $this->_view->tinyMCEBuild($preview, $post, $type, $token);

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

            $this->_safeGet['submit'] === 'preview' ? $token = true : $token = false;

            return $this->_view->tinyMCEBuild($preview, $post, $edit, $token);
        }

    }

    /**
     * @return mixed
     */
    private function _markdownBuild()
    {

        include(ROOT_FOLDER . '/Vendor/assets/Markdown/Parsedown.php');
        $Parsedown = new Parsedown();
        $this->_parsedownText = $this->_safePost['markdown'];

        return $this->_view->markdownBuild();
    }

    /**
     *
     */
    private function _newPost() {

        $postTitle = $this->_safePost['postTitle'];
        $postContent = $this->_safePost['postContent'];
        $postUrlImage = $this->_safePost['postUrlImage'];

        $this->_postsManager->insertNewPost($postTitle, $postContent, $postUrlImage);
    }

    /**
     *
     */
    private function _editPost() {

        $postTitle = $this->_safePost['postTitle'];
        $postContent = $this->_safePost['postContent'];
        $postUrlImage = $this->_safePost['postUrlImage'];
        $postId = $this->_safePost['postId'];

        $this->_postsManager->editPost($postTitle, $postContent, $postUrlImage, $postId);

    }

    /**
     * @param $id
     */
    private function _deletePost($id)
    {
        $this->_postsManager->deletePost($id);
    }

    /**
     *
     */
    private function _submitPostOrder()
    {
        if ($this->_safeGet['editor'] === 'delete' && isset($this->_safeGet['submit'])) {

            $this->_deletePost($this->_safeGet['submit']);

        } elseif ($this->_safeGet['editor'] === 'edit' && $this->_safeGet['post'] !== 'list' && $this->_safeGet['submit'] === 'true') {

            $this->_editPost();

        } elseif ($this->_safeGet['editor'] === 'new' && $this->_safeGet['submit'] === 'true') {

            $this->_newPost();
        }

        $this->_redirect();
    }

    /**
     *
     */
    private function _submitCommentOrder() {

        if ($this->_safePost['accept']) {

            $this->_commentsManager->acceptComment($this->_safePost['accept']);

        } elseif ($this->_safePost['delete']) {

            $this->_commentsManager->deleteComment($this->_safePost['delete']);
        }

        $this->_redirect();
    }

    /**
     *
     */
    private function _redirect() {

        if ($this->_safeGet['editor'] === 'edit' && $this->_safeGet['post'] !== 'list' && $this->_safeGet['submit'] === 'true') {
            $submitExplode = explode('&post=', $this->_safeUri);
            $redirectUri = $submitExplode[0] . '&post=list';
        } else {
            $submitExplode = explode('&submit=', $this->_safeUri);
            $redirectUri = $submitExplode[0];
        }

        $redirection = URL . 'User/' . $redirectUri;

        require_once(ROOT_FOLDER . '/Views/Templates/redirect.php');

    }
}