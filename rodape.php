<div class="clear bgBranco secao2">
    <h2>Demétrios<br><span>Tire suas dúvidas com o Demétrios, ele está pronto para resolver qualquer</br> problema!</span></h2>
    <ul class="left largura30">
        <li title="Você pode selecionar o item desejado no menu disponível na barra superior do site ou clicando no botão todos os materiais. Escolha um ou mais itens para seu carrinho e siga o passo a passo. Ao finalizar sua compra você receberá um código/token para acompanhar todas as etapas do processo de produção do seu pedido.">Como faço uma compra?</li>
        <li title="Basta clicar no “Menu” disponível no canto superior direito da página, selecionar a opção “Atualizar Dados Pessoais e de Acesso” e incluir as alterações necessárias.">Como altero meus dados?</li>
        <li title="O prazo de criação do pedido será passado pelo Controle da Agência em até 4 dias úteis após a inserção da solicitação no DMTrix. Após aprovação da arte, o material será entregue ao solicitante em até 15 dias.">Quanto tempo demora para meu pedido ficar pronto?</li>
        <li title="Neste caso você deve entrar em contato com o Trade Marketing e solicitar que sua necessidade seja avaliada.">Se acabar meu budget, o que eu faço?</li>
        
        <li title="Vá até a opção “Menu” e selecione “Envio de SMS”.">Como faço para solicitar SMS?</li>
       	<li title="“Vá até a opção “Menu” e selecione “Loja de Brindes”. Você pode solicitar diversos brindes em uma única compra, e ainda acompanhar seu pedido.">Como faço para comprar brindes?</li>
        <li title="Os pedidos que apresentam o valor fixo de R$25,00 para o Merchan são os que dependem de orçamento, ou seja, são valores que variam de acordo com o fornecedor e, por isso, inicialmente apresentamos o valor genérico.">Por que alguns produtos possuem valor genérico de R$25,00?</li>
        <li title="Os pedidos no DMTRIX estão configurados para receber valores de largura e altura em cm. Atente-se a isso quando for realizar seu pedido.">Qual a unidade de medida usada no DMTrix?</li>
        <li title="Sim. Nós criamos uma opção nas escolha de lojas na qual você pode selecionar a rede em si, procurando pelo número dela. Caso não localize a rede no seu perfil, basta enviar a solicitação de inclusão através do “Fale Conosco”, ou entrar em contato com a Agência de Marketing da DM.">Posso solicitar produtos para uma rede inteira?</li>
    </ul>
    
    <div class="left largura30 personagem">
        <img src="img/demetrios.png" width="161" height="300">
    </div>
    
    <div class="right largura30">
        <h3>Selecione uma pergunta</h3>
        <p>para te darmos a melhor resposta!</p>
    </div>
</div>

<footer class="clear bgBranco rodape">
    <nav class="left largura30">
        <h2>Mapa do site</h2>
        <ul>
            <li><a href="brindes.php">Loja de Brindes</a></li>
            <li><a href="todos-os-materiais.php">Materiais de Merchan</a></li>
            <li><a href="alterar-dados.php">Alterar Conta</a></li>
            <li><a href="solicitacao-sms.php">Envio de SMS</a></li>
            <li><a href="solicitacao-novo-cartao.php">Arte de Novo Cartão</a></li>
            <li><a href="carrinho.php">Carrinho</a></li>
        </ul>
    </nav>
    <nav class="left largura30">
        <h2>Histórico</h2>
        <ul>
            <li><a href="historico.php">Minhas Compras Realizadas</a></li>
            <li><a href="rastreio.php">Rastrear Pedidos</a></li>
            <li><a href="historico-sms.php">Meus envios de SMS</a></li>
            <li><a href="historico-producao.php">Pedidos que estão com fornecedor</a></li>
            <li><a href="historico-novo-cartao.php">Historico de Cartões pedidos</a></li>
            
        </ul>
    </nav>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="right largura30">
        <h2>Fale Conosco</h2>
        <div class="largura100 left campo">
            <select name="supervisor">
                <option value="<?php echo $usuarioLogado['nome'] ?>"><?php echo $usuarioLogado['nome'] ?></option>
            </select>
        </div>
        <div class="largura100 left campo"><textarea name="mensagem" placeholder="Digite aqui sua mensagem" required></textarea></div>
        <input type="submit" name="duvida" value="Enviar Mensagem" class="largura100 left btnSubmit">
    </form>


</footer>





<?php include("boxResumo.php"); 

	
	if(isset($_POST['duvida']))
	{
		$texto = $_POST['mensagem'];
		$usuario = $_POST['supervisor'];
		$emailDestinatario = 'flavio.barros@dmcard.com.br';
		$assunto = 'Duvida no DMTRIX de '.$usuario;
		$mensagem = 'Segue duvida da usuario(a) '.$usuario.':';
		$mensagem .= $texto;
		
		
		
		envioEmail($emailDestinatario, 'Flavio', $assunto, $mensagem);
		
		
	}


?>