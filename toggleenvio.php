<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] == ""){
	header("Location: index.php");
}
include "connect.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql_insert = "UPDATE `envios` SET `status` = !status where id=".$_GET['id'];
$conn->query($sql_insert);
header("Location: system.php?l=envios");

?>