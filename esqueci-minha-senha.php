<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
<?php include("funcoes.php");
	  include("config.php"); ?>
      

<div class="index esqueci-minha-senha">
	<a href="index.php" class="clear logotipo"></a>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="clear bgBranco">
    	<h1 class="clear">Esqueci Minha Senha</h1>
        <div class="largura90 left campo"><input type="text" name="usuario" class="left" placeholder="Usuário" required autocomplete="off"><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo"><input type="email" name="email" class="left" placeholder="E-mail" required autocomplete="off"><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo">
        	<p>Diga-nos qual o usuário você usa para entrar no DmTrix e qual o seu e-mail cadastrado, assim podemos lhe enviar a senha por e-mail.</p>
        </div>
        <input type="submit" name="Esqueci" value="Enviar Senha" class="largura90 left btnSubmit">
    </form>
    <a href="http://dmcard.com.br/" target="_blank" class="clear assinatura">www.dmcard.com.br</a>
</div>
<?php if(isset($_POST['Esqueci']))
{

	$usuarioLogado = $_POST['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
	$idUsuario = $usuarioLogado['idUsuario'];
	$email = $_POST['email'];
	
	EsqueciSenha($idUsuario, $email);
	
}

?>
</body>
</html>