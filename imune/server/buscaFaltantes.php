<?php
require_once "../server/seguranca.php";
header("Content-Type: text/html; charset=UTF-8",true);
mysqli_set_charset($con,"utf8");


$array['data'] = array();

$query = "select pes.id,pes.nome as cliente, consulta.den_id, (select pessoa.nome from pessoa,consulta as con where pessoa.id = con.den_id and con.id = consulta.id) as dentista, pes.telefone, pes.celular, consulta.dt_start as ult_consulta, pes.contador, pes.resposta from consulta, pessoa as pes where pes.id = consulta.cli_id and consulta.status = 5 and consulta.dt_start between '2017-08-01 00:00:00' and '".date('Y-m-d')." 23:59:59' and pes.contador > 0 group by cli_id order by consulta.dt_start desc";



$valida = mysqli_query($con,$query);
while($row=mysqli_fetch_array($valida)){


    $dt_start = substr($row['ult_consulta'],8,2)."/".substr($row['ult_consulta'],5,2)."/".substr($row['ult_consulta'],0,4)." ".substr($row['ult_consulta'],11,5);




    array_push($array['data'],array(

        "id"=>$row['id'],
        "telefone"=>$row['telefone'],
        "celular"=>$row['celular'],
        "cli_id"=>$row['cli_id'],
        "profissional"=>$row['dentista'],
        "pro_id"=>$row['den_id'],
        "ult_consulta"=>"$dt_start",
        "hora"=>$hora,
        "cliente"=>$row['cliente'],
        "ult_lig"=>$ult_lig,
        "faltas"=>$row['contador'],
        "status"=>$status,
        "st"=>$row['status']
    ));
}


echo json_encode($array);
?>