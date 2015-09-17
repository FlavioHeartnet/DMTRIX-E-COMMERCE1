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

if(isset($_POST['detalhes'])){
$idTarefa = $_POST['idTarefa'];
}

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

<div class="centro">
	<div class="clear bgBranco secao1 aprovar-reprovar">
    <h2>Detalhes de Pausas e Observações</br><span>Veja aqui o detalhe de suas tarefas.</span></h2>
    <?php $query = odbc_exec($conexao, "select * from [MARKETING].[dbo].[pausaDMTRIX] p inner join [MARKETING].[dbo].[tarefasDMTRIX] t on t.idTarefa = p.idTarefa  
  where p.idTarefa = '$idTarefa'");
  
  $query2 = odbc_exec($conexao, "select * from [MARKETING].[dbo].[tarefasDMTRIX] where idTarefa = '$idTarefa'");
  
  $rsQuery2 = odbc_fetch_array($query2);
	
	
	?>
    <table style="padding:5px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <thead>
    	<tr>
        	<td><strong>tarefa iniciada: <?php echo $rsQuery2['tempoIniciado']; ?></strong></td>
        </tr>
    </thead>
    </table>
    
    <?php 
	while($rsQuery = odbc_fetch_array($query)){
	?>
    
     <table style="padding:5px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            	<td><h2><span style="color:#f37021">Controle de pausas no periodo do trabalho:</span></h2></td>
            </tr>
            
                <tr class="fila" style="font-weight: bold;">
                    <td>Pausa realizada em:</td>
                    <td>Trabalho retomado: </td>
                    
                    
                </tr>
            </thead>
		
            <tbody>
                <tr>
                    <td><?php echo $rsQuery['horaPausa']; ?></td>
                    <td><?php echo $rsQuery['horaRetomada']; ?></td>
                    
                    
                    
                    
                </tr>
             </tbody>
            </table> 
    
    
    <?php } ?>
    <table style="padding:5px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <thead>
    	<tr>
        	<td><strong>tarefa finalizada: <?php echo $rsQuery2['tempoFinal']; ?></strong></td>
        </tr>
    </thead>
    </table>
    
    </div>
</div>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>