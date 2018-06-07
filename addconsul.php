<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["consuladoconsul"] != "" && $_POST["consul"] != "" && $_POST["cargo"] != "" && $_POST["tipodeconsulado"] != ""){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$sql_insert = "INSERT INTO `consules` (`id`, `consulado`, `consul`, `cargo`, `tipodeconsulado`) VALUES (NULL, '".$_POST["consuladoconsul"]."', '".$_POST["consul"]."', '".$_POST["cargo"]."', '".$_POST["tipodeconsulado"]."');";
		$conn->query($sql_insert);
		header("Location: system.php?l=consules&ev=newsuccessConsul");
		
}
?>