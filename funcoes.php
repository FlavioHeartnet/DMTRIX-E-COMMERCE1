<?php
include_once("config.php");
// Função para enviar e-mails
function envioEmail($emailDestinatario, $nomeDestinatario, $assunto, $mensagem){
	require("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 1;
	$mail->From = "faqdmtrade@dmcard.com.br";
	$mail->FromName = "E-commerce DMTrix";
	$mail->IsHTML(true);
	$mail->AddAddress($emailDestinatario, $nomeDestinatario);
	$mail->AddAddress($emailDestinatario);
	$mail->Subject  = $assunto;
	
	$corpoEmail = "<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
	<tr>
    	<td><img style='display:block' src='http://dmcard.com.br/dmtrix/img/demetrios2.png' width='80%'  alt=''>
        
       
        
        </td>
   
   
        <td><strong><p style = 'font-size:36px; font-family:Calibri; color:#0054a6'>AVISO DMTRIX</p></strong><p style='font-family:Calibri; font-size:20px; color:#0054a6'>".$mensagem."</p></td>
       
    </tr>


</table>";

	
	$corpoEmail .= "</td></tr></tbody></table>";
	
	$mail->Body = $corpoEmail;
	$enviado = $mail->Send();
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
	if($enviado == true){

		return true;
		
	}else{
		$error = $mail->ErrorInfo;
		$issue = error_reporting(E_STRICT);
		echo "<script>alert('falha: $error $issue');</script>";
		return false;
		
	};
};

function envioEmailCompra($emailDestinatario, $nomeDestinatario, $assunto, $mensagem, $Cc, $nome, $Cc2)
{
	
	
	require("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 1;
	$mail->From = "faqdmtrade@dmcard.com.br";
	$mail->FromName = "E-commerce DMTrix";
	$mail->IsHTML(true);
	$mail->AddAddress($emailDestinatario, $nomeDestinatario);
	$mail->AddAddress($emailDestinatario);
	$mail->AddCC($Cc, $nome);
	$mail->AddCC($Cc);
	$mail->AddCC($Cc2);
	$mail->AddCC($Cc2);
	$mail->Subject  = $assunto;
	
	$corpoEmail = "<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0'>
	<tr>
    	<td><img style='display:block' src='http://dmcard.com.br/dmtrix/img/demetrios2.png' width='80%'  alt=''>
        
       
        
        </td>
   
   
        <td><strong><p style = 'font-size:36px; font-family:Calibri; color:#0054a6'>PEDIDO DE COMPRA DMTRIX</p></strong><p style='font-family:Calibri; font-size:20px; color:#0054a6'>".$mensagem."</p></td>
       
    </tr>


</table>";

	
	$corpoEmail .= "</td></tr></tbody></table>";
	$mail->Body = $corpoEmail;
	$enviado = $mail->Send();
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();
	if($enviado == true){
		echo "<script>alert('sucesso');</script>";
		return true;
		
	}else{
		$error = $mail->ErrorInfo;
		$issue = error_reporting(E_STRICT);
		echo "<script>alert('falha: $error $issue');</script>";
		return false;
		
	};
	
	
}

//adicionar tarefa
function addTarefa ($idUsuario, $idPedido, $UsuarioLogado)
{

		if($idUsuario != ""){

            $sql = odbc_exec($GLOBALS['conexao'],"select * from tarefasDMTRIX where idPedido = '$idPedido'");
            $row = odbc_num_rows($sql);
            if($row == 0) {
                $query = odbc_exec($GLOBALS['conexao'], "insert into [MARKETING].[dbo].[tarefasDMTRIX] (idUsuario, idPedido, ativo) values ('$idUsuario','$idPedido', 'nao')");
                $query1 = odbc_exec($GLOBALS['conexao'], "update [MARKETING].[dbo].[pedidoDMTRIX] set status_pedido = 5 where idPedido = '$idPedido'");

            }else{

                echo "<script>alert('Tarefa ja foi delegada, caso aja problema falar com administrador.'); history.back(-1); </script>";


            }
		}


	
	if($query == true and $query1==true)
	{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $UsuarioLogado delegou uma tarefa')");
		return true;
		 
	}else
	{

		return false;
	}
	
}
//atualizar responsavel pela tarefa
function atualizaTarefa($idUsuario, $idPedido, $UsuarioLogado)
{

	$query = odbc_exec($GLOBALS['conexao'],"update  [MARKETING].[dbo].[tarefasDMTRIX] set idUsuario = '$idUsuario', idPedido = '$idPedido' where idPedido = '$idPedido'") ;
	$query1 = odbc_exec($GLOBALS['conexao'],"update [MARKETING].[dbo].[pedidoDMTRIX] set status_pedido = 5 where idPedido = '$idPedido'");

	
	
	if($query == true and $query1== true)
	{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $UsuarioLogado Re-delegou uma tarefa')");

		return "<div class='step'><i class='checkmark icon'></i></div>";
		 
	}else
	{

		return "<div class='step'><i class='remove icon'></i></div>";
	}
	
}
function Brindes($quantidade, $motivo, $idBrinde, $nome, $valor, $idUsuario)
{
	
	$dataSolicitacao = date("d/m/Y H:i:s");
	$query = odbc_exec($GLOBALS['conexao'],  "insert into [marketing].[dbo].[PedidoBrindesDMTRIX] (idBrinde,NomeBrinde,quantidade,motivo,idUsuario,ValorBrinde,dataCompra, statusBrindes) values('$idBrinde','$nome','$quantidade','$motivo','$idUsuario','$valor','$dataSolicitacao',1)"); 
	if($query == true)
	{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario pediu um brinde DMTRIX')");
		echo "<script>alert('Pedido realizada com sucesso, consulte o carrinho no Box abaixo para continuar a compra'); location.href='brindes.php';</script>";
		return true;
		 
	}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar comprar o item, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	}

}

function editBrinde($quantidade, $motivo, $valor, $valorTotal, $nome, $idUsuario, $idPedido)
{
	$query = odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[PedidoBrindesDMTRIX] set quantidade = '$quantidade', motivo = '$motivo', ValorBrinde = '$valor', valorTotal = '$valorTotal' where idPedido = '$idPedido'");
	if($query == true)
	{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $nome de codigo: $idUsuario Editou um brinde DMTRIX')");
		echo "<script>alert('Brinde editado com sucesso..'); location.href='comprasBrindes.php';</script>";
		return true;
		 
	}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar editar o Brinde, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	}
	
	
}

function deletaBrinde($idUsuario, $idPedido, $nome )
{
	
	
	
	$query = odbc_exec($GLOBALS['conexao'],"delete from [marketing].[dbo].[PedidoBrindesDMTRIX] where idPedido = '$idPedido' and statusBrindes = 1");
	if($query == true)
	{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario deletou o pedido de brinde: $idPedido : $nome DMTRIX')");
		echo "<script>alert('Deletado com sucesso o brinde.'); location.href='brindes.php';</script>";
		return true;
		 
	}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar deletar, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	}
	
	
}

