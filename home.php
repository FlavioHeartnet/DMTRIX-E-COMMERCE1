<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };

//nessa pagina você notara que a variavel num é crucial pois ela retorna o valor dinamico que uso, associar os checksbox aos campos(largura, altura, localizacao...etc) na hora do de salvar no banco de dados no $_POST['produto'].
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
<?php include("topo.php"); ?>

<div class="centro ">
	<div class="clear bgBranco secao1">
    <?php $buscaMaterial = odbc_exec($conexao, "select * from [MARKETING].[dbo].[produtosDicasDMTRIX] p inner join dicasDMTRIX d on p.idDica = d.idDica inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial where d.ativo = 'sim'");
	
	$arry = odbc_fetch_array($buscaMaterial);?>
    	<h2><?php echo $arry['titulo']; ?><br><span>Gostariamos de lhe dar algumas dicas de materiais para o <?php echo $arry['titulo']; ?></span></h2>
        <form action="#" method="post">
     	<?php 
		$buscaMaterial = odbc_exec($conexao, "select * from [MARKETING].[dbo].[produtosDicasDMTRIX] p inner join dicasDMTRIX d on p.idDica = d.idDica inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial where d.ativo = 'sim'");
						$num = 0;
					  while($rsBuscaMaterial = odbc_fetch_array($buscaMaterial)){
						  
						  $idProduto =  $rsBuscaMaterial['idProduto'];
					 ?> 
			<div class="clear listagemProdutosHome">
				<table width="100%" align="center" border="0" cellpadding="0" cellspacing="20px">
                   
                    <tr>
                        <td align="left" valign="middle" class="checks"><input type="checkbox" name="produto[]" id="l<?php echo  $num; ?>" value="<?php echo $num ?>"><label for="l<?php echo  $num; ?>"></label></td>
                        <td align="left" valign="middle"><label for="l<?php echo  $num; ?>"><img class="imagemConsulta" src="../dmtrade/img/brindes/<?php echo $rsBuscaMaterial['foto']; ?>"></label></td>
                        <td align="left" valign="middle"><label for="l<?php echo  $num; ?>"><p><?php echo $rsBuscaMaterial['material']; ?><br>R$<?php echo $rsBuscaMaterial['valor']; ?> m²</p></label></td>
                        <td align="left" valign="middle" style="border-right:1px solid #d4d4d4;"></td>
                        <td>
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="20px">
                                <tr>
                                    <td class="campo"><label for="<?php echo  $num; ?>"><input  type="text" name="largura[]" class="left" placeholder="Largura" autocomplete="off"  data-mask-reverse="true"></label></td>
                                    <td align="center" valign="middle">X</td>
                                    <td class="campo"><label for="<?php echo  $num; ?>"><input  type="text" name="altura[]" class="left" placeholder="Largura" autocomplete="off"  data-mask-reverse="true"></label></td>
                                    <td align="left" valign="middle" style="border-right:1px solid #d4d4d4;"></td>
                                    <td class="campo"><label for="<?php echo  $num; ?>"><input  type="text" name="quantidade[]" class="left" placeholder="Quantidade" autocomplete="off" data-mask="0000" data-mask-reverse="true"></label></td>
                                    <td align="left" valign="middle" style="border-right:1px solid #d4d4d4;"></td>
                                    <td class="campo"><label for="<?php echo  $num; ?>"><input  type="text" name="localizacao[]" class="left" placeholder="Localização" autocomplete="off"></label></td>
                                    <td align="left" valign="middle" style="border-right:1px solid #d4d4d4;"></td>
                                    <td class="campo"><label for="<?php echo  $num; ?>"><input  type="text" name="entrega[]" class="left" placeholder="Data de Entrega" autocomplete="off" data-mask="00/00/0000" data-mask-reverse="true"></label></td>
                                    <label for="<?php echo  $num; ?>"><input type="hidden" name="valor[]" value="<?php echo $rsBuscaMaterial['valor']; ?>"  class="left"  autocomplete="off" data-mask-reverse="true"></label>
                                     <label for="<?php echo  $num; ?>"><input type="hidden" name="idMaterial[]" value="<?php echo $rsBuscaMaterial['idMaterial']; ?>"  class="left"  autocomplete="off" data-mask-reverse="true"></label>
                                    
                                </tr>
                                <tr>
                                    <td class="campo" colspan="9"><label for="<?php echo  $num; ?>"><textarea name="observacao[]" class="left"  placeholder="Como você imagina essa peça pronta?"></textarea></label></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php 
					$num+=1;
					}; ?>
				</table>
                

			</div>
            <input type="submit" name="carrinho" value="Adicionar Itens ao Carrinho" class="largura25 right btnSubmit">
        </form>
    </div>
    <?php include("rodape.php");
	
	$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'")); 
	if(isset($_POST['produto']))
	{
		
		$largura = $_POST['largura'];
		$idMaterial = $_POST['idMaterial'];
		$produto = $_POST['produto'];
		$altura = $_POST['altura'];
		$quantidade = $_POST['quantidade'];
		$localizacao = $_POST['localizacao'];
		$entrega = $_POST['entrega'];
		$observacao = $_POST['observacao'];
		$produto = $_POST['produto'];
		$valor = $_POST['valor'] ;
		$count = count($produto);
		
		$idUsuario = $usuarioLogado['idUsuario'];
		$datapedido =  	date("m.d.y, g:i a");
		for($i = 0;$i < $count; $i++)
		{
			
			$ponteiro = $produto[$i];
			
			$valorFinal = $valor[$ponteiro];
			echo "<script>alert('$valor[$ponteiro]: valor quantidade: $quantidade[$ponteiro]  ');</script>";
			$query = odbc_exec($conexao, "insert into marketing.dbo.PedidoDMTRIX(idMaterial,largura,altura,quantidade,localizacao,data_entrega ,observacao,Data_do_Pedido, idUsuario, status_pedido, valorProduto) values ('$idMaterial[$ponteiro]','$largura[$ponteiro]','$altura[$ponteiro]', '$quantidade[$ponteiro]' , '$localizacao[$ponteiro]' ,'$entrega[$ponteiro]','$observacao[$ponteiro]','$datapedido','$idUsuario',1,'$valorFinal')");
	
			
		}
		
		if($query == true)
		{
		$historico = odbc_exec($conexao, "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado de codigo: $idUsuario realizou um pedido referente ao material ')");
		
		
		
		echo "<script>alert('Voce inseriu este item no carrinho!'); location.href='home.php';</script>"; 
		return true;
		}else
		{
		echo "<script>alert('Ocorreu um erro ao tentar enviar ser pedido, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
		}
		
		
		
	}
	
	 ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>