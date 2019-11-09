<?php
	require '../common/http.php';
	require '../common/conf.php';
	
	$errcode=0;
	$userinfo;
	$token=$_SERVER['HTTP_TOKEN'];
	//connect to db
	$conn = get_db_conn();
	if(!$conn)
	{
		die("db connect failed!");
	}
	$sql="SELECT *FROM TUser WHERE token='$token' AND status=1";
	$result = $conn->query($sql);
	if($result->num_rows<1)
	{
		$errcode=1;
	}
	else if($result->num_rows==1)
	{
		$row = $result->fetch_assoc();
		$userinfo->nickName=$row["nickName"];
		$userinfo->name=$row["name"];
		$userinfo->gender=$row["gender"];
		$userinfo->role=$row["role"];
$userinfo->authStatus=null;
		$userinfo->avatarUrl=$row["avatarUrl"];
		$userinfo->city=$row["city"];
		$userinfo->province=$row["province"];
		$userinfo->phone=$row["phone"];
		$userinfo->credit=$row["credit"];
	}
	else
	{
		$errcode=2;
	}
	$conn->close();

	$user->userInfo=$userinfo;
	$res->data=$user;
	$res->errcode=$errcode;
	echo json_encode($res);
?>
