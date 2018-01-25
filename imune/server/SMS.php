<?php
require_once "seguranca.php";

$data = $_REQUEST['data'];
$funcao = $_REQUEST['funcao'];
if(!isset($_SESSION['imunevacinas'])){
    $nome = 'SISTEMA';
}else{
    $nome = $_SESSION["imunevacinas"]['usuarioID']."-".$_SESSION['imunevacinas']['usuarioNome'];
    $empresa = $_SESSION["imunevacinas"]['usuarioEmpresa'];
}

if($funcao == 1){
    $content = file_get_contents('http://marketing.allcancesms.com.br/app/modulo/api/index.php?action=GetCampanha'.$_MT['sms_mkt'].'&idCamp='.$data);

    if ($content === false) {
        // Handle the error
    }else{
        $obj = json_decode($content,true);
        $mensagem = $obj['msg'];

        $query = "insert into campanha_sms(campanha)values('".$data."')";
        $valida = mysqli_query($con,$query);

        foreach($obj['doc'] as $ob){
            print_r ($ob);
            echo $ob['status'];
            if($ob['status'] == "SUCESSO"){
                $status = '3';
            }else if($ob['status'] == 'Aguardando envio'){
                $status = '1';
            }
            else if($ob['status'] == 'Numero invalido' || $ob['status'] == 'Numero invalido no Brasil'){
                $status = '2';
            }
            else{
                $status = '0';
            }
            $query = "insert into sms(dt_envio,campanha,nome,destino,msg,status,grp_emp_id)values('".$ob['dh_entrada']."','".$ob['codigo_campanha']."','".$nome."','".$ob['destino_celular']."','".$mensagem."','".$status."','".$empresa."')";
            $valida = mysqli_query($con,$query);


        }

    }
}
else if($funcao == 2){
    $query = "select * from campanha_sms where mid(dt_cad,1,10) = '".date('Y-m-d')."'";
    $valida = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($valida)){
        $content = file_get_contents('http://marketing.allcancesms.com.br/app/modulo/api/index.php?action=GetCampanha'.$_MT['sms_mkt'].'&idCamp='.$row['campanha']);

        if ($content === false) {

        }else{
            $obj = json_decode($content,true);

            foreach($obj['doc'] as $ob) {
                if($ob['status'] == "SUCESSO"){
                    $status = '3';
                }else if($ob['status'] == 'Aguardando envio'){
                    $status = '1';
                }
                else if($ob['status'] == 'Numero invalido' || $ob['status'] == 'Numero invalido no Brasil'){
                    $status = '2';
                }
                else{
                    $status = '0';
                }
                $update = "update sms set dt_envio = '".$ob['dh_entrada']."', status = $status where campanha='" . $row['campanha'] . "' and  destino = '" . $ob['destino_celular'] . "'";

                mysqli_query($con,$update);
            };
        }
    }
}



?>