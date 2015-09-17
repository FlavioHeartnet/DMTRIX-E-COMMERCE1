<?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
			$idUsuario = $usuarioLogado['idUsuario'];
 ?>
 <form class="left" action="" method="post">
        <input type="hidden" name="nivel" value="<?php echo $usuarioLogado['nivel']; ?>">
        </form>
<header class="clear bgBranco">
	<div class="centro">
    	<a href="home.php"><div class="logotipo left"></div></a>
        <form class="left" action="todos-os-materiais.php" method="post">
        <select id="busca" class="tranparencia largura80" name="busca" required autocomplete="off">
        <option value=""></option>
          <?php 
			$query = odbc_exec($conexao, "select * from dbo.materiaisDMTRIX order by material asc");
			while($rsQuery = odbc_fetch_array($query)){
				
				?>
					 <option name="value[]" value="<?php echo $rsQuery['idMaterial'];?>"><?php echo $rsQuery['material'];?></option>
				<?php
				} ?>
        	</select>
            <input type="submit" name="buscar" value="">
            <ul class="buscaResultados">
            
          
            
				<a href="#"><img src="img/produtos_thumbnail/Nome-do-Produto-de-Teste.png">Nome<br>R$20.00 m²</a>
            </ul>
            
        </form>
        
        <ul class="right menuPrincipal">
        	
        	<li><a href="rastreio.php">Rastrear Pedido<div class="icone"></div></a></li>
        	<li><a href="carrinho.php">Carrinho de Compras<div class="icone"></div></a></li>
           
            <li style="background:white; color:gray"><strong>Menu</strong><div class="icone"></div>
            	<nav  class="subMenu1">
                	<ul>
                        <h2>Outras Solicitações</h2>
                        <a href="solicitacao-sms.php">Envio de SMS</a>
                        <a href="solicitacao-novo-cartao.php">Arte de Novo Cartão</a>
                        
                    </ul>
                    <ul>
                    
                        <h2>Loja de Brindes</h2>
                        <a href="comprasBrindes.php">Carrinho de Brindes</a>
                        <a href="Rastreio-brindes.php">Rastreio de brindes</a>
                         <a href="brindes.php">Loja de Brindes</a>
                        
                    </ul>
                     <ul>
                     <div id="trade">
                        <h2>Trade Marketing </h2>
                        <a href="administrar-brinde.php">Adicionar Brindes</a>
                         <a href="filaBrindes.php">Gerenciamento e Triagem de Fila (Brindes)</a>
                        <a href="historico-relatorio.php">Relatórios e históricos</a>
                        <a href="dicas.php">Dicas de Merchandising</a>
                        <a href="cadastrar-dicas.php">Cadastrar Dicas de Merchandising</a>
					 </div>
                    </ul>
                    <div  class="verificaLogin">
                		<ul>
                        <h2>Aprovar e Reprovar</h2>
                        <a href="aprovacao-reprovacao.php">Aprovar / Reprovar Artes</a>
                        <a href="aprovacao-reprovacao.php">Aprovar / Reprovar Orçamentos</a>
                    	</ul>
                    </div>
                	<ul>
                    	<div id="controle" class="verificaLogin">
                        <h2>Controle</h2>
                        <a id="solicitacoes" href="atualizar-valor-compras.php">Atualizar o Valor das Solicitações</a>
                        <a id="gerenciamento" href="fila.php">Gerenciamento e Triagem de Fila</a>
                        <a id="distribuicao" href="distribuicao-de-budget.php">Atualizar Budget de Merchandising</a>
                        <a id="budget" href="distribuicao-de-budget.php">Atualizar Buget de Brindes</a>
                        <a id="envio" href="envio-arte-aprovacao.php">Enviar Arte para Aprovação</a>
                        <a id="listagem" href="listagem-usuarios.php">Administrar Usuários</a>
                        <a id="materiais" href="administrar-materiais.php">Administrar Materiais</a>
                        <a id="trade" href="trade-home.php">Home da Criação</a>
                        <a id="finalizar" href="finalizar.php">Mandar para Fornecedor</a>
                        <a id="compra" href="finalizar-compra.php">Fechar compras</a>
                        <a id="historico" href="historico-cartao.php">Relatorios e historico de solicitações de cartões</a>
                        <a id="compras" href="historico.php">Historico de compras dos usuarios</a>    
                        <a id="cartao" href="cartoes.php">Pedidos de cartões</a>
                        <a id="cartao" href="cadastro-lojas.php">Gerenciamento de Lojas</a>
                        </div>
                    </ul>
                	<ul>
                        <h2>Histórico</h2>
                        <a href="historico.php">Minhas Compras Realizadas</a>
                        <a href="rastreio.php">Rastrear Meus Pedidos</a>
                        <a href="historico-sms.php">Meus Envios de SMS</a>
                        <a href="historico-producao.php">Pedidos que estão com fornecedor</a>
                        <a href="historico-novo-cartao.php">Meus Pedidos de Arte de Novo Cartão</a>
                    </ul>
                	<ul>
                    <div id="conta" class="verificaLogin">
                        <h2>Minha Conta</h2>
                        <a id="alterarDados" href="alterar-dados.php">Atualizar Dados Pessoais e de Acesso</a>
                    </div>
                    </ul>
                	<ul>
                        <h2>Sair</h2>
                        <a href="sair.php">Sair do Sistema</a>
                    </ul>
                </nav>
            </li>
            
        </ul>
    </div>
