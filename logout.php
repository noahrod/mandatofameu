<?php
session_start();
$_SESSION["leuid"] = "";
$_SESSION["leusername"] = "";
header("Location: index.php");
?>