<?php
include("../config.php");
include("../funcoes.php");


$pedido = $_GET['valor'];
$usuario = $_GET['valor2'];
$acao = $_GET['valor3'];
$i = 0;
$contador = 0;
if($acao == 1) {
    $buscaCompras = odbc_exec($conexao, "select * from ComprasDMTRIX c inner join PedidoDMTRIX p on p.idCompra = c.idCompra inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join usuariosDMTRIX u
  on u.idUsuario = p.idUsuario inner join lojasDMTRIX l on l.idLoja = p.idLoja where (c.status_compra = 'Em analise' or c.status_compra = 'aprovacoes') and c.idCompra = '$pedido'");

    $count = odbc_num_rows($buscaCompras);

    while ($rsBuscaCompra = odbc_fetch_array($buscaCompras)) {

        $status = $rsBuscaCompra['status_pedido'];
        $formaCalculo = $rsBuscaCompra['formaCalculo'];

        if ($status == 2 || $status == 4 || $status == 9) {


            ?>

            <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0"
                   cellspacing="0">
                <thead>


                <tr class="fila" style="font-weight: bold;">
                    <td>Codigo da Compra</td>
                    <td>Nome Material</td>
                    <td>valor</td>
                    <td>Loja</td>
                    <td>Segmento</td>
                    <td>Usuario</td>
                    <td>Status</td>

                </tr>
                </thead>

                <tbody>
                <tr>
                    <td><?php echo $rsBuscaCompra['idCompra']; ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['material']); ?></td>
                    <td><?php echo $rsBuscaCompra['valor']; ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['numeroLoja'] . " - " . $rsBuscaCompra['nomeLoja']); ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['segmento']); ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['nome'] . " " . $rsBuscaCompra['sobrenome']); ?></td>
                    <?php if ($status == 2) {
                        $texto = 'Aguardando analise de valor!';
                    } else if ($status == 4) {
                        $texto = 'Orçamento reprovado!';
                    } else {
                        $texto = 'Aguardando aprovação';
                    } ?>
                    <td><?php echo $texto; ?></td>


                </tr>

                <tr>
                    <td>
                        <input type="button" onclick="controlePedidos(<?php echo $rsBuscaCompra['idPedido']  ?>,<?php echo $usuario ?>,1,<?php echo $contador ?>)" class="btnSubmit largura100" name="controlePedidos" value="Cancelar pedido">
                    </td>

                    <td id="pedidos<?php echo $contador ?>"></td>

                </tr>
                </tbody>
            </table>

        <?php
            $contador++;
        }
    }



}elseif($acao == 2) {
    $buscaCompras = odbc_exec($conexao, "SELECT * FROM ComprasDMTRIX c INNER JOIN PedidoDMTRIX p ON p.idCompra = c.idCompra INNER JOIN materiaisDMTRIX m ON m.idMaterial = p.idMaterial INNER JOIN usuariosDMTRIX u
  ON u.idUsuario = p.idUsuario INNER JOIN lojasDMTRIX l ON l.idLoja = p.idLoja where c.idCompra = '$pedido'");

    $count = odbc_num_rows($buscaCompras);
    $contador = 0;
    while ($rsBuscaCompra = odbc_fetch_array($buscaCompras)) {

        $status = $rsBuscaCompra['status_pedido'];
        $formaCalculo = $rsBuscaCompra['formaCalculo'];

    if($status == 3) {
        ?>

        <form action="#" method="post">

            <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0"
                   cellspacing="0">
                <tr class="fila" style="font-weight: bold;">
                    <td>Codigo da Compra</td>
                    <td>Nome Material</td>
                    <td>valor</td>
                    <td>Loja</td>
                    <td>Usuario</td>
                    <td>Status</td>
                    <td>Responsavel</td>
                </tr>


                <tr>
                    <td><?php echo $rsBuscaCompra['idCompra']; ?></td>
                    <td><?php echo $rsBuscaCompra['material']; ?></td>
                    <td><?php echo $rsBuscaCompra['valorProduto']; ?></td>
                    <td><?php echo $rsBuscaCompra['numeroLoja'] . " - " . $rsBuscaCompra['nomeLoja']; ?></td>
                    <td><?php echo $rsBuscaCompra['nome'] . " " . $rsBuscaCompra['sobrenome']; ?></td>

                    <?php if ($status == 3) {
                        $texto = 'Aprovado o Orçamento!';
                    }?>
                    <td><?php echo $texto; ?></td>
                    <input type="hidden" name="idPedido[]" value="<?php echo $rsBuscaCompra['idPedido']; ?>">
                    <input type="hidden" name="idCompra[]" value="<?php echo $rsBuscaCompra['idCompra']; ?>">

                    <td>
                        <div class="campo"><select id="criacao<?php echo $contador ?>" name="criacao">


                                <option value="">--</option>
                                <option value="10">Flavio</option>
                                <?php $buscaUsuario = odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE nivel = 2");

                                while ($rsBuscaUsuario = odbc_fetch_array($buscaUsuario)) {

                                    ?>
                                    <option
                                        value="<?php echo $rsBuscaUsuario['idUsuario'] ?>"><?php echo $rsBuscaUsuario['nome'] . " " . $rsBuscaUsuario['sobrenome']; ?></option>
                                <?php } ?>
                            </select></div>
                    </td>


                </tr>

                <tr style="font-weight: bold;  border-bottom:0px">

                    <td>Observação</td>
                    <td>Custeio</td>
                    <td>Forma de Pagamento</td>
                    <td>largura</td>
                    <td>altura</td>
                    <td>segmento</td>


                </tr>

                <tr>
                    <td>
                        <div class="field"><textarea readonly
                                                     name="observação"><?php echo $rsBuscaCompra['observacao']; ?></textarea>
                        </div>
                    </td>
                    <td><?php echo $rsBuscaCompra['custeio']; ?></td>
                    <td><?php echo $rsBuscaCompra['formaPagamento']; ?></td>

                    <td><?php echo $rsBuscaCompra['largura']; ?></td>
                    <td><?php echo $rsBuscaCompra['altura']; ?></td>
                    <td><?php echo $rsBuscaCompra['segmento']; ?></td>
                </tr>




            </table>


            <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0"
                   cellspacing="0">
                <tr>
                    <td colspan="8" align="right"><input onclick="delegar1(<?php echo $rsBuscaCompra['idPedido']; ?>,<?php echo $usuario; ?>,1,<?php echo $contador ?>);" type="button" class="btnSubmit largura25" name="delegar"
                                                         value="Delegar tarefa"></td>

                    <td id="saida<?php echo $contador ?>"></td>
                    <td>


                </tr>

                <tr><td>
                        <input type="button" onclick="controlePedidos1(<?php echo $rsBuscaCompra['idPedido']  ?>,<?php echo $usuario ?>,1,<?php echo $contador ?>)" class="btnSubmit largura25" name="controlePedidos" value="Cancelar pedido">
                    </td>

                <td id="pedidos<?php echo $contador ?>"></td>

                </tr>

            </table>

        </form>


    <?php
    }

    }

}elseif($acao == 3)
{
    $buscaCompras = odbc_exec($conexao, "select t.idTarefa,t.idUsuario,t.idPedido,t.ativo,u.usuario,u.sobrenome,u.nome,u.email,m.idMaterial,p.largura,p.altura,p.segmento,p.custeio,p.data_entrega,
  p.observacao,m.material, p.idLoja,l.nomeLoja, p.status_pedido, p .formaPagamento, p.idCompra,p.valorProduto from [MARKETING].[dbo].[tarefasDMTRIX] t
  inner join usuariosDMTRIX u on u.idUsuario = t.idUsuario inner join PedidoDMTRIX p on p.idPedido = t.idPedido
  inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join lojasDMTRIX l on l.idLoja = p.idLoja where p.idCompra = '$pedido'  ");

    $count = odbc_num_rows($buscaCompras);
    $contador = 0;
    while ($rsBuscaCompra = odbc_fetch_array($buscaCompras)) {

        $status = $rsBuscaCompra['status_pedido'];

    if($status == 5 or $status == 7 ) {
        ?>
        <form action="#" method="post">
        <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0"
               cellspacing="0">
            <thead>
            <tr class="fila" style="font-weight: bold;">
                <td>Codigo da Compra</td>
                <td>Nome Material</td>
                <td>valor</td>
                <td>Loja</td>
                <td>Usuario</td>
                <td>Status</td>
                <td>Responsavel</td>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><?php echo $rsBuscaCompra['idCompra']; ?></td>
                <td><?php echo $rsBuscaCompra['material']; ?></td>
                <td><?php echo $rsBuscaCompra['valorProduto']; ?></td>
                <td><?php echo $rsBuscaCompra['nomeLoja']; ?></td>
                <td><?php echo $rsBuscaCompra['idUsuario']; ?></td>
                <?php if ($status == 3) {
                    $texto = 'Aprovado o Orçamento!';
                } else if ($status == 5) {
                    $texto = 'Em Fabricação';
                }?>
                <td><?php echo $texto; ?></td>
                <input type="hidden" name="idPedido[]" value="<?php echo $rsBuscaCompra['idPedido']; ?>">
                <input type="hidden" name="idTarefa[]" value="<?php echo $rsBuscaCompra['idTarefa']; ?>">
                <input type="hidden" name="idCompra[]" value="<?php echo $rsBuscaCompra['idCompra']; ?>">
                <td>
                    <div class="campo"><select id="criacao<?php echo $contador ?>" name="criacao">

                            <option
                                value="<?php echo $rsBuscaCompra['idUsuario']; ?>"><?php echo $rsBuscaCompra['nome'] . " " . $rsBuscaCompra['sobrenome']; ?></option>

                            <option value="10">Flavio Nogueira</option>
                            <?php $buscaUsuario = odbc_exec($conexao, "SELECT * FROM dbo.usuariosDMTRIX WHERE nivel = 2");

                            while ($rsBuscaUsuario = odbc_fetch_array($buscaUsuario)) {

                                ?>
                                <option
                                    value="<?php echo $rsBuscaUsuario['idUsuario'] ?>"><?php echo $rsBuscaUsuario['nome'] . " " . $rsBuscaUsuario['sobrenome']; ?></option>
                            <?php } ?>
                        </select></div>
                </td>
            </tr>

            <tr style="font-weight: bold;  border-bottom:0px">

                <td>Observação</td>
                <td>Custeio</td>
                <td>Forma de Pagamento</td>
                <td>largura</td>
                <td>altura</td>
                <td>segmento</td>


            </tr>

            <tr>
                <td>
                    <div class="field"><textarea readonly
                                                 name="observacão"><?php echo $rsBuscaCompra['observacao']; ?></textarea>
                    </div>
                </td>
                <td><?php echo $rsBuscaCompra['custeio']; ?></td>
                <td><?php echo $rsBuscaCompra['formaPagamento']; ?></td>

                <td><?php echo $rsBuscaCompra['largura']; ?></td>
                <td><?php echo $rsBuscaCompra['altura']; ?></td>
                <td><?php echo $rsBuscaCompra['segmento']; ?></td>


            </tr>


            </tbody>
        </table>

        <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0"
               cellspacing="0">
            <tr>
                <td colspan="8" align="right"><input type="button" onclick="delegar(<?php echo $rsBuscaCompra['idPedido']  ?>,<?php echo $usuario ?>,2,<?php echo $contador ?>);" name="redelegar" value="Re-Delegar Tarefa"
                                                     class="btnSubmit largura25"></td>

                <td id="saida<?php echo $contador ?>"></td>


            </tr>
            <tr><td>
                    <input type="button" onclick="controlePedidos2(<?php echo $rsBuscaCompra['idPedido']  ?>,<?php echo $usuario ?>,0,<?php echo $contador ?>)" class="btnSubmit largura25" name="controlePedidos" value="Aprovar para fornecedor">
                </td>

                <td id="pedidos<?php echo $contador ?>"></td>
            </tr>
        </table>
    <?php

        $contador++;
        }
    }

}elseif($acao = 4)
{

    $buscaCompras = odbc_exec($conexao, "select * from ComprasDMTRIX c inner join PedidoDMTRIX p on p.idCompra = c.idCompra inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial inner join usuariosDMTRIX u
  on u.idUsuario = p.idUsuario inner join lojasDMTRIX l on l.idLoja = p.idLoja where (c.status_compra = 'Em analise' or c.status_compra = 'aprovacoes') and c.idCompra = '$pedido'");

    while ($rsBuscaCompra = odbc_fetch_array($buscaCompras)) {

        $status = $rsBuscaCompra['status_pedido'];


        if ($status == 6) {
            ?>

            <table class="ui table" style="padding:5px" width="100%" align="center" border="0" cellpadding="0"
                   cellspacing="0">
                <thead>


                <tr class="fila" style="font-weight: bold;">
                    <td>Codigo da Compra</td>
                    <td>Nome Material</td>
                    <td>valor</td>
                    <td>Loja</td>
                    <td>Segmento</td>
                    <td>Usuario</td>
                    <td>Status</td>

                </tr>
                </thead>

                <tbody>
                <tr>
                    <td><?php echo $rsBuscaCompra['idCompra']; ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['material']); ?></td>
                    <td><?php echo $rsBuscaCompra['valor']; ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['numeroLoja'] . " - " . $rsBuscaCompra['nomeLoja']); ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['segmento']); ?></td>
                    <td><?php echo utf8_encode($rsBuscaCompra['nome'] . " " . $rsBuscaCompra['sobrenome']); ?></td>
                    <td>Aprovado</td>


                </tr>
                </tbody>
            </table>

        <?php
        }
    }


}elseif($acao == 5){



}

