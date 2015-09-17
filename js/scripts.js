/*

1 - Filtragem de Resultados
Script utilizado para fazer um filtro de materiais da pesquisa realizada pelo usuário no topo da página.

2 - Some com a listagem
Some a listagem de produtos realizados no item 1

3 - Banner do topo
Banner rotativo no topo da página

4 - Barra de rolagem
Insere uma barra de rolagem personalizada no elemento 

5 - Perguntas Demétrios
Quando o usuário clica sobre a pergunta, aparece a resposta do lado direito da caixa

6 - Remove produto do Resumo do Pedido
Quando o usuário clica sobre o X no resumo do pedido, este item é removido da lista

7 - Esconde/Mostra Resumo do Pedido
Esconde ou Mostra a div Resumo do Pedido

8 - Enviar form após selecionar
Função para enviar o formulário no exato momento que o usuário selecionar o radio box na página de aprovação e reprovação de arte e orçamento

9 - Inicia jQuery UI em input#datepicker
Deixa todos os input#datepicker personalizados

10,11 - Funções do formulário de envio de SMS 

12 - Bloqueio de alguns caracteres para determinados campos

*/

jQuery(document).ready(function(e) {
	var data = new Date();
	// 1
    // Filtragem de Resultados
	jQuery("header form input[type='text']").keyup(function(){
		if((jQuery(this).val() != "") && (jQuery(this).val() != " ")){
			var texto = jQuery(this).val();
			jQuery("header form ul").stop().fadeIn();
			jQuery("header form ul a").each(function(){
				if(jQuery(this).text().toUpperCase().indexOf(texto.toUpperCase()) < 0){
					jQuery("header form ul").stop().fadeOut()
				};
			});
		}else{
			jQuery("header form ul").stop().fadeOut()
		};
	});
	
	// 2
	// Some com a listagem
	jQuery("header form input[type='text']").blur(function(){
		jQuery("header form ul").stop().fadeOut()
	});
	
	// 3
	// Banner do topo
	jQuery(".bannerRotativo").owlCarousel({
		autoWidth:true,
		loop:true,
		margin:200,
		center:true,
		dots:false,
		autoplay:true
	});
	
	// 4
	// Barra de rolagem
	jQuery(".listagemProdutosHome, .resumoPedido").jScrollPane();
	
	// 5
	// Perguntas Demétrios
	jQuery(".secao2 ul li").click(function(){
		jQuery(this).parent().children().removeClass("ativo");
		jQuery(this).toggleClass("ativo");
		titulo = jQuery(this).text();
		texto = jQuery(this).attr("title");
		jQuery(this).parent().parent().children(".right").children("h3").text(titulo);
		jQuery(this).parent().parent().children(".right").children("p").text(texto);
	});
	
	//6
	// Remove produto do Resumo do Pedido
	jQuery(".removerLinhaProduto").click(function(){
		
		var x = confirm('Tem certeza que deseja excluir!');
		if(x == true )
		{
		jQuery(this).parent("tr").parent("tbody").parent("table").parent("form").submit();
		jQuery(this).parent("tr").remove();
		if(jQuery(".resumoPedido tr").length < 1){
			jQuery(".resumoPedido table").append("<p>Nenhum Item no Carrinho</p>");
		}else{
			jQuery(".resumoPedido table p").remove();
		};
		
		
		}else{return false;}
		somaProdutos();
	});

//solicitação de um novo cartão, verificar redes

	jQuery("select[name='nomeRede']").change(function()
	{
		$("#rede").submit();
	});

	
	// 7
	// Esconde/Mostra Resumo do Pedido
	jQuery(".boxResumo h2 span").click(function(){
		sinal = jQuery(this).html();
		if(sinal == "--"){ jQuery(this).html("+"); }else{ jQuery(this).html("--"); };
		jQuery(".boxResumo").toggleClass("escondido");
	});
	
	
	// Enviar form após selecionar o radio
		
		jQuery("input[name='aprovarOrcamento']").click(function(){
			jQuery(".msgAlerta").html("Aguarde...").slideDown();
			jQuery(this).parent("form").submit();

			});
					
			jQuery("input[name='aprovarArte']").click(function(){
				jQuery(".msgAlerta").html("Aguarde...").slideDown();
				jQuery(this).parent("form").submit();
				});
			
				
		// botão da home para os pedidos da DICA
		
		jQuery("input[name='carrinho']").click(function(){
			
			if(jQuery("input[type='checkbox']").val() == "")
			{
				alert('favor selecionar os item a serem inclusos no carrinho!');
				return false;
			}
			
			
			
			})	
		
	/*jQuery("select[name='loja[]']").change(function(){
		
			valor= jQuery(this).val();
			alert('idLoja: '+valor);  valores do sms ao selecionar uma loja
		
		});
			*/	
	jQuery("input[name='ReprovarOrcamento']").click(function()
		{
			$(this).toggleClass("active").next().next().next().slideToggle('slow');
		});
	
		jQuery("input[name='ReaprovarArte']").click(function(){
			
			$(this).toggleClass("active").next().next().next().slideDown('slow'); 
			
		});
		
		//fila, esconder itens
		
		$("#compra1").click(function(){
			
			jQuery(this).toggleClass("active").next().slideToggle('slow'); 
			
			});
			$("#data1").click(function(){
			
			jQuery(this).toggleClass("active").next().slideToggle('slow');

			
			});
			

			
	//mudar o botão trabalhar home-trade

	jQuery("input[name='trabalhar']").click(function(){
		
		if(jQuery(this).val() == "Trabalhar"){
	
		jQuery(this).prev().removeAttr("style")	
			
		}else if(jQuery(this).val() == "Pausar"){
				jQuery(this).prev().removeAttr("style")	
				

			}else{alert('deu errado')}
		})		
	
	//remover Box Resumo
	function RemoveBox()
	{
		$("#boxResumo div").removeClass("boxResumo");
	}
	
	// 9
	// Inicia jQuery UI em input#datepicker
	if((data.getHours() >= 0) && (data.getHours() <= 12)){
		jQuery("input.datepicker").multiDatesPicker({
			dateFormat: 'dd-mm-yy',
			minDate: 2
		});
	}else{
		jQuery("input.datepicker").multiDatesPicker({
			dateFormat: 'dd-mm-yy',
			minDate: 3
		});
	};
	
	jQuery("input.datepicker2").multiDatesPicker({dateFormat: 'dd-mm-yy'});
	
	// 10 - adicionar lojas e redes no SMS
	jQuery("input[name='addCampoLojas']").click(function(){
		jQuery(this).parent("td").prev("td").children().first().clone().appendTo(".listagemUnidadesLojas tr td:first");
		jQuery(".listagemUnidadesLojas tr td .campo").css({"margin-top":"5px"});
		return false;
	});
	jQuery("input[name='addCampoLojas2']").click(function(){
		jQuery(this).parent("td").prev("td").children().first().clone().appendTo(".listagemUnidadesLojas2 tr td:first");
		jQuery(".listagemUnidadesLojas2 tr td .campo").css({"margin-top":"5px"});
		return false;
	});
	jQuery("input[name='addCampoMateriais']").click(function(){
		jQuery(this).parent("td").parent("tr").parent("tfoot").prev("tbody.listaMateriaisExtras").children("tr:first").clone().appendTo("tbody.listaMateriaisExtras");
		return false;
	});
	
	//selecionar a loja baseado na rede
	function loja()
	{
		valor = jQuery("select[name='rede']").val();
		jQuery("input[name='rede']").val(valor);
	}
	
	// 11
	jQuery("input[name='inserirValor']").click(function(){
		palavra = jQuery(this).attr("alt");
		qtdPalavra = parseInt(palavra.length);
		textoAtual = jQuery("textarea[name='mensagemSMS']").val();
		qtdTextoAtual = parseInt(textoAtual.length);
		
		if((qtdTextoAtual + qtdPalavra) <= 160){
			jQuery("textarea[name='mensagemSMS']").val(textoAtual + palavra);
			jQuery("textarea[name='mensagemSMS']").focus();
			contaCaracteres();
		}else{
			return false;
		};
	});
	
	// 12
	jQuery("textarea[name='mensagemSMS']").filter_input({regex:'[ A-z0-9,./()?!_-]'});
	jQuery("input[name='usuario'], input[name='senha']").filter_input({regex:'[A-z0-9]'});
	
	//caixa de seleção de todos os materiais
	jQuery("input[name='selecionarMaterial']").click(function(){
		if(jQuery(this).hasClass('abreBox'))
		{	
		jQuery(".todosMateriais table").hide();
		jQuery("input[name='addCarrinho']").hide();
		jQuery(".boxMaterial").css({"background":"#fff"});
		jQuery("input[name='selecionarMaterial']").val("Selecionar");
		jQuery(this).prev("table").slideDown().parent(".clear").parent(".boxMaterial").css({"background":"#f1f1f1"});
		jQuery(this).val("Adicionar ao Carrinho");
		jQuery(this).removeClass('abreBox');
		
		return false;

		}else{
			dataIdMaterial = jQuery(this).attr("data-idMaterial");
			
			if(jQuery("input[data-idMaterial='" + dataIdMaterial + "'][name='largura']").val() == "")
			{
				alert("Preencha o campo largura");
				return false;

			}else{return true};
			if(jQuery("input[data-idMaterial='" + dataIdMaterial + "'][name='altura']").val() == "")
			{
				alert("Preencha o campo Altura");
				return false;
			}else{return true};
			
			if(jQuery("input[data-idMaterial='" + dataIdMaterial + "'][name='quantidade']").val() == "")
			{
				alert("Preencha o campo Quantidade");
				return false;
			}else{return true};

			return true;
		};
	});
	
});




