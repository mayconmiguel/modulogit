<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$nome       = utf8_decode($_POST['nome']);

    @$desc_min   = $_POST['desc_min'];
    @$desc_max   = $_POST['desc_max'];
    @$busca      = $_POST['busca'];
    @$id         = $_POST['id'];
    $today       = date("Y-m-d H:i:s");
    $grupoEmpresa       = $_SESSION['imunevacinas']['usuarioEmpresa'];


// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from convenio where grp_emp_id = $grupoEmpresa and  nome = '$nome'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            echo 2;
        }
        else
        {
            $insert = "insert ignore into convenio(grp_emp_id,nome,desc_min,desc_max)values('$grupoEmpresa','$nome','$desc_min','$desc_max')";
            $valida = mysqli_query($con,$insert);
            if($valida)
            {
                echo 1;
            }else{
                echo 0;
            };
        }
    }
    elseif($funcao == 2)
    {
        $update = "update ignore convenio set nome = '$nome', desc_min = '$desc_min', desc_max = '$desc_max' where id = '$id'";

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
        $delete = "delete from convenio where id = '$id'";
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