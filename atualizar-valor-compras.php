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

<body onLoad="verificaLogin(), NovoValor()">
<div class="msgAlerta"></div>
<?php include("topo.php");
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$idUsuario = $usuarioLogado['idUsuario'];
 ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna atualizar-valor-compras">
    	<h2>Atualizar Valor das Compras<br><span>Gere o orçamento real para o solicitante. Assim que você enviar, ele(a) receberá um e-mail informando esse valor e poderá confirmar o pedido.</span></h2>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>"method="post">
        	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            	<td><div class="campo"><input type="text" data-mask="0000" data-mask-reverse="true" name="token" class="left" placeholder="Insira o Código/Token do Pedido" autocomplete="off" required></div></td>
            </tr>
            <tr>
            	<td><input type="submit" onClick="mostra() NovoValor()"  name="submit_form" value="Procurar Pedido" class="largura30 right btnSubmit"></td>
            </tr>
            	<tr>
                	<td>
                    
                    	
						
</td>
                </tr>
        	</table>
        </form>
        <?php
			if(isset($_POST['submit_form']))
			{
			$idCompra = $_POST['token'];	
			
			$buscaPedido = odbc_exec($conexao, "  SELECT * FROM [marketing].[dbo].[PedidoDMTRIX] where idCompra = '$idCompra' ");
			$row = odbc_num_rows($buscaPedido);
            
			if($row != 0)
			
			{
			
			while($rsBuscaPedido = odbc_fetch_array($buscaPedido)){
        $idProduto = $rsBuscaPedido['idMaterial'];
        $status = $rsBuscaPedido['status_pedido'];
        $nomeProduto = odbc_exec($conexao, " SELECT * FROM [marketing].[dbo].[materiaisDMTRIX] where idMaterial =  '$idProduto'");
        $rsProdutos = odbc_fetch_array($nomeProduto);

        if ($status == 2 or $status == 4 ){


        ?>
        <div id="conteudo" style='visibility: visible'>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <td colspan="2">Material</td>
                        <td>Descrição do Material</td>
                        <td>Valor do Material</td>
                        <td>Valor Final</td>
                    </tr>
                    </thead>
                </table>

                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td class="imagemTodosMateriais"><img
                                src="../dmtrade/img/brindes/<?php echo $rsProdutos['foto']; ?>"></td>
                        <td><?php echo $rsProdutos['material']; ?></td>
                        <td width="500px">
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr class="semBorda">
                                    <td>Largura
                                        <div class="campo"><input type="text" name="largura[]" class="left"
                                                                  value="<?php echo $rsBuscaPedido['largura']; ?>"
                                                                  placeholder="Largura"></div>
                                    </td>
                                    <td>Altura
                                        <div class="campo"><input type="text" name="altura[]" class="left"
                                                                  value="<?php echo $rsBuscaPedido['altura']; ?>"
                                                                  placeholder="Largura"></div>
                                    </td>
                                    <td>Quantidade
                                        <div class="campo"><input type="text" name="quantidade[]" class="left"
                                                                  value="<?php echo $rsBuscaPedido['quantidade']; ?>"
                                                                  placeholder="Quantidade"></div>
                                    </td>
                                </tr>
                                <tr class="semBorda">
                                    <td colspan="9">Observação
                                        <div class="campo"><textarea name="observacao[]" class="left"
                                                                     placeholder="Como você imagina essa peça pronta?"><?php echo $rsBuscaPedido['observacao']; ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="90px">R$<?php echo $rsProdutos['valor']; ?>m²</td>
                        <td width="80px">
                            <div class="campo"><input onChange="NovoValor()" type="text" name="valorPedido[]"
                                                      class="left" placeholder="Novo Valor" data-mask="00000.00"
                                                      value="<?php echo $rsBuscaPedido['valorProduto']; ?>"
                                                       data-mask-reverse="false"></div>
                        </td>

                        <input type="hidden" name="idPedido[]" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                        <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra']; ?>">
                        <input type="hidden" name="Usuario" value="<?php echo $rsBuscaPedido['idUsuario']; ?>">

                    </tr>

                    <?php
                    }
                 };
				 }else{echo "<script>alert('Compra não existe ou ja foi aprovada!')</script>";} // verificar se existe a compra
			};
		?>
        
                <tr class="semBorda">
                	<td colspan="4" align="right">Total: </td>
                    
                	<td align="right" class="NovoTotal"><span>R$222.00</span><input type="hidden" name="valorTotalnew" style="width:50px;"></td>
                </tr>
                <tr class="semBorda">
                	<td colspan="5"><input type="submit" name="atualizar" value="Atualizar Valores" class="largura25 right btnSubmit"></td>
                </tr>
            </tbody>
        </table>
        </form>
        </div>
        <br>
			<?php 
			if(isset($_POST['atualizar']))
			{
			$qdt = $_POST['valorPedido'];
			$tamanho = count($qdt);
			$idPedido = $_POST['idPedido'];
			$idUsuario = $usuarioLogado['idUsuario'];
			$idCompra = $_POST['idCompra'];
			$Total = $_POST['valorTotalnew'];
			$Comprador = $_POST['Usuario'];
            $largura = $_POST['largura'];
            $altura = $_POST['altura'];
            $quantidade = $_POST['quantidade'];
            $observacao = $_POST['observacao'];
			
			
			
		 	AtualizaValor($qdt, $idUsuario, $idPedido,$idCompra, $Total, $Comprador, $largura,$altura, $quantidade, $observacao );
			
				
			}
			?>

    </div>
    <?php include("rodape.php");?>


</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>