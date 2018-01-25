<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$cod        = $_POST['cod'];
    @$banco      = utf8_decode($_POST['banco']);
    @$agencia    = $_POST['agencia'];
    @$conta      = $_POST['conta'];
    @$contato    = utf8_decode($_POST['contato']);
    @$saldo      = $_POST['saldo'];
    @$obs        = utf8_decode($_POST['obs']);
    @$id         = $_POST['id'];
    $today       = date("Y-m-d H:i:s");
    $grupoEmpresa       = $_SESSION['imunevacinas']['usuarioEmpresa'];


// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {

        $insert = "insert ignore into banco(grp_emp_id,cod,banco,agencia,conta,contato,saldo,obs)values('$grupoEmpresa','$cod','$banco','$agencia','$conta','$contato','$saldo','$obs')";
        $valida = mysqli_query($con,$insert);

        if($valida)
        {
            echo 1;
        }else{
            echo 0;
        };

    }
    elseif($funcao == 2)
    {
        $update = "update ignore banco set cod = '$cod', obs = '$obs', saldo = '$saldo', banco = '$banco', agencia = '$agencia', conta = '$conta', contato = '$contato' where id = '$id'";

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
        $delete = "delete from banco where id = '$id'";
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