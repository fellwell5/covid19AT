<?php
	$mysqli = new mysqli("", "", "", "");
  if ($mysqli->connect_errno) {
      printf("Connect failed: %s\n", $mysqli->connect_error);
      exit();
  }
  mysqli_set_charset($mysqli,"utf8");