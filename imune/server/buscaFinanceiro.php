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
$type       = $_GET['type'];
if($type == 1){
    $nome 		= "Contas à Pagar";
}
else if($type == 2){
    $nome 		= "Contas à Receber";
}
else if($type == 3){
    $nome 		= "Contas Pagas";
}
else if($type == 4){
    $nome 		= "Contas Recebidas";
}

if($type == 1 || $type == 2){
    $colunas	= "financeiro.ban_id,financeiro.id,pessoa.nome,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,financeiro.dt_emi,financeiro.dt_fat,financeiro.valorliquido,concat(financeiro.cheque,'',financeiro.boleto) as cheque,pagamento.nome as pagamento,centrocusto.nome as centrocusto,financeiro.obs,financeiro.status as status";
    $tabn		= "id,nome,empresa,banco,Dt. Emis.,Dt. Venc.,valor,Nº C/B,f.pag,c. custo,obs";
}else if($type == 3 || $type == 4){
    $colunas	= "financeiro.ban_id,financeiro.aglutinado,financeiro.id,pessoa.nome,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,financeiro.dt_emi,financeiro.dt_baixa,financeiro.valorliquido,concat(financeiro.cheque,'',financeiro.boleto) as cheque,pagamento.nome as pagamento,centrocusto.nome as centrocusto,financeiro.obs,financeiro.status as status";
    $tabn		= "id,nome,empresa,banco,Dt. Emis.,Dt. Baixa.,valor,Nº C/B,f.pag,c. custo,obs";
}


$tabela		= "financeiro,pessoa,centrocusto,pagamento,empresa,banco where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and financeiro.ban_id = banco.id and financeiro.emp_id = empresa.id and financeiro.pag_id = pagamento.id and financeiro.cen_id = centrocusto.id and pessoa.id = financeiro.pes_id and financeiro.conciliada != 1  and financeiro.status =  '$type' and financeiro.ap = 0";

if(isset($_GET['busca'])){
    $busca = $_GET['busca'];
    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);
    if($busca == ""){
        $select = "select ".$colunas." from ".$tabela." and financeiro.dt_cad between '$mes_start2' and '$mes_end2'";
    }else{
        if($type == 1 || $type == 2){
            $select = "select ".$colunas." from ".$tabela." and (pessoa.nome like '$busca%' or financeiro.id = '$busca' or financeiro.cheque like '$busca%' or empresa.razao like '$busca%' or banco.banco like '$busca%' or financeiro.valorliquido like '%$busca%' or pagamento.nome like '$busca%' or centrocusto.nome like '$busca%' or financeiro.obs like '%$busca%' or financeiro.dt_emi between '".$redata." 00:00:00' and '".$redata." 23:59:59' or financeiro.dt_fat between '".$redata." 00:00:00' and '".$redata." 23:59:59')";
        }
        elseif($type == 3 || $type == 4){
            $select = "select ".$colunas." from ".$tabela." and (pessoa.nome like '$busca%' or financeiro.id = '$busca' or financeiro.cheque like '$busca%' or empresa.razao like '$busca%' or banco.banco like '$busca%' or financeiro.valorliquido like '%$busca%' or pagamento.nome like '$busca%' or centrocusto.nome like '$busca%' or financeiro.obs like '%$busca%' or financeiro.dt_emi between '".$redata." 00:00:00' and '".$redata." 23:59:59' or financeiro.dt_baixa between '".$redata." 00:00:00' and '".$redata." 23:59:59')";
        }
    }
}else{
    $select = "select ".$colunas." from ".$tabela." and financeiro.dt_cad between '$mes_start2' and '$mes_end2' ";
    if($type == 1 || $type == 2){
        $select .= " and financeiro.cen_id != 1 ";
    }else{
        $select .= " and ((financeiro.conciliada = 2) or (financeiro.conciliada = 0 and financeiro.cen_id !=1))";
    }
}

$titulos = "";
$aglutinado = "";
$content = "";
$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $d_emi = substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4);
    if($row['status'] == 1 || $row['status'] == 2){
        $dta = substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4);
    }else if($row['status'] == 3 || $row['status'] == 4){
        $dta = substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4);
        if($row['aglutinado'] == 1){
            $sel = "select financeiro.id,pessoa.nome as pessoa,financeiro.dt_fat,financeiro.valorliquido,concat(financeiro.cheque,financeiro.boleto) as numero,financeiro.obs from financeiro,pessoa where pessoa.id = financeiro.pes_id and financeiro.aglu_id = ".$row['id']." ";
            $content = "";
            $titulos = "";
            $val = mysqli_query($con,$sel);
            while($rr = mysqli_fetch_array($val)){
                $titulos .= $rr['id'].",";
                $content .= "<b>NOME: </b>".substr($rr['pessoa'],0,20)."   |   <b>NÚMERO: </b>".$rr['numero']."   |   <b>VALOR: </b>".$rr['valorliquido']."<br>";
            }
            $titulos = substr($titulos,0,strlen($titulos)-1);
        }
    };
    $sel = '<input type="checkbox" banco="'.$row['ban_id'].'" titulos="'.$titulos.'" aglutinado="'.@$row['aglutinado'].'" name="titulos" pag="'.$row['pagamento'].'"  id="'.$row['id'].'" valor="'.$row['id'].'" status="'.$row['status'].'">';
    array_push($array['data'],array("sel" => $sel,"id" => $row['id'],'nome'=>$row['nome'],'empresa'=>$row['empresa'],'banco'=>$row['banco'],'dt_emi'=>$d_emi,'dt_fat'=>$dta,'valor'=>$row['valorliquido'],'cb'=>$row['cheque'],'pagamento'=>$row['pagamento'],'centrocusto'=>$row['centrocusto'],'obs' => $row['obs'],'aglutinado'=>@$row['aglutinado'],'content'=>$content,'titulos'=>$titulos));
}
echo json_encode($array);

?>


