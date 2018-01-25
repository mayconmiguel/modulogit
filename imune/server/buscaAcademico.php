<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "aca.id,aca.matricula,curso.nome as curso,curso.periodos as periodos,aca.turno as turno,aca.turma as turma,empresa.fantasia as unidade,modalidade.nome as modalidade,convenio.nome as convenio,statusCursos.nome as status";
$tabela		= "academico as aca,empresa,modalidade,convenio,curso,statusCursos where aca.status = statusCursos.id and aca.curso = curso.id and aca.modalidade = modalidade.id and aca.convenio = convenio.id and aca.emp_id = empresa.id";
$select     = "select ".$colunas." from ".$tabela." and aca.pes_id =".$_GET['pes_id'];

$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){
    if($row['turno'] == 1){
        $turno = "MATUTINO";
    }
    else if($row['turno'] == 2){
        $turno = "VESPERTINO";
    }
    else if($row['turno'] == 3){
        $turno = "NOTURNO";
    }
    array_push($array['data'],array("matricula"=>"<label id='matricula' valor='".$row['matricula']."' retorno='".$row['id']."'>".$row['matricula']."</label>","curso"=>$row['curso'],"periodos"=>$row['periodos'],"turno"=>$turno,"turma"=>$row['turma'],"unidade"=>$row['unidade'],"modalidade"=>$row['modalidade'],"convenio"=>$row['convenio'],"status"=>$row['status']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


