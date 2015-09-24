<?php

include("config.php");
include("funcoes.php");


$pedido = $_POST['idPedido'];
$usuario = $_POST['idUsuario'];


$nome_material = $_FILES['foto']['name'];
$nome_temp = $_FILES['foto']['tmp_name'];

$exteFoto = explode(" ",$nome_material);
$exteFoto_ex = strtolower($exteFoto);



$extencaoF = $pedido."".$nome_material.$exteFoto_ex;

CarregaArte($extencaoF,$nome_temp);
$result = SalvarArte($usuario, $extencaoF, $pedido);
