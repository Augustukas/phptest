<?php
require 'Message.php';

// Start the session
session_start();
$messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
//var_dump($_SESSION);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Žinutės</title>
    <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css"/>
</head>
<body>


<div id="wrapper">

    <h1>Jūsų žinutės</h1>
    <?php include 'MessageForm.php' ?>

    <?php include 'MessageList.php' ?>

    <p id="pages">
        <a href="#" title="atgal">atgal</a>
        <a href="#" title="1">1</a>
        2
        <a href="#" title="3">3</a>
        <a href="#" title="4">4</a>
        <a href="#" title="toliau">toliau</a>
    </p>
</div>
</body>
</html>