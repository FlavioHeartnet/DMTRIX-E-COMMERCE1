<?php
include("analyticstracking.php");
include("funcoes.php");
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
    <link rel="stylesheet" type="text/css" href="css/semantic.min.css">
</head>

<body onLoad="verificaLogin()">
<div class="msgAlerta"></div>
<div class="popup">
	<div class="clear bgBranco secaoInterna">
    	<h2>Como o produto esta avaliado<br><span>Aqui você ve como o produto esta avaliado pelos usuarios.</span></h2>
        <?php 
		
		$nomeMaterial = $_POST['nome'];
		$idMaterial = $_POST['idMaterial'];
		$Valor =$_POST['valor'];
		
		$buscaaprovacao1 = odbc_exec($conexao, "SELECT count(*) as total, avaliacao FROM dbo.avaliacaoDMTRIX where idMaterial = '$idMaterial'  GROUP BY avaliacao ORDER BY total desc ");
		$aux  = 0;
		$buscaScore = odbc_fetch_array($buscaaprovacao1);
		
		
		$score = $buscaScore['avaliacao'];
		
		
		$buscaMaterial = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX  where idMaterial = '$idMaterial' "));
		
		 ?>
         <input type="hidden" name="score" value="<?php echo $score ?>">
         <div align="center" class="largura30">
                <div class="clear imagemTodosMateriais"><img src="../dmtrade/img/brindes/<?php echo $buscaMaterial['foto']; ?>"></div>
                <div  class="clear">
                    <h3><?php echo $nomeMaterial ?></h3>
                    <p>R$<?php echo $buscaMaterial['valor']; ?></p>
                    <p>Descrição: Produto usado em diversas coisas.</p>
                    
                    <div class="estrela"></div>
                    
                  
                 </div>
                 </div>

                 
          <h2>Opiniões</h2>
          <h2><span>Veja as opiniões sobre estes produtos</span></h2>
          <?php
		  
		  
		  $buscaaprovacao = odbc_exec($conexao, "SELECT * FROM dbo.avaliacaoDMTRIX a inner join dbo.usuariosDMTRIX u on u.idUsuario = a.idUsuario  where idMaterial = '$idMaterial'");
		  $count = odbc_num_rows($buscaaprovacao); 
		  if( $count != 0){
		  
		  while ($rsbuscaaprovacao = odbc_fetch_array($buscaaprovacao)){
			  
			  
			  
		   ?>
           
          
           <table class="ui table" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
           <tr>
           		<td><strong><?php echo $rsbuscaaprovacao['nome']." ".$rsbuscaaprovacao['sobrenome'] ?></strong> </td>
                
           </tr>
           	<tr>
            	<td><p>Opinião: <strong><?php echo $rsbuscaaprovacao['observacao'];?></strong></p></td>
            </tr>
            </table>
          
         <?php
		  }
		  		}else{
			 
			 
			 ?>
             
             	   <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
           <tr>
           		<td>Não ha avaliações para este produto!</td>
                
           </tr>
            </table>
             
             
             <?php
			 
			 }
		  ?>
        
       
       
		</div>
    </div>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/semantic.js"></script>
<script type="text/javascript" src="js/jquery.raty.js"></script>
<script type="text/javascript">
	$('.estrela').raty({
		
		score: jQuery("input[name='score']").val(),
		readOnly: true
 
	});

</script>

           
			
</body>
</body>
</html>