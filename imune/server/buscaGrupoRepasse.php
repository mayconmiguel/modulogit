<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));
$mes_start = date('01/m/Y');
$mes_start2 = date('Y-m-01', strtotime('-1 month'));
$mes_end = date('t/m/Y');
$mes_end2 = date('Y-m-t', strtotime('+1 month'));
$type       = 1;
$nome 		= "Baixa de Comissão";

$colunas	= "id,nome";


$tabela		= "grupoRepasse";

if(isset($_GET['busca'])){
    $busca = $_GET['busca'];
    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);
    if($busca == "PR1SC1L4"){
        $select = "select ".$colunas." from ".$tabela." ";
    }else{
        $select = "select ".$colunas." from ".$tabela." where (id = '$busca' or nome like '%$busca%')";
    }
}else{
    $select = "select ".$colunas." from ".$tabela." where (id = '$busca' or nome like '%$busca%')";

}

$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){

    array_push($array['data'],array('id'=>$row['id'],'nome'=>$row['nome']));
}
echo json_encode($array);
mysqli_close ( $con );
?>

