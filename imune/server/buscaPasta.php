<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "pasta.id,pasta.numero,especialidade.nome as especialidade, empresa.razao as unidade ";
$tabela		= "pasta,especialidade,empresa where especialidade.id = pasta.esp_id and empresa.id = pasta.emp_id ";
$select     = "select ".$colunas." from ".$tabela." and pasta.pes_id =".$_GET['pes_id'];

$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){

    array_push($array['data'],array("numero"=>"<label id='numero' valor='".$row['numero']."' retorno='".$row['id']."'>".$row['numero']."</label>","especialidade"=>'<label id="especialidade" retorno="'.$row['especialidade'].'">'.$row['especialidade'].'</label>',"unidade"=>$row['unidade']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


