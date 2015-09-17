<?php
include("funcoes.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/estilos-bibliotecas.css">
</head>

<body onLoad="somaProdutos(),verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>
 <?php
				$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
				$idUsuario = $usuarioLogado['idUsuario'];
				$buscaCompra = odbc_exec($GLOBALS['conexao'], "select top 1 * from [marketing].[dbo].[ComprasDMTRIX] c inner join [marketing].[dbo].PedidoDMTRIX p on (c.idCompra = p.idCompra) where p.status_pedido= '2' and p.idUsuario = '$idUsuario' ORDER BY p.idCompra DESC ");
		        $rsbuscaCompra = odbc_fetch_array($buscaCompra);
		        $Compra = $rsbuscaCompra['idCompra']; 
				$valor = $rsbuscaCompra['valorTotal'];
				$total = $valor +0;
				
			?>
<div class="centro">
	<div class="clear bgBranco secaoInterna compra-finalizada">
    	<h2>Compra Finalizada<br><span>O valor total da sua compra foi de aproximadamente R$<?php echo $total;  ?> Iremos analisar seu pedido e retornaremos em breve.</span></h2>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr class="semBorda">
            	<td align="center"><img src="img/passos_correcao_de_valor.png"></td>
            </tr>
            
            <tr class="semBorda">
           
            	<td align="center">O código do seu pedido é <br/><span><?php echo $Compra ?></span><br/> Acompanhe o status do seu pedido <a href="aprovacao-reprovacao.php">clicando aqui</a></td>
            </tr>
        </table>
    </div>
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>