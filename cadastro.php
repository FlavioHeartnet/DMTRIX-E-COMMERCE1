<?php
include("funcoes.php");
include("analyticstracking.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>

<div class="index cadastro">
	<a href="index.php" class="clear logotipo"></a>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="clear bgBranco">
    	<h1 class="clear">Cadastro</h1>
        <div class="largura90 left campo"><input type="text" name="usuario" class="left" placeholder="Usuário" required maxlength="50"><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo"><input type="password" name="senha" class="left" placeholder="Senha" required><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo"><input type="password" name="repeteSenha" class="left" placeholder="Repita a Senha" required><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo"><input type="email" name="email" class="left" placeholder="E-mail" required><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo"><input type="text" name="nome" class="left" placeholder="Nome" required maxlength="50"></div>
        <div class="largura90 left campo"><input type="text" name="sobrenome" class="left" placeholder="Sobrenome" required maxlength="50"></div>
        <div class="largura90 left campo">
        	<p>Ao clicar em cadastrar, o usuário Controle do DMTrix receberá uma solicitação para validar seu usuário. Enquanto isso não acontece, você não terá acesso.</p>
        </div>
        <input type="submit" name="submit_form" value="Cadastrar" class="largura90 left btnSubmit">
    </form>
    <a href="http://dmcard.com.br/" target="_blank" class="clear assinatura">www.dmcard.com.br</a>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<?php
if($_POST){
	$usuario		= $_POST['usuario'];
	$senha			= $_POST['senha'];
	$repeteSenha	= $_POST['repeteSenha'];
	$email			= $_POST['email'];
	$nome			= $_POST['nome'];
	$sobrenome		= $_POST['sobrenome'];
	
	echo cadastraUsuarios($usuario, $senha, $repeteSenha, $nome, $sobrenome, $email);
};
?>
</body>
</html>