//caixa para os brindes

jQuery("input[name='ComprarBrinde']").click(function(){
	
		if(jQuery(this).hasClass('abreBox'))
		{	
		jQuery(".todosMateriais table").hide();
		jQuery("input[name='addCarrinho']").hide();
		jQuery(".boxMaterial").css({"background":"#fff"});
		jQuery("input[name='ComprarBrinde']").val("Selecionar");
		jQuery(this).prev("table").slideDown().parent(".clear").parent(".boxMaterial").css({"background":"#f1f1f1"});
		jQuery(this).val("Comprar Brinde");
		jQuery(this).removeClass('abreBox');
		
		return false;
		}else
		{
			dataIdBrinde = jQuery(this).attr("data-idBrinde");
			if(jQuery("input[data-idBrinde='" + dataIdBrinde + "'][name='quantidade']").val() == "")
			{
				alert("Preencha o campo quantidade");
				return false;

			}else{return true};
			
			if(jQuery("input[data-idBrinde='" + dataIdBrinde + "'][name='MotivoCompra']").val() == "")
			{
				alert("Preencha o Motivo da Compra");
				return false;

			}else{return true};
		}

	});

function pedidos(){
	if(jQuery("input[name='Status_pedido']").val() == 2){
	jQuery('#status').removeAttr("style", "display:none");

	}else if(jQuery("input[name='Status_pedido']").val() == 3 || jQuery("input[name='Status_pedido']").val() == 4 )
	{
		jQuery('#status3').removeAttr("style", "display:none");
		
	}else if(jQuery("input[name='Status_pedido']").val() == 5)
	{
		jQuery('#status5').removeAttr("style", "display:none");
		
	}else if(jQuery("input[name='Status_pedido']").val() == 6 || jQuery("input[name='Status_pedido']").val() == 7)
	{
		jQuery('#status6').removeAttr("style", "display:none");
		
	}

}






