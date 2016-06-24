<?php
date_default_timezone_set('australia/melbourne');

if(isset($_GET['GUID']) && isset($_GET['RequestType']) && isset($_GET['Value']))
{
		$ID = urldecode($_GET['GUID']);
		$RequestType = urldecode($_GET['RequestType']);
		$Value = urldecode($_GET['Value']);
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

		$server 	="localhost";
		$db		="WestProjectionsData";
		$user	="MobileUser";
		$pwd	="MobileProjection";
		
	 	$sql = "INSERT INTO `UserInput`( `IP_Posted`, `RequestType`, `Value`) VALUES ('" 
	 		. $ip . "','" . $RequestType . "','" .  $Value . "')";
		

		echo $sql;

		$conn = new mysqli($server, $user, $pwd, $db);
		$result = $conn->query($sql);
		$conn->close();

		echo $result;
		echo "Sussed";
}
else 
{
	header("HTTP/1.0 400 Bad Request");
	echo "Bad Request:  ";
}
	
?>

