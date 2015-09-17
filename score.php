<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();

if($_SESSION['usuario'] == ""){ header("Location: index.php"); };
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$idUsuario = $usuarioLogado['idUsuario'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/jquery.raty.css">
<link rel="stylesheet" type="text/css" href="css/estilos-bibliotecas.css">
</head>

<body onLoad="verificaLogin()">
<div class="msgAlerta"></div>
<div class="centro">
	<div class="clear bgBranco secaoInterna todosMateriais">
    	<h2>Avaliação de Produto<br><span>Por favor responda a pesquisa de qualidade de suas compras realizadas.</span></h2>
        <?php
       $query = odbc_exec($conexao, "select * from ComprasDMTRIX where status_compra = 'finalizado' and idUsuario = '$idUsuario'");
	   
	   					$id1 = 0;
						$id2 = 2;
						$id3 = 3;
						$id4 = 4;
						$id5 = 5;
		while($compras = odbc_fetch_array($query)){
		$idCompra = $compras['idCompra'];
		$avaliado = $compras['avaliado'];
		
		if($avaliado == 'nao'){
		
		$buscaPedidos = odbc_exec($conexao, "select * from pedidoDMTRIX p inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial where p.idCompra = '$idCompra'");
		$qtd = odbc_num_rows($buscaPedidos);
		?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <input type="hidden" name="pedidos" value="<?php echo $qtd; ?>">
        <input type="hidden" name="idCompra" value="<?php echo $compras['idCompra']; ?>">
       
        	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

                        <tr class="semBorda">
                        <?php while($rsBuscaPedido = odbc_fetch_array($buscaPedidos)) { ?>
                        	<td>Nome: <?php echo $rsBuscaPedido['material'];?><div class="campo"><input type="text" name="observacao[]" class="left" placeholder="Digite em poucas palavras sua opinião sobre os produtos recebidos na Compra" autocomplete="off"  data-mask-reverse="true"></div></td>
                            <input type="hidden" name="idPedido[]" value="<?php echo $rsBuscaPedido['idPedido']; ?>">
                             <input type="hidden" name="idMaterial[]" value="<?php echo $rsBuscaPedido['idMaterial'];?>">
                           
                        </tr>
                        </table>
                        
                        
                        
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                        	<td>Como você avalia este produto?<p><div>
  							<div class="estrela<?php echo $id1; ?>"></div>
                            <div class="campo largura25"><select  id="<?php echo $id1; ?>" name="selector[]">
  							<option value="">--</option>
  							<option value="1">Muito Ruim</option>
  							<option value="2">Ruim</option>
  							<option value="3">Regular</option>
  							<option value="4">Bom</option>
  							<option value="5">Excelente</option>
							</select></div>
  
  </div></p></td>
                        </tr>
                        	
                        
                         <?php 
						 $id1+=1;
						 
						  };// preencher os campos na tela
							}; // if para verificar se ja foi avaliado
						}; //primeiro while no topo	?>
                        
                        	<tr>
                            	<td align="right"><input type="submit" name="avaliar" value="Finalizar" class="largura30 btnSubmit"></td>
                            </tr>
                          
                        </table>
        	</form>
        
        </div>
    </div>
    
    <?php 
	
	if(isset($_POST['avaliar']))
	{

		
		$avaliacao = $_POST['observacao'];
		$idUsuario = $usuarioLogado['idUsuario'];
		$idPedido = $_POST['idPedido'];
		$idMaterial = $_POST['idMaterial'];
		$idCompra = $_POST['idCompra'];
		
		
		$valor = $_POST['selector'];
		

					
				 avaliacao($avaliacao, $idUsuario, $idPedido, $idMaterial, $valor, $idCompra);

	}
	?>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/jquery.raty.js"></script>
<script type="text/javascript">

	qtd = jQuery("input[name='pedidos']").val();
	
	
for(i=0;i < qtd;i++){

	$('.estrela'+i+'').raty({
	  target: '#'+i+'',
	  targetKeep: true
	  
	});

}

</script>
</body>
</body>
</html>