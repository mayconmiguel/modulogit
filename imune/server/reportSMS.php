<?php
require_once "../server/seguranca.php";
header("Content-Type: text/html; charset=UTF-8",true);
mysqli_set_charset($con,"utf8");
$ch = curl_init();

$array['results'] = array();

if($_SESSION['config']['sms'] == 2){

    $query = "select (select pessoa.nome from pessoa where pessoa.celular = sms.destino order by pessoa.nome limit 1) as cliente,sms.id,sms.resposta,sms.contato,sms.campanha as messageId, sms.destino as 'to', sms.nome as 'from', sms.msg as text, sms.dt_envio as sentAt, sms.count as smsCount, sms.status from sms where sms.grp_emp_id = '".$_SESSION['imunevacinas']['usuarioEmpresa']."' group by concat(mid(sms.dt_envio,1,12),sms.destino) order by sms.dt_envio desc limit 5000";
    $valida = mysqli_query($con,$query);
    while($row=mysqli_fetch_array($valida)){
        if($row['contato'] == 1){
            $contato = "<label class='label label-info' id='contato'>1 - Realizado</label>";
        }else{
            $contato = "<label class='label label-warning' id='contato'>0 - Pendente</label>";
        }

        array_push($array['results'],array("cliente"=>$row['cliente'],"id"=>$row['id'],"cont"=>$contato,"contato"=>$row['contato'],"resposta"=>$row['resposta'],"messageId"=>$row['messageId'],"to"=>$row['to'],"from"=>$row['from'],"text"=>$row['text'],"sentAt"=>$row['sentAt'],"smsCount"=>$row['smsCount'],"status"=>array("groupId"=>$row['status'])));
    }


    echo json_encode($array);

}else{
    curl_setopt($ch, CURLOPT_URL, 'http://api.allcancesms.com.br/sms/1/logs?limite=10000&limit=10000');

    $request_headers = array();
    $request_headers[] = "Authorization: Basic ".$_MT['sms_chave'];
    $request_headers[] = "Content-Type: application/json" ;
    $request_headers[] = "Accept: application/json";
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    $head = curl_exec($ch);
    curl_close($ch);
    $retorno = json_decode($head,true);
    foreach($retorno['results'] as $r){
        $r['sentAt'] = date('Y-m-d H:i:s',strtotime($r['sentAt']));
        array_push($array['results'],array("messageId"=>$r['messageId'],"to"=>$r['to'],"from"=>$r['from'],"text"=>$r['text'],"sentAt"=>$r['sentAt'],"smsCount"=>$r['smsCount'],"status"=>array("groupId"=>$r['status']['groupId'])));

    }
    echo json_encode($array);
}


?>

