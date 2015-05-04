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


?>