<div id="boxResumo" class="boxResumo escondido">
    <h2>Resumo do Pedido <span>--</span></h2>
    <div class="resumoPedido">
    <?php
			$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$usuario = $usuarioLogado['idUsuario'];
            $buscaPedido = odbc_exec($conexao, "SELECT * FROM dbo.PedidoDMTRIX where idUsuario = '$usuario' and status_pedido = 1");
			
			$buscaBrinde = odbc_exec($conexao, "select * from [marketing].[dbo].[PedidoBrindesDMTRIX] where idUsuario = '$usuario' and statusBrindes = 1");

			
			$count = odbc_num_rows($buscaBrinde);
			
			
			if($count == 0){
			
			
            while($rsBuscaPedido = odbc_fetch_array($buscaPedido)){
				
			
						$idmaterial = $rsBuscaPedido['idMaterial'];
						$nomeMaterial = odbc_exec($conexao, "SELECT material FROM dbo.materiaisDMTRIX where idMaterial = '$idmaterial'");
						$valor = odbc_exec($conexao, "SELECT valor FROM dbo.materiaisDMTRIX where idMaterial = '$idmaterial'");
						$quantidade = odbc_exec($conexao, "SELECT quantidade FROM dbo.materiaisDMTRIX where idMaterial = '$idmaterial'");
						
						$rsnomeMaterial = odbc_fetch_array($nomeMaterial);
						$nomeMaterial = $rsnomeMaterial['material'];
						
						$rsvalor = odbc_fetch_array($valor);
						$valor = $rsvalor['valor'];
						
						$rsquantidade = odbc_fetch_array($quantidade);
						$quantidade = $rsBuscaPedido['quantidade'];

        	?>
   	
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        
        
		<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">	
                <tr>
                    <td class="removerLinhaProduto">x</td>
                    <td></td>
                    
                    <td><span><?php echo $nomeMaterial;?></span><br>Valor: R$<?php echo $valor;?> | Quantidade: <?php echo $quantidade;?></span></td>
                </tr>
       	</table>
        <input type="hidden" name="id" value="<?php echo $rsBuscaPedido['idPedido'];?>">
        </form>
        
        <?php
		};
		
		$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
			
			DeletaPedido($id,$usuarioLogado['nome'],$usuarioLogado['idUsuario'],1);
		};
				
			
	 ?>
 		<form action="carrinho.php" method="post">
        <input style="margin-left:50px" type="submit" name="carrinho" value="Visualizar Carrinho" class="largura60 center btnAzul">	
      </form>
      <?php }else
	  	{
		  	 while($rsBuscaBrinde = odbc_fetch_array($buscaBrinde)){
				 $idBrinde = $rsBuscaBrinde['idBrinde'];
				 $rsBrinde = odbc_fetch_array($buscaBrindeNome = odbc_exec($conexao, "select * from [marketing].[dbo].[brindesDMTRIX] where idBrinde = '$idBrinde'"));

        	?>
   	
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        
        
		<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">	
                <tr>
                    <td class="removerLinhaProduto">x</td>
                    <td></td>
                    <?php $valor = $rsBrinde['valor'];
								$quantidade = $rsBuscaBrinde['quantidade'];
								$total = $valor * $quantidade; ?>
                    <td><span><?php echo $rsBuscaBrinde['NomeBrinde'];?></span><br>Valor: <strong>R$<?php echo $total;?></strong> | Quantidade: <?php echo $rsBuscaBrinde['quantidade'];?></span></td>
                </tr>
       	</table>
        <input type="hidden" name="id" value="<?php echo $rsBuscaBrinde['idPedido'];?>">
        </form>
        <?php
		};
		
		$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
			
			$idUsuario = $usuarioLogado['idUsuario'];
			$nome = $usuarioLogado['nome']." ".$usuarioLogado['sobrenome'];
			deletaBrinde($idUsuario, $id, $nome);
		};
				
			
	 ?>
 		<form action="comprasBrindes.php" method="post">
        <input style="margin-left:50px" type="submit" name="carrinho" value="Visualizar Carrinho" class="largura60 center btnAzul">	
      </form>
      
      <?php }
	   //fim do else?>
	
      </div>
</div>
