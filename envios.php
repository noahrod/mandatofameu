<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Envíos</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoEnvio">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button><br><br>
		<?php
			if($_GET["start"] != ""){
				$my_from = $_GET["start"];
			}else{
				$my_from = 0;
			}
			include "connect.php";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT id,destino,fechadeenvio,tracking,cheque,status FROM `envios` order by status ASC, id desc  LIMIT ".$my_from.",20";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Cheque</th>
					<th>Cheque escaneado</th>
					<th>Destino</th>
					<th>Etiqueta escaneada</th>
					<th>Fecha de envío</th>
					<th>Tracking</th>
					<th>Status</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					if(substr($row["destino"],0,1) == "c"){
						$connc1 = new mysqli($servername, $username, $password, $dbname);
						if ($connc1->connect_error) {
						    die("Connection failed: " . $connc1->connect_error);
						}
						$sqlc1 = "SELECT ubicacion FROM `consulados` WHERE id=" . substr($row["destino"],1);
						$resultc1 = $connc1->query($sqlc1);
						$rowc1 = $resultc1->fetch_assoc();
						echo "<tr>";
						echo "<td>".$row["id"]."</td>";
						$lospedazos = explode(",", $row["cheque"]);
						echo "<td >";
						foreach ($lospedazos as $elpedazo) {
							echo $elpedazo . "<br>";
						}
						echo "</td >";
						echo "<td><a style='word-break: break-all;' target=_blank href='downloadcheque.php?id=".$row["id"]."'>Cheque".$row["cheque"].".pdf</a></td>";
						echo "<td>".$rowc1["ubicacion"]."</td>";
						echo "<td><a style='word-break: break-all;' target=_blank href='downloadetiqueta.php?id=".$row["id"]."'>EtiquetaCheque".$row["cheque"].".pdf</a></td>";
						echo "<td>".$row["fechadeenvio"]."</td>";
						echo "<td><a style='word-break: break-all;' target=_blank href='https://tools.usps.com/go/TrackConfirmAction?tRef=fullpage&tLc=2&text28777=&tLabels=".$row["tracking"]."%2C'>".$row["tracking"]."<a></td>";
						if($row["status"] == 0){
							echo '<td><button type="button" class="btn btn-default" onclick="toggleenvio(\''.$row["id"].'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></td>';
						}else{
							if($row["status"] == 1){
								echo '<td><button type="button" class="btn btn-success" onclick="toggleenvio(\''.$row["id"].'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></td>';
							}
						}
						echo '<td><button type="button" class="btn btn-default" onclick="editEnvio(\''.$row["id"].'\',\''.$row["cheque"].'\',\''.$row["destino"].'\',\''.$row["fechadeenvio"].'\',\''.$row["tracking"].'\');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
						
						echo "</tr>";
						$connc1->close();
					}else{
						if(substr($row["destino"],0,1) == "p"){
							$connc2 = new mysqli($servername, $username, $password, $dbname);
							if ($connc2->connect_error) {
							    die("Connection failed: " . $connc2->connect_error);
							}
							$sqlc2 = "SELECT nombreproveedor FROM `proveedores` WHERE id=" . substr($row["destino"],1);
							$resultc2 = $connc2->query($sqlc2);
							$rowc2 = $resultc2->fetch_assoc();
							echo "<tr>";
							echo "<td>".$row["id"]."</td>";
							echo "<td>".$row["cheque"]."</td>";
							echo "<td><a target=_blank href='downloadcheque.php?id=".$row["id"]."'>Cheque".$row["cheque"].".pdf</a></td>";
							echo "<td>".$rowc2["nombreproveedor"]."</td>";
							echo "<td><a target=_blank href='downloadetiqueta.php?id=".$row["id"]."'>EtiquetaCheque".$row["cheque"].".pdf</a></td>";
							echo "<td>".$row["fechadeenvio"]."</td>";
							echo "<td><a target=_blank href='https://tools.usps.com/go/TrackConfirmAction?tRef=fullpage&tLc=2&text28777=&tLabels=".$row["tracking"]."%2C'>".$row["tracking"]."<a></td>";
							if($row["status"] == 0){
								echo '<td><button type="button" class="btn btn-default" onclick="toggleenvio(\''.$row["id"].'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></td>';
							}else{
								if($row["status"] == 1){
									echo '<td><button type="button" class="btn btn-success" onclick="toggleenvio(\''.$row["id"].'\')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></td>';
								}
							}
							echo '<td><button type="button" class="btn btn-default" onclick="editEnvio(\''.$row["id"].'\',\''.$row["cheque"].'\',\''.$row["destino"].'\',\''.$row["fechadeenvio"].'\',\''.$row["tracking"].'\');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
							
							echo "</tr>";
							$connc2->close();
						}
					}
				}
			}else{
				echo "<tr><td>No existe envíos en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
		<?php
			include "connect.php";
			$conn1 = new mysqli($servername, $username, $password, $dbname);
			if ($conn1->connect_error) {
			    die("Connection failed: " . $conn1->connect_error);
			}
			$sql_paginacion = "select * from envios";
			$condecontar = $conn1->query($sql_paginacion);
			$cuantas_paginas = ceil ($condecontar->num_rows / 20);
			echo '<br><center>
				<nav>
				  <ul class="pagination">';

			if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
			if($my_from ==0){
				echo '
				    <li class="disabled">
				      <a href="system.php" aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				      </a>
				    </li>';
			}else{

				echo '
				    <li>
				      <a href="#" onclick="loadEnvios(\''.($my_from-20).'\')" aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				      </a>
				    </li>';
			}

		    
			$s =0;
			for ($i=1; $i < $cuantas_paginas+1; $i++){ 
				if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
				if($my_from == $s){ echo "<li class='active'><a href='#' onclick='loadEnvios(\"".$s."\")'>".$i."</a></li>";}
				else{ echo "<li><a href='#' onclick='loadEnvios(\"".$s."\")'>".$i."</a></li>";}
				$s= $s + 20;
			}

			if(($my_from + 20) > $condecontar->num_rows){
				echo "  <li class='disabled'>
					      <a href='system.php' aria-label='Next'>
					        <span aria-hidden='true'>&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
				</center><br><br>";
			}else{
				echo "  <li>
					      <a href='#' onclick='loadEnvios(\"".($my_from+20)."\")' aria-label='Next'>
					        <span aria-hidden='true'>&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
				</center><br><br>";
			 }
		?>
	</div>
</div>
<script>
  $( function() {
    $( "#fechadeenvio" ).datepicker();
    $( "#editfechadeenvio" ).datepicker();
  } );
  </script>

<div class="modal fade" id="myModalNuevoEnvio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Envío</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevoenvio" enctype="multipart/form-data" method="post" action="addenvio.php">
			  <div class="form-group">
			    <label for="exampleInputFile">Cheque(s) <button type="button" class="btn btn-success" onclick="addenviochequelist();">+</button>&nbsp;<button type="button" class="btn btn-success" onclick="removelastenviochequelist();">-</button></label>
			    <input type="hidden" id="chequesenvio" name="chequesenvio" value="">
			    <select class="form-control" name="chequesenvio1" id="chequesenvio1">
			    <option></option>
				  <?php
				  	/*include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT numerodecheque FROM `cheques`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='".$row1["numerodecheque"]."'>".$row1["numerodecheque"]."</option>";
						}
					}else{
						echo "<option>Aún no hay cheques dados de alta.</option>";
					}
				  	$conn1->close();*/
				  ?>
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
				</select>
				<div id="listchequesenvio">
				  	
				  </div>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputFile">Escaneo del(los) cheque(s)</label>
			    <input type="file" id="imagencheque" name="imagencheque">
			    <p class="help-block">En formato *.pdf</p>
			  </div>
			  <div class="form-group">
			    <label for="labelingresos">Destino</label>
			    <select class="form-control" name="destino" id="destino">
			    <option></option>
			    <option>-- CONSULADOS --</option>
				  <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT id,ubicacion FROM `consulados`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='c".$row1["id"]."'>Consulmex ".$row1["ubicacion"]."</option>";
						}
					}
				  	$conn1->close();
				  ?>
				  <option></option>
			    <option>-- PROOVEDORES --</option>
			    <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT id,nombreproveedor FROM `proveedores`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='p".$row1["id"]."'>".$row1["nombreproveedor"]."</option>";
						}
					}
				  	$conn1->close();
				  ?>
				</select>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputFile">Escaneo de la etiqueta</label>
			    <input type="file" id="imagenetiqueta" name="imagenetiqueta">
			    <p class="help-block">En formato *.pdf</p>
			  </div>
			  <div class="form-group">
			    <label for="labelfechadesolicitud">Fecha de envío</label>
			    <input type="text" class="form-control" name="fechadeenvio" id="fechadeenvio" placeholder="Fecha de envío">
			  </div>
			  <div class="form-group">
			    <label for="labelfechadesolicitud">Tracking #</label>
			    <input type="text" class="form-control" name="tracking" id="tracking" placeholder="Tracking #">
			  </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertEnvio();">Agregar</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="myModalEditEnvio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Envío</h4>
      </div>
      <div class="modal-body">
			<form id="formeditenvio" enctype="multipart/form-data" method="post" action="updateenvio.php">
			  <div class="form-group">
			    <label for="exampleeditInputFile">Cheque(s) <button type="button" class="btn btn-success" onclick="addenviochequelistedit();">+</button>&nbsp;<button type="button" class="btn btn-success" onclick="removelastenviochequelistedit();">-</button></label>
			    <input type="hidden" id="editchequesenvio" name="editchequesenvio" value="">
			    <select class="form-control" name="editchequesenvio1" id="editchequesenvio1">
			    <option></option>
				  <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT numerodecheque FROM `cheques`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='".$row1["numerodecheque"]."'>".$row1["numerodecheque"]."</option>";
						}
					}else{
						echo "<option>Aún no hay cheques dados de alta.</option>";
					}
				  	$conn1->close();
				  ?>
				</select>
				<div id="editlistchequesenvio">
				  
				  </div>
			  </div>
			  <div class="form-group">
			    <label for="exampleeditInputFile">Escaneo del(los) cheque(s)</label>
			    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfilecheque"></a>
			    <br>
			    <br>
			    <input type="file" id="editimagencheque" name="editimagencheque">
			    <p class="help-block">En formato *.pdf</p>
			  </div>
			  <div class="form-group">
			    <label for="labeleditingresos">Destino</label>
			    <select class="form-control" name="editdestino" id="editdestino">
			    <option></option>
			    <option>-- CONSULADOS --</option>
				  <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT id,ubicacion FROM `consulados`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='c".$row1["id"]."'>Consulmex ".$row1["ubicacion"]."</option>";
						}
					}
				  	$conn1->close();
				  ?>
				  <option></option>
			    <option>-- PROOVEDORES --</option>
			    <?php
				  	include "connect.php";
					$conn1 = new mysqli($servername, $username, $password, $dbname);
					if ($conn1->connect_error) {
					    die("Connection failed: " . $conn1->connect_error);
					}
					$sql1 = "SELECT id,nombreproveedor FROM `proveedores`";
					$result1 = $conn1->query($sql1);
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<option value='p".$row1["id"]."'>".$row1["nombreproveedor"]."</option>";
						}
					}
				  	$conn1->close();
				  ?>
				</select>
			  </div>
			  <div class="form-group">
			    <label for="exampleeditInputFile">Escaneo de la etiqueta</label>
			    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfileetiqueta"></a>
			    <br>
			    <br>
			    <input type="file" id="editimagenetiqueta" name="editimagenetiqueta">
			    <p class="help-block">En formato *.pdf</p>
			  </div>
			  <div class="form-group">
			    <label for="labeleditfechadesolicitud">Fecha de envío</label>
			    <input type="text" class="form-control" name="editfechadeenvio" id="editfechadeenvio" placeholder="Fecha de envío">
			  </div>
			  <div class="form-group">
			    <label for="labeleditfechadesolicitud">Tracking #</label>
			    <input type="text" class="form-control" name="edittracking" id="edittracking" placeholder="Tracking #">
			  </div>
			  <input type="hidden" id="enid" name="enid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateEnvio();">Actualizar</button>
      </div>
    </div>
  </div>
</div>