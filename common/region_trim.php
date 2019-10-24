<?php
	function fetch_city_dist($str)
	{
		$city="";
		$dist="";
		$region_pos = strpos($str, "省");
		if(empty($region_pos))
		{
			$region_pos = strpos($str, "市");
			if(!empty($region_pos))
			{
				$city = substr($str, 0, $region_pos+3);
			}
		}
		$str = substr($str, $region_pos+3, strlen($str));
		$city_pos = strpos($str, "市");
		if(!empty($city_pos))
		{
			$city = substr($str, 0, $city_pos+3);
			$str = substr($str, $city_pos+3, strlen($str));
		}
		$dist_pos = strpos($str, "区");
		if(empty($dist_pos))
		{
			$dist_pos = strpos($str, "市");
			if(empty($dist_pos))
			{
				$dist_pos = strpos($str, "县");
			}
		}
		$dist = substr($str,0, $dist_pos+3);
		return $city."|".$dist;	
	}
	function fetch_city($str)
	{
		$str = fetch_city_dist($str);
		$city_pos = strpos($str, "|");
		return substr($str, 0, $city_pos);
	}
	function fetch_dist($str)
	{
		$str = fetch_city_dist($str);
		$dist_pos = strpos($str, "|");
		return substr($str, $dist_pos+1, strlen($str));
	}
	function filter_addr($str,$city,$dist)
	{
        $detail_pos=strpos($str,"(");
        if(is_numeric($detail_pos))
        {
                $str = substr($str, 0, $detail_pos);
        }
        $city_pos=strpos($str,$city);
        if(is_numeric($city_pos))
        {
                $str = substr($str, $city_pos+strlen($city), strlen($str)-strlen($city));
        }
        $dist_pos=strpos($str,$dist);
        if(is_numeric($dist_pos))
        {
                $str = substr($str, $dist_pos+strlen($dist), strlen($str)-strlen($dist));
        }
		$addr=$city.$dist.$str;
		/*
		$addr=$dist.$str;
		if(strlen($addr)>45)
		{
			$addr = substr($addr,0,45);
		}
		else if(strlen($addr)+strlen($city) <= 45)
		{
			$addr = $city.$addr;
		}*/
		
        return $addr;
	}
?>
