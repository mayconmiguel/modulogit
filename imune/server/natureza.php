<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$nome       = utf8_decode($_POST['nome']);
    @$busca      = $_POST['busca'];
    @$id         = $_POST['id'];
    $today       = date("Y-m-d H:i:s");
    $grupoEmpresa       = $_SESSION['imunevacinas']['usuarioEmpresa'];


// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from natureza where grp_emp_id = $grupoEmpresa and  nome = '$nome'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            $cen_id = $row['id'];
            $nome = $row['nome'];
            echo 2;
        }
        else
        {
            $insert = "insert ignore into natureza(grp_emp_id,nome)values('$grupoEmpresa','$nome')";
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
        $update = "update ignore natureza set nome = '$nome' where id = '$id'";

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
        $delete = "delete from natureza where id = '$id'";
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