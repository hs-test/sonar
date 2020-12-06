<?php
    $pageTitle = isset($pageTitle) ? $pageTitle : '';
    $bodyClass = isset($bodyClass) ? $bodyClass : '';
?>

<!doctype html>
<html class="no-js">
<!-- Begin Global Header -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?=$pageTitle?></title>
    <meta name="description" content="<?=$pageTitle?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Favicons and Device related Images
    ================================================== -->
    <link rel="shortcut icon" href="favicon/favicon.png" />
    <link rel="icon" href="favicon/favicon.svg" sizes="any" type="image/svg+xml" />
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="favicon/apple-touch-icon-144x144.png" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- Stylesheet -->
    <link type="text/css" rel="stylesheet" href="dist/css/vendor.css" />
    <link type="text/css" rel="stylesheet" href="dist/css/default.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="dist/css/prettify.css" />
</head>

<!-- //End Global Header -->
<body class="<?=$bodyClass?>">
<!-- Note: Some classes are adding in the body from JS so developer need to create a function in which page specific classes can be added on every page... -->