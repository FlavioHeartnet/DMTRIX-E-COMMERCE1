<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == ""){ header("Location: index.php"); };
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $_SESSION['usuario'];
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
    		
        
       	<div id="tab" style=" border:0px; background:#FFF">
        <h2>Solicitação de Novo Cartão<br><span>Informe-nos os dados abaixo que tentaremos criar um belo cartão para a loja.</span></h2>
        	<ul style="background:#FFF; border: 0px"> 
            	<li><a href="#aba-1">Loja cadastrada</a></li>
            	<li><a href="#aba-2">Loja não cadastrada</a></li>  
            </ul>

			<div id="aba-1" style="background:#FFF ">
        		<form id="rede" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
          
        <table  style="margin-left:0px" width="48%"  border="0" cellpadding="0" cellspacing="0">
        	<tr class="semBorda">
            	 
            	<td align="left"><div class="campo"><select id="selecionado" name="nomeRede"  required>
                <option value="">Nome da Rede</option>
                <?php
				
				
				 $idUsuario = $usuarioLogado['idUsuario'];
			$nome = $usuarioLogado['nome'];
			$nivel = $usuarioLogado['nivel'];
                    if($nivel == 3){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT [rede] FROM [MARKETING].[dbo].[lojasDMTRIX] INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.supervisor = '$idUsuario' OR
                        dbo.usuariosDMTRIX.idUsuario = '$idUsuario'
                        ORDER BY numeroLoja ASC");
                    }elseif($nivel == 4){
                        $buscaTodasLojas = odbc_exec($conexao, " SELECT distinct rede FROM [MARKETING].[dbo].[lojasDMTRIX] INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.idUsuario = '$idUsuario'");
                    }elseif($nivel == 5){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT [rede] FROM [MARKETING].[dbo].[lojasDMTRIX] INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.idUsuario = '$idUsuario'
                        ORDER BY numeroLoja ASC");
                    }else
					{
						$buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT [rede] FROM [MARKETING].[dbo].[lojasDMTRIX]");
					};
                    while($rsBuscaTodasLojas = odbc_fetch_array($buscaTodasLojas)){
				 	
					
				?>
                	<option value="<?php echo $rsBuscaTodasLojas['rede'];?>"><?php echo $rsBuscaTodasLojas['rede'];?></option>
                    
                    
                    <?php } ?>
                
                </select></div></td>
                
            </tr>
            </table>
      </form>
            <?php if(isset($_POST['nomeRede']))
			{
			?>
      <form  enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        		<table width="48%" align="left" border="0" cellpadding="0" cellspacing="0">
        	<tr class="semBorda">
            	<td align="left"><div class="campo"><select name="nomeLoja" placeholder="Nome da Loja" required>                
                <option value="">Nome da Loja</option>
                <?php
				 $idUsuario = $usuarioLogado['idUsuario'];
			$nome = $usuarioLogado['nome'];
			$nivel = $usuarioLogado['nivel'];
			$rede = $_POST['nomeRede'];
                    if($nivel == 3){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.supervisor = '$idUsuario' OR
                        dbo.usuariosDMTRIX.idUsuario = '$idUsuario' and dbo.lojasDMTRIX.rede = '$rede'
                        ORDER BY numeroLoja ASC");
                    }elseif($nivel == 4){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.idUsuario = '$idUsuario' and dbo.lojasDMTRIX.rede = '$rede'
                        ORDER BY numeroLoja ASC");
                    }elseif($nivel == 5){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.idUsuario = '$idUsuario' and dbo.lojasDMTRIX.rede = '$rede'
                        ORDER BY numeroLoja ASC");
                    }else
					{
						$buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX where rede = '$rede'");
					};
                    while($rsBuscaTodasLojas = odbc_fetch_array($buscaTodasLojas)){
				 
				?>
                
                <option value="<?php echo $rsBuscaTodasLojas['idLoja'];?>"><?php echo $rsBuscaTodasLojas['nomeLoja'];?> - numero da loja: <?php echo $rsBuscaTodasLojas['numeroLoja'];?> </option>
                
                <?php } ?>
                </select>
           </div></td>
           
           </tr>
           
           <tr class="semBorda">
            	<td align="center"><div class="campo"><input type="text" name="site" placeholder="digite o site de sua loja."></div></td>
            </tr>
           
        	<tr class="semBorda">
            	<td align="center"><div class="campo"><input type="file" name="lojaAnexo"></div></td>
            </tr>
            
        </table>
        <table width="48%" align="right" border="0" cellpadding="0" cellspacing="0">
        	<tr class="semBorda">
            	<td align="center"><div class="campo" style="height:180px;"><textarea name="briefing" placeholder="Descreva aqui a média de idade dos clientes, classe social, etc." required style="height:180px; line-height:25px;"></textarea></div></td>
            </tr>
            <tr>
            	<td><input type="submit" name="enviaLoja" value="Enviar Pedido" class="largura33 right btnSubmit"></td>
            </tr>
        </table>
       	
        </form>
        	
        <?php } ?>
         		</div>
                
                <div id="aba-2" style="background:#FFF">
                 <form  enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        		<table width="48%" align="left" border="0" cellpadding="0" cellspacing="0">
                <tr class="semBorda">
            	<td align="center"><div class="campo"><input required type="text" name="site" placeholder="digite o site de sua loja/ou fanpage."></div></td>
            </tr>
           
        	<tr class="semBorda">
            	<td align="center"><div class="campo"><input required type="file" name="anexo"></div></td>
            </tr>
            
        </table>
        <table width="48%" align="right" border="0" cellpadding="0" cellspacing="0">
        	<tr class="semBorda">
            	<td align="center"><div class="campo" style="height:180px;"><textarea name="briefing" placeholder="Descreva aqui a média de idade dos clientes, classe social, como você imagina o cartão, etc." required style="height:180px; line-height:25px;"></textarea></div></td>
            </tr>
            <tr>
            	<td><input type="submit" name="envia" value="Enviar Pedido" class="largura33 right btnSubmit"></td>
            </tr>
        </table>
       	
        </form>
                
                </div>
                
                
        		</div>
        		
   </div>
    
    
    <?php include("rodape.php"); ?>
</div>
<?php

if(isset($_POST['envia']))
{
	
		$idLoja = "";
		$descricao = $_POST['briefing'];
		$site = $_POST['site'];
		$logo = $_FILES['anexo']['name'];
		$nome_temp = $_FILES['anexo']['tmp_name'];
		
		$exteFoto = explode('.', $logo);
		$exteFoto_ex = strtolower(end($exteFoto)); 
		

	
		$extencaoF = $logo;
		
		
		echo CarregaLogo($extencaoF,$nome_temp);
		echo AddCartao($site, $extencaoF, $descricao, $idLoja, $usuario);
			
	
	
}else if(isset($_POST['enviaLoja']))
{
		$idLoja = $_POST['nomeLoja'];
		$descricao = $_POST['briefing'];
		$site = $_POST['site'];
		
		
		$logo = $_FILES['lojaAnexo']['name'];
		$nome_temp = $_FILES['lojaAnexo']['tmp_name'];
		
		$exteFoto = explode('.', $logo);
		$exteFoto_ex = strtolower(end($exteFoto)); 
		$extencaoF =$exteFoto_ex.$logo;
		

	
		
		
		
		echo CarregaLogo($extencaoF,$nome_temp);
		echo AddCartao($site, $extencaoF, $descricao, $idLoja, $usuario);
}



?>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">

$( "#tab" ).tabs({
  show: { effect: "blind", duration: 800 }
});

</script>
</body>
</html>