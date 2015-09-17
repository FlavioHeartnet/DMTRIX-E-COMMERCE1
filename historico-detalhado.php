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

<body onLoad="somaProdutos() verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php");

				$idCompra = $_POST['idcompra'];
				$valorTotal = $_POST['valor'];
				$loja = $_POST['loja']; 
				?>

<div class="centro">
	<div class="clear bgBranco secaoInterna">
    	<h2>Histórico de Pedidos<br><span>Detalhes do Pedido <?php echo $idCompra; ?>.</span></h2>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td colspan="2">Material</td>
                    <td>Descrição do Material</td>
                    <td>Valor do Material</td>
                    <td align="right" style="padding-right:5px;">Valor Final</td>
                </tr>
            </thead>
            <tbody>
            	<?php 
				
				
				$query = odbc_exec($conexao, "select p.idCompra,p.acao,p.altura,p.largura, p.quantidade,p.segmento,m.idMaterial,m.material,m.foto,p.observacao, p.valorProduto,p.valorTotal,p.idLoja,p.formaPagamento
 from  [marketing].[dbo].[PedidoDMTRIX] p inner join [marketing].[dbo].[materiaisDMTRIX] m on m.idMaterial = p.idMaterial where idCompra =  '$idCompra'");
				
				
				while($buscaPedido = odbc_fetch_array($query)){ ?>
            	<tr>
                	<td><div class="clear imagemTodosMateriais"><img src="../dmtrade/img/brindes/<?php echo $buscaPedido['foto']; ?>"></div></td>
                	<td><?php echo $buscaPedido['material']; ?></td>
                    <td width="500px">
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr class="semBorda">
                                <td>Largura<div class="campo"><input type="text" readonly name="largura[]"  class="left" placeholder="Largura" value="<?php echo $buscaPedido['largura']; ?>" autocomplete="off" data-mask="0000.00" data-mask-reverse="true"></div></td>
                                <td>Altura<div class="campo"><input type="text" readonly name="altura[]" class="left" placeholder="Altura" value="<?php echo $buscaPedido['altura']; ?>" autocomplete="off" data-mask="0000.00" data-mask-reverse="true"></div></td>
                                <td>Quantidade<div class="campo"><input type="text" readonly name="quantidade[]" class="left" placeholder="Quantidade" value="<?php echo $buscaPedido['quantidade']; ?>" ></div></td>
                                 </tr>
                            <tr class="semBorda">
                                <td colspan="9"><div class="campo"><textarea readonly name="observacao[]"  class="left" placeholder="Como você imagina essa peça pronta?" style="line-height:25px;"><?php echo $buscaPedido['observacao']; ?></textarea></div></td>
                            </tr>
                        </table>                    
                    </td>
                    <td width="90px">R$<?php echo $buscaPedido['valorProduto']; ?>m²</td>
                    <td width="80px" class="valorProduto" align="right">R$<?php echo $buscaPedido['quantidade'] * $buscaPedido['valorProduto'];?></td>
                </tr>
                <?php }; 
				
				$query = odbc_exec($conexao, "select * from  [marketing].[dbo].[PedidoDMTRIX] p inner join [marketing].[dbo].[materiaisDMTRIX] m on m.idMaterial = p.idMaterial where idCompra =  '$idCompra'");
				$buscaPedido = odbc_fetch_array($query);
				?>
                
                
                
                <tr>
                	<td colspan="5" height="50px"></td>
                </tr>
                
                <tr>
                	<td colspan="2">
                        <div class="largura100 left campo">
                            <select name="custeio">
                                <option value=""><?php echo $buscaPedido['custeio']; ?></option>
                            </select>
                        </div>                    
                    </td>
                    <td>
                        <div class="largura100 left campo">
                            <select name="loja">
                                <option value=""><?php echo $loja; ?></option>
                            </select>
                        </div>                       
                    </td>
                	<td colspan="2" class="valorTotal" align="right">Total: <span>R$<?php echo 	$valorTotal; ?></span><input type="hidden" name="valorTotal" style="width:50px;"></td>
                </tr>
                
                <tr class="semBorda">
                	<td colspan="2">
                        <div class="largura100 left campo">
                            <select name="formaPagamento">
                                <option value=""><?php echo $buscaPedido['formaPagamento']; ?></option>
                            </select>
                        </div>                    
                    </td>
                    <td>
                        <div class="largura100 left campo">
                            <select name="segmento">
                                <option value=""><?php echo $buscaPedido['segmento']; ?></option>
                            </select>
                        </div>                       
                    </td>
                	<td colspan="2" align="right"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>