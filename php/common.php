<?php

function printFeature($featid, $lang, $hlight)
{
	if($featid != "")
	{
		$featids = preg_split('/;/',$featid);

		$fl = 0;
		foreach ($featids as $fid)
		{
			$query3 = "select feat_name from feature where featid='$fid'";
			$result3 = mysql_query($query3);		
			$row3=mysql_fetch_assoc($result3);
			$feature=$row3['feat_name'];

			$feature_link = $feature;
			$feature_link = preg_replace("/ /", "%20", $feature_link);
							
			if($fl == 0)
			{
				$flink = $feature;
				if($lang == "eng"){$flink = uiConvertText($feature);}
				else
				{
					if($fid == $hlight)
					{
						$flink = "<span class=\"highlight\">$flink</span>";
					}
				}
				echo "<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><span class=\"featurespan\"><a href=\"feat.php?feature=$feature_link&amp;featid=$fid\">$flink</a></span>";
				$fl = 1;
			}
			else
			{
				$flink = $feature;
				if($lang == "eng"){$flink = uiConvertText($feature);}
				else
				{
					if($fid == $hlight)
					{
						$flink = "<span class=\"highlight\">$flink</span>";
					}
				}
				echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"featurespan\"><a href=\"feat.php?feature=$feature_link&amp;featid=$fid\">$flink</a></span>";
			}
		}
	}
}

