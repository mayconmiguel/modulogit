<?php
    header("Content-Type: text/html; charset=UTF-8",true);
    require_once "seguranca.php";
mysqli_set_charset($con,"utf8");
    $tabela = $_POST['tabela'];
    $coluna = $_POST['coluna'];

    if($coluna == 'telefone' || $coluna == 'celular'){
        $valor  = str_replace("-","",str_replace(" ","",str_replace(")","",str_replace("(","",$_POST['valor']))));
    }else{
        $valor  = $_POST['valor'];
    }
    $id     = $_POST['id'];

if($coluna == "dt_baixa"){
    $valor = substr($valor,6,4)."-".substr($valor,3,2)."-".substr($valor,0,2);
}

    $query = "update ignore ".$tabela." set ".$coluna." = '".$valor."' where id = '".$id."'";

    if(mysqli_query($con,$query)){
        echo 1;
    }else{
        echo 0;
    }
?>