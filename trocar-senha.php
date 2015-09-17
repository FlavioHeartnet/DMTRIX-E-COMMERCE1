<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
<?php include("funcoes.php"); 
include("analyticstracking.php");
	  include("config.php");?>

<div class="index esqueci-minha-senha">
	<a href="index.php" class="clear logotipo"></a>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="clear bgBranco">
    	<h1 class="clear">Digite sua nova senha</h1>
        <div class="largura90 left campo"><input type="text" name="Usuario" class="left" placeholder="Usuario" required autocomplete="off"><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo"><input type="password" name="senha" class="left" placeholder="Nova senha." required autocomplete="off"><div class="bg right"><div class="icone left"></div></div></div>
        
        <div class="largura90 left campo">
        	<p>Digite sua nova senha de acesso nos campos acima.</p>
        </div>
        <input type="submit" name="trocar" value="Trocar Senha" class="largura90 left btnSubmit">
    </form>
    <a href="http://dmcard.com.br/" target="_blank" class="clear assinatura">www.dmcard.com.br</a>
</div>

<?php if(isset($_POST['trocar']))
{	
	$usuarioLogado = $_POST['Usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
	$usuario = $usuarioLogado['idUsuario'];
	$nome = $usuarioLogado['nome']." ".$usuarioLogado['sobrenome'];
	$senha = $_POST['senha'];
	
	
		TrocaSenha($senha, $usuario, $nome);
	
}  

?>

</body>
</html>