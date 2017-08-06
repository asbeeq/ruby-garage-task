<?php

/**
 * @var $template
 */

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/script.js" type="text/javascript"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="/css/style.css" rel="stylesheet" type="text/css"/>
    <title><?= $this->pageTitle ?></title>
</head>
<body>

<header>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Task List</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

                <ul class="nav navbar-nav navbar-right">
                    <?php if (\Model\User::isLogin()) : ?>
                        <li class="navbar-text">Hello, <?= $_SESSION['user_login'] ?></li>
                        <li><a href="/logout">Log Out</a></li>
                    <?php else : ?>
                        <li><a href="/register">Register</a></li>
                        <li><a href="/login">Log In</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="container">
    <?php if (\Libs\Message::hasMessages() > 0) : ?>
        <?php foreach (\Libs\Message::getMessages() as $message) : ?>
            <div class="alert alert-<?= $message['type'] ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?= $message['text'] ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php include TEMPLATE_PATH . $template; ?>
</main>
</body>
</html>