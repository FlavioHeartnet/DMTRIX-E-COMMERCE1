<?php
include_once("../config.php");



// Recebe o valor enviado
$valor = $_GET['valor'];


$verificar = is_numeric($valor);




if($verificar == true) {
// Procura titulos no banco relacionados ao valor
    $sql = odbc_exec($GLOBALS['conexao'], "SELECT * FROM usuariosDMTRIX WHERE  nome =  '$valor ' ORDER BY nome ASC");

}

?>

<?php


