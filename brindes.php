<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$budget = $usuarioLogado['budgetBrindes'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/estilos-bibliotecas.css">
</head>

<body onLoad="verificaLogin(), RemoveBox()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>
<div class="centro">
	<div class="clear bgBranco secaoInterna todosMateriais">
    	<h2>Todos os Brindes<br><span>Ao encontrar o brinde que procura, clique em Selecionar, preencha os campos e clique em Adicionar, Seu saldo de budget é: <?php echo $budget; ?></span></h2>
        <?php
            $buscaBrinde = odbc_exec($conexao, "SELECT * FROM dbo.brindesDMTRIX order by valor ASC");
            while($rsbuscaBrinde = odbc_fetch_array($buscaBrinde)){
					if($rsbuscaBrinde['estoque']>0){
        	?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="largura30 left boxMaterial">
                <div class="clear imagemTodosMateriais"><img src="../dmtrade/img/brindes/<?php echo $rsbuscaBrinde['foto'];?>"></div>
                <div class="clear">
                    <h3><?php echo $rsbuscaBrinde['brinde']; ?></h3>
                    <p>R$<?php echo $rsbuscaBrinde['valor']; ?></p><input type="hidden" name="valor" value="<?php echo $rsbuscaBrinde['valor']; ?>">
                    <p>Estoque: <strong><?php echo $rsbuscaBrinde['estoque']; ?></strong></p>
                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="display:none;">
                    
                    <tr>
                    	<td><div style="margin-top:25px"><a style="margin-top:25%" data-fancybox-group="gallery" href="../dmtrade/img/brindes/<?php echo $rsbuscaBrinde['foto'];?>" class="fancybox">Clique aqui para visualizar a imagem</a></div></td>
                    </tr>
                    
                        <input type="hidden" name="idBrinde" class="left" value="<?php echo $rsbuscaBrinde['idBrinde']; ?>">
                        <tr class="semBorda">
                            <td><div class="campo"><input type="text" required name="quantidade" class="left" placeholder="Quantidade" autocomplete="off" data-mask="0000" data-mask-reverse="true" data-idBrinde="<?php echo $rsbuscaBrinde['idBrinde']; ?>"></div></td>
                            <input type="hidden" name="idBrinde" value="<?php echo $rsbuscaBrinde['idBrinde'];?>">
                            <input type="hidden" name="nomeBrinde" value="<?php echo $rsbuscaBrinde['brinde'];?>">

                        </tr>
                        <tr>
                            <td colspan="2"><div class="campo" style="height:80px;"><textarea name="MotivoCompra" class="left" placeholder="Motivo da Compra" style="line-height:25px; height:80px;"></textarea></div></td>                    
                        </tr>
                    </table>
                    
                    <input type="submit" name="ComprarBrinde" value="Selecionar" class="largura50 btnSubmit abreBox" data-idBrinde="<?php echo $rsbuscaBrinde['idBrinde']; ?>">
                    
                    
                    
               
                </div>
            </div>
        </form>
            <?php }
			}; ?>


	</div>
<?php include("rodape.php");
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			

if(isset($_POST['ComprarBrinde']))
{
	$quantidade = $_POST['quantidade'];
	$motivo = $_POST['MotivoCompra'];
	$idBrinde = $_POST['idBrinde'];
	$nome = $_POST['nomeBrinde'];
	$valor = $_POST['valor'];
	$idUsuario = $usuarioLogado['idUsuario'];
    $total = $valor * $quantidade;

	
	Brindes($quantidade, $motivo, $idBrinde, $nome, $total, $idUsuario);
}

 ?>
</div>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			

			$('.fancybox').fancybox();

			});
			
			
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});
			
</script>
</body>
</html>