function AddCompraBrinde($valorTotal, $idUsuario, $nome, $budget, $quantidade, $pedido, $estoque)
{
	$dataSolicitacao = date("d/m/Y H:i:s");
	$query = odbc_exec($GLOBALS['conexao'], "insert into [marketing].[dbo].[ComprasBrindesDMTRIX] (dataCompra, ValorTotal, idUsuario, status_compra) values('$dataSolicitacao','$valorTotal','$idUsuario',1)");
	
	if($query == true) {
        $buscaCompra = odbc_exec($GLOBALS['conexao'], "select idCompra from [marketing].[dbo].[ComprasBrindesDMTRIX] where idUsuario = '$idUsuario' and status_compra = 1");
        $rsbuscaCompra = odbc_fetch_array($buscaCompra);
        $Compra = $rsbuscaCompra['idCompra'];

        $query = odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[PedidoBrindesDMTRIX] set idCompra = '$Compra'  where idUsuario = '$idUsuario' and statusBrindes = 1");

        //subtrair do budget e o estoque


        $budgetAtualizado = $budget - $valorTotal;
        $budgetAtualizado= number_format($budgetAtualizado, 2, '.', '');
        $idBrinde = $_POST['brinde'];
        for ($i = 0; $i < count($pedido); $i++)
        {
            if ($estoque[$i] >= $quantidade[$i])
            {

            $quant = $quantidade[$i];
            $estoqueAtual = $estoque[$i] - $quantidade[$i];
                $idPedido = $pedido[$i];

                $tipoMov = "Compra de Brinde";

                $controleEstoque = MovimentacaoEstoque($tipoMov, $idPedido, $quantidade[$i], $estoqueAtual, $idUsuario);

            odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[brindesDMTRIX] set estoque = '$estoqueAtual' where  idBrinde = '$idBrinde[$i]'");


        }else{echo "<script>alert('Pedido é maior que o estoque por favor altere a quantidade'); </script>"; return false;}

        }

        odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[usuariosDMTRIX] set budgetBrindes = '$budgetAtualizado' where idUsuario = '$idUsuario'");



        $RsUsuario = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from usuariosDMTRIX where idUsuario = '$idUsuario'"));
        $nome = $RsUsuario['nome'] . " " . $RsUsuario['sobrenome'];


        if ($query == true) {
            $query = odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[ComprasBrindesDMTRIX] set status_compra = 2 where idCompra = '$Compra'");
            $query = odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[PedidoBrindesDMTRIX] set statusBrindes = 2 , valorTotal = '$valorTotal', dataCompra = '$dataSolicitacao'  where idUsuario = '$idUsuario' and statusBrindes = 1");

        } else {
            echo "<script>alert('Erro na atualização do pedido.'); </script>";
            return false;
        }

        $historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuario: $nome realizou uma compra de brinde, seu saldo anterior era de: $budget e o saldo atual: $budgetAtualizado')");
        //parte de envio de email, apos estar tudo ok

        if ($historico == true) {

        $query2 = odbc_exec($GLOBALS['conexao'], "select * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on p.idBrinde = b.idBrinde where p.idCompra = '$Compra'");


        $mensagem = "O Usuario " . $nome . " realizou a compra de brinde de numero " . $Compra . " no DMtrix, os itens pedidos Foram: </br> ";
        while ($rsbuscaPedido = odbc_fetch_array($query2)) {

            $mensagem .= "- " . $rsbuscaPedido['NomeBrinde'] . " - Quantidade: " . $rsbuscaPedido['quantidade'] . "</br>";
        }

        $emailDestinatario = "maria.lidia@dmcard.com.br";
        $nomeDestinatario = "Maria";
        $assunto = "Pedido de compra de brinde - DMTRIX";
        $Cc = "lucas.santos@dmcard.com.br";
            $Cc2 = "lucas.santos@dmcard.com.br";

            envioEmailCompra($emailDestinatario, $nomeDestinatario, $assunto, $mensagem, $Cc, $nome, $Cc2);

        echo "<script>alert('Compra realizada!'); location.href='compraBrinde-finalizada.php';</script>";
        return true;
        }else{

            echo "<script>alert('Ocorreu uma indisponibilidade ao tentar salvar o historico.'); </script>";
            return false;

        }


	}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar finalizar sua compra, tente novamente mais tarde, ou contate o administrador.'); </script>";
		return false;
	}

	
	
}

function TrocaSenha($senha, $idUsuario, $nome)
{
	$query = odbc_exec($GLOBALS['conexao'], "update [MARKETING].[dbo].[usuariosDMTRIX] set senha = '$senha' where idUsuario = '$idUsuario'");
		if($query == true)
		{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $nome de codigo: $idUsuario trocou sua senha no DMTRIX')");
		
		$assunto = "Alteração de senha no DMTRIX.";
		//$menssagem =  "Caro(a) ".$nome." você alterou sua senha no E-commerce DMTRIX, sua nova senha é: ".$senha;
		//envioEmail($email, $nome, $assunto, $menssagem);
		echo "<script>alert('Senha alterada com sucesso, Um email foi enviado com sua nova senha'); location.href='index.php';</script>"; 
		return true;
		}else
		{
		echo "<script>alert('Ocorreu um erro ao tentar Trocar sua senha, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
		}
		
		
}

function EsqueciSenha($idUsuario, $email)
{
	$query = odbc_exec($GLOBALS['conexao'], "select * from [MARKETING].[dbo].[usuariosDMTRIX] where idUsuario = '$idUsuario'");
	if($query == true){
	$query = odbc_fetch_array($query);
	$email = $query['email'];
	$nomeDestinatario = $query['nome']." ".$query['sobrenome'];
	$novaSenha = geraSenha();
	$site = "<a href='http://www.dmcard.com.br/dmtrix/trocar-senha.php'>Trocar senha</a>";
	$assunto = "Solicitação de alteração de senha DMTRIX.";
	$menssagem =  "Caro(a) ".$query['nome']." você solicitou a troca de sua senha no E-commerce DMTRIX, sua nova senha é: <strong>".$novaSenha."</strong> acesse o link para alterar: ".$site;
	envioEmail($email, $nomeDestinatario, $assunto, $menssagem);
	TrocaSenha($novaSenha, $idUsuario, $nomeDestinatario);
	}else{echo "<script>alert('Ocorreu um erro ao buscar, usuario não encontrado');  history.back(-1);</script>";}
}

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
// Caracteres de cada tipo

	$lmin = 'abcdefghijklmnopqrstuvwxyz';

	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	$num = '1234567890';

	$simb = '!@#$%*-';

 

// Variáveis internas

	$retorno = '';

	$caracteres = '';

 

// Agrupamos todos os caracteres que poderão ser utilizados

	$caracteres .= $lmin;

	if ($maiusculas) $caracteres .= $lmai;

	if ($numeros) $caracteres .= $num;

	if ($simbolos) $caracteres .= $simb;

 

// Calculamos o total de caracteres possíveis

		$len = strlen($caracteres);

 

		for ($n = 1; $n <= $tamanho; $n++) {

// Criamos um número aleatório de 1 até $len para pegar um dos caracteres

		$rand = mt_rand(1, $len);

// Concatenamos um dos caracteres na variável $retorno

		$retorno .= $caracteres[$rand-1];

	}

	return $retorno;

}



function EmailSMSRede($idUsuario, $codigoSolicitacao,$statusCliente, $dataEnvio, $texto)
{
	$rede = $_POST['rede'];
		
		
	
		$dataSolicitacao = date("d/m/Y H:i:s");

		for($i = 0; $i < count($rede); $i++){
			$loja = $rede[$i];
			$query = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from lojasDMTRIX where rede = $rede[$i]"));

			
			$cadastraSMS = odbc_exec($GLOBALS['conexao'], "INSERT INTO [marketing].[dbo].[envioSmsDMTRIX](idUsuario, codigoSolicitacao, loja, statusCliente, dataEnvio, texto, dataSolicitacao) 
  VALUES('$idUsuario', '$codigoSolicitacao', '$loja', '$statusCliente', '$dataEnvio', '$texto', '$dataSolicitacao')");
		};
		

			$selectUser = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], " select * from usuariosDMTRIX where idUsuario = '$idUsuario'"));
			$email = $selectUser['email'];
			$nome = $selectUser['nome'];
            $supervisor = $selectUser['supervisor'];

            $rsSupervisor = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], " select * from usuariosDMTRIX where idUsuario = '$supervisor'"));
            $emailSupervisor = $rsSupervisor['email'];

		require("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->From = "faqdmtrade@dmcard.com.br";
		$mail->FromName = "Sistema DMTRIX";
		$mail->IsHTML(true);
		$mail->AddAddress("rafael.carvalho@dmcard.com.br", "Rafael");
		$mail->AddAddress("rafael.carvalho@dmcard.com.br");
		$mail->AddCC($email, $nome);
		$mail->AddCC($email);
        $mail->AddCC($emailSupervisor, $nome);
        $mail->AddCC($emailSupervisor);
		$mail->Subject  = "Envio de SMS - Sistema DMTRIX";
		
		$corpoEmail = "<table width='600px' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#eeeeee'><tr><td><img src='http://dmcard.com.br/dmtrade/img/imgEmail/cabecalho2.jpg' width='600' height='35' alt='Notificação Sistema DMTRIX' /></td></tr><tr><td><p style='font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#afafaf; text-align:center; font-weight:bold;'><br />";
		$corpoEmail .= "Envio de SMS - Sistema DMTRIX";
		$corpoEmail .= "<br /><br /></p></td></tr><tr><td><p style='padding:0 20px; font-family:Arial; font-size:14px; color:#f37021; font-weight:bold;'>";
		$corpoEmail .= "Olá,";
		$corpoEmail .= "<br /><br /></p></td></tr><tr><td><p style='padding:0 20px; font-family:Arial; font-size:14px; color:#2c2d2f; text-align:justify; line-height:18px;'>";
		
		$nomeUsuario = odbc_exec($GLOBALS['conexao'], "  SELECT idUsuario, nome, sobrenome FROM marketing.dbo.usuariosDMTRIX WHERE idUsuario = '$idUsuario'");
		$nomeUsuario = odbc_fetch_array($nomeUsuario);
		$nomeUsuario = $nomeUsuario['nome']." ".$nomeUsuario['sobrenome'];
		
		$corpoEmail .= "O usuário $nomeUsuario solicitou o envio de um SMS para o dia $dataEnvio para os clientes $statusCliente.<br /> O SMS deverá ser enviado para os clientes das redes: <br/>";

		for($i = 0; $i < count($rede); $i++){

			$corpoEmail .= " - ".$rede[$i]."<br />";
		};

		$corpoEmail .= "<br /><br />";
		$corpoEmail .= "O SMS deverá conter o seguinte texto:<br />";
		$corpoEmail .= nl2br($texto);
		
		
		
		$corpoEmail .= "<br /></p></td></tr><tr><td><p style='padding:0 20px; font-family:Arial; font-size:14px; color:#2c2d2f; text-align:right; line-height:18px; font-style:italic'>Sistema DMTRIX<br /><br /></p></td></tr><tr><td><img src='http://dmcard.com.br/dmtrade/img/imgEmail/rodape.jpg' width='600' height='35' alt='Notificação Sistema DMTRIX' /></td></tr></table>";	
		
		$mail->Body = $corpoEmail;
		$enviado = $mail->Send();
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		// Alerta o usuário para ação realizada
		if($enviado == true){
			$dataLog = date("d/m/Y H:i:s"); $cadastraLog = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicoDMTRIX(acao) VALUES('SMS enviado da rede enviado')");
			echo "<script>alert('Pedido enviado com sucesso!'); location.href='solicitacao-sms.php';</script>";
		}else{
            $error = $mail->ErrorInfo;
            $issue = error_reporting(E_STRICT);
            echo "<script>alert('falha: $error $issue');</script>";
			echo "<script>alert('Houve uma falha ao fazer o pedido. Tente novamente mais tarde.'); location.href='home.php';</script>";
		};
	
}

