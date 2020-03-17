<?php
	if(!isset($_GET["load"])){
		$jsonRequest = file_get_contents('php://input');
		$data = json_decode($jsonRequest, true);
		if( empty($data) || (!isset($data) ) ) {
			die('Bad Request');
		}
		
		$intent = !empty($data['request']['intent']['name']) ? $data['request']['intent']['name'] : 'default';
		$intentData = !empty($data['request']['intent']['slots']) ? $data['request']['intent']['slots'] : 'default';
		
		require_once("valid_request.php");
		$guid = "63fa1d8f-d639-4b98-bfb0-21bf9f1ab20f";
		$valid = validate_request( $guid, "" );
		if ( ! $valid['success'] )  {
		    error_log( 'Request failed: ' . $valid['message'] );
		    header("HTTP/1.1 400 Bad Request");
		    die();
		}
		
		//if($intent == "coronastats_state")
		//file_put_contents("alexa.json", $jsonRequest);
	}else{
		$jsonRequest = file_get_contents('alexa.json');
		$data = json_decode($jsonRequest, true);
		$intent = !empty($data['request']['intent']['name']) ? $data['request']['intent']['name'] : 'default';
		$intentData = !empty($data['request']['intent']['slots']) ? $data['request']['intent']['slots'] : 'default';
	}
	
	define("BASE_URL", "https://md.matthiasschaffer.com/covid19AT");
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, BASE_URL."/covid19AT.php");
	$r = json_decode(curl_exec($ch), true);
	curl_close($ch);
	
	function getAustriaStats(){
		global $r, $data;
		$responseArray = [ 'version' => '1.0',
		    'response' => [
		          'outputSpeech' => [
		                'type' => 'PlainText',
		                'text' => "In Österreich sind zurzeit ".$r["total"]["currently_sick"]." Personen am Coronavirus erkrankt. Bisher wurden ".$r["total"]["tested_persons"]." Personen getestet.",
		                'ssml' => null
		          ],
		          'shouldEndSession' => false
		    ]
		];
		if(isset($data["context"]["System"]["device"]["supportedInterfaces"]["Display"])){
			$responseArray["response"]["directives"] = [[
				'type' => 'Display.RenderTemplate',
				'template' => [
					'type' => 'BodyTemplate1',
					'token' => 'coronastats',
					"backgroundImage" => [
						"contentDescription" => "Hintergrundbild",
						"sources" => [[
							"url" => BASE_URL."/alexa/background_blacked.jpg"
						]]
					],
					'backButton' => 'HIDDEN',
					'title' => 'Coronavirus in Österreich',
					'textContent' => [
						'primaryText' => [
							'text' => '<font size="5">In Österreich sind zurzeit <b>'.$r["total"]["currently_sick"].'</b> Personen am Coronavirus erkrankt.<br />Bisher wurden <b>'.$r["total"]["tested_persons"].'</b> Personen getestet.</font>',
							'type' => 'RichText'
						],
						'secondaryText' => [
							'text' => '<font size="2">Personen infiziert: <b>'.$r["total"]["infected"].'</b>,  genesen: <b>'.$r["total"]["recovered"].'</b>,  verstorben: <b>'.$r["total"]["dead"].'</b></font>',
							'type' => 'RichText'
						],
						'tertiaryText' => [
							'text' => '<br /><br /><action token="coronastats_allstates">Alle Bundesländer anzeigen</action><br /><font size="1">Stand: '.date("d.m.Y H:i", $r["timestamp"]).' - Quelle: '.$r["data_source_short"].'</font>',
							'type' => 'RichText'
						]
					]
				]
			]];
		}
		return $responseArray;
	}
	
	if($data["request"]["type"] == "IntentRequest"){
		switch ($intent) {
			case 'coronastats_state':
				$state_mapping = ["burgenland" => "b", "kärnten" => "k", "niederösterreich" => "n", "oberösterreich" => "o", "salzburg" => "s",
					"steiermark" => "st", "tirol" => "t", "vorarlberg" => "v", "wien" => "w"];
				$intent_state = !empty($intentData['state']['value']) ? $intentData['state']['value'] : '';
				
				if(!isset($state_mapping[strtolower($intent_state)])){
					$responseArray = [ 'version' => '1.0',
					    'response' => [
					          'outputSpeech' => [
					                'type' => 'PlainText',
					                'text' => "Tut mir leid. Das Bundesland $intent_state habe ich nicht erkannt.",
					                'ssml' => null
					          ],
					          
					          'shouldEndSession' => true
					    ]
					];
					break;
				}
				
				$state = $r["states"][$state_mapping[strtolower($intent_state)]];
				
				$responseArray = [ 'version' => '1.0',
				    'response' => [
				          'outputSpeech' => [
				                'type' => 'PlainText',
				                'text' => "Im Bundesland ".$state["name"]." sind zurzeit ".$state["currently_sick"]." Personen am Coronavirus erkrankt.",
				                'ssml' => null
				          ],
				          'shouldEndSession' => false
				    ]
				];
				
				if(isset($data["context"]["System"]["device"]["supportedInterfaces"]["Display"])){
					$responseArray["response"]["directives"] = [[
						'type' => 'Display.RenderTemplate',
						'template' => [
							'type' => 'BodyTemplate1',
							'token' => 'coronastats_'.$state_mapping[strtolower($intent_state)],
							"backgroundImage" => [
								"contentDescription" => "Hintergrundbild",
								"sources" => [[
									"url" => BASE_URL."/alexa/background_blacked.jpg"
								]]
							],
							'backButton' => 'HIDDEN',
							'title' => 'Coronavirus - '.$state["name"],
							'textContent' => [
								'primaryText' => [
									'text' => '<font size="5">Im Bundesland <b>'.$state["name"].'</b> sind zurzeit <b>'.$state["currently_sick"].'</b> Personen am Coronavirus erkrankt.</font>',
									'type' => 'RichText'
								],
								'secondaryText' => [
									'text' => '<font size="2">Personen infiziert: <b>'.$state["infected"].'</b>,  genesen: <b>'.$state["recovered"].'</b>,  verstorben: <b>'.$state["dead"].'</b></font>',
									'type' => 'RichText'
								],
								'tertiaryText' => [
									'text' => '<br /><br /><action token="coronastats_allstates">Alle Bundesländer anzeigen</action><br /><font size="1">Stand: '.date("d.m.Y H:i", $r["timestamp"]).' - Quelle: '.$r["data_source_short"].'</font>',
									'type' => 'RichText'
								]
							]
						]
					]];
				}
				break;
			case 'coronastats_allstates':
				if(isset($data["context"]["System"]["device"]["supportedInterfaces"]["Display"])){
					$listItems = [];
					foreach($r["states"] as $key => $state){
						$listItems[] = [
							"token" => "state_".$key,
							"image" => [
								"contentDescription" => "Wappen des Bundeslandes ".$state["name"],
								"sources" => [[
									"url" => BASE_URL."/alexa/Wappen/$key.jpg"
								]]
							],
							'textContent' => [
								'primaryText' => [
									'text' => '<font size="6">'.$state["name"].'</font>',
									'type' => 'RichText'
								],
								'secondaryText' => [
									'text' => '<font size="2">infiziert: <b>'.$state["infected"].'</b>,  genesen: <b>'.$state["recovered"].'</b>,  verstorben: <b>'.$state["dead"].'</b></font>',
									'type' => 'RichText'
								],
								'tertiaryText' => [
									'text' => '<font size="7">'.$state["currently_sick"].'</font>',
									'type' => 'RichText'
								]
							]
						];
					}
					$responseArray = [ 'version' => '1.0',
					    'response' => [
					    			'directives' => [[
											'type' => 'Display.RenderTemplate',
											'template' => [
												'type' => 'ListTemplate1',
												'token' => 'coronastats_allstates',
												'backButton' => 'HIDDEN',
												"backgroundImage" => [
													"contentDescription" => "Hintergrundbild",
													"sources" => [[
														"url" => BASE_URL."/alexa/background_blacked.jpg"
													]]
												],
												'title' => 'Coronavirus - erkrankte Personen',
												'listItems' => $listItems
											]
										]],
					          'shouldEndSession' => true
					    ]
					];
				}else{
					$responseArray = [ 'version' => '1.0',
					    'response' => [
					          'outputSpeech' => [
					                'type' => 'PlainText',
					                'text' => "Dein Gerät unterstützt diese Anfrage nicht.",
					                'ssml' => null
					          ],
					          'shouldEndSession' => true
					    ]
					];
				}
				break;
			// Default
			case 'coronastats':
			default:
				$responseArray = getAustriaStats();
		}
	}elseif($data["request"]["type"] == "Display.ElementSelected"){
		switch($data["request"]["token"]){
			case "coronastats_allstates":
				$listItems = [];
				foreach($r["states"] as $key => $state){
					$listItems[] = [
						"token" => "state_".$key,
						"image" => [
							"contentDescription" => "Wappen des Bundeslandes ".$state["name"],
							"sources" => [[
								"url" => BASE_URL."/alexa/Wappen/$key.jpg"
							]]
						],
						'textContent' => [
							'primaryText' => [
								'text' => '<font size="6">'.$state["name"].'</font>',
								'type' => 'RichText'
							],
							'secondaryText' => [
								'text' => '<font size="2">infiziert: <b>'.$state["infected"].'</b>,  genesen: <b>'.$state["recovered"].'</b>,  verstorben: <b>'.$state["dead"].'</b></font>',
								'type' => 'RichText'
							],
							'tertiaryText' => [
								'text' => '<font size="7">'.$state["currently_sick"].'</font>',
								'type' => 'RichText'
							]
						]
					];
				}
				$responseArray = [ 'version' => '1.0',
				    'response' => [
				    			'directives' => [[
										'type' => 'Display.RenderTemplate',
										'template' => [
											'type' => 'ListTemplate1',
											'token' => 'coronastats_allstates',
											'backButton' => 'HIDDEN',
											"backgroundImage" => [
												"contentDescription" => "Hintergrundbild",
												"sources" => [[
													"url" => BASE_URL."/alexa/background_blacked.jpg"
												]]
											],
											'title' => 'Coronavirus - erkrankte Personen',
											'listItems' => $listItems
										]
									]],
				          'shouldEndSession' => true
				    ]
				];
				break;
		}
	}else{
		$responseArray = getAustriaStats();
	}
	
	header ( 'Content-Type: application/json' );
	echo json_encode ( $responseArray );
	die();