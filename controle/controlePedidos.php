<?php

include_once("../config.php");
include("../funcoes.php");

$idPedido = $_GET['valor'];
$usuario = $_GET['valor2'];
$acao = $_GET['valor3'];

if($acao == 0) {


    $query = odbc_exec($GLOBALS['conexao'], "update PedidoDMTRIX set status_pedido = 6 where idPedido = '$idPedido'");



    $query2 = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from PedidoDMTRIX where idPedido = '$idPedido'"));
    $foto = $query2['fotoArte'];

    if ($foto == "" or $foto == null) {

        $query2 = odbc_exec($GLOBALS['conexao'], "update PedidoDMTRIX set fotoArte = 'Sem Arte' where idPedido = '$idPedido'");

    }

    if ($query == true and $query2 == true) {
        $historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $usuario tranferiu o pedido: $idPedido para a fila do fornecedor sem a aprovação do cliente!')");

        echo "<div class='step'><i class='checkmark icon'></i></div>";

    } else {
        echo "<div class='step'><i class='remove icon'></i></div>";
    }

}elseif($acao == 1)
{

    $buscaPedido = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from PedidoDMTRIX where idPedido = '$idPedido'"));
    $idCompra = $buscaPedido['idCompra'];
    $historico = "debito";
    if($buscaPedido['status_pedido'] == 3)
    {
        $idUsuario = $buscaPedido['idUsuario'];
        $buscaUsuario = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from usuariosDMTRIX where idUsuario = '$idUsuario'"));
        $budget = $buscaUsuario['budgetMerchandising'];
        $valor = $buscaPedido['valorProduto'];
        $total = $budget + $valor;


        $supervisor = $buscaUsuario['supervisor'];

        odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[usuariosDMTRIX] set budgetMerchandising =  '$total'  WHERE idUsuario = '$idUsuario' OR idUsuario = '$supervisor' OR supervisor = '$supervisor'");
        odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $usuario cancelou o pedido: $idPedido! e foi devolvido $valor para o budget de merchan, o budget atual é: $total')");
        $historico = "credito";
    }
    $query = odbc_exec($GLOBALS['conexao'], "update PedidoDMTRIX set status_pedido = 11 where idPedido = '$idPedido'");

    $buscaCompra = odbc_exec($GLOBALS['conexao'],"select * from PedidoDMTRIX where idCompra = '$idCompra'");
    $count = odbc_num_rows($buscaCompra);
    while($RsbuscaCompra = odbc_fetch_array($buscaCompra))
    {
        $status = $RsbuscaCompra['status_pedido'];
        if($status == 11)
        {
            $array[] = $status;
        }
    }

    if($count == count($array))
    {

        $query3 = odbc_exec($GLOBALS['conexao'], "update ComprasDMTRIX set status_compra = 'Cancelado' where idCompra = '$idCompra'");

    }


    $query2 = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from PedidoDMTRIX where idPedido = '$idPedido'"));
    $foto = $query2['fotoArte'];

    if ($foto == "" or $foto == null) {

        $query2 = odbc_exec($GLOBALS['conexao'], "update PedidoDMTRIX set fotoArte = 'Pedido cancelado' where idPedido = '$idPedido'");

    }

    if ($query == true and $query2 == true) {
        if($historico != "credito") {
            $historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $usuario cancelou o pedido: $idPedido !')");
        }

        echo "<div class='step'><i class='checkmark icon'></i></div>";

    } else {
        echo "<div class='step'><i class='remove icon'></i></div>";
    }

}