function EmailSMS($idUsuario, $codigoSolicitacao,$statusCliente, $dataEnvio, $texto )
{
		
		$idLoja = $_POST['loja'];
		
		
	
		$dataSolicitacao = date("d/m/Y H:i:s");

		for($i = 0; $i < count($idLoja); $i++){
			$loja = $idLoja[$i];
			echo "<script>alert('$loja este é o valor1);</script>";
			
			
			$cadastraSMS = odbc_exec($GLOBALS['conexao'], "INSERT INTO [marketing].[dbo].[envioSmsDMTRIX](idUsuario, codigoSolicitacao, loja, statusCliente, dataEnvio, texto, dataSolicitacao) 
  VALUES('$idUsuario', '$codigoSolicitacao', '$loja', '$statusCliente', '$dataEnvio', '$texto', '$dataSolicitacao')");
		};
		

			$selectUser = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], " select * from usuariosDMTRIX where idUsuario = '$idUsuario'"));
			$email = $selectUser['email'];
			$nome = $selectUser['nome'];
            $supervisor = $selectUser['supervisor'];

        $rsSupervisor = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], " select * from usuariosDMTRIX where idUsuario = '$supervisor'"));
        $emailSupervisor = $rsSupervisor['email'];
		require("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->From = "faqdmtrade@dmcard.com.br";
		$mail->FromName = "Sistema DMTRIX";
		$mail->IsHTML(true);
		$mail->AddAddress("rafael.carvalho@dmcard.com.br", "Rafael");
		$mail->AddAddress("rafael.carvalho@dmcard.com.br");
		$mail->AddCC($email, $nome);
		$mail->AddCC($email);
        $mail->AddCC($emailSupervisor, $nome);
        $mail->AddCC($emailSupervisor);
		$mail->Subject  = "Envio de SMS - Sistema DMTRIX";
		
		$corpoEmail = "<table width='600px' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#eeeeee'><tr><td><img src='http://dmcard.com.br/dmtrade/img/imgEmail/cabecalho2.jpg' width='600' height='35' alt='Notificação Sistema DMTRIX' /></td></tr><tr><td><p style='font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#afafaf; text-align:center; font-weight:bold;'><br />";
		$corpoEmail .= "Envio de SMS - Sistema DMTRIX";
		$corpoEmail .= "<br /><br /></p></td></tr><tr><td><p style='padding:0 20px; font-family:Arial; font-size:14px; color:#f37021; font-weight:bold;'>";
		$corpoEmail .= "Olá,";
		$corpoEmail .= "<br /><br /></p></td></tr><tr><td><p style='padding:0 20px; font-family:Arial; font-size:14px; color:#2c2d2f; text-align:justify; line-height:18px;'>";
		
		$nomeUsuario = odbc_exec($GLOBALS['conexao'], "  SELECT idUsuario, nome, sobrenome FROM marketing.dbo.usuariosDMTRIX WHERE idUsuario = '$idUsuario'");
		$nomeUsuario = odbc_fetch_array($nomeUsuario);
		$nomeUsuario = $nomeUsuario['nome']." ".$nomeUsuario['sobrenome'];
		
		$corpoEmail .= "O usuário $nomeUsuario solicitou o envio de um SMS para o dia $dataEnvio para os clientes $statusCliente.<br /> O SMS deverá ser enviado para os clientes das lojas: <br/>";

		for($i = 0; $i < count($idLoja); $i++){
			$loja = $idLoja[$i];
			$dadosLoja = odbc_exec($GLOBALS['conexao'], "SELECT * FROM [marketing].[dbo].[lojasDMTRIX] WHERE idLoja = '$loja'");
			$dadosLoja = odbc_fetch_array($dadosLoja);
			$corpoEmail .= $dadosLoja['numeroLoja']." - ".$dadosLoja['nomeLoja']."<br />";
		};

		$corpoEmail .= "<br /><br />";
		$corpoEmail .= "O SMS deverá conter o seguinte texto:<br />";
		$corpoEmail .= nl2br($texto);
		
		
		
		$corpoEmail .= "<br /></p></td></tr><tr><td><p style='padding:0 20px; font-family:Arial; font-size:14px; color:#2c2d2f; text-align:right; line-height:18px; font-style:italic'>Sistema DMTRIX<br /><br /></p></td></tr><tr><td><img src='http://dmcard.com.br/dmtrade/img/imgEmail/rodape.jpg' width='600' height='35' alt='Notificação Sistema DMTRIX' /></td></tr></table>";	
		
		$mail->Body = $corpoEmail;
		$enviado = $mail->Send();
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		// Alerta o usuário para ação realizada
		if($enviado == true){
			$dataLog = date("d/m/Y H:i:s"); $cadastraLog = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('SMS solicitado por $idUsuario')");
			echo "<script>alert('Pedido enviado com sucesso!'); location.href='solicitacao-sms.php';</script>";
		}else{
            $error = $mail->ErrorInfo;
            $issue = error_reporting(E_STRICT);
            echo "<script>alert('falha: $error $issue');</script>";
			echo "<script>alert('Houve uma falha ao fazer o pedido. Tente novamente mais tarde.'); location.href='solicitacao-sms.php';</script>";
		};
}

function SalvarArte($usuario, $arte, $pedido)
{
    echo "<script>alert('Usuario: $usuario , Arte: $arte, pedido: $pedido')</script>";
	$query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set fotoArte = '$arte'  where idPedido = '$pedido'");
	$query2 =  odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from [marketing].[dbo].[PedidoDMTRIX] p inner join MARKETING.dbo.usuariosDMTRIX u on p.idUsuario = u.idUsuario where idPedido = '$pedido'"));
	$nome = $query2['nome']." ".$query2['sobrenome'];
	if($query == true)
	{
	$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $nome de codigo: $usuario Enviou uma arte')");
	//enviar Email para Usuario
	$email = $query2['email'];
	$idMaterial = $query2['idMaterial'];
	
	$material =  odbc_fetch_array(odbc_exec($GLOBALS['conexao']," select * from [marketing].[dbo].materiaisDMTRIX where idMaterial = '$idMaterial'"));
	$material = $material['material'];
	
	$emailDestinatario = utf8_decode($email);
	$nomeDestinatario = utf8_decode($nome);
	//$emailDestinatario = utf8_decode($email);
	//$nomeDestinatario = utf8_decode($nome);
	$assunto = utf8_decode("Arte solicitada da Compra ".$query2['idCompra']);
	$mensagem =  utf8_decode("Caro(a) ".$nome." nossa equipe postou uma arte para a compra que você solicitou. Para visualiza-la basta entrar no E-commerce DMTRIX e ir em Aprovar/Reprovar Artes, o produto é: $material ");
	
	envioEmail($emailDestinatario, $nomeDestinatario, $assunto, $mensagem);
	
		
	
	
		echo "<script> window.close()</script>";
		}else
			{
			echo "<script>alert('Ocorreu um erro ao salvar, é possivel que o Token digitado não exista!'); history.back(-1); </script>";
			return false;
			};
}

