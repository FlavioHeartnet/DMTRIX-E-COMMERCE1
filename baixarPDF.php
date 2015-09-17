<?php



if(isset($_POST['pdf'])){
	
	$loja = $_POST['loja'];
	$idCartao = $_POST['idCartao'];
	$descricao = $_POST['descricao'];
	$solicitante = $_POST['solicitante'];
	$data = $_POST['data'];
	$site=$_POST['site'];
	
	$count = count($loja);

/* Carrega a classe DOMPdf */
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
 <h2>Este é o relatorio dos pedidos pesquisados: </h2></br>
 
 ';
  for($i = 0;$i < $count;$i++){
	  
 
  $html .= '<table style="width: 100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                	<td style="color: white">Codigo da Compra</td>
                    <td style="color: white">Data</td>
                    <td style="color: white">Solicitante</td>
                    <td style="color: white">Loja</td>
                    <td style="color: white">Site do Cliente: </td>
                    <td style="color: white">Descricao</td>
                    <td></td>
                </tr>
            </thead>
			
			<tbody>
                <tr>
                	<td><p align="center">'.$idCartao[$i].'</p></td>
                    <td>'.$data[$i].'</td>
                    <td>'.$solicitante[$i].'</td>
                    <td>'.$loja[$i].'</td>
                    <td><a href="'.$site[$i].'">Site</a></td>
                    <td>'.$descricao[$i].'</td>
                    
                    
                </tr>
            </tbody>
			
			</table>
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
    "Relatorio de Cartões.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => false /* Para download, altere para true */
    )
);


}
?>

