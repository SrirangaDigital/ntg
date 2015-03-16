<?php
	include("../../connect.php");
	$year = $_GET["year"];
	$month = $_GET["month"];
	$qtext = $_GET["q"];
	$stext  = $_GET["q"];
	$texts = '';
	$texts = preg_split("/ /", $qtext);
	$textFilter = "";
	for($ic=0;$ic<sizeof($texts);$ic++)
	{
		$textFilter .= $texts[$ic] . "* ";
	}
	$db = @new mysqli('localhost', "$user", "$password", "$database");
	$db->set_charset("utf8");
	$query = "SELECT * FROM searchtable WHERE MATCH (text) AGAINST ('$textFilter' IN BOOLEAN MODE) and cur_page NOT REGEXP '[a-z]' and year = '$year' and month = '$month'";
	
	$result = $db->query($query); 
	$num_rows = $result ? $result->num_rows : 0;
	for($a=1;$a<=$num_rows;$a++)
	{
		$row=$result->fetch_assoc();
		$query1 = "select * from word where match (word) AGAINST ('$textFilter' IN BOOLEAN MODE) and year = '".$year."' and month = '".$month."' and pagenum = '".$row["cur_page"]."'" ;
		$result1 = $db->query($query1);
		$num_rows1 = $result1->num_rows;
		$cord = array();
		$array = "";
		for($b = 0; $b < $num_rows1; $b++)
		{
			$row1=$result1->fetch_assoc();
			$cord[] = array("l" => $row1['l'],"b" => $row1["b"],"r" => $row1["r"],"t" => $row1["t"]);
			//~ $sumne = preg_split("/,/", $row1['cords']);
			//~ Base image size is 800X1200
			//~ Also note that coordinate has already been shifted to top left from bottom left (DjVu)
			//~ $sumne[0] = floor($sumne[0] * 800 / $row1['width']);
			//~ $sumne[2] = floor($sumne[2] * 800 / $row1['width']);
			//~ $sumne[1] = floor($sumne[1] * 1200 / $row1['height']);
			//~ $sumne[3] = floor($sumne[3] * 1200 / $row1['height']);

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
			
