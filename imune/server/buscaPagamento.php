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

$colunas	= "  financeiro.id as financeiro, financeiro.dt_fat,financeiro.conciliada,financeiro.apo_id, financeiro.nat_id, financeiro.porcentagem, financeiro.id as financeiro,financeiro.ap,financeiro.qtd,financeiro.parcela,financeiro.obs, apo.n_pro, apo.id as apo_id,financeiro.conciliada as conciliada,financeiro.id,pagamento.nome as pagamento,apo.n_apo,financeiro.dt_fat,financeiro.dt_baixa,(select pessoa.nome from pessoa,apolice as apo2 where apo2.id = apo.id and apo2.cli_id = pessoa.id limit 1) as cliente,pessoa.nome as produtor,(select pessoa.nome from pessoa,apolice as apo3 where apo3.id = apo.id and apo3.seg_id = pessoa.id limit 1) as seguradora,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,financeiro.valorliquido,financeiro.status as status";


$tabela		= "apolice as apo,financeiro,pessoa,pagamento,empresa,banco where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and  apo.status = 2 and financeiro.ban_id = banco.id and financeiro.emp_id = empresa.id and financeiro.pag_id = pagamento.id and pessoa.id = financeiro.pes_id and financeiro.apo_id = apo.id and financeiro.status = 3 and pessoa.produtor = 1 and financeiro.conciliada = 0";

$dt_ini  = substr($_GET['dt_ini'],6,4)."-".substr($_GET['dt_ini'],3,2)."-".substr($_GET['dt_ini'],0,2)." 00:00:00";
$dt_fim  = substr($_GET['dt_fim'],6,4)."-".substr($_GET['dt_fim'],3,2)."-".substr($_GET['dt_fim'],0,2)." 23:59:59";
$busca   = $_GET['busca'];

$select = "select ".$colunas." from ".$tabela." and pessoa.id = '$busca' and dt_baixa between '".$dt_ini."' and '".$dt_fim."'";


$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $dt_venc = substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4);
    $dt_baixa = substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4);
    $conciliada = $row['conciliada'];

    $status = '<label class="label label-success">REPASSE</label>';
    $sel = '<input nat_id="'.$row['nat_id'].'" porcentagem="'.$row['porcentagem'].'" apo_id="'.$row['apo_id'].'" obs="'.$row['obs'].'" checked type="checkbox" ap="'.$row['ap'].'" name="titulos" id="'.$row['id'].'" repasse="'.$row['valorliquido'].'" valor="'.$row['id'].'" conciliada="'.$row['conciliada'].'" status="'.$row['status'].'">';


    array_push($array['data'],array("sel" => $sel,"n_apo" => $row['n_apo'],'dt_venc'=>$dt_venc,'dt_baixa'=>$dt_baixa,'cliente'=>$row['cliente'],'produtor'=>$row['produtor'],'seguradora'=>$row['seguradora'],'empresa'=>$row['empresa'],'valor'=>$row['valorliquido'],'status'=>$status,'financeiro' => $row['financeiro'],'obs' => $row['obs'],'n_pro' => $row['n_pro'],'apo_id' => $row['apo_id'],'qtd' => $row['qtd'],'parcela' => $row['parcela']));
}

$select = "	select financeiro.id as financeiro, financeiro.dt_fat,financeiro.conciliada, financeiro.apo_id, financeiro.nat_id, financeiro.porcentagem, financeiro.valorliquido as repasse,financeiro.ap, financeiro.dt_baixa, financeiro.dt_emi, financeiro.id, financeiro.obs, financeiro.status, empresa.razao as empresa from financeiro,empresa where financeiro.emp_id = empresa.id and financeiro.cen_id = 1 and financeiro.nat_id = 11 and financeiro.pes_id = '".$busca."' and financeiro.dt_baixa between '".$dt_ini."' and '".$dt_fim."' and financeiro.status = 3 and financeiro.conciliada = 0 order by id";
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $dt_venc = substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4);
    $dt_baixa = substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4);
    $status = '<label class="label label-warning">DESCONTO</label>';
    $repasse = number_format($row['repasse'],2,".","");
    $sel = '<input nat_id="'.$row['nat_id'].'" checked porcentagem="'.$row['porcentagem'].'" apo_id="'.$row['apo_id'].'" obs="'.$row['obs'].'" type="checkbox" ap="'.$row['ap'].'" name="titulos" id="'.$row['id'].'" repasse="'.$repasse.'" valor="'.$row['id'].'" conciliada="'.$row['conciliada'].'" status="'.$row['status'].'">';
    array_push($array['data'],array("sel" => $sel,"n_apo" => "",'dt_venc'=>$dt_venc,'dt_baixa'=>$dt_baixa,'cliente'=>"",'produtor'=>"",'seguradora'=>"",'empresa'=>$row['empresa'],'valor'=>$repasse,'status'=>$status,'financeiro' => $row['financeiro'],'obs' => $row['obs'],'n_pro' => "",'apo_id' => "",'qtd' => "",'parcela' => ""));
}

