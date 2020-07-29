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
	
	function parse_csv_string($string){
		$csv = [];
		$lines = explode("\n", $string);
		$head = str_getcsv(array_shift($lines), ";");
		$columns = count($head);
		foreach($lines as $line){
			$line = str_getcsv($line, ";");
			if($columns > count($line)) break;
			
			$newline = [];
			foreach($line as $id => $col){
				$newline[$head[$id]] = $col;
			}
			$csv[] = $newline;
		}
		
		return $csv;
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, "https://info.gesundheitsministerium.at/data/AllgemeinDaten.csv");
	$csv = curl_exec($ch);
	$allgemeine_daten = parse_csv_string($csv)[0];
	
	$array["timestamp"] = strtotime($allgemeine_daten["Timestamp"]);
	$array["date"] = strtotime($allgemeine_daten["Timestamp"]);
	$array["time"] = strtotime($allgemeine_daten["Timestamp"]);
	
	$array["total"]["tested_persons"] = intval($allgemeine_daten["GesTestungen"]);
	$array["total"]["infected"] = intval($allgemeine_daten["PositivGetestet"]);
	$array["total"]["recovered"] = intval($allgemeine_daten["Genesen"]);
	$array["total"]["dead"] = intval($allgemeine_daten["TotBestaetigt"]);
	$array["total"]["currently_sick"] = intval($allgemeine_daten["AktuelleErkrankungen"]);
	$array["total"]["population"] = $total_population;
	
	$array["total"]["tested_persons_percent"] = ($array["total"]["tested_persons"] / $array["total"]["population"]) * 100;
	$array["total"]["infected_percent"] = ($array["total"]["infected"] / $array["total"]["population"]) * 100;
	$array["total"]["recovered_percent"] = ($array["total"]["recovered"] / $array["total"]["population"]) * 100;
	$array["total"]["dead_percent"] = ($array["total"]["dead"] / $array["total"]["population"]) * 100;
	$array["total"]["currently_sick_percent"] = ($array["total"]["currently_sick"] / $array["total"]["population"]) * 100;
	
	
	/* GET Information: currently_sick */
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, "https://info.gesundheitsministerium.at/data/Bundesland.csv");
	$csv = curl_exec($ch);
	$bundeslaender = parse_csv_string($csv);
	
	$array["details"]["currently_sick"]["information"] = [
		"name" => "Zurzeit Erkrankt", "name_en" => "Currently Sick",
		"updated_timestamp" => strtotime($bundeslaender[0]["Timestamp"]),
		"updated_datetime" => $bundeslaender[0]["Timestamp"]
	];
	foreach($bundeslaender as $bl){
		$bl_short = $state_mapping[ucfirst($bl["Bundesland"])];
		$array["details"]["currently_sick"]["states"][$bl_short] = intval($bl["Anzahl"]);
	}
	
	/* GET Information: recovered & dead */
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, "https://info.gesundheitsministerium.at/data/GenesenTodesFaelleBL.csv");
	$csv = curl_exec($ch);
	$bundeslaender = parse_csv_string($csv);
	
	$array["details"]["recovered"]["information"] = [
		"name" => "Genesen", "name_en" => "Recovered",
		"updated_timestamp" => strtotime($bundeslaender[0]["Timestamp"]),
		"updated_datetime" => $bundeslaender[0]["Timestamp"]
	];
	$array["details"]["dead"]["information"] = [
		"name" => "Verstorben", "name_en" => "Dead",
		"updated_timestamp" => strtotime($bundeslaender[0]["Timestamp"]),
		"updated_datetime" => $bundeslaender[0]["Timestamp"]
	];
	
	foreach($bundeslaender as $bl){
		$bl_short = $state_mapping[ucfirst($bl["Bundesland"])];
		$array["details"]["recovered"]["states"][$bl_short] = intval($bl["Genesen"]);
		$array["details"]["dead"]["states"][$bl_short] = intval($bl["Todesfälle"]);
	}
	
	/* GET Information: district_infected */
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, "https://info.gesundheitsministerium.at/data/Bezirke.csv");
	$csv = curl_exec($ch);
	$bezirke = parse_csv_string($csv);
	
	$array["details"]["district_infected"]["information"] = [
		"name" => "Infiziert (nach Bezirk)", "name_en" => "Infected (by district)",
		"updated_timestamp" => strtotime($bezirke[0]["Timestamp"]),
		"updated_datetime" => $bezirke[0]["Timestamp"]
	];
	foreach($bezirke as $be){
		$array["details"]["district_infected"]["districts"][intval($be["GKZ"])] = intval($be["Anzahl"]);
	}
	foreach($bezirke as $be){
		$array["details"]["district_infected"]["districts_name"][intval($be["GKZ"])] = $be["Bezirk"];
	}
	
	/* SET State Informations */
	$array["details"]["infected"]["information"] = [
		"name" => "Infizierte", "name_en" => "Infected",
		"updated_timestamp" => strtotime($bundeslaender[0]["Timestamp"]),
		"updated_datetime" => $bundeslaender[0]["Timestamp"]
	];
	foreach($states_array as $key => $state){
		$array["states"][$key] = $state;
		$array["states"][$key]["infected"] = 	(isset($array["details"]["recovered"]["states"][$key]) ? $array["details"]["recovered"]["states"][$key] : 0)+
																					(isset($array["details"]["dead"]["states"][$key]) ? $array["details"]["dead"]["states"][$key] : 0)+
																					(isset($array["details"]["currently_sick"]["states"][$key]) ? $array["details"]["currently_sick"]["states"][$key] : 0);
		$array["details"]["infected"]["states"][$key] = $array["states"][$key]["infected"];
		
		$array["states"][$key]["recovered"] = (isset($array["details"]["recovered"]["states"][$key]) ? $array["details"]["recovered"]["states"][$key] : 0);
		$array["states"][$key]["dead"] = (isset($array["details"]["dead"]["states"][$key]) ? $array["details"]["dead"]["states"][$key] : 0);
		$array["states"][$key]["currently_sick"] = (isset($array["details"]["currently_sick"]["states"][$key]) ? $array["details"]["currently_sick"]["states"][$key] : 0);
		
		$array["states"][$key]["infected_percent"] = ($array["states"][$key]["infected"] / $array["states"][$key]["population"]) * 100;
		$array["states"][$key]["recovered_percent"] = ($array["states"][$key]["recovered"] / $array["states"][$key]["population"]) * 100;
		$array["states"][$key]["dead_percent"] = ($array["states"][$key]["dead"] / $array["states"][$key]["population"]) * 100;
		$array["states"][$key]["currently_sick_percent"] = ($array["states"][$key]["currently_sick"] / $array["states"][$key]["population"]) * 100;
	}
	
	header("Content-Type: application/json");
	echo json_encode($array);
