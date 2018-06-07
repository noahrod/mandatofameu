<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Correos</h3> 
	</div>
	<div class="panel-body">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoCorreo">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
		<button type="button" class="btn btn-info" onclick="opengeneradordecorreos();">Generar <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>
		<br><br>
		<?php
			include "connect.php";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT correos.id,correos.numerodecorreo,correos.fecha,correos.consulado,consulados.ubicacion FROM `correos` 
				LEFT JOIN consulados on consulados.id = correos.consulado order by correos.id desc;";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Número de correo</th>
					<th>Fecha de envío de correo</th>
					<th>Destinatario</th>
					<th>Oficio</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["numerodecorreo"]."</td>";
					echo "<td>".$row["fecha"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td><a target=_blank href='downloadcorreo.php?id=".$row["id"]."'>".$row["numerodecorreo"].".pdf</a></td>";
					echo '<td><button type="button" class="btn btn-default" onclick="editCorreo(\''.$row["id"].'\',\''.$row["numerodecorreo"].'\',\''.$row["fecha"].'\',\''.$row["consulado"].'\');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen correos en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
	</div>
</div>


<div class="modal fade" id="myModalNuevoCorreo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Correo</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevocorreo" enctype="multipart/form-data" method="post" action="addcorreo.php">
				<div class="form-group">
				    <label for="labelnumerodecorreo">Número de correo</label>
				    <input type="text" class="form-control" name="numerodecorreo" id="numerodecorreo" placeholder="Número de correo">
				</div>
				<div class="form-group">
				    <label for="labelfechadecorreo">Fecha de envío de correo</label>
				    <input type="text" class="form-control" name="fechadecorreo" id="fechadecorreo" placeholder="Fecha de envío de correo">
			  	</div>
			  	<div class="form-group">
				    <label for="labelconsuladocorreo">Consulado</label>
				    <select class="form-control" name="consuladocorreo" id="consuladocorreo">
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
				    <label for="exampleInputFile">Escaneo del Correo</label>
				    <input type="file" id="imagencorreo" name="imagencorreo">
				    <p class="help-block">En formato *.pdf</p>
			  	</div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertCorreo();">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModalEditCorreo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Correo</h4>
      </div>
      <div class="modal-body">
			<form id="formeditcorreo" enctype="multipart/form-data" method="post" action="updatecorreo.php">
				<div class="form-group">
				    <label for="labelnumerodecorreo">Número de correo</label>
				    <input type="text" class="form-control" name="editnumerodecorreo" id="editnumerodecorreo" placeholder="Número de correo">
				</div>
				<div class="form-group">
				    <label for="labelfechadecorreo">Fecha de envío de correo</label>
				    <input type="text" class="form-control" name="editfechadecorreo" id="editfechadecorreo" placeholder="Fecha de envío de correo">
			  	</div>
			  	<div class="form-group">
				    <label for="labelconsuladocorreo">Consulado</label>
				    <select class="form-control" name="editconsuladocorreo" id="editconsuladocorreo">
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
				    <label for="exampleInputFile">Escaneo del Correo</label>
				    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfileanchor"></a>
			    	<br>
			    	<br>
				    <input type="file" id="editimagencorreo" name="editimagencorreo">
				    <p class="help-block">En formato *.pdf</p>
			  	</div>
			  	<input type="hidden" id="cid" name="cid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateCorreo();">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	function opengeneradordecorreos(){
	  $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
	  $.ajax({
	    method: "POST",
	    url: "generadordecorreos.php"
	  })
	    .done(function( msg ) {
	      $("#sitecontent").html(msg);
	  });
	}
	$( function() {
    	$( "#fechadecorreo" ).datepicker();
    	$( "#editfechadecorreo" ).datepicker();
  	} );
</script>
