<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["editnumerodecorreo"] != "" && $_POST["editfechadecorreo"] != "" && $_POST["editconsuladocorreo"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['editimagencorreo']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['editimagencorreo']['tmp_name']));
			$sql_insert = "UPDATE `correos` SET `numerodecorreo` = '".$_POST["editnumerodecorreo"]."', `fecha` = '".$_POST["editfechadecorreo"]."', `consulado` = '".$_POST["editconsuladocorreo"]."', `correo` = '".$imgData."' WHERE `correos`.`id` = " . $_POST["cid"];
		}else{
			$sql_insert = "UPDATE `correos` SET `numerodecorreo` = '".$_POST["editnumerodecorreo"]."', `fecha` = '".$_POST["editfechadecorreo"]."', `consulado` = '".$_POST["editconsuladocorreo"]."' WHERE `correos`.`id` = " . $_POST["cid"];
		}
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		$conn->query($sql_insert);
		header("Location: system.php?l=correos");
	}
}
?>