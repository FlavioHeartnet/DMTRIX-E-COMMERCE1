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
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna">
    	<h2>Alterar Acesso e Dados Pessoais<br><span>Utilize os campos abaixo para atualizar seus dados pessoais e de acesso do DMTrix</span></h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                    <tr>
                        <td colspan="5">Dados Pessoais</td>
                    </tr>
                </thead>
                
                <?php $usuario = $_SESSION['usuario']; $meusDados = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuario'")); ?>
                
                <tbody>
                	<tr>
                    	<td width="20%"><div class="campo"><input type="text" name="nome" class="left" placeholder="Primeiro Nome" autocomplete="off" required value="<?php echo $meusDados['nome']; ?>"></div></td>
                    	<td width="20%"><div class="campo"><input type="text" name="sobrenome" class="left" placeholder="Sobrenome" autocomplete="off" required value="<?php echo $meusDados['sobrenome']; ?>"></div></td>
                    	<td width="20%"><div class="campo"><input type="email" name="email" class="left" placeholder="E-mail" autocomplete="off" required value="<?php echo $meusDados['email']; ?>"></div></td>
                    	<td width="20%"></td>
                        <td width="20%"></td>
                    </tr>
                </tbody>

            	<thead>
                    <tr>
                        <td colspan="5">Dados de Acesso</td>
                    </tr>
                </thead>
                
                <tbody>
                	<tr>
                    	<td width="20%"><div class="campo"><input type="text" name="usuario" class="left" placeholder="Usuário" autocomplete="off" required value="<?php echo $meusDados['usuario']; ?>"></div></td>
                    	<td width="20%"><div class="campo"><input type="password" name="senha" class="left" placeholder="Senha" autocomplete="off" required value="<?php echo $meusDados['senha']; ?>"></div></td>
                    	<td width="20%"><div class="campo"><input type="password" name="repeteSenha" class="left" placeholder="Repita a Senha" autocomplete="off" required value="<?php echo $meusDados['senha']; ?>"></div></td>
                    	<td width="20%"><div class="campo">
                        <select name="supervisor">
                        <?php
						$buscaSupervisores = odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE nivel = '3'");
						if($meusDados['idUsuario'] != $meusDados['supervisor']){
							$idSupervisor = $meusDados['supervisor'];
							$buscaSupervisorAtual = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE idUsuario = '$idSupervisor'"));
						?>
							<option value="<?php echo $buscaSupervisorAtual['idUsuario'] ?>"><?php echo $buscaSupervisorAtual['nome']. " " . $buscaSupervisorAtual['sobrenome'] ?></option>
                        <?php
							};
						while($rsBuscaSupervisores = odbc_fetch_array($buscaSupervisores)){
							if($meusDados['nivel'] != 4){
						?>
							<option value="<?php echo $meusDados['idUsuario'] ?>">Não Possui Supervisor</option>
                        <?php
							};
						?>
							<option value="<?php echo $rsBuscaSupervisores['idUsuario'] ?>"><?php echo $rsBuscaSupervisores['nome'] . " " . $rsBuscaSupervisores['sobrenome'] ?></option>
                        <?php
						};
						?>
                        </select>                        
                        </div></td>
                    	<td width="20%"><div class="campo">
                        <select name="nivel">
                        	<?php if($meusDados['nivel'] == NULL){ ?>
							<option value="">Defina o Nível</option>
                        	<?php }else{ ?>
							<option value="<?php echo $meusDados['nivel'] ?>"><?php echo $niveis[$meusDados['nivel'] - 1]; ?></option>
                            <?php }; ?>
                            
							<?php for($i = 0; $i < $qtdNiveis; $i++){ ?>
							<option value="<?php echo ($i + 1); ?>"><?php echo $niveis[$i]; ?></option>
                            <?php }; ?>
						</select>
                        </div></td>
                    </tr>
                    <tr>
                    	<input type="hidden" name="usuarioLogado" value="<?php echo $meusDados['nome']." ".$meusDados['sobrenome']; ?>">
                    	<input type="hidden" name="idUsuario" value="<?php echo $meusDados['idUsuario']; ?>">
                    	<input type="hidden" name="usuarioAntigo" value="<?php echo $meusDados['usuario']; ?>">
                    	<td colspan="5"><input type="submit" name="submit_form" value="Atualizar Usuário" class="largura30 right btnSubmit"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<?php
if($_POST){
	$nome				= $_POST['nome'];
	$sobrenome			= $_POST['sobrenome'];
	$email				= $_POST['email'];
	$usuario			= $_POST['usuario'];
	$senha				= $_POST['senha'];
	$repeteSenha		= $_POST['repeteSenha'];
	$nivel				= $_POST['nivel'];
	$supervisor			= $_POST['supervisor'];
	$usuarioAntigo		= $_POST['usuarioAntigo'];
	$idUsuario			= $_POST['idUsuario'];
	$status 			= 1;
	$usuarioLogado		= $_POST['usuarioLogado'];
	
	echo atualizaUsuarios($usuario, $senha, $repeteSenha, $nivel, $nome, $sobrenome, $email, $supervisor, $status, $idUsuario, $usuarioAntigo, $usuarioLogado);
};
?>
</body>
</html>