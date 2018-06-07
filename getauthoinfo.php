<?php
include "connect.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT autorizaciones.fechadesolicitud,autorizaciones.numerodecorreo FROM autorizaciones WHERE id = ".$_POST["autorizacion"];
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$valchqu =  $row["numerodecorreo"] . " | ". date("d/m/Y", strtotime($row["fechadesolicitud"]));

echo "<input type='hidden' value='".$valchqu."' id='aut".$_POST["varnumba"]."' name='aut".$_POST["varnumba"]."'>";

$leunique = uniqid("aut");

echo "<div id='".$leunique."'>".$valchqu ."&nbsp;<span class='glyphicon glyphicon-remove-circle' aria-hidden='true' onclick='removedaaut(\"".$leunique."\");removedaaut(\"aut".$_POST["varnumba"]."\");'></span></div>";
?>