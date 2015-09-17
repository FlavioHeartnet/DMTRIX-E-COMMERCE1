<?php

include("../config.php");

$idCompra = $_GET['valor'];
$prioridade = $_GET['valor2'];

$query = odbc_exec($GLOBALS['conexao'], "update ComprasDMTRIX set Prioridade = '$prioridade' where idCompra = '$idCompra'");

switch($prioridade)
{
    case 1: $color = "red"; break;
    case 2: $color = "yellow"; break;
    case 3: $color = "green"; break;
    default: $color = "";
}

if($query == true)
{
    echo $color;

}

