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

$cortarfecha = explode("/", $_POST["fechadecorreo"]);
$fechadecorreofinal = $cortarfecha[1] ." de " . get_mes($cortarfecha[0]) . " de " . $cortarfecha[2];
$ccptext = "";
switch ($_POST['tpago']) {
  case 'adenda':
    $ccptext =  "SSAN; DGPME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar;";
    break;
  case 'pale':
    $ccptext =  "SSAN; DGPME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar; Escobar Carré, Judith; De la Cruz Cadena, Delia;";
    break;
  case 'ime':
    $ccptext =  "SSAN; DGPME; IME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar;";
    break;
  case 'adendapale':
   $ccptext =  "SSAN; DGPME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar; Escobar Carré, Judith; De la Cruz Cadena, Delia;";
    break;
  case 'adendaime':
   $ccptext =  "SSAN; DGPME; IME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar;";
    break;
  case 'paleime':
   $ccptext =  "SSAN; DGPME; IME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar; Escobar Carré, Judith; De la Cruz Cadena, Delia;";
    break;
  case 'adendapaleime':
   $ccptext =  "SSAN; DGPME; IME; DGPOP; Márquez Lartigue, Rodrigo; Mendoza Durán, Sandra; Sánchez Patiño, Fania; Villegas Sánchez, Oscar; Escobar Carré, Judith; De la Cruz Cadena, Delia;";
    break;
  default:
    break;
}

$textref = "";
for($i = 1; $i<16; $i ++){
	if($_POST["aut" . $i] != ""){
	  $pedacin = explode("|", $_POST["aut" . $i]);
	  $textref.= $pedacin[0] . "(".$pedacin[1]."); ";
	}
}
$textref.= $_POST['oficios'];
$firststring =  str_replace("[[numcheques]]", $_POST['numcheques'] ,$_POST['correspondientesa']);
$correspondientesatext= str_replace("[[oficios]]", $oficiosfiii ,$firststring);
$paleadendatext = "";
switch ($_POST['tpago']) {
	case 'adenda':
	  $paleadendatext = "Adenda de los contratos suscritos en el marco del FAMEU.";
	  $template = 'MKE-00000TEMPLATE.docx';
	  $paleadenda = $paleadendatext;
	  break;
	case 'pale':
	  $paleadendatext = "Cuarta Radicación PALE 2015-2018.";
	  $template = 'MKE-00000TEMPLATE.docx';
	  $paleadenda = $paleadendatext;
	  break;
  case 'ime':
    $paleadendatext = "Programa de Protección al Patrimonio.";
    $template = 'MKE-00000TEMPLATE.docx';
    $paleadenda = $paleadendatext;
    break;
	case 'adendapale':
	  $paleyadendatext1 = "Adenda de los contratos suscritos en el marco del FAMEU.";
	  $paleyadendatext2 = "Cuarta Radicación PALE 2015-2018.";
	  $adenda = $paleyadendatext1;
	  $pale = $paleyadendatext2;
	  $template = 'MKE-00000TEMPLATE2.docx';
	  break;
  case 'adendaime':
    $paleyadendatext1 = "Adenda de los contratos suscritos en el marco del FAMEU.";
    $paleyadendatext2 = "Programa de Protección al Patrimonio.";
    $adenda = $paleyadendatext1;
    $pale = $paleyadendatext2;
    $template = 'MKE-00000TEMPLATE2.docx';
    break;
  case 'paleime':
    $paleyadendatext1 = "Cuarta Radicación PALE 2015-2018.";
    $paleyadendatext2 = "Programa de Protección al Patrimonio.";
    $adenda = $paleyadendatext1;
    $pale = $paleyadendatext2;
    $template = 'MKE-00000TEMPLATE2.docx';
    break;
  case 'adendapaleime':
    $paleyadendatextime1 = "Adenda de los contratos suscritos en el marco del FAMEU.";
    $paleyadendatextime2 = "Cuarta Radicación PALE 2015-2018.";
    $paleyadendatextime3 = "Programa de Protección al Patrimonio.";
    $adenda = $paleyadendatextime1;
    $pale = $paleyadendatextime2;
    $ime = $paleyadendatextime3;
    $template = 'MKE-00000TEMPLATE3.docx';
    break;
	default:
	  break;
}
$enviotext = str_replace("[[trackingenvio]]", $_POST['envio'] ,$_POST['textoenvio']);
include_once('./demo/tbs_class.php');
include_once('tbs_plugin_opentbs.php');
$TBS = new clsTinyButStrong;
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
$consulado = ucwords(strtolower($_POST["consulado"]));
$ccp = $ccptext;
$numerodecorreo = $_POST['numerodecorreo'];
$fecha = $fechadecorreofinal;
$oficios = $oficiosfiii;
$referencias = $textref;
$correspondientesa = $correspondientesatext;
$textoenvio = $enviotext;
$cierre = $_POST['textoenviocierre'];
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
$TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
$output_file_name = "MKE-" . $numerodecorreo ." " .$consulado.".docx";
$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);




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