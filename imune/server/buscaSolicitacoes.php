<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "sol.id, sol.dt_cad, sol.solicitacao, setor.nome as setor, pessoa.nome as solicitante, sol.dt_end, sol.status";
$tabela		= "solicitacao as sol,setor,pessoa ";
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];

    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);

    $select = "select ".$colunas." from ".$tabela." where pessoa.id = sol.pes_id and setor.id = sol.set_id and (pessoa.nome like '%$busca%' or pes.id = '$busca' or sol.solicitacao like '%$busca%' or setor.nome like '%$busca%')";
}else{
    $select = "select ".$colunas." from ".$tabela." where pessoa.id = sol.pes_id and setor.id = sol.set_id";
}



$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){

    $dt_cad = date('d/m/Y H:i:s', strtotime($row['dt_cad']));
    if($row['dt_end'] == '' || strlen($row['dt_end']) == 0){
        $dt_end = '';
    }else{
        $dt_end = date('d/m/Y H:i:s', strtotime($row['dt_end']));
    }
    if($row['status'] == 1){
        $row['status'] = '<label class="label bg-color-greenLight">ABERTO</label>';
    }else if($row['status'] == 2){
        $row['status'] = '<label class="label bg-color-orange">EM ANÁLISE</label>';
    }else if($row['status'] == 3){
        $row['status'] = '<label class="label bg-color-blue">FINALIZADO</label>';
    }else if($row['status'] == 4){
        $row['status'] = '<label class="label bg-color-redLight">CANCELADO</label>';
    };

    array_push($array['data'],array('id'=>'<i id="id">'.$row['id'].'</i>','dt_cad'=>$dt_cad,'solicitacao'=>$row['solicitacao'],'solicitante'=>$row['solicitante'],'dt_end'=>$dt_end,'setor'=>$row['setor'],'status'=>$row['status']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


