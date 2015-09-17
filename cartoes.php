<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == "" ){ header("Location: index.php"); };
$nivel = $_SESSION['nivel'];
if($_SESSION['nivel'] == 1){}else if($_SESSION['nivel'] == 2) {}else {session_destroy(); header("Location: index.php");}
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $usuarioLogado['idUsuario'];
$nome = $usuarioLogado['nome']." ".$usuarioLogado['sobrenome'];

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
	<div class="clear bgBranco secao1 aprovar-reprovar">
    <h2>Pedidos de cartões solicitados<br><span>Aqui você podera visualizar as solicitações de cartões pedidas por consultores.</span></h2>
     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <table style="margin-top: 10px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0"><!-- esta table é para ajuste no firefox que a primeira table sai fora da tela -->
      </table>
    <?php 
	
	$buscarCartao = odbc_exec($conexao, "select * from 
  [MARKETING].[dbo].[novoCartaoDMTRIX] c inner join lojasDMTRIX l on c.idLoja = l.idLoja inner join usuariosDMTRIX u on u.idUsuario = c.idUsuario where c.status = 1");
	
	while($rsBuscaCartao = odbc_fetch_array($buscarCartao)){
		
		 	
		
	?>
   
     <table style="margin-top: 10px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                	<td>Código do Cartão</td>
                    <td>Data</td>
                    <td>Solicitante</td>
                    <td>Loja</td>
                    <td>Site</td>
                    <td>Descrição</td>
                    
                </tr>
            </thead>
            
            <tbody>
                <tr>
                	<td><?php echo $rsBuscaCartao['idCartao']; ?></td>
                    <td><?php echo $rsBuscaCartao['dataSolicitacao']; ?></td>
                    <td><?php echo $rsBuscaCartao['nome']." ".$rsBuscaCartao['sobrenome']; ?></td>
                    <td><?php echo $rsBuscaCartao['nomeLoja']; ?></td>
                    <td><a href="<?php echo $rsBuscaCartao['site']; ?>">Site da Loja</a></td>
                    <td><textarea name="descricao" placeholder="Descrição do cartão"><?php echo $rsBuscaCartao['descricao']; ?></textarea></td>
                    <input type="hidden" name="idCartao[]" value="<?php echo $rsBuscaCartao['idCartao']; ?>">
                </tr>
                
                <tr>
                	<td colspan="1" align="center"><a href="../dmtrade/img/brindes/<?php echo $rsBuscaCartao['logotipo2']; ?>"><div class="btnAzul largura100">Baixar logo</div></a></td>
                    <td><div style="margin-left: 60px; margin-top:37px" class="campo clear"><select name="funciorio[]">
                    <option value="10">Flavio</option>
                    <option value="12">Diego</option>
                    <option value="13">Saulo</option>
                    <option value="14">Ana Plesky</option>
                    
                    </select></div>
                    </td>
                </tr>
            </tbody>
        </table>
      
       
       <?php } ?>
       
       		<div align="right" style="margin-top:30px"><input type="submit" name="Delegar" value="Delegar Tarefas" class="btnSubmit largura25"></div>
    	 </form>
    </div>
    
    	<?php include("rodape.php");
		
		if(isset($_POST['Delegar']))
		{
			$funcionario = $_POST['funciorio'];
			$idCartao = $_POST['idCartao'];
			$tipo = 1;
			
			addTarefa ($funcionario, $idCartao, $nome, $tipo);
			
			
			
		}
		
		
		
		 ?>
    
  </div>
</body>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
</html>