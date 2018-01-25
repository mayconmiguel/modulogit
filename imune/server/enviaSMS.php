<?php
require_once "../server/seguranca.php";



$usu_id = $_SESSION['imunevacinas']['usuarioID'];
$usu_nome = explode(' ',$_SESSION['imunevacinas']['usuarioNome'])[0];
$num  = $_POST['num'];
$numbers = implode(',',$_POST['num']);





$ch = curl_init();


if($_SESSION['config']['sms'] == 2){
    $msg  = urlencode(utf8_encode($_POST['msg']));
    curl_setopt($ch, CURLOPT_URL, 'http://marketing.allcancesms.com.br/app/modulo/api/index.php?action=sendsms'.$_MT['sms_chave'].'&msg='.$msg.'&numbers='.$numbers);
}else if($_SESSION['config']['sms'] == 1){
    $msg  = $_POST['msg'];
    curl_setopt($ch, CURLOPT_URL, 'http://api.allcancesms.com.br/sms/1/text/single');

    $request_headers = array();
    $request_headers[] = "Authorization: Basic ".$_MT['sms_chave'];
    $request_headers[] = "Content-Type: application/json" ;
    $request_headers[] = "Accept: application/json";

    curl_setopt($ch, CURLOPT_POST, 1);

    $data = json_encode(array(
        'from' => $usu_id."-".$usu_nome,
        'to' => $num,
        'text' => $msg,
        'flash' => true
    ));

    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
}

$head = curl_exec($ch);
curl_close($ch);
return $head;


?>

