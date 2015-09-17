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

<body onLoad="somaProdutos(), verificaLogin(), pedidos();">
<div class="msgAlerta"></div>
<?php include("topo.php"); 
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));?>

<div class="centro">
	<div class="clear bgBranco secaoInterna aprovar-reprovar">
    	<h2>Rastreio do Pedido<br><span>Saiba o status atual do seu pedido.</span></h2>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0"><!-- esta table é para ajuste no firefox que a primeira table sai fora da tela -->
        </table>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            	<td><div class="campo"><input type="text" name="token" class="left" placeholder="Insira o Código/Token do Pedido" autocomplete="off" data-mask="00000000" data-mask-reverse="true" ></div></td>

                <td><div class="campo"><select name="status">
                            <option value="">selecionar Status</option>
                            <option value="2">Pedidos aguardando orçamento</option>
                            <option value="9">Pedidos aguardando aprovação de orçamento</option>
                            <option value="3">Pedidos com orçamento aprovados</option>
                            <option value="3">Pedidos com orçamento reprovado</option>
                            <option value="5">Pedidos em criação/aguardando aprovação de arte</option>
                            <option value="6">Pedidos com Arte aprovada</option>
                            <option value="7">Pedidos com Arte reprovadas</option>
                            <option value="8">Pedidos com Fornecedor</option>
                            <option value="11">Pedidos Finalizados</option>


                        </select></div></td>
            </tr>





            <tr>
            	<td colspan="2"><input type="submit" name="Buscar" value="Procurar Pedido" class="largura30 right btnSubmit"></td>
            </tr>
            
            <tr id="informacoes">
            	
            </tr>
            
          
   
       
        
         <?php 

				$nivel = $usuarioLogado['nivel'];
		 		if(isset($_POST['Buscar'])){
				$idCompra = $_POST['token'];
                    $status = $_POST['status'];
				$usuario = $usuarioLogado['idUsuario'];

				
				if($nivel == 1 or $nivel == 2){

                    if($status == "") {

                        $buscapedido = odbc_exec($conexao, " SELECT p.idLoja, p.acao,p.altura,p.custeio,p.Data_do_Pedido,p.data_entrega,p.formaPagamento,p.formaPagamento,p.idCompra,p.idLoja,p.idMaterial,p.idPedido,p.idUsuario,p.largura,p.objetivo,p.observacao,p.publicAlvo,p.quantidade,p.segmento,p.status_pedido,
  p.valorProduto,p.valorTotal, m.material,m.categoria FROM [marketing].[dbo].[PedidoDMTRIX] p inner join marketing.dbo.materiaisDMTRIX m  on p.idMaterial = m.idMaterial  
  where p.idCompra = '$idCompra'");

                    }else
                    {
                        $buscapedido = odbc_exec($conexao, " SELECT p.idLoja, p.acao,p.altura,p.custeio,p.Data_do_Pedido,p.data_entrega,p.formaPagamento,p.formaPagamento,p.idCompra,p.idLoja,p.idMaterial,p.idPedido,p.idUsuario,p.largura,p.objetivo,p.observacao,p.publicAlvo,p.quantidade,p.segmento,p.status_pedido,
  p.valorProduto,p.valorTotal, m.material,m.categoria FROM [marketing].[dbo].[PedidoDMTRIX] p inner join marketing.dbo.materiaisDMTRIX m  on p.idMaterial = m.idMaterial
  where p.status_pedido = '$status'");


                    }

				}else
				{

                    if($status == "") {
                        $buscapedido = odbc_exec($conexao, " SELECT p.idLoja, p.acao,p.altura,p.custeio,p.Data_do_Pedido,p.data_entrega,p.formaPagamento,p.formaPagamento,p.idCompra,p.idLoja,p.idMaterial,p.idPedido,p.idUsuario,p.largura,p.objetivo,p.observacao,p.publicAlvo,p.quantidade,p.segmento,p.status_pedido,
  p.valorProduto,p.valorTotal, m.material,m.categoria FROM [marketing].[dbo].[PedidoDMTRIX] p inner join marketing.dbo.materiaisDMTRIX m  on p.idMaterial = m.idMaterial  
  where p.idUsuario = '$usuario' and p.idCompra = '$idCompra'");
                    }else
                    {
                        $buscapedido = odbc_exec($conexao, " SELECT p.idLoja, p.acao,p.altura,p.custeio,p.Data_do_Pedido,p.data_entrega,p.formaPagamento,p.formaPagamento,p.idCompra,p.idLoja,p.idMaterial,p.idPedido,p.idUsuario,p.largura,p.objetivo,p.observacao,p.publicAlvo,p.quantidade,p.segmento,p.status_pedido,
  p.valorProduto,p.valorTotal, m.material,m.categoria FROM [marketing].[dbo].[PedidoDMTRIX] p inner join marketing.dbo.materiaisDMTRIX m  on p.idMaterial = m.idMaterial
  where p.idUsuario = '$usuario' and  p.status_pedido = '$status'");
                    }
					
					
				}
				if($buscapedido <= 0)
					{
					echo "<script>alert('Compra não encontrada'); location.href='rastreio.php';</script>";
					}else{

					while($rsBuscaPedido = odbc_fetch_array($buscapedido)){
						$status = $rsBuscaPedido['status_pedido'];
						$idMaterial = $rsBuscaPedido['idMaterial'];
						$idPedido = $rsBuscaPedido['idPedido'];
						
						
						$buscaMotivo = odbc_fetch_array(odbc_exec($conexao," select * from [marketing].[dbo].[ControleReprovacoesDMTRIX] where idPedido = '$idPedido'"));
						
							?>
                           	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                            <thead>
                            <td>Compra:</td>
                            <td>Loja:</td>
                            <td>Material:</td>
                            <td>Status:</td>
                            <td>Largura cm:</td>
                            <td>Altura cm:</td>
                            <td>Quantidade:</td>
                            <td>Valor: </td>
                            <td>Custeio: </td>
                            
                            
                            </thead>
                            </tr>
                            <tr class="semBorda">
                                <td width="15%"><div class="campo"><input type="text"readonly name="idCompra" value="<?php echo $rsBuscaPedido['idCompra']; ?>"  class="left"></div></td>
                                <?php

                                $idLoja =  $rsBuscaPedido['idLoja'];

                                $loja = odbc_fetch_array(odbc_exec($conexao, "select nomeLoja, rede from lojasDMTRIX where idLoja = '$idLoja'"));

                                ?>

                                <td width="15%"><div class=""><textarea readonly name="loja"   class=""><?php echo "Loja: ".$loja['nomeLoja']." ,rede: ". $loja['rede']; ?></textarea></div></td>
                            	<td width="15%"><div class="campo"><input type="text"readonly name="Material" value="<?php echo $rsBuscaPedido['material']; ?>"  class="left"></div></td>
                                
                            	                                <?php $status = $rsBuscaPedido['status_pedido'];
																$texto = "";
																
																if($status == 3)
																{
																	$texto = "Aprovado";

																}else if($status == 6)
																{
																	$texto = "Aprovado Arte";
																}
																else if($status == 4 || $status == 7){$texto = "Reprovado";
																}else if($status == 9){$texto = "Aguardando Aprovação!";}
																else if($status == 5){$texto = "Em fabricação!";}else if($status == 10){$texto = "Aguardando aprovação da Arte!";}
																else if($status == 8){$texto = "Com Fornecedor";}else if($status == 11){$texto = "Finalizado";}else{$texto = "Correção de valores";}
																?>
                                                                <input type="hidden" name="Status_pedido" value="<?php echo $status; ?>"> <!--para o script pegar o valor do status e mostrar as barras -->

                                <td width="15%"><div class="campo"><input type="text" name="Status"readonly value="<?php echo $texto; ?>"  class="left"></div></td>
                                
                                <td><div class="campo"><input type="text" name="largura"readonly value="<?php echo $rsBuscaPedido['largura'];?>"  class="left" autocomplete="off" data-mask="0000.00" data-mask-reverse="true"></div></td>
                                <td> <div class="campo"><input type="text" name="altura" readonly value="<?php echo $rsBuscaPedido['altura']; ?>" class="left"  autocomplete="off" data-mask="0000.00" data-mask-reverse="true"></div></td>
                               
                                <td><div class="campo"><input type="text" name="quantidade" readonly value="<?php echo $rsBuscaPedido['quantidade']; ?>" class="left"  autocomplete="off" data-mask-reverse="true"></div></td>
                                <td><div class="campo"><input type="text" name="Valor" readonly value="<?php echo $rsBuscaPedido['valorProduto']; ?>" class="left" autocomplete="off"></div></td>
                                <td><div class="campo"><input type="text" name="Custeio" readonly value="<?php echo $rsBuscaPedido['custeio']; ?>" class="left"  autocomplete="off" ></div></td>
                            </tr>
                            
                            <thead><tr>
                            
                            </tr> </thead>
                            <thead>
                            <tr class="semBorda">
                            <td colspan="1">Ação:</td>
                            <td>Publico Alvo: </td>
                            <td>Objetivo: </td>
                            <td>Observação:</td>
                            <td>Motivo da reporvação.</td>
                            <td colspan="2">Motivo da Arte Reprov.</td>
                            <td colspan="2">Data de Reprovação: </td>
                            </tr>
                            </thead>
                            <tr class="semBorda">
                                <td colspan="" width="15%" ><div class="campo"><input type="text" name="acao" value="<?php echo $rsBuscaPedido['acao']; ?>" readonly class="left"></div></td>
                                <td > <div class="campo"><textarea name="publico" class="left" readonly ><?php echo $rsBuscaPedido['publicAlvo']; ?></textarea></div></td>
                                <td> <div class="campo"><textarea name="Objetivo" class="left" readonly  ><?php echo $rsBuscaPedido['objetivo']; ?></textarea></div></td>
                                <td><div class=""><textarea name="observacao" class="left" readonly  ><?php echo $rsBuscaPedido['observacao']; ?></textarea></div></td>
                                <td> <div class="campo"><textarea readonly name="Motivo" class="left"><?php echo $buscaMotivo['Motivo']; ?></textarea></div></td>
                                <td colspan="2"><div class="campo"><textarea readonly name="MotivoArte" class="left"><?php echo $buscaMotivo['MotivoArte']; ?></textarea></div></td>
                                <td colspan="2"><div class="campo"><input type="text" name="Data" data-mask="00/00/0000" data-mask-reverse="true" readonly value="<?php echo $buscaMotivo['data_reprovado']; ?>" class="left"  autocomplete="off" ></div></td>
                                
                                                               
                            </tr>
                            
                          
                          
                           <thead><tr>                    
        				</tr> 
        				</thead> 
                         <tr class="semBorda"><td></td></tr>
                        </table>
                        
        					 
                            <?php
							};
							
		 				 }
			
				}
		?>
       
       						</table>
                          </form>     											   
      
       						
       						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

       						<tr>
            					<td style="display:none" id="status" align='center'><img src='img/passos_correcao_de_valor.png'></td>
                				<td style="display:none" id="status3" align='center'><img src='img/BarraStatus2.png'></td>
                				<td style="display:none" id="status5" align='center'><img src='img/BarraStatus3.png'></td>
                				<td style="display:none" id="status6" align='center'><img src='img/BarraStatus4.png'></td>
                
            				</tr> 
                            </table>	
       
        
    </div>
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
</body>
</html>