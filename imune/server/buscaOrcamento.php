<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "insc.procedimentos,insc.id,insc.dt_cad,insc.nome,beneficio.nome as convenio,insc.telefone,insc.celular,pessoa.nome as dentista, insc.valor, indicacao.nome as contato, insc.status, insc.obs";
$tabela		= "orcamento as insc, pessoa, beneficio, indicacao ";
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];

    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);

    $select = "select ".$colunas." from ".$tabela." where indicacao.id = insc.contato and beneficio.id = insc.convenio and pessoa.id = insc.pes_id and (nome like '%$busca%' or id = '$busca' or cpf like '%$busca%' or telefone like '%$busca%' or celular like '%$busca%' or email like '%$busca%')";
}else{
    $select = "select ".$colunas." from ".$tabela." where indicacao.id = insc.contato and beneficio.id = insc.convenio and pessoa.id = insc.dentista";
}




$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){

    $data = substr($row['dt_cad'],8,2)."/".substr($row['dt_cad'],5,2)."/".substr($row['dt_cad'],0,4);

    if($row['status'] == 0){
        $status = '<label class="label label-danger">0 - EM ABERTO</label>';
    }else if($row['status'] == 1){
        $status = '<label class="label label-primary">1 - VENDA</label>';
    }else if($row['status'] == 2){
        $status = '<label class="label label-default">2 - ENCERRADO</label>';
    };

    array_push($array['data'],array('id'=>'<i id="id">'.$row['id'].'</i>','nome'=>$row['nome'],'dt_cad'=>$data,'valor'=>$row['valor'],'contato'=>$row['contato'],'vendedor'=>$row['vendedor'],'convenio'=>$row['convenio'],'dentista'=>$row['dentista'],'obs'=>$row['obs'],'email'=>$row['email'],'celular'=>$row['celular'],'telefone'=>$row['telefone'],'cpf'=>$row['cpf'],'st'=>$row['status'],'status'=>$status,'procedimentos'=>$row['procedimentos']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


