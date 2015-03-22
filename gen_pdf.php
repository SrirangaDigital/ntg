<?php

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
	<img src="php/images/nt5.png" class="flow"/>
	<img src="php/images/logo.png" class="logo"/>
	<p class="heading">
		' . htmlentities('नटरंग') . '<br />
		<span class="sml">' . htmlentities('भारतीय रंगमंच का त्रैमासिक') . '</span>
	</p>
	<div>
		<p class="issue">' . htmlentities('अप्रैल-सितम्बर १९६९ (वर्ष ३ अंक १०-११)') . '</p>
		<p class="feature">' . htmlentities('नाटक/प्रदर्शन') . '</p>
		<p class="title">' . htmlentities('मिट्टी की गाड़ी का रंगमंच : एक रंग-अनुभूति') . '</p>
		<p class="author">&#8212;' . htmlentities('लक्ष्मी नारायण लाल') . '</p>
	</div>
</div>
<div>
	<p class="credit">
		<br />
		12<sup>th</sup> March 2015 08:15 PM IST<br />
		This article is downloaded from Natarang archives (http://www.natarag.org/).<br />
		All rights reserved.
	</p>
</div>
';
//==============================================================
//==============================================================
//==============================================================

include("mpdf60/mpdf.php");

$mpdf=new mPDF(''); 

$mpdf->WriteHTML($html);

$mpdf->Output();
exit;
//==============================================================
//==============================================================


?>