function Aprovacoes($status, $idPedido, $idUsuario, $nome,$compra, $motivo, $motivoArte, $valoProduto, $idLoja)
{
    $Compra = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from [marketing].[dbo].[PedidoDMTRIX] where idPedido = '$idPedido'"));
    $idCompra = $Compra['idCompra'];
	$aprovação = "";
	if($status == 3)
	{

        $query2 = odbc_exec($GLOBALS['conexao'], "select * from ControleAprovacoesDMTRIX where idPedido = '$idPedido'");
        $linhas = odbc_num_rows($query2);

        if($linhas == 0) {

            $query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set status_pedido = '3'  where idPedido = '$idPedido'");



            if($query == true)
            {
                $budget = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from [marketing].[dbo].[usuariosDMTRIX] where idUsuario = '$idUsuario'"));

                $responsavel = $budget['supervisor'];
                $budgetAtual = $budget['budgetMerchandising'];

                echo "<script>alert('$budgetAtual , $valoProduto');</script>";

                if($budgetAtual >= $valoProduto){
                    $observacao = "Aprovação de orçamento";
                    $total = $budgetAtual - $valoProduto;
                    odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[usuariosDMTRIX] set budgetMerchandising = '$total'  where idUsuario = '$idUsuario'");
                    odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[usuariosDMTRIX] set budgetMerchandising = '$total'  WHERE idUsuario = '$idUsuario' OR idUsuario = '$responsavel' OR supervisor = '$idUsuario'");
                    odbc_exec($GLOBALS['conexao'],"insert into [marketing].[dbo].[ControleAprovacoesDMTRIX] (idCompra, idPedido,data_aprovado) values ('$idCompra','$idPedido',GETUTCDATE())");//insere no controle de aprovações
                    AddDebitoDMTRIX($valoProduto, $idPedido, 1, $observacao, $responsavel, $budget, $idUsuario, $idLoja);
                }else
                {
                    echo "<script>alert('Valores não atualizados, pois o valor é maior que o budget atual'); location.href='aprovacao-reprovacao.php';</script>";
                    $query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set status_pedido = '9'  where idPedido = '$idPedido'");

                    return false;

                }

                $historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario aprovou o orçamento do pedido $idPedido')");
                echo "<script>alert('Aprovado'); location.href='aprovacao-reprovacao.php'; </script>";


            }else
            {
                echo "<script>alert('Ocorreu ao aprovar, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
                return false;
            };

        }else{

            echo "<script>alert('Este pedido ja foi aprovado!'); history.back(-1); </script>";
            return false;

        }


			$aprovação = "Aprovou o";
	}else if ($status == 4)
	{
		 $query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set status_pedido = '4'  where idPedido = '$idPedido'");
		 $query2 = odbc_exec($GLOBALS['conexao'],"insert into [marketing].[dbo].[ControleReprovacoesDMTRIX] (idCompra,idPedido,data_reprovado,Motivo) values ('$idCompra','$idPedido',GETUTCDATE(),'$motivo')");//insere no comtrole de reprovações
		if($query == true)
		{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario Reprovou o orçamento do pedido $idPedido')");
		echo "<script>alert('Reprovado, será enviado para analise novamente '); location.href='aprovacao-reprovacao.php';</script>";
		}else
			{
			echo "<script>alert('Ocorreu ao aprovar, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
			return false;
			};
			$aprovação = "Reprovou o";
	}else if($status == 6)
	{
		$query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set status_pedido = '6'  where idPedido = '$idPedido'");
		$query2 = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[ControleAprovacoesDMTRIX] set idCompra='$idCompra', idPedido='$idPedido', data_aprovado_arte=GETUTCDATE() where idPedido = '$idPedido'");
		$temporetomado = date("d/m/Y H:i:s");
		$query3 = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[tarefasDMTRIX] set tempoFinal = '$temporetomado' , ativo = 'nao'  where idPedido = '$idPedido'");
		
		if($query == true)
		{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario Aprovou a Arte do pedido $idPedido')");
		echo "<script>alert('Aprovado'); location.href='aprovacao-reprovacao.php';</script>";
		}else
			{
			echo "<script>alert('Ocorreu ao aprovar, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
			return false;
			};
			$aprovação = "Aprovou a arte do";
	}else if($status == 7)
	{
		$query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set status_pedido = '7'  where idPedido = '$idPedido'");
		$query2 = odbc_exec($GLOBALS['conexao'],"insert into [marketing].[dbo].[ControleReprovacoesDMTRIX] (idCompra,idPedido,data_reprovado_arte,MotivoArte) values ('$idCompra','$idPedido',GETUTCDATE(),'$motivoArte')");//insere no comtrole de reprovações
		if($query == true)
		{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario Reprovou a Arte do pedido $idPedido')");
		echo "<script>alert('Reprovado, será enviado para analise novamente'); location.href='aprovacao-reprovacao.php';</script>";
		}else
			{
			echo "<script>alert('Ocorreu ao aprovar, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
			return false;
			};
			$aprovação = "Reprovou a Arte do";
	};
	
	
	$emailDestinatario = utf8_decode("agenciamarketing@dmcard.com.br");
	$nomeDestinatario = utf8_decode("Julia Melo");
	$assunto = utf8_decode("Status de pedido: ".$idPedido);
	$mensagem =  utf8_decode("Usuario: ".$nome." ".$aprovação."  pedido: ".$idPedido." da compra de numero ".$idCompra);
	
	envioEmail($emailDestinatario, $nomeDestinatario, $assunto, $mensagem);
	
};

