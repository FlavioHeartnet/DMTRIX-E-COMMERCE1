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

        <h2>Gerenciamento da fila de Brindes</br><span>Aqui você ira controlar a fila de Brindes e mudar seus status.</span></h2>

        <div class="ui steps">

            <div class="step">
                <a class="step">
                    <i class="Sidebar icon"></i>
                    <div class="content">
                        <div class="title">1. Compras em Espera</div>
                        <div class="description">Pedidos que estão aguardadando analise</div>
                    </div>
                </a>
            </div>


            <div class=" step">
                <a class="step">
                    <i class="Tasks icon"></i>
                    <div class="content">
                        <div class="title">Em Preparação</div>
                        <div class="description">Os itens estão sendo preparados para retirada.</div>
                    </div>
                </a>
            </div>


            <div class=" step">
                <a class="step">
                    <i class="Paint Brush icon"></i>
                    <div class="content">
                        <div class="title">Em Pronto para retirada</div>
                        <div class="description">Os itens estão prontos para serem serem retirados</div>
                    </div>
                </a>
            </div>

            <div class=" step">
                <a class="step">
                    <i class="Checkmark icon"></i>
                    <div class="content">
                        <div class="title">Cancelados</div>
                        <div class="description">Itens que foram cancelados.</div>
                    </div>
                </a>
            </div>



        </div>
        <br>

        <div class="ui four column center aligned  divided grid">
            <div class=" column">

                <?php

                $query = odbc_exec($conexao, "select distinct c.idCompra, p.statusBrindes from PedidoBrindesDMTRIX p inner join ComprasBrindesDMTRIX c on c.idCompra = p.idCompra where p.statusBrindes = 2");
                while($rsQuery = odbc_fetch_array($query)){
                ?>

                <div class="column ui segment"><a onclick="Brindes(<?php echo $rsQuery['idCompra']; ?>,2,<?php echo $usuario ?>)" class="compra"  href="#"><?php echo $rsQuery['idCompra']; ?></a></div>

                <?php } ?>
            </div>
            <div class="column">

                <?php
                $query = odbc_exec($conexao, "select distinct c.idCompra, p.statusBrindes from PedidoBrindesDMTRIX p inner join ComprasBrindesDMTRIX c on c.idCompra = p.idCompra where p.statusBrindes = 3");
                while($rsQuery = odbc_fetch_array($query)){
                ?>

                    <div class="column ui segment"><a onclick="Brindes(<?php echo $rsQuery['idCompra']; ?>,3,<?php echo $usuario ?>)" class="compra"  href="#"><?php echo $rsQuery['idCompra']; ?></a></div>
                <?php } ?>

            </div>
            <div class="column">
                <?php
                $query = odbc_exec($conexao, "select distinct c.idCompra, p.statusBrindes from PedidoBrindesDMTRIX p inner join ComprasBrindesDMTRIX c on c.idCompra = p.idCompra where p.statusBrindes = 4");
                while($rsQuery = odbc_fetch_array($query)){
                ?>

                    <div class="column ui segment"><a onclick="Brindes(<?php echo $rsQuery['idCompra']; ?>,4,<?php echo $usuario ?>)" class="compra"  href="#"><?php echo $rsQuery['idCompra']; ?></a></div>
                <?php } ?>
            </div>
            <div class="column">
                <?php
                $query = odbc_exec($conexao, "select distinct c.idCompra, p.statusBrindes, c.status_compra from PedidoBrindesDMTRIX p inner join ComprasBrindesDMTRIX c on c.idCompra = p.idCompra where p.statusBrindes = 5");
                while($rsQuery = odbc_fetch_array($query)){
                    $statusCompra = $rsQuery['status_compra'];
                    if($statusCompra != 6)
                    {
                ?>
                    <div class="column ui segment"><a onclick="Brindes(<?php echo $rsQuery['idCompra']; ?>,5,<?php echo $usuario ?>)" class="compra"  href="#"><?php echo $rsQuery['idCompra']; ?></a></div>
                <?php }
                } ?>
            </div>

            </div>


        <div id="janela" class="ui basic modal">
            <i class="close icon"></i>

            <div id="resultado">


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


    $('.compra').click(function(){

        $('#janela')
            .modal('show');
    });

    function Brindes(valor,valor2,valor3) {
// Verificando Browser
        if(window.XMLHttpRequest) {
            req3 = new XMLHttpRequest();
        }
        else if(window.ActiveXObject) {
            req3 = new ActiveXObject("Microsoft.XMLHTTP");
        }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)


        var url = "controle/exibirBrindes.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3;


// Chamada do método open para processar a requisição
        req3.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
        req3.onreadystatechange = function() {

            // Exibe a mensagem "Buscando Noticias..." enquanto carrega
            if(req3.readyState == 1) {
                document.getElementById('resultado').innerHTML = '<div class="ui active inverted dimmer"> <div class="ui text loader">Carregando..</div> </div> <p></p>';
            }

            // Verifica se o Ajax realizou todas as operações corretamente
            if(req3.readyState == 4 && req3.status == 200) {

                // Resposta retornada pelo busca.php
                var resposta2 = req3.responseText;

                // Abaixo colocamos a(s) resposta(s) na div resultado
                document.getElementById('resultado').innerHTML = resposta2;
            }
        };
        req3.send(null);
    }


    function controleBrindes(valor,valor2,valor3,valor4) {

        var apagar = confirm('Deseja realmente cancelar este pedido?');
        if (apagar){
            // Verificando Browser
            if(window.XMLHttpRequest) {
                req3 = new XMLHttpRequest();
            }
            else if(window.ActiveXObject) {
                req3 = new ActiveXObject("Microsoft.XMLHTTP");
            }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
            var url = "controle/cancelarBrindes.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3;


// Chamada do método open para processar a requisição
            req3.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
            req3.onreadystatechange = function() {

                // Exibe a mensagem "Buscando Noticias..." enquanto carrega
                if(req3.readyState == 1) {
                    document.getElementById('pedidos'+valor4).innerHTML = '<div class="ui active inverted dimmer"> <div class="ui text loader">Carregando..</div> </div> <p></p>';
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
        }else{
            event.preventDefault();
        }


    }
    var req2;
    function delegarBrindes(valor,valor2,valor3,valor4)
    {
        var responsavel =  $("#criacao"+valor4).val();

// Verificando Browser
        if(window.XMLHttpRequest) {
            req2 = new XMLHttpRequest();
        }
        else if(window.ActiveXObject) {
            req2 = new ActiveXObject("Microsoft.XMLHTTP");
        }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)


            var url = "controle/delegarBrindes.php?valor=" + valor + "&valor2=" + valor2 + "&valor3=" + valor3 + "&valor4=" + responsavel;



// Chamada do método open para processar a requisição
        req2.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
        req2.onreadystatechange = function() {

            // Exibe a mensagem "Buscando Noticias..." enquanto carrega
            if(req2.readyState == 1) {
                document.getElementById('saidas'+valor4).innerHTML = '<div class="ui active inverted dimmer"> <div class="ui text loader">Delegando..</div> </div> <p></p>';
            }

            // Verifica se o Ajax realizou todas as operações corretamente
            if(req2.readyState == 4 && req2.status == 200) {

                // Resposta retornada pelo busca.php
                var resposta2 = req2.responseText;

                // Abaixo colocamos a(s) resposta(s) na div resultado
                document.getElementById('saidas'+valor4).innerHTML = resposta2;
            }
        };
        req2.send(null);
    }

</script>
    </body>
</html>