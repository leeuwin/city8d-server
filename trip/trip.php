<?php 
	//class
	class User {
		var $nickName;
		var $phone;
	}
	class Trip {
		var $user;
		var $credit;
		var $startTime;
		var $endTime;
		var $fromName;
		var $fromAddress;
		var $fromLatitude;
		var $fromLongitude;
		var $destName;
		var $destAddress;
		var $destLatitude;
		var $destLongitude;
		var $passageCount;
		
	}
	class Trips {
		var $data;
		var $errcode=0;
	}
	
	//
	class TList {
		var $list=array();
	}

?>