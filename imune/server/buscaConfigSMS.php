<?php
header("Content-Type: text/html; charset=UTF-8",true);

require_once("../server/seguranca.php");
$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));

$fim       = date('Y-m-t')." 23:59:59";
$ini = date('Y-m-01 00:00:00', strtotime('-1 month'));



$colunas	= "id,nome,msg,tipo,valor,status";
$tabela		= "config_sms";


$select = "select ".$colunas." from ".$tabela." where grp_emp_id = $empresa";


$array['data']  = array();
mysqli_set_charset($con,"utf8");
$valida = mysqli_query($con,$select);
while($row = mysqli_fetch_array($valida)){


    if($row['status'] == 1){
        $status = '<label class="label label-success">ATIVO</label>';
    }else{
        $status = '<label class="label label-danger">INATIVO</label>';
    };

    array_push($array['data'],array('id'=>$row['id'],'nome'=>"<mirai id='nome'>".$row['nome']."</mirai>",'msg'=>"<mirai id='msg'>".$row['msg']."</mirai>",'status'=>"<mirai id='status'>".$status."</mirai>",'st'=>$row['status']));
}
echo json_encode($array);
mysqli_close ( $con );
?>


