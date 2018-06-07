<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if($_SESSION["leuid"] != ""){
	header("Location: system.php");
}
include "connect.php";
if($_POST["username"] != "" && $_POST["password"] != ""){
	$sql = "select * from usuarios where username = '".$_POST["username"]."' and password = '".md5($_POST["password"])."';";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
	        $_SESSION["leuid"] = $row["id"];
	        $_SESSION["leusername"] = $_POST["username"];
          $_SESSION["lename"] = $row["nombre"] ." " .$row["apellido"];
	    	header("Location: system.php");    
	    }
	} else {
	    header("Location: index.php?e=1");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Directorio Consulmex Milwaukee">
    <meta name="author" content="Noé Rodríguez Castro">
    <!-- Bootstrap core CSS -->
    <title>Mandato FAMEU</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="system.css" rel="stylesheet">
  </head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Mandato FAMEU</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
 <div class="container">
  <div class="starter-template">
	  <div class="container">
			<div class="login-container">
		            <?php
						if($_GET["e"] == 1){
							echo '<div id="output" class="alert alert-danger animated fadeInUp">Nombre de Usuario o Contraseña Incorrecta</div>';
						}else{
							echo '<div id="output"></div>';
						}
					?>
		            <div class="avatar"></div>
		            <div class="form-box">
		                <form action="index.php" method="post" id="login_form">
		                    <input name="username" type="text" placeholder="nombre de usuario">
		                    <input name="password" type="password" placeholder="contraseña">
		                    <button class="btn btn-info btn-block login" type="submit">Ingresar</button>
		                </form>
		            </div>
		        </div>
		        
		</div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="sitejs.js"></script>
<script type="text/javascript">
$(function(){
var username = $("input[name=username]");
var password = $("input[name=password]");
            $('button[type="submit"]').click(function(e) {
                e.preventDefault();
                //little validation just to check username
                if (username.val() != "") {
                    if (password.val() != "") {
                        $("#login_form").submit();
                    } else {
                        //remove success mesage replaced with error message
                        $("#output").removeClass(' alert alert-success');
                        $("#output").addClass("alert alert-danger animated fadeInUp").html("Ingrese una contraseña");
                    }
                    
                } else {
                    //remove success mesage replaced with error message
                    $("#output").removeClass(' alert alert-success');
                    $("#output").addClass("alert alert-danger animated fadeInUp").html("Ingrese un nombre usuario");
                }

                //console.log(textfield.val());

            });
});
</script>
</body>
</html>