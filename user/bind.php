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
	$idCard=$_POST['idCard'];
	$cardID=substr($idCard,6,8);
        $birth_year=substr($cardID,0,4);
        $birth_month=substr($cardID,4,2);
        $birth_day=substr($cardID,6,2);
        $birthday="$birth_year-$birth_month-$birth_day";
	$sql="UPDATE TUser SET 
		name='$name',
		IdCard='$idCard',
		birthday='$birthday',
		credit=credit+10,
		role=3 WHERE token='$token'";
	$conn->query($sql);
	$conn->close();

	$data->role=3;
$data->authStatus=null;
	$user->user=$data;
	$res->data=$user;
	$res->errcode=0;
	echo json_encode($res);
?>
