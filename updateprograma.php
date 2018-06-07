<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editnombredelprograma"] != "" && $_POST["proid"] != ""){
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql_insert = "UPDATE `programas` SET `programa` = '".$_POST["editnombredelprograma"]."' WHERE `programas`.`id` = ".$_POST["proid"].";";
	$conn->query($sql_insert);
	header("Location: system.php?l=programas");
}
?>