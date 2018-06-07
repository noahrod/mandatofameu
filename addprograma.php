<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["nombredelprograma"] != ""){
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql_insert = "INSERT INTO `programas` (`id`, `programa`) VALUES (NULL, '".$_POST["nombredelprograma"]."');";
	$conn->query($sql_insert);
	header("Location: system.php?l=programas&ev=newsuccessPrograma");
}
?>