function producao($idUsuario, $idPedido)
{
	$query = odbc_exec($GLOBALS['conexao'],"update PedidoDMTRIX set status_pedido = 8 where idPedido = '$idPedido'");
	if($query == true)
	{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario pós o pedido: $idPedido em produção com fornecedor ')");
		echo "<script>alert('Atualizado'); location.href='finalizar.php';</script>"; 
		return true;
		}else
	{
		echo "<script>alert('Ocorreu um erro ao mudar o status, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	};
	
}

function AtualizaValor($valor, $idUsuario, $idPedido, $Compra, $Total, $Comprador, $largura,$altura, $quantidade, $observacao){


    $count = count($idPedido);

    for($i = 0; $i < $count ; $i++)
    {
        $sql = odbc_exec($GLOBALS['conexao'], " update PedidoDMTRIX set largura = '$largura[$i]', altura='$altura[$i]', quantidade='$quantidade[$i]', observacao = '$observacao[$i]' where idPedido = '$idPedido[$i]'");
    }


	$budget = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from [marketing].[dbo].[usuariosDMTRIX] where idUsuario = '$Comprador'"));
		
		$responsavel = $budget['supervisor'];
		$budgetAtual = $budget['budgetMerchandising'];
		
		echo "<script>alert('Seu budget: $budgetAtual , $Total este é o total');</script>";

		if($budgetAtual >= $Total){


	
	$count = count($idPedido);
	
	for($i=0; $i < $count; $i++){

        $sql = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from PedidoDMTRIX where idPedido = '$idPedido[$i]'"));

        $status = $sql['status_pedido'];



        if($status == 2 or $status == 4 ) {

            $query = odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[PedidoDMTRIX] set valorProduto = '$valor[$i]',  status_pedido = 9  where idPedido = '$idPedido[$i]'");

        }
		
	}



            $valorCompra = odbc_exec($GLOBALS['conexao'], "select * from PedidoDMTRIX where idCompra = '$Compra'");
            $total = 0;
            while($RSvalorCompra=odbc_fetch_array($valorCompra))
            {

                $produto = $RSvalorCompra['valorProduto'];

                $total += $produto;

                echo "<script>alert('total: $total, produto: $produto');</script>";

            }

            $query2 = odbc_exec($GLOBALS['conexao'], "update [marketing].[dbo].[PedidoDMTRIX] set valorTotal = '$total'  where idCompra = '$Compra'");


	
		}// if de verificação do budget
		else{echo "<script>alert('O budget do Usuario é menor que o valor total da compra, entre em contato com o mesmo para alinha a situação!'); location.href='atualizar-valor-compras.php';</script>";
		return false;}
	
	$query2 = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[ComprasDMTRIX] set valorTotal = '$Total', status_compra = 'aprovacoes'  where idCompra = '$Compra'");

		if($query == true && $query2 == true)
	{
		$Usuario = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from [marketing].[dbo].[ComprasDMTRIX] c inner join dbo.usuariosDMTRIX u on u.idUsuario = c.idUsuario where c.idCompra = '$Compra'"));
		$email = $Usuario['email'];
		$nome = $Usuario['nome']." ".$Usuario['sobrenome'];
        $supervisor= $Usuario['supervisor'];
            $sql = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from usuariosDMTRIX where idUsuario = '$supervisor'"));
        $supervisorEmail = $sql['email'];
        $Cc = $supervisorEmail;
        $Cc2 = $supervisorEmail;

        $valorCompra = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from PedidoDMTRIX where idCompra = '$Compra'"));
        $formaPagamento = $valorCompra['formaPagamento'];
		
		
		$emailDestinatario = utf8_decode($email);
		$nomeDestinatario = utf8_decode($nome);
		$assunto = utf8_decode("alteração de valor da compra: ".$Compra);
		$mensagem =  utf8_decode("Ola </br> O valor de sua compra de numero ".$Compra." foi atualizado</br> entre no DMTRIX e verifique se você esta de acordo com o valor!");
        $mensagem .=  utf8_decode("sua compra ".$nome." foi orçada, o valor da compra que sera descontado do budget de seu supervisor será: ".$total." caso haja alguma alteraçao entraremos em contato<br>
        o valor ainda não foi descontado do budget, apenas será descontado quando você aprovar o orçamento, a forma de pagamento selecionada para esta compra é: ".$formaPagamento);

        envioEmailCompra($emailDestinatario, $nomeDestinatario, $assunto, $mensagem, $Cc, $nome, $Cc2);



		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario atualizou os valores da Compra: $Compra')");
		echo "<script>alert('Valores atualizados'); location.href='atualizar-valor-compras.php';</script>"; 
		return true;
		}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar editar os valores, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	}
	
	
};
function EditCarrinho($largura, $altura, $quantidade, $observacao, $id, $valorMaterial, $usuarioLogado,$idUsuario)
{
	if($observacao == NULL)
	{
		$observacao = "Sem observacao";
	}
	
	$query = odbc_exec($GLOBALS['conexao'],"update dbo.PedidoDMTRIX set largura = '$largura', altura = '$altura', quantidade= '$quantidade', observacao = '$observacao', valorProduto = '$valorMaterial' where idPedido = '$id'");
	if($query == true)
	{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado de codigo: $idUsuario Editou o pedido de numero: $id ')");
		echo "<script>alert('Atualizado'); location.href='carrinho.php';</script>"; 
		return true;
		}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar editar, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
	}
	
}
function AddCarrinho($largura, $altura, $quantidade, $observacao, $id,$datapedido,$usuarioLogado,$idUsuario, $valor)
{
	if($observacao == NULL)
	{
		$observacao = "Sem observacao";
	}
						$largura1 = $largura/100;
						$altura1 =  $altura/100;
						$valorMaterial = round((($largura1*$altura1)*$valor*$quantidade),2);
						$_SESSION['valorTotal'] = $valorMaterial;
	
	
	/*/$Material = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from [marketing].[dbo].[materiaisDMTRIX] where idMaterial = '$id'"));
	
	$formaPagamento = $Material['formaCalculo'];
	
	if($formaPagamento != 1){/*/
	
	
	$query = odbc_exec($GLOBALS['conexao'], "insert into marketing.dbo.PedidoDMTRIX(idMaterial,largura,altura,quantidade ,observacao,Data_do_Pedido, idUsuario, status_pedido, valorProduto) values ('$id','$largura','$altura', '$quantidade' ,'$observacao','$datapedido','$idUsuario',1,'$valorMaterial')");
	
	/*/}else
	{
			$query = odbc_exec($GLOBALS['conexao'], "insert into marketing.dbo.PedidoDMTRIX(idMaterial,largura,altura,quantidade,localizacao,data_entrega ,observacao,Data_do_Pedido, idUsuario, status_pedido, valorProduto) values ('$id','$largura','$altura', '$quantidade' , '$localizacao' ,'$dataEntrega','$observacao','$datapedido','$idUsuario',3,'$valor')");
		
	}/*/
	
		if($query == true)
		{
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado de codigo: $idUsuario realizou um pedido referente ao material de id: $id ')");
		
		
		
		echo "<script>alert('Voce inseriu este item no carrinho!'); location.href='todos-os-materiais.php';</script>"; 
		return true;
		}else
		{
		echo "<script>alert('Ocorreu um erro ao tentar enviar ser pedido, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
		}
			
	//};
};

