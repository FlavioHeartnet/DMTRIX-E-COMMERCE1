<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == "" ){ header("Location: index.php"); };
$nivel = $_SESSION['nivel'];
if($_SESSION['nivel'] == 1){}else if($_SESSION['nivel'] == 2) {}else {session_destroy(); header("Location: index.php");}
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $usuarioLogado['idUsuario'];
$nome = $usuarioLogado['nome']." ".$usuarioLogado['sobrenome'];

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>DMTrix</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/estilos-bibliotecas.css">
    <link rel="stylesheet" type="text/css" href="css/css/semantic.css">
    <script src="js/modernizr.custom.js"></script>
</head>

<body onLoad="verificaLogin()">
<?php include("topo.php"); ?>

<div class="centro">
<div class="clear bgBranco secao1 aprovar-reprovar">
    <h2>Bem - vindo </br><span>Veja aqui suas solicitações pendentes, em aberto e em andamento.</span></h2>




    <div class="ui steps">

        <div class="step">
            <a class="step">
                <i class="Paint Brush icon"></i>
                <div class="content">
                    <div class="title">Fabricação</div>
                    <div class="description">Veja as artes em aberto para serem feitas.</div>
                </div>
            </a>
        </div>


        <div class=" step">
            <a class="step">
                <i class="payment icon"></i>
                <div class="content">
                    <div class="title">Aguardando aprovação</div>
                    <div class="description">Itens finalizados aguardadndo aprovação do cliente.</div>
                </div>
            </a>
        </div>


        <div class=" step">
            <a class="step">
                <i class="Remove User icon"></i>
                <div class="content">
                    <div class="title">Reprovados</div>
                    <div class="description">Itens reprovados pelo cliente.</div>
                </div>
            </a>
        </div>


        <div class="step">
            <a class="step">
                <i class="Checkmark icon"></i>
                <div class="content">
                    <div class="title">aprovados</div>
                    <div class="description">Itens aprovados pelo cliente.</div>
                </div>
            </a>
        </div>

    </div>
    <br>

    <div class="ui four column center aligned  divided grid">
        <div class=" column">
            <div id="" class="grid clearfix">

                <?php

                $sql = odbc_exec($conexao, "select distinct p.idCompra, c.Prioridade from tarefasDMTRIX t inner join PedidoDMTRIX p on t.idPedido = p.idPedido inner join ComprasDMTRIX c  on c.idCompra = p.idCompra  where p.status_pedido = 5 and t.idUsuario = '$usuario' ");

                while($rsSql = odbc_fetch_array($sql)){

                    $idCompra = $rsSql['idCompra'];
                    $ValidaPedidos = odbc_exec($conexao, "select * from PedidoDMTRIX where idCompra = '$idCompra' and status_pedido = 5");
                    $count = odbc_num_rows($ValidaPedidos);
                    $contador = 0;
                    while($RSvalidaPedidos = odbc_fetch_array($ValidaPedidos))
                    {

                        $foto = $RSvalidaPedidos['fotoArte'];

                        if($foto != "")
                        {

                            $contador += 1;

                        }

                    }

                    if($contador != $count){

                        $prioridade = $rsSql['Prioridade'];
                        switch($prioridade)
                        {
                            case 1: $color = "red"; break;
                            case 2: $color = "yellow"; break;
                            case 3: $color = "green"; break;
                            default: $color = "";
                        }

                        ?>
                        <div class="column ui segment <?php echo $color ?>"><a onclick="buscarPedido(<?php echo $rsSql['idCompra']  ?>,<?php echo $usuario; ?>,1,0)" class="compra" href="#"><?php echo $rsSql['idCompra']  ?></a></div>
                    <?php }
                }?>
            </div>

        </div>
        <div class=" column ">
            <div id="" class="drop-area">

                <?php

                $sql = odbc_exec($conexao, "select distinct p.idCompra, c.Prioridade from tarefasDMTRIX t inner join PedidoDMTRIX p on t.idPedido = p.idPedido inner join ComprasDMTRIX c  on c.idCompra = p.idCompra  where p.status_pedido = 5 and t.idUsuario = '$usuario' and p.fotoArte != ''");

                while($rsSql = odbc_fetch_array($sql)){

                    $prioridade = $rsSql['Prioridade'];
                    switch($prioridade)
                    {
                        case 1: $color = "red"; break;
                        case 2: $color = "yellow"; break;
                        case 3: $color = "green"; break;
                        default: $color = "";
                    }

                    ?>

                    <div class="column ui segment <?php echo $color ?>"><a onclick="buscarPedido(<?php echo $rsSql['idCompra']  ?>,<?php echo $usuario; ?>,2,0)" class="compra"  href="#"><?php echo $rsSql['idCompra']  ?></a></div>

                <?php } ?>

            </div>
        </div>

        <div class="column">

            <?php

            $sql = odbc_exec($conexao, "select distinct p.idCompra, c.Prioridade from tarefasDMTRIX t inner join PedidoDMTRIX p on t.idPedido = p.idPedido inner join ComprasDMTRIX c  on c.idCompra = p.idCompra where p.status_pedido = 7 and t.idUsuario = '$usuario' ");

            while($rsSql = odbc_fetch_array($sql)){

                $prioridade = $rsSql['Prioridade'];
                switch($prioridade)
                {
                    case 1: $color = "red"; break;
                    case 2: $color = "yellow"; break;
                    case 3: $color = "green"; break;
                    default: $color = "";
                }

                ?>

                <div class="column ui segment <?php echo $color ?>"><a onclick="buscarPedido(<?php echo $rsSql['idCompra']  ?>,<?php echo $usuario; ?>,3,0)" class="compra"  href="#"><?php echo $rsSql['idCompra']  ?></a></div>

            <?php } ?>
        </div>

        <div class="column">

            <?php

            $sql = odbc_exec($conexao, "select distinct p.idCompra, p.status_pedido, c.Prioridade  from tarefasDMTRIX t inner join PedidoDMTRIX p on t.idPedido = p.idPedido inner join ComprasDMTRIX c  on c.idCompra = p.idCompra where p.status_pedido = 6 and t.idUsuario = '$usuario' ");

            while($rsSql = odbc_fetch_array($sql)){

                $prioridade = $rsSql['Prioridade'];
                switch($prioridade)
                {
                    case 1: $color = "red"; break;
                    case 2: $color = "yellow"; break;
                    case 3: $color = "green"; break;
                    default: $color = "";
                }


                ?>

                <div class="column ui segment <?php echo $color ?>"><a onclick="buscarPedido(<?php echo $rsSql['idCompra']  ?>,<?php echo $usuario; ?>,4,0)" class="compra"  href="#"><?php echo $rsSql['idCompra']  ?></a></div>

            <?php
            } ?>

        </div>

    </div>

    <div class="ui basic modal">
        <i class="close icon"></i>

        <div id="resultado">





        </div>



    </div>



