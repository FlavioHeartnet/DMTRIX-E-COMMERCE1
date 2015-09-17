<?php
///Incluir aquivo de conexão
include("../config.php");

$idCompra = $_GET['valor'];
$status = $_GET['valor2'];
$UsuarioLogado = $_GET['valor3'];

$query = odbc_exec($GLOBALS['conexao'],"select * from PedidoBrindesDMTRIX where idCompra = '$idCompra' and statusBrindes = '$status'");
$contador = 0;
while($rsQuery = odbc_fetch_array($query))
{

    $idUsuario = $rsQuery['idUsuario'];

    $Usuario = odbc_fetch_array(odbc_exec($GLOBALS['conexao'],"select * from usuariosDMTRIX where idUsuario = '$idUsuario'"));
    $nome = $Usuario['nome']." ".$Usuario['sobrenome'];
    ?>

    <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
               cellspacing="0">
            <thead>
            <tr>
                <td colspan="1"><strong>Pedido</strong></td>
                <td><strong>Compra</strong></td>
                <td><strong>Brinde</strong></td>
                <td><strong>Quantidade</strong></td>
                <td><strong>Comprador</strong></td>
                <td><strong>valor</strong></td>
                <td><strong>Valor Total</strong></td>
                <td><strong>Responsavel</strong></td>


            </tr>
            </thead>
            <tbody>

            <tr>

                <td><?php echo $rsQuery['idPedido']; ?></td>
                <td><?php echo $rsQuery['idCompra']; ?></td>
                <td><?php echo $rsQuery['NomeBrinde']; ?></td>
                <td><?php echo $rsQuery['quantidade']; ?></td>
                <td><?php echo $nome; ?></td>
                <td><?php echo number_format($rsQuery['ValorBrinde'], 2, ',',' '); ?></td>
                <td><?php echo number_format($rsQuery['valorTotal'], 2, ',',' '); ?></td>
                <td>
                    <div class="campo"><select id="criacao<?php echo $contador ?>" name="criacao">
                            <option value="">--</option>
                            <option value="3">Trade</option>
                        </select></div>
                </td>

            </tr>
            <tr>
                <?php if($status == 2){ ?>

                <td colspan="8" align="right"><input onclick="delegarBrindes(<?php echo $rsQuery['idPedido']; ?>,2,<?php echo $UsuarioLogado ?>,<?php echo $contador ?>);" type="button" class="btnSubmit largura30" name="delegar"
                                                     value="Delegar para fila de preparação"></td>

                <?php }elseif($status == 3){
                    ?>

                    <td colspan="8" align="right"><input onclick="delegarBrindes(<?php echo $rsQuery['idPedido']; ?>,3,<?php echo $UsuarioLogado ?>,<?php echo $contador ?>);" type="button" class="btnSubmit largura30" name="delegar"
                                                         value="Liberar brinde para retirada"></td>


               <?php }elseif($status == 4){

                    ?>

                    <td colspan="7" align="right"><input onclick="delegarBrindes(<?php echo $rsQuery['idPedido']; ?>,4,<?php echo $UsuarioLogado ?>,<?php echo $contador ?>);" type="button" class="btnSubmit largura30" name="delegar"
                                                         value="Finalizar pedido"></td>
               <?php }?>

                <td id="saidas<?php echo $contador ?>"></td>

            </tr>

            <tr><td colspan="7">
                    <?php if($status != 5) { ?>

                    <input type="button" onclick="controleBrindes(<?php echo $rsQuery['idPedido']  ?>,0,<?php echo $UsuarioLogado ?>,<?php echo $contador ?>)" class="btnSubmit largura30" name="controlePedidos" value="Cancelar pedido">

                    <?php }else{ ?>

                        <input type="button" onclick="delegarBrindes(<?php echo $rsQuery['idPedido']  ?>,6,<?php echo $UsuarioLogado ?>,<?php echo $contador ?>)" class="btnSubmit largura30" name="controlePedidos" value="Finalizar Pedido">

                    <?php } ?>

    </td>

                <td id="pedidos<?php echo $contador ?>">

                </td>

            </tr>
            </tbody>
        </table>
<br>

    </form>



    <?php
    $contador++;
}

