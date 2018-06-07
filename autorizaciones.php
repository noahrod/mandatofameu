<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Autorizaciones</h3> 
	</div>
	<div class="panel-body">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevaAutorizacion">Nueva <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button><br><br>
		<?php
			include "connect.php";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT id,numerodecorreo,fechadesolicitud,ingresos FROM `autorizaciones` order by id desc";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Número de correo</th>
					<th>Fecha de solicitud</th>
					<th>Ingresos</th>
					<th>Autorización</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["numerodecorreo"]."</td>";
					echo "<td>".$row["fechadesolicitud"]."</td>";
					echo "<td>".number_format($row["ingresos"],2)."</td>";
					echo "<td><a target=_blank href='downloadauth.php?id=".$row["id"]."'>".$row["numerodecorreo"].".pdf</a></td>";
					echo '<td><button type="button" class="btn btn-default" onclick="editAuth(\''.$row["id"].'\',\''.$row["numerodecorreo"].'\',\''.$row["fechadesolicitud"].'\',\''.$row["ingresos"].'\');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen autorizaciones en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
	</div>
</div>
<script>
  $( function() {
    $( "#fechadesolicitud" ).datepicker();
	$( "#editfechadesolicitud" ).datepicker();
  } );
  </script>

<div class="modal fade" id="myModalNuevaAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Autorización</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevaautorizacion" enctype="multipart/form-data" method="post" action="addautorizacion.php">
			  <div class="form-group">
			    <label for="labelnumerodecorreo">Número de correo</label>
			    <input type="text" class="form-control" name="numerodecorreo" id="numerodecorreo" placeholder="Número de correo">
			  </div>
			  <div class="form-group">
			    <label for="labelfechadesolicitud">Fecha de solicitud</label>
			    <input type="text" class="form-control" name="fechadesolicitud" id="fechadesolicitud" placeholder="Fecha de solicitud">
			  </div>
			  <div class="form-group">
			    <label for="labelingresos">Ingresos</label>
			    <input type="text" class="form-control" name="ingresos" id="ingresos" placeholder="Ingresos">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputFile">Escaneo de la Autorización</label>
			    <input type="file" id="imagenautorizacion" name="imagenautorizacion">
			    <p class="help-block">En formato *.pdf</p>
			  </div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertAuth();">Agregar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalEditAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Autorización</h4>
      </div>
      <div class="modal-body">
			<form id="formeditautorizacion" enctype="multipart/form-data" method="post" action="updateautorizacion.php">
			  <div class="form-group">
			    <label for="labeleditnumerodecorreo">Número de correo</label>
			    <input type="text" class="form-control" name="editnumerodecorreo" id="editnumerodecorreo" placeholder="Número de correo">
			  </div>
			  <div class="form-group">
			    <label for="labeleditfechadesolicitud">Fecha de solicitud</label>
			    <input type="text" class="form-control" name="editfechadesolicitud" id="editfechadesolicitud" placeholder="Fecha de solicitud">
			  </div>
			  <div class="form-group">
			    <label for="labeleditingresos">Ingresos</label>
			    <input type="text" class="form-control" name="editingresos" id="editingresos" placeholder="Ingresos">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputeditFile">Escaneo de la Autorización</label>
			    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfileanchor"></a>
			    <br>
			    <br>
			    <input type="file" id="editimagenautorizacion" name="editimagenautorizacion">
			    <p class="help-block">En formato *.pdf</p>
			  </div>
			  <input type="hidden" id="aid" name="aid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateAuth();">Actualizar</button>
      </div>
    </div>
  </div>
</div>