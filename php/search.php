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
<script type="text/javascript" src="js/devanagari_kbd.js" charset="UTF-8"></script>
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
<?php include("keyboard.php"); ?>
					<div class="archive_search">
					<form method="post" action="search-result.php">
						<table>
							<tr>
								<td class="left"><span class="authorspan">लेखक</span></td>
								<td class="right"><input name="author" type="text" class="titlespan wide_input" id="textfield1" onfocus="SetId('textfield1')"/></td>
							</tr>
							<tr>
								<td class="left"><span class="authorspan">लेख</span></td>
								<td class="right"><input name="title" type="text" class="titlespan wide_input" id="textfield2" onfocus="SetId('textfield2')"/></td>
							</tr>
							<tr>
								<td class="left"><span class="authorspan">श्रेणी / विषय</span></td>
								<td class="right">
									<select name="featid" class="titlespan wide_input1">
										<option value=""></option>
		<?php

require_once("connect.php");
require_once("common.php");

$query1 = "select * from feature order by feat_name";
$result1 = $mysqli->query($query1);

$num_rows1 = $result1->num_rows;

if($num_rows1)
{
	for($i=1;$i<=$num_rows1;$i++)
	{
		$row1=$result1->fetch_assoc();

		$feature=$row1['feat_name'];
		$featid=$row1['featid'];
		//echo "$feature";
		
		if ($feature == '')
		{
			$feature = '&nbsp;';
		}
		echo "<option value=\"$featid\">$feature</option>";
	}
}

?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="left"><span class="authorspan">शब्दः</span></td>
								<td class="right"><input name="text" type="text" class="titlespan wide_input" id="textfield3" onfocus="SetId('textfield3')"/></td>
							</tr>
							<tr>
								<td class="left"><span class="authorspan">वर्ष</span></td>
								<td class="right"><select name="year1" class="titlespan">
										<option value="">&nbsp;</option>
<?php

$query = "select distinct year from article order by year";
$result = $mysqli->query($query);

$num_rows = $result->num_rows;

if($num_rows)
{
for($i=1;$i<=$num_rows;$i++)
{
	$row=$result->fetch_assoc();

	$year=$row['year'];
	echo "<option value=\"$year\">".engtohin_issue($year)."</option>";
}
}

?>
									</select>
									<span class="titlespan" >&nbsp;से&nbsp;</span>
									<select name="year2" class="titlespan">
										<option value="">&nbsp;</option>

<?php
$result = $mysqli->query($query);

$num_rows = $result->num_rows;

if($num_rows)
{
for($i=1;$i<=$num_rows;$i++)
{
	$row=$result->fetch_assoc();

	$year=$row['year'];
	echo "<option value=\"$year\">".engtohin_issue($year)."</option>";
}
}

?>
									</select>
									<span class="titlespan" >&nbsp;तक्</span>
								</td>
							</tr>
							<tr>
								<td class="left">&nbsp;</td>
								<td class="right">
									<input name="button1" type="submit" class="titlespan button" id="button" value="खोजें"/>
									<input name="button2" type="reset" class="titlespan button" id="button_reset" value="रीसेट करें"/>
								</td>
							</tr>
						</table>
					</form>
					</div>
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
