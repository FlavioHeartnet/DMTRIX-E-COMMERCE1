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

<body onLoad="verificaLogin(), somaProdutos()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>
<div class="centro">
	<div class="clear bgBranco secaoInterna carrinho">
    	<h2>Carrinho de Brindes<br><span>Revise todos os itens do seu pedido e finalize a compra. Voce ainda pode alterar as informaçoes de cada item.</span></h2>
         <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td width="15%">Brinde</td>
                    <td style="text-align:right">Nome do Brinde</td>
                    <td style="text-align:right">Valor do Brinde</td>
                    <td align="right" style="padding-right:5px;">Valor Final</td>
                </tr>
            </thead>
            </table>
           
        	<?php 
			$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$usuario = $usuarioLogado['idUsuario'];
            $buscaBrinde = odbc_exec($conexao, "select * from [marketing].[dbo].[PedidoBrindesDMTRIX] where idUsuario = '$usuario' and statusBrindes = 1");
			 
			
		
            while($rsBuscaBrinde = odbc_fetch_array($buscaBrinde)){
				
				$idBrinde = $rsBuscaBrinde['idBrinde'];
				$rsBrinde = odbc_fetch_array($buscaBrindeNome = odbc_exec($conexao, "select * from [marketing].[dbo].[brindesDMTRIX] where idBrinde = '$idBrinde'"));
				
				
				?>
	
       
            <form action="comprasBrindes.php" method="post">
            <input type="hidden" name="idBrinde" value="<?php echo $rsBuscaBrinde['idPedido'];?>">
            <input type="submit" class="removerLinhaProduto botaoexcluir" name="excluir" value="x"> 
            
            </form>
            
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            
            	
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            	
            	<tr>

                	
                    <td><div class="clear imagemTodosMateriais"><img src="../dmtrade/img/brindes/<?php echo $rsBrinde['foto'];?>"></div></td>
                    <td><?php echo $rsBuscaBrinde['NomeBrinde'];?></td>
                    <td width="500px">
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr class="semBorda">
                                <td>Quantidade<div class="campo"><input type="text" name="quantidade" value="<?php echo $rsBuscaBrinde['quantidade']; ?>"  class="left" placeholder="Quantidade" autocomplete="off" data-mask-reverse="true"></div></td>
                                <td>Motivo da Compra<div class="campo"><input type="text" name="motivo" value="<?php echo $rsBuscaBrinde['motivo']; ?>" class="left" placeholder="Motivo da Compra" autocomplete="off" data-mask-reverse="true"></div></td>
                                <input type="hidden" name="idBrinde" value="<?php echo $rsBuscaBrinde['idPedido']; ?>">
                                <input type="hidden" name="idUsuario" value="<?php echo $rsBuscaBrinde['idUsuario']; ?>">
                                <?php 
								$valor = $rsBrinde['valor'];
								$quantidade = $rsBuscaBrinde['quantidade'];
								$total = $valor * $quantidade;
								
								 ?>
                                
                                <td class="valorProduto" width="90px">R$<?php echo $total; ?></td><input type="hidden" name="valor" value = "<?php echo $total; ?>"> 
                            </tr>
                            <tr>
                             		 <td align="char" colspan="6"><input type="submit" name="Passo" value="Atualizar" class="largura25 right btnAzul"></td>
                                    
                             </tr>
                        </table>
                       
                      
                      </td>
                      </tr>
                      </tbody>
        
                       </table>
                        </form>
                        
                        <?php } ?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                        
                       <?php $buscaBrinde = odbc_exec($conexao, "select * from [marketing].[dbo].[PedidoBrindesDMTRIX] where idUsuario = '$usuario' and statusBrindes = 1");
					  
					   
					   while($rsBuscaBrinde = odbc_fetch_array($buscaBrinde)){
						   $pedido = $rsBuscaBrinde['idPedido'];
						 $rsBrinde = odbc_fetch_array($buscaBrindeNome = odbc_exec($conexao, "SELECT * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on b.idBrinde = p.idBrinde where idPedido = '$pedido'"));  
							
							$budget = $usuarioLogado['budgetBrindes'];
							$estoque = $rsBrinde['estoque'];
						   
						   ?>
                       
                       <input type="hidden" name="estoque[]" value="<?php echo $estoque; ?>">
                       <input type="hidden" name="budget" value="<?php echo $budget; ?>">
                        <input type="hidden" name="quantidade[]" value="<?php echo $rsBuscaBrinde['quantidade']; ?>">
                        <input type="hidden" name="pedido[]" value="<?php echo $rsBuscaBrinde['idPedido']; ?>">
                        <input type="hidden" name="brinde[]" value="<?php echo $rsBuscaBrinde['idBrinde']; ?>">
                           <input type="hidden" name="brinde[]" value="<?php echo $rsBuscaBrinde['idBrinde']; ?>">
                        
                        
						
						
						<?php } ?>
                         <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                         <tr>
                             <td colspan="5" class="valorTotal" align="right">Valor Total: <span> R$222.00</span></td><input type="hidden" name="valorTotal">
                        </tr>
                        
                         <tr>
                			<td align="right" colspan="6"><input type="submit" name="comprar" value="Comprar" class="largura25 right btnAzul"></td>
                		</tr>
        				</table>
                  </form>
		</div>
<?php include("rodape.php");
	if(isset($_POST['excluir']))
	{
			$id = $_POST['idBrinde'];
			$idUsuario = $usuarioLogado['idUsuario'];
			$nome = $usuarioLogado['nome']." ".$usuarioLogado['sobrenome'];
			deletaBrinde($idUsuario, $id, $nome);
		
		
	}else if(isset($_POST['Passo']))
	{
		$quantidade = $_POST['quantidade'];
		$motivo = $_POST['motivo'];
		$valor = $_POST['valor'];
        $idUsuario = $_POST['idUsuario'];
		
		
		$nome = $usuarioLogado['nome']." ".$usuarioLogado['sobrenome'];
		$idPedido = $_POST['idBrinde'];

        $verifica = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select p.idCompra, p.idPedido, p.idBrinde, b.estoque, p.idUsuario from brindesDMTRIX b inner join PedidoBrindesDMTRIX p on p.idBrinde = b.idBrinde where p.idPedido = '$idPedido'"));
        $estoque = $verifica['estoque'];

        if($estoque >= $quantidade) {
            editBrinde($quantidade, $motivo, $valor, $valorTotal, $nome, $idUsuario, $idPedido);
        }else
        {
            echo "<script>alert('A quantidade selecionada é maior que o estoque deste pedido!');</script>";

        }
		
		
		
	}else if(isset($_POST['comprar']))
	{

		$valorTotal = $_POST['valorTotal'];
		$idUsuario = $usuarioLogado['idUsuario'];
		$quantidade = $_POST['quantidade'];
		$idPedido = $_POST['pedido'];
		$count = count($idPedido);
		$budget = $_POST['budget'];
		$nome = $usuarioLogado['nome'];
		$estoque = $_POST['estoque'];

		if($budget > $valorTotal or $budget == $valorTotal )
		{
			AddCompraBrinde($valorTotal, $idUsuario, $nome, $budget, $quantidade, $idPedido, $estoque );

		}else
		{
			echo "<script>alert('Você não tem budget suficiente ou a quantidade pedida é maior que o estoque.');</script>";
		}
		
		
		
		
		
	}

?>
</div>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/fliplightbox.min.js"></script>
<script type="text/javascript">$('body').flipLightBox()</script>
</body>
</html>