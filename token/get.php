<?php
	require '../common/http.php';

	$wxcode=$_POST['code'];
	$login_url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx72f8912d30adb441&secret=46cfd45178c548c4fd2887f05771360e&js_code=$wxcode&grant_type=authorization_code";
	$token=json_decode(curl_get_https($login_url));
	
	/*class token{
		var $sension_key;
		var $openid;
	}*/
	class res{
		var $data;
		var $errcode=0;
	}
	
	$res = new res();
	$res->data = $token;
	echo json_encode($res);
?>