$select = "	select financeiro.id as financeiro, financeiro.dt_fat,financeiro.conciliada, financeiro.apo_id, financeiro.nat_id, financeiro.porcentagem, financeiro.valorliquido as repasse,financeiro.ap, financeiro.dt_baixa, financeiro.dt_emi, financeiro.id, financeiro.obs, financeiro.status, empresa.razao as empresa from financeiro,empresa where financeiro.emp_id = empresa.id and financeiro.cen_id = 1 and financeiro.nat_id = 4 and financeiro.pes_id = '".$busca."' and financeiro.dt_baixa between '".$dt_ini."' and '".$dt_fim."' and financeiro.status = 3 and financeiro.conciliada = 0 order by id";
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $dt_venc = substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4);
    $dt_baixa = substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4);
    $status = '<label class="label label-danger">ADIANTAMENTO</label>';
    $repasse = number_format($row['repasse']*(-1),2,".","");
    $sel = '<input nat_id="'.$row['nat_id'].'" checked porcentagem="'.$row['porcentagem'].'" apo_id="'.$row['apo_id'].'" obs="'.$row['obs'].'" type="checkbox" ap="'.$row['ap'].'" name="titulos" id="'.$row['id'].'" repasse="'.$repasse.'" valor="'.$row['id'].'" conciliada="'.$row['conciliada'].'" status="'.$row['status'].'">';
    array_push($array['data'],array("sel" => $sel,"n_apo" => "",'dt_venc'=>$dt_venc,'dt_baixa'=>$dt_baixa,'cliente'=>"",'produtor'=>"",'seguradora'=>"",'empresa'=>$row['empresa'],'valor'=>$repasse,'status'=>$status,'financeiro' => $row['financeiro'],'obs' => $row['obs'],'n_pro' => "",'apo_id' => "",'qtd' => "",'parcela' => ""));
}

$select = "	select financeiro.id as financeiro, financeiro.dt_fat,financeiro.conciliada, financeiro.apo_id, financeiro.nat_id,financeiro.porcentagem, financeiro.valorliquido as repasse,financeiro.ap, financeiro.dt_baixa, financeiro.dt_emi, financeiro.id, financeiro.obs, financeiro.status, empresa.razao as empresa from financeiro,empresa where financeiro.emp_id = empresa.id and financeiro.cen_id = 1 and financeiro.nat_id = 8 and financeiro.pes_id = '".$busca."' and financeiro.dt_baixa between '".$dt_ini."' and '".$dt_fim."' and financeiro.status = 3 and financeiro.conciliada = 0 order by id";
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $dt_venc = substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4);
    $dt_baixa = substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4);
    $status = '<label class="label label-primary">PREMIAÇÃO</label>';

    $sel = '<input checked nat_id="'.$row['nat_id'].'" porcentagem="'.$row['porcentagem'].'" apo_id="'.$row['apo_id'].'" obs="'.$row['obs'].'" type="checkbox" name="titulos" ap="'.$row['ap'].'" id="'.$row['id'].'" repasse="'.$row['repasse'].'" valor="'.$row['id'].'" conciliada="'.$row['conciliada'].'" status="'.$row['status'].'">';
    array_push($array['data'],array("sel" => $sel,"n_apo" => "",'dt_venc'=>$dt_venc,'dt_baixa'=>$dt_baixa,'cliente'=>"",'produtor'=>"",'seguradora'=>"",'empresa'=>$row['empresa'],'valor'=>$row['repasse'],'status'=>$status,'financeiro' => $row['financeiro'],'obs' => $row['obs'],'n_pro' => "",'apo_id' => "",'qtd' => "",'parcela' => ""));
}


mysqli_close ( $con );
echo json_encode($array);
?>

