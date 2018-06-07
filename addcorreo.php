<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
if($_POST["numerodecorreo"] != "" && $_POST["fechadecorreo"] != "" && $_POST["consuladocorreo"] != ""){
	if(count($_FILES) > 0) {
		if(is_uploaded_file($_FILES['imagencorreo']['tmp_name'])) {
			$imgData =addslashes(file_get_contents($_FILES['imagencorreo']['tmp_name']));
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql_insert = "INSERT INTO `correos` (`id`,`numerodecorreo`,`fecha`,`consulado`,`correo`) VALUES (NULL,'".$_POST["numerodecorreo"]."','".$_POST["fechadecorreo"]."','".$_POST["consuladocorreo"]."','".$imgData."')";
			$conn->query($sql_insert);
			header("Location: system.php?l=correos&ev=newsuccessCorreo");
		}
	}
}
?>