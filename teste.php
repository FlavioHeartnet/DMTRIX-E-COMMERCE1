<?php
include("funcoes.php");
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

<body onLoad="somaProdutos(),verificaLogin()">
<div class="msgAlerta"></div>
<?php include("topo.php"); ?>

<div class="centro">
    <div class="clear bgBranco secaoInterna compra-finalizada">
        <h2>Distribuição de Budget<br><span>Altere o budget para Merchandising e para Brindes de cada supervisor, a partir de agora coloque a quantidade a ser adicionada ao budget.</span></h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <td>Nome</td>
                    <td>Nível de Acesso</td>
                    <td>Budget para Brindes</td>
                    <td>Budget para Merchandising</td>
                </tr>
                </thead>

                <tbody>
                <?php
                $buscaUsuarios = odbc_exec($conexao, "SELECT * FROM usuariosDMTRIX WHERE nivel = '3'  OR nivel = '4' OR nivel = '5'  ORDER BY nome ASC");
                while($rsBuscaUsuarios = odbc_fetch_array($buscaUsuarios)){

                    $status = $rsBuscaUsuarios['status'];

                    if($status == 1) {
                        ?>
                        <tr>
                            <td><?php echo utf8_encode($rsBuscaUsuarios['nome'] . " " . $rsBuscaUsuarios['sobrenome']); ?></td>
                            <td><?php echo $niveis[$rsBuscaUsuarios['nivel'] - 1]; ?></td>
                            <td>
                                <div class="campo"><input type="text" name="budgetBrindes[]" class="left"
                                                          placeholder="Budget para Brindes" data-mask="000000.00"
                                                          data-mask-reverse="true"
                                                          value="<?php echo $rsBuscaUsuarios['budgetBrindes']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="campo">
                                    <input type="text" name="budgetMerchandising[]" class="left"
                                           placeholder="Budget para Merchandising"
                                           data-supervisor="<?php echo $rsBuscaUsuarios['supervisor']; ?>"
                                           data-mask="000000.00" data-mask-reverse="true"
                                           value="<?php echo $rsBuscaUsuarios['budgetMerchandising']; ?>" <?php if ($rsBuscaUsuarios['nivel'] == 4) { ?> style="opacity:0.5;" readonly <?php }; ?>>
                                </div>
                            </td>
                            <input type="hidden" name="idUsuario[]"
                                   value="<?php echo $rsBuscaUsuarios['idUsuario']; ?>">
                        </tr>
                    <?php
                    }
                };
                ?>

                <tr>
                    <td colspan="4">
                        <?php $usuarioLogado = $_SESSION['usuario']; $usuarioLogado = odbc_fetch_array(odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE usuario = '$usuarioLogado'")); ?>
                        <input type="hidden" name="usuarioLogado" value="<?php echo $usuarioLogado['idUsuario'] ?>">
                        <input type="submit" name="submit_form" value="Atualizar Budget" class="largura25 right btnSubmit">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <?php include("rodape.php"); ?>
</div>

<script type="text/javascript" src="js/bibliotecas.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(e) {
        jQuery("input[name='budgetMerchandising[]']").keyup(function(){
            supervisor = jQuery(this).attr("data-supervisor");
            jQuery("input[data-supervisor='" + supervisor + "']").val(jQuery(this).val());
        });
    });
</script>
<?php
if($_POST){
    $idUsuario				= $_POST['idUsuario'];
    $budgetBrindes			= $_POST['budgetBrindes'];
    $budgetMerchandising	= $_POST['budgetMerchandising'];
    $usuarioLogado			= $_POST['usuarioLogado'];


    echo atualizaBudget($idUsuario, $budgetMerchandising, $budgetBrindes, $usuarioLogado);
};
?>
</body>
</html>