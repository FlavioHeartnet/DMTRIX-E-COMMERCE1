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

<body onLoad="verificaLogin(), mudaStatus()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna">

        <h2>Historico de Novos Cartão solicitados<br><span>Baixe e consulte o historico de solicitações de cartões</span></h2>
        <?php 
		$buscaUsuarios = odbc_exec($conexao, "select * from usuariosDMTRIX where nivel = 4 or nivel = 3 or nivel = 5");
		
		
		?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        	<tr>
            
            	<td><span id="compra1">Pesquise pelo Usuario(clique aqui).</span>
                
                <div class="campo tlg1"><select name="nomes">
                <option value="">Selecione o usuario</option>
                <option value="10">Flavio Nogueira</option>
                <?php 
				
				while($RsbuscaUsuarios = odbc_fetch_array($buscaUsuarios)){
				
				?>
                <option value="<?php echo $RsbuscaUsuarios['idUsuario']; ?>"><?php echo $RsbuscaUsuarios['nome']." ".$RsbuscaUsuarios['sobrenome'] ?></option>
                <?php
				}
				?>
                </select></div></td>
               
            </tr>
          
            </table>
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            
            <tr>
            	<td width="25%"><span id="data1">Pesquise por Datas(clique aqui).</span>
            
                	<div class="campo tlg2"><input  type="text" name="dataInicio" class="datepicker2"  data-mask="00/00/0000" data-mask-reverse="true" placeholder="Digite a data de proucura!"><br>
                    <div class="campo"><input  type="text" name="dataFinal" class="datepicker2"  data-mask="00/00/0000" data-mask-reverse="true" placeholder="Digite a data final para proucura!"></div></div></td>
                
            </tr>
          
            <tr>
            	<td width="25%"></td>
               
            </tr>
            
            <tr>
            	<td><input type="submit" name="Buscar" value="Procurar Pedido" class="largura25 right btnSubmit"></td>
            </tr>
            
            <tr id="informacoes">
            	
            </tr>
            </table>
            </form>
            <?php 
			if(isset($_POST['nomes']))
			{
				$nomes = $_POST['nomes'];

				$query = odbc_exec($conexao, " select * from novoCartaoDMTRIX n inner join lojasDMTRIX l on l.idLoja = n.idLoja inner join usuariosDMTRIX u on u.idUsuario = n.idUsuario where n.idUsuario = '$nomes'");

				while($rsbuscaCartao = odbc_fetch_array($query)){
				?>
                 <form action="baixarPDF.php" method="post" target="_blank">
                 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                <tr>
                	<td>Código do cartão</td>
                    <td>Data</td>
                    <td>Solicitante</td>
                    <td>Loja</td>
                    <td>site</td>
                    <td>Descrição</td>
                    
                </tr>
            	</thead>
                
                <tbody>
                <tr>
                	<td><p align="center"><?php echo $rsbuscaCartao['idCartao']; ?></p></td>
                    <td><?php $date = $rsbuscaCartao['dataSolicitacao'];
					
					$timeStamp = strtotime($date); echo date('d/m/Y', $timeStamp); ?><input type="hidden" name="semana" value="<?php echo date('l', $timeStamp);?>"><br><span class="semana">semana</span></td>
                    <td><?php echo $rsbuscaCartao['nome']." ".$rsbuscaCartao['sobrenome']; ?></td>
                    <td><?php echo $rsbuscaCartao['nomeLoja'];?></td>
                    <td><a href="<?php echo $rsbuscaCartao['site']; ?>">Site do cliente</a></td>
                    <td><?php echo $rsbuscaCartao['descricao']; ?></td>
                    <input type="hidden" name="idCartao[]" value="<?php echo $rsbuscaCartao['idCartao']; ?>">
                    <input type="hidden" name="descricao[]" value="<?php echo $rsbuscaCartao['descricao']; ?>">
                    <input type="hidden" name="loja[]" value="<?php echo $rsbuscaCartao['nomeLoja'];?>">
                    <input type="hidden" name="solicitante[]" value="<?php echo $rsbuscaCartao['nome']." ".$rsbuscaCartao['sobrenome']; ?>">
                    <input type="hidden" name="data[]" value="<?php echo $date;?>">
                    <input type="hidden" name="site[]" value="<?php echo $rsbuscaCartao['site'];?>">
                    
                </tr>
            </tbody>
                
                </table>
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                	<td><input style="margin-left: 81%; width:20%"  type="submit" name="pdf" value="Ralatorio em pdf" class="btnSubmit largura45 left"></td>
                </tr>
                </table>
                </form>
                <?php
				}
				
			}else if(isset($_POST['dataInicio']) and isset($_POST['dataFinal']))
			{
				$DataI = $_POST['dataInicio'];
				$DataF = $_POST['dataFinal'];
				
				$buscaCompra = odbc_exec($conexao, "  select DISTINCT * from novoCartaoDMTRIX n inner join lojasDMTRIX l on l.idLoja = n.idLoja inner join usuariosDMTRIX u on u.idUsuario = n.idUsuario where n.dataSolicitacao between '$DataI' and '$DataF'");
			while($rsbuscaCartao = odbc_fetch_array($buscaCompra)){
			?>
             <form action="baixarPDF.php" method="post" target="_blank">
                 <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            	<thead>
                <tr>
                	<td>Código do cartão</td>
                    <td>Data</td>
                    <td>Solicitante</td>
                    <td>Loja</td>
                    <td>site</td>
                    <td>Descrição</td>
                    
                </tr>
            	</thead>
                
                <tbody>
                <tr>
                	<td><p align="center"><?php echo $rsbuscaCartao['idCartao']; ?></p></td>
                    <td><?php $date = $rsbuscaCartao['dataSolicitacao'];
					$timeStamp = strtotime($date); echo date('d/m/Y', $timeStamp);?><input type="hidden" name="semana" value="<?php echo date('l', $timeStamp);?>"><br><span class="semana">semana</span></td>
                    <td><?php echo $rsbuscaCartao['nome']." ".$rsbuscaCartao['sobrenome']; ?></td>
                    <td><?php echo $rsbuscaCartao['nomeLoja'];?></td>
                    <td><a href="<?php echo $rsbuscaCartao['site']; ?>">Site do cliente</a></td>
                    <td><?php echo $rsbuscaCartao['descricao']; ?></td>
                    <input type="hidden" name="idCartao[]" value="<?php echo $rsbuscaCartao['idCartao']; ?>">
                    <input type="hidden" name="descricao[]" value="<?php echo $rsbuscaCartao['descricao']; ?>">
                    <input type="hidden" name="loja[]" value="<?php echo $rsbuscaCartao['nomeLoja'];?>">
                    <input type="hidden" name="solicitante[]" value="<?php echo $rsbuscaCartao['nome']." ".$rsbuscaCartao['sobrenome']; ?>">
                    <input type="hidden" name="data[]" value="<?php echo $date;?>">
                    <input type="hidden" name="site[]" value="<?php echo $rsbuscaCartao['site'];?>">
                    
                </tr>
            </tbody>
                
                </table>
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                	<td><input style="margin-left: 81%; width:20%" type="submit" name="pdf" value="Ralatorio em pdf" class="btnSubmit largura45 left"></td>
                </tr>
                </table>
                </form>

            <?php	
				}	
			}
			?>
        
        
        
        
  	</div>
    <?php include("rodape.php") ?>
  </div>      
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
$('.tlg1').hide();
$('.tlg2').hide();
$('.tlg3').hide();</script>        
</body>
</html>