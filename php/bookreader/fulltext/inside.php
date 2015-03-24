<?php
	include("../../connect.php");
	$issue = $_GET["issue"];
	$qtext = $_GET["q"];
	$stext  = $_GET["q"];
	$texts = '';
	$texts = preg_split("/ /", $qtext);
	$textFilter = "";
	for($ic=0;$ic<sizeof($texts);$ic++)
	{
		$textFilter .= $texts[$ic] . "* ";
	}
	$query = "SELECT * FROM searchtable WHERE MATCH (text) AGAINST ('$textFilter' IN BOOLEAN MODE) and cur_page NOT REGEXP '[a-z]' and issue = '$issue'";
	$result = mysql_query($query); 
	$num_rows = $result ? mysql_num_rows($result) : 0;
	for($a=1;$a<=$num_rows;$a++)
	{
		$row = mysql_fetch_assoc($result);
		$query1 = "select * from word where match (word) AGAINST ('$textFilter' IN BOOLEAN MODE) and issue = '".$issue."' and pagenum = '".$row["cur_page"]."'" ;
		$result1 = mysql_query($query1);
		$num_rows1 = mysql_num_rows($result1);
		$cord = array();
		$array = "";
		for($b = 0; $b < $num_rows1; $b++)
		{
			$row1=mysql_fetch_assoc($result1);
			$cord[] = array("l" => $row1['l'],"b" => $row1["b"],"r" => $row1["r"],"t" => $row1["t"]);
		}
		$row1["text"] = "Text Found in";
		$qtext = "Text";
		$row1["text"] = preg_replace("/Text/" , "{{{".$qtext."}}}" , $row1["text"]);
		$array["text"] = $row1["text"];
		$array["par"][] = array( "page" => $row1["pagenum"] , "boxes" => $cord);
		$sd["matches"][] = $array;
	}
	echo json_encode($sd);
?>
			
