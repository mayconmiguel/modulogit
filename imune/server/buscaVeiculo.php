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
$colunas	= "veiculo.id,modelo.nome as modelo,marca.nome as marca,veiculo.img as img, veiculo.valor,cor.nome as cor";
$tabela		= "veiculo,modelo,marca,cor";
$array['data']  = array();
mysqli_set_charset($con,"utf8");
if(isset($_GET['busca'])){
    $busca = $_GET['busca'];
    if($busca == "PR1SC1L4"){
        $select = "select ".$colunas." from ".$tabela." where veiculo.mod_id = modelo.id and veiculo.mar_id = marca.id and veiculo.cor_id = cor.id and veiculo.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']."";
    }else{
        $select = "select ".$colunas." from ".$tabela." where veiculo.mod_id = modelo.id and veiculo.mar_id = marca.id and veiculo.cor_id = cor.id and veiculo.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']."  and (veiculo.id = '$busca' or modelo.nome like '%$busca%' or marca.nome like '%$busca%' or cor.nome like '%$busca%')";
    }
    $select .= "  limit 500";
    $valida = mysqli_query($con,$select);
    while($row = mysqli_fetch_array($valida)){

        array_push($array['data'],array("id" => "<span id='id' valor='".$row['id']."'>".$row['id']."</span>",'img'=>'<img width="100px" src="'.$row['img'].'">','marca'=>$row['marca'],'modelo'=>$row['modelo'],'cor'=>$row['cor'],'valor'=>$row['valor']));
    }
}else{
    $select = "select ".$colunas." from ".$tabela." where veiculo.mod_id = modelo.id and veiculo.mar_id = marca.id and veiculo.cor_id = cor.id and veiculo.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']."";
    $select .= "  limit 500";
    $valida = mysqli_query($con,$select);
    while($row = mysqli_fetch_array($valida)){

        array_push($array['data'],array("id" => "<span id='id' valor='".$row['id']."'>".$row['id']."</span>",'img'=>'<img width="100px" src="'.$row['img'].'">','marca'=>$row['marca'],'modelo'=>$row['modelo'],'cor'=>$row['cor'],'valor'=>$row['valor']));
    }
}
echo json_encode($array);
mysqli_close ( $con );
?>


