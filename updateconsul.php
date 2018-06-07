<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editconsuladoconsul"] != "" && $_POST["editconsul"] != "" && $_POST["editcargo"] != "" && $_POST["edittipodeconsulado"] != "" && $_POST["coid"] != "" ){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$sql_update = "UPDATE `consules` SET `consulado` = '".$_POST["editconsuladoconsul"]."', `consul` = '".$_POST["editconsul"]."', `cargo` = '".$_POST["editcargo"]."', `tipodeconsulado` = '".$_POST["edittipodeconsulado"]."' WHERE `consules`.`id` = '".$_POST["coid"]."';";
		$conn->query($sql_update);
		header("Location: system.php?l=consules");
		
}
?>