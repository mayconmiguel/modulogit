<?php
require_once "seguranca.php";

$data = $_POST['data'];
if($_GET['funcao'] == 1){
    $query = "insert into beneficio(nome,esp_id,pro_id,tipo,valor)values";
}
foreach($data as $dt){
    if($_GET['funcao'] == 1){
        $query .= "('".$dt['nome']."','".$dt['especialidade']."','".$dt['procedimento']."','".$dt['tipo']."','".$dt['valor']."'),";
    }
}
if($_GET['funcao'] == 1){
    $query = substr($query,0,strlen($query)-1).";";
    if(mysqli_query($con,$query)){
        echo 1;
    }else{
        echo mysqli_errno($con)." - ".mysqli_error($con);
    }
}





?>