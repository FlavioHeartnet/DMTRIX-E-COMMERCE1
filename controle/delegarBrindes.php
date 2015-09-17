<?php
include("../config.php");
include("../funcoes.php");

$idPedido = $_GET['valor'];
$usuario = $_GET['valor4'];
$resp = $_GET['valor3'];
$status_acao = $_GET['valor2'];



if($status_acao== 2){

$query = odbc_exec($GLOBALS['conexao'], "update PedidoBrindesDMTRIX set statusBrindes = '3' WHERE idPedido= '$idPedido'");

    $busca = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX where idPedido = '$idPedido'"));

    $idCompra = $busca['idCompra'];

    $busca = odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX where idCompra = '$idCompra'");

    $count = odbc_num_rows($busca);
    $array = array();
    while($rsBusca = odbc_fetch_array($busca))
    {

        if($rsBusca['statusBrindes'] == 3) {
            $array[] = $rsBusca['statusBrindes'];
        }

    }

    $total = count($array);

    if($total == $count)
    {
        $compra = odbc_exec($GLOBALS['conexao'], "update ComprasBrindesDMTRIX set status_compra = '3' WHERE idCompra= '$idCompra'");

    }
//$query2 = addTarefa($usuario, $idPedido, $resp);

}elseif($status_acao == 3)
{

    $query = odbc_exec($GLOBALS['conexao'], "update PedidoBrindesDMTRIX set statusBrindes = '4' WHERE idPedido= '$idPedido'");
    $busca = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX where idPedido = '$idPedido'"));

    $idCompra = $busca['idCompra'];

    $busca = odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX where idCompra = '$idCompra'");

    $count = odbc_num_rows($busca);
    $array = array();
    while($rsBusca = odbc_fetch_array($busca))
    {
        if($rsBusca['statusBrindes'] == 4) {
            $array[] = $rsBusca['statusBrindes'];
        }

    }

    $total = count($array);



    if($total == $count)
    {
        $compra = odbc_exec($GLOBALS['conexao'], "update ComprasBrindesDMTRIX set status_compra = '4' WHERE idCompra= '$idCompra'");

    }

}elseif($status_acao == 4)
{


    $query = odbc_exec($GLOBALS['conexao'], "update PedidoBrindesDMTRIX set statusBrindes = '6' WHERE idPedido= '$idPedido'");
    $busca = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX where idPedido = '$idPedido'"));

    $idCompra = $busca['idCompra'];
    $compra = odbc_exec($GLOBALS['conexao'], "update ComprasBrindesDMTRIX set status_compra = '6' WHERE idCompra= '$idCompra'");

    $busca = odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX where idCompra = '$idCompra'");

    $count = odbc_num_rows($busca);
    $array = array();
    while($rsBusca = odbc_fetch_array($busca))
    {
        if($rsBusca['statusBrindes'] == 6) {
            $array[] = $rsBusca['statusBrindes'];
        }

    }

    $total = count($array);

    if($total == $count)
    {
        $compra = odbc_exec($GLOBALS['conexao'], "update ComprasBrindesDMTRIX set status_compra = '6' WHERE idCompra= '$idCompra'");

    }


}elseif($status_acao == 6)
{
    $query = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX where idPedido = '$idPedido'"));

    $idCompra = $query['idCompra'];
    $compra = odbc_exec($GLOBALS['conexao'], "update ComprasBrindesDMTRIX set status_compra = '6' WHERE idCompra= '$idCompra'");

}

if($query == true)
{


    echo "<div class='step'><i class='checkmark icon'></i></div>";


}else
{
    echo "<div class='step'><i class='remove icon'></i></div>";
}