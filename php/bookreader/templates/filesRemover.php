<?php
	$jpg = 'find ../../../Volumes/jpg/1/ +mmin 10 -type f -name "*.jpg" -exec rm {} \;';
	exec($jpg);
	$tif = 'find ../../../Volumes/tif/ +mmin 10 -type f -name "*.tif" -exec rm {} \;';
	exec($tif);
?>