function printAuthor($authid, $lang, $hlight)
{
	if($hlight == '')
	{
		$authorWords = '';
	}
	else
	{
		$authorWords = preg_split("/ /", $hlight);
	}

	if($authid != 0)
	{

		if($lang == "hin"){echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;";}
		else{echo "&nbsp; <span class=\"eaut\">";}
		$aut = preg_split('/;/',$authid);

		$fl = 0;
		foreach ($aut as $aid)
		{
			$query2 = "select * from author where authid=$aid";
			$result2 = mysql_query($query2);

			$num_rows2 = mysql_num_rows($result2);

			if($num_rows2)
			{
				$row2=mysql_fetch_assoc($result2);

				$authorname=$row2['authorname'];
			
				$authorname_link = $authorname;
				$authorname_link = preg_replace("/ /", "%20", $authorname_link);
				
				if($fl == 0)
				{
					$alink = $authorname;
					if($lang == "eng")
					{
						$alink = uiConvertText($authorname);
					}
					else
					{
						if($authorWords != '')
						{
							foreach($authorWords as $aw)
							{
								if($aw != ''){$alink = preg_replace("/($aw)/u","<span class=\"highlight\">$1</span>", $alink);}
							}						
						}
					}
					echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$aid&amp;author=$authorname_link\">$alink</a></span>";
					$fl = 1;
				}
				else
				{
					$alink = $authorname;
					if($lang == "eng")
					{
						$alink = uiConvertText($authorname);
					}
					else
					{
						if($authorWords != '')
						{
							foreach($authorWords as $aw)
							{
								if($aw != ''){$alink = preg_replace("/($aw)/u","<span class=\"highlight\">$1</span>", $alink);}
							}						
						}
					}
					echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"auth.php?authid=$aid&amp;author=$authorname_link\">$alink</a></span>";
				}
			}

		}			
		if($lang != "hin"){echo "</span>";}
	}
}

function engtohin_issue($eng)
{
	if(intval($eng) == 0)
	{
		return "";
	}
	$hin = $eng;

	$hin = preg_replace("/0/", "०", $hin);
	$hin = preg_replace("/1/", "१", $hin);
	$hin = preg_replace("/2/", "२", $hin);
	$hin = preg_replace("/3/", "३", $hin);
	$hin = preg_replace("/4/", "४", $hin);
	$hin = preg_replace("/5/", "५", $hin);
	$hin = preg_replace("/6/", "६", $hin);
	$hin = preg_replace("/7/", "७", $hin);
	$hin = preg_replace("/8/", "८", $hin);
	$hin = preg_replace("/9/", "९", $hin);
	
	$hin = preg_replace("/^०/", "", $hin);
	$hin = preg_replace("/^०/", "", $hin);
	$hin = preg_replace("/\-०/", "-", $hin);
	$hin = preg_replace("/\-०/", "-", $hin);
	
	return $hin;
}

function engtohin_month($eng)
{
	if(intval($eng) == 0)
	{
		return "";
	}
	
	$hin = $eng;
	
	$hin = preg_replace("/00/", "", $hin);
	$hin = preg_replace("/01/", "जनवरी", $hin);
	$hin = preg_replace("/02/", "फ़रवरी", $hin);
	$hin = preg_replace("/03/", "मार्च", $hin);
	$hin = preg_replace("/04/", "अप्रैल", $hin);
	$hin = preg_replace("/05/", "मई", $hin);
	$hin = preg_replace("/06/", "जून", $hin);
	$hin = preg_replace("/07/", "जुलाई", $hin);
	$hin = preg_replace("/08/", "अगस्त", $hin);
	$hin = preg_replace("/09/", "सितम्बर", $hin);
	$hin = preg_replace("/10/", "अक्टूबर", $hin);
	$hin = preg_replace("/11/", "नवम्बर", $hin);
	$hin = preg_replace("/12/", "दिसम्बर", $hin);
	
	return $hin;
}

function eng_month($eng)
{
	if(intval($eng) == 0)
	{
		return "";
	}
	$eng = preg_replace("/00/", "", $eng);
	$eng = preg_replace("/01/", "Jan", $eng);
	$eng = preg_replace("/02/", "Feb", $eng);
	$eng = preg_replace("/03/", "Mar", $eng);
	$eng = preg_replace("/04/", "Apr", $eng);
	$eng = preg_replace("/05/", "May", $eng);
	$eng = preg_replace("/06/", "Jun", $eng);
	$eng = preg_replace("/07/", "Jul", $eng);
	$eng = preg_replace("/08/", "Aug", $eng);
	$eng = preg_replace("/09/", "Sep", $eng);
	$eng = preg_replace("/10/", "Oct", $eng);
	$eng = preg_replace("/11/", "Nov", $eng);
	$eng = preg_replace("/12/", "Dec", $eng);
	
	$eng = preg_replace("/\-/", " - ", $eng);

	return $eng;
}

function get_ymvi($volume, $issue, $year, $month)
{
	$ymvi = '';
	$ymvi = $ymvi . "वर्ष ".engtohin_issue($volume);
	$ymvi = $ymvi . " अंक ".engtohin_issue($issue);
	
	if(($month != "00") || ($year != "00"))
	{
		$ymvi = $ymvi . ", ".engtohin_month($month)." ".engtohin_issue($year);
	}
	$ymvi = preg_replace("/  /", " ", $ymvi);
	return $ymvi;
}
function get_ymvi_eng($volume, $issue, $year, $month)
{
	$month_name = array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

	$ymvi = '';
	$ymvi = $ymvi . "Vol. " . intval($volume);
	$ymvi = $ymvi . " No. ". intval($issue);
	
	if(($month != "00") || ($year != "00"))
	{
		$ymvi = $ymvi . ", ".eng_month($month) . " " . intval($year);
	}
	$ymvi = preg_replace("/  /", " ", $ymvi);
	return $ymvi;
}

function uiConvertText($text)
{
	$text = preProcessText($text);
	$chars = preg_split('/(?<!^)(?!$)/u', $text);
	$etext = '';
	foreach($chars as $c)
	{
		$etext .= uiConvertChar($c);
	}
	$etext .= " ";
	$etext = preg_replace("/a\.(a|ā|i|ī|u|ū|r̥|r̥̄|e|ai|o|au|āṅ)/", "$1$2", $etext);
	$etext = preg_replace("/\.(ṁ|ḥ|ṅ|ñ|ṇ|n|m)/", "$1", $etext);
	$etext = preg_replace("/a\.zzz/", "", $etext);
	$etext = preg_replace("/a([ [:punct:]])/", "$1", $etext);

	$etext = preg_replace("/ṁ(k|g)/", "ṅ$1", $etext);
	$etext = preg_replace("/ṁ(c|j)/", "ñ$1", $etext);
	$etext = preg_replace("/ṁ(ṭ|ḍ)/", "ṇ$1", $etext);
	$etext = preg_replace("/ṁ(t|d)/", "n$1", $etext);
	$etext = preg_replace("/ṁ(p|b)/", "m$1", $etext);
	
	$etext = preg_replace("/(ā|i|ī|e|ai|o|au)ṁ /", "$1ṅ ", $etext);
	$etext = preg_replace("/(ā|i|ī|e|ai|o|au)ṁ$/", "$1ṅ", $etext);
	$etext = preg_replace("/\s$/", "", $etext);
	$etext = schwaDeletion($etext);

	return($etext);
}
function uiConvertChar($char)
{
	switch($char)
	{
		case "अ" : return("a");
		case "आ" : return("ā");
		case "इ" : return("i");
		case "ई" : return("ī");
		case "उ" : return("u");
		case "ऊ" : return("ū");
		case "ऋ" : return("r̥");
		case "ॠ" : return("r̥̄");
		case "ए" : return("e");
		case "ऐ" : return("ai");
		case "ओ" : return("o");
		case "औ" : return("au");
		case "क" : return("ka");
		case "ख" : return("kha");
		case "ग" : return("ga");
		case "घ" : return("gha");
		case "ङ" : return("ṅa");
		case "च" : return("ca");
		case "छ" : return("cha");
		case "ज" : return("ja");
		case "झ" : return("jha");
		case "ञ" : return("ña");
		case "ट" : return("ṭa");
		case "ठ" : return("ṭha");
		case "ड" : return("ḍa");
		case "ढ" : return("ḍha");
		case "ण" : return("ṇa");
		case "त" : return("ta");
		case "थ" : return("tha");
		case "द" : return("da");
		case "ध" : return("dha");
		case "न" : return("na");
		case "प" : return("pa");
		case "फ" : return("pha");
		case "ब" : return("ba");
		case "भ" : return("bha");
		case "म" : return("ma");
		case "य" : return("ya");
		case "र" : return("ra");
		case "ल" : return("la");
		case "व" : return("va");
		case "श" : return("śa");
		case "ष" : return("ṣa");
		case "स" : return("sa");
		case "ह" : return("ha");
		case "ा" : return(".ā");
		case "ि" : return(".i");
		case "ी" : return(".ī");
		case "ु" : return(".u");
		case "ू" : return(".ū");
		case "ृ" : return(".r̥");
		case "ॄ" : return(".r̥̄");
		case "े" : return(".e");
		case "ै" : return(".ai");
		case "ो" : return(".o");
		case "ौ" : return(".au");
		case "ँ" : return(".ṅ");
		case "ॉ" : return(".āṅ");
		case "ं" : return(".ṁ");
		case "ः" : return(".ḥ");
		case "्" : return(".zzz");
		case "क़" : return("qa");
		case "ख़" : return("ḳha");
		case "ग़" : return("g͟ha");
		case "ड़" : return("ṛa");
		case "ढ़" : return("ṛha");
		case "फ़" : return("fa");
		case "ज़" : return("za");
		case "०" : return("0");
		case "१" : return("1");
		case "२" : return("2");
		case "३" : return("3");
		case "४" : return("4");
		case "५" : return("5");
		case "६" : return("6");
		case "७" : return("7");
		case "८" : return("8");
		case "९" : return("9");
		
		default : return($char);
	}
}

function schwaDeletion($text)
{
	
	$vyanjana = "k|kh|g|gh|ṅ|c|ch|j|jh|ñ|ṭ|ṭh|ḍ|ḍh|ṇ|t|th|d|dh|n|p|ph|b|bh|m|y|r|l|v|ś|ṣ|s|h|q|ḳh|g͟h|ṛ|ṛh|f|z";
	$anunasika = "ṅ|ñ|ṇ|n|m";
	$swara = "a|ā|i|ī|u|ū|r̥|r̥̄|e|ai|o|au";
	
	$text = preg_replace("/($swara|$anunasika|r)($vyanjana)a($vyanjana)($swara)/", "$1$2$3$4", $text);
	return($text);
}

function preProcessText($text)
{
	$text = preg_replace("/डॉ\./", "Dr.", $text);
	return($text);
}
function VerifyCredentials($lemail, $lpassword)
{
	session_start();
	include("connect.php");
	
	$salt = "shankara";
	$lpassword = sha1($salt.$lpassword);

	$query_l2 = "select count(*) from details where email='$lemail' and password='$lpassword'";
	$result_l2 = mysql_query($query_l2);
	$row_l2=mysql_fetch_assoc($result_l2);
	$num=$row_l2['count(*)'];
	if($num > 0)
	{
		$query_l3 = "update details set visitcount=visitcount+1 where email='$lemail'";
		$result_l3 = mysql_query($query_l3);
		
		$_SESSION['email'] = $lemail;
		$_SESSION['valid'] = 1;
		
        @header("Location: volumes.php");
		exit;
	}
	else
	{
		@header("Location: login.php?error=3");
		exit;
	}
}
function hasResetExpired($reset)
{
  	include("connect.php");
	
	$query_l2 = "select *,count(*) from reset where hash='$reset'";
	$result_l2 = mysql_query($query_l2);
	$row_l2=mysql_fetch_assoc($result_l2);
	$num=$row_l2['count(*)'];
	if ($num == 0)
    {
        return True;
    }
    else
    {
        $tstamp=$row_l2['timestamp'];
        $cstamp = time();
        if(floor(($cstamp - $tstamp) / 3600) > 24)
        {
            $query = "DELETE from reset where timestamp<='$tstamp'";
            $result = mysql_query($query);            
            return True;
        }
        else
        {
            return False;
        }
    }
}

?>
