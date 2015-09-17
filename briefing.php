<?php
include("funcoes.php");
include("analyticstracking.php");
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

<body onLoad="verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna briefing">
    	<h2>Briefing<br><span>Queremos atender todas as suas expectativas! Mas para isso, você precisa nos dizer:</span></h2>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            </tr>
        </table>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr class="semBorda">
            	<td align="center"><img src="img/passos_briefing.png"></td>
            </tr>
        	<tr class="semBorda">
            	<td align="center"><div class="campo"><textarea name="publicoAlvo" class="left" placeholder="Qual o seu Público Alvo?"></textarea></div></td>
            </tr>
        	<tr class="semBorda">
            	<td align="center"><div class="campo"><textarea name="acao" class="left" placeholder="Qual será sua Ação na loja?"></textarea></div></td>
            </tr>
        	<tr class="semBorda">
            	<td align="center"><div class="campo"><textarea name="objetivo" class="left" placeholder="Qual seu Objetivo ao usar este material?"></textarea></div></td>
            </tr>
            <tr class="semBorda">
            	<td><input type="submit" name="finalizar" value="Finalizar Compra" class="largura25 right btnSubmit"></td>
            </tr>
        </table>
        </form>
    </div>
    <?php
	$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
		if(isset($_POST['finalizar']))
		{
			$publico = 		$_POST['publicoAlvo'];
			$acao =			$_POST['acao'];
			$objetivo = 	$_POST['objetivo'];
			$valorTotal =	$_SESSION['valorTotal'];
			$idUsuario =	$usuarioLogado['idUsuario'];
			
			$query = odbc_exec($conexao," update [marketing].[dbo].[PedidoDMTRIX] set  publicAlvo = '$publico', acao = '$acao', objetivo = '$objetivo'  where idUsuario = '$idUsuario' and status_pedido = 1");
			
			addCompra($valorTotal, $idUsuario);
			
		};
		
	 include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>