<?php
// Incluir aquivo de conexão
include("../config.php");

// Recebe a id enviada no método GET
$id = $_GET['id'];


// Seleciona a noticia que tem essa ID
$sql = odbc_exec($GLOBALS['conexao'],"SELECT * FROM lojasDMTRIX l INNER JOIN usuariosDMTRIX u on l.responsavel = u.idUsuario WHERE l.idLoja = '$id'");




// Exibe o conteúdo da notica

while($lojas = odbc_fetch_array($sql)) {

    ?>

    <tr>
        <td>Numero da Loja
            <div class="campo"><input type="text" name="numeroLoja" class="left"
                                      value="<?php echo $lojas['numeroLoja'] ?>" data-mask="000000" autocomplete="off"
                                      data-mask-reverse="true"></div>

            <input type="hidden" value="<?php echo $lojas['idLoja'] ?>" name="idLoja">
            <input type="hidden" value="0" name="controle">
        </td>
        <td>Nome da Loja
            <div class="campo"><input type="text" name="nomeLoja" class="left" value="<?php echo $lojas['nomeLoja'] ?>"
                                      autocomplete="off" data-mask-reverse="true"></div>
        </td>
    </tr>

    <tr>
        <td>Rede
            <div class="campo"><input type="text" name="rede" class="left" value="<?php echo $lojas['rede'] ?>"
                                      autocomplete="off" data-mask-reverse="true"></div>
        </td>
        <td>Responsavel
            <div class="campo"><select name="responsavel" >

                    <option value="<?php echo $lojas['idUsuario']?>"><?php echo $lojas['nome']." ".$lojas['sobrenome']; ?></option>
                    <?php

                    $query = odbc_exec($GLOBALS['conexao'],"select * from usuariosDMTRIX where status = 1");

                    while($rsquery =odbc_fetch_array($query)){
                    ?>

                        <option value="<?php echo $rsquery['idUsuario']?>"><?php echo $rsquery['nome']." ".$rsquery['sobrenome']; ?></option>

                    <?php } ?>
            </select>
            </div>
        </td>
    </tr>

    <tr>
        <td>Cidade
            <div class="campo"><input type="text" name="cidade" class="left" value="<?php echo $lojas['cidade'] ?>"
                                      autocomplete="off" data-mask-reverse="true"></div>
        </td>
        <td>Estado
            <div class="campo"><input type="text" name="estado" class="left" value="<?php echo $lojas['estado'] ?>"
                                      autocomplete="off" data-mask-reverse="true"></div>
        </td>
        <td>Cep
            <div class="campo"><input type="text" name="cep" class="left" value="<?php echo $lojas['cep'] ?>"
                                      autocomplete="off" data-mask-reverse="true"></div>
        </td>
    </tr>

<?php
}


?>