function addCompra($valorTotal, $idUsuario)
{
	$data = date("m.d.y, g:i a");
	
	$query = odbc_exec($GLOBALS['conexao'],"insert into [marketing].[dbo].[ComprasDMTRIX] (dataCompra, valorTotal, idUsuario, status_compra) values(GETDATE(),'$valorTotal','$idUsuario','Aguardando')");
	
	if($query == true)
	{
		$buscaCompra = odbc_exec($GLOBALS['conexao'], "select idCompra from [marketing].[dbo].ComprasDMTRIX where idUsuario = '$idUsuario' and status_compra = 'Aguardando'");
		$rsbuscaCompra = odbc_fetch_array($buscaCompra);
		$Compra = $rsbuscaCompra['idCompra'];
		
		$query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set idCompra = '$Compra'  where idUsuario = '$idUsuario' and status_pedido = 1");
		
		
				if($query == true)
				{
					$query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[ComprasDMTRIX] set status_compra = 'Em analise', avaliado = 'nao' where idCompra = '$Compra'");
					$query = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set status_pedido = 2  where idUsuario = '$idUsuario' and status_pedido = 1");
					
					$formaPag = odbc_exec($GLOBALS['conexao'], "select * from [marketing].[dbo].ComprasDMTRIX c inner join PedidoDMTRIX p on p.idCompra = c.idCompra inner join 
materiaisDMTRIX m on m.idMaterial = p.idMaterial where c.idCompra ='$Compra'");
						while($rsFoma = odbc_fetch_array($formaPag))
						{
							$forma = $rsFoma['formaCalculo'];
							$status = $rsFoma['status_pedido'];
							$idPedidos = $rsFoma['idPedido'];
							
							if($forma == 1 and $status <= 2)
							{
								$query2 = odbc_exec($GLOBALS['conexao'],"update [marketing].[dbo].[PedidoDMTRIX] set status_pedido = 3  where idPedido = '$idPedidos'");
								
							}
							
							
							
						}
					
					
				}else{ echo "<script>alert('Erro na atualização do pedido.'); </script>";
		return false; }
				
				$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário de codigo: $idUsuario realizou uma compra')");
				
				//parte de envio de email, apos estar tudo ok
						$query2 = odbc_exec($GLOBALS['conexao']," SELECT p.acao,p.altura,p.custeio,p.Data_do_Pedido,p.data_entrega,p.formaPagamento,p.formaPagamento,p.idCompra,p.idLoja,p.idMaterial,p.idPedido,p.idUsuario,p.largura,p.objetivo,p.observacao,p.publicAlvo,p.quantidade,p.segmento,p.status_pedido,
  p.valorProduto,p.valorTotal, m.material,m.categoria FROM [marketing].[dbo].[PedidoDMTRIX] p inner join marketing.dbo.materiaisDMTRIX m  on p.idMaterial = m.idMaterial  
  where  p.idCompra = '$Compra'");
						
  
  					$queryUsu = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * FROM [marketing].[dbo].[usuariosDMTRIX] where idUsuario = '$idUsuario'"));
					$nome = $queryUsu['nome']." ".$queryUsu['sobrenome'];
					$email = $queryUsu['email'];
					$responsavel = $queryUsu['supervisor'];
					$queryRsp = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * FROM [marketing].[dbo].[usuariosDMTRIX] where idUsuario = '$responsavel'"));
					$Cc = $queryRsp['email'];
                    $mensagem="-";
						
					$mensagem .= " Caro ".$nome.", seu pedido foi realizado</br> com sucesso, o codigo de sua compra  é <strong>".$Compra."</strong></br> com ele você pode acompanhar os status de seu</br> pedido atravez da opção rastreio de pedido.</br>";
					while($rsbuscaPedido = odbc_fetch_array($query2))
					{
						
						$mensagem .= "- ".$rsbuscaPedido['material']." - Quantidade: ".$rsbuscaPedido['quantidade']."</br>";
					}
	
					$emailDestinatario = "agenciamarketing@dmcard.com.br";
					$nomeDestinatario = $nome;
					$assunto = "Pedido de compra - DMTRIX";
	
					envioEmailCompra($emailDestinatario, $nomeDestinatario, $assunto, $mensagem, $email, $nome, $Cc);
					//envioEmail($email, $nome, $assunto, $mensagem);
				
				echo "<script>alert('Compra realizada!'); location.href='compra-finalizada.php';</script>"; 
		
	}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar finalizar sua compra, tente novamente mais tarde, ou contate o administrador.'); </script>";
		return false;
	}
	
	
};

function DeletaPedido($id,$usuarioLogado,$idUsuario, $number)
{
	$query = odbc_exec($GLOBALS['conexao'], "delete from [marketing].[dbo].[PedidoDMTRIX] where idPedido = '$id'");
	if($number == 1){
		if($query == true)
		{
			$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO [marketing].[dbo].[historicosDMTRIX](acao) VALUES('O usuário $usuarioLogado de codigo: $idUsuario : Deletou um pedido')");
		echo "<script>alert('Pedido deletado com sucesso!'); location.href='todos-os-materiais.php';</script>"; 
		return true;
		}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar excluir, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
		};
	}else if($number == 2)
	{
		if($query == true)
		{
			$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO [marketing].[dbo].[historicosDMTRIX](acao) VALUES('O usuário $usuarioLogado de codigo: $idUsuario : Deletou um pedido')");
		echo "<script>alert('Pedido deletado com sucesso!'); location.href='carrinho.php';</script>"; 
		return true;
		}else
	{
		echo "<script>alert('Ocorreu um erro ao tentar excluir, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
		};
	}
}
// Função para login de usuários
function login($usuario, $senha, $ficarLogado){
	// Valida o usuário e senha
	$query = odbc_exec($GLOBALS['conexao'], "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuario' AND senha = '$senha' AND status = '1'");
	$qtd = odbc_num_rows($query);
	// Verifica se há usuários com a senha informada
	if($qtd < 1){
		echo "<script>alert('Usuário ou senha incorretos.');</script>";
		return false;
	}else{
		// Verifica se o usuário quer guardar o login e senha em cookie
		if($ficarLogado == 1){
			setcookie("usuario", $usuario, (time() + (30 * 24 * 3600)));
			setcookie("senha", $senha, (time() + (30 * 24 * 3600)));
		};
		$dadosUsuario = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuario'"));
		$nivel = $dadosUsuario['nivel'];
		$idUsuario = $dadosUsuario['idUsuario'];
		$dadosUsuario = $dadosUsuario['nome']." ".$dadosUsuario['sobrenome'];
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $dadosUsuario fez o login no DMTrix.')");
		
		// Cria a sessão
		session_start();
		$_SESSION['usuario'] = $usuario;
		$_SESSION['nivel'] = $nivel;
		
		
		
		
		$query = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from [MARKETING].[dbo].[ComprasDMTRIX] where status_compra = 'finalizado' and idUsuario = '$idUsuario'"));
		
		$avaliado = $query['avaliado'];
		
		if($avaliado == 'sim' or $avaliado == ""){
			if($nivel == 2 or $nivel == 1){

		header("Location: trade-home.php");
			}else{header("Location: home.php");}
		
		}else if($avaliado == 'nao')
		{
			
			
			?>
            <script type="text/javascript" src="js/bibliotecas.js"></script>
			<script type="text/javascript" src="js/scripts.js"></script>
            <script type="text/javascript" src="js/jquery.colorbox.js"></script>
            <script type="text/javascript">
			
	
	
			$.colorbox({href:"score.php", width:"69%", height:"100%"});
	
			

			</script> 
			<?php
		}else
		{
			echo "<script>alert('A avaliação esta com valor nulo ou um parametro diferente do esperado, contate o administrador do sistema. valor: $avaliado')</script>";
		}
	};
};

//função para salvar avaliações dos usuarios
function avaliacao($avaliacao, $idUsuario, $idPedido, $idMaterial, $valor, $idCompra)
{
	$count = count($avaliacao);
	for($i=0; $i < $count; $i++){
		
	$query = odbc_exec($GLOBALS['conexao'], "insert into [MARKETING].[dbo].[avaliacaoDMTRIX] (idPedido, idUsuario, avaliacao, idMaterial, observacao) values ('$idPedido[$i]', '$idUsuario', '$valor[$i]', '$idMaterial[$i]', '$avaliacao[$i]')");
	
	}
	
	$query2 = $query = odbc_exec($GLOBALS['conexao'], "update [MARKETING].[dbo].[ComprasDMTRIX] set avaliado = 'sim' where idCompra = '$idCompra'");
	
		if($query == true)
		{
			$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO [marketing].[dbo].[historicosDMTRIX](acao) VALUES('O usuário de codigo: $idUsuario : avaliou uma compra de numero: $idCompra')");
		echo "<script>alert('Avaliação realizada com sucesso!'); location.href='home.php';</script>"; 
		return true;
		}else
			{
		echo "<script>alert('Ocorreu um erro ao tentar avaliar, tente novamente ou entre em contato com o administrador.'); history.back(-1); </script>";
		return false;
		};
	
	
};


// Função para cadastrar usuários
function cadastraUsuarios($usuario, $senha, $repeteSenha, $nome, $sobrenome, $email){
	// Verifica se o usuário já não existe
	$query = odbc_num_rows(odbc_exec($GLOBALS['conexao'], "SELECT usuario FROM dbo.usuariosDMTRIX WHERE usuario = '$usuario'"));
	if($query > 0){
		echo "<script>alert('O usuário $usuario já existe no sistema. Por favor, escolha outro.'); history.back(-1);</script>";
		return false;
	};

	// Verifica se ambas as senhas são iguais
	if($senha != $repeteSenha){
		echo "<script>alert('As senhas não estão iguais.'); history.back(-1);</script>";
		return false;
	};
	
	// Realiza o cadastro
	$query = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.usuariosDMTRIX(usuario, senha, nome, sobrenome, email) VALUES('$usuario', '$senha', '$nome', '$sobrenome', '$email')");
	
	// Verifica ação bem sucedida
	if($query == true){
		// Busca o id do usuário recem cadastrado e insere no histórico
		$usuarioCadastrado = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "SELECT * FROM dbo.usuariosDMTRIX ORDER BY idUsuario DESC"));
		$usuarioCadastrado = $usuarioCadastrado['nome']." ".$usuarioCadastrado['sobrenome'];
		
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioCadastrado fez o cadastro no DMTrix.')");
		
		
		echo envioEmail("agenciamarketing@dmcard.com.br", "Administrador", "Cadastro de Usuários", "
		Administrador,<br><br>
		
		Um usuário acaba de se registrar no DmTrix. Segue abaixo os dados: <br>
		<strong>Nome Completo:</strong> $nome $sobrenome <br>
		<strong>Usuário:</strong> $usuario <br>
		<strong>Senha:</strong> $senha <br>
		<strong>E-mail:</strong> $email <br>
		
		Por enquanto este usuário não está liberado para acessar o DMTrix. Para liberar o acesso dele(a), informar o nível de acesso e o supervisor,
		<a href='http://dmcard.com.br/dmtrix/liberar-acesso.php' target='_blank'>clique aqui</a>.
		");
		echo "<script>alert('Cadastro realizado com sucesso. Em breve seu usuário será liberado pelo controle.'); location.href='index.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar o cadastro. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	};
};

