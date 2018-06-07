<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Generador de Oficios</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.2.3/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }</style>
  <style>
    @font-face{ 
        font-family: 'SoberanaTextoRegular';
        src: url("fonts/soberanatextoregular.otf") format("opentype");
        }
    @font-face{ 
        font-family: 'SoberanaTextoBold';
        src: url("fonts/soberanatextobold.otf") format("opentype");
        }
    @font-face{ 
        font-family: 'SoberanaSansBold';
        src: url("fonts/soberanasansbold.otf") format("opentype");
        }
    @font-face{ 
        font-family: 'SoberanaSansRegular';
        src: url("fonts/soberanasansregular.otf") format("opentype");
        }
        body{
          font-family: 'SoberanaSansRegular';
        }
        table,th,td{
          border: 1px solid #000;
        }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm" style="background-image: url(fondo.png); background-size: cover; background-position: -20px -35px; ">
    <img src="logo.png" style="width: 250px;">
    <span style="float: right; font-size: 15px; font-weight: bold; font-family: 'SoberanaSansBold';">Consulado de México en Milwaukee</span>
    <br>
    <span style="float: right; font-size: 16px;">MKE-<?php echo $_POST["numerodeoficio"]; ?>/2018</span>
    <br>
    <?php
        $cortarfecha = explode("/", $_POST["fechadeoficio"]);
        $fechadeoficiofinal = $cortarfecha[1] ." de " . get_mes($cortarfecha[0]) . " de " . $cortarfecha[2];
    ?>
    <span style="float: right; font-size: 16px;">Milwaukee, WI., <?php echo $fechadeoficiofinal; ?></span>
    <br>
    <br>
    <table style="font-size: 10px; text-align: center; float: right; width: 310px;">
      <tr>
        <td colspan="2">INFORMACIÓN RESERVADA</td>
      </tr>
      <tr>
        <td>Fecha de clasificación:</td>
        <td><?php echo $fechadeoficiofinal; ?></td>
      </tr>
      <tr>
        <td>Unidad responsable:</td>
        <td>CONSULMEX MILWAUKEE</td>
      </tr>
      <tr>
        <td>Fundamento legal:</td>
        <td>LFTAIP Arts. 99 y 110</td>
      </tr>
      <tr>
        <td>Partes clasificadas:</td>
        <td>Todo el documento</td>
      </tr>
      <tr>
        <td>Rúbrica del titular de la <br>Unidad Administrativa</td>
        <td>Julián Adem Díaz de León<br>Cónsul Titular</td>
      </tr>  
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p>
    <?php
      include "connect.php";
      $connc = new mysqli($servername, $username, $password, $dbname);
      if ($connc->connect_error) {
          die("Connection failed: " . $connc->connect_error);
      }
      $sqlc = "select consules.consul,consules.cargo, consules.tipodeconsulado, consulados.ubicacion from consules
        left join consulados ON consules.consulado = consulados.id where consules.consulado=" . $_POST["consulado"];
      $resultc = $connc->query($sqlc);
      $rowc = $resultc->fetch_assoc();
      echo $rowc["consul"] . "<br>";
      echo $rowc["cargo"] . "<br>";
      echo $rowc["tipodeconsulado"] . "<br>";
    ?>
    </p>
    <?php
        include "connect.php";
            $conn0 = new mysqli($servername, $username, $password, $dbname);
            if ($conn0->connect_error) {
                die("Connection failed: " . $conn0->connect_error);
            }
            $sql0 = "SELECT numerodecorreo,fechadesolicitud FROM `autorizaciones` WHERE id=".$_POST["autorizacionoficio"];
            $result0 = $conn0->query($sql0);
            $row0 = $result0->fetch_assoc();
            $numerodeautorizacion = $row0["numerodecorreo"];
            $fechadesolicitudauth = $row0["fechadesolicitud"];
            $pedazos = explode("/", $fechadesolicitudauth);

            $conn0->close();
    ?>
    <p style="text-align: justify;">
      <?php
       $firstreplace =  str_replace("[[autorizacion]]", $numerodeautorizacion ,$_POST["correspondientesa"]); 
       $fechaffff =  $pedazos[1] . " de " . get_mes($pedazos[0]);
       echo str_replace("[[fechaautorizacion]]", $fechaffff ,$firstreplace); 
       ?>
    </p>
    <table style="width: 100%;">
      <tr style="text-align: center;">
        <td style="width: 440px !important;"><b>Proveedor</b></td>
        <td style="width: 85px !important;"><b>Número de Cheque</b></td>
        <td><b>Fecha de cheque</b></td>
        <td><b>Cantidad</b></td>
      </tr>
      <?php
        function get_count_proveedores(){
          $prov = 0;
          for($i = 1; $i<50; $i ++){
            if($_POST["ch" . $i] != ""){
              $prov++;
            }
          }
          return $prov;
        }

        if(get_count_proveedores() <= 4){
           $sumacheques = 0;
            for($i = 1; $i<50; $i ++){
              if($_POST["ch" . $i] != ""){
                $pedacin = explode("|", $_POST["ch" . $i]);
                echo '<tr style="text-align: center;">
                  <td style="text-align: left;">'.strtoupper($pedacin[0]).'</td>
                  <td>'.strtoupper($pedacin[3]).'</td>
                  <td>'.strtoupper($pedacin[1]).'</td>
                  <td style="text-align: right;">$'.number_format($pedacin[2],2).'</td>
                </tr>';
                $sumacheques = $sumacheques + $pedacin[2];
              }
            }
            echo '<tr style="text-align: center;">
                <td><b>Total</b></td>
                <td></td>
                <td></td>
                <td><b>'."$" . number_format($sumacheques,2) . '</b></td>
              </tr>
            </table>
            <p>'.$_POST['acuse'].'</p>
            <p>
              Sin otro particular, aprovecho la ocasión para enviarle un cordial saludo. 
            </p>
            <p>
              Atentamente,
            </p>
            <br>
            <br>
            <p>
              Julián Adem<br>
              Cónsul Titular<br>
              <br>
              IF/yr
              <br>
      <small>'.$_POST["leccp"].'</small>
            </p>';
        } else{
          if(get_count_proveedores() > 4 && get_count_proveedores() <15){
            $sumacheques = 0;
            for($i = 1; $i<50; $i ++){
              if($_POST["ch" . $i] != ""){
                $pedacin = explode("|", $_POST["ch" . $i]);
                echo '<tr style="text-align: center;">
                  <td style="text-align: left;">'.$pedacin[0].'</td>
                  <td>'.$pedacin[3].'</td>
                  <td>'.$pedacin[1].'</td>
                  <td style="text-align: right;">$'.number_format($pedacin[2],2).'</td>
                </tr>';
                $sumacheques = $sumacheques + $pedacin[2];
              }
            }
             echo '<tr style="text-align: center;">
                <td><b>Total</b></td>
                <td></td>
                <td></td>
                <td><b>'."$" . number_format($sumacheques,2) . '</b></td>
              </tr>
            </table>';
            echo '<br>';
            echo '<p>'.$_POST['acuse'].'</p>';
          }
          $sumacheques = 0;
          if(get_count_proveedores() > 16 && get_count_proveedores() <50){
              
              for($i = 1; $i<16; $i ++){
                if($_POST["ch" . $i] != ""){
                  $pedacin = explode("|", $_POST["ch" . $i]);
                  echo '<tr style="text-align: center;">
                    <td style="text-align: left;">'.strtoupper($pedacin[0]).'</td>
                    <td>'.strtoupper($pedacin[3]).'</td>
                    <td>'.strtoupper($pedacin[1]).'</td>
                    <td style="text-align: right;">$'.number_format($pedacin[2],2).'</td>
                  </tr>';
                  $sumacheques = $sumacheques + $pedacin[2];
                }
              }
              echo "</table>";
            }
        }
       
      ?>

      
      
    <div style="text-align: center; font-family: 'SoberanaSansBold'; font-size: 10px; position: absolute; bottom: 0; top: 1020px; left: 43%; color: #333;">
      <p>
        1443 N. Prospect Ave.,<br>
        Milwaukee, WI. 53202<br>
        Tel. (414) 944 7589<br>
        Fax (414) 944 8985 / 86<br>
      </p>

    </div>
  </section>
  <?php
  if(get_count_proveedores() > 4 && get_count_proveedores() <15){
      echo '<section class="sheet padding-10mm" style="background-image: url(fondo.png); background-size: cover; background-position: -20px -35px; ">
      <img src="logo.png" style="width: 250px;">
    <span style="float: right; font-size: 15px; font-weight: bold; font-family: \'SoberanaSansBold\';">Consulado de México en Milwaukee</span>
    <br>
    <br>
    <br>
    <p>
      Sin otro particular, aprovecho la ocasión para enviarle un cordial saludo. 
    </p>
    <p>
      Atentamente,
    </p>
    <br>
    <br>
    <p>
      Julián Adem<br>
      Cónsul Titular<br>
      <br><br>
      IF/yr
      <br>
      <small>'.$_POST["leccp"].'</small> 
    </p>
      <div style="text-align: center; font-family: \'SoberanaSansBold\'; font-size: 10px; position: absolute; bottom: 0; top: 1020px; left: 43%; color: #333;">
      <p>
        1443 N. Prospect Ave.,<br>
        Milwaukee, WI. 53202<br>
        Tel. (414) 944 7589<br>
        Fax (414) 944 8985 / 86<br>
      </p>

    </div>
      </section>';
  }
  if(get_count_proveedores() > 14 && get_count_proveedores() <50){
    echo '<section class="sheet padding-10mm" style="background-image: url(fondo.png); background-size: cover; background-position: -20px -35px; ">
      <img src="logo.png" style="width: 250px;">
    <span style="float: right; font-size: 15px; font-weight: bold; font-family: \'SoberanaSansBold\';">Consulado de México en Milwaukee</span>
    <br>
    <br>
    <br>
    <table style="width: 100%;">
      <tr style="text-align: center;">
        <td style="width: 440px !important;"><b>Proveedor</b></td>
        <td style="width: 85px !important;"><b>Número de Cheque</b></td>
        <td><b>Fecha de cheque</b></td>
        <td><b>Cantidad</b></td>
      </tr>
    ';
    for($i = 16; $i<50; $i ++){
      if($_POST["ch" . $i] != ""){
        $pedacin = explode("|", $_POST["ch" . $i]);
        echo '<tr style="text-align: center;">
          <td style="text-align: left;">'.strtoupper($pedacin[0]).'</td>
          <td>'.strtoupper($pedacin[3]).'</td>
          <td>'.strtoupper($pedacin[1]).'</td>
          <td style="text-align: right;">$'.number_format($pedacin[2],2).'</td>
        </tr>';
        $sumacheques = $sumacheques + $pedacin[2];
      }
    }
    echo '<tr style="text-align: center;">
                <td><b>Total</b></td>
                <td></td>
                <td></td>
                <td><b>'."$" . number_format($sumacheques,2) . '</b></td>
              </tr>';
    echo '
    </table>
    <p>'.$_POST['acuse'].'</p>
    <p>
      Sin otro particular, aprovecho la ocasión para enviarle un cordial saludo. 
    </p>
    <p>
      Atentamente,
    </p>
    <br>
    <br>
    <p>
      Julián Adem<br>
      Cónsul Titular<br>
      <br><br>
      IF/yr
      <br>
      <small>'.$_POST["leccp"].'</small>
    </p>
      <div style="text-align: center; font-family: \'SoberanaSansBold\'; font-size: 10px; position: absolute; bottom: 0; top: 1020px; left: 43%; color: #333;">
      <p>
        1443 N. Prospect Ave.,<br>
        Milwaukee, WI. 53202<br>
        Tel. (414) 944 7589<br>
        Fax (414) 944 8985 / 86<br>
      </p>

    </div>
      </section>';
    
    
  }
  ?>

</body>

</html>

<?php

function get_mes($mesm){
  switch ($mesm) {
    case '01':
      return "enero";
      break;
    case '02':
      return "febrero";
      break;
    case '03':
      return "marzo";
      break;
    case '04':
      return "abril";
      break;
    case '05':
      return "mayo";
      break;
    case '06':
      return "junio";
      break;
    case '07':
      return "julio";
      break;
    case '08':
      return "agosto";
      break;
    case '09':
      return "septiembre";
      break;
    case '10':
      return "octubre";
      break;
    case '11':
      return "noviembre";
      break;
    case '12':
      return "diciembre";
      break;
    default:
      return "";
      break;
  }
}
?>