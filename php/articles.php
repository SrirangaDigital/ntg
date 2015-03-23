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
			<img src="images/logo.png" alt="Natarang Logo" class="logo"/>
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
					<h2>लेख / Articles</h2>
					<div class="alphabet">
						<span class="letter"><a href="articles.php?letter=अ">अ</a></span>
						<span class="letter"><a href="articles.php?letter=आ">आ</a></span>
						<span class="letter"><a href="articles.php?letter=इ">इ</a></span>
						<span class="letter"><a href="articles.php?letter=ई">ई</a></span>
						<span class="letter"><a href="articles.php?letter=उ">उ</a></span>
						<span class="letter"><a href="articles.php?letter=ए">ए</a></span>
						<span class="letter"><a href="articles.php?letter=ऐ">ऐ</a></span>
						<span class="letter"><a href="articles.php?letter=ओ">ओ</a></span>
						<span class="letter"><a href="articles.php?letter=औ">औ</a></span>
						<span class="letter"><a href="articles.php?letter=क">क</a></span>
						<span class="letter"><a href="articles.php?letter=ख">ख</a></span>
						<span class="letter"><a href="articles.php?letter=ग">ग</a></span>
						<span class="letter"><a href="articles.php?letter=घ">घ</a></span>
						<span class="letter"><a href="articles.php?letter=च">च</a></span>
						<span class="letter"><a href="articles.php?letter=छ">छ</a></span>
						<span class="letter"><a href="articles.php?letter=ज">ज</a></span>
						<span class="letter"><a href="articles.php?letter=झ">झ</a></span>
						<span class="letter"><a href="articles.php?letter=ट">ट</a></span>
						<span class="letter"><a href="articles.php?letter=ठ">ठ</a></span>
						<span class="letter"><a href="articles.php?letter=ड">ड</a></span><br />
						<span class="letter"><a href="articles.php?letter=त">त</a></span>
						<span class="letter"><a href="articles.php?letter=थ">थ</a></span>
						<span class="letter"><a href="articles.php?letter=द">द</a></span>
						<span class="letter"><a href="articles.php?letter=ध">ध</a></span>
						<span class="letter"><a href="articles.php?letter=न">न</a></span>
						<span class="letter"><a href="articles.php?letter=प">प</a></span>
						<span class="letter"><a href="articles.php?letter=फ">फ</a></span>
						<span class="letter"><a href="articles.php?letter=ब">ब</a></span>
						<span class="letter"><a href="articles.php?letter=भ">भ</a></span>
						<span class="letter"><a href="articles.php?letter=म">म</a></span>
						<span class="letter"><a href="articles.php?letter=य">य</a></span>
						<span class="letter"><a href="articles.php?letter=र">र</a></span>
						<span class="letter"><a href="articles.php?letter=ल">ल</a></span>
						<span class="letter"><a href="articles.php?letter=व">व</a></span>
						<span class="letter"><a href="articles.php?letter=श">श</a></span>
						<span class="letter"><a href="articles.php?letter=ष">ष</a></span>
						<span class="letter"><a href="articles.php?letter=स">स</a></span>
						<span class="letter"><a href="articles.php?letter=ह">ह</a></span>
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

$query = "select * from article where title like '$letter%' order by title, volume, issue, page";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=mysql_fetch_assoc($result);

		$titleid=$row['titleid'];
		$title=$row['title'];
		$featid=$row['featid'];
		$page=$row['page'];
		$authid=$row['authid'];
		$volume=$row['volume'];
		$issue=$row['issue'];
		$year=$row['year'];
		$month=$row['month'];
		
		$title1=addslashes($title);
		
		echo "<li>";
		echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"show_article.php?issue=$issue&amp;titleid=$titleid&amp;page=$page\">$title</a></span>";
		printFeature($featid, "hin", "");
		echo "<br />";
		echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"show_article.php?issue=$issue&amp;titleid=$titleid&amp;page=$page\">" . uiConvertText($title) . "</a></span>";
		printFeature($featid, "eng", "");
		
		printAuthor($authid, "hin", "");
		printAuthor($authid, "eng", "");
		echo "<br /><span class=\"sleft yearspan\"><a href=\"toc.php?vol=$volume&amp;issue=$issue\">".get_ymvi($volume, $issue, $year, $month)."</a></span>";
		echo " &nbsp;<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;issue=$issue\">(".get_ymvi_eng($volume, $issue, $year, $month).")</a></span>";
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
				<li><a class="active" href="articles.php">लेख</a></li>
				<li><a href="authors.php">लेखक</a></li>
				<li><a href="features.php">श्रेणी / विषय</a></li>
				<li><a href="search.php">खोज</a></li>
			</ul>
			<ul class="nav_eng" style="float: right;">
				<li><a href="../index.html">Home</a></li>
				<li><a href="volumes.php">Issue</a></li>
				<li><a class="active" href="articles.php">Articles</a></li>
				<li><a href="authors.php">Authors</a></li>
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
