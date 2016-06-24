<?php

if(isset($_GET['QueryType']) && isset($_GET['Parameters']))
{
	$QueryType = urldecode($_GET['QueryType']);
	$Parameters = urldecode($_GET['Parameters']);
	
	$server 	="localhost";
	$db		="WestProjectionsData";
	$user	="MobileUser";
	$pwd	="MobileProjection";
		$sql = "";
	
	if($QueryType == "List")
	{
		$ParamsSplit = explode("|", $Parameters);
		$RequestType = explode("=", $ParamsSplit[0])[1];
		$MaxResults = explode("=", $ParamsSplit[1])[1];
		$NoOlderThan = explode("=", $ParamsSplit[2])[1];
		$UnreadOnly = explode("=", $ParamsSplit[3])[1];


		$sql = "SELECT * FROM `UserInput` WHERE  `RequestType` = '" . $RequestType . "'";

		if($NoOlderThan != "0")
		{
			$sql = $sql . " AND  `Time_Posted` >=  DATE_SUB( NOW( ) , INTERVAL " . $NoOlderThan . " MINUTE)";
		}

		if($UnreadOnly == "TRUE")
		{
			$sql = $sql . " AND  `ServerRead` =0";
		}

		if($MaxResults != "0" && $MaxResults != "") 
		{
			$sql = $sql . " LIMIT " . $MaxResults;
		}
	
	}
	else if ($QueryType == "MarkAsRead")
	{
		$sql = "UPDATE `UserInput` SET `ServerRead`= 1  WHERE `ServerRead` = 0";
	}
    if($sql != "")
	{
		$conn = new mysqli($server, $user, $pwd, $db);
		if ($conn->connect_error) 
		{
		    die("Connection failed: " . $conn->connect_error);
		} 
		$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
		    // output data of each row
		    $allrows = "id,Date,IP,RequestType,Value\r\n";
		 //header	
			while($row = $result->fetch_assoc()) 
			{
		        $output[$row["id"]] = $row;
				
				$flatrow = "";
				$flatrow .= $row["ID"] .",";
				$flatrow .= $row["Time_Posted"].",";
				
				$flatrow .= $row["IP_Posted"].",";
				
				$flatrow .= $row["RequestType"].",";
				$flatrow .= $row["Value"];
			
				$flatrow .= "\r\n";
				$allrows .= $flatrow;
		    }
			
		} 
		else 
		{
		    die( "0 results");
		}
		$conn->close();
		echo $allrows;
	}	
}
else 
{
	header("HTTP/1.0 400 Bad Request");
	echo "Bad Request:  ";
}

?>

