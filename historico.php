<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };

$nivel = $_SESSION['nivel'];
$usuarioLogado = $_SESSION['usuario'];
$usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $usuarioLogado['idUsuario'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/estilos-bibliotecas.css">
</head>

<body onLoad="verificaLogin(); mudaStatus()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna historico">
    	<h2>Histórico de Pedidos<br><span>Visualize todos os seus pedidos realizados no DMTrix.</span></h2>

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <table><tr></tr></table>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            
            	<td><span id="compra1">Pesquise pelo codigo da compra(clique aqui).</span>
                
                <div class="campo tlg1"><input type="text" name="token" class="left" placeholder="Insira o Código/Token do Pedido" autocomplete="off" data-mask="00000000" data-mask-reverse="true"></div></td>
               
            </tr>
          
            </table>
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            
            <tr>
            	<td width="25%"><span id="data1">Pesquise por Datas(clique aqui).</span>
            
                	<div class="campo tlg2"><input type="text" name="dataInicio" class="datepicker2"  data-mask="00/00/0000" data-mask-reverse="true" placeholder="Digite a data de proucura!"><br>
                    <div class="campo"><input type="text" name="dataFinal" class="datepicker2"  data-mask="00/00/0000" data-mask-reverse="true" placeholder="Digite a data final para proucura!"></div></div></td>
                
            </tr>
          
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

                if($nivel > 2)
                {

                    $buscaCompra = odbc_exec($conexao, "select DISTINCT c.idCompra, c.dataCompra, c.valorTotal, c.idUsuario,u.nome,u.sobrenome, p.idLoja, l.nomeLoja, l.numeroLoja from [marketing].[dbo].[ComprasDMTRIX] c inner join
  [marketing].[dbo].[PedidoDMTRIX] p on c.idCompra = p.idCompra inner join [marketing].[dbo].[lojasDMTRIX] l on p.idLoja = l.idLoja inner join [marketing].[dbo].[usuariosDMTRIX] u on
  p.idUsuario = u.idUsuario where c.idCompra = '$idCompra' and c.idUsuario = '$usuario'");

                }else if($nivel <= 2)
                {

                    $buscaCompra = odbc_exec($conexao, "select DISTINCT c.idCompra, c.dataCompra, c.valorTotal, c.idUsuario,u.nome,u.sobrenome, p.idLoja, l.nomeLoja, l.numeroLoja from [marketing].[dbo].[ComprasDMTRIX] c inner join
  [marketing].[dbo].[PedidoDMTRIX] p on c.idCompra = p.idCompra inner join [marketing].[dbo].[lojasDMTRIX] l on p.idLoja = l.idLoja inner join [marketing].[dbo].[usuariosDMTRIX] u on
  p.idUsuario = u.idUsuario where c.idCompra = '$idCompra'");

                }

			while($rsbuscaCompra = odbc_fetch_array($buscaCompra)){ 
				$idCompra = $rsbuscaCompra['idCompra'];
				$PegaSegmento = odbc_fetch_array(odbc_exec($conexao, "select * from [marketing].[dbo].[PedidoDMTRIX] where idCompra = '$idCompra' "));
			
			?>
          <form action="historico-detalhado.php" method="post">  
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
                    <td><?php echo $rsbuscaCompra['numeroLoja']."-".$rsbuscaCompra['nomeLoja'];?></td>
                    <td><?php echo $PegaSegmento['segmento']; ?></td>
                    <td>R$<?php echo $rsbuscaCompra['valorTotal']; ?></td>
                    <input type="hidden" name="idcompra" value="<?php echo $rsbuscaCompra['idCompra']; ?>">
                    <input type="hidden" name="valor" value="<?php echo $rsbuscaCompra['valorTotal']; ?>">
                    <input type="hidden" name="loja" value="<?php echo $rsbuscaCompra['nomeLoja'];?>">
                    <td><input type="submit" name="submit_form" value="Ver Materiais" class="largura100 left btnAzul"></td>
                </tr>
            </tbody>
        </table>
       </form>
       <?php }
			} if (isset($_POST['dataInicio']) and isset($_POST['dataFinal']))
			{
			$DataI = $_POST['dataInicio'];
			$DataF = $_POST['dataFinal'];

            if($nivel > 2) {

                $buscaCompra = odbc_exec($conexao, "  select DISTINCT c.idCompra, c.dataCompra, c.valorTotal, c.idUsuario,u.nome,u.sobrenome, p.idLoja, l.nomeLoja, l.numeroLoja from [marketing].[dbo].[ComprasDMTRIX] c inner join
  [marketing].[dbo].[PedidoDMTRIX] p on c.idCompra = p.idCompra inner join [marketing].[dbo].[lojasDMTRIX] l on p.idLoja = l.idLoja inner join [marketing].[dbo].[usuariosDMTRIX] u on
  p.idUsuario = u.idUsuario where c.dataCompra between '$DataI' and '$DataF' and c.idUsuario = '$usuario'");
            }else if($nivel <= 2)
            {
                $buscaCompra = odbc_exec($conexao, "  select DISTINCT c.idCompra, c.dataCompra, c.valorTotal, c.idUsuario,u.nome,u.sobrenome, p.idLoja, l.nomeLoja, l.numeroLoja from [marketing].[dbo].[ComprasDMTRIX] c inner join
  [marketing].[dbo].[PedidoDMTRIX] p on c.idCompra = p.idCompra inner join [marketing].[dbo].[lojasDMTRIX] l on p.idLoja = l.idLoja inner join [marketing].[dbo].[usuariosDMTRIX] u on
  p.idUsuario = u.idUsuario where c.dataCompra between '$DataI' and '$DataF'");


            }

			while($rsbuscaCompra = odbc_fetch_array($buscaCompra)){
				
				$idCompra = $rsbuscaCompra['idCompra'];
				$PegaSegmento = odbc_fetch_array(odbc_exec($conexao, "select * from [marketing].[dbo].[PedidoDMTRIX] where idCompra = '$idCompra' "));
				?>
                
                
            
          <form action="historico-detalhado.php" method="post">  
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
                	<td><p align="center"><?php echo $idCompra; ?></p></td>
                    <td><?php $date = $rsbuscaCompra['dataCompra'];
					$timeStamp = strtotime($date); echo date('d/m/Y', $timeStamp);?><br><?php echo date('l', $timeStamp);?></td>
                    <td><?php echo $rsbuscaCompra['nome']." ".$rsbuscaCompra['sobrenome']; ?></td>
                    <td><?php echo $rsbuscaCompra['numeroLoja']."-".$rsbuscaCompra['nomeLoja'];?></td>
                    <td><?php echo $PegaSegmento['segmento']; ?></td>
                    <td>R$<?php echo $rsbuscaCompra['valorTotal']; ?></td>
                    
                    <input type="hidden" name="idcompra" value="<?php echo $rsbuscaCompra['idCompra']; ?>">
                    <input type="hidden" name="valor" value="<?php echo $rsbuscaCompra['valorTotal']; ?>">
                    <input type="hidden" name="loja" value="<?php echo $rsbuscaCompra['nomeLoja'];?>">
                    
                    
                    
                    <td><input type="submit" name="submit_form" value="Ver Materiais" class="largura100 left btnAzul"></td>
                </tr>
            </tbody>
        </table>
       </form>
       <?php }
			}else{}?>
    </div>
    <?php
	 include("rodape.php"); 
	?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
$('.tlg1').hide();
$('.tlg2').hide();
$('.tlg3').hide();</script>
</body>
</html>