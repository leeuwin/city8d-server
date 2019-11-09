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
	$departureDate=$_POST['departureDate'];
	date_default_timezone_set("Asia/Shanghai");
	$today=date("Y-m-d");
	$current_time=date("H:i:s");
	// --select data
	$sql = "SELECT id,publisher,departure_date,departure_time_first,departure_time_last,seat_count,src_addr_view,dst_addr_view,price FROM TTrip WHERE departure_date='$today' and departure_time_last>='$current_time' or departure_date>'$today'";

	if(!empty($departureDate))
	{
		if($departureDate>$today)
		{	$sql = "SELECT id,publisher,departure_date,departure_time_first,departure_time_last,seat_count,src_addr_view,dst_addr_view,price FROM TTrip WHERE departure_date='$departureDate'";}
		else
		{	$sql = "SELECT id,publisher,departure_date,departure_time_first,departure_time_last,seat_count,src_addr_view,dst_addr_view,price FROM TTrip WHERE departure_date='$departureDate' and departure_time_last>='$current_time'";}
	}
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc() )
	{
		$trip = new Trip();
		$user = new User();
		
		$user->userID = $row["publisher"];
		$user->nickName = "nobody";
		$user->phone = 'xxx';
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

