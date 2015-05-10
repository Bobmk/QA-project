<?php

function redirect_to($location){
	header("Location: ".$location);
	exit;
}

function password_encrypt($password){

	$hash_format="$2y$10$";
	$saltLength=22;
	$salt=generate_salt($saltLength);
	// echo "Salt Length : ".strlen($salt)."<br>";

	$format_salt=$hash_format.$salt;
	// echo "FormatSalt Length : ".strlen($format_salt)."<br>";
	// echo $format_salt."<br><br>";

	$hash_password=crypt($password,$format_salt);
	// echo "HashedPassword Length : ".strlen($hash_password)."<br>";
	// echo $hash_password."<br>";

	$hash2=crypt($password,$hash_password);
	// echo "Hash2 Length : ".strlen($hash2)."<br>";
	// echo $hash2."<br>";

	return $hash_password;
}

function generate_salt($length){

	$rand_string=md5(uniqid(mt_rand(),true));
	// echo $rand_string."<br>";

	$base64_string=base64_encode($rand_string);
	// echo $base64_string."<br>";

	$mod_string=str_replace('+','.',$base64_string);
	// echo $mod_string."<br>";

	$salt=substr($mod_string,0,$length);

	return $salt;
}

function password_check($password,$existing_hash){
	$hash=crypt($password,$existing_hash);
	if($hash===$existing_hash)
		return true;
	else
		return false;
}

function diff_time_format($big,$small){
	$d1=strtotime($big);
	$d2=strtotime($small);

	$seconds=($d1-$d2);
	if($seconds<60){
		if($seconds<=1){
			return "$seconds second ago";
		}
		return "$seconds seconds ago";
	}
	$minutes=floor($seconds/60);
	if($minutes<60){
		if($minutes==1){
			return "1 minute ago";
		}
		return "$minutes minutes ago";
	}
	$hours=floor($minutes/60);
	if($hours<24){
		if($hours==1){
			return "1 hour ago";
		}
		return "$hours hours ago";
	}
	$days=floor($hours/24);
	if($days<30){
		if($days==1){
			return "1 day ago";
		}
		return "$days days ago";
	}
	$months=floor($days/30);
	if($months<12){
		if($months==1){
			return "1 month ago";
		}
		return "$months months ago";
	}
	$date=date_parse($small);
	$mons=array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$mod_min=$date['minute'];
	if($mod_min<10){
		$mod_min="0".$date['minute'];
	}
	$date_string=$mons[$date['month']]." ".$date['day']." ".$date['year']." at ".$date['hour'].":".$mod_min;
	return $date_string;
}


?>