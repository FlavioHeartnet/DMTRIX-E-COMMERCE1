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

<body onLoad="somaProdutos(), verificaLogin(), arrayProdutos()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna carrinho">
    <?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
	
	$budget = $usuarioLogado['budgetMerchandising'];
	$nivel = $usuarioLogado['nivel'];
	
		if($nivel <= 3){
	
	 ?>
    	<h2>Carrinho<br><span>Revise todos os itens do seu pedido e finalize a compra. Voce ainda pode alterar as informaçoes de cada item. seu budget atual é R$<?php echo $usuarioLogado['budgetMerchandising']; ?></span></h2>
        
        <?php
		}else{
		?>
        
        <h2>Carrinho<br><span>Revise todos os itens do seu pedido e finalize a compra. Voce ainda pode alterar as informaçoes de cada item.</span></h2>
        <?php
		}
		?>
        
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr class="semBorda">
            	<td align="center"><img src="img/passos_carrinho.png"></td>
            </tr>
        </table>
        <?php 
			$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$usuario = $usuarioLogado['idUsuario'];
            $buscaPedido = odbc_exec($conexao, "SELECT * FROM dbo.PedidoDMTRIX where idUsuario = '$usuario' and status_pedido = 1");
			
            while($rsBuscaPedido = odbc_fetch_array($buscaPedido)){
						if($rsBuscaPedido['custeio'] != "" and $rsBuscaPedido['formaPagamento'] != "")
						{
							echo "<script>alert('Você ja Preencheu os valores destes itens, você será redirecinado para a pagina de briefing para continuarmos a solicitação');</script>";
							echo "<script>location.href='briefing.php';</script>";
							
						}
			
						$idmaterial = $rsBuscaPedido['idMaterial'];
						$nomeMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX where idMaterial = '$idmaterial'");
						
						$rsnomeMaterial = odbc_fetch_array($nomeMaterial);
						
						$nomeMaterial = $rsnomeMaterial['material'];
						$valor = $rsnomeMaterial['valor'];
						?>
                        
	
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td colspan="3">Material</td>
                    <td style="text-align:right">Descrição do Material</td>
                    <td style="text-align:right">Valor do Material</td>
                    <td align="right" style="padding-right:5px;">Valor Final</td>
                </tr>
            </thead>
            </table>
            <form action="carrinho.php" method="post">
            <input type="hidden" name="idPedido2" value="<?php echo $rsBuscaPedido['idPedido'];?>">
            <input type="submit" class="removerLinhaProduto botaoexcluir" name="excluir" value="x"> 
            
            </form>
            
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            
            	
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            	
            	<tr>
                	
                <!--	<td class="removerLinhaProduto">x</td> -->
                   
                    
                	
                	<td><?php echo $nomeMaterial;?></td>
                    <td><div class="clear"><img class="imagemTodosMateriais" src="../dmtrade/img/brindes/<?php echo $rsnomeMaterial['foto'];?>"></div></td>
                    <td width="500px">
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr class="semBorda">
                                <td>Largura<div class="campo"><input type="text" name="largura" value="<?php echo $rsBuscaPedido['largura']; ?>"  class="left" placeholder="Largura" autocomplete="off"  data-mask-reverse="true"></div></td>
                                <td>Altura<div class="campo"><input type="text" name="altura" value="<?php echo $rsBuscaPedido['altura']; ?>" class="left" placeholder="Altura" autocomplete="off"  data-mask-reverse="true"></div></td>
                               
                                <td>Quantidade<div class="campo"><input type="text" name="quantidade" value="<?php echo $rsBuscaPedido['quantidade']; ?>" class="left" placeholder="Quantidade" autocomplete="off" data-mask="0000000" data-mask-reverse="true"></div></td>
                               
                               
                            </tr>
                            <tr class="semBorda">
                                <td colspan="9">Observações<div class="campo"><textarea name="observacao" class="left" placeholder="<?php echo $rsBuscaPedido['observacao']; ?>" style="line-height:25px;"><?php echo $rsBuscaPedido['observacao']; ?></textarea></div></td>
                                <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">

                               
                            </tr>
                        </table>
                                         
                    </td>
                    <td width="90px">R$<?php echo $valor; ?>m²</td>
                    <?php $largura =  $rsBuscaPedido['largura']/100;
						 $altura =  $rsBuscaPedido['altura']/100;
						 $quantidade = $rsBuscaPedido['quantidade'];
						$valorMaterial = round((($largura*$altura)*$valor*$quantidade),2);
						$_SESSION['valorTotal'] = $valorMaterial;
						
						 ?>
                    <input type="hidden" value="<?php echo $valorMaterial;?>" name="valorProduto" style="width:50px;">
                    
                    <td width="80px" class="valorProduto" align="right">R$<?php echo $valorMaterial?></td>
                </tr>
                <tr>
                <td align="char" colspan="6"><input type="submit" name="Passo" value="Atualizar" class="largura25 right btnAzul"></td>
                </tr>
                <?php }; ?>
                </tbody>
               </table>
               </form>
               
              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
              
               <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
               	<tbody>
                <tr>
                	<td colspan="6"  height="50px"><div class="produtoOculto">
                    
                    </div></td>
                </tr>
                
                <tr>
                	<td colspan="3">
                        <div class="largura100 left campo">
                        	
                            <select onChange="somaProdutos()" class="valorTotal" name="custeio">
                                <option value="">Defina o Custeio</option>
                                <option value="100% DMcard">100% DMcard</option>
                                <option value="100% Loja">100% Loja</option>
                                <option value="50% Loja e 50% DMcard">50% Loja e 50% DMcard</option>
                            </select>
                        </div>                    
                    </td>
                    <td>
                    <?php
					$nivel=$usuarioLogado['nivel'];
                    $usuarioAtual = $usuarioLogado['idUsuario'];

						if($nivel == 4){
					 	 $buscaLoja = odbc_exec($conexao, "SELECT * FROM dbo.lojasDMTRIX where responsavel = '$usuario'");
						}else if($nivel == 3)
						{
							$buscaLoja = odbc_exec($conexao, "SELECT * FROM lojasDMTRIX l INNER JOIN dbo.usuariosDMTRIX u
						ON l.responsavel = u.idUsuario WHERE u.supervisor = '$usuario' OR
						u.idUsuario = '$usuario'");
						}else
                        {
                            $buscaLoja = odbc_exec($conexao, "SELECT * FROM lojasDMTRIX where idLoja = 913");
                        }

                    if($usuarioAtual == 83)
                    {

                        $buscaLoja = odbc_exec($conexao, "SELECT * FROM lojasDMTRIX where rede = 'Construja'");


                    }
                    $buscaPedido = odbc_exec($conexao, "SELECT * FROM dbo.PedidoDMTRIX where idUsuario = '$usuario' and status_pedido = 1");
                    while($rsBuscaPedido = odbc_fetch_array($buscaPedido)){

                        ?>
                        <input type="hidden" value="<?php echo $rsBuscaPedido['idMaterial']; ?>" name="idMaterial[]">
                        <input type="hidden" value="<?php echo $rsBuscaPedido['idPedido']; ?>" name="idPedido[]"> <!-- receber o id do Material para fazer as verificações no briefing -->
                    <?php

                    }
						  
					?>
                        <div class="largura100 left campo">
                            <select class="loja" required name="loja">
                                <option value="">Defina a Loja</option>
                               <?php while($rsbuscaLoja = odbc_fetch_array($buscaLoja)) {?>
                                <option value="<?php echo $rsbuscaLoja['idLoja'];?>"><?php echo $rsbuscaLoja['numeroLoja']." - ".$rsbuscaLoja['nomeLoja'];?></option>
                                
                                <?php };
								?>
                            </select>
                        </div>                       
                    </td>
                	<td colspan="2" class="valorTotal" align="right">Total: <span>R$222.00</span><input type="hidden" name="valorTotal" style="width:50px;"></td>
                   
                </tr>
                
                <tr class="semBorda">
                	<td colspan="3">
                        <div class="largura100 left campo">
                            <select name="formaPagamento" required>
                                <option value="">Defina a Forma de Pagamento</option>
                                <option value="Sem Forma de Pagamento">Sem Forma de Pagamento</option>
                                <option value="Desconto no reembolso">Desconto no reembolso</option>
                                <option value="Boleto Bancario">Boleto Bancario</option>
                  
                            </select>
                        </div>                    
                    </td>
                    <td>
                        <div class="largura100 left campo" required>
                            <select name="segmento">
                                <option value="">Segmento</option>
                                <option value="Merchandising de Lançamento">Merchandising de Lançamento</option>
                                <option value="Merchandising de Reposição">Merchandising de Reposição</option>
                                <option value="Campanha">Campanha</option>
                                <option value="Solicitação extra">Solicitação extra</option>
                            </select>
                        </div>                       
                    </td>
                	<td colspan="2" align="right"></td>
                </tr>
                
                <tr>
                	<td align="right" colspan="6"><input type="submit" name="briefing" value="Próximo Passo" class="largura25 right btnAzul"></td>
                </tr>
            </tbody>
        </table>
      </form>
      
    </div>
    
    <?php
	  		$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			if(isset($_POST['Passo'])){	
			$largura = 	$_POST['largura'];
			$altura = 	$_POST['altura'];
			$quantidade = $_POST['quantidade'];
			$observacao= 	$_POST['observacao'];
			$id =			$_POST['idPedido'];
			$valorMaterial=	$_POST['valorProduto'];
			$budget = $usuarioLogado['budgetMerchandising'];
			
					
	 			EditCarrinho($largura, $altura, $quantidade, $observacao, $id, $valorMaterial, $usuarioLogado['nome'],$usuarioLogado['idUsuario']);
				
			
			}else if(isset($_POST['excluir']))
						{
						$id = $_POST['idPedido2'];
							DeletaPedido($id,$usuarioLogado['nome'],$usuarioLogado['idUsuario'],2);
			}else if(isset($_POST['briefing'])) {


                $idMaterial = $_POST['idMaterial'];
                $idPedido = $_POST['idPedido'];
                $custeio = $_POST['custeio'];
                $pagamento = $_POST['formaPagamento'];
                $segmento = $_POST['segmento'];
                $idUsuario = $usuarioLogado['idUsuario'];
                $valorTotal = $_POST['valorTotal'];
                $lojaid = $_POST['loja'];
                $query2 = false;

                for ($i = 0 ; $i < count($idPedido); $i++) {

                    $sql = odbc_exec($conexao, "select * from materiaisDMTRIX  where idMaterial = '$idMaterial[$i]'");
                    $rsSql = odbc_fetch_array($sql);
                    $formaCalculo = $rsSql['formaCalculo'];

                 if ($formaCalculo != 1)
                 {

                    if ($budget >= $valorTotal and $lojaid != "") {


                        $query2 = odbc_exec($GLOBALS['conexao'], " update [marketing].[dbo].[PedidoDMTRIX] set  idLoja = '$lojaid', valorTotal='$valorTotal',custeio = '$custeio', formaPagamento= '$pagamento', segmento= '$segmento'  where idPedido = '$idPedido[$i]'");

                    } else if ($budget < $valorTotal) {
                        $query2 = false;
                        echo "<script>alert('Você não tem budget sufuciente para esta compra!, caso tenha produtos Free no seu carrinho, retire os produtos com preço para a compra ser processada!');</script>";
                        return false;

                    }
                }else
                 {

                     $query2 = odbc_exec($GLOBALS['conexao'], " update [marketing].[dbo].[PedidoDMTRIX] set  idLoja = '$lojaid', valorTotal='$valorTotal',custeio = '$custeio', formaPagamento= '$pagamento', segmento= '$segmento'  where idPedido = '$idPedido[$i]'");

                 }

            }


	if($query2 == true)
	{
		echo "<script>location.href='briefing.php';</script>"; 
		return true;
		}else
	    {
		echo "<script>alert('Ocorreu um erro, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	    }
	
	
							
		};
						
			
						
	
	 include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>