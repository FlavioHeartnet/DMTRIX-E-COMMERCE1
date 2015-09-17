<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == "" ){ header("Location: index.php"); };
$nivel = $_SESSION['nivel'];
if($_SESSION['nivel'] == 1){}else if($_SESSION['nivel'] == 2) {}else {session_destroy(); header("Location: index.php");}
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $usuarioLogado['idUsuario'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/estilos-bibliotecas.css">
<link rel="stylesheet" type="text/css" href="css/css/semantic.css">

</head>

<body onLoad="verificaLogin()">
<?php include("topo.php"); ?>

<div class="centro">
	<div class="clear bgBranco secao1">



    <h2>Gerenciamento da fila de pedidos</br><span>Aqui você ira controlar a fila de pedidos feitos por consultores e delegar trabalhos.</span></h2>
    
    
    <!--espaço para por lista de usuario que mais estão pedindo -->
    <div><a href="#" class="modal">Click aqui e veja quantos pedidos os usuarios estão fazendo</a></div>

    <div id="incidencia" class="ui basic modal">
  
  <div class="header">
    Incidencia de Pedidios
  </div>
  <div class="content">
    <div class="image">
      <i class="archive icon"></i>
    </div>
    <div class="description">
      <p>Veja aqui quantos pedidos cada usuario esta fazendo!</p>
        <br>
      
      
      <?php 
	  $query = odbc_exec($conexao, "SELECT count(*) as NrVezes, u.nome, p.status_pedido FROM PedidoDMTRIX p inner join usuariosDMTRIX u on u.idUsuario = p.idUsuario GROUP BY u.nome, p.status_pedido  ORDER BY NrVezes DESC");
	  

	  
	  while($rsQuery = odbc_fetch_array($query)){
	  
	  	$status = $rsQuery['status_pedido'];
		$nome = $rsQuery['nome'];
	  	  $query2 = odbc_exec($conexao, "SELECT count(*) as NrVezes, u.nome, p.status_pedido, m.material FROM PedidoDMTRIX p inner join usuariosDMTRIX u on u.idUsuario = p.idUsuario inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial
  where u.nome = '$nome' and p.status_pedido != 1 GROUP BY u.nome, p.status_pedido, m.material  ORDER BY NrVezes DESC");
  
  
  while($rsQuery2 = odbc_fetch_array($query2))
  	{
		?>
        
        <input type="hidden" name="consultor[]" value="<?php echo $rsQuery2['nome']; ?>">
        <input type="hidden" name="NrVezes[]" value="<?php echo $rsQuery2['NrVezes']; ?>">
        <input type="hidden" name="material[]" value="<?php echo $rsQuery2['material']; ?>">
        
        <?php
	}
	  if($status != 1){
	  
	  
	  ?>
      
      <table class="ui table" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
      <tr>
      
      		<td>Numero de Pedidos</td>
            <td>Nome do Usuario</td>
      
      </tr>
      
      <tr>
      
      		<td><?php echo $rsQuery['NrVezes']; ?></td>
            <td>
    <div class="ui styled accordion">
    <div class="active title">
      <i class="dropdown icon"></i>
      <?php echo $rsQuery['nome']; ?>
    </div>
    <div class="active content">
      <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
    </div>
           

            </td>
      
      </tr>
      
      </table>

      <?php }

	  }

	  ?>
    </div>
  </div>

</div>

    <div class="ui steps">

        <div class="step">
            <a class="step">
                <i class="Sidebar icon"></i>
                <div class="content">
                    <div class="title">1. Compras em Espera</div>
                    <div class="description">Pedidos que não foram atualizados os valores e estão aguardando aprovação</div>
                </div>
            </a>
        </div>


        <div class=" step">
            <a class="step">
                <i class="Tasks icon"></i>
                <div class="content">
                    <div class="title">Em Aberto</div>
                    <div class="description">Itens Aprovados que não foram delegados ainda.</div>
                </div>
            </a>
        </div>


        <div class=" step">
            <a class="step">
                <i class="Paint Brush icon"></i>
                <div class="content">
                    <div class="title">Fabricação</div>
                    <div class="description">Itens sendo atendidos pela criação.</div>
                </div>
            </a>
        </div>

        <div class=" step">
            <a class="step">
                <i class="Checkmark icon"></i>
                <div class="content">
                    <div class="title">Artes Aprovadas</div>
                    <div class="description">Itens onde o cliente aprovou a peça.</div>
                </div>
            </a>
        </div>

        

    </div>


<br>

    <div class="ui four column center aligned  divided grid">
        <div class=" column">

            <?php

            if(isset($_POST['compra']))
            {

                $Compra = $_POST['valor'];

                $buscaCompras = odbc_exec($conexao, "select distinct c.idCompra, p.status_pedido  from ComprasDMTRIX c inner join PedidoDMTRIX p on p.idCompra = c.idCompra inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join usuariosDMTRIX u
  on u.idUsuario = p.idUsuario inner join lojasDMTRIX l on l.idLoja = p.idLoja where c.status_compra = 'Em analise' or c.status_compra = 'aprovacoes' and c.idCompra = '$Compra'");

            }else{
                $buscaCompras = odbc_exec($conexao, "select distinct c.idCompra, p.status_pedido from ComprasDMTRIX c inner join PedidoDMTRIX p on p.idCompra = c.idCompra inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join usuariosDMTRIX u
  on u.idUsuario = p.idUsuario inner join lojasDMTRIX l on l.idLoja = p.idLoja where c.status_compra = 'Em analise' or c.status_compra = 'aprovacoes'");
            }

            $count = odbc_num_rows($buscaCompras);

            while($rsBuscaCompra = odbc_fetch_array($buscaCompras)){

            $status = $rsBuscaCompra['status_pedido'];


            if($status == 2 || $status == 4 || $status == 9 ){
            ?>

            <div class="column ui segment"><a onclick="buscarPedido(<?php echo $rsBuscaCompra['idCompra']  ?>,<?php echo $usuario; ?>,1,0)" class="compra"  href="#"><?php echo $rsBuscaCompra['idCompra']; ?></a></div>
            <?php }
            } ?>



        </div>

        <div class="column">
            <?php

            if(isset($_POST['aberto'])){

                $Compra = $_POST['id2'];

                $buscaCompras = odbc_exec($conexao, "select distinct c.idCompra, p.status_pedido, c.Prioridade from ComprasDMTRIX c inner join PedidoDMTRIX p on p.idCompra = c.idCompra inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join usuariosDMTRIX u
  on u.idUsuario = p.idUsuario inner join lojasDMTRIX l on l.idLoja = p.idLoja where c.idCompra = '$Compra'");

            }else
            {

                $buscaCompras = odbc_exec($conexao, "select distinct c.idCompra, p.status_pedido, c.Prioridade from ComprasDMTRIX c inner join PedidoDMTRIX p on p.idCompra = c.idCompra inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join usuariosDMTRIX u
  on u.idUsuario = p.idUsuario inner join lojasDMTRIX l on l.idLoja = p.idLoja");

            }
            $count = odbc_num_rows($buscaCompras);
            $i=1;


            while($rsBuscaCompra = odbc_fetch_array($buscaCompras)){

            $status = $rsBuscaCompra['status_pedido'];
            $prioridade = $rsBuscaCompra['Prioridade'];

                switch($prioridade)
                {
                    case 1: $color = "red"; break;
                    case 2: $color = "yellow"; break;
                    case 3: $color = "green"; break;
                    default: $color = "";
                }

            if($status == 3){
            ?>

            <div class="column ui segment <?php echo $color ?>" id="<?php echo $rsBuscaCompra['idCompra']; ?>" ><a onclick="buscarPedido(<?php echo $rsBuscaCompra['idCompra']  ?>,<?php echo $usuario; ?>,2,0)" class="compra"  href="#"><?php echo $rsBuscaCompra['idCompra']; ?></a></div>
                <div class="ui flowing popup top left transition hidden">
                    <div class="ui three column divided center aligned grid">
                        <div class="column red">
                            <h4 class="ui header">Prioridade Alta</h4>
                            <p><b>1</b> representado na cor Vermelha</p>
                            <div class="ui button red" onclick="mudarCor(<?php echo $rsBuscaCompra['idCompra']; ?>,1)">selecionar</div>
                        </div>
                        <div class="column yellow">
                            <h4 class="ui header">Prioridade Media</h4>
                            <p><b>2</b> representado na cor Amarela</p>
                            <div class="ui button yellow" onclick="mudarCor(<?php echo $rsBuscaCompra['idCompra']; ?>,2)">selecionar</div>
                        </div>
                        <div class="column green">
                            <h4 class="ui header">Prioridade Baixa</h4>
                            <p><b>3</b> representado na cor Verde</p>
                            <div class="ui button green" onclick="mudarCor(<?php echo $rsBuscaCompra['idCompra']; ?>,3)">selecionar</div>
                        </div>
                    </div>
                </div>

            <?php }
            }
            ?>
        </div>

        <div class=" column">

            <?php

            if(isset($_POST['fabrica'])){

                $Compra = $_POST['id3'];

                $buscaCompras = odbc_exec($conexao, " select DISTINCT p.idCompra, p.status_pedido, c.Prioridade  from [MARKETING].[dbo].[tarefasDMTRIX] t
  inner join usuariosDMTRIX u on u.idUsuario = t.idUsuario inner join PedidoDMTRIX p on p.idPedido = t.idPedido
  inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join lojasDMTRIX l on l.idLoja = p.idLoja inner join ComprasDMTRIX c on p.idCompra = c.idCompra where   p.idCompra = '$Compra'");


            }else
            {
                $buscaCompras = odbc_exec($conexao, "  select DISTINCT p.idCompra, p.status_pedido, c.Prioridade from tarefasDMTRIX t
  inner join usuariosDMTRIX u on u.idUsuario = t.idUsuario inner join PedidoDMTRIX p on p.idPedido = t.idPedido
  inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join lojasDMTRIX l on l.idLoja = p.idLoja inner join ComprasDMTRIX c on p.idCompra = c.idCompra  ");

            }
            $count = odbc_num_rows($buscaCompras);

            while($rsBuscaCompra = odbc_fetch_array($buscaCompras)){

            $status = $rsBuscaCompra['status_pedido'];
                $prioridade = $rsBuscaCompra['Prioridade'];
                switch($prioridade)
                {
                    case 1: $color = "red"; break;
                    case 2: $color = "yellow"; break;
                    case 3: $color = "green"; break;
                    default: $color = "";
                }

                if($status == 5 or $status == 7){
            ?>

                <div class="column ui segment <?php echo $color ?>" id="<?php echo $rsBuscaCompra['idCompra']; ?>" ><a onclick="buscarPedido(<?php echo $rsBuscaCompra['idCompra']  ?>,<?php echo $usuario; ?>,3,0)" class="compra" href="#"><?php echo $rsBuscaCompra['idCompra']; ?></a></div>
                <div class="ui flowing popup top left transition hidden">
                    <div class="ui three column divided center aligned grid">
                        <div class="column red">
                            <h4 class="ui header">Prioridade Alta</h4>
                            <p><b>1</b> representado na cor Vermelha</p>
                            <div class="ui button red" onclick="mudarCor(<?php echo $rsBuscaCompra['idCompra']; ?>,1)">selecionar</div>
                        </div>
                        <div class="column yellow">
                            <h4 class="ui header">Prioridade Media</h4>
                            <p><b>2</b> representado na cor Amarela</p>
                            <div class="ui button yellow" onclick="mudarCor(<?php echo $rsBuscaCompra['idCompra']; ?>,2)">selecionar</div>
                        </div>
                        <div class="column green">
                            <h4 class="ui header">Prioridade Baixa</h4>
                            <p><b>3</b> representado na cor Verde</p>
                            <div class="ui button green" onclick="mudarCor(<?php echo $rsBuscaCompra['idCompra']; ?>,3)">selecionar</div>
                        </div>
                    </div>
                </div>

            <?php }
            }
            ?>

        </div>

        <div class=" column">

            <?php
            if(isset($_POST['fabrica'])){

                $Compra = $_POST['id3'];

                $buscaCompras = odbc_exec($conexao, " select DISTINCT p.idCompra, p.status_pedido, c.Prioridade  from [MARKETING].[dbo].[tarefasDMTRIX] t
  inner join usuariosDMTRIX u on u.idUsuario = t.idUsuario inner join PedidoDMTRIX p on p.idPedido = t.idPedido
  inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join lojasDMTRIX l on l.idLoja = p.idLoja inner join ComprasDMTRIX c on p.idCompra = c.idCompra where   p.idCompra = '$Compra'");


            }else
            {
                $buscaCompras = odbc_exec($conexao, "  select DISTINCT p.idCompra, p.status_pedido, c.Prioridade from tarefasDMTRIX t
  inner join usuariosDMTRIX u on u.idUsuario = t.idUsuario inner join PedidoDMTRIX p on p.idPedido = t.idPedido
  inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join lojasDMTRIX l on l.idLoja = p.idLoja inner join ComprasDMTRIX c on p.idCompra = c.idCompra  ");

            }
            $count = odbc_num_rows($buscaCompras);

            while($rsBuscaCompra = odbc_fetch_array($buscaCompras)){

            $status = $rsBuscaCompra['status_pedido'];
            $prioridade = $rsBuscaCompra['Prioridade'];
            switch($prioridade)
            {
                case 1: $color = "red"; break;
                case 2: $color = "yellow"; break;
                case 3: $color = "green"; break;
                default: $color = "";
            }

            if($status == 6 ){

            ?>

                <div class="column ui segment <?php echo $color ?>" id="<?php echo $rsBuscaCompra['idCompra']; ?>" ><a onclick="buscarPedido(<?php echo $rsBuscaCompra['idCompra']  ?>,<?php echo $usuario; ?>,4,0)" class="compra" href="#"><?php echo $rsBuscaCompra['idCompra']; ?></a></div>

            <?php }
            }
            ?>

        </div>
        <div id="janela" class="ui basic modal">
            <i class="close icon"></i>

            <div id="resultado">





            </div>



        </div>

        </div>


    </div>

    <?php include("rodape.php"); ?>

</div>


<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/grafico/js/highcharts.js"></script>
<script type="text/javascript" src="js/grafico/js/modules/exporting.js"></script>
<script src="js/js/semantic.js"></script>
<script type="text/javascript">
   /* $('.modal').click(function(){


        $('#incidencia')
            .modal('show');


    });*/
		
		$('.ui.accordion')
  .accordion()
;

    $('.segment')
        .popup({
            inline   : true,
            hoverable: true,

            delay: {
                show: 100,
                hide: 200
            }
        })
    ;


    $('.checkbox').checkbox();

    var req;
    function mudarCor(idCompra,cor) {

// Verificando Browser
        if(window.XMLHttpRequest) {
            req = new XMLHttpRequest();
        }
        else if(window.ActiveXObject) {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
        var url = "controle/prioridades.php?valor="+idCompra+"&valor2="+cor;


// Chamada do método open para processar a requisição
        req.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
        req.onreadystatechange = function() {

            // Exibe a mensagem "Buscando Noticias..." enquanto carrega
            if(req.readyState == 1) {
                document.getElementById(idCompra).innerHTML = 'salvando prioridade...';
            }

            // Verifica se o Ajax realizou todas as operações corretamente
            if(req.readyState == 4 && req.status == 200) {

                // Resposta retornada pelo busca.php
                var resposta2 = req.responseText;

                $('#'+idCompra).removeClass();
                $('#'+idCompra).addClass(resposta2+ ' column ui segment');
            }
        };
        req.send(null);
    }

    var req2;

    function buscarPedido(valor,valor2,valor3,valor4) {

// Verificando Browser
        if(window.XMLHttpRequest) {
            req2 = new XMLHttpRequest();
        }
        else if(window.ActiveXObject) {
            req2 = new ActiveXObject("Microsoft.XMLHTTP");
        }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
        var url = "controle/exibirFila.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3+"&valor4="+valor4;


// Chamada do método open para processar a requisição
        req2.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
        req2.onreadystatechange = function() {

            // Exibe a mensagem "Buscando Noticias..." enquanto carrega
            if(req2.readyState == 1) {
                document.getElementById('resultado').innerHTML = 'Buscando pedidos...';
            }

            // Verifica se o Ajax realizou todas as operações corretamente
            if(req2.readyState == 4 && req2.status == 200) {

                // Resposta retornada pelo busca.php
                var resposta2 = req2.responseText;

                // Abaixo colocamos a(s) resposta(s) na div resultado
                document.getElementById('resultado').innerHTML = resposta2;
            }
        };
        req2.send(null);
    }
var req3;

   function delegar(valor,valor2,valor3,valor4) {

     var responsavel =  $("#criacao"+valor4).val();

// Verificando Browser
       if(window.XMLHttpRequest) {
           req3 = new XMLHttpRequest();
       }
       else if(window.ActiveXObject) {
           req3 = new ActiveXObject("Microsoft.XMLHTTP");
       }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
       var url = "controle/delegar.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3+"&valor4="+responsavel;


// Chamada do método open para processar a requisição
       req3.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
       req3.onreadystatechange = function() {

           // Exibe a mensagem "Buscando Noticias..." enquanto carrega
           if(req3.readyState == 1) {
               document.getElementById('saida'+valor4).innerHTML = 'Delegando...';
           }

           // Verifica se o Ajax realizou todas as operações corretamente
           if(req3.readyState == 4 && req3.status == 200) {

               // Resposta retornada pelo busca.php
               var resposta2 = req3.responseText;

               // Abaixo colocamos a(s) resposta(s) na div resultado
               document.getElementById('saida'+valor4).innerHTML = resposta2;
           }
       };
       req3.send(null);
   }

   function delegar1(valor,valor2,valor3,valor4) {

       var responsavel =  $("#criacao"+valor4).val();

// Verificando Browser
       if(window.XMLHttpRequest) {
           req3 = new XMLHttpRequest();
       }
       else if(window.ActiveXObject) {
           req3 = new ActiveXObject("Microsoft.XMLHTTP");
       }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
       var url = "controle/delegar.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3+"&valor4="+responsavel;


// Chamada do método open para processar a requisição
       req3.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
       req3.onreadystatechange = function() {

           // Exibe a mensagem "Buscando Noticias..." enquanto carrega
           if(req3.readyState == 1) {
               document.getElementById('saida'+valor4).innerHTML = 'Delegando...';
           }

           // Verifica se o Ajax realizou todas as operações corretamente
           if(req3.readyState == 4 && req3.status == 200) {

               // Resposta retornada pelo busca.php
               var resposta2 = req3.responseText;

               // Abaixo colocamos a(s) resposta(s) na div resultado
               document.getElementById('saida'+valor4).innerHTML = resposta2;
           }
       };
       req3.send(null);
   }

    $('.compra').click(function(){

        $('#janela')
            .modal('show');


    });

   function controlePedidos(valor,valor2,valor3,valor4) {



// Verificando Browser
       if(window.XMLHttpRequest) {
           req3 = new XMLHttpRequest();
       }
       else if(window.ActiveXObject) {
           req3 = new ActiveXObject("Microsoft.XMLHTTP");
       }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
       var url = "controle/controlePedidos.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3;


// Chamada do método open para processar a requisição
       req3.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
       req3.onreadystatechange = function() {

           // Exibe a mensagem "Buscando Noticias..." enquanto carrega
           if(req3.readyState == 1) {
               document.getElementById('pedidos'+valor4).innerHTML = 'Aprovando...';
           }

           // Verifica se o Ajax realizou todas as operações corretamente
           if(req3.readyState == 4 && req3.status == 200) {

               // Resposta retornada pelo busca.php
               var resposta2 = req3.responseText;

               // Abaixo colocamos a(s) resposta(s) na div resultado
               document.getElementById('pedidos'+valor4).innerHTML = resposta2;
           }
       };
       req3.send(null);
   }
   function controlePedidos1(valor,valor2,valor3,valor4) {



// Verificando Browser
       if(window.XMLHttpRequest) {
           req3 = new XMLHttpRequest();
       }
       else if(window.ActiveXObject) {
           req3 = new ActiveXObject("Microsoft.XMLHTTP");
       }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
       var url = "controle/controlePedidos.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3;


// Chamada do método open para processar a requisição
       req3.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
       req3.onreadystatechange = function() {

           // Exibe a mensagem "Buscando Noticias..." enquanto carrega
           if(req3.readyState == 1) {
               document.getElementById('pedidos'+valor4).innerHTML = 'Aprovando...';
           }

           // Verifica se o Ajax realizou todas as operações corretamente
           if(req3.readyState == 4 && req3.status == 200) {

               // Resposta retornada pelo busca.php
               var resposta2 = req3.responseText;

               // Abaixo colocamos a(s) resposta(s) na div resultado
               document.getElementById('pedidos'+valor4).innerHTML = resposta2;
           }
       };
       req3.send(null);
   }
   function controlePedidos2(valor,valor2,valor3,valor4) {



// Verificando Browser
       if(window.XMLHttpRequest) {
           req3 = new XMLHttpRequest();
       }
       else if(window.ActiveXObject) {
           req3 = new ActiveXObject("Microsoft.XMLHTTP");
       }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
       var url = "controle/controlePedidos.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3;


// Chamada do método open para processar a requisição
       req3.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
       req3.onreadystatechange = function() {

           // Exibe a mensagem "Buscando Noticias..." enquanto carrega
           if(req3.readyState == 1) {
               document.getElementById('pedidos'+valor4).innerHTML = 'Aprovando...';
           }

           // Verifica se o Ajax realizou todas as operações corretamente
           if(req3.readyState == 4 && req3.status == 200) {

               // Resposta retornada pelo busca.php
               var resposta2 = req3.responseText;

               // Abaixo colocamos a(s) resposta(s) na div resultado
               document.getElementById('pedidos'+valor4).innerHTML = resposta2;
           }
       };
       req3.send(null);
   }

</script>


</body>
</html>