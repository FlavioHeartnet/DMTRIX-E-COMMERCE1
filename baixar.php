<?php 
include_once("config.php");

		$inicio = $_POST['dataInicio'];
		$final = $_POST['dataFinal'];
		$idUsuario = $_POST['idUsuario'];
		$usuario = $_POST['token'];
		$excel = $_POST['excel'];
		$pdf = $_POST['pdf'];
		
	$query =odbc_fetch_array(odbc_exec($GLOBALS['conexao'], "select * from dbo.usuariosDMTRIX where idUsuario = '$usuario'"));
	
	if($inicio == "" and $final != "")
	{
		$arquivo = "Brindes-DMTRIX-".$inicio.".xls";
		$query2 = odbc_fetch_array(odbc_exec($GLOBALS['conexao'], " select * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on p.idBrinde = b.idBrinde inner join marketing.dbo.usuariosDMTRIX u on p.idUsuario = u.idUsuario where p.dataCompra = '$inicio'"));
		
		
		
	} if($inicio != "" and $final != "")
	{
		$arquivo = "Brindes-DMTRIX-".$inicio."-".$final.".xls";
		$query2 =odbc_exec($GLOBALS['conexao'], "select * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on p.idBrinde = b.idBrinde inner join marketing.dbo.usuariosDMTRIX u on p.idUsuario = u.idUsuario where dataCompra between '$inicio' and '$final'");
		
	}else if($inicio != "" and $final == "")
	{
		$arquivo = "Brindes-DMTRIX-".$inicio.".xls";
		$query2 = odbc_exec($GLOBALS['conexao'], "select * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on p.idBrinde = b.idBrinde inner join marketing.dbo.usuariosDMTRIX u 
 on p.idUsuario = u.idUsuario where p.dataCompra = '$inicio'");
		
	}else if($inicio == "" and $final == "")
	{
		$arquivo = "Brindes-DMTRIX-".$query['nome'].".xls";
		$query2 = odbc_exec($GLOBALS['conexao'], "select * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on p.idBrinde = b.idBrinde inner join marketing.dbo.usuariosDMTRIX u on p.idUsuario = u.idUsuario where p.idUsuario = '$idUsuario'");
	}else if($inicio == "" and $final != "")
	{
		$arquivo = "Brindes-DMTRIX-".$final.".xls";
		$query2 = odbc_exec($GLOBALS['conexao'], "select * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on p.idBrinde = b.idBrinde inner join marketing.dbo.usuariosDMTRIX u 
 on p.idUsuario = u.idUsuario where p.dataCompra = '$final'");
	}
	
	 if($inicio != "" and $final != "" and $usuario != "")
	{
		$arquivo = "Brindes-DMTRIX-".$inicio."-".$final.".xls";
		$query2 =odbc_exec($GLOBALS['conexao'], "select * FROM [marketing].[dbo].[PedidoBrindesDMTRIX] p inner join marketing.dbo.brindesDMTRIX b on p.idBrinde = b.idBrinde inner join marketing.dbo.usuariosDMTRIX u on p.idUsuario = u.idUsuario where dataCompra between '$inicio' and '$final' and u.idUsuario = '$usuario'");
		
	}
	
	if($excel == 1){
	
	$tabela = "<table>";
			$tabela .= "<tr>";
				$tabela .= utf8_decode("<td><strong>Identificação da Solicitação</strong></td>");
				$tabela .= utf8_decode("<td><strong>Solicitante</strong></td>");
				$tabela .= utf8_decode("<td><strong>Brinde</strong></td>");
				$tabela .= utf8_decode("<td><strong>Quantidade</strong></td>");
				$tabela .= utf8_decode("<td><strong>Motivo da Compra</strong></td>");
				$tabela .= utf8_decode("<td><strong>Solicitado no Dia</strong></td>");
				$tabela .= utf8_decode("<td><strong>Valor Unitário do brinde</strong></td>");
				$tabela .= utf8_decode("<td><strong>Valor dos brindes pedidos conforme quantidade</strong></td>");
				$tabela .= utf8_decode("<td><strong>Valor Total da Solicitação</strong></td>");
				$tabela .= utf8_decode("<td><strong>budget atual</strong></td>");
				$tabela .= utf8_decode("<td><strong>Estoque</strong></td>");
			$tabela .= "</tr>";


			
			while($rsQuery = odbc_fetch_array($query2)){
                $total  = $rsQuery['valor']* $rsQuery['quantidade'];
			$tabela .= "<tr>";
				$tabela .= utf8_decode("<td>". $rsQuery['idCompra'] ."</td>");
				$tabela .= utf8_decode("<td>". $rsQuery['nome'] . " " . $rsQuery['sobrenome'] ."</td>");
				$tabela .= utf8_decode("<td>". $rsQuery['NomeBrinde'] ."</td>");
				$tabela .= utf8_decode("<td>". $rsQuery['quantidade'] ."</td>");
				$tabela .= utf8_decode("<td>". $rsQuery['motivo'] ."</td>");
				$tabela .= utf8_decode("<td>". $rsQuery['dataCompra'] ."</td>");
				$tabela .= utf8_decode("<td>R$". number_format($rsQuery['valor'], 2, '.', '') ."</td>");
				$tabela .= utf8_decode("<td>R$".number_format($total, 2, '.', '') ."</td>");
				$tabela .= utf8_decode("<td>R$". number_format($rsQuery['valorTotal'], 2, '.', '') ."</td>");
				$tabela .= utf8_decode("<td>". $rsQuery['budgetBrindes'] ."</td>");
				$tabela .= utf8_decode("<td>". $rsQuery['estoque']."</td>");
			$tabela .= "</tr>";
			};
			
	$tabela .= "</table>";
	
		
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header("Content-Type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
		echo $tabela;
		
	}else if($pdf == 2)
	{
require_once("dompdf/dompdf/dompdf_config.inc.php");

/* Cria a instância */
$dompdf = new DOMPDF();

/* Carrega seu HTML */

	 
	 $html = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DMTrix</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/estilos-bibliotecas.css">
</head>

<body>

<img src="img/logo_new.png">
 
 
<div class="clear  secaoInterna">
 <h2>Este é o relatorio de compra de Brindes: </h2></br>
 
 ';
  while($rsQuery2 = odbc_fetch_array($query2)){
	  
 
  $html .= '<table style="width: 100%" border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                	<td style="color: white">Identificação da Solicitação</td>
                    <td style="color: white">Solicitante</td>
                    <td style="color: white">Brinde</td>
                    <td style="color: white">Quantidade</td>
                    <td style="color: white">Motivo da Compra </td>
                    <td style="color: white">Solicitado no Dia</td>
					<td style="color: white">Valor Unitário do brinde</td>
					
					<td style="color: white">Valor Total</td>
					<td style="color: white">budget atual</td>
					<td style="color: white">Estoque</td>
                    <td></td>
                </tr>
            </thead>
			
			<tbody>
                <tr>
                	<td><p align="center">'.$rsQuery2['idCompra'].'</p></td>
                    <td>'.$rsQuery2['nome'].$rsQuery2['sobrenome'].'</td>
                    <td>'.$rsQuery2['NomeBrinde'].'</td>
                    <td>'.$rsQuery2['quantidade'].'</td>
                    <td>'.$rsQuery2['motivo'].'</td>
                    <td>'.$rsQuery2['dataCompra'].'</td>
					<td>'.number_format($rsQuery2['valor'], 2, '.', '').'</td>
					
					<td>'.number_format($rsQuery2['valorTotal'], 2, '.', '').'</td>
					<td>'.$rsQuery2['budgetBrindes'].'</td>
					<td>'.$rsQuery2['estoque'].'</td>
                    
                    
                </tr>
            </tbody>
			
			</table>
			<br>
';
}

$html .= '			</div>	
		
	</body>		
</html>';

$dompdf->load_html($html);

 

/* Renderiza */
$dompdf->render();

/* Exibe */
$dompdf->stream(
    "Relatorio de Brindes.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => true /* Para download, altere para true */
    )
);


}
?>


	}

?>