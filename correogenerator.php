<?php
$textooficios = preg_replace('/\s+/', '', preg_replace("/\([^)]+\)/","",$_POST['oficios']));
$pedazosoficios = explode(";", $textooficios);
$oficiosfiii = "";

if (count($pedazosoficios) == 2) {
  $oficiosfiii =  $pedazosoficios[0];
}else{
  if (count($pedazosoficios) == 3) {
    $oficiosfiii =  $pedazosoficios[0] . " y " . $pedazosoficios[1];
  }else{
    if (count($pedazosoficios) > 3) {
      for ($i=0; $i < (count($pedazosoficios) - 2); $i++) { 
        $oficiosfiii.= $pedazosoficios[$i] . ", ";
      }
      $oficiosfiii = substr($oficiosfiii, 0, -2);
      array_pop($pedazosoficios);
      $oficiosfiii.= " y " . end($pedazosoficios);
    }
  }  
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Generador de Correos</title>

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
    #contentmail{
      font-size: 15px;
    }
  </style>
</head>
<?php
    $cortarfecha = explode("/", $_POST["fechadecorreo"]);
    $fechadecorreofinal = $cortarfecha[1] ." de " . get_mes($cortarfecha[0]) . " de " . $cortarfecha[2];
?>
<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm" style="">
    <br>
    <span>CONSULMEX MILWAUKEE</span>
    <div style="width: 100%; height: 1px; background-color: #000;"></div>
    <p>
      <table style="border: 0px solid #000; font-size: 14px;position: relative; top: -15px;">
        <tr style="border: 0px solid #000;">
          <td style="border: 0px solid #000; width: 100px;" valign="top">Para:</td>
          <td style="border: 0px solid #000;" valign="top">Consulmex <?php echo ucwords(strtolower($_POST["consulado"])) ;?></td>
        </tr>
        <tr style="border: 0px solid #000;">
          <td style="border: 0px solid #000;" valign="top">De:</td>
          <td style="border: 0px solid #000;" valign="top">Consulmex Milwaukee</td>
        </tr>
        <tr style="border: 0px solid #000;">
          <td style="border: 0px solid #000;" valign="top">C.c.p.:</td>
          <td style="border: 0px solid #000;" valign="top">
          <?php
            switch ($_POST['tpago']) {
              case 'adenda':
                echo "SSAN; DGPME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar;";
                break;
              case 'pale':
                echo "SSAN; DGPME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar; Escobar Carré, Judith; De la Cruz Cadena, Delia;";
                break;
              case 'adendapale':
                echo "SSAN; DGPME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar; Escobar Carré, Judith; De la Cruz Cadena, Delia;";
                break;
              default:
                break;
            }
            ?>
          </td>
        </tr>
        <tr style="border: 0px solid #000;">
          <td style="border: 0px solid #000;" valign="top">C.c.o.:</td>
          <td style="border: 0px solid #000;" valign="top">ifernandez; prot6mke;</td>
        </tr>
        <tr style="border: 0px solid #000;">
          <td style="border: 0px solid #000;" valign="top">Asunto:</td>
          <td style="border: 0px solid #000;" valign="top">MKE-<?php echo $_POST['numerodecorreo']; ?> - Envío de cheques Mandato FAMEU.</td>
        </tr>
        <tr style="border: 0px solid #000;">
          <td style="border: 0px solid #000;" valign="top">Fecha:</td>
          <td style="border: 0px solid #000;" valign="top"><?php echo $fechadecorreofinal; ?></td>
        </tr>
        <tr style="border: 0px solid #000;">
          <td style="border: 0px solid #000;" valign="top">Anexo:</td>
          <td style="border: 0px solid #000;" valign="top">Oficios: <?php echo $oficiosfiii; ?></td>
        </tr>
      </table>
    </p>
    <img src="logo250.png" style="float: right;">
   <br>
   <br>
   <br>
   <br>
   <br>
    <table class="bordes" style="font-size: 10px; text-align: center; float: right; width: 310px;">
      <tr>
        <td colspan="2">INFORMACIÓN RESERVADA</td>
      </tr>
      <tr>
        <td>Fecha de clasificación:</td>
        <td><?php echo $fechadecorreofinal; ?></td>
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
    <div id="contentmail">
    <p style="text-align: justify;">
      Ref: <?php 
         for($i = 1; $i<16; $i ++){
            if($_POST["aut" . $i] != ""){
              $pedacin = explode("|", $_POST["aut" . $i]);
              echo $pedacin[0] . "(".$pedacin[1]."); ";
            }
          }
          echo $_POST['oficios'];
      ?>
    </p>
    <p style="text-align: justify;">
      <?php 

      $firststring =  str_replace("[[numcheques]]", $_POST['numcheques'] ,$_POST['correspondientesa']);
      echo str_replace("[[oficios]]", $oficiosfiii ,$firststring);

      ?> 
    </p>
    <ul>
      <?php
      switch ($_POST['tpago']) {
        case 'adenda':
          echo "<li>Adenda de los contratos suscritos en el marco del FAMEU.</li>";
          break;
        case 'pale':
          echo "<li>Cuarta Radicación PALE 2015-2018.</li>";
          break;
        case 'adendapale':
          echo "<li>Adenda de los contratos suscritos en el marco del FAMEU.</li>
          <li>Cuarta Radicación PALE 2015-2018.</li>";
          break;
        default:
          break;
      }
      ?>
    
    </ul>
    <p style="text-align: justify;">
      <?php echo str_replace("[[trackingenvio]]", $_POST['envio'] ,$_POST['textoenvio']);?>
    </p>
    <p style="text-align: justify;">
      <?php echo $_POST['textoenviocierre'];?>
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
            </p>
    </div>
  </section>

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