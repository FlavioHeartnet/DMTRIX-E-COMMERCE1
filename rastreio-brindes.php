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

<body onLoad="somaProdutos(),verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>
<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));?>
<div class="centro">
	<div class="clear bgBranco secaoInterna compra-finalizada">
    <h2>Rastreio de Brindes<br><span>Aqui você pode conferir suas compras realizadas e os produtos pedidos</span></h2>
    
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            	<td><div class="campo"><input type="text" name="token" class="left" placeholder="Insira o Código/Token do Pedido" autocomplete="off" data-mask="00000000" data-mask-reverse="true" required></div></td>
            </tr>
            <tr>
            	<td><input type="submit" name="Buscar" value="Procurar Pedido" class="largura30 right btnSubmit"></td>
            </tr>
            
            <tr id="informacoes">
            	
            </tr>

         <?php 
		 		$status = "";
		 		if(isset($_POST['Buscar'])){
				$idCompra = $_POST['token'];
				$usuario = $usuarioLogado['idUsuario'];
				$buscapedido = odbc_exec($conexao, "SELECT * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] where idUsuario = '$usuario' and idCompra = '$idCompra'"); 
				if($buscapedido != true)
					{
					echo "<script>alert('Compra não encontrada'); location.href='rastreio-brindes.php';</script>";
					}else{

					while($rsBuscaPedido = odbc_fetch_array($buscapedido)){
						$status = $rsBuscaPedido['statusBrindes'];
						$idBrinde = $rsBuscaPedido['idBrinde'];
						$idPedido = $rsBuscaPedido['idPedido'];
						
						
							?>
                           	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                            <thead>
                            <td>Nome:</td>
                            <td>Numero da Compra: </td>
                            <td>Motivo da Compra:</td>
                            <td>Valor:</td>
                            <td>Valor Total da Compra</td>
                            <td>Quantidade:</td>
                          
                            
                            
                            
                            </thead>
                            </tr>
                            <tr class="semBorda">
                            	<td width="15%"><div class="campo"><input type="text"readonly name="Nome" value="<?php echo $rsBuscaPedido['NomeBrinde']; ?>"  class="left"></div></td>
                                <td><div class="campo"><input type="text" name="compra" readonly value="<?php echo  $rsBuscaPedido['idCompra']; ?>" class="left"></div></td>
                            	                              
                                                                <input type="hidden" name="Status_pedido" value="<?php echo $status; ?>"> <!--para o script pegar o valor do status e mostrar as barras -->
                                <td><div class="campo"><input type="text" name="Motivo"readonly value="<?php echo $rsBuscaPedido['motivo']; ?>"  class="left"></div></td>
                                <td> <div class="campo"><input type="text" name="valor" readonly value="R$ <?php echo number_format($rsBuscaPedido['ValorBrinde'],2); ?>" class="left" ></div></td>
                               
                                <td><div class="campo"><input type="text" name="valorCompra" readonly  value="R$ <?php echo number_format($rsBuscaPedido['valorTotal'],2);  ?>" class="left"></div></td>
                                 <td width="15%"><div class="campo"><input type="text" name="quantidade"readonly value="<?php echo $rsBuscaPedido['quantidade'];?>"  class="left"></div></td>
                               
                                
                            </tr>
                            
                            <thead><tr>
                            
                            </tr> </thead>

                        </table>
                        
        
                            
                            <?php
							};
							
		 				 }
			
				}
		?>
       
         											   
       </table>
       							
      </form>  
    
    
    
    </div>
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>