<div class="panel panel-primary">
	<div class="panel-heading"> 
		<h3 class="panel-title">Oficios</h3> 
	</div>
	<div class="panel-body">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalNuevoOficio">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
		<button type="button" class="btn btn-info" onclick="opengeneradordeoficios();">Generar <span class="glyphicon glyphicon-file" aria-hidden="true"></span></button>
		<br><br>
		<?php
			include "connect.php";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT oficios.id,oficios.numerodeoficio,oficios.fecha,oficios.consulado,consulados.ubicacion FROM `oficios` 
				LEFT JOIN consulados on consulados.id = oficios.consulado order by oficios.id desc;";
			$result = $conn->query($sql);
			echo '<table class="table table-hover">';
			echo '<thead>
					<tr>
					<th>Id</th>
					<th>Número de oficio</th>
					<th>Fecha de oficio</th>
					<th>Destinatario</th>
					<th>Oficio</th>
					<th>Acción</th>
					</tr>
					</thead>';
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["numerodeoficio"]."</td>";
					echo "<td>".$row["fecha"]."</td>";
					echo "<td>".$row["ubicacion"]."</td>";
					echo "<td><a target=_blank href='downloadoficio.php?id=".$row["id"]."'>".$row["numerodeoficio"].".pdf</a></td>";
					echo '<td><button type="button" class="btn btn-default" onclick="editOficio(\''.$row["id"].'\',\''.$row["numerodeoficio"].'\',\''.$row["fecha"].'\',\''.$row["consulado"].'\');"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>No existen oficios en el sistema.</td></tr>";
			}
			echo '</table>';
		?>
	</div>
</div>


<div class="modal fade" id="myModalNuevoOficio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Oficio</h4>
      </div>
      <div class="modal-body">
			<form id="formnuevooficio" enctype="multipart/form-data" method="post" action="addoficio.php">
				<div class="form-group">
				    <label for="labelnumerodeoficio">Número de oficio</label>
				    <input type="text" class="form-control" name="numerodeoficio" id="numerodeoficio" placeholder="Número de oficio">
				</div>
				<div class="form-group">
				    <label for="labelfechadeoficio">Fecha de oficio</label>
				    <input type="text" class="form-control" name="fechadeoficio" id="fechadeoficio" placeholder="Fecha de oficio">
			  	</div>
			  	<div class="form-group">
				    <label for="labelconsuladooficio">Consulado</label>
				    <select class="form-control" name="consuladooficio" id="consuladooficio">
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
				    <label for="exampleInputFile">Escaneo del Oficio</label>
				    <input type="file" id="imagenoficio" name="imagenoficio">
				    <p class="help-block">En formato *.pdf</p>
			  	</div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertOficio();">Agregar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModalEditOficio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Oficio</h4>
      </div>
      <div class="modal-body">
			<form id="formeditoficio" enctype="multipart/form-data" method="post" action="updateoficio.php">
				<div class="form-group">
				    <label for="labelnumerodeoficio">Número de oficio</label>
				    <input type="text" class="form-control" name="editnumerodeoficio" id="editnumerodeoficio" placeholder="Número de oficio">
				</div>
				<div class="form-group">
				    <label for="labelfechadeoficio">Fecha de oficio</label>
				    <input type="text" class="form-control" name="editfechadeoficio" id="editfechadeoficio" placeholder="Fecha de oficio">
			  	</div>
			  	<div class="form-group">
				    <label for="labelconsuladooficio">Consulado</label>
				    <select class="form-control" name="editconsuladooficio" id="editconsuladooficio">
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
				    <label for="exampleInputFile">Escaneo del Oficio</label>
				    <br><span><b>Archivo Actual:</b></span> <a href="" target=_blank id="editfileanchor"></a>
			    	<br>
			    	<br>
				    <input type="file" id="editimagenoficio" name="editimagenoficio">
				    <p class="help-block">En formato *.pdf</p>
			  	</div>
			  	<input type="hidden" id="oid" name="oid" value="">
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="updateOficio();">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	function opengeneradordeoficios(){
	  $("#sitecontent").html("<img src='loader.gif' style='height: 50px;'/>");
	  $.ajax({
	    method: "POST",
	    url: "generadordeoficios.php"
	  })
	    .done(function( msg ) {
	      $("#sitecontent").html(msg);
	  });
	}

	$( function() {
    	$( "#fechadeoficio" ).datepicker();
    	$( "#editfechadeoficio" ).datepicker();
  	} );
</script>
