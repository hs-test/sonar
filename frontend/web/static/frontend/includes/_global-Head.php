<?php
    $pageTitle = isset($pageTitle) ? $pageTitle : '';
//    $bodyClass = isset($bodyClass) ? $bodyClass : 'inner-pages';
?>

<!doctype html>
<html lang="en">
<!-- Begin Global Header -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?=$pageTitle?></title>
    <meta name="description" content="<?=$pageTitle?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Favicons and Device related Images
    ================================================== -->
    <link rel="shortcut icon" href="favicon/favicon.svg" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Stylesheet -->
    <link type="text/css" rel="stylesheet" href="static/css/vendors.css" />
    <link type="text/css" rel="stylesheet" href="static/css/default.css" media="screen" />
</head>

<!-- //End Global Header -->
<body class="body <?=$bodyClass?>">
<!-- Note: Some classes are adding in the body from JS so developer need to create a function in which page specific classes can be added on every page... -->