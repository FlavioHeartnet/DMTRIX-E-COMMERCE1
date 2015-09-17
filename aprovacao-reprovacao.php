<?php
include_once("analyticstracking.php"); 
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
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />

</head>

<body onLoad="verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna aprovar-reprovar">
    	<h2>Aprovação e Reprovação<br><span>Aprove ou reprove seus pedidos no DMTrix.</span></h2>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    
                    <td>Código/Token</td>
                    <td>Material</td>
                    <td>Loja</td>
                    <td>Valor</td>
                    <td>Ver Arte</td>
                    <td>Orçamento</td>
                    <td>Arte</td>
                </tr>
            </thead>
            <?php 
			$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$usuario = $usuarioLogado['idUsuario'];
            $buscaPedido = odbc_exec($conexao, "SELECT * FROM dbo.PedidoDMTRIX where idUsuario = '$usuario' and status_pedido > 1");
			
						//id para uso do radiobox
						$id1 = 1;
						$id2 = 2;
						$id3 = 3;
						$id4 = 4;
			while($rsBuscaPedido = odbc_fetch_array($buscaPedido)){
						// status da solicitação para verificar se foi aprovada ou nao
						$status = $rsBuscaPedido['status_pedido'];
						//Pega id loja e o nome
						$idLoja = $rsBuscaPedido['idLoja'];
						$loja = odbc_exec($conexao,"select * from dbo.lojasDMTRIX where idLoja = '$idLoja'");
						$rsLoja =  odbc_fetch_array($loja); $loja = $rsLoja['nomeLoja'];
						
						//pega o id e nome do material
						$idmaterial = $rsBuscaPedido['idMaterial'];
						$nomeMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX where idMaterial = '$idmaterial'");
						$rsnomeMaterial = odbc_fetch_array($nomeMaterial);
						$nomeMaterial = $rsnomeMaterial['material'];
						
						if($status != 11 and $status != 8){
						
						?>
            <tbody>
                <tr>
                   
                    <td><?php echo $rsBuscaPedido['idCompra']; ?></td>
                    <td><?php echo $nomeMaterial; ?></td>
                    <td><?php echo $loja; ?></td>
                    <td><?php echo $rsBuscaPedido['valorProduto'];?></td>
                            <?php
                        $link = $rsBuscaPedido['fotoArte'];
                                if($link == null or $link == "")
                                {
                                     ?>
                                    <td><a>Arte ainda não disponivel</a></td>
                                    <?php

                                }else
                                {
                                    ?>
                                    <td><a style="margin-top:25%" data-fancybox-group="gallery" href="../dmtrade/img/brindes/<?php echo $rsBuscaPedido['fotoArte'];?>" class="fancybox">Clique aqui para visualizar a imagem</a></td>
                                <?php

                                }

                            ?>
                    <td class="checks">
                    <?php 
							//inicio estrutura para verificar se a solicitação esta aprovada ou não
						if($status == 3)
						{		
					?>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>" ><label for="l<?php echo $id1; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                        <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                    <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled type="radio" name="ReprovarOrcamento" id="l<?php echo $id2;?>" class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                    <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                    </td>
                    <td class="checks">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled  type="radio" name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label> 
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled type="radio" name="ReaprovarArte"  id="l<?php echo $id4;?>"  class=" vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                    <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                    </form>
                    
                    </td>
                </tr>
            </tbody>
            <?php 
						//contador do radio
						$id1+=4;
						$id2+=4;
						$id3+=4;
						$id4+=4;
					}else if($status == 4)
					{
						?>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input   type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>" ><label for="l<?php echo $id1; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                        <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                    <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked type="radio" name="ReprovarOrcamento" id="l<?php echo $id2;?>"  class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                    <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                    </td>
                    <td class="checks">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled  type="radio" name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label> 
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled type="radio" name="ReaprovarArte"  id="l<?php echo $id4;?>"  class=" vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                    <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                    </form>
         
                 
                    
                    </td>
                </tr>
            </tbody>
            <?php 
						//contador do radio
						$id1+=4;
						$id2+=4;
						$id3+=4;
						$id4+=4;
					}else if($status == 6)
						{
							?>
                    
                   <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked disabled type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>" ><label for="l<?php echo $id1; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                       <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                    <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled  type="radio" name="ReprovarOrcamento" id="l<?php echo $id2;?>"  class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                    <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Comfirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                    </td>
                    <td class="checks">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked disabled type="radio" name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label> 
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled  type="radio" name="ReaprovarArte"  id="l<?php echo $id4;?>"  class=" vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                    <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                    </form>
         
                 
                    
                    </td>
                </tr>
            </tbody>
            <?php 
						//contador do radio
						$id1+=4;
						$id2+=4;
						$id3+=4;
						$id4+=4;
							
						}else if($status == 7)
							{
								?>
                    
                   <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled checked type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>" ><label for="l<?php echo $id1; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                       <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                    <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled type="radio" name="ReprovarOrcamento" id="l<?php echo $id2;?>"  class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                    <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Comfirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                    </td>
                    <td class="checks">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input  type="radio" name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label> 
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked type="radio" name="ReaprovarArte"  id="l<?php echo $id4;?>"  class=" vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                    <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                    </form>
         
                 
                    
                    </td>
                </tr>
            </tbody>
            <?php 
						//contador do radio
						$id1+=4;
						$id2+=4;
						$id3+=4;
						$id4+=4;
							}else if($status == 9) 
							{
								?>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"><input type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>" ><label for="l<?php echo $id1;?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                        <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                    <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input type="radio" name="ReprovarOrcamento" id="l<?php echo $id2;?>"  class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                    <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                    </td>
                    <td class="checks">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled type="radio" name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled type="radio" name="ReaprovarArte"  id="l<?php echo $id4;?>"  class="vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                    <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                    </form>
         
                 
                    
                    </td>
                </tr>
            </tbody>
            <?php 
					//contador do radio
						$id1+=4;
						$id2+=4;
						$id3+=4;
						$id4+=4;
							}else if($status == 5) 
							{
                                if($link == ""){

                                    ?>

                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked disabled type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>"><label for="l<?php echo $id1; ?>">Aprovar</label>
                                        <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                                        <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                                        <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                                        <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input type="radio" disabled name="ReprovarOrcamento" id="l<?php echo $id2;?>"  class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                                        <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                                            <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                                        <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                                        <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                                    </td>
                                    <td class="checks">
                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input  type="radio" disabled name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label>
                                        <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                                        <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input  type="radio" disabled name="ReaprovarArte"  id="l<?php echo $id4;?>"  class="vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                                        <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                                            <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                                        <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                                        <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                                    </form>

                                    <?php


                                }else{

								?>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked disabled type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>"><label for="l<?php echo $id1; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                        <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                    <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input type="radio" disabled name="ReprovarOrcamento" id="l<?php echo $id2;?>"  class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                    <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                    </td>
                    <td class="checks">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input  type="radio" name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input  type="radio" name="ReaprovarArte"  id="l<?php echo $id4;?>"  class="vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                    <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                    </form>

                                <?php } ?>
                    
                    </td>


            <?php 
					//contador do radio
						$id1+=4;
						$id2+=4;
						$id3+=4;
						$id4+=4;
						}else if($status == 10) 
							{
								?>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input checked  type="radio" name="aprovarOrcamento" id="l<?php echo $id1;?>" ><label for="l<?php echo $id1; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                        <input type="hidden" name="idLoja" value="<?php echo $rsBuscaPedido['idLoja'];?>">
                    <input type="hidden" name="valoProduto" value="<?php echo $rsBuscaPedido['valorProduto'];?>"></form><br><!--controle para pegar idpedido e compra e salvar no banco de dados -->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input disabled type="radio" name="ReprovarOrcamento" id="l<?php echo $id2;?>"  class="vermelho"><label for="l<?php echo $id2; ?>">Reprovar</label><br>
                    <div class='tlg1'><textarea name="observacaoA" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form>
                    </td>
                    <td class="checks">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input  type="radio" name="aprovarArte" id="l<?php echo $id3;?>" ><label for="l<?php echo $id3; ?>">Aprovar</label>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>"></form><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> <input  type="radio" name="ReaprovarArte"  id="l<?php echo $id4;?>"  class="vermelho"><label for="l<?php echo $id4; ?>">Reprovar</label><br>
                    <div class='tlg2'><textarea required name="observacao" placeholder="Digite o motivo de reprovar"></textarea><br>
                    <input type="submit" class="btnSubmit largura50" value="Confirmar"></div>
                    <input type="hidden" name="idPedido" value="<?php echo $rsBuscaPedido['idPedido'];?>">
                    <input type="hidden" name="idCompra" value="<?php echo $rsBuscaPedido['idCompra'];?>">
                    </form>
         
                 
                    
                    </td>
                </tr>
            </tbody>
            <?php 
					//contador do radio
						$id1+=4;
						$id2+=4;
						$id3+=4;
						$id4+=4;
						}
						
					}// verificar o status 11, finalizado
					
			}; ?>
        </table>
    </div>
    <?php 
	// fim da estrutura de verificação
					if(isset($_POST['aprovarOrcamento']))
					{
						$status = 3;
						$idUsuario = $usuarioLogado['idUsuario'];
						$nome = $usuarioLogado['nome'];
						$idPedido = $_POST['idPedido'];
						$compra =  $_POST['idCompra'];
						$motivo = "";
						$motivoArte = "";
						$valoProduto = $_POST['valoProduto'];
                        $idLoja = $_POST['idLoja'];
						
						
						
						Aprovacoes($status, $idPedido, $idUsuario, $nome,$compra, $motivo, $motivoArte, $valoProduto, $idLoja);
					}
					
					if(isset($_POST['ReprovarOrcamento']))
					{
						$status = 4;
						$idUsuario = $usuarioLogado['idUsuario'];
						$nome = $usuarioLogado['nome'];
						$compra =  $_POST['idCompra'];
						$idPedido = $_POST['idPedido'];
						$motivo = $_POST['observacaoA'];
						$compra = $rsBuscaPedido['idCompra'];
						$reprovado = "sim";
						$valoProduto = 0;
                        $idLoja = 0;
						
						
						Aprovacoes($status, $idPedido, $idUsuario, $nome,$compra, $motivo, $motivoArte, $valoProduto, $idLoja);
					}
					
					if(isset($_POST['aprovarArte']))
					{
						$status = 6;
						$idUsuario = $usuarioLogado['idUsuario'];
						$nome = $usuarioLogado['nome'];
						$idPedido = $_POST['idPedido'];
						$compra =  $_POST['idCompra'];
						$motivo = "";
						$motivoArte = "";
						$valoProduto = 0;
                        $idLoja = 0;
						
						
						Aprovacoes($status, $idPedido, $idUsuario, $nome,$compra, $motivo, $motivoArte, $valoProduto, $idLoja);
					}
					
					if(isset($_POST['ReaprovarArte']))
					{
						$status = 7;
						$idUsuario = $usuarioLogado['idUsuario'];
						$nome = $usuarioLogado['nome'];
						$idPedido = $_POST['idPedido'];
						$motivoArte = $_POST['observacao'];
						$compra =  $_POST['idCompra'];
						$reprovadoArte = "sim";
						$motivo = "";
						$valoProduto = 0;
                        $idLoja = 0;
						
					
						Aprovacoes($status, $idPedido, $idUsuario, $nome,$compra, $motivo, $motivoArte, $valoProduto, $idLoja);
					}	
	
	include("rodape.php");
	?>
    
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

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
			
$('.tlg1').hide();
$('.tlg2').hide();
</script>

</body>
</html>