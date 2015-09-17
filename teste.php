<?php
include("funcoes.php");
include("analyticstracking.php");
session_start();
if($_SESSION['usuario'] == "" ){ header("Location: index.php"); };
$nivel = $_SESSION['nivel'];
if($_SESSION['nivel'] == 1){}else if($_SESSION['nivel'] == 2) {}else {session_destroy(); header("Location: index.php");}
$usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'"));
$usuario = $usuarioLogado['idUsuario'];
$user = $usuarioLogado['usuario'];
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
    <h2>Distribuição de Budget<br><span>Altere o budget para Merchandising e para Brindes de cada supervisor, a partir de agora coloque a quantidade a ser adicionada ao budget.</span></h2>

    <?php
    $buscaUsuarios = odbc_exec($conexao, "SELECT * FROM usuariosDMTRIX WHERE nivel = '3'  OR nivel = '4' OR nivel = '5'  ORDER BY nome ASC");

    ?>

    <div class="ui fluid category search">
        <div class="ui icon input">
            <input  onclick="buscarPedido(this.value,0,0,0)" onkeyup="buscarPedido(this.value,0,0,0)" class="prompt" type="text" placeholder="Proucurar Usuario">

            <i class="search icon"></i>
        </div>
        <div class="results"></div>
    </div>

<p><strong>Aqui você deve colocar o valor que sera adicionado ao budget, caso queira retira coloque o sinal de "-" antes do numero para mostrar que é negativo!</strong> </p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

    <div class="ui segment column" id="resultado">


    </div>
        <div class="ui segment column">
            <div class="row">
                <input type="hidden" name="usuarioLogado" value="<?php echo $usuario; ?>">
                <input type="submit" name="budget" value="Atualizar Budget" class="largura25 right btnSubmit">
            </div>
        </div>

    </form>






</div>
    <?php include("rodape.php");

    $buscaUsuarios = odbc_exec($conexao, "SELECT * FROM usuariosDMTRIX WHERE nivel = '3'  OR nivel = '4' OR nivel = '5' and status = 1  ORDER BY nome ASC");

    ?>
</div>



<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script src="js/js/semantic.js"></script>

<script>


    var content = [

        <?php while($rsBusca = odbc_fetch_array($buscaUsuarios)){ ?>

        { title: '<?php echo $rsBusca['nome']; ?>' },

      <?php } ?>

        {title: ''}
    ];

    $('.ui.search')
        .search({
            source: content,
            error : {
                source      : 'Cannot search. No source used, and Semantic API module was not included',
                noResults   : 'Usuario não encontrado!',
                logging     : 'Error in debug logging, exiting.',
                noTemplate  : 'A valid template name was not specified.',
                serverError : 'There was an issue with querying the server.',
                maxResults  : 'Results must be an array to use maxResults setting',
                method      : 'The method you called is not defined.'
            }
        });


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
        var url = "controle/buscaUsuarios.php?valor="+valor+"&valor2="+valor2+"&valor3="+valor3+"&valor4="+valor4;


// Chamada do método open para processar a requisição
        req.open("get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
        req.onreadystatechange = function() {

            // Exibe a mensagem "Buscando Noticias..." enquanto carrega
            if(req.readyState == 1) {
                document.getElementById('resultado').innerHTML = '<div class="ui active inverted dimmer"> <div class="ui text loader">Buscando Usuario..</div> </div> <p></p>';
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


</script>
<script type="text/javascript">
$('.compra').click(function(){

    $('.ui.basic.modal')
        .modal('show');

});
</script>
<?php
if(isset($_POST['budget']))
{
    $idUsuario				= $_POST['idUsuario'];
    $budgetBrindes			= $_POST['budgetBrindes'];
    $budgetMerchandising	= $_POST['budgetMerchandising'];
    $usuarioLogado			= $_POST['usuarioLogado'];
    $observacao             = $_POST['observacao'];


    echo atualizaBudget($idUsuario, $budgetMerchandising, $budgetBrindes, $usuarioLogado, $observacao);
};
?>
</body>
</html>