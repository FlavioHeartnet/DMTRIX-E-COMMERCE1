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
<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));

$Usuario = odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX order by nome");
?>

<div class="centro">
  <div class="clear bgBranco secaoInterna">
    <h2>Histórico e Relatórios<br><span>Baixe relatorios e historico de compras de brindes e estoques</span></h2>
    
    <div class="clear">
    <form action="baixar.php" method="post">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            
            	<td><span id="compra1">Pesquise pelo nome do comprador(clique aqui).</span>
                
                <div class="campo tlg1"><select id="tags" name="token" class="left" autocomplete="off">
                	<option value="">Selecione um nome</option>
                  <?php while($rsUsuario = odbc_fetch_array($Usuario)){ ?>
                	<option value="<?php echo $rsUsuario['idUsuario']; ?>"><?php echo $rsUsuario['nome']." ".$rsUsuario['sobrenome']; ?></option>
                    <?php } ?>
                    </select>
                    
                    <input type="hidden" name="idUsuario" value="<?php echo $usuarioLogado['idUsuario']; ?>">
              
                
          
                
            
                
                </div></td>
               
            </tr>
          
            </table>
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            
            <tr>
            	<td width="25%"><span id="data1">Pesquise compras por Datas(clique aqui).</span>
            
                	<div class="campo tlg2"><input type="text" name="dataInicio" class="datepicker2"  data-mask="00/00/0000" data-mask-reverse="true" placeholder="Digite a data de proucura!"><br>
                    <div class="campo"><input type="text" name="dataFinal" class="datepicker2"  data-mask="00/00/0000" data-mask-reverse="true" placeholder="Digite a data final para proucura!"></div></div></td>
                
            </tr>
            <tr>
            	<td> </td>
            </tr>
            
          
            <tr>
            	<td width="25%" class="checks"><div class="jspContainer"><p>Baixar planilha excel</p><input type="checkbox" name="excel" id="l1" value="1"><label for="l1"></label></div></td>
                <td width="25%" class="checks"><p>Baixar em PDF</p><input type="checkbox" name="pdf" id="l2" value="2"><label for="l2"></label></td>
            </tr>
            
            <tr>
            	<td><input style="margin-right:-100%; float:0" type="submit" name="Buscar" value="Buscar" class="largura30 right btnSubmit"></td>
            </tr>
            
            <tr id="informacoes">
            	
            </tr>
            </table>
            </form>
    </div>

    
    
    </div>
    <?php include("rodape.php");
	
	
	
	
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