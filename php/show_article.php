<?php

$issue = $_GET['issue'];
$titleid = $_GET['titleid'];
$page = $_GET['page'];

@header("Location:../Volumes/$issue/index.djvu?djvuopts&page=$page.djvu&zoom=page");

?>
