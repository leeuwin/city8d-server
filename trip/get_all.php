<?php

	require '../common/conf.php';
	require 'trip.php';
	
	$trips_list = new TList();
	
	$trip = new Trip();
	$user = new User();
	
	// --connect database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("连接失败: " . $conn->connect_error);
	}
	$conn->set_charset('utf8');
	
	// --select data
	$sql = "SELECT * FROM TTrip";
	$result = $conn->query($sql);
	 
	$user->nickName = $_POST['destCityCode'];
	$user->phone = '18659985223';
	
	while($row = $result->fetch_assoc() )
	{
		$trip = new Trip();
		$trip->user = $user;
		$trip->credit = 99;
		$trip->startTime = $row["departure_date"]." ".$row["departure_time_first"];
		$trip->endTime = $row["departure_date"]." ".$row["departure_time_last"];
		$trip->passageCount = $row["seat_count"];
		
		$trip->fromName = $row["src_city"];
		$trip->fromAddress = $row["src_addr"];
		$trip->fromLongitude = $row["src_longitude"];
		$trip->fromLatitude = $row["src_latitude"];
		$trip->destName = $row["dst_city"];
		$trip->destAddress = $row["dst_addr"];
		$trip->destLongitude = $row["dst_longitude"];
		$trip->destLatitude = $row["dst_latitude"];
		$trip->price = $row["price"];
				
		array_push($trips_list->list,$trip);
	}
	$result->free_result();
	$conn->close();
	
	$t = new Trips();
	$t->data = $trips_list;
   	
	echo json_encode($t);
?>

