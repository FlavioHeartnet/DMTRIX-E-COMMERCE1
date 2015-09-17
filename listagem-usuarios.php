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
    	<h2>Usuários<br><span>Edite e Apague usuários do sistema.</span></h2>
		<?php
            $buscaUsuarios = odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX ORDER BY status DESC, nome ASC");
            while($rsBuscaUsuarios = odbc_fetch_array($buscaUsuarios)){
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="left">
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                    <tr>
                        <td colspan="5"><?php echo $rsBuscaUsuarios['nome']." ".$rsBuscaUsuarios['sobrenome']; ?></td>
                    </tr>
                </thead>
                
                <tbody>
                	<tr>
                    	<td width="20%"><div class="campo"><input type="text" name="nome" class="left" placeholder="Primeiro Nome" value="<?php echo $rsBuscaUsuarios['nome']; ?>" required></div></td>
                    	<td width="20%"><div class="campo"><input type="text" name="sobrenome" class="left" placeholder="Sobrenome" value="<?php echo $rsBuscaUsuarios['sobrenome']; ?>" required></div></td>
                    	<td width="20%"><div class="campo"><input type="email" name="email" class="left" placeholder="E-mail" value="<?php echo $rsBuscaUsuarios['email']; ?>" required></div></td>
                    	<td width="20%"></td>
                        <td width="20%"></td>
                    </tr>
                	<tr>
                    	<td width="20%"><div class="campo"><input type="text" name="usuario" class="left" placeholder="Usuário" value="<?php echo $rsBuscaUsuarios['usuario']; ?>" required></div></td>
                    	<td width="20%"><div class="campo"><input type="password" name="senha" class="left" placeholder="Senha" value="<?php echo $rsBuscaUsuarios['senha']; ?>" required></div></td>
                    	<td width="20%"><div class="campo"><input type="password" name="repeteSenha" class="left" placeholder="Repita a Senha" value="<?php echo $rsBuscaUsuarios['senha']; ?>" required></div></td>
                    	<td width="20%"><div class="campo">
                        <select name="supervisor">
                        <?php
						$buscaSupervisores = odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE nivel = '3'");
						if($rsBuscaUsuarios['idUsuario'] != $rsBuscaUsuarios['supervisor']){
							$idSupervisor = $rsBuscaUsuarios['supervisor'];
							$buscaSupervisorAtual = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE idUsuario = '$idSupervisor'"));
						?>
							<option value="<?php echo $buscaSupervisorAtual['idUsuario'] ?>"><?php echo $buscaSupervisorAtual['nome']. " " . $buscaSupervisorAtual['sobrenome'] ?></option>
                        <?php
							};
						while($rsBuscaSupervisores = odbc_fetch_array($buscaSupervisores)){
							if($rsBuscaUsuarios['nivel'] != 4){
						?>
							<option value="<?php echo $rsBuscaUsuarios['idUsuario'] ?>">Não Possui Supervisor</option>
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
                        	<?php if($rsBuscaUsuarios['nivel'] == NULL){ ?>
							<option value="">Defina o Nível</option>
                        	<?php }else{ ?>
							<option value="<?php echo $rsBuscaUsuarios['nivel'] ?>"><?php
							if($rsBuscaUsuarios['nivel'] == 0){
								echo $niveis[$rsBuscaUsuarios['nivel']];
							}else{
								echo $niveis[$rsBuscaUsuarios['nivel'] - 1];
							};
							 //echo $niveis[$rsBuscaUsuarios['nivel'] - 1]; ?></option>
                            <?php }; ?>
                            
							<?php for($i = 0; $i < $qtdNiveis; $i++){ ?>
							<option value="<?php echo ($i + 1); ?>"><?php echo $niveis[$i]; ?></option>
                            <?php }; ?>
						</select>
                        </div></td>
                    </tr>
                    <tr>
                    	<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'")); ?>
                    	<input type="hidden" name="usuarioLogado" value="<?php echo $usuarioLogado['nome']." ".$usuarioLogado['sobrenome']; ?>">
                    	<input type="hidden" name="usuarioAntigo" value="<?php echo $rsBuscaUsuarios['usuario']; ?>">
                    	<input type="hidden" name="idUsuario" value="<?php echo $rsBuscaUsuarios['idUsuario']; ?>">
                        <?php if($rsBuscaUsuarios['status'] == 0){ ?>
                    	<td colspan="4" align="right"><input type="checkbox" name="status" value="1" checked>Usuário Desativado</td>
						<?php }else{ ?>
                    	<td colspan="4" align="right"><input type="checkbox" name="status" value="1"> Desativar Usuário</td>
						<?php }; ?>
                    	<td align="right"><input type="submit" name="atualizarUsuario" value="Atualizar Usuário" class="largura100 right btnSubmit"></td>
                    </tr>
                </tbody>
            </table>
        </form>
		<?php
            };
        ?>
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
	if(isset($_POST['nivel'])){ $nivel = $_POST['nivel']; }else{ $nivel = NULL; };
	$supervisor			= $_POST['supervisor'];
	$usuarioAntigo		= $_POST['usuarioAntigo'];
	$idUsuario			= $_POST['idUsuario'];
	if(isset($_POST['status'])){ $status = 0; }else{ $status = 1; };
	$usuarioLogado		= $_POST['usuarioLogado'];
	
	echo atualizaUsuarios($usuario, $senha, $repeteSenha, $nivel, $nome, $sobrenome, $email, $supervisor, $status, $idUsuario, $usuarioAntigo, $usuarioLogado);
};
?>
</body>
</html>