</div>

<?php

include("rodape.php");




?>

</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script src="js/draggabilly.pkgd.min.js"></script>
<script src="js/js/semantic.js"></script>
<script src="js/dragdrop.js"></script>
<script>


    var req;
    function buscarPedido(valor,valor2,valor3,valor4) {

// Verificando Browser
        if(window.XMLHttpRequest) {
            req = new XMLHttpRequest();
        }
        else if(window.ActiveXObject) {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        }

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
        var url = "controle/exibirJob.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3+"&valor4="+valor4;


// Chamada do método open para processar a requisição
        req.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
        req.onreadystatechange = function() {

            // Exibe a mensagem "Buscando Noticias..." enquanto carrega
            if(req.readyState == 1) {
                document.getElementById('resultado').innerHTML = 'Buscando pedidos...';
            }

            // Verifica se o Ajax realizou todas as operações corretamente
            if(req.readyState == 4 && req.status == 200) {

                // Resposta retornada pelo busca.php
                var resposta2 = req.responseText;

                // Abaixo colocamos a(s) resposta(s) na div resultado
                document.getElementById('resultado').innerHTML = resposta2;
            }
        };
        req.send(null);
    }

    var req2;

    function salvaArte(valor4) {

        $('#form'+valor4).submit(function(){
            var dados = jQuery( this ).serialize();
            dados = new FormData(dados[0]);

            var formData = {
                'idPedido'              : $('input[name=idPedido]').val(),
                'idUsuario'             : $('input[name=idUsuario]').val(),
                'foto'    : $('input[name=foto]').val()
            };

            // process the form
            $.ajax({
                type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url         : 'salvarArte.php', // the url where we want to POST
                data        : dados, // our data object
                encode          : true
            })
                // using the done promise callback
                .done(function(data) {

                    // log data to the console so we can see
                    console.log(data);

                    // here we will handle errors and validation messages
                });



        });
    }


</script>
<script type="text/javascript">
    $('.compra').click(function(){

        $('.ui.basic.modal')
            .modal('show');


    });





</script>
</body>
</html>