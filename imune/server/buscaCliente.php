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


$colunas	= "pessoa.id,pessoa.nome,pessoa.nomepai,pessoa.nomemae,pessoa.nasc";
$tabela		= "pessoa";
$array['data']  = array();
mysqli_set_charset($con,"utf8");
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];

    if($busca == "PR1SC1L4"){
        $select = "select ".$colunas." from ".$tabela." where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and cliente = 1";
    }else{
        $select = "select ".$colunas." from ".$tabela." where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and cliente = 1 and (id = '$busca' or ficha2 = '$busca' or nome like '%$busca%' or cpf = '$busca')";
    }
    $select .= " order by dt_atu desc, id desc limit 500";
    $valida = mysqli_query($con,$select);
    while($row = mysqli_fetch_array($valida)){

        array_push($array['data'],array("id"=>$row['id'],"nome"=>$row['nome']));
    }


}else{
    $select = "select ".$colunas." from ".$tabela." where pessoa.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and cliente = 1";
    $select .= " order by id desc, id desc limit 500";
    $valida = mysqli_query($con,$select);
    while($row = mysqli_fetch_array($valida)){

        //$row['nasc'] = substr($row['nasc'],8,2)."/".substr($row['nasc'],5,2)."/".substr($row['nasc'],0,4);
        $row['nasc'] = ($row['nasc'] != '0000-00-00')?date('d/m/Y',strtotime($row['nasc'])):'00/00/0000';

        array_push($array['data'],$row);
    }
}


echo json_encode($array);
mysqli_close ( $con );
?>


