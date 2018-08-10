<?php

use MessagingBoard\MessageRepository;
use MessagingBoard\Paginator;

$rep = new MessageRepository();
$paginator = new Paginator($rep);
echo $paginator->createLinks(3, 'pages')
?>
<p id="pages">
    <a href="#" title="atgal">atgal</a>
    <a href="#" title="1">1</a>
    2
    <a href="#" title="3">3</a>
    <a href="#" title="4">4</a>
    <a href="#" title="toliau">toliau</a>
</p>