<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$nome       = utf8_decode($_POST['nome']);
    @$busca      = $_POST['busca'];
    @$tipo       = $_POST['tipo'];
    @$naturezas  = implode(",",$_POST['naturezas']);
    @$id         = $_POST['id'];
    $today       = date("Y-m-d H:i:s");
    $grupoEmpresa = $_SESSION['imunevacinas']['usuarioEmpresa'];



// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from modelo where grp_emp_id = '$grupoEmpresa' and nome = '$nome'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            $cen_id = $row['id'];
            $nome = $row['nome'];
            echo 2;
        }
        else
        {
            $insert = "insert ignore into modelo(nome,mar_id,grp_emp_id)values('$nome','$naturezas','$grupoEmpresa')";
            
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
        $update = "update ignore modelo set nome = '$nome', mar_id = '$naturezas' where id = '$id'";

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
        $delete = "delete from modelo where id = '$id'";
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