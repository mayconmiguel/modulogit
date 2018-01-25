<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "centrocusto.nome as centro,fin.id, fin.porcentagem, fin.ex_id as venda, fin.ap, fin.apo_id as item_id, fin.dt_cad, fin.dt_fat, fin.dt_baixa, fin.valorliquido as valor, concat(parcela,'/',qtd) as parcela,fin.status,fin.obs";
$tabela		= "financeiro as fin, centrocusto";
$select     = "select ".$colunas." from ".$tabela." where fin.pes_id =".$_GET['pes_id']." and centrocusto.id = fin.cen_id and fin.aglu_id is null and valorliquido != 0.00 and fin.status < 5";

$array['data']  = array();
$array['total']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
$total = 0;
while($row = mysqli_fetch_array($valida)){
    $procedimento = '';
    $valor = 0;
    if(strlen($row['item_id']) > 0){
        $query = "select pro.id, pro.nome as procedimento, pasta_aux.dente, pessoa.nome as dentista from procedimento as pro, pasta_aux,pessoa where pessoa.id = pasta_aux.den_id and pasta_aux.id = '".$row['item_id']."' and pasta_aux.pro_id = pro.id";
        $val = mysqli_query($con,$query);

        if($r = mysqli_fetch_array($val)){
            $procedimento = $r['procedimento'];
        }else{
            $procedimento = $row['centro'];
        }
    }else{
        $procedimento = 'FINANCEIRO';
    }


    ($row['dt_cad']!= '0000-00-00 00:00:00') ? $dt_cad = date('d/m/Y',strtotime($row['dt_cad'])) : $dt_cad = '';
    ($row['dt_fat']!= '0000-00-00 00:00:00') ? $dt_fat = date('d/m/Y',strtotime($row['dt_fat'])) : $dt_fat = '';
    ($row['dt_baixa']!= '0000-00-00 00:00:00') ? $dt_baixa = date('d/m/Y',strtotime($row['dt_baixa'])) : $dt_baixa = '';



    if($row['status'] == 2){
        $valor = number_format(abs($row['valor']),2,'.','');
        $status = '<span class="label label-danger">À PAGAR</span>';
        $sel = '<input type="checkbox" valor="'.$row['id'].'" obs="'.$row['obs'].'" status="'.$row['status'].'" porcentagem="'.$row['porcentagem'].'" apo_id="'.$row['item_id'].'"  ap="'.$row['ap'].'" repasse="'.$valor.'" name="titulos" id="efetuar_pagamento" data-pk="'.$row['id'].'" checked>';
    }
    else if($row['status'] == 3){

        $valor = number_format(-1 * abs($row['valor']),2,'.','');
        $status = '<span class="label label-warning">ESTORNO</span>';
        $sel = '<input type="checkbox" valor="'.$row['id'].'" obs="'.$row['obs'].'" status="'.$row['status'].'" porcentagem="'.$row['porcentagem'].'" apo_id="'.$row['item_id'].'"  ap="'.$row['ap'].'"  repasse="'.$valor.'" name="titulos" id="efetuar_pagamento" data-pk="'.$row['id'].'" checked disabled>';
    }
    else if($row['status'] == 4){

        $valor = number_format(abs($row['valor']),2,'.','');
        $status = '<span class="label label-primary">PAGO</span>';
        $sel = '<input type="checkbox" valor="'.$row['id'].'" obs="'.$row['obs'].'" status="'.$row['status'].'" porcentagem="'.$row['porcentagem'].'" apo_id="'.$row['item_id'].'" ap="'.$row['ap'].'" repasse="'.$valor.'" name="titulos" id="efetuar_pagamento" data-pk="'.$row['id'].'" checked  disabled>';
    }
    $total += $valor;

    array_push($array['data'],array("sel"=>$sel,"dente"=>$row['dente'],"id"=>$row['id'],"venda"=>$row['venda'],"procedimento" =>$procedimento,"valor"=>$valor,"st"=>$status,"status"=>$row['status'],"dt_cad"=>$dt_cad,"dt_fat"=>$dt_fat,"dt_baixa"=>$dt_baixa,"obs"=>$row['obs']));
}

echo json_encode($array);
mysqli_close ( $con );
?>


