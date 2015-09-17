<?php
include("funcoes.php");
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

<body onLoad="somaProdutos() verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php");
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $usuarioLogado['idUsuario'];
	 ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna compra-finalizada">
    	<h2>Envio de Arte para Aprovação<br><span>Envie artes para aprovação no formato: PDF - JPG - PNG - PPT - ODP</span></h2>
         
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <thead>
                <tr>
                    <td>Digite o código/token do pedido</td>
                </tr>
            </thead>
            
            <tbody>
            	<tr>
                	<td><div class="campo"><input type="text" name="token" class="left" placeholder="Token" required></div></td>
                </tr>
            </tbody>

            <thead>
                <tr>
                    <td>Anexe o arquivo clicando no campo abaixo</td>
                </tr>
            </thead>
            
            <tbody>
            	<tr>
                	<td><div class="campo"><input type="file" name="anexo" class="left" required></div></td>
                </tr>
            	<tr>
                	<td><input type="submit" name="Enviar" value="Enviar para Aprovação" class="largura25 right btnSubmit"></td>
                </tr>
            </tbody>
            </form>
        </table>
        
    </div>
    <?php include("rodape.php"); 
	
	if(isset($_POST['Enviar']))
	{
		$pedido = $_POST['token'];
		$arte = $_POST['anexo'];
		
		$nome_material = $_FILES['anexo']['name'];
		$nome_temp = $_FILES['anexo']['tmp_name'];
	
		$exteFoto = explode('', $nome_material);
		$exteFoto_ex = strtolower(end($exteFoto)); 
		

	
		$extencaoF = $pedido."".$nome_material.$exteFoto_ex;
		
		
                CarregaArte($extencaoF,$nome_temp);
				SalvarArte($usuario, $extencaoF, $pedido);
		
	}
	
	?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>