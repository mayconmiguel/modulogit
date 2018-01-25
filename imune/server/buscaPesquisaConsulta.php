<?php
require_once "../server/seguranca.php";
header("Content-Type: text/html; charset=UTF-8",true);
mysqli_set_charset($con,"utf8");


$array['data'] = array();

$query = "select consulta.dt_start, pessoa.nome as dentista, consulta.status from pessoa,consulta where pessoa.id = consulta.den_id and consulta.dt_start between '".date('Y-01-01 00:00:00')."' and '".date('Y-12-t 23:59:59')."' and consulta.cli_id = ".$_GET['cli_id'];

$valida = mysqli_query($con,$query);
while($row=mysqli_fetch_array($valida)){
    if($row['status'] == 1){
        $status = "<label class='label bg-color-blueDark' id='contato'>1 - AGENDADO(A)</label>";
    }
    else if($row['status'] == 2){
        $status = "<label class='label label-primary' id='contato'>2 - CONFIRMADO(A)</label>";
    }
    else if($row['status'] == 3){
        $status = "<label class='label bg-color-green' id='contato'>3 - COMPARECIDO(A)</label>";
    }
    else if($row['status'] == 4){
        $status = "<label class='label label-warning' id='contato'>4 - REMARCADO(A)</label>";
    }
    else if($row['status'] == 5){
        $status = "<label class='label label-danger' id='contato'>5 - NÃO COMPARECIDO(A)</label>";
    }
    else if($row['status'] == 6){
        $status = "<label class='label bg-color-redLight' id='contato'>6 - CANCELADO(A)</label>";
    }
    else if($row['status'] == 7){
        $status = "<label class='label bg-color-blueLight' id='contato'>7 - ENCAIXADO(A)</label>";
    }

    $dt_start = substr($row['dt_start'],8,2)."/".substr($row['dt_start'],5,2)."/".substr($row['dt_start'],0,4);
    $hora     = substr($row['dt_start'],11,5);


    array_push($array['data'],array("dt_start"=>$dt_start,"hora"=>$hora,"profissional"=>$row['dentista'],"status"=>$status));
}


echo json_encode($array);
?>

