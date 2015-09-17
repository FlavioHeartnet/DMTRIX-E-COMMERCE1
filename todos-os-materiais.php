<?php
include_once("analyticstracking.php");
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
<!--<link rel="stylesheet" type="text/css" href="css/colorbox.css">-->
</head>

<body onLoad="verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secaoInterna todosMateriais">
    	<h2>Todos os Materiais<br><span>Ao encontrar o material que procura, clique em Selecionar, preencha os campos e clique em Adicionar.</span></h2>
        
        
			<?php
			if(isset($_POST['buscar'])){
				
				$idMaterial = $_POST['busca'];
				$buscaMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX where idMaterial = '$idMaterial' ");
				$count = odbc_num_rows($buscaMaterial);
				
			
			}else if(isset($_POST['categoria']))
			{
				
				$categoria = $_POST['categoria'];
				$buscaCategoria = odbc_fetch_array(odbc_exec($conexao, "select * from categoriaDMTRIX where idCategoria = '$categoria'"));
				$idCategoria = $buscaCategoria['idCategoria'];
				$buscaMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX where categoria = '$idCategoria'");
				
				
			}
			
			else{
            	$buscaMaterial = odbc_exec($conexao, "SELECT * FROM dbo.materiaisDMTRIX order by materiaisDMTRIX.material ASC");
				 }
			
			
            while($rsBuscaMaterial = odbc_fetch_array($buscaMaterial)){
        	?>
             		
        			<form target="_blank" action="score-produto.php" method="post">
                    
                    <input type="hidden" name="valor" value="<?php echo $rsBuscaMaterial['valor']; ?>">
                    <input type="hidden" name="nome" value="<?php echo $rsBuscaMaterial['material']; ?>">
                    <input type="hidden" name="idMaterial" value="<?php echo $rsBuscaMaterial['idMaterial']; ?>">
                    
                    <input style="display:compact" class="botaoexcluir" type="submit" name="score" value="click aqui e veja a avaliação deste produto">
                    
                    
                    </form>
                   
         
         
       		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="largura30 left boxMaterial">
                <div class="clear imagemTodosMateriais"><img src="../dmtrade/img/brindes/<?php echo $rsBuscaMaterial['foto'];?>"></div>
                <div class="clear">
               
                    <h3><?php echo $rsBuscaMaterial['material']; ?></h3>
                    <p>R$<?php echo $rsBuscaMaterial['valor']; ?>m²</p>
                    

                    <input type="hidden" name="valor" value="<?php echo $rsBuscaMaterial['valor']; ?>" >
                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="display:none;">
                        <tr class="semBorda">
                        
                            <td><div class="campo"><input type="text" name="largura" class="left" placeholder="Largura cm" autocomplete="off" data-mask="000000" data-mask-reverse="true" data-idMaterial="<?php echo $rsBuscaMaterial['idMaterial']; ?>"></div></td>
                            <td><div class="campo"><input type="text" name="altura" class="left" placeholder="Altura cm" autocomplete="off" data-mask="000000" data-mask-reverse="true" data-idMaterial="<?php echo $rsBuscaMaterial['idMaterial']; ?>"></div></td>
                        </tr>
                        <input type="hidden" name="idmaterial" class="left" value="<?php echo $rsBuscaMaterial['idMaterial']; ?>">
                 
                        <tr class="semBorda">
                            <td><div class="campo"><input type="text" name="quantidade" class="left" placeholder="Quantidade" autocomplete="off" data-mask="000000" data-mask-reverse="true" data-idMaterial="<?php echo $rsBuscaMaterial['idMaterial']; ?>"></div></td>
                            
                        </tr>
                        <tr class="semBorda">
     
                        </tr>
                        <tr>
                            <td colspan="2"><div class="campo" style="height:80px;"><textarea  name="observacao" class="left" placeholder="Observações" onKeyDown="textCounter(this.form.observacao,this.form.remLen,500);" onKeyUp="textCounter(this.form.message,this.form.remLen,500);" style="line-height:25px; height:80px;"></textarea></div></td>                    
                        </tr>
                    </table>
                     
                    <input type="submit" name="selecionarMaterial" value="Selecionar" class="largura50 btnSubmit abreBox" data-idMaterial="<?php echo $rsBuscaMaterial['idMaterial']; ?>">
                    
               
                </div>
            </div>
       </form>
            <?php }; ?>
                
            
    </div>
  
	<?php
				 
				 
	$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'")); 
	
	if(isset($_POST['selecionarMaterial'])){
		$largura = 		$_POST['largura'];
		$altura = 		$_POST['altura'];
		$quantidade = 	$_POST['quantidade'];
		$observacao = 	$_POST['observacao'];
		$idMaterial =	$_POST['idmaterial'];
		$datapedido =  	date("m.d.y, g:i a");
		$valor = $_POST['valor'];
		$usuario = $usuarioLogado['idUsuario'];
		
		$buscaPedido =odbc_exec($conexao, "SELECT * FROM dbo.PedidoDMTRIX where idUsuario = '$usuario' and status_pedido = 1");
		
			$rows = odbc_num_rows($buscaPedido);
			$buscaPedido= odbc_fetch_array($buscaPedido);
			
					if($rows != 0){
           
						if($buscaPedido['custeio'] != "" and $buscaPedido['formaPagamento'] != "")
						{
							echo "<script>alert('Já existe uma solicitação em andamento, para pedir novos produtos finalize o pedido atual');</script>";
							echo "<script>location.href='briefing.php';</script>";
							
						}else
						{
							AddCarrinho($largura, $altura, $quantidade, $observacao, $idMaterial, $datapedido, $usuarioLogado['nome'],$usuarioLogado['idUsuario'], $valor);
						}
					}else{
				
						AddCarrinho($largura, $altura, $quantidade, $observacao, $idMaterial, $datapedido, $usuarioLogado['nome'],$usuarioLogado['idUsuario'], $valor);
					}
		
	};
	
	
	include("rodape.php"); ?>
    </div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/fliplightbox.min.js"></script>
<script type="text/javascript">$('body').flipLightBox()</script>
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
            <script type="text/javascript">
			$('.score').click(function(){
	
			$.colorbox({href:"score-produto.php", width:"50%", height:"85%"});
	
			});
			
			
			function textCounter(field, countfield, maxlimit) {
			if (field.value.length > maxlimit)
			field.value = field.value.substring(0, maxlimit);
			else 
			countfield.value = maxlimit - field.value.length;
			}
			
</script>
</body>
</html>