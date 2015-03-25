<?php

require_once('include_requireLogin.php');

require_once("connect.php");
require_once("common.php");

$titleid=$_GET['titleid'];

$query = 'select * from article where titleid=\'' . $titleid . '\'';
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

if($num_rows)
{
	$row=mysql_fetch_assoc($result);

	$issueDetails = getIssueDetails($row['volume'], $row['issue'], $row['year'], $row['month']);
	$featureDetails = getFeatures($row['featid']);

	$html = '
	<style>
	body, p, div { font-size: 14pt; font-family: freeserif;}
	h3 { font-size: 15pt; margin-bottom:0; font-family: sans-serif; }
	.heading{
		font-size: 40px;
		margin-bottom: 0;
		margin-top: 0px;
	}
	.sml{
		font-size: 20px;
	}
	.flow{
		float: right;
		width: 300px;
	}
	.logo{
		height: 100px;
	}
	.title{
		font-weight: bold;
		font-size: 24px;
	}
	.feature{
		font-weight: bold;
		font-size: 22px;
	}
	.author{
		font-size: 22px;
	}
	.issue{
		font-size: 20px;
	}
	.credit{
		font-size: 14px;
		font-family: sans-serif;
		color: #777;
		text-align: right;
		line-height: 1.75em;
	}
	a{
		text-decoration: none;
	}
	</style>

	<div style="text-align: left;">
		<img src="images/nt5.png" class="flow"/>
		<img src="images/logo.png" class="logo"/>
		<p class="heading">
			' . 'नटरंग' . '<br />
			<span class="sml">' . 'भारतीय रंगमंच का त्रैमासिक' . '</span>
		</p>
		<div>';
		
		$html .= '<p class="issue">' . $issueDetails . '</p>';
		$html .= '<p class="feature">' . $featureDetails . '</p>';
		$html .= '<p class="title">' . $row['title'] . '</p>';
		$html .= ($row['authorname']) ? '<p class="author">&#8212;' . $row['authorname'] . '</p>' : '';
	
	$html .= '</div>
	</div>
	<div>
		<p class="credit">
			<br />';

	date_default_timezone_set( 'Asia/Calcutta' );
	$html .= date('j') . '<sup>' . date('S') . '</sup>' . date(' F Y h:i A T');	
			// 12<sup>th</sup> March 2015 08:15 PM IST<br />
	
	$html .= '<br />This article is downloaded from Natarang archives (http://www.natarang.org/).<br />
			All rights reserved.
		</p>
	</div>';

	//==============================================================
	//==============================================================
	//==============================================================

	include("mpdf60/mpdf.php");

	$mpdf=new mPDF(''); 

	$mpdf->WriteHTML($html);

	$faceFilename = '../ReadWrite/facingSheet.pdf';
	$inFilename = '../Volumes/pdf/' . $row['issue'] . '/' . $row['page'] . '-' . $row['page_end'] .'.pdf';
	$outFilename = '../ReadWrite/' . time() . '-' . $row['issue'] . '-' . $row['page'] . '-' . $row['page_end'] . '.pdf';

	$mpdf->Output($faceFilename, 'F');

	system('pdftk ' . $faceFilename . ' ' . $inFilename . ' cat output ' . $outFilename);
	system('rm ' . $faceFilename);

	@header("Location: $outFilename");
	exit;

	//==============================================================
	//==============================================================

}
else
{
	@header("Location: ../index.html");	
}

?>
