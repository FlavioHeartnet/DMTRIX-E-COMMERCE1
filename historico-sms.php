<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };

$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'")); 
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

<body onLoad="verificaLogin()">
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secao1">
    	<h2>Historico de SMS<br><span>Visualize os SMS que você ja solicitou</span></h2>
        
        
        <?php 
		$buscaSMS = odbc_exec($conexao,"  select * from [MARKETING].[dbo].[envioSmsDMTRIX] e inner join dbo.usuariosDMTRIX u on e.idUsuario = u.idUsuario inner join dbo.lojasDMTRIX l on e.loja = l.idLoja where e.idUsuario = '$idUsuario'");
		
		while($rsBuscaSMS = odbc_fetch_array($buscaSMS)){ 
		
		?>
       	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                            <thead>
                            <td>Data de envio:</td>
                            <td>Status do Cliente:</td>
                            <td>Loja:</td>
                            <td>Texto:</td>
                          
                            
                            
                            </thead>
                            </tr>
                            <tr class="semBorda">
                            	<td width="15%"><div class="campo"><input type="text"readonly name="Data" value="<?php echo $rsBuscaSMS['dataEnvio']; ?>"  class="left"></div></td>
                               

                                <td width="15%"><div class="campo"><input type="text" name="Status"readonly value="<?php echo $rsBuscaSMS['statusCliente']; ?>"  class="left"></div></td>
                                
                                <td><div class="campo"><input type="text" name="Loja"readonly value="<?php echo $rsBuscaSMS['nomeLoja'];?>"  class="left"></div></td>
                                <td> <div class="campo"><textarea  name="Texto" readonly class="left"  autocomplete="off"><?php echo $rsBuscaSMS['texto']; ?></textarea></div></td>
                               
                            </tr>
        </table>  
        <?php } ?>      
        </div>
        <?php include ("rodape.php"); ?>
</div>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>
