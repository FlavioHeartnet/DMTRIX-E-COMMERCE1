<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == "" ){ header("Location: index.php"); };
$nivel = $_SESSION['nivel'];
if($_SESSION['nivel'] == 1){}else if($_SESSION['nivel'] == 2) {}else {session_destroy(); header("Location: index.php");}
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $usuarioLogado['idUsuario'];
$nome = $usuarioLogado['nome']." ".$usuarioLogado['sobrenome'];

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

<div class="centro">
	<div class="clear bgBranco secaoInterna historico">
    <h2>Finalizar compras</br><span>finalize aqui as compras ja entregues</span></h2>


	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            
            	<td><span id="compra1">Pesquise pelo codigo da compra(clique aqui).</span>
                
                <div class="campo tlg1"><input type="text" name="token" class="left" placeholder="Insira o Código/Token do Pedido" autocomplete="off" data-mask="00000000" data-mask-reverse="true"></div></td>
               
            </tr>
          
            </table>
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            
            
          
            <tr>
            	<td width="25%"></td>
               
            </tr>
            
            <tr>
            	<td><input type="submit" name="Buscar" value="Procurar Pedido" class="largura30 right btnSubmit"></td>
            </tr>
            
            <tr id="informacoes">
            	
            </tr>
            </table>
            </form>
            <?php 
			if(isset($_POST['token'])){
				$idCompra = $_POST['token'];
			$buscaCompra = odbc_exec($conexao, "select DISTINCT c.idCompra, c.dataCompra, c.valorTotal, c.idUsuario,u.nome,u.sobrenome, p.idLoja, l.nomeLoja from [marketing].[dbo].[ComprasDMTRIX] c inner join 
  [marketing].[dbo].[PedidoDMTRIX] p on c.idCompra = p.idCompra inner join [marketing].[dbo].[lojasDMTRIX] l on p.idLoja = l.idLoja inner join [marketing].[dbo].[usuariosDMTRIX] u on
  p.idUsuario = u.idUsuario where c.idCompra = '$idCompra' and p.status_pedido = 8");
			while($rsbuscaCompra = odbc_fetch_array($buscaCompra)){ 
				$idCompra = $rsbuscaCompra['idCompra'];
				$PegaSegmento = odbc_fetch_array(odbc_exec($conexao, "select * from [marketing].[dbo].[PedidoDMTRIX] where idCompra = '$idCompra' "));
			
			?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">  
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                	<td>Código da Compra</td>
                    <td>Data</td>
                    <td>Solicitante</td>
                    <td>Loja</td>
                    <td>Segmento</td>
                    <td>Valor</td>
                    <td></td>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                	<td><p align="center"><?php echo $rsbuscaCompra['idCompra']; ?></p></td>
                    <td><?php $date = $rsbuscaCompra['dataCompra'];
					$timeStamp = strtotime($date); echo date('d/m/Y', $timeStamp);?><input type="hidden" name="semana" value="<?php echo date('l', $timeStamp);?>"><br><span class="semana">semana</span></td>
                    <td><?php echo $rsbuscaCompra['nome']." ".$rsbuscaCompra['sobrenome']; ?></td>
                    <td><?php echo $rsbuscaCompra['nomeLoja'];?></td>
                    <td><?php echo $PegaSegmento['segmento']; ?></td>
                    <td>R$<?php echo $rsbuscaCompra['valorTotal']; ?></td>
                    <input type="hidden" name="idcompra" value="<?php echo $rsbuscaCompra['idCompra']; ?>">
                    <input type="hidden" name="valor" value="<?php echo $rsbuscaCompra['valorTotal']; ?>">
                    <input type="hidden" name="loja" value="<?php echo $rsbuscaCompra['nomeLoja'];?>">
                    <td><input type="submit" name="fechar" value="fechar Compra" class="largura100 left btnAzul"></td>
                </tr>
            </tbody>
        </table>
       </form>
       <?php }
			
			}else{}?>

</div>
<?php


if(isset($_POST['fechar']))
{
	$idCompra = $_POST['idcompra'];
	
	$query = odbc_fetch_array(odbc_exec($conexao, "select COUNT(status_pedido)num from PedidoDMTRIX  where  idCompra = '$idCompra'"));
	
	$count = $query['num'];
	
	$query2 = odbc_fetch_array(odbc_exec($conexao, "select COUNT(status_pedido)num from PedidoDMTRIX  where status_pedido = 8 and idCompra = '$idCompra'"));
	
	$count2 = $query2['num'];
	
	if($count == $count2)
	{
		
		$query = odbc_exec($conexao, "update ComprasDMTRIX set status_compra = 'finalizado' where idCompra = '$idCompra'");
		$query2 = odbc_exec($conexao, " UPDATE PedidoDMTRIX set status_pedido = 11 where idCompra = '$idCompra'");
		
		if($query == true and $query2 == true)
		{
			
		$historico = odbc_exec($conexao, "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $usuario finalizou uma compra')");
		echo "<script>alert('finalizada com sucesso'); location.href='finalizar-compra.php';</script>";
		return true;
		 
	}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar finalizar a compra, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	}
		
	}else{
	
	echo "<script>alert('Esta compra não pode ser finalizada pois nem todos os pedidos foram concluidos!');</script>";
	}
}

 include("rodape.php"); ?>
    
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
$('.tlg1').hide();
$('.tlg2').hide();
$('.tlg3').hide();</script>
</body>

</body>
</html>