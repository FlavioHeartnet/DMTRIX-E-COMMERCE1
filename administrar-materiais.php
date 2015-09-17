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
    	<h2>Materiais<br><span>Insira materiais do sistema.</span></h2>
	
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="left">
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
                <tbody>
                	<tr>
                    	<td width="20%"><div class="campo"><input type="text" name="material" class="left" placeholder="Material" required></div></td>
                    	<td width="20%"><div class="campo"><input type="text" name="valor" class="left" placeholder="Valor" data-mask="0000.00" data-mask-reverse="true" required></div></td>
                    	<td width="20%"><div class="campo">
                        <select name="formaCalculo">
                        	<option value="">Forma de Cálculo</option>
                            <option value="1">Free (Ex.: Arte Monitor)</option>
                            <option value="2">Metro (Ex.: Banner)</option>
                            <option value="3">Unidade (Ex.: Regulamento/Cartaz A3)</option>
                            <option value="4">Pacote (Ex.: Flyer 5000uni.)</option>
                        </select>
                        </div></td>
                    	<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = 	 		'$usuarioLogado'")); ?>
                    	<input type="hidden" name="usuarioLogado" value="<?php echo $usuarioLogado['nome']." ".$usuarioLogado['sobrenome']; ?>">
                    	<td width="20%"><div class="campo"><input type="text" name="quantidade" class="left" placeholder="Quantidade" disabled></div></td>				
                    	<td width="20%"><input type="file" name="foto"> </td>
                        
                    </tr>
                    <tr>
                    <td width="20%"><div class="campo"><select name="categoria">
                    <option value="">Categorias</option>
					<?php
                    
					$categoria = odbc_exec($conexao, 'select * from categoriaDMTRIX');
					
					while($rsCategoria = odbc_fetch_array($categoria)){
					
					?>
                    <option value="<?php echo $rsCategoria['idCategoria'] ?>"><?php echo utf8_encode($rsCategoria['nomeCategoria']); ?></option>
                    

                    <?php } ?>
                    
                    </select></div></td>
                    <td width="20%"><input type="submit" name="cadastrarMaterial" value="Cadastrar Material" class="largura100 right btnSubmit"></td></tr>
                </tbody>
            </table>
            <?php
				//Edição de Materiais 
			?>
        </form>
        
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="left">
        <?php
		
		$buscaMaterial2 = odbc_exec($conexao, "SELECT * FROM dbo.categoriaDMTRIX order by nomeCategoria");		
		 ?>
          <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
         <td><div class="campo"><select name="seletor">
         
         <option value="">Busca rapida</option>
         
         <?php 
		 while($rsMaterial = odbc_fetch_array($buscaMaterial2)){
		 ?>
         
         <option value="<?php echo $rsMaterial['idCategoria']; ?>"><?php echo utf8_encode($rsMaterial['nomeCategoria']); ?></option>
         
         <?php } ?>
         </select></div></td>
         
         </tr>
         
         <tr>
         	<td><input type="submit" value="buscar" name="categoria" class="btnSubmit left largura25"></td>
         </tr>
         </table>
        </form>
        
        
        
        <h2> <br><span>Edite materiais do sistema.</span></h2>
    	<?php
		
		
			if($_POST['seletor'] == ""){
			
            $buscaMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX order by materiaisDMTRIX.material");
            while($rsBuscaMaterial = odbc_fetch_array($buscaMaterial)){
        ?>
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="left">
        	
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <thead>
                <tr>
                 	<td colspan="5" id="<?php echo $rsBuscaMaterial['material']; ?>"><?php echo $rsBuscaMaterial['material']; ?></td>   
                 </tr>
                 </thead>
                	<tr>
                    	<td width="20%"><div class="campo"><input type="text" name="material" class="left" placeholder="Material" data-mask-reverse="false" required value="<?php echo $rsBuscaMaterial['material']; ?>"></div></td>
                    	<td width="20%"><div class="campo"><input type="text" name="valor" class="left" placeholder="Valor" data-mask="0000.00" data-mask-reverse="true"
                         <?php 
						 	if($rsBuscaMaterial['formaCalculo'] == 1)
							{
								echo "readonly";
							}
						 ?> 
                         required value="<?php echo $rsBuscaMaterial['valor']; ?>"></div></td>
                    	<td width="20%"><div class="campo">
                        <?php
						$formaCalculo;
							switch($rsBuscaMaterial['formaCalculo'])
								{
									case 1: $formaCalculo = "Free (Ex.: Arte Monitor)";
									break;
									
									case 2: $formaCalculo = "Metro (Ex.: Banner)";
									break;
									
									case 3: $formaCalculo = "Unidade (Ex.: Regulamento/Cartaz A3)";
									break;
									
									case 4: $formaCalculo = "Pacote (Ex.: Flyer 5000uni.)";
									break;
									
									default: $formaCalculo = "Opção invalida, selecione uma forma correta!";
								}
						 ?>
                        <select name="formaCalculo">
                        	<option value="<?php echo $rsBuscaMaterial['formaCalculo'];?>"><?php echo $formaCalculo;?></option>
                            <option value="1">Free (Ex.: Arte Monitor)</option>
                            <option value="2">Metro (Ex.: Banner)</option>
                            <option value="3">Unidade (Ex.: Regulamento/Cartaz A3)</option>
                            <option value="4">Pacote (Ex.: Flyer 5000uni.)</option>
                        </select></div></td>
                    	<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = 	 					'$usuarioLogado'")); ?>
                    	<input type="hidden" name="usuarioLogado" value="<?php echo $usuarioLogado['nome']." ".$usuarioLogado['sobrenome']; ?>">
                        <input type="hidden" name="idMaterial" value="<?php echo $rsBuscaMaterial['idMaterial'];?>">
                    	<td width="20%"><div class="campo"><input type="text" name="quantidade"
                         <?php 
						 	if($rsBuscaMaterial['formaCalculo'] != 4)
							{
								echo "disabled";
							}
						 ?> class="left" placeholder="Quantidade" value="<?php echo $rsBuscaMaterial['quantidade']; ?>"></div></td>
                    		<td width="20%"><input type="file" name="foto" value="<?php echo $rsBuscaMaterial['foto']; ?>"></td>
                    </tr>
                    <tr><td width="20%"><input type="submit" name="AtualizaMaterial" value="Atualizar Material"  class="largura100 right btnSubmit"></td></tr>
                </tbody>
            </table>
        </form>
		<?php
            };
			
			
			}else{
				
				$idCategoria = $_POST['seletor'];
				
				$buscaMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX where categoria = '$idCategoria'");
            	while($rsBuscaMaterial = odbc_fetch_array($buscaMaterial)){
				
				?>
				<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="left">
        	
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <thead>
                <tr>
                 	<td colspan="5" id="<?php echo $rsBuscaMaterial['material']; ?>"><?php echo utf8_encode($rsBuscaMaterial['material']); ?></td>   
                 </tr>
                 </thead>
                	<tr>
                    	<td width="20%"><div class="campo"><input type="text" name="material" class="left" placeholder="Material" required value="<?php echo $rsBuscaMaterial['material']; ?>"></div></td>
                    	<td width="20%"><div class="campo"><input type="text" name="valor" class="left" placeholder="Valor" data-mask="0000.00" data-mask-reverse="true"
                         <?php 
						 	if($rsBuscaMaterial['formaCalculo'] == 1)
							{
								echo "readonly";
							}
						 ?> 
                         required value="<?php echo $rsBuscaMaterial['valor']; ?>"></div></td>
                    	<td width="20%"><div class="campo">
                        <?php
						$formaCalculo;
							switch($rsBuscaMaterial['formaCalculo'])
								{
									case 1: $formaCalculo = "Free (Ex.: Arte Monitor)";
									break;
									
									case 2: $formaCalculo = "Metro (Ex.: Banner)";
									break;
									
									case 3: $formaCalculo = "Unidade (Ex.: Regulamento/Cartaz A3)";
									break;
									
									case 4: $formaCalculo = "Pacote (Ex.: Flyer 5000uni.)";
									break;
									
									default: $formaCalculo = "Opção invalida, selecione uma forma correta!";
								}
						 ?>
                        <select name="formaCalculo">
                        	<option value="<?php echo $rsBuscaMaterial['formaCalculo'];?>"><?php echo $formaCalculo;?></option>
                            <option value="1">Free (Ex.: Arte Monitor)</option>
                            <option value="2">Metro (Ex.: Banner)</option>
                            <option value="3">Unidade (Ex.: Regulamento/Cartaz A3)</option>
                            <option value="4">Pacote (Ex.: Flyer 5000uni.)</option>
                        </select></div></td>
                    	<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = 	 					'$usuarioLogado'")); ?>
                    	<input type="hidden" name="usuarioLogado" value="<?php echo $usuarioLogado['nome']." ".$usuarioLogado['sobrenome']; ?>">
                        <input type="hidden" name="idMaterial" value="<?php echo $rsBuscaMaterial['idMaterial'];?>">
                    	<td width="20%"><div class="campo"><input type="text" name="quantidade"
                         <?php 
						 	if($rsBuscaMaterial['formaCalculo'] != 4)
							{
								echo "disabled";
							}
						 ?> class="left" placeholder="Quantidade" value="<?php echo $rsBuscaMaterial['quantidade']; ?>"></div></td>
                    		<td width="20%"><input type="file" name="foto" value="<?php echo $rsBuscaMaterial['foto']; ?>"></td>
                    </tr>
                    <tr><td width="20%"><input type="submit" name="AtualizaMaterial" value="Atualizar Material"  class="largura100 right btnSubmit"></td></tr>
                </tbody>
            </table>
        </form>
				
				<?php
					}//fim do while
				}//else do if
			
		
			
        ?>
        
    </div>
    
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(e) {
    jQuery("select[name='formaCalculo']").change(function(){
		if(jQuery(this).val() == 4)
		{
			jQuery(this).parent("div").parent("td").nextAll("td").children("div").children("input[name='quantidade']").attr("disabled", false);
		}else{
			jQuery(this).parent("div").parent("td").nextAll("td").children("div").children("input[name='quantidade']").attr("disabled", true);
		};
		
		if(jQuery(this).val() == 1)
		{
			jQuery(this).parent("div").parent("td").prev("td").children("div").children("input[name='valor']").attr("readonly", true).val(0.00);
		}else{
			jQuery(this).parent("div").parent("td").prev("td").children("div").children("input[name='valor']").attr("readonly", false);
		};
	});
	
	jQuery("a").click(function(){
		var alvo = jQuery(this).attr("href").split("#").pop();
		jQuery("html, body").animate({scrollTop: jQuery("#" + alvo).offset().top }, 1000);
		return false;
	});
	
});
</script>
<?php
	if(isset($_POST['cadastrarMaterial'])){
	$material		= $_POST['material'];
	$valor			= $_POST['valor'];
	$formaCalculo	= $_POST['formaCalculo'];
	$nome_material = $_FILES['foto']['name'];
	$nome_temp = $_FILES['foto']['tmp_name'];
	
	$exteFoto = explode('.', $nome_material);
	$exteFoto_ex = strtolower(end($exteFoto)); 
	
	
	$nome_tratado = preg_replace('/[^[:alpha:]_]/', '', $material);
	$extencaoF = $nome_tratado.".".$exteFoto_ex;
	
	if($formaCalculo == 4){
	$quantidade		= $_POST['quantidade'];
	}else{
		$quantidade = 1;	
		}
	$usuarioLogado  = $_POST['usuarioLogado'];
	$categoria = $_POST['categoria'];
	
	
	
	echo CarregaFoto($extencaoF,$nome_temp);
	echo cadastraMaterial($material, $valor, $formaCalculo, $quantidade, $usuarioLogado, $extencaoF, $categoria);
	
	}else if(isset($_POST['AtualizaMaterial']))
	{
	$material		= $_POST['material'];
	$id				= $_POST['idMaterial'];
	$valor			= $_POST['valor'];
	$formaCalculo	= $_POST['formaCalculo'];
	if($formaCalculo == 4){
	$quantidade		= $_POST['quantidade'];
	}else{
		$quantidade = 1;	
		}
	$usuarioLogado = $_POST['usuarioLogado'];
	$nome_material = $_FILES['foto']['name'];
	$nome_temp = $_FILES['foto']['tmp_name'];
	
	if($nome_material != "")
		{
	
	$exteFoto = explode('.', $nome_material);
	$exteFoto_ex = strtolower(end($exteFoto)); 
	
	
	$nome_tratado = preg_replace('/[^[:alpha:]_]/', '', $material);
	$extencaoF = utf8_encode($extencaoF = $nome_tratado.".".$exteFoto_ex);
	
	echo "<script>alert('$exteFoto, extensão, $nome_material, material, extensão final: $extencaoF');</script>";
		echo CarregaFoto($extencaoF,$nome_temp);
		}else
		{
			$extencaoF = "";
		}
		
		
		AtualizaMaterial ($material, $valor, $formaCalculo, $quantidade, $usuarioLogado, $id, $extencaoF);
	};
			
	
?>
</body>
</html>