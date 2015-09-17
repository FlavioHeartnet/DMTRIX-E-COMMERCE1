<?php
include("file:///C|/wamp/www/funcoes.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>DMTrix</title>
<!-- TemplateEndEditable -->
<link rel="stylesheet" type="text/css" href="file:///C|/wamp/www/css/estilos.css">
<link rel="stylesheet" type="text/css" href="file:///C|/wamp/www/css/estilos-bibliotecas.css">
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>

<body onLoad="somaProdutos(),verificaLogin()">
<div class="msgAlerta"></div>
<?php include("file:///C|/wamp/www/topo.php"); ?>
<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));?>
<div class="centro">
  <div class="clear bgBranco secaoInterna compra-finalizada">
    <h2>Histórico e Relatórios<br><span>Baixe relatorios e historico de compras de brindes e estoques</span></h2>

    
    
    </div>
    <?php include("file:///C|/wamp/www/rodape.php"); ?>
</div>

<script type="text/javascript" src="file:///C|/wamp/www/js/bibliotecas.js"></script>
<script type="text/javascript" src="file:///C|/wamp/www/js/scripts.js"></script>    
</body>
</html>