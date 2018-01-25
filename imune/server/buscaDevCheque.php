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
$colunas	= "financeiro.id,financeiro.status,financeiro.dt_baixa,pessoa.nome,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,concat(financeiro.cheque,financeiro.boleto) as cheque,financeiro.valorliquido,financeiro.obs";

$tabela		= "financeiro,pessoa,empresa,banco where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and  banco.id = financeiro.ban_id  and empresa.id = financeiro.emp_id and pessoa.id = financeiro.pes_id and financeiro.cb = 1 and financeiro.status = 6 and financeiro.pag_id = 2";





if(isset($_GET['busca'])){
    $busca = $_GET['busca'];
    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);
    if($busca == ""){
        $select = "select ".$colunas." from ".$tabela." and (financeiro.dt_baixa between '$mes_start2' and '$mes_end2' or financeiro.dt_emi between '$mes_start2' and '$mes_end2')";
    }else{
        $select = "select ".$colunas." from ".$tabela." and(financeiro.id = '$busca' or pessoa.nome like '%$busca%' or empresa.razao like '%$busca%' or banco.banco like '%$busca%' or financeiro.cheque like '%$busca%' or financeiro.valorliquido like '%$busca%' or financeiro.obs like '%$busca%')";
    }
}else{
    $select = "select ".$colunas." from ".$tabela." and (financeiro.dt_baixa between '$mes_start2' and '$mes_end2' or financeiro.dt_emi between '$mes_start2' and '$mes_end2')";
}

$titulos = "";
$aglutinado = "";
$content = "";
$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){

    $sel = '<input type="checkbox" name="titulos" valor="'.$row['id'].'" status="'.$row['status'].'">';
    array_push($array['data'],array("sel" => $sel,"id" => $row['id'],'dt_baixa'=>date('d/m/Y',strtotime($row['dt_baixa'])),'nome'=>$row['nome'],'empresa'=>$row['empresa'],'banco'=>$row['banco'],'valor'=>$row['valorliquido'],'cb'=>$row['cheque'],'obs' => $row['obs']));
}
echo json_encode($array);

?>


