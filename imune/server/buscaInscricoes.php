<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "insc.id,insc.nome,insc.cpf,insc.telefone,insc.celular,insc.email,insc.origem,insc.especial,curso1.nome as curso1,curso2.nome as curso2 ";
$tabela		= "inscricao as insc,curso as curso1, curso as curso2 ";
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];

    $redata = substr($_GET['busca'],6,4)."-".substr($_GET['busca'],3,2)."-".substr($_GET['busca'],0,2);

    $select = "select ".$colunas." from ".$tabela." where curso1.id = insc.curso1 and curso2.id = insc.curso2 and (nome like '%$busca%' or id = '$busca' or cpf like '%$busca%' or telefone like '%$busca%' or celular like '%$busca%' or email like '%$busca%')";
}else{
    $select = "select ".$colunas." from ".$tabela." where curso1.id = insc.curso1 and curso2.id = insc.curso2";
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

    array_push($array['data'],array('id'=>'<i id="id">'.$row['id'].'</i>','nome'=>$row['nome'],'curso1'=>$row['curso1'],'curso2'=>$row['curso2'],'obs'=>$row['especial'],'email'=>$row['email'],'celular'=>$row['celular'],'telefone'=>$row['telefone'],'cpf'=>$row['cpf'],'origem'=>$row['origem']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


