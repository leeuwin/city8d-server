<?php

	require '../common/conf.php';
	require 'trip.php';
	
	
	// --connect database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("连接失败: " . $conn->connect_error);
	}
	$conn->set_charset('utf8');
	
	// --select data
	$sql = "SELECT * FROM TTrip WHERE id=".$_POST['tripCode'];
	$result = $conn->query($sql);
	
	$trip = new TripDetail();
	$user = new User();
	
	while($row = $result->fetch_assoc() )
	{
		
		
		$user->userID = $row["publisher"];
		$user->nickName = "nobody";
		$user->phone = '10086';
		$user->credit = 90;
		$user->avatarUrl='http://39.100.243.238/image/avatar.jpg';
		$sql = "select nickName,phone,credit,avatarUrl from TUser where id=$user->userID";
		$userResult = $conn->query($sql);
		if($userResult->num_rows == 1)
		{
			$userRow = $userResult->fetch_assoc();
			$user->nickName = $userRow["nickName"];
			$user->phone = $userRow["phone"];
			$user->credit = $userRow["credit"];;
			$user->avatarUrl=$userRow["avatarUrl"];
		}

		$trip->user = $user;
		
		$trip->tripID = $row["id"];
		$trip->startTime = $row["departure_date"]." ".$row["departure_time_first"];
		$trip->endTime = $row["departure_date"]." ".$row["departure_time_last"];
		$trip->passageCount = $row["seat_count"];
		$trip->price = $row["price"];
		
		$trip->fromAddrView = $row["src_addr_view"];
		$trip->fromAddrName = $row["src_addr_name"];
		$trip->fromAddress = $row["src_addr"];
		$trip->fromLongitude = $row["src_longitude"];
		$trip->fromLatitude = $row["src_latitude"];
		$trip->destAddrView = $row["dst_addr_view"];
		$trip->destAddrName = $row["dst_addr_name"];
		$trip->destAddress = $row["dst_addr"];
		$trip->destLongitude = $row["dst_longitude"];
		$trip->destLatitude = $row["dst_latitude"];
		$trip->throughAddrView = $row["mid_addr_view"];
		$trip->throughAddrName = $row["mid_addr_name"];
		$trip->throughAddress = $row["mid_addr"];
		$trip->throughLongitude = $row["mid_longitude"];
		$trip->throughLatitude = $row["mid_latitude"];
		
				
	}
	$result->free_result();
	$conn->close();
	
	$trips = new Trips();
	$trips->data = $trip;
   	
	echo json_encode($trips);
?>

