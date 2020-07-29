<?php
	require_once("mysql.php");
	$commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));
  $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
  $commitDate->setTimezone(new \DateTimeZone('Europe/Vienna'));
  
  $version = sprintf('rev.%s (%s)', $commitHash, $commitDate->format('Y-m-d H:i:s'));
?>
<!doctype html>
<html lang="de" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="covid19AT Stats">
    <meta name="author" content="Matthias Schaffer">
    <title>covid19AT Stats</title>
    
    <link href="fontawesome/css/all.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/Chart.min.css" rel="stylesheet">
		
		<link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <link rel="mask-icon" href="./favicon/safari-pinned-tab.svg" color="#b91d47">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#b91d47">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
			
			.footer {
			  background-color: #f5f5f5;
			}
			
			.card-body-icon {
				position: absolute;
				z-index: 0;
				top: -20px;
				right: 0px;
				font-size: 5rem;
				-webkit-transform: rotate(5deg);
				-ms-transform: rotate(5deg);
				transform: rotate(5deg);
			}
			
			@media screen and (orientation:landscape)
			{
			   .orientation-warning
			   {
			      display: none;
			   }
			}
    </style>
  </head>
  <body class="d-flex flex-column h-100">
  	
		<main role="main" class="flex-shrink-0">
			<div class="container mt-5">
				<?php
					$result = $mysqli->query("SELECT * FROM `total` ORDER BY `timestamp` DESC LIMIT 0,1");
					$row = $result->fetch_assoc();
	        $last_update = (file_exists("../last_update.txt")) ? filemtime("../last_update.txt") : $row["timestamp"];
				?>
				<h1>covid-19 Austria</h1>
		  	<h3>Stand <?php echo date("d.m.Y H:i", $row["timestamp"]); ?></h3>
		  	<div class="jumbotron">
		  	  <h3>Offizielle Information des Bundesministeriums für Soziales, Gesundheit, Pflege und Konsumentenschutz</h3>
		  	  <a class="btn btn-primary" href="https://info.gesundheitsministerium.at/">Hier klicken <i class="fas fa-angle-right"></i></a>
		  	</div>
	      <div class="row">
	        <div class="col-xl-3 col-sm-6 mb-3">
	          <div class="card text-white bg-primary o-hidden h-100">
	            <div class="card-body">
	              <div class="card-body-icon">
	                <i class="fas fa-vial"></i>
	              </div>
	              <div class="mr-5"><h4><?php echo $row["tested_persons"]; ?></h4> getestete Personen</div>
	            </div>
	          </div>
	        </div>
	        <div class="col-xl-3 col-sm-6 mb-3">
	          <div class="card text-white bg-warning o-hidden h-100">
	            <div class="card-body">
	              <div class="card-body-icon">
	                <i class="fas fa-biohazard"></i>
	              </div>
	              <div class="mr-5"><h4><?php echo $row["infected"]; ?></h4> infizierte Personen</div>
	            </div>
	          </div>
	        </div>
	        <div class="col-xl-3 col-sm-6 mb-3">
	          <div class="card text-white bg-success o-hidden h-100">
	            <div class="card-body">
	              <div class="card-body-icon">
	                <i class="fas fa-user-nurse"></i>
	              </div>
	              <div class="mr-5"><h4><?php echo $row["recovered"]; ?></h4> genesene Personen</div>
	            </div>
	          </div>
	        </div>
	        <div class="col-xl-3 col-sm-6 mb-3">
	          <div class="card text-white bg-danger o-hidden h-100">
	            <div class="card-body">
	              <div class="card-body-icon">
	                <i class="fas fa-skull-crossbones"></i>
	              </div>
	              <div class="mr-5"><h4><?php echo $row["dead"]; ?></h4> verstorbene Personen</div>
	            </div>
	          </div>
	        </div>
	      </div>
		  </div>
			<div class="container">
				<div class="row">
					
					<div class="col-12 orientation-warning">
						<div class="card mb-3">
							<div class="card-body">
								<img src="port2land.png" width="90%">
								<h3>Um die Statistiken besser lesen zu können, drehen Sie Ihr Gerät bitte horizontal.</h3>
							</div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="card mb-3">
							<div class="card-header">
								<i class="fas fa-chart-line"></i> Gesamt-Statistik
							</div>
							<div class="card-body">
								<small>Klicken Sie auf die Beschreibung um die Linie zu verstecken. / Click on the description to hide the line.</small>
								<canvas id="totalChart" width="100%"></canvas>
							</div>
							<div class="card-footer small text-muted">Stand: <?php echo date("d.m.Y H:i", $row["timestamp"]); ?> &bull; Aktualisiert: <?php echo date("d.m.Y H:i:s", $last_update); ?></div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="card mb-3">
							<div class="card-header">
								<i class="fas fa-chart-line"></i> Infiziert-Statistik
							</div>
							<div class="card-body">
								<canvas id="infectedChart" width="100%"></canvas>
							</div>
							<div class="card-footer small text-muted">Stand: <?php echo date("d.m.Y H:i", $row["timestamp"]); ?> &bull; Aktualisiert: <?php echo date("d.m.Y H:i:s", $last_update); ?></div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="card mb-3">
							<div class="card-header">
								<i class="fas fa-chart-line"></i> Genesen-Statistik
							</div>
							<div class="card-body">
								<canvas id="recoveredChart" width="100%"></canvas>
							</div>
							<div class="card-footer small text-muted">Stand: <?php echo date("d.m.Y H:i", $row["timestamp"]); ?> &bull; Aktualisiert: <?php echo date("d.m.Y H:i:s", $last_update); ?></div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="card mb-3">
							<div class="card-header">
								<i class="fas fa-chart-line"></i> Verstorben-Statistik
							</div>
							<div class="card-body">
								<canvas id="deadChart" width="100%"></canvas>
							</div>
							<div class="card-footer small text-muted">Stand: <?php echo date("d.m.Y H:i", $row["timestamp"]); ?> &bull; Aktualisiert: <?php echo date("d.m.Y H:i:s", $last_update); ?></div>
						</div>
					</div>
					
					<div class="col-12">
					  <div class="card mb-3">
							<div class="card-header">
								<i class="fas fa-list-ol"></i> Bezirke (TOP 5)
							</div>
							<div class="card-body">
								<ul class="list-group">
      					  <?php
      					    $result = $mysqli->query("SELECT districts_infected.*, districts.Bezirk FROM districts_infected LEFT JOIN districts ON districts_infected.GKZ = districts.GKZ WHERE timestamp = (SELECT MAX(timestamp) FROM districts_infected) ORDER BY number DESC LIMIT 0,5");
      					    while($row = $result->fetch_assoc()){
      					      $timestamp = $row["timestamp"];
      					      echo "<li class=\"list-group-item d-flex justify-content-between align-items-center\">";
      					      echo $row["Bezirk"]." <span class=\"badge badge-primary badge-pill\">".$row["number"]."</span>";
      					      echo "</li>";
      					    }
      					  ?>
                </ul>
							</div>
							<div class="card-footer small text-muted">Stand: <?php echo date("d.m.Y H:i", $timestamp); ?> &bull; Aktualisiert: <?php echo date("d.m.Y H:i:s", $last_update); ?></div>
						</div>
					</div>
				</div>
			</div>
		</main>
		
		<footer class="footer mt-auto py-3">
      <div class="container">
        <span class="text-muted">
          <a href="https://www.data.gv.at/covid-19/" target="_blank">Quelle: data.gv.at</a> &bull; 
          <a href="https://github.com/fellwell5/covid19AT" target="_blank"><i class="fab fa-github" title="Github"></i> fellwell5/covid19AT</a> &bull; 
          <img src="https://healthchecks.io/badge/398fe207-255b-43fd-9f63-bb488c/aAz0uawd.svg" title="Healthcheck" /> &bull; 
          Version: <?php echo $version; ?>
        </span>
      </div>
    </footer>
		
		<script src="js/Chart.bundle.min.js"></script>
		<script>
			<?php
				$totalChart = [];
				$result = $mysqli->query("SELECT * FROM `total` ORDER BY `timestamp` ASC");
				while($row = $result->fetch_assoc()){
					$totalChart["label"][] = date("d.m.Y H:i", $row["timestamp"]);
					foreach($row as $key => $value){
						$totalChart[$key][] = $value;
					}
				}
			?>
      var ctx = document.getElementById("totalChart");
      var totalChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($totalChart["label"]); ?>,
          datasets: [{
            label: "getestet",
            backgroundColor: "rgba(0,123,255,0.2)",
            borderColor: "rgb(0,123,255)",
            data: <?php echo json_encode($totalChart["tested_persons"]); ?>
          },{
            label: "infiziert",
            backgroundColor: "rgba(255,193,7,0.2)",
            borderColor: "rgb(255,193,7)",
            data: <?php echo json_encode($totalChart["infected"]); ?>
          },
          {
            label: "erkrankt",
            backgroundColor: "rgba(201,203,207,0.2)",
            borderColor: "rgb(201,203,207)",
            data: <?php echo json_encode($totalChart["currently_sick"]); ?>
          },
          {
            label: "genesen",
            backgroundColor: "rgba(40,167,69,0.2)",
            borderColor: "rgb(40,167,69)",
            data: <?php echo json_encode($totalChart["recovered"]); ?>
          },
          {
            label: "verstorben",
            backgroundColor: "rgba(220,53,69,0.2)",
            borderColor: "rgb(220,53,69)",
            data: <?php echo json_encode($totalChart["dead"]); ?>
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'time'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              },
              stacked: false
            }],
          },
          legend: {
            display: true
          },
          tooltips: {
            mode: "x"
          },
          elements: {
            line: {
              cubicInterpolationMode: 'monotone',
              lineTension: 0
            }
          }
        }
      });
		</script>
		<script>
			<?php
				$infectedChart = [];
				$result = $mysqli->query("SELECT * FROM `infected` ORDER BY `timestamp` ASC");
				while($row = $result->fetch_assoc()){
					$infectedChart["label"][] = date("d.m.Y H:i", $row["timestamp"]);
					foreach($row as $key => $value){
						$infectedChart[$key][] = $value;
					}
				}
			?>
      var infected = document.getElementById("infectedChart");
      var infectedChart = new Chart(infected, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($infectedChart["label"]); ?>,
          datasets: [{
            label: "Burgenland",
            borderColor: "rgb(131,205,227)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["b"]); ?>
          },{
            label: "Kärnten",
            borderColor: "rgb(178,204,75)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["k"]); ?>
          },
          {
            label: "Niederösterreich",
            borderColor: "rgb(167,220,244)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["n"]); ?>
          },
          {
            label: "Oberösterreich",
            borderColor: "rgb(243,161,128)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["o"]); ?>
          },
          {
            label: "Salzburg",
            borderColor: "rgb(249,155,78",
        		fill: false,
            data: <?php echo json_encode($infectedChart["s"]); ?>
          },
          {
            label: "Steiermark",
            borderColor: "rgb(215,226,153)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["st"]); ?>
          },
          {
            label: "Tirol",
            borderColor: "rgb(249,185,97)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["t"]); ?>
          },
          {
            label: "Vorarlberg",
            borderColor: "rgb(244,162,97)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["v"]); ?>
          },
          {
            label: "Wien",
            borderColor: "rgb(81,152,206)",
        		fill: false,
            data: <?php echo json_encode($infectedChart["w"]); ?>
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'time'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              },
              stacked: false
            }],
          },
          legend: {
            display: true
          },
          tooltips: {
            mode: "x"
          },
          elements: {
            line: {
              cubicInterpolationMode: 'monotone',
              lineTension: 0
            }
          }
        }
      });
		</script>
		<script>
			<?php
				$recoveredChart = [];
				$result = $mysqli->query("SELECT * FROM `recovered` ORDER BY `timestamp` ASC");
				while($row = $result->fetch_assoc()){
					$recoveredChart["label"][] = date("d.m.Y H:i", $row["timestamp"]);
					foreach($row as $key => $value){
						$recoveredChart[$key][] = $value;
					}
				}
			?>
      var recovered = document.getElementById("recoveredChart");
      var recoveredChart = new Chart(recovered, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($recoveredChart["label"]); ?>,
          datasets: [{
            label: "Burgenland",
            borderColor: "rgb(131,205,227)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["b"]); ?>
          },{
            label: "Kärnten",
            borderColor: "rgb(178,204,75)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["k"]); ?>
          },
          {
            label: "Niederösterreich",
            borderColor: "rgb(167,220,244)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["n"]); ?>
          },
          {
            label: "Oberösterreich",
            borderColor: "rgb(243,161,128)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["o"]); ?>
          },
          {
            label: "Salzburg",
            borderColor: "rgb(249,155,78",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["s"]); ?>
          },
          {
            label: "Steiermark",
            borderColor: "rgb(215,226,153)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["st"]); ?>
          },
          {
            label: "Tirol",
            borderColor: "rgb(249,185,97)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["t"]); ?>
          },
          {
            label: "Vorarlberg",
            borderColor: "rgb(244,162,97)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["v"]); ?>
          },
          {
            label: "Wien",
            borderColor: "rgb(81,152,206)",
        		fill: false,
            data: <?php echo json_encode($recoveredChart["w"]); ?>
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'time'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              },
              stacked: false
            }],
          },
          legend: {
            display: true
          },
          tooltips: {
            mode: "x"
          },
          elements: {
            line: {
              cubicInterpolationMode: 'monotone',
              lineTension: 0
            }
          }
        }
      });
		</script>
		<script>
			<?php
				$deadChart = [];
				$result = $mysqli->query("SELECT * FROM `dead` ORDER BY `timestamp` ASC");
				while($row = $result->fetch_assoc()){
					$deadChart["label"][] = date("d.m.Y H:i", $row["timestamp"]);
					foreach($row as $key => $value){
						$deadChart[$key][] = $value;
					}
				}
			?>
      var dead = document.getElementById("deadChart");
      var deadChart = new Chart(dead, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($deadChart["label"]); ?>,
          datasets: [{
            label: "Burgenland",
            borderColor: "rgb(131,205,227)",
        		fill: false,
            data: <?php echo json_encode($deadChart["b"]); ?>
          },{
            label: "Kärnten",
            borderColor: "rgb(178,204,75)",
        		fill: false,
            data: <?php echo json_encode($deadChart["k"]); ?>
          },
          {
            label: "Niederösterreich",
            borderColor: "rgb(167,220,244)",
        		fill: false,
            data: <?php echo json_encode($deadChart["n"]); ?>
          },
          {
            label: "Oberösterreich",
            borderColor: "rgb(243,161,128)",
        		fill: false,
            data: <?php echo json_encode($deadChart["o"]); ?>
          },
          {
            label: "Salzburg",
            borderColor: "rgb(249,155,78",
        		fill: false,
            data: <?php echo json_encode($deadChart["s"]); ?>
          },
          {
            label: "Steiermark",
            borderColor: "rgb(215,226,153)",
        		fill: false,
            data: <?php echo json_encode($deadChart["st"]); ?>
          },
          {
            label: "Tirol",
            borderColor: "rgb(249,185,97)",
        		fill: false,
            data: <?php echo json_encode($deadChart["t"]); ?>
          },
          {
            label: "Vorarlberg",
            borderColor: "rgb(244,162,97)",
        		fill: false,
            data: <?php echo json_encode($deadChart["v"]); ?>
          },
          {
            label: "Wien",
            borderColor: "rgb(81,152,206)",
        		fill: false,
            data: <?php echo json_encode($deadChart["w"]); ?>
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'time'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              },
              stacked: false
            }],
          },
          legend: {
            display: true
          },
          tooltips: {
            mode: "x"
          },
          elements: {
            line: {
              cubicInterpolationMode: 'monotone',
              lineTension: 0
            }
          }
        }
      });
		</script>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56491949-5"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		
		  gtag('config', 'UA-56491949-5');
		</script>
	</body>
</html>