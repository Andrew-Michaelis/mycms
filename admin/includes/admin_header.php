<?php include_once "../includes/db.php" ?>
<?php include "functions.php" ?>
<?php ob_start(); session_start(); ?>
<?php
    if(!isset($_SESSION["role"])){
        header("Location: ../index.php", true);
    }else{
        if($_SESSION["role"] !== "Admin"){
            header("Location: ../index.php", true);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- JQuery Core -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="css/plugins/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/plugins/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- WYSIWYG summernote -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> -->
    <link href="css/summernote.css" rel="stylesheet">

    <!-- Google Chart Making Support -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="css/styles.css" rel="stylesheet">

</head>

<body>