jQuery("input[name='briefing']").click(function(){
	
		
		if(jQuery("select[name='custeio']").val() == "" || jQuery("select[name='formaPagamento']").val() == "" || jQuery("select[name='segmento']").val() == "" || jQuery("select[name='loja']").val() == "" )
		{
			alert('Preencha os dados de pagamento.');
			return false;
		}

		
	});
//loading de atualização
function mostra(){
if(window.onload){
	document.getElementById('lendo').style.display="none";
	document.getElementById('conteudo').style.visibility="visible";
	
	}	
}

function NovoValor(){
		arrayValores = [];	
		soma = 0;
		jQuery('input[name="valorPedido[]"]').each(function() { 
		
		var valores = $(this).val();
		soma += parseFloat(valores.split("R$"));
	});
		
		jQuery(".NovoTotal span").text("R$" + soma.toFixed(2));
		jQuery("input[name='valorTotalnew']").val(soma.toFixed(2));	
		

}

function verificaLogin(){
	
	user = jQuery("input[name='nivel']").val();
	if(user ==4 || user == 3 || user == 5)
	{
		jQuery('#controle').attr("style","display:none");
		jQuery('#trade').attr("style","display:none");
		//jQuery('#conta').attr("style","display:none");
		
		
		
	}
	
	}
//tranformar numero do status em texto
function mudaStatus()
{
	semana = jQuery("input[name='semana']").val();
	
		if(status == "Sunday") {jQuery(".semana").text("Dommingo");}
		else if(semana == "Monday"){jQuery(".semana").text("Segunda-feira.");}
			
		else if(semana == "Tuesday"){jQuery(".semana").text("Terça-feira");}
				
		else if(semana == "Wednesday"){jQuery(".semana").text("Quarta-feira");}
			
		else if(semana == "Thursday"){jQuery(".semana").text("Quinta-feira");}
				
		else if(semana == "Friday"){ jQuery(".semana").text("Sexta-feira");}
		else if(semana == "Saturday"){jQuery(".semana").text("Sabado");}
				
		else{}
			
	
	
	
}



