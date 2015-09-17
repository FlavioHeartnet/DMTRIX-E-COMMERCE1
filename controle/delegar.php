<?php

include_once("../config.php");
include("../funcoes.php");

$usuario = $_GET['valor4'];
$idPedido = $_GET['valor'];
$acao = $_GET['valor3'];
$resp = $_GET['valor2'];

if($acao == 1) {

    $query = addTarefa($usuario, $idPedido, $resp);

    if($query == true)
    {

        echo "<div class='step'><i class='checkmark icon'></i></div>";


    }else
    {
        echo "<div class='step'><i class='remove icon'></i></div>";
    }



}elseif($acao == 2)
{
    $query = atualizaTarefa($usuario, $idPedido, $resp);

    echo $query;
}