</header>
<form class="categoria" action="todos-os-materiais.php" method="post">
<header style="background:#f37021" class="clear bgBranco">
	<div  class="centro AjustaMenu">
	<ul class="left menuPrincipal">
    	<li >Checkout
        	<nav style="background:#EF8D52" class="subMenu bgLaranjaClaro branco">
            	 <ul>
                	<a id="1" href="#">Pinpad</a>
                   	<a id="2" href="#">Orelha de Micro</a>
                    <a id="3" href="#">Saia de PDV (Adesivo Lam)</a> 
                    <a id="4" href="#">Saia de PDV (Imantado)</a> 
                    <a id="5" href="#">Separador de Compra</a> 
                    <a id="6" href="#">Mobile PVC (Acima 500un)</a>
                    </ul>
                    <ul> 
                    <a id="7" href="#">Arte Monitor</a> 
                    <a id="8" href="#">Flyer (Acima de 1000)</a> 
                    <a id="9" href="#">Placa L  com Take one (Em Papel Resistente)</a> 
                    <a id="10" href="#">Placa L Informativa</a> 
                    <a id="11" href="#">Identificador de Checkout</a>
                    </ul>
                    <ul> 
                    <a id="12" href="#">Arte para uniforme loja</a> 
                    <a id="13" href="#">Arte Sacola</a> 
                    <a id="14" href="#">Arte Verso do Cupom fiscal</a> 
                    <a id="15" href="#">Aviso ou Placa de Informações (Placa PVC 2mm)</a> 
                    <a id="16" href="#">Colinha de Vendas</a> 
                    </ul>
                 
            
            </nav>
        </li>
    
    </ul>
    <ul class="left menuPrincipal">
    	<li>Balcão
        	<nav style="background:#EF8D52" class="subMenu branco">
            <ul>
            		<a id="17" href="#">  Balcão de Vendas do Cartão</a>
                     <a id="18" href="#"> Balcão Atendimento ao Cliente</a>
                     <a id="19" href="#"> Balcão Guarda Volume</a>
                     <a id="20" href="#"> Placa de Identificação do Guarda Volumes (Placa3mm)</a> 
                     <a id="21" href="#"> Banner Padrão (Lona acabamento madeira  90x140)</a> 
           	
            </ul> 
            </nav>
        </li>
    
    </ul>
    <ul class="left menuPrincipal">
    	<li>Entrada Loja
        	<nav style="background:#EF8D52" class="subMenu branco">
            	<ul>
                	 <a id="22" href="#"> Capa de alarme (Tecido)</a>
                     <a id="23" href="#"> Cancela (Placa)</a>
                     <a id="24" href="#"> Cancela (Tecido)</a>
                     <a id="25" href="#"> Guarita</a>
                     <a id="26" href="#"> Banner (Acabamento em Madeira)</a>
                     <a id="27" href="#"> Faixa Externa Acima 2m de larg (Acabamento em Ilhós)</a>
                     </ul>
                     <ul>
                     <a id="28" href="#"> Faixa Externa Abaixo 2m de larg (Acabamento em madeira)</a>
                     <a id="29" href="#"> Faixa Interna Acima 2m de larg (Acabamento em Ilhós)</a>
                     <a id="30" href="#"> Faixa Interna Abaixo 2m de larg (Acabamento em madeira)</a>
                     <a id="31" href="#"> Faixa Externa Bolso de Ofertas (Acabamento em ilhós)</a>
                     <a id="32" href="#"> Vidros Frente de Loja</a>
                         <a id="70" href="#"> Diversos</a>
                     </ul>
                     <ul>
         
                     <a id="34" href="#"> Comunicação Terminal de Auto Atendimento</a>

                </ul>
            
            </nav>
        </li>
    
    </ul>
    <ul class="left menuPrincipal ">
    	<li>Gôndola
        	<nav style="background:#EF8D52" class="subMenu branco">
            <ul>
            
           		   <a id="35" href="#"> Stopper</a>
                   <a id="36" href="#"> Wobbler</a>
                   <a id="37" href="#"> Placa Setores (PVC)</a>
                   <a id="38" href="#"> Banner Aéreo </a>
                   </ul>
                   <ul>
                   <a id="42" href="#"> Precificador Papel (Acima de 1000un)</a>
                   <a id="43" href="#"> Precificador Plástico (Acima de 500un)</a>
            
            </ul>
            
            </nav>
        </li>
    
    </ul>
     <ul class="left menuPrincipal ">
    	<li>Apresentações e Treinamentos
        	<nav style="background:#EF8D52" class="subMenu branco">
            	<ul>
               		<a id="44" href="#"> Capa para Template</a>
                    <a id="45" href="#"> Miolo para Template</a>
                    <a id="46" href="#"> Colinha</a>
                </ul>
            
            </nav>
        </li>
    
    </ul>
    
    <ul class="left menuPrincipal">
    	<li>Campanhas
        	<nav style="background:#EF8D52" class="subMenu branco">
            	<ul>
               	 	<a id="47" href="#">Display Pirâmide (Acima de 500)</a>
                     <a id="48" href="#"> Regulamento</a>
                     <a id="49" href="#"> Banner Tamanho Padrão</a>
                     <a id="50" href="#"> Roleta com adesivo personalizado</a> 
                     <a id="51" href="#"> Urna em papel</a> 
                     <a id="52" href="#"> Mobile em papel (Acima de 1000)</a>
                     </ul>
                     <ul> 
                     <a id="53" href="#"> Wobbler em papel (Acima de 1000)</a> 
                     <a id="54" href="#"> Protetor de Tela para Monitor</a> 
                     <a id="55" href="#"> Publicação para facebook</a> 
                     <a id="56" href="#"> Cupom Promocional</a>
                         <a id="69" href="#"> Diversos</a>
                 
                </ul>
            
            </nav>
        </li>
    
    </ul>
    
    <ul class="left menuPrincipal">
    	<li>Digital
        	<nav style="background:#EF8D52" class="subMenu branco">
            <ul>
             <a id="57" href="#">E-mail Marketing</a> 
                     <a id="58" href="#"> Hotsite do Cartão</a> 
                     <a id="59" href="#"> Capa para Facebook</a> 
                     <a id="60" href="#"> Publicação para Facebook</a> 
                     <a id="61" href="#"> Imagem para passar em TV</a> 
            </ul>
            
            </nav>
        </li>
    
    </ul>
    
    <ul class="left menuPrincipal">
    	<li>Outros
        	<nav style="background:#EF8D52" class="subMenu branco">
            <ul>
                    <a id="62" href="#"> Placa de Setores (2mm)</a>
                    <a id="63" href="#"> Texto de Vinheta</a>
                    <a id="64" href="#"> Placa Campeões em Vendas com bolso formato 10x15.</a>
                    <a id="65" href="#">Tag</a>
                    <a id="66" href="#">Impressos</a>
                    <a id="67" href="#">Tratamento de Imagem</a>
                    <a id="68" href="#">Pacotes Fechados</a>
            </ul>
            
            </nav>
        </li>
    
    </ul>
    </div>
</header>
</form>

<section  class="clear bgBranco topo">
	<div class="centro ">
    
        
        <div style="z-index:0" class="largura100 right bannerRotativo">
        	<div class="bannerProduto"><div><img style=" margin-top: -53px" src="img/teste/banner_guardasol.jpg"></div></div>
            <div class="bannerProduto"><div><img style=" margin-top: -53px" src="img/teste/banner_guardasol-02.jpg"></div></div>
            <div class="bannerProduto"><div><img style=" margin-top: -53px" src="img/teste/banner_guardasol-03.jpg"></div></div>

        	
        </div>
        
        
        <div class="largura70 right">
        	<a href="carrinho.php" class="btnAzul right">Ver Carrinho e Finalizar Compra</a>
            <a href="todos-os-materiais.php" style="margin-left:-298px" class="btnAzul left">Todos os materiais</a>
        </div>
    </div>
</section>

