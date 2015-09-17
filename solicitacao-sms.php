<?php
include("config.php");
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
<div class="msgAlerta"></div>
<?php include("topo.php");
include("funcoes.php"); ?>

<div class="centro">

	<div class="clear bgBranco secaoInterna solicitacao-sms">
    <div id="tab" style=" border:0px; background:#FFF">
    	<h2>Solicitação de Envio de SMS<br><span>O que você deseja dizer aos clientes?</span></h2>
        
        <ul style="background:#FFF; border: 0px"> 
            	<li><a href="#aba-1">Lojas</a></li>
            	<li><a href="#aba-2">Rede de lojas</a></li>  
            </ul>

			<div id="aba-1" style="background:#FFF ">
      <form id="rede" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="left largura45">
        	  
        	
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td colspan="2">Unidade ou Loja</td>
                        </tr>
                    </thead>
                    <tbody class="listagemUnidadesLojas">
                        
                    <tr>
                     <td> <div class="campo"><select name="loja[]">
                        <option value="0">Selecione a Loja</option>
                       <?php
					   $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$idUsuario = $usuarioLogado['idUsuario'];
			$nome = $usuarioLogado['nome'];
			$nivel = $usuarioLogado['nivel'];
                    if($nivel == 3){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.supervisor = '$idUsuario' OR
                        dbo.usuariosDMTRIX.idUsuario = '$idUsuario'
                        ORDER BY numeroLoja ASC");
                    }elseif($nivel == 4){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX INNER JOIN dbo.usuariosDMTRIX
                        ON dbo.lojasDMTRIX.responsavel = dbo.usuariosDMTRIX.idUsuario WHERE dbo.usuariosDMTRIX.idUsuario = '$idUsuario'
                        ORDER BY numeroLoja ASC");
                    }elseif($nivel == 5){
                        $buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX");
                    }else
					{
						$buscaTodasLojas = odbc_exec($conexao, "SELECT DISTINCT * FROM dbo.lojasDMTRIX");
					};
                    while($rsBuscaTodasLojas = odbc_fetch_array($buscaTodasLojas)){
						?>
                            <option value="<?php echo $rsBuscaTodasLojas['idLoja'];?>"><?php echo $rsBuscaTodasLojas['numeroLoja']. " - ".$rsBuscaTodasLojas['nomeLoja'];?></option>
                            <?php } 
							
							?>
                            </select>
                        	</div>
                            </td>
                            <td valign="bottom"><input type="button" name="addCampoLojas" value="Adicionar Outra" class="largura100 left btnAzul"></td>
                            </tr>
                        
                    
                          
                        <tr>
                    </tbody>

                </table>
            </div>
    
            <div class="right largura45" style="margin-right:20px;">
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td colspan="3">Sobre o SMS</td>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                            <td colspan="3"><div class="campo"><select name="status">
                            <option value="Status dos Clientes">Status dos Clientes</option>
                            <option value="Ativos">Ativos</option>
                            <option value="Inativos">Inativos</option>
                            <option value="Nunca Compraram">Nunca Compraram</option>
                            <option value="Ativos e Inativos">Ativos e Inativos</option>
                            <option value="Ativos e nunca compraram">Ativos e nunca compraram</option>
                            <option value="Inativos e nunca compraram">Inativos e nunca compraram</option>
                            <option value="Todas as opções">Todas as opções</option>
                            </select></div></td>
                        </tr>
                        <tr>
                            <td colspan="3"><div class="campo"><input type="text" name="dataEnvio" class="datepicker" placeholder="Data de Envio"></div></td>
                        </tr>
                        <tr>
                            <td colspan="3"><div class="campo" style="height:100px;"><textarea name="mensagemSMS" placeholder="Digite aqui sua mensagem" required onKeyUp="contaCaracteres()" maxlength="147" style="height:100px; line-height:25px;"></textarea></div></td>
                        </tr>
                        <tr>
                            <td><input type="button" name="inserirValor" value="Nome da Loja" alt="[____LOJA_____]" class="largura100 right btnAzul"></td>
                            <td><input type="button" name="inserirValor" value="Nome do Cliente" alt="[_CLIENTE__]" class="largura100 right btnAzul"></td>
                            <td><input type="button" name="inserirValor" value="Cód. Promo." alt="[ COD.]" class="largura100 right btnAzul"></td>
                            <input type="hidden" name="codigoSolicitacao" value="<?php echo $idUsuario.md5($nome.time());?>" />
                        </tr>
                        <tr>
                        	<td align="left" class="infoCaracteres">Você ainda pode digitar <strong>147</strong> caracteres</td>
                            <td colspan="2"><input type="submit" name="sms" value="Enviar Pedido" class="largura100 right btnSubmit"></td>
                        </tr>
                    </tbody>
                </table>
                  
            </div>
       </form>
       		</div> <!-- fechar abas -->
            
            <div id="aba-2" style="background:#FFF">
            <form id="rede" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="left largura45">
        	  
        	
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td colspan="2">Unidade ou Loja</td>
                        </tr>
                    </thead>
                    <tbody class="listagemUnidadesLojas2">
                        
                    <tr>
                     <td> <div class="campo"><select name="rede[]">
                        <option value="0">Selecione a rede</option>
                       <?php
					   $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$idUsuario = $usuarioLogado['idUsuario'];
			$nome = $usuarioLogado['nome'];
			$nivel = $usuarioLogado['nivel'];
                    
						$buscaTodasLojas = odbc_exec($conexao, "SELECT distinct rede FROM dbo.lojasDMTRIX");
					
                    while($rsBuscaTodasLojas = odbc_fetch_array($buscaTodasLojas)){
						?>
                            <option value="<?php echo $rsBuscaTodasLojas['rede'];?>"><?php echo utf8_encode($rsBuscaTodasLojas['rede']);?></option>
                            <?php } 
							
							?>
                            </select>
                        	</div>
                            </td>
                            <td valign="bottom"><input type="button" name="addCampoLojas2" value="Adicionar Outra" class="largura100 left btnAzul"></td>
                            </tr>
                        
                    
                          
                        <tr>
                    </tbody>

                </table>
            </div>
    
            <div class="right largura45" style="margin-right:20px;">
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td colspan="3">Sobre o SMS</td>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                            <td colspan="3"><div class="campo"><select name="status">
                            <option value="Status dos Clientes">Status dos Clientes</option>
                            <option value="Ativos">Ativos</option>
                            <option value="Inativos">Inativos</option>
                            <option value="Nunca Compraram">Nunca Compraram</option>
                            <option value="Ativos e Inativos">Ativos e Inativos</option>
                            <option value="Ativos e nunca compraram">Ativos e nunca compraram</option>
                            <option value="Inativos e nunca compraram">Inativos e nunca compraram</option>
                            <option value="Todas as opções">Todas as opções</option>
                            </select></div></td>
                        </tr>
                        <tr>
                            <td colspan="3"><div class="campo"><input type="text" name="dataEnvio" class="datepicker" placeholder="Data de Envio"></div></td>
                        </tr>
                        <tr>
                            <td colspan="3"><div class="campo" style="height:100px;"><textarea name="mensagemSMS" placeholder="Digite aqui sua mensagem" required onKeyUp="contaCaracteres()" maxlength="147" style="height:100px; line-height:25px;"></textarea></div></td>
                        </tr>
                        <tr>
                            <td><input type="button" name="inserirValor" value="Nome da Loja" alt="[____LOJA_____]" class="largura100 right btnAzul"></td>
                            <td><input type="button" name="inserirValor" value="Nome do Cliente" alt="[_CLIENTE__]" class="largura100 right btnAzul"></td>
                            <td><input type="button" name="inserirValor" value="Cód. Promo." alt="[ COD.]" class="largura100 right btnAzul"></td>
                            <input type="hidden" name="codigoSolicitacao" value="<?php echo $idUsuario.md5($nome.time());?>" />
                        </tr>
                        <tr>
                        	<td align="left" class="infoCaracteres">Você ainda pode digitar <strong>147</strong> caracteres</td>
                            <td colspan="2"><input type="submit" name="smsRede" value="Enviar Pedido" class="largura100 right btnSubmit"></td>
                        </tr>
                    </tbody>
                </table>
                  
            </div>
       </form>
            
            
            </div>
            
            
            </div> <!-- fechar tab -->
    </div>
   
    <?php include("rodape.php");
	if(isset($_POST['sms']))
	{
		
		$idUsuario = $usuarioLogado['idUsuario'];
		$codigoSolicitacao = $_POST['codigoSolicitacao'];
		$statusCliente = $_POST['status'];
		$dataEnvio = $_POST['dataEnvio'];
		$texto = $_POST['mensagemSMS'];

		//echo "<script>alert('$idUsuario, $statusCliente, $texto');</script>";

        if($statusCliente != 'Status dos Clientes')
        {
            EmailSMS($idUsuario, $codigoSolicitacao,$statusCliente, $dataEnvio, $texto);

        }else{echo "<script>alert('Selecione os clientes que receberão o SMS');</script>";}


	}else if(isset($_POST['smsRede']))
	{
		
		$idUsuario = $usuarioLogado['idUsuario'];
		$codigoSolicitacao = $_POST['codigoSolicitacao'];
		$statusCliente = $_POST['status'];
		$dataEnvio = $_POST['dataEnvio'];
		$texto = $_POST['mensagemSMS'];

    if($statusCliente != 'Status dos Clientes') {

        EmailSMSRede($idUsuario, $codigoSolicitacao, $statusCliente, $dataEnvio, $texto);
        // echo "<script>alert('$idUsuario, $statusCliente, $texto');</script>";

    }else{echo "<script>alert('Selecione os clientes que receberão o SMS');</script>";}
		
	}
	
	
	 ?>
</div>


<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">

$( "#tab" ).tabs({
  show: { effect: "blind", duration: 800 }
});

</script>
</body>
</html>