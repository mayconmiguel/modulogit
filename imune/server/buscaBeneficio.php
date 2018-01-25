<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "distinct b.id, b.nome, especialidade.nome as especialidade from beneficio as b,especialidade where  especialidade.id = b.esp_id ";
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];

    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);

    $select = "select ".$colunas." and (b.nome like '%$busca%' or b.id = '$busca' or especialidade.nome like '%$busca%') group by nome";
}else{
    $select = "select ".$colunas." group by nome limit 100";
}




$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){


    if($row['origem'] == 1){
        $row['origem'] = '<label class="label bg-color-greenLight">SISTEMA</label>';
    }else if($row['origem'] == 2){
        $row['origem'] = '<label class="label bg-color-orange">SITE</label>';
    }else if($row['origem'] == 3){
        $row['origem'] = '<label class="label bg-color-blue">R</label>';
    }else if($row['origem'] == 4){
        $row['origem'] = '<label class="label bg-color-redLight">C</label>';
    }else if($row['origem'] == 5){
        $row['origem'] = '<label class="label bg-color-blueLight">I</label>';
    };

    array_push($array['data'],array('id'=>'<i id="id">'.$row['id'].'</i>','nome'=>$row['nome'],'especialidade'=>$row['especialidade'],'procedimento'=>$row['procedimento'],'tipo'=>$row['tipo'],'valor'=>$row['valor'],));
}
echo json_encode($array);
mysqli_close ( $con );
?>