// Função para atualizar usuários
function atualizaUsuarios($usuario, $senha, $repeteSenha, $nivel, $nome, $sobrenome, $email, $supervisor, $status, $idUsuario, $usuarioAntigo, $usuarioLogado){
	// Verifica se ambas as senhas são iguais
	if($senha != $repeteSenha){
		echo "<script>alert('As senhas não estão iguais.'); history.back(-1);</script>";
		return false;
	};

	// Se o usuário informado for diferente do antigo e EXISTIR, PARA o script
	$query = odbc_exec($GLOBALS['conexao'], "SELECT usuario FROM dbo.usuariosDMTRIX WHERE usuario = '$usuario'");
	if(($usuario != $usuarioAntigo) && (odbc_num_rows($query) > 0)){
		echo "<script>alert('O usuário $usuario já existe no sistema. Por favor, escolha outro.'); history.back(-1);</script>";
		return false;
	};
	
	// Verifica se ele é supervisor, caso sim, o supervisor dele será ele mesmo
	if($nivel == 3){ $supervisor = $idUsuario; }
	if($nivel == 0){ $nivel = 1; }
	
	// Realiza a atualização
	$query = odbc_exec($GLOBALS['conexao'], "UPDATE dbo.usuariosDMTRIX SET usuario = '$usuario', senha = '$senha', nivel = '$nivel', nome = '$nome', sobrenome = '$sobrenome', email = '$email', supervisor = '$supervisor', status = '$status' WHERE idUsuario = '$idUsuario'");
	
	if($query == true){
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado efetuou uma atualização no cadastro de $nome $sobrenome')");
		echo "<script>alert('A atualização do usuário $nome foi realizada com sucesso!'); location.href='listagem-usuarios.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar a alteração. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	}
};

// Função para atualizar o valor do budget
function atualizaBudget($idUsuario, $budgetMerchandising, $budgetBrindes, $usuarioLogado, $observacao){
	$count = count($idUsuario);
	for($i = 0; $i < $count; $i++){

        $buscar = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from usuariosDMTRIX where idUsuario= '$idUsuario[$i]'"));
        if($budgetMerchandising[$i] == "")
        {

            $merchan = 0;


        }else{ $merchan = $budgetMerchandising[$i]; }
        $budgetAtual = $buscar['budgetMerchandising'];
        $total = $budgetAtual + $merchan;
        $idPedido = 0;

        $idLoja = 0;
        $responsavel = $buscar['supervisor'];
        $observacao = $observacao[$i];

            // Atualiza budget de Merchandising
            $query = odbc_exec($GLOBALS['conexao'], "UPDATE dbo.usuariosDMTRIX SET budgetMerchandising = '$total' WHERE supervisor = '$idUsuario[$i]'");
            $query = odbc_exec($GLOBALS['conexao'], "UPDATE dbo.usuariosDMTRIX SET budgetMerchandising = '$total' WHERE idUsuario = '$idUsuario[$i]'");
            if($merchan < 0) {

                $merchan = abs($merchan);
                if($merchan != 0) {

                    if($observacao == "Credito Trimestral")
                    {
                        $observacao = "Debito Trimestral";
                    }

                    $query2 = AddDebitoDMTRIX($merchan, $idPedido, 1, $observacao, $responsavel, $total, $idUsuario[$i], $idLoja);

                }

            }else
            {
                if($merchan != 0) {
                    $query2 = AddCreditoDMTRIX($merchan, $idPedido, 1, $observacao, $usuarioLogado, $total, $idUsuario[$i]);
                }
            }


        $budgetAtual = $buscar['budgetBrindes'];
        if($budgetBrindes[$i] == "")
        {

            $brinde = 0;


        }else{ $brinde = $budgetBrindes[$i]; }
        $total = $budgetAtual + $brinde;

            // Atualiza budget de Brindes
            $query = odbc_exec($GLOBALS['conexao'], "UPDATE dbo.usuariosDMTRIX SET budgetBrindes = '$total' WHERE idUsuario = '$idUsuario[$i]'");
        if($brinde < 0) {
            $brinde = abs($brinde);
            if($brinde != 0) {
                if($observacao == "Credito Trimestral")
                {
                    $observacao = "Debito Trimestral";
                }
                $query2 = AddDebitoDMTRIX($brinde, $idPedido, 2, $observacao, $responsavel, $total, $idUsuario[$i], $idLoja);
            }

        }else
        {

            if($brinde != 0) {
                $query2 = AddCreditoDMTRIX($brinde, $idPedido, 2, $observacao, $usuarioLogado, $total, $idUsuario[$i]);
            }
        }


	};

	if($query == true and $query2 = true){
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado atualizou o budget dos usuários')");
		echo "<script>alert('Atualização dos budgets foi realizada com sucesso!'); location.href='distribuicao-de-budget.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar a alteração. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	}
};

// Função para cadastrar os materiais
function cadastraMaterial($material, $valor, $formaCalculo, $quantidade, $usuarioLogado, $nome_material, $categoria){
	// Verifica se há algum valor na quantidade. Caso não hava, é definido como NULL
	if($quantidade == ""){ $quantidade == NULL; };
	if($valor == ""){$valor == NULL; }
	if($formaCalculo == NULL)
		{
			echo "<script>alert('Selecione uma opção para Forma Calculo.'); history.back(-1);</script>";
			return false;
		}
	
	// Faz o cadastro do material
	$query = odbc_exec($GLOBALS['conexao'], "INSERT INTO materiaisDMTRIX(material, valor, formaCalculo, quantidade, foto, categoria) VALUES('$material', '$valor', '$formaCalculo', '$quantidade', '$nome_material', '$categoria')");

	if($query == true){
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado cadastrou um novo material')");
		echo "<script>alert('Material cadastrado com sucesso!'); location.href='administrar-materiais.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar o cadastro. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	};
};

function cadastraBrinde($Brinde, $valor, $quantidade, $usuarioLogado, $nome_brinde)
{
	
	$query = odbc_exec($GLOBALS['conexao'], "INSERT INTO brindesDMTRIX(Brinde, valor, estoque, foto) VALUES('$Brinde', '$valor', '$quantidade', '$nome_brinde')");
	if($query == true){
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado cadastrou um novo Brinde')");
		echo "<script>alert('Brinde cadastrado com sucesso!'); location.href='administrar-brinde.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar o cadastro. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	};
	
}

function AtualizaMaterial ($material, $valor, $formaCalculo, $quantidade, $usuarioLogado, $id,$nome_material){
		if($quantidade == ""){ $quantidade == NULL; };
		if($valor == ""){$valor == NULL; };
		if($formaCalculo == NULL)
		{
			echo "<script>alert('Selecione uma opção para Forma Calculo.'); history.back(-1);</script>";
			return false;
		}
		if($nome_material == "")
		{
			$query = odbc_exec($GLOBALS['conexao'],"update dbo.materiaisDMTRIX set material = '$material', valor = '$valor', formaCalculo= '$formaCalculo', quantidade='$quantidade' where idMaterial = '$id'");
		}else{

	$query = odbc_exec($GLOBALS['conexao'],"update dbo.materiaisDMTRIX set material = '$material', valor = '$valor', formaCalculo= '$formaCalculo', quantidade='$quantidade', foto = '$nome_material' where idMaterial = '$id'");
		}
		//salva historico
		if($query == true){
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado Editou o material de codigo $id')");
		echo "<script>alert('Material Atualizado com sucesso!'); location.href='administrar-materiais.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar na atualização. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	}
	
};

function AtualizaBrinde($Brinde, $valor, $quantidade, $usuarioLogado, $extencaoF, $idBrinde)
{
	if($quantidade == ""){ $quantidade == NULL; };
		if($valor == ""){$valor == NULL; };

    $qtdBrinde = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from brindesDMTRIX where idBrinde = '$idBrinde'"));
    $estoque = $qtdBrinde['estoque'];

    $total = $estoque + $quantidade;
    $tipoMov = "Quantidade Alterada";
    $idPedido = 0;
    if($total < 0)
    {
        $total = 0;
    }


    $query2 = MovimentacaoEstoque($tipoMov, $idPedido, $quantidade, $total, $usuarioLogado);




		if($extencaoF == "")
		{
			
			$query = odbc_exec($GLOBALS['conexao'],"update dbo.brindesDMTRIX set brinde = '$Brinde', valor = '$valor', estoque='$total' where idBrinde = '$idBrinde'");
			
		}else{
		
		$query = odbc_exec($GLOBALS['conexao'],"update dbo.brindesDMTRIX set brinde = '$Brinde', valor = '$valor', estoque='$total', foto = '$extencaoF' where idBrinde = '$idBrinde'");
		
		}
		if($query == true and $query2 == true){
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $usuarioLogado Editou o Brinde de codigo $idBrinde')");
		echo "<script>alert('Brinde Atualizado com sucesso!'); location.href='administrar-brinde.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar na atualização. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	}

}

function AddCartao($site, $logo, $descricao, $idLoja, $idUsuario)
{
	if($idLoja == "")
	{
		$idLoja = 1413;
	}
	if($site == "")
	{
		$site = "sem site";
	}
	if($logo == "")
	{
		$logo = "sem logotipo";
	}
	//$dataSolicitacao = date("d/m/y, g:i a");
	
	$query = odbc_exec($GLOBALS['conexao'], "insert into [MARKETING].[dbo].[novoCartaoDMTRIX] 
  (idLoja,site,descricao,idUsuario, logotipo2, dataSolicitacao, status) values
  ('$idLoja','$site','$descricao','$idUsuario','$logo', GETDATE(), 1)");
  
  if($query == true){
	  
	  $query =odbc_fetch_array( odbc_exec($GLOBALS['conexao'], "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$idUsuario'"));
	  $query2 =odbc_fetch_array( odbc_exec($GLOBALS['conexao'], "  SELECT * FROM [MARKETING].[dbo].[novoCartaoDMTRIX]  WHERE idUsuario = '$idUsuario' order by idCartao desc"));
	  $idCartao=$query2['idCartao'];
	  $nome = $query['nome']." ".$query['sobrenome'];
	  $emailDestinatario = utf8_decode("julia.melo@dmcard.com.br");
		$nomeDestinatario = utf8_decode($nome);
		$assunto = utf8_decode("Pedido de novo cartão de numero ".$idCartao);
		$mensagem =  utf8_decode("O Usuario: ".$nome." solicitou a criação de um novo cartão!");

	envioEmail($emailDestinatario, $nomeDestinatario, $assunto, $mensagem);
		$historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('O usuário $idUsuario Solicitou um novo cartão)'");
		echo "<script>alert('Solicitado novo cartão com sucesso, aguarde nosso contato!!'); location.href='solicitacao-novo-cartao.php'</script>";
		return true;
	}else{
		echo "<script>alert('Houve uma falha ao realizar a solicitação. Tente novamente mais tarde.'); history.back(-1);</script>";
		return false;
	};
	
}

function addLoja($numeroLoja, $nomeLoja, $rede, $responsavel, $cidade, $estado, $cep){

$query = odbc_exec($GLOBALS['conexao'], "insert into lojasDMTRIX(numeroLoja,nomeLoja,rede,responsavel,cidade,estado,cep,qtdMerchLancamento) values('$numeroLoja','$nomeLoja', '$rede', '$responsavel','$cidade', '$estado' ,'$cep',0)");

    if($query == true)
    {
        $historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('a loja de numero: '$numeroLoja' foi adicionada'");
        echo "<script>alert('Loja cadastrada com sucesso!!'); location.href='cadastro-lojas.php'</script>";
        return true;
    }else{echo "<script>alert('Ocorreu uma falha ao salvar, verifique se as informações estão corretas!'); history.back(-1);</script>";
        return false;}

}

function AtualizarLoja($idLoja, $numeroLoja, $nomeLoja, $rede, $responsavel, $cidade, $estado, $cep){

    $query = odbc_exec($GLOBALS['conexao'], "update lojasDMTRIX set numeroLoja='$numeroLoja', nomeLoja='$nomeLoja',rede='$rede', responsavel='$responsavel',
cidade='$cidade', estado='$estado', cep='$cep' where idLoja = '$idLoja'");

    echo "<script>alert('idLoja: $idLoja, numero da loja: $numeroLoja, $nomeLoja  $rede  $responsavel  $cidade $estado $cep')</script>";
    if($query == true)
    {


        $historico = odbc_exec($GLOBALS['conexao'], "INSERT INTO dbo.historicosDMTRIX(acao) VALUES('a loja de numero: '$numeroLoja' foi atualizada'");
        echo "<script>alert('Loja Atualizada com sucesso!!'); location.href='cadastro-lojas.php'</script>";
        return true;
    }else{

        $erro = odbc_errormsg();
        echo "<script>alert('$erro')</script>";
        echo "<script>alert('Ocorreu uma falha ao editar, verifique se as informações estão corretas!'); history.back(-1);</script>";
        return false;}

}

function CarregaFoto($nome_material,$nome_temp)
{
	
	$pasta = '../dmtrade/img/brindes/';
	move_uploaded_file($nome_temp, $pasta. $nome_material);
	
	
};

function CarregaArte($nome_material,$nome_temp)
{
	$pasta = '../dmtrade/img/brindes/';
	move_uploaded_file($nome_temp, $pasta. $nome_material);
	
	
};

function CarregaBrinde($nome_material,$nome_temp)
{
	$pasta = '../dmtrade/img/brindes/';
	move_uploaded_file($nome_temp, $pasta. $nome_material);
	
	
};

function CarregaLogo($nome_material,$nome_temp)
{
	$pasta = '../dmtrade/img/brindes/';
	//$pasta = 'img/logos/';
	move_uploaded_file($nome_temp, $pasta. $nome_material);
	
	
};


function AddCreditoDMTRIX($valor, $idPedido, $tipo, $observacao, $controle, $budget, $idUsuario)
{

    if($tipo == 1) {


       $credito =  odbc_exec($GLOBALS['conexao'],"insert into creditoDMTRIX (valor,dataCredito,idUsuario,controle,tipo,observacao,idPedido, budget) values ('$valor',GETDATE(),'$idUsuario','$controle','$tipo','$observacao','$idPedido', '$budget')");
        if($credito == true)
        {

            return true;

        }else
        {
            return false;
        }

    }elseif($tipo == 2)
    {

        $credito =  odbc_exec($GLOBALS['conexao'],"insert into creditoDMTRIX (valor,dataCredito,idUsuario,controle,tipo,observacao,idPedido, budget) values ('$valor',GETDATE(),'$idUsuario','$controle','$tipo','$observacao','$idPedido','$budget')");
        if($credito == true)
        {

            return true;

        }else
        {
            return false;
        }

    }

}

function AddDebitoDMTRIX($valor, $idPedido, $tipo, $observacao, $responsavel, $budget, $idUsuario, $idLoja)
{

    if($tipo == 1)
    {


        $credito =  odbc_exec($GLOBALS['conexao'],"insert into debitoDMTRIX (valor,dataDebito,idUsuario,supervisor,idLoja,idPedido,observacao, tipo, budget ) values ('$valor',GETDATE(),'$idUsuario','$responsavel','$idLoja','$idPedido','$observacao',1,'$budget')");

        if($credito == true)
        {

            return true;

        }else
        {
            return false;
        }

    }elseif($tipo == 2)
    {

        $credito =  odbc_exec($GLOBALS['conexao'],"insert into debitoDMTRIX (valor,dataDebito,idUsuario,supervisor,idLoja,idPedido,observacao, tipo, budget ) values ('$valor',GETDATE(),'$idUsuario','$responsavel','$idLoja','$idPedido','$observacao',2,'$budget')");

        if($credito == true)
        {

            return true;

        }else
        {
            return false;
        }

    }

}

function MovimentacaoEstoque($tipoMov, $idPedido, $quantidade, $estoque, $idUsuario)
{

    if($tipoMov == "Cancelamento Pedido")
    {

        $query = odbc_exec($GLOBALS['conexao'], "INSERT INTO movimentacaoEstoqueDMTRIX (dataMovimentacao,tipoMovimentacao,idPedido,quantidadeMov,estoque,idUsuario) VALUES (GETDATE(),'$tipoMov','$idPedido','$quantidade','$estoque','$idUsuario')");

        if($query == true) {
            return true;
        }else
        {
            return false;

        }

    }elseif($tipoMov == "Compra de Brinde")
    {
        $query = odbc_exec($GLOBALS['conexao'], "INSERT INTO movimentacaoEstoqueDMTRIX (dataMovimentacao,tipoMovimentacao,idPedido,quantidadeMov,estoque,idUsuario) VALUES (GETDATE(),'$tipoMov','$idPedido','$quantidade','$estoque','$idUsuario')");

        if($query == true) {
            return true;
        }else
        {
            return false;

        }

    }elseif($tipoMov == "Quantidade Alterada")
    {

        $query = odbc_exec($GLOBALS['conexao'], "INSERT INTO movimentacaoEstoqueDMTRIX (dataMovimentacao,tipoMovimentacao,idPedido,quantidadeMov,estoque,idUsuario) VALUES (GETDATE(),'$tipoMov','$idPedido','$quantidade','$estoque','$idUsuario')");


        if($query == true) {

            return true;

        }else{

            return false;

        }


    }


}

?>