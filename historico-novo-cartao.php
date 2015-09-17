<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $_SESSION['usuario'];
$idUsuario = $usuarioLogado['idUsuario'];
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
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna">

        <h2>Historico de Novos Cartão solicitados<br><span>consulte o historico de solicitações de cartões</span></h2>
        
        <?php 
		$query = odbc_exec($conexao, " select * from novoCartaoDMTRIX n inner join lojasDMTRIX l on l.idLoja = n.idLoja inner join usuariosDMTRIX u on u.idUsuario = n.idUsuario where n.idUsuario = '$idUsuario'");
		
		
		
		while($rsbuscaCartao = odbc_fetch_array($query)){
				?>
                 <form action="baixarPDF.php" method="post" target="_blank">
                 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                <tr>
                	<td>Código do cartão</td>
                    <td>Data</td>
                    <td>Solicitante</td>
                    <td>Loja</td>
                    <td>site</td>
                    <td>Descrição</td>
                    
                </tr>
            	</thead>
                
                <tbody>
                <tr>
                	<td><p align="center"><?php echo $rsbuscaCartao['idCartao']; ?></p></td>
                    <td><?php $date = $rsbuscaCartao['dataSolicitacao'];
					
					$timeStamp = strtotime($date); echo date('d/m/Y', $timeStamp); ?><input type="hidden" name="semana" value="<?php echo date('l', $timeStamp);?>"><br><span class="semana">semana</span></td>
                    <td><?php echo $rsbuscaCartao['nome']." ".$rsbuscaCartao['sobrenome']; ?></td>
                    <td><?php echo $rsbuscaCartao['nomeLoja'];?></td>
                    <td><a href="<?php echo $rsbuscaCartao['site']; ?>">Site do cliente</a></td>
                    <td><?php echo $rsbuscaCartao['descricao']; ?></td>
                    <input type="hidden" name="idCartao[]" value="<?php echo $rsbuscaCartao['idCartao']; ?>">
                    <input type="hidden" name="descricao[]" value="<?php echo $rsbuscaCartao['descricao']; ?>">
                    <input type="hidden" name="loja[]" value="<?php echo $rsbuscaCartao['nomeLoja'];?>">
                    <input type="hidden" name="solicitante[]" value="<?php echo $rsbuscaCartao['nome']." ".$rsbuscaCartao['sobrenome']; ?>">
                    <input type="hidden" name="data[]" value="<?php echo $date;?>">
                    <input type="hidden" name="site[]" value="<?php echo $rsbuscaCartao['site'];?>">
                    
                </tr>
            </tbody>
                
                </table>
                </form>
                <?php } ?>
        
          	</div>
    <?php include("rodape.php") ?>
  </div>      
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>