<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "p.dente,p.id, convenio.id as con_id, procedimento.id as pro_id, pessoa.id as den_id, convenio.nome as convenio, procedimento.nome as procedimento,pessoa.nome as dentista,p.dt_exec,p.status";
$tabela		= "pasta_aux as p,procedimento,convenio,pasta,pessoa where pasta.id = p.pas_id and convenio.id = p.con_id and pessoa.id = p.den_id and procedimento.id = p.pro_id ";
$select     = "select ".$colunas." from ".$tabela." and pasta.id =" .$_GET['pasta'];

$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    $dt_exec = substr($row['dt_exec'],8,2)."/".substr($row['dt_exec'],5,2)."/".substr($row['dt_exec'],0,4);
    if($row['status'] == 1){
        $status = "<label id='status' data-pk='".$row['id']."' class='label label-primary'>1 - Em Andamento</label>";
    }
    else if($row['status'] == 2){
        $status = "<label id='status' data-pk='".$row['id']."' class='label label-success'>2 - Concluído</label>";
    }
    else if($row['status'] == 3){
        $status = "<label id='status' data-pk='".$row['id']."' class='label label-danger'>3 - Cancelado</label>";
    }
    else if($row['status'] == 4){
        $status = "<label id='status' data-pk='".$row['id']."' class='label label-default'>4 - Glozado</label>";
    }
    else{
        $status = "<label id='status' data-pk='".$row['id']."' class='label label-warning'>0 - Pendente</label>";
    }

    array_push($array['data'],array("dente1"=>$row['dente'],"dente"=>'<mirai id="dente">'.$row['dente'].'</mirai>',"pro_id"=>$row['pro_id'],"den_id"=>$row['den_id'],"numero"=>"<label id='numero' valor='".$row['id']."' retorno='".$row['id']."'>".$row['id']."</label>","procedimento"=>$row['procedimento'],"dentista"=>'<mirai id="dentista">'.$row['dentista'].'</mirai>',"convenio"=>$row['convenio'],"dt_exec"=>$dt_exec,"status"=>$status,"st"=>$row['status']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


