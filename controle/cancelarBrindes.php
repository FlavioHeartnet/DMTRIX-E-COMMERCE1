<?php
include("../config.php");
include("../funcoes.php");

$idPedido = $_GET['valor'];
$UsuarioLogado = $_GET['valor3'];

$busca = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from PedidoBrindesDMTRIX  WHERE idPedido= '$idPedido'"));
$idUsuario = $busca['idUsuario'];
$idMaterial = $busca['idBrinde'];
$quantidade = $busca['quantidade'];

$material = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from brindesDMTRIX  WHERE idBrinde= '$idMaterial'"));

$estoque = $material['estoque'];
$novoEstoque = $estoque + $quantidade;


$usuarios = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from usuariosDMTRIX where idUsuario = '$idUsuario'"));

$budget = $usuarios['budgetBrindes'];
$valor = $busca['ValorBrinde'];
$valorTotal = $busca['valorTotal'];
$tipoMov = "Cancelamento Pedido";

$total = $budget + $valor;

$totalcompra = $valorTotal - $valor;
$query3 = odbc_exec($GLOBALS['conexao'],"update usuariosDMTRIX set budgetBrindes = '$total' where idUsuario = '$idUsuario'");
$query = odbc_exec($GLOBALS['conexao'], "update PedidoBrindesDMTRIX set statusBrindes = '5', valorTotal='$totalcompra' WHERE idPedido= '$idPedido'");


$query4 = odbc_exec($GLOBALS['conexao'], "update brindesDMTRIX set estoque = '$novoEstoque' WHERE idBrinde = '$idMaterial'");

$query4 =  MovimentacaoEstoque($tipoMov, $idPedido, $quantidade, $novoEstoque, $idUsuario);

$observacao = "Cancelamento de pedido de Brinde";
$tipo = 2;

$query2 = AddMovimentacao($valor, $idPedido, 4, $observacao, $total, $idUsuario, $UsuarioLogado);

$query = true;
if($query == true and $query2 == true and $query3 == true and $query4 == true)
{

    echo "<div class='step'><i class='checkmark icon'></i>Cancelado!</div> <span>Novo total da compra: R$".$totalcompra." "." <strong>budget atual:". " R$".$total."</strong></span>";

}else
{
    echo "<div class='step'><i class='remove icon'></i>Sem sucesso!</div><span>Houve um problema, tente novamente mais tarde!</span>";
}