<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Consulados</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoConsulado">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button><br><br>
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
			$sql = "SELECT * FROM `consulados` LIMIT ".$my_from.",20";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Ubicación</th>
					<th>Dirección</th>
					<th>Teléfono</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td>CONSULADO DE MEXICO<br>".$row["calleynumero"]."<br>".$row["ciudad"].", ".$row["estado"]."<br>".$row["codigopostal"]." &nbsp;<button type='button' class='btn btn-default' onclick='copytoclipboard();'><span class='glyphicon glyphicon-copy' aria-hidden='true'></span></button></td>";
					echo "<td>".$row["telefono"]."</td>";
					echo '<td><button type="button" class="btn btn-default" onclick="editConsulado(\''.$row["id"].'\',\''.$row["ubicacion"].'\',\''.$row["calleynumero"].'\',\''.$row["ciudad"].'\',\''.$row["estado"].'\',\''.$row["codigopostal"].'\',\''.$row["telefono"].'\')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
					</td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen consulados en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
<?php
	include "connect.php";
	$conn1 = new mysqli($servername, $username, $password, $dbname);
	if ($conn1->connect_error) {
	    die("Connection failed: " . $conn1->connect_error);
	}
	$sql_paginacion = "select * from consulados";
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
		      <a href="#" onclick="loadConsulados(\''.($my_from-20).'\')" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>';
	}

    
	$s =0;
	for ($i=1; $i < $cuantas_paginas+1; $i++){ 
		if($_GET["start"] != ""){ $my_from = $_GET["start"]; }else{ $my_from = 0; }
		if($my_from == $s){ echo "<li class='active'><a href='#' onclick='loadConsulados(\"".$s."\")'>".$i."</a></li>";}
		else{ echo "<li><a href='#' onclick='loadConsulados(\"".$s."\")'>".$i."</a></li>";}
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
			      <a href='#' onclick='loadConsulados(\"".($my_from+20)."\")' aria-label='Next'>
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

<div class="modal fade" id="myModalNuevoConsulado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Consulado</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevoconsulado" method="post" action="addconsulado.php">
			  <div class="form-group">
			    <label for="labelubicacionconsulado">Ubicación</label>
			    <input type="text" class="form-control" name="ubicacionconsulado" id="ubicacionconsulado" placeholder="Nombre">
			  </div>
			  <div class="form-group">
			    <label for="labelcalleynumero">Calle y número</label>
			    <input type="text" class="form-control" name="calleynumero" id="calleynumero" placeholder="Calle y número">
			  </div>
			  <div class="form-group">
			    <label for="labelciudad">Ciudad</label>
			    <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Ciudad">
			  </div>
			  <div class="form-group">
			    <label for="labelciudad">Estado</label>
			    <input type="text" class="form-control" name="estado" id="estado" placeholder="Estado">
			  </div>
			  <div class="form-group">
			    <label for="labelcodigopostal">Código Postal</label>
			    <input type="text" class="form-control" name="codigopostal" id="codigopostal" placeholder="Código Postal">
			  </div>
			  <div class="form-group">
			    <label for="labeltelefono">Teléfono</label>
			    <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono">
			  </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertConsulate();">Agregar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalEditConsulado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Consulado</h4>
      </div>
      <div class="modal-body">
			<form id="formeditconsulado" method="post" action="updateconsulado.php">
			  <div class="form-group">
			    <label for="labeleditubicacionconsulado">Ubicación</label>
			    <input type="text" class="form-control" name="editubicacionconsulado" id="editubicacionconsulado" placeholder="Nombre">
			  </div>
			  <div class="form-group">
			    <label for="labeleditcalleynumero">Calle y número</label>
			    <input type="text" class="form-control" name="editcalleynumero" id="editcalleynumero" placeholder="Calle y número">
			  </div>
			  <div class="form-group">
			    <label for="labeleditciudad">Ciudad</label>
			    <input type="text" class="form-control" name="editciudad" id="editciudad" placeholder="Ciudad">
			  </div>
			  <div class="form-group">
			    <label for="labeleditestado">Estado</label>
			    <input type="text" class="form-control" name="editestado" id="editestado" placeholder="Estado">
			  </div>
			  <div class="form-group">
			    <label for="labeleditcodigopostal">Código Postal</label>
			    <input type="text" class="form-control" name="editcodigopostal" id="editcodigopostal" placeholder="Código Postal">
			  </div>
			  <div class="form-group">
			    <label for="labeledittelefono">Teléfono</label>
			    <input type="text" class="form-control" name="edittelefono" id="edittelefono" placeholder="Teléfono">
			  </div>
			  <input type="hidden" id="cid" name="cid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateConsulate();">Actualizar</button>
      </div>
    </div>
  </div>
</div>