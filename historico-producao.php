<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == "" ){ header("Location: index.php"); };

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

<body onLoad="verificaLogin(), mudaStatus()">
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secao1 aprovar-reprovar">
    <h2>Pedidos que estão com fornecedor</br><span>Aqui você pode visualizar os pedidos que estão com fornecedor.</span></h2>
    <?php 
	$query = odbc_exec($conexao, "select * from PedidoDMTRIX p inner join lojasDMTRIX l on l.idLoja = p.idLoja inner join usuariosDMTRIX u on p.idUsuario = u.idUsuario where status_pedido = 8");
	while($rsbuscaCompra = odbc_fetch_array($query)){
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
                    <td><?php $date = $rsbuscaCompra['data_entrega'];
					$timeStamp = strtotime($date); echo date('d/m/Y', $timeStamp);?><input type="hidden" name="semana" value="<?php echo date('l', $timeStamp);?>"><br><span class="semana">semana</span></td>
                    <td><?php echo $rsbuscaCompra['nome']." ".$rsbuscaCompra['sobrenome']; ?></td>
                    <td><?php echo $rsbuscaCompra['nomeLoja'];?></td>
                    <td><?php echo $rsbuscaCompra['segmento']; ?></td>
                    <td>R$<?php echo $rsbuscaCompra['valorTotal']; ?></td>
                    <input type="hidden" name="idcompra" value="<?php echo $rsbuscaCompra['idCompra']; ?>">
                    <input type="hidden" name="valor" value="<?php echo $rsbuscaCompra['valorTotal']; ?>">
                    <input type="hidden" name="loja" value="<?php echo $rsbuscaCompra['nomeLoja'];?>">
                </tr>
            </tbody>
        </table>
       </form>
    
    <?php } ?>
    
    </div>
    <?php include("rodape.php"); ?>
    
  </div>
 <script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>