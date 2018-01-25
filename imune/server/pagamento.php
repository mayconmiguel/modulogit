<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$nome       = utf8_decode($_POST['nome']);
    @$condicao   = $_POST['condicao'];
    @$taxa       = $_POST['taxa'];
    @$busca      = $_POST['busca'];
    @$ban_id     = $_POST['banco'];
    @$emp_id     = $_POST['empresa'];
    @$id         = $_POST['id'];
    @$tipo       = $_POST['tipo'];
    $today       = date("Y-m-d H:i:s");
    $grupoEmpresa       = $_SESSION['imunevacinas']['usuarioEmpresa'];


// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from pagamento where grp_emp_id = '$grupoEmpresa' and  nome = '$nome'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            echo 2;
        }
        else
        {
            $insert = "insert ignore into pagamento(grp_emp_id,tipo,nome,condicao,taxa,ban_id,emp_id)values('$grupoEmpresa','$tipo','$nome','$condicao','$taxa','$ban_id','$emp_id')";
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
        $update = "update ignore pagamento set tipo = '$tipo', nome = '$nome', condicao = '$condicao', taxa = '$taxa', ban_id = '$ban_id', emp_id = '$emp_id' where id = '$id'";

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
        $delete = "delete from pagamento where id = '$id'";
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