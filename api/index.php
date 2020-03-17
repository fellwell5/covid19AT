<?php
	/* This file is used for api caching */
	if(!file_exists("../covid.json") || filemtime("../covid.json") < (time() - 900)){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, "https://md.matthiasschaffer.com/covid19AT/covid19AT.php");
		$data = curl_exec($ch);
		curl_close($ch);
		file_put_contents("../covid.json", $data);
		
		header("Content-Type: application/json");
		exit($data);
	}else{
		header("Content-Type: application/json");
		exit(file_get_contents("../covid.json"));
	}