<?php
	session_start();
	$url ="";
	
	if(isset($_GET['issue']) && $_GET['issue'] != ''){$issue = $_GET['issue']; $url .= "&issue=".$issue;}
	if(isset($_GET['page']) && $_GET['page'] != ''){$page = $_GET['page']; $url .= "&pagenum=".$page;}
	if(isset($_GET['text']) && $_GET['text'] != ''){$text = $_GET['text']; $url .= "&searchText=".$text;}
	
	@header("Location: bookreader/templates/book.php?".$url);
?>
