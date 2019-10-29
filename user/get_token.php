<?php
	require '../common/http.php';
	require '../common/conf.php';

	function generateToken($openid)
	{
		return md5($openid);
	}
	class CUser{
		var $nick;
		var $gender;
	}
	class CData{
		var $token;
		var $user;
	}
	class CRes{
		var $data;
		var $errcode=0;
	}
	$res = new CRes();
	$user = null;
	$wxcode=$_POST['code'];
	$login_url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$wxcode&grant_type=authorization_code";
	$session=json_decode(curl_get_https($login_url));
	if(empty($session->openid) || empty($session->session_key))
	{
		$res->errcode=1;
	}
	else
	{
		$token = generateToken($session->openid);
		//connect to db
		$conn = get_db_conn();
		if(!$conn)
		{
			die("db connect failed!");
		}
		$sql="SELECT *FROM TUser WHERE openid='$session->openid' AND status=1";
		$result = $conn->query($sql);
//echo "row=[$result->num_rows]";	
	if($result->num_rows < 1)
		{
			//new user register
			$sql="INSERT INTO TUser(token,session_key,openid,role) VALUES('$token','$session->session_key','$session->openid',0)";
//echo "sql=[$sql]";	
			$result = $conn->query($sql);
			if($result!==TRUE)
			{
				$res->errcode = 2;//insert new user failed!
			}
//echo "insert success!";	
		}
		else if($result->num_rows == 1)
		{
			if($row = $result->fetch_assoc()) 
			{
				$user->nickName=$row["nickName"];
				$user->name=$row["name"];
				$user->gender=$row["gender"];
				$user->role=$row["role"];
			$user->authStatus=null;
				$user->avatarUrl=$row["avatarUrl"];
				$user->city=$row["city"];
				$user->province=$row["province"];
				$user->phone=$row["phone"];
				$user->credit=$row["credit"];

			}
			else
			{
				$res->errcode=3;//get user failed
			}
			//update user;
			//try to update session_key
			$sql="UPDATE TUser SET session_key='$session->session_key' WHERE openid='$session->openid' AND status=1";
			$result = $conn->query($sql);
		}
		else // >1
		{
			$res->errcode=4;
		}
	}
	$data = new CData();
	$data->token = $token;
	$data->user = $user;	
	$res->data = $data;
	echo json_encode($res);
?>
