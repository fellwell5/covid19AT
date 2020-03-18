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
	$states_array = [
		"b" => ["name" => "Burgenland", "name_en" => "Burgenland", "population" => 294466],
		"k" => ["name" => "Kärnten", "name_en" => "Carinthia", "population" => 561390],
		"n" => ["name" => "Niederösterreich", "name_en" => "Lower Austria", "population" => 1684623],
		"o" => ["name" => "Oberösterreich", "name_en" => "Upper Austria", "population" => 1490392],
		"s" => ["name" => "Salzburg", "name_en" => "Salzburg", "population" => 558479],
		"st" => ["name" => "Steiermark", "name_en" => "Styria", "population" => 1246576],
		"t" => ["name" => "Tirol", "name_en" => "Tyrol", "population" => 757852],
		"v" => ["name" => "Vorarlberg", "name_en" => "Vorarlberg", "population" => 397094],
		"w" => ["name" => "Wien", "name_en" => "Vienna", "population" => 1911728]
	];
	$state_mapping = ["Burgenland" => "b", "Kärnten" => "k", "Niederösterreich" => "n", "Oberösterreich" => "o", "Salzburg" => "s",
		"Steiermark" => "st", "Tirol" => "t", "Vorarlberg" => "v", "Wien" => "w"];
		
	$total_population = 8904511;
	
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
		global $state_mapping;
		$output = [];
		$states = explode(")", $string);
		foreach($states as $state){
			$explode = explode(" ", $state);
			if(count($explode) == 2){
				$name = trim(str_replace([",", " ", chr(194), chr(160)], "", $explode[0]));
				$output[$state_mapping[$name]] = intval(preg_replace("/[^0-9]/", "", $explode[1]));
			}elseif(count($explode) == 3){
				$name = trim(str_replace([",", " ", chr(194), chr(160)], "", $explode[1]));
				$output[$state_mapping[$name]] = intval(preg_replace("/[^0-9]/", "", $explode[2]));
			}
		}
		foreach($state_mapping as $short){
			if(!isset($output[$short])){
				$output[$short] = 0;
			}
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
	$array["data_source_short"] = "https://masch.xyz/covid-info";
	$array["date"] = $tmp_explode[1];
	$array["time"] = substr($tmp_explode[2], 0, 5);
	$array["timestamp"] = strtotime($array["date"]." ".$array["time"]);
	
	/* GET Abstract numbers */
	//print_r($nodes[0]->childNodes[8]);
	$array["total"]["population"] = $total_population;
	$numbers = [];
	foreach($nodes[0]->childNodes as $node){
		if(strpos($node->nodeValue, "Stand") !== false) continue;
		if(strpos($node->nodeValue, "Uhr") !== false) continue;
		if(strpos($node->nodeValue, "0800 555 621") !== false) continue;
		
		preg_match_all("/[0-9.]+/", $node->nodeValue, $matches);
		foreach($matches[0] as $match){
			$value = intval(preg_replace("/[^0-9]/", "", $match));
			if($value != 0 && $value < $total_population){
				$numbers[] = $value;
			}
		}
	}
	
	/*$array["total"]["tested_persons"] = intval(preg_replace("/[^0-9]/", "", $nodes[0]->childNodes[2]->nodeValue));
	preg_match_all("/[0-9]+/", $nodes[0]->childNodes[3]->nodeValue, $matches);
	$matches = $matches[0];
	$array["total"]["infected"] = intval($matches[0]);
	$array["total"]["recovered"] = intval($matches[1]);
	$array["total"]["dead"] = intval($matches[2]);
	$array["total"]["currently_sick"] = $matches[0] - ($matches[1] + $matches[2]);*/
	
	$array["total"]["tested_persons"] = $numbers[0];
	$array["total"]["infected"] = $numbers[1];
	$array["total"]["recovered"] = $numbers[2];
	$array["total"]["dead"] = $numbers[3];
	$array["total"]["currently_sick"] = $array["total"]["infected"] - ($array["total"]["recovered"] + $array["total"]["dead"]);
	
	$array["total"]["tested_persons_percent"] = ($array["total"]["tested_persons"] / $array["total"]["population"]) * 100;
	$array["total"]["infected_percent"] = ($array["total"]["infected"] / $array["total"]["population"]) * 100;
	$array["total"]["recovered_percent"] = ($array["total"]["recovered"] / $array["total"]["population"]) * 100;
	$array["total"]["dead_percent"] = ($array["total"]["dead"] / $array["total"]["population"]) * 100;
	$array["total"]["currently_sick_percent"] = ($array["total"]["currently_sick"] / $array["total"]["population"]) * 100;
	
	
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
	$states = get_string_from($dead_string, ", nach Bundesländern: ");
	$array["details"]["dead"]["states"] = parseStates($states);
	
	
	/* SET State Informations */
	foreach($states_array as $key => $state){
		$array["states"][$key] = $state;
		$array["states"][$key]["infected"] = (isset($array["details"]["infected"]["states"][$key]) ? $array["details"]["infected"]["states"][$key] : 0);
		$array["states"][$key]["recovered"] = (isset($array["details"]["recovered"]["states"][$key]) ? $array["details"]["recovered"]["states"][$key] : 0);
		$array["states"][$key]["dead"] = (isset($array["details"]["dead"]["states"][$key]) ? $array["details"]["dead"]["states"][$key] : 0);
		$array["states"][$key]["currently_sick"] = $array["states"][$key]["infected"] - ($array["states"][$key]["recovered"] + $array["states"][$key]["dead"]);
		
		$array["states"][$key]["infected_percent"] = ($array["states"][$key]["infected"] / $array["states"][$key]["population"]) * 100;
		$array["states"][$key]["recovered_percent"] = ($array["states"][$key]["recovered"] / $array["states"][$key]["population"]) * 100;
		$array["states"][$key]["dead_percent"] = ($array["states"][$key]["dead"] / $array["states"][$key]["population"]) * 100;
		$array["states"][$key]["currently_sick_percent"] = ($array["states"][$key]["currently_sick"] / $array["states"][$key]["population"]) * 100;
	}
	
	header("Content-Type: application/json");
	echo json_encode($array);
