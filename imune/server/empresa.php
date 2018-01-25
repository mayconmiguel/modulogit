<?php
require_once "seguranca.php";

// recebimento de variáveis metodo post apenas.
@$funcao     = $_POST['funcao'];
@$susep      = $_POST['susep'];
@$razao       = utf8_decode($_POST['nome']);
@$fantasia   = utf8_decode($_POST['fantasia']);
@$cnpj        = str_replace(".","",str_replace("/","",str_replace("-","",str_replace(".","",$_POST['cnpj']))));
@$cep        = $_POST['cep'];
@$endereco   = utf8_decode($_POST['endereco']);
@$numero     = $_POST['numero'];
@$bairro     = utf8_decode($_POST['bairro']);
@$cidade     = utf8_decode($_POST['cidade']);
@$estado     = $_POST['estado'];
@$telefone   = str_replace(" ","",str_replace(")","",str_replace("(","",str_replace("-","",$_POST['telefone']))));
@$email      = $_POST['email'];
@$bancos      = implode(",",$_POST['bancos']);
@$contato    = utf8_decode($_POST['contato']);

@$obs        = utf8_decode($_POST['obs']);
@$busca      = $_POST['busca'];
@$id         = $_POST['id'];
$today       = date("Y-m-d H:i:s");
$grupoEmpresa       = $_SESSION['imunevacinas']['usuarioEmpresa'];



// validando se é inclusão, exclusão ou edição de dados.

if($funcao == 1)
{
    $select = "select * from empresa where grp_emp_id = $grupoEmpresa and  cnpj = '$cnpj'";
    $valida = mysqli_query($con,$select);
    if($row = mysqli_fetch_array($valida))
    {
        echo 2;
    }
    else
    {
        $insert = "insert ignore into empresa(grp_emp_id,bancos,susep,razao,fantasia,dt_cad,cnpj,endereco,numero,bairro,cidade,estado,cep,telefone,email,contato,obs)values('$grupoEmpresa','$bancos','$susep','$razao','$fantasia','$today','$cnpj','$endereco','$numero','$bairro','$cidade','$estado','$cep','$telefone','$email','$contato','$obs')";
        $valida = mysqli_query($con,$insert);
        if($valida)
        {
            echo 1;
        }else{
            echo 0;
        }
    }
}
elseif($funcao == 2)
{
    $update = "update ignore empresa set bancos = '$bancos', susep = '$susep', razao = '$razao', fantasia = '$fantasia', cnpj = '$cnpj', telefone = '$telefone', contato = '$contato', email = '$email', cep = '$cep', endereco = '$endereco', bairro = '$bairro', cidade = '$cidade', numero = '$numero', estado = '$estado', obs = '$obs' where id = '$id'";
    $valida = mysqli_query($con,$update);
    if($valida)
    {
        echo 1;
    }else{
        echo 0;
    }
}
elseif($funcao == 3)
{
    $delete = "delete from empresa where id = '$id'";
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

?>