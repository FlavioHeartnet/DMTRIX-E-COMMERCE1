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
        <div id="tab" style=" border:0px; background:#FFF">
        <h2>Cadastro de Lojas</br><span>Aqui você pode cadastrar novas lojas no sistema.</span></h2>

        <ul style="background:#FFF; border: 0px">
            <li><a href="#aba-1">Cadastro de Lojas</a></li>
            <li><a href="#aba-2">Editar Lojas</a></li>
        </ul>
        <div id="aba-1" style="background:#FFF ">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>Numero da Loja<div class="campo"><input type="text"  name="numeroLoja"  class="left" placeholder="Digite o numero da loja"  data-mask="000000" autocomplete="off" data-mask-reverse="true"></div></td>
                <td>Nome da Loja<div class="campo"><input type="text"  name="nomeLoja"  class="left" placeholder="Digite o nome da loja" autocomplete="off" data-mask-reverse="true"></div></td>
            </tr>

            <tr>
                <td >Rede<div id="redeExitente" class="campo"><label>
                            <select id="rede1" name="rede">
                                <?php
                                $query = odbc_exec($conexao, "select DISTINCT rede from lojasDMTRIX");
                            while($rsQuery = odbc_fetch_array($query)){
                            ?>
                                <option
                                    value="<?php echo utf8_encode($rsQuery['rede'])?>"><?php echo utf8_encode($rsQuery['rede']) ?></option>
                                <?php } ?>


                            </select>
                        </label></div>

                   <div id="redeInexistente" class="campo"><input id="rede2" type="text"  name="rede1"  class="left" placeholder="Digite o nome da rede" autocomplete="off" data-mask-reverse="true"></div>


                    <div class="checks"> <input checked type="checkbox" name="comrede" id="l" ><label for="l">Rede existente</label></div>
                    <div class="checks"><input  type="checkbox" name="semrede" id="2a" ><label for="2a">Nova rede</label></div>

                </td>
                <td>Responsavel<div class="campo"><select name="responsavel">

                            <?php
                            $query = odbc_exec($conexao, "select * from usuariosDMTRIX ");
                            while($rsQuery = odbc_fetch_array($query)) {
                                $status = $rsQuery['status'];
                                if ($status == 1) {
                                    ?>
                                    <option
                                        value="<?php echo $rsQuery['idUsuario'] ?>"><?php echo utf8_encode($rsQuery['nome'] . " " . $rsQuery['sobrenome']) ?></option>
                                <?php
                                }
                            }?>


                </select></div></td>
            </tr>

            <tr>

                <td>Cidade<div class="campo"><input type="text"  name="cidade"  class="left" placeholder="Digite a cidade" autocomplete="off" data-mask-reverse="true"></div></td>
                <td>Estado<div class="campo"><input type="text"  name="estado"  class="left" placeholder="Digite o estado" autocomplete="off" data-mask-reverse="true"></div></td>
                <td>CEP<div class="campo"><input type="text"  name="cep"  class="left" placeholder="Digite o CEP" autocomplete="off" data-mask-reverse="true"></div></td>
            </tr>

            <tr>
                <td colspan="3"><div  class="right"><input style="width: 138px;" type="submit"  name="loja"  class="btnSubmit" value="Cadastrar"></div></td>

            </tr>

        </table>
            </form>
            </div> <!-- abas -->
        <div id="aba-2" style="background:#FFF ">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">



                <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr><td>pesquise pelo numero de Loja ou nome da loja<div class="campo"><input type="text" id="busca" onkeyup="buscarNoticias(this.value)" /></div></td>
                    </tr>


                </table>
                <table  id="conteudo" class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">


                </table>
                <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

                    <tr><td colspan="3"><div  class="right"><input style="width: 138px;" type="submit"  name="editarLoja"  class="btnSubmit" value="Atualizar"></div></td></tr>
                </table>



                </form>

            <div id="resultado"></div>





        </div>

            </div>

        </div>
    <?php include("rodape.php");


    if(isset($_POST['loja']))
    {
        if($_POST['numeroLoja']==""){echo "<script>alert('digite o numero da loja para cadastrar.')</script>";}else {
            $numeroLoja = $_POST['numeroLoja'];
            $nomeLoja = $_POST['nomeLoja'];
            $rede = $_POST['rede'];
            $responsavel = $_POST['responsavel'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            $cep = $_POST['cep'];

            echo "<script>alert('esta é a rede: $rede');</script>";

            addLoja($numeroLoja, $nomeLoja, $rede, $responsavel, $cidade, $estado, $cep);
        }
    }else if (isset($_POST['editarLoja'])) {


        $idLoja = $_POST['idLoja'];
        $numeroLoja = $_POST['numeroLoja'];
        $nomeLoja = $_POST['nomeLoja'];
        $rede = $_POST['rede'];
        $responsavel = $_POST['responsavel'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $cep = $_POST['cep'];


        AtualizarLoja($idLoja, $numeroLoja, $nomeLoja, $rede, $responsavel, $cidade, $estado, $cep);
    }
    ?>
</div>
<script type="text/javascript" src="js/bibliotecas.js"></script>
<script src="js/js/semantic.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">

    $( "#tab" ).tabs({
        show: { effect: "blind", duration: 800 }
    });

</script>
</body>
</html>