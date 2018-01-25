<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "apolice.id,apolice.n_pro,apolice.n_apo,apolice.dt_emissao,apolice.item,pessoa.nome as cliente,(select pes2.nome from pessoa as pes2,apolice as apo2 where apo2.id=apolice.id and pes2.id = apolice.pro_id limit 1) as produtor,(select pes.nome from pessoa as pes,apolice as apo where apo.id=apolice.id and pes.id = apolice.seg_id limit 1) as seguradora,empresa.razao as empresa,apolice.pr_total,apolice.pr_liquido,apolice.tipo,apolice.status,apolice.situacao";
$tabela		= "apolice,pessoa,empresa where apolice.grp_emp_id = '".$_SESSION['imunevacinas']['usuarioEmpresa']."'";
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];

    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);

    $select = "select ".$colunas." from ".$tabela." and (mid(apolice.dt_cad,1,10) = '".$redata."' or n_pro = '$busca' or n_apo = '$busca' or descricao like '%$busca%' or (select pes2.nome from pessoa as pes2,apolice as apo2 where apo2.id=apolice.id and pes2.id = apolice.pro_id limit 1) like '%$busca%' or (select pes.nome from pessoa as pes,apolice as apo where apo.id=apolice.id and pes.id = apolice.seg_id limit 1) like '%$busca%' or pessoa.nome like '%$busca%' or empresa.razao like '%$busca%' or apolice.pr_total like '%$busca%' or apolice.pr_liquido like '%$busca%') and apolice.cli_id = pessoa.id and apolice.emp_id = empresa.id order by apolice.id";
}else{
    $select = "select ".$colunas." from ".$tabela." and (apolice.dt_cad between '$ini' and '$fim' or apolice.situacao = 0) and apolice.cli_id = pessoa.id and apolice.emp_id = empresa.id order by apolice.id desc";
}




$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $d_emi = substr($row['dt_emissao'],8,2)."/".substr($row['dt_emissao'],5,2)."/".substr($row['dt_emissao'],0,4);

    if($row['tipo'] == 1){
        $row['tipo'] = '<label class="label bg-color-greenLight">N</label>';
    }else if($row['tipo'] == 2){
        $row['tipo'] = '<label class="label bg-color-orange">E</label>';
    }else if($row['tipo'] == 3){
        $row['tipo'] = '<label class="label bg-color-blue">R</label>';
    }else if($row['tipo'] == 4){
        $row['tipo'] = '<label class="label bg-color-redLight">C</label>';
    }else if($row['tipo'] == 5){
        $row['tipo'] = '<label class="label bg-color-blueLight">I</label>';
    };

    if($row['status'] == 1){
        $row['status'] = '<label class="label bg-color-pink">P</label>';
    }else if($row['status'] == 2){
        $row['status'] = '<label class="label bg-color-purple">A</label>';
    };

    if($row['situacao'] == 0){
        $row['situacao'] = '<label class="label bg-color-red">À</label>';
    }else if($row['situacao'] == 1){
        $row['situacao'] = '<label class="label bg-color-green">C</label>';
    }

    $sel = '<input type="checkbox" name="titulos" id="'.$row['id'].'" tipo="'.$row['tipo'].'" status="'.$row['status'].'">';
    array_push($array['data'],array("sel" => $sel,"id" => '<label id="identificador" valor="'.$row['id'].'">'.$row['id'].'</label>','n_pro'=>$row['n_pro'],'n_apo'=>$row['n_apo'],'dt_cad'=>$d_emi,'descricao'=>$row['item'],'cliente'=>$row['cliente'],'produtor'=>$row['produtor'],'seguradora'=>$row['seguradora'],'empresa'=>$row['empresa'],'valortotal'=>$row['pr_total'],'valorliquido'=>$row['pr_liquido'],'tipo'=>$row['tipo'],'status'=>$row['status'],'situacao'=>$row['situacao']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


