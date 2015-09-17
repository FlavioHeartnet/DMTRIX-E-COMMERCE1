<?php

include_once("../config.php");



// Recebe o valor enviado
$valor = $_GET['valor'];

$verificar = is_numeric($valor);




if($verificar == true) {
// Procura titulos no banco relacionados ao valor
    $sql = odbc_exec($GLOBALS['conexao'], "SELECT * FROM lojasDMTRIX WHERE numeroLoja LIKE '%" . $valor . "%'");

}else{

    $sql = odbc_exec($GLOBALS['conexao'], "SELECT * FROM lojasDMTRIX WHERE nomeLoja LIKE '%" . $valor . "%'");

}

// Exibe todos os valores encontrados
    while ($loja = odbc_fetch_array($sql)) {
        echo "<a href=\"javascript:func()\" onclick=\"exibirConteudo('" . $loja['idLoja'] . "')\">" . $loja['numeroLoja'] . " - " . $loja['nomeLoja'] . "</a><br />";
    }


?>