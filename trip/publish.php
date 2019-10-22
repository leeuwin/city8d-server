<?php

	require '../common/conf.php';
	require '../common/validate.php';
	require '../common/region_trim.php';
	require 'trip.php';
	
	
	// --connect database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		echo "{\"errcode\":1,\"errmsg\":\"$conn->connect_error\"}";
		die();
	}
	$conn->set_charset('utf8');
		
	$stmt = $conn->prepare("INSERT INTO TTrip(
	type,
	publisher,
	departure_date,
	departure_time_first,
	departure_time_last,
	seat_count,
	price,
	src_longitude,
	src_latitude,
	src_addr_view,
	src_addr_name,
	src_addr,
	src_city,
	src_district,
	dst_longitude,
	dst_latitude,
	dst_addr_view,
	dst_addr_name,
	dst_addr,
	dst_city,
	dst_district,
	mid_longitude,
	mid_latitude,
	mid_addr_view,
	mid_addr_name,
	mid_addr,
	mid_city,
	mid_district) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("iisssidddsssssddsssssddsssss",
	$type,
	$publisher,
	$departure_date,
	$departure_time_first,
	$departure_time_last,
	$seat_count,
	$price,
	$src_longitude,
	$src_latitude,
	$src_addr_view,
	$src_addr_name,
	$src_addr,
	$src_city,
	$src_district,
	$dst_longitude,
	$dst_latitude,
	$dst_addr_view,
	$dst_addr_name,
	$dst_addr,
	$dst_city,
	$dst_district,
	$mid_longitude,
	$mid_latitude,
	$mid_addr_view,
	$mid_addr_name,
	$mid_addr,
	$mid_city,
	$mid_district);
	
	$type = test_input($_POST['type']);
	$publisher = 1;
	$departure_date = test_input($_POST['date']);
	$departure_time_first = test_input($_POST['startTime']);
	$departure_time_last = test_input($_POST['endTime']);
	$seat_count = test_input($_POST['seatCount']);
	$price = test_input($_POST['price']);
	$src_longitude = test_input($_POST['fromLongitude']);
	$src_latitude = test_input($_POST['fromLatitude']);
	$src_addr_name = test_input($_POST['fromAddrName']);
	$src_addr = test_input($_POST['fromAddress']);
	$src_city = fetch_city($src_addr);
	$src_district = fetch_dist($src_addr);
	$src_addr_view = filter_addr($src_addr_name,$src_city,$src_district);
	$dst_longitude = test_input($_POST['destLongitude']);
	$dst_latitude = test_input($_POST['destLatitude']);
	$dst_addr_name = test_input($_POST['destAddrName']);
	$dst_addr = test_input($_POST['destAddress']);
	$dst_city = fetch_city($dst_addr);
	$dst_district = fetch_dist($dst_addr);
	$dst_addr_view = filter_addr($dst_addr_name,$dst_city,$dst_district);
	$mid_longitude = test_input($_POST['throughLongitude']);
	$mid_latitude = test_input($_POST['throughLatitude']);
	$mid_addr_name = test_input($_POST['throughAddrName']);
	$mid_addr = test_input($_POST['throughAddress']);
	$mid_city = fetch_city($mid_addr);
	$mid_district = fetch_dist($mid_addr);
	$mid_addr_view = filter_addr($mid_addr_name,$mid_city,$mid_district);
	
	$stmt->execute();
	$stmt->close();
	$conn->close();

	echo "{\"errcode\":0}"
?>

