<?php
include_once("../config.php");



// Recebe o valor enviado
$valor = $_GET['valor'];


$verificar = is_numeric($valor);




if($verificar == true) {
// Procura titulos no banco relacionados ao valor
    $sql = odbc_exec($GLOBALS['conexao'], "SELECT * FROM usuariosDMTRIX WHERE  nome like '%" . $valor . "%'   ORDER BY nome ASC");

}else{

    $sql = odbc_exec($GLOBALS['conexao'], "SELECT * FROM usuariosDMTRIX WHERE  nome like '%" . $valor . "%'  ORDER BY nome ASC");

}

// Exibe todos os valores encontrados
?>
<table class="ui table" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>Nome</td>
                <td>Nível de Acesso</td>
                <td>Budget para Brindes</td>
                <td>Budget para Merchandising</td>
                <td>Tipo de movimentação</td>
            </tr>

            </thead>

            <tbody>
            <?php
while ($rsBuscaUsuarios = odbc_fetch_array($sql)) {

  $nivel = $rsBuscaUsuarios['nivel'];
  $status = $rsBuscaUsuarios['status'];

    switch($nivel)
    {
        case 5: $x = 1;
            break;
        case 3: $x = 1;
            break;
        case 4: $x =1;
            break;
        default: $x=0;

    }


    if ($status == 1 and $x = 1) {

        ?>
        <tr>
            <td><?php echo utf8_encode($rsBuscaUsuarios['nome'] . " " . $rsBuscaUsuarios['sobrenome']); ?></td>
            <td><?php echo $niveis[$rsBuscaUsuarios['nivel'] - 1]; ?></td>
            <td>
                <div class="campo"><input type="text" name="budgetBrindes[]" class="left"
                                          placeholder="Brindes: <?php echo $rsBuscaUsuarios['budgetBrindes'] ?>" data-mask="000000.00"
                                          data-mask-reverse="true"
                                          value="">
                </div>
            </td>
            <td>
                <div class="campo">
                    <input type="text" name="budgetMerchandising[]" class="left"
                           placeholder="Merchandising: <?php echo $rsBuscaUsuarios['budgetMerchandising'] ?>"
                           data-supervisor="<?php echo $rsBuscaUsuarios['supervisor']; ?>"
                           data-mask="000000.00" data-mask-reverse="true"
                           value="">
                </div>
            </td>
            <td><div class="campo">
                        <select id="observacao" class="ui " name="observacao[]">
                            <option value="Credito Trimestral">Credito Trimestral</option>
                            <option value="Debito Trimestral">Debito Trimestral</option>
                            <option value="Distribição de  budget">Distribição de budget</option>
                            <option value="Re-distriduição de budget">Re-distriduição de budget</option>

                        </select>
                    </div></td>
            <input type="hidden" name="idUsuario[]" value="<?php echo $rsBuscaUsuarios['idUsuario']; ?>">
        </tr>

        <tr>

            <td>  </td>

        </tr>

    <?php

    }
}
        ?>


            </tbody>
</table>




<?php


