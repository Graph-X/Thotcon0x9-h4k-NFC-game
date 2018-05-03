<?php
if ($_POST)
{
	$handle = $_POST['h'];
	$pid = $_POST['pid'];
	include ('dbconnect.php');
	$query = "UPDATE players SET handle='" . $handle . "' where pid='".$pid."'";
	if ($r = $mysqli->query($query))
	{
		echo("OK");
	}
	else
	{
		echo($myqli->error);
	}
	
}
 