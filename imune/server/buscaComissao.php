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

$colunas	= "financeiro.id as financeiro,concat(financeiro.parcela,'/',financeiro.qtd) as parc,financeiro.qtd,financeiro.parcela,financeiro.obs, apo.n_pro, apo.id as apo_id,financeiro.conciliada as conciliada,financeiro.id,pagamento.nome as pagamento,apo.n_apo,financeiro.dt_fat,financeiro.dt_baixa,(select pessoa.nome from pessoa,apolice as apo2 where apo2.id = apo.id and apo2.cli_id = pessoa.id limit 1) as cliente,pessoa.nome as produtor,(select pessoa.nome from pessoa,apolice as apo3 where apo3.id = apo.id and apo3.seg_id = pessoa.id limit 1) as seguradora,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,financeiro.valorbruto,financeiro.valorliquido,financeiro.status as status";


$tabela		= "apolice as apo,financeiro,pessoa,pagamento,empresa,banco where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and apo.status = 2 and financeiro.ban_id = banco.id and financeiro.emp_id = empresa.id and financeiro.pag_id = pagamento.id and pessoa.id = financeiro.pes_id and financeiro.apo_id = apo.id and (financeiro.status = 1 or financeiro.status = 3) and pessoa.produtor = 1";

if(isset($_GET['busca'])){
    $busca = $_GET['busca'];
    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);
    if($busca == "PR1SC1L4"){
        $select = "select ".$colunas." from ".$tabela." ";
    }else{
        $select = "select ".$colunas." from ".$tabela." and ((select pessoa.nome from pessoa,apolice as apo2 where apo2.id = apo.id and apo2.cli_id = pessoa.id limit 1) like '$busca%' or (pessoa.nome like '$busca%') or (select pessoa.nome from pessoa,apolice as apo3 where apo3.id = apo.id and apo3.seg_id = pessoa.id limit 1) like '$busca%' or banco.banco like '%$busca%' or financeiro.valorliquido like '%$busca%' or apo.n_apo like '$busca%' or empresa.razao like '$busca%' or mid(financeiro.dt_emi,1,10) = '".$redata."' or mid(financeiro.dt_fat,1,10) = '".$redata."' or mid(financeiro.dt_baixa,1,10) = '".$redata."' or financeiro.obs like '%$busca%' or apo.id = '$busca' or apo.n_pro = '$busca' or apo.n_apo = '$busca') and financeiro.conciliada = 0";
    }
}else{
    $select = "select ".$colunas." from ".$tabela." and financeiro.dt_cad between '$mes_start2' and '$mes_end2' and financeiro.conciliada = 0";

}


$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $dt_venc = substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4);
    $dt_baixa = substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4);
    $conciliada = $row['conciliada'];
    if($conciliada != 0){
        $status = '<label title="Conciliada" class="label bg-color-blueDark">C</label>';
        $sel = '<input type="checkbox" name="titulos" id="'.$row['id'].'" valor="'.$row['id'].'" conciliada="'.$row['conciliada'].'" status="'.$row['status'].'" disabled>';
    }else{
        if($row['status'] == 1){
            $status = '<label title="Pendente" class="label label-warning">P</label>';
            $sel = '<input type="checkbox" name="titulos" id="'.$row['id'].'" valor="'.$row['id'].'" conciliada="'.$row['conciliada'].'" status="'.$row['status'].'">';
        }else if($row['status'] == 3){
            $status = '<label title="Baixada" class="label label-success">B</label>';
            $sel = '<input type="checkbox" name="titulos" id="'.$row['id'].'" valor="'.$row['id'].'" conciliada="'.$row['conciliada'].'" status="'.$row['status'].'">';
        };
    };

    array_push($array['data'],array("sel" => $sel,"n_apo" => $row['n_apo'],'dt_venc'=>$dt_venc,'dt_baixa'=>$dt_baixa,'parc'=>$row['parc'],'cliente'=>$row['cliente'],'produtor'=>$row['produtor'],'seguradora'=>$row['seguradora'],'empresa'=>$row['empresa'],'valorbruto'=>$row['valorbruto'],'valorliquido'=>$row['valorliquido'],'status'=>$status,'financeiro' => $row['financeiro'],'obs' => $row['obs'],'n_pro' => $row['n_pro'],'apo_id' => $row['apo_id'],'qtd' => $row['qtd'],'parcela' => $row['parcela']));
}
echo json_encode($array);
mysqli_close ( $con );
?>

