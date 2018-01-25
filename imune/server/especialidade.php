<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$nome       = utf8_decode($_POST['nome']);
    @$procedimentos       = explode(";",utf8_decode($_POST['procedimentos']));
    @$busca      = $_POST['busca'];
    @$id         = $_POST['id'];
    $today       = date("Y-m-d H:i:s");

$empresa    = $_SESSION['imunevacinas']['usuarioEmpresa'];

// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from especialidade where grp_emp_id = '$empresa' and nome = '$nome'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            echo 2;
        }
        else
        {
            $insert = "insert ignore into especialidade(nome,grp_emp_id)values('$nome','$empresa')";
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
        $update = "update ignore especialidade set nome = '$nome' where id = '$id'";

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
        $delete = "delete from especialidade where id = '$id'";
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