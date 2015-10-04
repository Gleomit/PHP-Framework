<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>EShop</title>
    <link href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/css/price-range.css" rel="stylesheet">
    <link href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/css/animate.css" rel="stylesheet">
    <link href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/css/main.css" rel="stylesheet">
    <link href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/js/html5shiv.js"></script>
    <script src="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?= \DF\Services\RouteService::$basePath . '/Content'; ?>/images/ico/apple-touch-icon-57-precomposed.png">
</head>
<body>

<?php if(\DF\Helpers\Session::get('userId') != null) require 'Views/partials/userNavbar.php'; ?>
<?php require 'Views/partials/shopNavigation.php'?>
