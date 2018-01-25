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

$nome = "Contas Conciliadas";

$colunas	= "financeiro.id,pessoa.nome,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,financeiro.dt_emi,financeiro.dt_baixa,financeiro.valorliquido,financeiro.cheque as cheque,pagamento.nome as pagamento,centrocusto.nome as centrocusto,financeiro.obs,financeiro.status as status";
$tabn		= "id,nome,empresa,banco,Dt. Emis.,Dt. Baixa.,valor,Nº C/B,f.pag,c. custo,obs,p/r";


$tabela		= "financeiro,pessoa,centrocusto,pagamento,empresa,banco where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and  financeiro.ban_id = banco.id and financeiro.emp_id = empresa.id and financeiro.pag_id = pagamento.id and financeiro.cen_id = centrocusto.id and pessoa.id = financeiro.pes_id and financeiro.conciliada = 1 ";

if(isset($_GET['busca'])){
    $busca = $_GET['busca'];
    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);
    if($busca == ""){
        $select = "select ".$colunas." from ".$tabela." and financeiro.dt_cad between '$mes_start2' and '$mes_end2'";
    }else{
        $select = "select ".$colunas." from ".$tabela." and (pessoa.nome like '$busca%' or financeiro.id = '$busca' or financeiro.cheque like '$busca%' or empresa.razao like '$busca%' or banco.banco like '$busca%' or financeiro.valorliquido like '%$busca%' or pagamento.nome like '$busca%' or centrocusto.nome like '$busca%' or financeiro.obs like '%$busca%' or mid(financeiro.dt_emi,1,10) = '".$redata."' or mid(financeiro.dt_baixa,1,10) = '".$redata."') and financeiro.conciliada = 1";
    }
}else{
    $select = "select ".$colunas." from ".$tabela." and financeiro.dt_cad between '$mes_start2' and '$mes_end2'";

}



$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $d_emi = substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4);
    $dta = substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4);
    if($row['status'] == 3){
        $status = '<label class="label label-primary">P</label>';
    }else if($row['status'] == 4){
        $status = '<label class="label label-success">R</label>';
    };

    array_push($array['data'],array("id" => $row['id'],'nome'=>$row['nome'],'empresa'=>$row['empresa'],'banco'=>$row['banco'],'dt_emi'=>$d_emi,'dt_fat'=>"<a href='javascript:void(0)' data-type='text' data-pk='".$row['id']."' data-value='".$dta."' data-format='YYYY-MM-DD' data-viewformat='DD/MM/YYYY' id='dt_baixa'>".$dta."</a>",'valor'=>$row['valorliquido'],'cb'=>$row['cheque'],'pagamento'=>$row['pagamento'],'centrocusto'=>$row['centrocusto'],'obs' => $row['obs'],'pr' => $status));
}
echo json_encode($array);
mysqli_close ( $con );
?>


