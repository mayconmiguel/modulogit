<?php
require_once "seguranca.php";
header("Content-Type: text/html; charset=UTF-8",true);
mysqli_set_charset($con,"utf8");

if($_POST['funcao'] == 2){
    $content = file_get_contents('http://marketing.allcancesms.com.br/app/modulo/api/index2.php?action=GetResposta'.$_MT['sms_mkt'].'&dt_ini='.date("Y-m-01").'&dt_fim='.date("Y-m-t"));

    if ($content === false) {

    }else{
        $obj = json_decode($content,true);

        foreach($obj['doc'] as $ob){
            $update = "update sms set codigo = '".$ob['codigo']."', resposta = '".$ob['resposta']."' where codigo = '' and mid(dt_envio,1,10) = '".date('Y-m-d',strtotime(date('Y-m-d'),$ob['dh_entrada']))."' and destino = '".$ob['destino_celular']."'";
            //$update = "select * from sms where  dt_envio = '".$ob['dh_entrada']."' and destino = '".$ob['destino_celular']."'";
            //echo "<br>".$update;
            mysqli_query($con,$update);
        }
    }
}


?>