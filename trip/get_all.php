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
	$sql = "SELECT id,publisher,departure_date,departure_time_first,departure_time_last,seat_count,src_addr_view,dst_addr_view,price FROM TTrip";
	$result = $conn->query($sql);
	
	$trips_list = new TList();
	while($row = $result->fetch_assoc() )
	{
		$trip = new Trip();
		$user = new User();
		
		$user->userID = row["publisher"];
		$user->nickName = "nickname";
		$user->phone = '18659985223';
		$user->credit = 90;
		$user->avatarUrl='http://39.100.243.238/image/avatar.jpg';
		$trip->user = $user;
		
		$trip->tripID = $row["id"];
		$trip->startTime = $row["departure_date"]." ".$row["departure_time_first"];
		$trip->endTime = $row["departure_date"]." ".$row["departure_time_last"];
		$trip->passageCount = $row["seat_count"];
		
		$trip->fromAddrView = $row["src_addr_view"];
		$trip->destAddrView = $row["dst_addr_view"];
		$trip->price = $row["price"];
				
		array_push($trips_list->list,$trip);
	}
	$result->free_result();
	$conn->close();
	
	$trips = new Trips();
	$trips->data = $trips_list;
   	
	echo json_encode($trips);
?>

