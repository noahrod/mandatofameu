<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Programas</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoPrograma">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button><br><br>
		<?php
			include "connect.php";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT * FROM `programas`";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Programa</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["programa"]."</td>";
					echo '<td><button type="button" class="btn btn-default" onclick="editPrograma(\''.$row["id"].'\',\''.$row["programa"].'\')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen programas en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
	</div>
</div>
<script>
  </script>

<div class="modal fade" id="myModalNuevoPrograma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Programa</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevoprograma" method="post" action="addprograma.php">
			  <div class="form-group">
			    <label for="labelnombredelprograma">Nombre del programa</label>
			    <input type="text" class="form-control" name="nombredelprograma" id="nombredelprograma" placeholder="Nombre del programa">
			  </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertPrograma();">Agregar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalEditPrograma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Programa</h4>
      </div>
      <div class="modal-body">
			<form id="formeditprograma" method="post" action="updateprograma.php">
			  <div class="form-group">
			    <label for="labeleditnombredelprograma">Nombre del programa</label>
			    <input type="text" class="form-control" name="editnombredelprograma" id="editnombredelprograma" placeholder="Nombre del programa">
			  </div>
			  <input type="hidden" id="proid" name="proid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updatePrograma();">Actualizar</button>
      </div>
    </div>
  </div>
</div>