<?php
include("../config.php");


$pedido = $_GET['valor'];
$usuario = $_GET['valor2'];
$acao = $_GET['valor3'];
$i = 0;




$sql = odbc_exec($GLOBALS['conexao'], "select t.idTarefa,t.idPedido, t.idUsuario, t.ativo, t.tempoIniciado, t.tempoFinal,t.iniciado,m.material, p.largura,p.altura,
p.quantidade,p.observacao,p.status_pedido,p.publicAlvo,p.acao,p.objetivo, l.nomeLoja, l.numeroLoja,l.rede, p.idCompra, p.fotoArte from tarefasDMTRIX t inner join PedidoDMTRIX p
on p.idPedido = t.idPedido inner join materiaisDMTRIX m on m.idMaterial = p.idMaterial join lojasDMTRIX l on l.idLoja = p.idLoja
  where p.idCompra = '$pedido' and t.idUsuario='$usuario'");

while($rsSql = odbc_fetch_array($sql))
{
    $foto = $rsSql['fotoArte'];
    if($acao == 1){

       if($foto == "") {
           ?>
           <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
               <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
                      cellspacing="0">
                   <thead>
                   <tr>
                       <td colspan="1"><strong>Pedido</strong></td>
                       <td><strong>Compra</strong></td>
                       <td><strong>Material</strong></td>
                       <td><strong>loja</strong></td>
                       <td><strong>Descrição</strong></td>


                   </tr>
                   </thead>
                   <tbody>

                   <tr>

                       <td><?php echo $rsSql['idPedido']; ?></td>
                       <td><?php echo $rsSql['idCompra']; ?></td>
                       <td><?php echo $rsSql['material']; ?></td>
                       <td><?php echo $rsSql['nomeLoja']." rede: ".$rsSql['rede']?></td>

                       <td width="500px">
                           <table class="ui table" width="100%" align="center" border="0"
                                  cellpadding="0"
                                  cellspacing="0">
                               <tr class="semBorda">
                                   <td>
                                       <div class="campo"><input type="text" readonly
                                                                 name="largura[]"
                                                                 class="left" placeholder="Largura"
                                                                 value="<?php echo $rsSql['largura']; ?>"

                                                                 autocomplete="off"
                                                                 data-mask="0000.00"
                                                                 data-mask-reverse="true"></div>
                                   </td>
                                   <td>
                                       <div class="campo"><input type="text" readonly
                                                                 name="altura[]"
                                                                 class="left" placeholder="Altura"
                                                                 value="<?php echo $rsSql['altura']; ?>"
                                                                 autocomplete="off"
                                                                 data-mask="0000.00"
                                                                 data-mask-reverse="true"></div>
                                   </td>


                               </tr>
                               <tr class="semBorda">
                                   <td colspan="9">
                                       <div class="field"><textarea readonly name="observacao[]"
                                                                    class="left"
                                                                    placeholder="Como você imagina essa peça pronta?"
                                                                    style="line-height:25px;"><?php echo $rsSql['observacao']; ?></textarea>
                                       </div>
                                   </td>
                               </tr>
                           </table>
                       </td>
                   </tr>
                   <tr>
                   </tr>


                   </tbody>
               </table>
           </form>
           <form id="form<?php echo $i ?>" action="salvarArte.php" target="_blank" method="post" enctype="multipart/form-data">
               <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
                      cellspacing="0">


                   <tr>
                       <td>
                           <div class="ui action input">
                               <input type="file" name="foto" class="left ui button largura100" required>
                               <input type="hidden" value="<?php echo $rsSql['idPedido']; ?>" name="idPedido">
                               <input type="hidden" value="<?php echo $usuario ?>" name="idUsuario">


                               <div class="ui toggle button"><input type="submit" name="foto" value="Enviar Arte"></div>

                           </div>

                       </td>

                       <td id="resultado<?php echo $i ?>">

                       </td>

                       <?php $i++; ?>



                   </tr>
               </table>

           </form>
           <br>

       <?php
       }
    }else if($acao == 3)
    {

        $status = $rsSql['status_pedido'];
        $idPedido = $rsSql['idPedido'];

        if($status == 7)
        {
            $reprovado = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from ControleReprovacoesDMTRIX where idPedido = '$idPedido'"));

            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <td colspan="1"><strong>Pedido</strong></td>
                        <td><strong>Compra</strong></td>
                        <td><strong>Material</strong></td>
                        <td><strong>reprovado</strong></td>
                        <td><strong>loja</strong></td>
                        <td><strong>Descrição</strong></td>


                    </tr>
                    </thead>
                    <tbody>

                    <tr>

                        <td><?php echo $rsSql['idPedido']; ?></td>
                        <td><?php echo $rsSql['idCompra']; ?></td>
                        <td><?php echo $rsSql['material']; ?></td>
                        <td><?php echo $reprovado['MotivoArte']; ?></td>
                        <td><?php echo $rsSql['nomeLoja']." rede: ".$rsSql['rede']?></td>

                        <td width="500px">
                            <table class="ui table" width="100%" align="center" border="0"
                                   cellpadding="0"
                                   cellspacing="0">
                                <tr class="semBorda">
                                    <td>
                                        <div class="campo"><input type="text" readonly
                                                                  name="largura[]"
                                                                  class="left" placeholder="Largura"
                                                                  value="<?php echo $rsSql['largura']; ?>"

                                                                  autocomplete="off"
                                                                  data-mask="0000.00"
                                                                  data-mask-reverse="true"></div>
                                    </td>
                                    <td>
                                        <div class="campo"><input type="text" readonly
                                                                  name="altura[]"
                                                                  class="left" placeholder="Altura"
                                                                  value="<?php echo $rsSql['altura']; ?>"
                                                                  autocomplete="off"
                                                                  data-mask="0000.00"
                                                                  data-mask-reverse="true"></div>
                                    </td>


                                </tr>
                                <tr class="semBorda">
                                    <td colspan="9">
                                        <div class="field"><textarea readonly name="observacao[]"
                                                                     class="left"
                                                                     placeholder="Como você imagina essa peça pronta?"
                                                                     style="line-height:25px;"><?php echo $rsSql['observacao']; ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>


                    </tr>


                    <tr>


                    </tr>

                    </tbody>
                </table>
            </form>
            <form id="form<?php echo $i ?>" action="salvarArte.php" target="_blank" method="post" enctype="multipart/form-data">
                <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
                       cellspacing="0">


                    <tr>
                        <td>
                            <div class="ui action input">
                                <input type="file" name="foto" class="left ui button largura100" required>
                                <input type="hidden" value="<?php echo $rsSql['idPedido']; ?>" name="idPedido">
                                <input type="hidden" value="<?php echo $usuario ?>" name="idUsuario">


                                <div class="ui toggle button"><input type="submit" name="foto" value="Enviar Arte"></div>

                            </div>

                        </td>

                        <td id="resultado<?php echo $i ?>">

                        </td>

                        <?php $i++; ?>



                    </tr>
                </table>

            </form>
            <br>

        <?php
        }
    }elseif($acao == 2) {

            $status = $rsSql['status_pedido'];

        if ($foto != "" and $status == 5)
        {
            ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <td colspan="1"><strong>Pedido</strong></td>
                        <td><strong>Compra</strong></td>
                        <td><strong>Material</strong></td>
                        <td><strong>loja</strong></td>
                        <td><strong>Descrição</strong></td>


                    </tr>
                    </thead>
                    <tbody>

                    <tr>

                        <td><?php echo $rsSql['idPedido']; ?></td>
                        <td><?php echo $rsSql['idCompra']; ?></td>
                        <td><?php echo $rsSql['material']; ?></td>
                        <td><?php echo $rsSql['nomeLoja']." rede: ".$rsSql['rede']?></td>

                        <td width="500px">
                            <table class="ui table" width="100%" align="center" border="0"
                                   cellpadding="0"
                                   cellspacing="0">
                                <tr class="semBorda">
                                    <td>
                                        <div class="campo"><input type="text" readonly
                                                                  name="largura[]"
                                                                  class="left" placeholder="Largura"
                                                                  value="<?php echo $rsSql['largura']; ?>"

                                                                  autocomplete="off"
                                                                  data-mask="0000.00"
                                                                  data-mask-reverse="true"></div>
                                    </td>
                                    <td>
                                        <div class="campo"><input type="text" readonly
                                                                  name="altura[]"
                                                                  class="left" placeholder="Altura"
                                                                  value="<?php echo $rsSql['altura']; ?>"
                                                                  autocomplete="off"
                                                                  data-mask="0000.00"
                                                                  data-mask-reverse="true"></div>
                                    </td>


                                </tr>
                                <tr class="semBorda">
                                    <td colspan="9">
                                        <div class="field"><textarea readonly name="observacao[]"
                                                                     class="left"
                                                                     placeholder="Como você imagina essa peça pronta?"
                                                                     style="line-height:25px;"><?php echo $rsSql['observacao']; ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>


                    </tr>


                    <tr>



                    </tr>

                    </tbody>
                </table>
            </form>
            <form enctype="multipart/form-data" action="salvarArte.php" target="_blank" method="post" id="form<?php echo $i ?>">
                <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
                       cellspacing="0">


                    <tr>
                        <td>
                            <div class="ui action input">
                                <input type="file" name="foto" class="left ui button largura100" required>
                                <input type="hidden" value="<?php echo $rsSql['idPedido']; ?>" name="idPedido">
                                <input type="hidden" value="<?php echo $usuario ?>" name="idUsuario">


                                <div class="ui toggle button"><input required="" type="submit" name="foto" value="Enviar Arte"></div>



                            </div>

                        </td>

                        <td id="resultado<?php echo $i ?>">


                        </td>

                        <?php $i++; ?>

                    </tr>
                </table>

            </form>
            <br>

        <?php
        }
    }elseif($acao == 4)
    {

        $status = $rsSql['status_pedido'];
        if($status == 6)
        {
            ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table class="ui table" width="100%" align="center" border="0" cellpadding="0"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <td colspan="1"><strong>Pedido</strong></td>
                        <td><strong>Compra</strong></td>
                        <td><strong>Material</strong></td>
                        <td><strong>loja</strong></td>
                        <td><strong>Descrição</strong></td>


                    </tr>
                    </thead>
                    <tbody>

                    <tr>

                        <td><?php echo $rsSql['idPedido']; ?></td>
                        <td><?php echo $rsSql['idCompra']; ?></td>
                        <td><?php echo $rsSql['material']; ?></td>
                        <td><?php echo $rsSql['nomeLoja']." rede: ".$rsSql['rede']?></td>

                        <td width="500px">
                            <table class="ui table" width="100%" align="center" border="0"
                                   cellpadding="0"
                                   cellspacing="0">
                                <tr class="semBorda">
                                    <td>
                                        <div class="campo"><input type="text" readonly
                                                                  name="largura[]"
                                                                  class="left" placeholder="Largura"
                                                                  value="<?php echo $rsSql['largura']; ?>"

                                                                  autocomplete="off"
                                                                  data-mask="0000.00"
                                                                  data-mask-reverse="true"></div>
                                    </td>
                                    <td>
                                        <div class="campo"><input type="text" readonly
                                                                  name="altura[]"
                                                                  class="left" placeholder="Altura"
                                                                  value="<?php echo $rsSql['altura']; ?>"
                                                                  autocomplete="off"
                                                                  data-mask="0000.00"
                                                                  data-mask-reverse="true"></div>
                                    </td>


                                </tr>
                                <tr class="semBorda">
                                    <td colspan="9">
                                        <div class="field"><textarea readonly name="observacao[]"
                                                                     class="left"
                                                                     placeholder="Como você imagina essa peça pronta?"
                                                                     style="line-height:25px;"><?php echo $rsSql['observacao']; ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>


                    </tr>


                    <tr>


                        <td colspan="8"
                            align="center">

                        </td>
                    </tr>

                    </tbody>
                </table>
            </form>

            <br>

        <?php
        }
    }elseif($acao == 5)
    {



    }
}