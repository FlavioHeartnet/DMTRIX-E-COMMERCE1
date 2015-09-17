<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuarioLogado2 = $usuarioLogado['idUsuario'];

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
    	<h2>Administrar Brindes<br><span>Você pode adicionar e editar brindes disponiveis na loja.</span></h2>
        
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="left">
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
                <tbody>
                	<tr>
                    	<td width="20%"><div class="campo"><input  type="text" name="Brinde" class="left" placeholder="Brinde" required></div></td>
                    	<td width="20%"><div class="campo"><input  type="text" name="valor" class="left" placeholder="Valor" data-mask="0000.00" data-mask-reverse="true" required></div></td>
                    	<td width="20%"><div class="campo"><input  required type="text" name="quantidade" class="left" placeholder="Quantidade" ></div></td>				
                    	<td width="20%"><input type="file" required name="foto"> </td>
                        
                    </tr>
                    <tr><td width="20%"><input type="submit" name="cadastrarBrinde" value="Cadastrar Brinde" class="largura100 right btnSubmit"></td></tr>
                </tbody>
            </table>
            </form>
            
            
            <h2>Editar Brindes <br><span>Edite os Brindes do Sistema e suas informações.</span></h2>
    	<?php
            $buscaBrinde= odbc_exec($conexao, "SELECT * FROM dbo.brindesDMTRIX order by Brinde");
            while($rsBuscaBrinde = odbc_fetch_array($buscaBrinde)){
        ?>
        	<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="left">
        	
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <thead>
                <tr>
                 	<td colspan="5"><?php echo $rsBuscaBrinde['brinde']; ?></td>   
                 </tr>
                 </thead>
                	<tr>
                    	<td width="20%">Brinde: <div class="campo"><input type="text" name="Brinde" class="left" placeholder="Brinde" required value="<?php echo $rsBuscaBrinde['brinde']; ?>"></div></td>
                    	<td width="20%">Valor: <div class="campo"><input type="text" name="valor" class="left" placeholder="Valor" data-mask="0000.00" data-mask-reverse="true"
                         required value="<?php echo $rsBuscaBrinde['valor']; ?>"></div></td>
                        <input type="hidden" name="idBrinde" value="<?php echo $rsBuscaBrinde['idBrinde'];?>">
                    	<td width="20%">Estoque: <div class="campo"><input type="text" name="quantidade" class="left" placeholder="Estoque atual: <?php echo $rsBuscaBrinde['estoque']; ?>" ></div></td>
                    		<td width="20%"><input type="file" name="foto" value="<?php echo $rsBuscaBrinde['foto']; ?>"></td>
                    </tr>
                    <tr><td width="20%"><input type="submit" name="AtualizaBrinde" value="Atualizar Brinde"  class="largura100 right btnSubmit"></td></tr>
                </tbody>
            </table>
        </form>
		<?php
            };
        ?>
            </div>
      
        

        
<?php
 if(isset($_POST['cadastrarBrinde'])){
	$Brinde		= $_POST['Brinde'];
	$valor			= $_POST['valor'];
	$quantidade	= $_POST['quantidade'];
	$nome_brinde = $_FILES['foto']['name'];
	$nome_temp = $_FILES['foto']['tmp_name'];
	
	$exteFoto = explode('.', $nome_brinde);
	$exteFoto_ex = strtolower(end($exteFoto)); 

	$nome_tratado = preg_replace('/[^[:alpha:]_]/', '', $Brinde);
	$extencaoF = $nome_tratado.".".$exteFoto_ex;
	$usuarioLogado  = $usuarioLogado2;
	
     CarregaBrinde($extencaoF,$nome_temp);
	echo cadastraBrinde($Brinde, $valor, $quantidade, $usuarioLogado, $extencaoF);
	
	
 }else if(isset($_POST['AtualizaBrinde']))
 {
	 
	$Brinde		= $_POST['Brinde']; 
	$idBrinde = $_POST['idBrinde'];
	$valor			= $_POST['valor'];
	$quantidade	= $_POST['quantidade'];
	$nome_brinde = $_FILES['foto']['name'];
	$nome_temp = $_FILES['foto']['tmp_name'];
	$usuarioLogado  = $usuarioLogado2;
	

	
	
	if($nome_brinde != ""){
		
	$exteFoto = explode('.', $nome_brinde);
	$exteFoto_ex = strtolower(end($exteFoto)); 	
		
	$nome_tratado = preg_replace('/[^[:alpha:]_]/', '', $Brinde);
	$extencaoF = utf8_encode($extencaoF = $nome_tratado.".".$exteFoto_ex);
	
	
	echo CarregaBrinde($extencaoF,$nome_temp);
	
	}else
	{
		$extencaoF = "";
	}
	echo AtualizaBrinde($Brinde, $valor, $quantidade, $usuarioLogado, $extencaoF, $idBrinde);
	
 }
 

 include("rodape.php");?>      
 </div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>
