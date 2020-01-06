<?php


class AdminPanel {

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

    public function __construct()
    {
      echo $this->_panelBuild();
    }

    use CardTemplate {
        cardBuilder as protected;
    }

    private function _mainBuild($insert)
    {
        $prePanel_panelContent = $insert;


        ob_start();

        // Inclut le fichier View
        require(ROOT_FOLDER . '/Views/Templates/adminTemplate.php');

        return ob_get_clean();
    }

    private function _panelBuild() {

        if ($_GET['editor']) {
            if ($_GET['editor'] !== 'new' && $_GET['post'] === 'list') {
                $panelContent = $this->_listBuild();
            } elseif ($_GET['editor'] === 'edit' && $_GET['post'] !== 'list') {
                $panelContent = $this->_tinyMCEBuild('edit');
            } elseif ($_GET['editor'] === 'new') {
                $panelContent = $this->_tinyMCEBuild('new');
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
            $panelContent = $this->_dashboard();
        }

        return $this->_mainBuild($panelContent);
    }

    private function _executionBoard() {

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


        ob_start();
        ?>

        <div class="container-fluid">
            <div id="ui-view">
                <div class="animated fadeIn">
                    <div class="card"><div class="card">
                            <div class="card-header">Tableau d'execution</div>
                            <div class="card-body">
                                <form class="w-100" id="executeForm" method="post" action="">
                                    <fieldset id="executeBoard">

                                        <legend>Supprimer de la base de données...</legend>

                                    <div class="form-group"> Billet... <br/>
                                        <select class="form-control">

                                            <?php foreach ($this->_postTitle as $postTitle):?>
                                                <option name="billet" value="<?= $postTitle ?>"><?= $postTitle ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>

                                        <div class="form-group"> Commentaire... <br/>
                                            <select class="form-control">

                                                <?php foreach ($this->_commentText as $commentText):?>
                                                    <option name="commentaire" value="<?= $commentText ?>"><?= $commentText ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>

                                    <div class="form-group text-center">
                                        <input type="submit" class="align-self-center justify-content-center w-50 text-center">
                                    </div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();

    }

    private function _listBuild() {

        if ((isset($_GET['editor']) || isset($_GET['comments'])) && $_GET['post'] === 'list') {

        ob_start();
        ?>

        <div class="container-fluid">
            <div id="ui-view">
                <div class="animated fadeIn">
                    <div class="card">
                        <?php  $this->_controllerIntegration = new ControllerHome(null); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();
        }
    }

    private function _commentsListBuild($type) {
        $this->_commentsManager = new PostCommentsManager();
        $commentsList = $this->_commentsManager->getComments('`billet_id`', '`accepted` = ' . $type);


        ob_start();
        ?>

        <div class="container-fluid">
            <div id="ui-view">
                <div class="animated fadeIn">
                    <div class="card">
                        <?php new CommentsTemplate($commentsList); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();

    }

    private function _setPost() {

        if (isset($_GET['post']) && $_GET['post'] !== 'list') {
            $this->_urlPost = $_GET['post'];

            $this->_controllerIntegration = new ControllerPost($this->_urlPost);

            $this->_post = $this->_controllerIntegration->getPost();
            $this->_viewIntegration = $this->_controllerIntegration->getView();

            //TODO MAKE IT WORK BITCH!
            if (!empty($_POST['postTitle'] && $_POST['postText'])) {
                return $this->cardBuilder(strip_tags($_POST['postText']), null, $_POST['urlImage']);
            } else {
                return $this->_viewIntegration->generatePost(array('Post' => $this->_post));
            }
        } else {
            throw new Exception(' Erreur 404 billet introuvable');
        }
    }

    private function _tinyMCEBuild($type) {

        if ($type === 'new') {
            $preview = $this->cardBuilder(strip_tags($_POST['postContent']), null, $_POST['urlImage']);
            $postText = '';
        } elseif ($type === 'edit') {
            $preview = $this->_setPost();
            $post = $this->_post[0];
            $postTitle = $post->title();
            $postText = $post->content();
            $postImage = $post->image();
        }

        ob_start();
        ?>
        <div class="container-fluid">
            <div id="ui-view"><div>

                    <div class="animated fadeIn">
                        <div class="card">
                            <div class="card-header">Nouveau Billet</div>
                            <div class="card-body">
                                <form class="w-100" method="post" action="">

                                    <div class="form-group">
                                    <label for="postTitle">Titre</label>
                                    <input type="text" class="form-control" id="postTitle" name="postTitle" value="<?= $postTitle ?>" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="postContent">Contenu du billet</label>
                                    <textarea class="form-control" id="postContent" name="postContent"><?= $postText ?></textarea>
                                    </div>

                                    <div class="form-group">
                                    <label for="urlImage">Insérer une image</label>
                                    <input type="url" class="form-control" id="urlImage" name="urlImage" placeholder="Entrez l'url de l'image" value="<?= $postImage ?>">
                                    </div>

                                    <div class="form-group text-center">
                                    <input type="submit" class="align-self-center justify-content-center w-50 text-center">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="animated fadeIn">
                        <div class="card">
                            <div class="card-header">Aperçu</div>
                            <div class="card-body">
                                <div id="tinyPreview">
                                    <?php print_r($preview)?>
                                </div>
                            </div>
                            <form method="post" action="">
                                <div class="form-group text-center">
                                <input type="submit" class="align-self-center justify-content-center w-50 text-center">
                                </div>
                            </form>
                        </div>
                    </div></div></div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function _markdownBuild() {

        include(ROOT_FOLDER . '/Vendor/assets/Markdown/Parsedown.php');
        $Parsedown = new Parsedown();
        $this->_parsedownText = $_POST['markdown'];


        ob_start();
        ?>
        <div class="container-fluid">
            <div id="ui-view"><div>

                    <div class="animated fadeIn">
                        <div class="card">
                            <div class="card-header">Markdown</div>
                            <div class="card-body">
                                <form method="post">
                                    <label for="markdown">Nouveau Billet</label>
                                    <textarea id="markdown" name="markdown">Ca marche!</textarea>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="animated fadeIn">
                        <div class="card">
                            <div class="card-header">Textdown</div>
                            <div class="card-body">
                                <form method="post">
                                    <label for="textdown">Result</label>
                                    <p id="textdown" name="textdown"><?php echo $Parsedown->text($this->_parsedownText); ?></p>
                                </form>
                            </div>
                        </div>
                    </div></div></div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function _dashboard() {

        ob_start();
        ?>
        <div class="container-fluid">
            <div id="ui-view"><div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h4 class="card-title mb-0">Traffic</h4>
                                    <div class="small text-muted">November 2017</div>
                                </div>

                                <div class="col-sm-7 d-none d-md-block">
                                    <button class="btn btn-primary float-right" type="button">
                                        <i class="icon-cloud-download"></i>
                                    </button>
                                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                                        <label class="btn btn-outline-secondary">
                                            <input id="option1" type="radio" name="options" autocomplete="off"> Day
                                        </label>
                                        <label class="btn btn-outline-secondary active">
                                            <input id="option2" type="radio" name="options" autocomplete="off" checked=""> Month
                                        </label>
                                        <label class="btn btn-outline-secondary">
                                            <input id="option3" type="radio" name="options" autocomplete="off"> Year
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="chart-wrapper" style="height:300px;margin-top:40px;"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <canvas class="chart chartjs-render-monitor" id="main-chart" height="300" width="968" style="display: block; width: 968px; height: 300px;"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center">
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Visits</div>
                                    <strong>29.703 Users (40%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Unique</div>
                                    <strong>24.093 Users (20%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Nouvelles inscriptions</div>
                                    <strong>22.123 Utilisateurs (80%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                    <div class="text-muted">Utilisateurs réguliers</div>
                                    <strong>40.15%</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="brand-card">
                                <div class="brand-card-header bg-facebook">
                                    <i class="fa fa-facebook"></i>
                                    <div class="chart-wrapper"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="social-box-chart-1" height="96" width="228" class="chartjs-render-monitor" style="display: block; width: 228px; height: 96px;"></canvas>
                                    </div>
                                </div>
                                <div class="brand-card-body">
                                    <div>
                                        <div class="text-value">89k</div>
                                        <div class="text-uppercase text-muted small">friends</div>
                                    </div>
                                    <div>
                                        <div class="text-value">459</div>
                                        <div class="text-uppercase text-muted small">feeds</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="brand-card">
                                <div class="brand-card-header bg-twitter">
                                    <i class="fa fa-twitter"></i>
                                    <div class="chart-wrapper"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="social-box-chart-2" height="96" width="228" class="chartjs-render-monitor" style="display: block; width: 228px; height: 96px;"></canvas>
                                    </div>
                                </div>
                                <div class="brand-card-body">
                                    <div>
                                        <div class="text-value">973k</div>
                                        <div class="text-uppercase text-muted small">followers</div>
                                    </div>
                                    <div>
                                        <div class="text-value">1.792</div>
                                        <div class="text-uppercase text-muted small">tweets</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="brand-card">
                                <div class="brand-card-header bg-linkedin">
                                    <i class="fa fa-linkedin"></i>
                                    <div class="chart-wrapper"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="social-box-chart-3" height="96" width="228" class="chartjs-render-monitor" style="display: block; width: 228px; height: 96px;"></canvas>
                                    </div>
                                </div>
                                <div class="brand-card-body">
                                    <div>
                                        <div class="text-value">500+</div>
                                        <div class="text-uppercase text-muted small">contacts</div>
                                    </div>
                                    <div>
                                        <div class="text-value">292</div>
                                        <div class="text-uppercase text-muted small">feeds</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="brand-card">
                                <div class="brand-card-header bg-google-plus">
                                    <i class="fa fa-google-plus"></i>
                                    <div class="chart-wrapper"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="social-box-chart-4" height="96" width="228" class="chartjs-render-monitor" style="display: block; width: 228px; height: 96px;"></canvas>
                                    </div>
                                </div>
                                <div class="brand-card-body">
                                    <div>
                                        <div class="text-value">894</div>
                                        <div class="text-uppercase text-muted small">followers</div>
                                    </div>
                                    <div>
                                        <div class="text-value">92</div>
                                        <div class="text-uppercase text-muted small">circles</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <br>
                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th class="text-center">
                                        <i class="icon-people"></i>
                                    </th>
                                    <th>User</th>
                                    <th>Usage</th>
                                    <th>Activity</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center">
                                        <div class="avatar">
                                            IMAGE ICI
                                            <span class="avatar-status badge-success"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>Yiorgos Avraamu</div>
                                        <div class="small text-muted">
                                            <span>New</span> | Registered: Jan 1, 2015</div>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-left">
                                                <strong>50%</strong>
                                            </div>
                                            <div class="float-right">
                                                <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                            </div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small text-muted">Last login</div>
                                        <strong>10 sec ago</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="avatar">
                                            IMAGE ICI
                                            <span class="avatar-status badge-danger"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>Avram Tarasios</div>
                                        <div class="small text-muted">
                                            <span>Recurring</span> | Registered: Jan 1, 2015</div>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <div class="float-left">
                                                <strong>10%</strong>
                                            </div>
                                            <div class="float-right">
                                                <small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small>
                                            </div>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small text-muted">Last login</div>
                                        <strong>5 minutes ago</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php
        return ob_get_clean();

    }
}