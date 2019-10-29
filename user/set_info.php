<?php
	require '../common/http.php';
	require '../common/conf.php';
	

	$token=$_SERVER['HTTP_TOKEN'];
	//connect to db
	$conn = get_db_conn();
	if(!$conn)
	{
		die("db connect failed!");
	}
	
	$sql="SELECT role FROM TUser WHERE token='$token'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$role = $row["role"];
	if(is_null($role) || empty($role))
	{
		$role = 1;
	}
	
	$nickName=$_POST['nickName'];
	$avatarUrl=$_POST['avatarUrl'];
	$gender=$_POST['gender'];
	$city=$_POST['city'];
	$province=$_POST['province'];
	$sql="UPDATE TUser SET 
		nickName='$nickName',
		gender='$gender',
		phone='10086',
		city='$city',
		role=$role,
		credit=60,
		province='$province',
		avatarUrl='$avatarUrl' WHERE token='$token'";
	$conn->query($sql);
	$conn->close();

	$data->nickName=$nickName;
	$data->avatarUrl=$avatarUrl;
	$data->gender=$gender;
	$data->city=$city;
	$data->province=$province;
$data->role=$role;
$data->authStatus=null;
	$user->user=$data;
	$res->data=$user;
	$res->errcode=0;
	echo json_encode($res);
?>
