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
	<div class="clear bgBranco secao1">
    	<h2>Cadastrar dicas<br><span>Aqui você pode cadastrar dicas que serão visualizadas na home</span></h2>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<div class="clear">
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="20px">
                
                <tr>
                	<td>Digite o titulo da dica!</td>
                </tr>
                <tr>
                	<td><div class="campo largura40"><input  required  autocomplete="off" type="text" name="titulo" placeholder="Digite o titulo!" ></div></td>
                </tr>
             </table>
				<table width="100%" align="center" border="0" cellpadding="0" cellspacing="20px">
               
                    <?php
					$buscaMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX order by materiaisDMTRIX.material ASC");
					  while($rsBuscaMaterial = odbc_fetch_array($buscaMaterial)){
						  
						  $idMaterial =  $rsBuscaMaterial['idMaterial'];
					 ?>
                    <tr>
                        <td align="left" valign="middle" class="checks"><input type="checkbox" name="produto[]" id="produtoHome<?php echo $idMaterial;  ?>" value="<?php echo $idMaterial; ?>"><label for="produtoHome<?php echo $idMaterial; ?>"></label></td>
                        
                        
                        <td align="left" valign="middle"><label for="produtoHome<?php echo $idMaterial; ?>"><img class="imagemConsulta" src="../dmtrade/img/brindes/<?php echo $rsBuscaMaterial['foto'];?>"></label></td>
                        <td align="left" valign="middle" style="border-right:1px solid #d4d4d4;"></td>
                        
                        <td align="left" valign="middle"><label for="produtoHome<?php echo $idMaterial; ?>"><p><?php echo $rsBuscaMaterial['material'] ?><br>R$<?php echo $rsBuscaMaterial['valor']; ?> m²</p></label></td>
                        <label for="produtoHome<?php echo $idMaterial; ?>"><input type="hidden" name="nome[]" value="<?php echo $rsBuscaMaterial['material']; ?>"></label>
                        <label for="produtoHome<?php echo $idMaterial; ?>"><input type="hidden" name="valor[]" value="<?php echo $rsBuscaMaterial['valor']; ?>"></label>
                        
                        <td>
                            
                    </tr>
                    <?php }; ?>
				</table>
                

			</div>
            <input type="submit" name="dicas" value="Adicionar Itens para dicas" class="largura25 right btnSubmit">
        </form>




  </div>
    <?php include("rodape.php"); 
	
	
	if(isset($_POST['dicas']))
{
    
	$idMaterial = $_POST['produto'];
	$titulo = $_POST['titulo'];
	$valor = $_POST['valor'];
	$nome = $_POST['nome'];
	$count = count($idMaterial);
	
	$dicas = odbc_exec($conexao, "insert into [MARKETING].[dbo].[dicasDMTRIX] (titulo, ativo) values ('$titulo','nao')");
	$idDicas = odbc_fetch_array(odbc_exec($conexao, "select  *  from [MARKETING].[dbo].[dicasDMTRIX] order by idDica DESC"));
	
	$idDica = $idDicas['idDica'];
	
	for($i=0;$i < $count; $i++)
	{
		$dicas = odbc_exec($conexao, "insert into [MARKETING].[dbo].[produtosDicasDMTRIX] (nome,  idMaterial, idDica,valor) values ('$nome[$i]', '$idMaterial[$i]', '$idDica', '$valor[$i]')");	
	}
	
		if($dicas == true)
			{
				$historico = odbc_exec($conexao, "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: Maria Lidia Adicionou uma dica')");
		echo "<script>alert('Cadastrado com sucesso'); location.href='cadastrar-dicas.php';</script>";
		return true;
			}else
			{
				echo "<script>alert('ocorreu um problema no cadastro, contate o administrador');  history.back(-1);</script>";
		return true;
			}
}


?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>
</html>