<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_GET['funcao'];
    @$nome       = utf8_decode($_POST['nome']);
    @$cpf       = str_replace("/","",str_replace("-","",str_replace(".","",$_POST['cpf'])));
    @$acesso     = $_POST['acesso'];

    @$usuario    = $_POST['usuario'];
    if(isset($_POST['status'])){
        $status = 1;
    }else{
        $status = 0;
    }

    @$senha      = $_POST['senha'];

    @$busca      = $_POST['busca'];
    @$id         = $_GET['id'];

    @$menus      = explode(",",$_POST['menu']);
    foreach($menus as $menu){
        @$m .= $menu.",";
    }
    $m = substr($m,0,strlen($m)-1);
    @$grupoEmpresa      = $_SESSION['imunevacinas']['usuarioEmpresa'];



// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from usuarios where grp_emp_id = $grupoEmpresa and email = '$usuario'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            echo 2;
        }
        else
        {
            $insert = "insert ignore into usuarios(grp_emp_id,nome,email,senha,menus,status,acesso)values('$grupoEmpresa','$nome','$usuario','$senha','$m',1,'$acesso')";
            $valida = mysqli_query($con,$insert);
            //echo $insert;
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
        $update = "update usuarios set email = '$usuario', senha = '$senha', nome = '$nome', menus = '$m', acesso = '$acesso',status = '$status' where id = '$id'";

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
        $delete = "delete from usuarios where id = '$id'";
        
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