<?php
require_once "seguranca.php";
$funcao = $_GET['funcao'];
$empresa = $_SESSION['imunevacinas']['usuarioID'];
@$_POST['cpf']      = str_replace("/","",str_replace("-","",str_replace(".","",$_POST['cpf'])));
@$_POST['rg']       = str_replace(".","",$_POST['rg']);
@$_POST['nasc'] 	= substr($_POST['nasc'],6,4)."-".substr($_POST['nasc'],3,2)."-".substr($_POST['nasc'],0,2);
@$_POST['cep']      = str_replace("-","",$_POST['cep']);
@$_POST['telefone'] = str_replace(" ","",str_replace(")","",str_replace("(","",str_replace("-","",$_POST['telefone']))));
@$_POST['celular']  = str_replace(" ","",str_replace(")","",str_replace("(","",str_replace("-","",$_POST['celular']))));
if($funcao == 1){
    foreach($_POST as $key => $value)
    {
        @$campos .= $key.",";
        @$valores .= "'".$value."',";
    }

    $campos .= "grp_emp_id,dt_cad,us_cad";
    $valores.= "'".$_SESSION['imunevacinas']['usuarioEmpresa']."','".date('Y-m-d H:i:s')."','".$empresa."'";
    mysqli_set_charset($con,"utf8");
    $query = "insert ignore  into pessoa($campos)values($valores)";

    if(strpos($query, 'drop ') !== false || strpos($query, 'alter ') !== false || strpos($query, 'delete ') !== false || strpos($query, 'replace ') !== false) {

    }else{
        if(mysqli_query($con,$query)){
            echo (int)mysqli_insert_id($con);
        }else{
            echo mysqli_errno($con)." - ".mysqli_error($con);
        }
    }
}
else if($funcao == 2){
    foreach($_POST as $key => $value)
    {
        @$valores .= $key."='".$value."',";
    }

    $valores = substr($valores,0,strlen($valores)-1);
    mysqli_set_charset($con,"utf8");
    $query = "update ignore pessoa set $valores where id = " . $_GET['id'];
    
    if(strpos($query, 'drop ') !== false || strpos($query, 'alter ') !== false || strpos($query, 'delete ') !== false || strpos($query, 'replace ') !== false) {

    }else{
        if(mysqli_query($con,$query)){
            echo $_GET['id'];
        }else{
            echo mysqli_errno($con)." - ".mysqli_error($con);
        }
    }
}
elseif($funcao == 3)
{
    $delete = "delete from pessoa where id = '".$_POST['id']."'";
    $valida = mysqli_query($con,$delete);
    if($valida)
    {
        echo 1; 
    }
    else
    {
        echo 0;
    }
};
mysqli_close ( $con );

?>