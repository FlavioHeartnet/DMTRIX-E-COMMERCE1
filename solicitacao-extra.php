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

<body onLoad="verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna">
    	<h2>Solicitações Extras<br><span>Espaço reservado para pedidos realizados por usuários internos da DMCard, como: Marketing, Recursos Humanos, Diretoria, etc.</span></h2>
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td>Nome do Material</td>
                    <td>Descrição do Material</td>
                </tr>
            </thead>
            
            <tbody class="listaMateriaisExtras">
            	<tr>
                	<td width="40%"><div class="campo"><input type="text" name="nomeMaterial[]" placeholder="Nome do Material" required></div></td>
                	<td width="60%">
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr class="semBorda">
                                <td><div class="campo"><input type="text" name="largura[]"  class="left" placeholder="Largura" autocomplete="off" data-mask="0000.00" data-mask-reverse="true"></div></td>
                                <td><div class="campo"><input type="text" name="altura[]" class="left" placeholder="Altura" autocomplete="off" data-mask="0000.00" data-mask-reverse="true"></div></td>
                                <td><div class="campo"><input type="text" name="quantidade[]" class="left" placeholder="Quantidade" autocomplete="off" data-mask="0000" data-mask-reverse="true"></div></td>
                                <td><div class="campo"><input type="text" name="localizacao[]" class="left" placeholder="Localização" autocomplete="off"></div></td>
                                <td><div class="campo"><input type="text" name="entrega[]" class="left" placeholder="Data de Entrega" autocomplete="off" data-mask="00/00/0000" data-mask-reverse="true"></div></td>
                            </tr>
                            <tr class="semBorda">
                                <td colspan="9"><div class="campo"><textarea name="observacao[]" class="left" placeholder="Como você imagina essa peça pronta?" style="line-height:25px;" required></textarea></div></td>
                            </tr>
                        </table> 
                    </td>
                </tr>
            </tbody>
            
            <tfoot>
                <tr>
                	<td><input type="button" name="addCampoMateriais" value="Adicionar + Campos" class="largura40 left btnAzul"></td>
                	<td><input type="submit" name="enviar" value="Finalizar Pedido" class="largura40 right btnSubmit"></td>
                </tr>
			</tfoot>
        </table>
    </div>
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>