<?php include_once("funcoes.php");
include("analyticstracking.php");
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" href="css/colorbox.css">
</head>

<body>

<div class="index login">
	<a href="index.php" class="clear logotipo"></a>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="clear bgBranco">
    	<h1 class="clear">Login</h1>
        <div class="largura90 left campo"><input type="text" name="usuario" class="left" placeholder="Usuário" required autofocus value="<?php if(isset($_COOKIE['usuario'])){ echo $_COOKIE['usuario']; }; ?>"><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura90 left campo"><input type="password" name="senha" class="left" placeholder="Senha" required value="<?php if(isset($_COOKIE['senha'])){ echo $_COOKIE['senha']; }; ?>"><div class="bg right"><div class="icone left"></div></div></div>
        <div class="largura40 left campo checks">
            <input type="checkbox" name="ficarLogado" id="ficarLogado" value="1" <?php if(isset($_COOKIE['senha'])){ echo "checked"; }; ?>>
            <label for="ficarLogado">Lembrar Dados</label>            
        </div>
        <div class="largura40 right campo checks">
        	<a href="cadastro.php">Criar Usuário</a>
        </div>
        <input type="hidden" name="tipoForm" value="Login">
        <input type="submit" name="submit_form" value="Logar no DMTrix" class="largura90 left btnSubmit">
        <div class="largura90 left campo">
        	<a href="esqueci-minha-senha.php">Esqueci Minha Senha</a>
        </div>
    </form>
    <a href="http://dmcard.com.br/" target="_blank" class="clear assinatura">www.dmcard.com.br</a>

</div>

<?php
if($_POST){
	$tipoForm		= $_POST['tipoForm'];
	$usuario		= $_POST['usuario'];
	$senha			= $_POST['senha'];
	$ficarLogado	= isset($_POST['ficarLogado']);
	
	echo login($usuario, $senha, $ficarLogado, $tipoForm);
	
};
?>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>