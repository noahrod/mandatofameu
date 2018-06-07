<?php
$handle = fopen("directorioconsulados.csv", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $pedazos = explode(",", $line);
        echo "INSERT INTO `consules` (`id`, `consulado`, `consul`, `cargo`, `tipodeconsulado`) VALUES (NULL, '".$pedazos[1]."', '".$pedazos[2]."', '".$pedazos[3]."', '".$pedazos[4]."');<br/>";
    }

    fclose($handle);
} else {
    // error opening the file.
} 
?>