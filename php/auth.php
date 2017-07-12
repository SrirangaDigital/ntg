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
<?php

require_once("connect.php");
require_once("common.php");

$authid=$_GET['authid'];
$authorname=$_GET['author'];

echo "<h2>$authorname / " . uiConvertText($authorname) . "</h2>";
echo "<ul class=\"gap_above\">";

$query = "select * from article where authid like '%$authid%' order by volume, issue, page";
$result = $mysqli->query($query);

$num_rows = $result->num_rows;

if($num_rows)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row=$result->fetch_assoc();

		$titleid=$row['titleid'];
		$title=$row['title'];
		$featid=$row['featid'];
		$page=$row['page'];
		$volume=$row['volume'];
		$issue=$row['issue'];
		$year=$row['year'];
		$month=$row['month'];
		
		$title1=addslashes($title);
		
		echo "<li>";
		echo "<span class=\"titlespan\"><a href=\"readBook.php?issue=$issue&amp;page=$page\" title=\"Read Online\" target=\"_blank\">$title</a></span>";
		printFeature($featid, "hin", "");
		echo "<br />";
		echo "<span class=\"titlespan\"><a href=\"readBook.php?issue=$issue&amp;page=$page\" title=\"Read Online\" target=\"_blank\">" . uiConvertText($title) . "</a></span>";
		printFeature($featid, "eng", "");
		
		echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;issue=$issue\">".get_ymvi($volume, $issue, $year, $month)."</a></span>";
		echo " &nbsp;<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;issue=$issue\">(".get_ymvi_eng($volume, $issue, $year, $month).")</a></span>";
		echo "<br /><span class=\"downloadspan\"><a target=\"_blank\" href=\"downloadPDF.php?titleid=$titleid\">Download PDF</a></span>";
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
