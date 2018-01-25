<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");



$colunas	= "cartao.id,cartao.vacina,cartao.dose,cartao.dt_aplicacao,cartao.dt_retorno,cartao.validade,cartao.unidade";
$tabela		= "cartao";
$array['data']  = array();
mysqli_set_charset($con,"utf8");

if(isset($_POST['busca'])){
    $busca = $_POST['busca'];

    if($busca == "PR1SC1L4"){
        $select = "select ".$colunas." from ".$tabela;
    }else{
        $select = "select ".$colunas." from ".$tabela;
    }
    $select .= " order by dt_atu desc, id desc limit 500";
    $valida = mysqli_query($con,$select);

    while($row = mysqli_fetch_array($valida)){

        array_push($array['data'],array("id"=>$row['id'],"nome"=>$row['nome']));
    }


}else{
    $select = "select ".$colunas." from ".$tabela;
    $select .= " order by id desc, id desc limit 500";
    $valida = mysqli_query($con,$select);
    while($row = mysqli_fetch_array($valida)){

        //$row['nasc'] = substr($row['nasc'],8,2)."/".substr($row['nasc'],5,2)."/".substr($row['nasc'],0,4);
        //$row['vencimento'] = ($row['vencimento'] != '0000-00-00')?date('d/m/Y',strtotime($row['vencimento'])):'00/00/0000';

        array_push($array['data'],$row);
    }
}

echo json_encode($array);
mysqli_close ( $con );
?>


