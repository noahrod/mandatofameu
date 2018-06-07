<?php
include "connect.php";
$conn_get_all_sent_cheques = new mysqli($servername, $username, $password, $dbname);
if ($conn_get_all_sent_cheques->connect_error) {
    die("Connection failed: " . $conn_get_all_sent_cheques->connect_error);
}


$sql_get_all_sent_cheques = "SELECT cheque FROM `envios`";
$result_get_all_sent_cheques = $conn_get_all_sent_cheques->query($sql_get_all_sent_cheques);
$cheque_list = "";
if ($result_get_all_sent_cheques->num_rows > 0) {
	while ($row_get_all_sent_cheques = $result_get_all_sent_cheques->fetch_assoc()) {
		$cheque_list.= $row_get_all_sent_cheques["cheque"];
		$cheque_list.= ",";
	}
}
$cheque_list = substr($cheque_list, 0,-1);
$cheques_enviados = explode(",", $cheque_list);
$conn_get_all_sent_cheques->close();


$conn_todos_los_cheques = new mysqli($servername, $username, $password, $dbname);
if ($conn_todos_los_cheques->connect_error) {
    die("Connection failed: " . $conn_todos_los_cheques->connect_error);
}

$cheques_todos[] = array();

$sql_todos_los_cheques = "SELECT numerodecheque FROM `cheques`";
$result_todos_los_cheques = $conn_todos_los_cheques->query($sql_todos_los_cheques);
if ($result_todos_los_cheques->num_rows > 0) {
	while($row_todos_los_cheques = $result_todos_los_cheques->fetch_assoc()) {
		$cheques_todos[] = $row_todos_los_cheques["numerodecheque"];
	}
}
$conn_todos_los_cheques->close();
$cheques_sin_enviar = array_diff($cheques_todos,$cheques_enviados);
$ii = 0;
foreach ($cheques_sin_enviar as $cheque_sin_enviar) {
	if(!is_array($cheque_sin_enviar)){
		echo "<option value='".$cheque_sin_enviar."'>".$cheque_sin_enviar."</option>";
		$ii++;
	}
}
if($ii == 0){
	echo "<option>Aún no hay cheques listos para envío.</option>";
}
?>