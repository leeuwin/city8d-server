<?php 
	//trips
	class User {
		var $userID;
		var $nickName;
		var $avatarUrl;
		var $credit;
	}
	class Trip {
		var $tripID;
		var $user;
		var $startTime;
		var $endTime;
		var $fromAddrView;
		var $destAddrView;
		var $passageCount;
		var $price;
		var $isSelf=0;
		
	}
	
	class TList {
		var $list=array();
	}
	
	class Trips {
		var $data;
		var $errcode=0;
	}
	
	//trip detail
	class TripDetail extends Trip{
		
		var $fromAddrName;
		var $fromAddress;
		var $fromLatitude;
		var $fromLongitude;
		
		var $destAddrName;
		var $destAddress;
		var $destLatitude;
		var $destLongitude;
		
		var $throughAddrView;
		var $throughAddrName;
		var $throughAddress;
		var $throughLatitude;
		var $throughLongitude;
		
		var $followList;
		
	}

?>
