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
	$name=$_POST['name'];
	$cardID=$_POST['idCard'];
	$sql="UPDATE TUser SET 
		name='$name',
		IdCard='$cardID',
		role=3 WHERE token='$token'";
	$conn->query($sql);
	$conn->close();

	$data->role=3;
	
	$user->user=$data;
	$res->data=$user;
	$res->errcode=0;
	echo json_encode($res);
?>
