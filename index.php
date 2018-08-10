<?php
require 'MessageInterface.php';
require 'Message.php';
require 'DbConnection.php';
require 'MessageRepository.php';
require 'MessageFactory.php';
require 'Errors.php';
require 'Paginator.php';


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

</div>
</body>
</html>
