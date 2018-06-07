<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Cónsules</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoConsul">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button><br><br>
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
			$sql = "SELECT consules.id, consules.consulado, consulados.ubicacion, consules.consul, consules.cargo, consules.tipodeconsulado FROM consules LEFT JOIN consulados on consules.consulado = consulados.id
				LIMIT ".$my_from.",20";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Ubicación</th>
					<th>Cónsul</th>
					<th>Cargo</th>
					<th>Tipo de Consulado</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td>".$row["consul"]."</td>";
					echo "<td>".$row["cargo"]."</td>";
					echo "<td>".$row["tipodeconsulado"]."</td>";
					echo '<td><button type="button" class="btn btn-default" onclick="editConsul(\''.$row["id"].'\',\''.$row["consulado"].'\',\''.$row["consul"].'\',\''.$row["cargo"].'\',\''.$row["tipodeconsulado"].'\')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
					</td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen Cónsules en el sistema.</td></tr>";
			}
			echo '</table>';
		?>

<?php
	include "connect.php";
	$conn1 = new mysqli($servername, $username, $password, $dbname);
	if ($conn1->connect_error) {
	    die("Connection failed: " . $conn1->connect_error);
	}
	$sql_paginacion = "select * from consules";
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
		      <a href="#" onclick="loadConsules(\''.($my_from-20).'\')" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>';
	}

    
	$s =0;
	for ($i=1; $i < $cuantas_paginas+1; $i++){ 
		if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
		if($my_from == $s){ echo "<li class='active'><a href='#' onclick='loadConsules(\"".$s."\")'>".$i."</a></li>";}
		else{ echo "<li><a href='#' onclick='loadConsules(\"".$s."\")'>".$i."</a></li>";}
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
			      <a href='#' onclick='loadConsules(\"".($my_from+20)."\")' aria-label='Next'>
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
  </script>

<div class="modal fade" id="myModalNuevoConsul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Cónsul</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevoconsul" method="post" action="addconsul.php">
				<div class="form-group">
				    <label for="labelconsuladoconsul">Consulado</label>
				    <select class="form-control" name="consuladoconsul" id="consuladoconsul">
					  <option></option>
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
								echo "<option value='".$row1["id"]."'>".$row1["ubicacion"]."</option>";
							}
						}else{
							echo "<option>"."No hay consulados dados de alta."."</option>";	
						}
					  	
					  ?>
					</select>
			  </div>
			  <div class="form-group">
			    <label for="labelconsul">Cónsul</label>
			    <input type="text" class="form-control" name="consul" id="consul" placeholder="Cónsul">
			 </div>
			 <div class="form-group">
			    <label for="labelcargo">Cargo</label>
			    <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Cargo">
			 </div>
			 <div class="form-group">
			    <label for="labeltipodeconsulado">Tipo de Consulado</label>
			    <input type="text" class="form-control" name="tipodeconsulado" id="tipodeconsulado" placeholder="Tipo de Consulado">
			 </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertConsul();">Agregar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalEditConsul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Consulado</h4>
      </div>
      <div class="modal-body">
			<form id="formeditconsul" method="post" action="updateconsul.php">
			  <div class="form-group">
				    <label for="labeleditconsuladoconsul">Consulado</label>
				    <select class="form-control" name="editconsuladoconsul" id="editconsuladoconsul">
					  <option></option>
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
								echo "<option value='".$row1["id"]."'>".$row1["ubicacion"]."</option>";
							}
						}else{
							echo "<option>"."No hay consulados dados de alta."."</option>";	
						}
					  	
					  ?>
					</select>
			  </div>
			  <div class="form-group">
			    <label for="labeleditconsul">Cónsul</label>
			    <input type="text" class="form-control" name="editconsul" id="editconsul" placeholder="Cónsul">
			 </div>
			 <div class="form-group">
			    <label for="labeleditcargo">Cargo</label>
			    <input type="text" class="form-control" name="editcargo" id="editcargo" placeholder="Cargo">
			 </div>
			 <div class="form-group">
			    <label for="labeledittipodeconsulado">Tipo de Consulado</label>
			    <input type="text" class="form-control" name="edittipodeconsulado" id="edittipodeconsulado" placeholder="Tipo de Consulado">
			 </div>
			  <input type="hidden" id="coid" name="coid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateConsul();">Actualizar</button>
      </div>
    </div>
  </div>
</div>