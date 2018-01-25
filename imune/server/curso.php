<?php
require_once "seguranca.php";

// recebimento de variáveis metodo post apenas.
@$funcao     = $_POST['funcao'];
@$nome       = utf8_decode($_POST['nome']);
@$periodos       = $_POST['periodos'];
@$rep_padrao   = $_POST['rep_padrao'];
@$rep_diferenciado = $_POST['rep_diferenciado'];
@$tipo       = $_POST['tipo'];
@$busca      = $_POST['busca'];
@$disciplinas  = implode(",",$_POST['disciplinas']);
@$id         = $_POST['id'];
$today       = date("Y-m-d H:i:s");
$grupoEmpresa = $_SESSION['imunevacinas']['usuarioEmpresa'];



// validando se é inclusão, exclusão ou edição de dados.

if($funcao == 1)
{
    $select = "select * from curso where grp_emp_id = $grupoEmpresa and  nome = '$nome'";
    $valida = mysqli_query($con,$select);
    if($row = mysqli_fetch_array($valida))
    {
        $cen_id = $row['id'];
        $nome = $row['nome'];
        echo 2;
    }
    else
    {
        $insert = "insert ignore into curso(nome,tipo,periodos,rep_padrao,rep_diferenciado,disciplinas,grp_emp_id)values('$nome','$tipo','$periodos','$rep_padrao','$rep_diferenciado','$disciplinas','$grupoEmpresa')";

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
    $update = "update ignore curso set nome = '$nome', tipo = '$tipo', rep_padrao = '$rep_padrao', rep_diferenciado = '$rep_diferenciado', periodos = '$periodos',disciplinas = '$disciplinas' where id = '$id'";

    $valida = mysqli_query($con,$update);
    if($valida)
    {
        echo 1;
    }else{
        echo 0;
    };
}
elseif($funcao == 3)
{
    $delete = "delete from curso where id = '$id'";
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