// Valor total no carrinho de compras
function somaProdutos(){
	valores = jQuery(".valorProduto").text();
	arrayValores = valores.split("R$");
	qtdValores = (arrayValores.length) - 1;
	soma = 0;	
	for(i = 1; i <= qtdValores; i++){
		arrayValores[i] = parseFloat(arrayValores[i]);
		soma += arrayValores[i];
	}
	
	if(jQuery("select[name='custeio']").val() == "50% Loja e 50% DMcard")
	{
		soma=soma/2;
		jQuery("select[name='formaPagamento']").val("");
		
	}else if(jQuery("select[name='custeio']").val() == "100% Loja")
	{
		soma = 0;
		jQuery("select[name='formaPagamento']").val("Sem Forma de Pagamento");
		
	}else if(jQuery("select[name='custeio']").val() == "100% DMcard")
	{
		jQuery("select[name='formaPagamento']").val("");
	}
	
	jQuery(".valorTotal span").text("R$" + soma.toFixed(2));
	jQuery("input[name='valorTotal']").val(soma.toFixed(2));
};


//pegar valor da categoria e jogar em todos-materiais

jQuery(".categoria a").click(function()
{
	 v = jQuery(this).attr("id")
	
	 
	jQuery(this).append("<input type='hidden' name='categoria' value='"+v+"'>");
	
	jQuery(".categoria").submit();
	
});


function contaCaracteres(){
	maximo = 147;
	qtd = jQuery("textarea[name='mensagemSMS']").val().length;
	jQuery("table tr td strong").text(maximo - qtd);
	if(jQuery("table tr td strong").text() <= 0){
		jQuery("table tr td.infoCaracteres").html("Você excedeu o limite de caracteres em <strong>" + (qtd - maximo) + "</strong>");
	}else{
		jQuery("table tr td.infoCaracteres").html("Você ainda pode digitar <strong>" + (maximo - qtd) + "</strong> caracteres");
	};
};

jQuery('#redeInexistente').hide();
jQuery("input[name='comrede']").click(function(){

    $("#redeInexistente").hide();
    $("#redeExitente").fadeIn(500);
    jQuery("input[name='semrede']").removeAttr("checked");
     jQuery("#rede2").attr('name','rede2');
    jQuery("#rede1").attr('name','rede');


});

jQuery("input[name='semrede']").click(function(){

    $("#redeExitente").hide();
    $("#redeInexistente").fadeIn(500);
    jQuery("input[name='comrede']").removeAttr("checked");
    jQuery("#rede1").attr('name','rede1');
    jQuery("#rede2").attr('name','rede');


});

var req;

function exibirConteudo(id) {

// Verificando Browser
    if(window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    }
    else if(window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

// Arquivo PHP juntamento com a id da noticia (método GET)
    var url = "controle/exibir.php?id="+id;

// Chamada do método open para processar a requisição
    req.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
    req.onreadystatechange = function() {

        // Exibe a mensagem "Aguarde..." enquanto carrega
        if(req.readyState == 1) {
            document.getElementById('conteudo').innerHTML = 'Aguarde...';
        }

        // Verifica se o Ajax realizou todas as operações corretamente
        if(req.readyState == 4 && req.status == 200) {

            // Resposta retornada pelo exibir.php
            var resposta = req.responseText;

            // Abaixo colocamos a resposta na div conteudo
            document.getElementById('conteudo').innerHTML = resposta;
        }
    }
    req.send(null);
}



// FUNÇÃO PARA BUSCA DADOS
function buscarNoticias(valor) {

// Verificando Browser
    if(window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    }
    else if(window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
    var url = "controle/busca.php?valor="+valor;

// Chamada do método open para processar a requisição
    req.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
    req.onreadystatechange = function() {

        // Exibe a mensagem "Buscando Noticias..." enquanto carrega
        if(req.readyState == 1) {
            document.getElementById('resultado').innerHTML = 'Buscando Lojas...';
        }

        // Verifica se o Ajax realizou todas as operações corretamente
        if(req.readyState == 4 && req.status == 200) {

            // Resposta retornada pelo busca.php
            var resposta2 = req.responseText;

            // Abaixo colocamos a(s) resposta(s) na div resultado
            document.getElementById('resultado').innerHTML = resposta2;
        }
    }
    req.send(null);
}

// Highchart - grafico da fila 


$(function () {

	numVezes = $("input[name='NrVezes']").val();
	nome = $("input[name='nome']").val();
	material = $("input[name='material']").val();
	qtd = numVezes.length;


    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Grafico de Produtos pedidos ?'
        },
        subtitle: {
            text: 'Fonte: CPD - Centro de Pesquisas DMCard - nº003/catálogo 7789-789 - Ano de 2014'
        },
        xAxis: {
            categories: ['Flavio'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '% de votos',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: '%'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: '#FFFFFF',
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [

            {
                name: "'"+valor+"'",
                data: [parseInt(pedido)]
            }, {
                name: "'"+valor1+"'",
                data: [parseInt(pedido1)]
            }]
    });
		

    });