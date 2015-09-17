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

<body onLoad="verificaLogin(), mudaStatus()">
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secao1 aprovar-reprovar">
    <h2>Ola, <?php echo $nome; ?></br><span>Aqui você pode finalizar os pedidos para envio ao fornecedor.</span></h2>
    <?php 
	
	$query = odbc_exec($conexao, "select * from PedidoDMTRIX p inner join lojasDMTRIX l on l.idLoja = p.idLoja inner join usuariosDMTRIX u on p.idUsuario = u.idUsuario where status_pedido = 6");
	while($rsbuscaCompra = odbc_fetch_array($query)){
	?>
     <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">  
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                	<td>Código da Compra</td>
                    <td>Código do Pedido</td>
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
                    <td><p align="center"><?php echo $rsbuscaCompra['idPedido']; ?></p></td>
                    <td><?php echo $rsbuscaCompra['nome']." ".$rsbuscaCompra['sobrenome']; ?></td>
                    <td><?php echo $rsbuscaCompra['nomeLoja'];?></td>
                    <td><?php echo $rsbuscaCompra['segmento']; ?></td>
                    <td>R$<?php echo $rsbuscaCompra['valorProduto']; ?></td>
                   
                    
                    
                </tr>
            </tbody>
        </table>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
        	<td  align="right"><input type="submit" style="margin-left: 83%;" name="producao" value="Ir para pradução" class="left btnAzul"></td>
        </tr>
        <input type="hidden"  name="idPedido" value="<?php echo $rsbuscaCompra['idPedido']; ?>">
         </table>
       </form>
    
    <?php }  ?>
   </div>
   
   <?php 
   if(isset($_POST['producao']))
   {
	 $idPedido = $_POST['idPedido'];
	 producao($usuario, $idPedido);
	}
   
   
   include("rodape.php");  ?>
  </div>
 <script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>