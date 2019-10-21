<?php

	require '../common/conf.php';
	require '../common/validate.php'
	require 'trip.php';
	
	
	// --connect database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		echo "{\"errcode\":1,\"errmsg\":\"$conn->connect_error\"}";
		die();
	}
	$conn->set_charset('utf8');
		
	$stmt = $conn->prepare("INSERT INTO TTrip(type,publisher,departure_date,departure_time_first,departure_time_last,seat_count,price,src_longitude,src_latitude,src_addr,dst_longitude,dst_latitude,dst_addr) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("iisssidddsdds",$type,$publisher,$departure_date,$departure_time_first,$departure_time_last,$seat_count,$price,$src_longitude,$src_latitude,$src_addr,$dst_longitude,$dst_latitude,$dst_addr);
	$type = test_input($_POST['type']);
	$publisher = 1;
	$departure_date = test_input($_POST['date']);
	$departure_time_first = test_input($_POST['startTime']);
	$departure_time_last = test_input($_POST['endTime']);
	$seat_count = test_input($_POST['seatCount']);
	$price = test_input($_POST['price']);
	$src_longitude = test_input($_POST['fromLongitude']);
	$src_latitude = test_input($_POST['fromLatitude']);
	$src_addr = test_input($_POST['fromAddress']);
	$dst_longitude = test_input($_POST['destLongitude']);
	$dst_latitude = test_input($_POST['destLatitude']);
	$dst_addr = test_input($_POST['destAddress']);
	
	$stmt->execute();
	$stmt->close();
	$conn->close();

	echo "{\"errcode\":0}"
?>

