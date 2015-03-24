<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Natarang</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/indexstyle.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/sticky.js"></script>
</head>

<body>
<div class="page">
	<div class="header">		
		<div class="flow">
			<img src="images/nt3.png" alt="" />
		</div>		
		<div class="sa">
			<a href="../index.html"><img src="images/logo.png" alt="Natarang Logo" class="logo"/></a>
		</div>
		<div class="title">
			<p>नटरंग</p>
			<p class="sml">भारतीय रंगमंच का त्रैमासिक</p>
		</div>
	</div>
	<div class="mainpage">
		<div class="widget12">
			<div class="col2 largeSpace">
				<div class="issue_holder">
					<div class="col1 colL largeSpace">
						<div class="section right" id="sec11">&nbsp;</div>
					</div>
					<h2>लेखक / Authors</h2>
					<div class="alphabet">
						<span class="letter"><a href="authors.php?letter=अ">अ</a></span>
						<span class="letter"><a href="authors.php?letter=आ">आ</a></span>
						<span class="letter"><a href="authors.php?letter=इ">इ</a></span>
						<span class="letter"><a href="authors.php?letter=ई">ई</a></span>
						<span class="letter"><a href="authors.php?letter=उ">उ</a></span>
						<span class="letter"><a href="authors.php?letter=ए">ए</a></span>
						<span class="letter"><a href="authors.php?letter=ऐ">ऐ</a></span>
						<span class="letter"><a href="authors.php?letter=ओ">ओ</a></span>
						<span class="letter"><a href="authors.php?letter=क">क</a></span>
						<span class="letter"><a href="authors.php?letter=ख">ख</a></span>
						<span class="letter"><a href="authors.php?letter=ग">ग</a></span>
						<span class="letter"><a href="authors.php?letter=घ">घ</a></span>
						<span class="letter"><a href="authors.php?letter=च">च</a></span>
						<span class="letter"><a href="authors.php?letter=ज">ज</a></span>
						<span class="letter"><a href="authors.php?letter=ट">ट</a></span>
						<span class="letter"><a href="authors.php?letter=ठ">ठ</a></span>
						<span class="letter"><a href="authors.php?letter=ड">ड</a></span><br />
						<span class="letter"><a href="authors.php?letter=त">त</a></span>
						<span class="letter"><a href="authors.php?letter=थ">थ</a></span>
						<span class="letter"><a href="authors.php?letter=द">द</a></span>
						<span class="letter"><a href="authors.php?letter=ध">ध</a></span>
						<span class="letter"><a href="authors.php?letter=न">न</a></span>
						<span class="letter"><a href="authors.php?letter=प">प</a></span>
						<span class="letter"><a href="authors.php?letter=फ">फ</a></span>
						<span class="letter"><a href="authors.php?letter=ब">ब</a></span>
						<span class="letter"><a href="authors.php?letter=भ">भ</a></span>
						<span class="letter"><a href="authors.php?letter=म">म</a></span>
						<span class="letter"><a href="authors.php?letter=य">य</a></span>
						<span class="letter"><a href="authors.php?letter=र">र</a></span>
						<span class="letter"><a href="authors.php?letter=ल">ल</a></span>
						<span class="letter"><a href="authors.php?letter=व">व</a></span>
						<span class="letter"><a href="authors.php?letter=श">श</a></span>
						<span class="letter"><a href="authors.php?letter=स">स</a></span>
						<span class="letter"><a href="authors.php?letter=ह">ह</a></span>
					</div>
					<ul>
<?php

require_once("connect.php");
require_once("common.php");

if(isset($_GET['letter']))
{
	$letter=$_GET['letter'];
}
else
{
	$letter = 'अ';
}

$query = "select * from author where authorname like '$letter%' order by authorname";
$result = mysql_query($query);

$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$authid=$row['authid'];
		$authorname=$row['authorname'];
		
		$authorname_link = $authorname;
		$authorname_link = preg_replace("/ /", "%20", $authorname_link);

		echo "<li class=\"less_gap\">";
		echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$authid&amp;author=$authorname_link\">$authorname</a></span>";
		echo "</li>\n";
	}
}

?>
					</ul>
			</div>
			</div>
		</div>
		<div class="nav sticky">
			<ul class="nav_hin" style="float: left;">
				<li><a href="../index.html">मुख पृष्ठ</a></li>
				<li><a href="volumes.php">अंक</a></li>
				<li><a href="articles.php">लेख</a></li>
				<li><a class="active" href="authors.php">लेखक</a></li>
				<li><a href="features.php">श्रेणी / विषय</a></li>
				<li><a href="search.php">खोज</a></li>
			</ul>
			<ul class="nav_eng" style="float: right;">
				<li><a href="../index.html">Home</a></li>
				<li><a href="volumes.php">Issue</a></li>
				<li><a href="articles.php">Articles</a></li>
				<li><a class="active" href="authors.php">Authors</a></li>
				<li><a href="features.php" title="Category / Subject">Category</a></li>
				<li><a href="search.php">Search</a></li>
			</ul>
		</div>
	</div>
	<div class="footer_inside">
		<p style="float: left;">
			नटरंग प्रतिष्ठान<br />
			७०६, सुमॆरु अपार्टमेंट<br />
			इ डि एम् माल के समीप, कौशाम्बि<br />
			ग़ाज़ियाबाद, उत्तर प्रदेश २०१ ०१०<br />
			भारत.<br /><br />
			&copy; २०१५, नटरंग प्रतिष्ठान
		</p>
		<p style="float: right;">
			Natarang Pratishthan<br />
			706, Sumeru Apartments<br />
			Near EDM mall, Kaushambi<br />
			Ghaziabad, Uttar Pradesh 201 010<br />
			INDIA.<br /><br />
			&copy; 2015, Natarang Pratishthan
		</p>
	</div>
</div>
</body>

</html>
