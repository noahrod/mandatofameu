<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editnumerodeoficio"] != "" && $_POST["editfechadeoficio"] != "" && $_POST["editconsuladooficio"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['editimagenoficio']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['editimagenoficio']['tmp_name']));
			$sql_insert = "UPDATE `oficios` SET `numerodeoficio` = '".$_POST["editnumerodeoficio"]."', `fecha` = '".$_POST["editfechadeoficio"]."', `consulado` = '".$_POST["editconsuladooficio"]."', `oficio` = '".$imgData."' WHERE `oficios`.`id` = " . $_POST["oid"];
		}else{
			$sql_insert = "UPDATE `oficios` SET `numerodeoficio` = '".$_POST["editnumerodeoficio"]."', `fecha` = '".$_POST["editfechadeoficio"]."', `consulado` = '".$_POST["editconsuladooficio"]."' WHERE `oficios`.`id` = " . $_POST["oid"];
		}
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=oficios");
	}
}
?>