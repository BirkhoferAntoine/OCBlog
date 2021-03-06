<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Blog Ecrivain">
    <meta name="keywords" content="Openclassrooms Blog Ecrivain Jean Forteroche">
    <meta name="author" content="Antoine Birkhofer">
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">
    <link rel="stylesheet" href="../Vendor/wireframe.css">
    <link rel="stylesheet" href="../Public/css/style.css">

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#postContent',
            plugins: 'autolink code link preview',
            toolbar: 'code link preview',
            menubar: 'tools insert view'
        });</script>

    <script defer src="https://kit.fontawesome.com/e1049b5881.js" crossorigin="anonymous"></script>
    <script defer src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" style=""></script>
    <script defer src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>

    <title>ADMIN PANEL</title>

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show pace-done aside-menu-lg-show">
<div class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show   pace-done pace-done">
    <header class="app-header navbar p-0">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#" style="">
            <span class="fa d-inline fa-lg fa-circle"></span>
            <b> BRAND</b>
        </a>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="<?= URL ?>"><i class="nav-icon fas fa-home"></i> <b>Retour au site</b></a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="<?= URL . 'User/Panel'?>">Dashboard</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Settings</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="icon fa fa-bell"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                    <div class="dropdown-header text-center">
                        <strong>You have 5 notifications</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="icon-user-follow text-success"></i> New user registered</a>
                    <a class="dropdown-item" href="#">
                        <i class="icon-user-unfollow text-danger"></i> User deleted</a>
                    <a class="dropdown-item" href="#">
                        <i class="icon-chart text-info"></i> Sales report is ready</a>
                    <a class="dropdown-item" href="#">
                        <i class="icon-basket-loaded text-primary"></i> New client</a>
                    <a class="dropdown-item" href="#">
                        <i class="icon-speedometer text-warning"></i> Server overloaded</a>
                    <div class="dropdown-header text-center">
                        <strong>Server</strong>
                    </div>
                    <a class="dropdown-item text-center" href="#">
                        <strong>View all tasks</strong>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown d-md-down-none">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="icon fa fa-envelope"></i>
                    <span class="badge badge-pill badge-info">7</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                    <div class="dropdown-header text-center">
                        <strong>You have 4 messages</strong>
                    </div>
                    <a>
                        <strong>View all messages</strong>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="img-avatar" src="../../Vendor/assets/styleguide/people_5.jpg">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Account</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-bell-o"></i> Updates
                        <span class="badge badge-info">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-envelope-o"></i> Messages
                        <span class="badge badge-success">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-tasks"></i> Tasks
                        <span class="badge badge-danger">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-comments"></i> Comments
                        <span class="badge badge-warning">42</span>
                    </a>
                    <div class="dropdown-header text-center">
                        <strong>Settings</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-user"></i> Profile</a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-wrench"></i> Settings</a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-usd"></i> Payments
                        <span class="badge badge-dark">42</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-file"></i> Projects
                        <span class="badge badge-primary">42</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-shield"></i> Lock Account</a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>
    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav ps ps--active-y">
                <ul class="nav">
                    <li class="nav-divider"></li>
                    <li class="nav-title">Gestion des billets</li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-feather-alt"></i> <b>Edition</b></a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?markdown=true">
                                    <i class="nav-icon fa fa-code"></i> Markdown
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?editor=new">
                                    <i class="nav-icon far fa-file"></i> Nouveau billet
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?editor=edit&post=list">
                                    <i class="nav-icon far fa-edit"></i> Editer un billet
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?editor=delete&post=list">
                                    <i class="nav-icon far fa-trash-alt"></i> Supprimer un billet
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i> <b>Moderation</b></a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?execution=board">
                                    <i class="nav-icon fas fa-chalkboard-teacher"></i> Tableau d'execution
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?comments=true&post=list">
                                    <i class="nav-icon far fa-comments"></i> Commentaires billet
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?comments=list">
                                    <i class="nav-icon far fa-comment"></i> Approuver
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?comments=edit&post=list">
                                    <i class="nav-icon far fa-comment-dots"></i> Editer
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Panel?comments=list&flag=true">
                                    <i class="nav-icon fas fa-comment-slash"></i> Signalements
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-title">Gestion du site</li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-bell"></i> <b>Notifications</b></a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="notifications/alerts.html">
                                    <i class="nav-icon icon-bell"></i> Alerts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notifications/badge.html">
                                    <i class="nav-icon icon-bell"></i> Badge</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notifications/modals.html">
                                    <i class="nav-icon icon-bell"></i> Modals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notifications/toastr.html">
                                    <i class="nav-icon icon-bell"></i> Toastr
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-chalkboard"></i> <b>Pages</b></a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="login.html" target="_top">
                                    <i class="nav-icon icon-star"></i> Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.html" target="_top">
                                    <i class="nav-icon icon-star"></i> Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="404.html" target="_top">
                                    <i class="nav-icon icon-star"></i> Error 404</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="500.html" target="_top">
                                    <i class="nav-icon icon-star"></i> Error 500</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fa fa-envelope"></i> <b>Emails</b></a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="apps/email/inbox.html">
                                    <i class="nav-icon icon-speech"></i> Inbox
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="apps/email/message.html">
                                    <i class="nav-icon icon-speech"></i> Messages
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="apps/email/compose.html">
                                    <i class="nav-icon icon-speech"></i> Composer
                                </a>
                            </li>
                        </ul>
                    </li>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-title">Labels</li>
                    <li class="nav-item d-compact-none d-minimized-none">
                        <a class="nav-label" href="#">
                            <i class="fa fa-circle text-danger"></i> Label danger</a>
                    </li>
                    <li class="nav-item d-compact-none d-minimized-none">
                        <a class="nav-label" href="#">
                            <i class="fa fa-circle text-info"></i> Label info</a>
                    </li>
                    <li class="nav-item d-compact-none d-minimized-none">
                        <a class="nav-label" href="#">
                            <i class="fa fa-circle text-warning"></i> Label warning</a>
                    </li>
                    <li class="nav-divider"></li>
                </ul>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 833px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 584px;"></div></div>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
        <main class="main">

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= URL ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Admin</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="<?= URL . 'User/Panel'?>">Dashboard</a>
                </li>
            </ol>
            <?php echo $prePanel_panelContent ?>
        </main>
        <aside class="aside-menu">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">
                        <i class="icon-list"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                        <i class="icon-speech"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                        <i class="icon-settings"></i>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="timeline" role="tabpanel">
                    <div class="list-group list-group-accent">
                        <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Today</div>
                        <div class="list-group-item list-group-item-accent-warning list-group-item-divider">
                            <div class="avatar float-right">
                                IMAGE ICI
                            </div>
                            <div>Meeting with
                                <strong>Lucas</strong>
                            </div>
                            <small class="text-muted mr-3">
                                <i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                            <small class="text-muted">
                                <i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
                        </div>
                        <div class="list-group-item list-group-item-accent-info">
                            <div class="avatar float-right">
                                IMAGE ICI
                            </div>
                            <div>Skype with
                                <strong>Megan</strong>
                            </div>
                            <small class="text-muted mr-3">
                                <i class="icon-calendar"></i>&nbsp; 4 - 5pm</small>
                            <small class="text-muted">
                                <i class="icon-social-skype"></i>&nbsp; On-line</small>
                        </div>
                        <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Tomorrow</div>
                        <div class="list-group-item list-group-item-accent-danger list-group-item-divider">
                            <div>New UI Project -
                                <strong>deadline</strong>
                            </div>
                            <small class="text-muted mr-3">
                                <i class="icon-calendar"></i>&nbsp; 10 - 11pm</small>
                            <small class="text-muted">
                                <i class="icon-home"></i>&nbsp; creativeLabs HQ</small>
                            <div class="avatars-stack mt-2">
                                IMAGE ICI
                            </div>
                        </div>
                        <div class="list-group-item list-group-item-accent-success list-group-item-divider">
                            <div>
                                <strong>#10 Startups.Garden</strong> Meetup</div>
                            <small class="text-muted mr-3">
                                <i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                            <small class="text-muted">
                                <i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
                        </div>
                        <div class="list-group-item list-group-item-accent-primary list-group-item-divider">
                            <div>
                                <strong>Team meeting</strong>
                            </div>
                            <small class="text-muted mr-3">
                                <i class="icon-calendar"></i>&nbsp; 4 - 6pm</small>
                            <small class="text-muted">
                                <i class="icon-home"></i>&nbsp; creativeLabs HQ</small>
                            <div class="avatars-stack mt-2">
                                IMAGE ICI
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane p-3" id="messages" role="tabpanel">
                    <div class="message">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                IMAGE ICI
                                <span class="avatar-status badge-success"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">Lukasz Holeczek</small>
                            <small class="text-muted float-right mt-1">1:52 PM</small>
                        </div>
                        <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                        <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                    </div>
                    <hr>
                    <div class="message">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                IMAGE ICI
                                <span class="avatar-status badge-success"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">Lukasz Holeczek</small>
                            <small class="text-muted float-right mt-1">1:52 PM</small>
                        </div>
                        <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                        <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                    </div>
                    <hr>
                    <div class="message">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                IMAGE ICI
                                <span class="avatar-status badge-success"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">Lukasz Holeczek</small>
                            <small class="text-muted float-right mt-1">1:52 PM</small>
                        </div>
                        <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                        <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                    </div>
                    <hr>
                    <div class="message">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">
                                IMAGE ICI
                                <span class="avatar-status badge-success"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">Lukasz Holeczek</small>
                            <small class="text-muted float-right mt-1">1:52 PM</small>
                        </div>
                        <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                        <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                    </div>
                    <hr>
                    <div class="message">
                        <div class="py-3 pb-5 mr-3 float-left">
                            <div class="avatar">IMAGE ICI
                                <span class="avatar-status badge-success"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">Lukasz Holeczek</small>
                            <small class="text-muted float-right mt-1">1:52 PM</small>
                        </div>
                        <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                        <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                    </div>
                </div>
                <div class="tab-pane p-3" id="settings" role="tabpanel">
                    <h6>Settings</h6>
                    <div class="aside-options">
                        <div class="clearfix mt-4">
                            <small>
                                <b>Option 1</b>
                            </small>
                            <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                                <input class="switch-input" type="checkbox" checked="">
                                <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                        </div>
                        <div>
                            <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                        </div>
                    </div>
                    <div class="aside-options">
                        <div class="clearfix mt-3">
                            <small>
                                <b>Option 2</b>
                            </small>
                            <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                                <input class="switch-input" type="checkbox">
                                <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                        </div>
                        <div>
                            <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                        </div>
                    </div>
                    <div class="aside-options">
                        <div class="clearfix mt-3">
                            <small>
                                <b>Option 3</b>
                            </small>
                            <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                                <input class="switch-input" type="checkbox">
                                <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                        </div>
                    </div>
                    <div class="aside-options">
                        <div class="clearfix mt-3">
                            <small>
                                <b>Option 4</b>
                            </small>
                            <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                                <input class="switch-input" type="checkbox" checked="">
                                <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </aside>
    </div>
</div>
<footer class="app-footer justify-content-center">
    <p class="text-center">Réalisé sur base de template CoreUI</p>
</footer>

</body>

</html>

