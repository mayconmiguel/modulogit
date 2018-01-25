<?php
require_once "../server/seguranca.php";



$ch = curl_init();

if($_SESSION['config']['sms'] == 2){
    curl_setopt($ch, CURLOPT_URL, 'http://corporativo.allcancesms.com.br/app/modulo/api/index.php?action=getbalance'.$_MT['sms_mkt']);

}else{
    curl_setopt($ch, CURLOPT_URL, 'http://api.allcancesms.com.br/account/1/balance');

    $request_headers = array();
    $request_headers[] = "Authorization: Basic ".$_MT['sms_chave'];
    $request_headers[] = "Content-Type: application/json" ;
    $request_headers[] = "Accept: application/json";

    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
}




$head = curl_exec($ch);
curl_close($ch);
return $head;



?>

