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
<?php

require_once("connect.php");
require_once("common.php");

$db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
$rs = mysql_select_db($database,$db) or die("No Database");
$author=$_POST['author'];
$title=$_POST['title'];
$year1=$_POST['year1'];
$year2=$_POST['year2'];
$featid=$_POST['featid'];

$author = preg_replace("/[\t]+/", " ", $author);
$author = preg_replace("/[ ]+/", " ", $author);
$author = preg_replace("/^ /", "", $author);
$title = preg_replace("/ $/", "", $title);

$title = preg_replace("/[\t]+/", " ", $title);
$title = preg_replace("/[ ]+/", " ", $title);
$title = preg_replace("/^ /", "", $title);
$title = preg_replace("/ $/", "", $title);

$etitle = $title;
$eauthor = $author;
$efeatid = $featid;

if($featid=='')
{
	$featid='.*';
}
if($year1=='')
{
	$year1='1965';
}
if($year2=='')
{
	$year2=date('Y');
}

if($year2 < $year1)
{
	$tmp = $year1;
	$year1 = $year2;
	$year2 = $tmp;
}

if($title == '')
{
	$titleFilter = " WHERE title REGEXP '.*'";
	$titleWords = '';
}
else
{
	$titleWords = preg_split("/ /", $title);
	$titleFilter = " WHERE";
	foreach($titleWords as $tw)
	{
		if($tw != ''){$titleFilter .= " and title REGEXP '$tw'";}
	}
	$titleFilter = preg_replace("/WHERE and/", "WHERE", $titleFilter);
}

if($author == '')
{
	$authorFilter = " WHERE authorname REGEXP '.*'";
	$authorWords = '';
}
else
{
	$authorWords = preg_split("/ /", $author);
	$authorFilter = " WHERE";
	foreach($authorWords as $aw)
	{
		if($aw != ''){$authorFilter .= " and authorname REGEXP '$aw'";}
	}
	$authorFilter = preg_replace("/WHERE and/", "WHERE", $authorFilter);
}

$query="SELECT * FROM
				(SELECT * FROM
					(SELECT * FROM
						(SELECT * FROM article $authorFilter) AS tb1
					$titleFilter) AS tb2
				WHERE featid REGEXP '$featid') AS tb3
			WHERE year between $year1 and $year2 ORDER BY volume, issue, page";

$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

if($num_rows > 0)
{
	echo "<h2>खोज परिणाम / Search Results</h2>";
	echo "<p class=\"authorspan flright\" style=\"margin-right: 25%;\">".engtohin_issue($num_rows)." परिणाम</p>";
	echo "<ul class=\"gap_above\">";
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
		
		$dtitle = $title;
		if($titleWords != '')
		{
			foreach($titleWords as $tw)
			{
				$dtitle = preg_replace("/($tw)/u","<span class=\"highlight\">$1</span>", $dtitle);
			}
		}
		
		echo "<li>";
		echo "<span class=\"titlespan\"><a href=\"bookReader.php?issue=$issue&amp;titleid=$titleid&amp;page=$page\">$dtitle</a></span>";
		printFeature($featid, "hin", $efeatid);
		echo "<br />";
		echo "<span class=\"titlespan\"><a href=\"bookReader.php?issue=$issue&amp;titleid=$titleid&amp;page=$page\">" . uiConvertText($title) . "</a></span>";
		printFeature($featid, "eng", $efeatid);
		
		printAuthor($authid, "hin", $eauthor);
		printAuthor($authid, "eng", $eauthor);
		echo "<br /><span class=\"sleft yearspan\"><a href=\"toc.php?vol=$volume&amp;issue=$issue\">".get_ymvi($volume, $issue, $year, $month)."</a></span>";
		echo " &nbsp;<span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;issue=$issue\">(".get_ymvi_eng($volume, $issue, $year, $month).")</a></span>";
		echo "</li>\n";
	}
}
else
{
	echo "<h2>खोज परिणाम / Search Results</h2>";
	echo "<ul class=\"gap_above\">";
	echo"<li><span class=\"titlespan\">कोईं परिणाम नहीं मिला</span><br />";
	echo"<span class=\"authorspan\"><a href=\"search.php\">फिर से कोशिश कीजियें</a></span></li>";
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
				<li><a href="authors.php">लेखक</a></li>
				<li><a href="features.php">श्रेणी / विषय</a></li>
				<li><a class="active" href="search.php">खोज</a></li>
			</ul>
			<ul class="nav_eng" style="float: right;">
				<li><a href="../index.html">Home</a></li>
				<li><a href="volumes.php">Issue</a></li>
				<li><a href="articles.php">Articles</a></li>
				<li><a href="authors.php">Authors</a></li>
				<li><a href="features.php" title="Category / Subject">Category</a></li>
				<li><a class="active" href="search.php">Search</a></li>
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
			&copy; २०१४, नटरंग प्रतिष्ठान
		</p>
		<p style="float: right;">
			Natarang Pratishthan<br />
			706, Sumeru Apartments<br />
			Near EDM mall, Kaushambi<br />
			Ghaziabad, Uttar Pradesh 201 010<br />
			INDIA.<br /><br />
			&copy; 2014, Natarang Pratishthan
		</p>
	</div>
</div>
</body>

</html>
