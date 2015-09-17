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
    	<h2>Dicas cadastradas<br><span>Aqui você pode selecionar dicas que serão visualizadas na home</span></h2>
        
        
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="20px">
               
                    <?php
					$buscaDica = odbc_exec($conexao, "SELECT * FROM dbo.dicasDMTRIX order by titulo ASC");
					  while($rsbuscaDica = odbc_fetch_array($buscaDica)){
						  
						  $idDica =  $rsbuscaDica['idDica'];
						  
						  
					 ?>
                    <tr>
                        <td align="left" valign="middle" class="checks"><input type="checkbox" name="produto[]" id="produtoHome<?php echo $idDica;  ?>" value="<?php echo $idDica; ?>"><label for="produtoHome<?php echo $idDica; ?>"></label></td>
                        
                        
                        <td align="left" valign="middle" style="border-right:1px solid #d4d4d4;"></td>
                        
                        <td align="left" valign="middle"><label for="produtoHome<?php echo $idDica; ?>"><p><div class="campo largura40"><input id="produtoHome<?php echo $idDica;  ?>" type="text" name="titulo[]" value="<?php echo $rsbuscaDica['titulo'] ?>"></div><br></label></td>
                        
                        <td>
                        <input type="hidden" name="idPro[]" id="produtoHome<?php echo $idDica;  ?>" value="<?php echo $idDica; ?>">
                            
                    </tr>
                    <?php }; ?>
				</table>
                

		
            <input type="submit" name="dicas" value="Selecionar dica" class="largura25 right btnSubmit">
        </form>
  
  
  
  </div>
    <?php include("rodape.php");
	
	if(isset($_POST['dicas']))
	{
		$titulo = $_POST['titulo'];
		$dica = $_POST['produto'];
		$id = $_POST['idPro'];
		$count = count($dica);
		$count2 = count($id);
		
		

			if($count > 1)
			{
				
				echo "<script>alert('Voce so pode selecionar uma dica para a home');</script>";
				
			}else if($count == 1)
			{
				$dicas = odbc_fetch_array(odbc_exec($conexao, "select * from [MARKETING].[dbo].[dicasDMTRIX] where ativo = 'sim'"));
				$DicaAtiva = $dicas['idDica'];
				
				$dicas = odbc_exec($conexao, "update [MARKETING].[dbo].[dicasDMTRIX] set ativo = 'nao' where idDica = '$DicaAtiva'");
				
				$dicas = odbc_exec($conexao, "update [MARKETING].[dbo].[dicasDMTRIX] set ativo = 'sim' where idDica = '$dica[0]'");
				
				for($i = 0;$i < $count2; $i++)
				{
					$dicas2 = odbc_exec($conexao, "update [MARKETING].[dbo].[dicasDMTRIX] set titulo = '$titulo[$i]' where idDica = '$id[$i]'");
				}
				
				if($dicas == true)
				{
				$historico = odbc_exec($conexao, "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: Maria Lidia selecionou uma dica '$dica[0]')");
				echo "<script>alert('selecionado com sucesso'); location.href='home.php';</script>";
				return true;
				}else
				{
				echo "<script>alert('ocorreu um problema ao selecionar, contate o administrador');  history.back(-1);</script>";
				return true;
			}
				
				
			}else
			{
				echo "<script>alert('Ocorreu um erro ao tentar colocar a dica na home');</script>";
			}
	}
	
	?>      
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>
</html>
