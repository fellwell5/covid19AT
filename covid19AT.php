<?php
	/**
	* covid19AT
	*
	* Gets the COVID-19 stats from the austrian goverment and formats it machine readable.
	*
	* @copyright  Copyright (c) 2020 Matthias Schaffer (https://matthiasschaffer.com)
	* @license    https://spdx.org/licenses/MIT.html   MIT License
	* @link       https://github.com/fellwell5/covid19AT
	*/
	
	define("SOURCE", "https://www.sozialministerium.at/Informationen-zum-Coronavirus/Neuartiges-Coronavirus-(2019-nCov).html");
	
	function get_string_between($string, $start, $end){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}
	function get_string_from($string, $start){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strlen($string);
	    return substr($string, $ini, $len);
	}
	
	function parseStates($string){
		$state_mapping = ["Burgenland" => "b", "Kärnten" => "k", "Niederösterreich" => "n", "Oberösterreich" => "o", "Salzburg" => "s",
		"Steiermark" => "st", "Tirol" => "t", "Vorarlberg" => "v", "Wien" => "w"];
		$output = [];
		$states = explode(", ", $string);
		foreach($states as $state){
			$explode = explode(" ", $state);
			$output[$state_mapping[$explode[0]]] = preg_replace("/[^0-9]/", "", $explode[1]);
		}
		ksort($output);
		return $output;
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, SOURCE);
	$buf = curl_exec($ch);
	curl_close($ch);
	
	$DOM = new DOMDocument();
	@$DOM->loadHTML($buf);
	
	$array = [];
	
	$finder = new DomXPath($DOM);
	$nodes = $finder->query("//p[contains(@class,'abstract')]");
	
	/* GET Stand Date & Time */
	$tmp_explode = explode(", ", $nodes[0]->childNodes[0]->nodeValue);
	$array["data_source"] = SOURCE;
	$array["date"] = $tmp_explode[1];
	$array["time"] = substr($tmp_explode[2], 0, 5);
	$array["timestamp"] = strtotime($array["date"]." ".$array["time"]);
	
	/* GET Abstract numbers */
	$array["total"]["tested_persons"] = preg_replace("/[^0-9]/", "", $nodes[0]->childNodes[2]->nodeValue);
	
	preg_match_all("/[0-9]+/", $nodes[0]->childNodes[4]->nodeValue, $matches);
	$matches = $matches[0];
	$array["total"]["infected"] = $matches[0];
	$array["total"]["recovered"] = $matches[1];
	$array["total"]["dead"] = $matches[2];
	$array["total"]["currently_sick"] = $matches[0] - ($matches[1] + $matches[2]);
	
	
	$nodes = $finder->query("//div[contains(@class,'infobox')]/p");
	
	/* GET Information: infected */
	$infected_string = $nodes[3]->nodeValue;
	
	$tmp_explode = explode(", ", $infected_string);
	$date = preg_replace("/[^0-9.]/", "", $tmp_explode[1]); $time = substr($tmp_explode[2], 0, 5);
	
	$array["details"]["infected"]["information"] = [
		"name" => $tmp_explode[0], "name_en" => "Infected",
		"updated_date" => $date, "updated_time" => $time, "updated_timestamp" => strtotime($date." ".$time)
	];
	$states = get_string_from($infected_string, ", nach Bundesländern: ");
	$array["details"]["infected"]["states"] = parseStates($states);
	
	/* GET Information: recovered */
	$recovered_string = $nodes[4]->nodeValue;
	
	$tmp_explode = explode(", ", $recovered_string);
	$date = preg_replace("/[^0-9.]/", "", $tmp_explode[1]); $time = substr($tmp_explode[2], 0, 5);
	
	$array["details"]["recovered"]["information"] = [
		"name" => $tmp_explode[0], "name_en" => "Recovered",
		"updated_date" => $date, "updated_time" => $time, "updated_timestamp" => strtotime($date." ".$time)
	];
	$states = get_string_from($recovered_string, ", nach Bundesländern: ");
	$array["details"]["recovered"]["states"] = parseStates($states);
	
	/* GET Information: dead */
	$dead_string = $nodes[5]->nodeValue;
	
	$tmp_explode = explode(", ", $dead_string);
	$date = preg_replace("/[^0-9.]/", "", $tmp_explode[1]); $time = substr($tmp_explode[2], 0, 5);
	
	$array["details"]["dead"]["information"] = [
		"name" => $tmp_explode[0], "name_en" => "Dead",
		"updated_date" => $date, "updated_time" => $time, "updated_timestamp" => strtotime($date." ".$time)
	];
	if(strpos($dead_string, ", nach Bundesländern: ") !== false){
		$states = get_string_from($dead_string, ", nach Bundesländern: ");
		$array["details"]["dead"]["states"] = parseStates($states);
	}else{
		$tmp_explode = explode(":", $dead_string);
		$array["details"]["dead"]["states"] = ["w" => preg_replace("/[^0-9]/", "", $tmp_explode[2])];
	}
	
	
	/* SET State Informations */
	$states = [
		"b" => ["name" => "Burgenland", "name_en" => "Burgenland"],
		"k" => ["name" => "Kärnten", "name_en" => "Carinthia"],
		"n" => ["name" => "Niederösterreich", "name_en" => "Lower Austria"],
		"o" => ["name" => "Oberösterreich", "name_en" => "Upper Austria"],
		"s" => ["name" => "Salzburg", "name_en" => "Salzburg"],
		"st" => ["name" => "Steiermark", "name_en" => "Styria"],
		"t" => ["name" => "Tirol", "name_en" => "Tyrol"],
		"v" => ["name" => "Vorarlberg", "name_en" => "Vorarlberg"],
		"w" => ["name" => "Wien", "name_en" => "Vienna"]
	];
	
	foreach($states as $key => $state){
		$array["states"][$key] = $state;
		$array["states"][$key]["infected"] = (isset($array["details"]["infected"]["states"][$key]) ? $array["details"]["infected"]["states"][$key] : 0);
		$array["states"][$key]["recovered"] = (isset($array["details"]["recovered"]["states"][$key]) ? $array["details"]["recovered"]["states"][$key] : 0);
		$array["states"][$key]["dead"] = (isset($array["details"]["dead"]["states"][$key]) ? $array["details"]["dead"]["states"][$key] : 0);
		$array["states"][$key]["currently_sick"] = $array["states"][$key]["infected"] - ($array["states"][$key]["recovered"] + $array["states"][$key]["dead"]);
	}
	
	header("Content-Type: application/json");
	echo json_encode($array);
