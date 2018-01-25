<?php
    require_once "seguranca.php";
mysqli_set_charset($con,"utf8");
    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];
    @$id         = $_POST['id'];
    @$ficha      = $_POST['ficha'];
    @$ficha2      = $_POST['antigo'];
    @$title      = $_POST['title'];
    @$obs        = $_POST['obs'];
    @$cli_id     = $_POST['cli_id'];
    @$den_id     = $_POST['den_id'];

    @$start = $_POST['start'];

    @$end = $_POST['end'];


    @$color      = $_POST['color'];
    @$dataAtual  = date('Y-m-d H:i:s');
    @$status     = $_POST['status'];
    @$tipo       = $_POST['tipo'];
    @$us_id     = $_SESSION['imunevacinas']['usuarioID'];
    @$us_nome     = $_SESSION['imunevacinas']['usuarioNome'];

    $emp_id      = $_SESSION['imunevacinas']['usuarioEmpresa'];




    if($funcao == 1)
    {
        $interno = " |*| O usuário: ".$us_id.": inseriu!";
        $query = "insert into consulta(first,tipo,us_id,emp_id,obs,ficha,cli_id,cli_nome,den_id,dt_start,dt_end,color,status,interno,ficha2)values('$status','$tipo','$us_id','$emp_id','$obs','$ficha','$cli_id','$title','$den_id','$start','$end','$color','$status','$interno','$ficha2')";
        //echo $query;
        if($valida = mysqli_query($con,$query)){
            echo 1;
            if($status == 5){
                $query = "update pessoa set contador = contador + 1 where id = '$cli_id'";
                $valida= mysqli_query($con,$query);
            }
            else if($status == 3){
                $query = "update pessoa set contador = 0 where id = '$cli_id'";
                $valida= mysqli_query($con,$query);
            }
        }else{
            echo 0;
        }



    }elseif($funcao == 2){
        $interno = " |*| O usuário: ".$us_id.": atualizou(Tipo:$tipo,Status:$status,Pasta:$ficha)!";
        $query = "update consulta set interno = concat(interno,'$interno'), tipo = '$tipo',  emp_id = '$emp_id', obs = '$obs', ficha = '$ficha',  cli_id = '$cli_id', cli_nome = '$title', den_id = '$den_id', dt_start = '$start', dt_end = '$end', color = '$color', status = '$status' where id = '$id'";
        
        if($valida = mysqli_query($con,$query)){
            echo 1;
            if($status == 5){
                $query = "update pessoa set contador = contador + 1 where id = '$cli_id'";
                $valida= mysqli_query($con,$query);
            }
            else if($status == 3){
                $query = "update pessoa set contador = 0 where id = '$cli_id'";
                $valida= mysqli_query($con,$query);
            }
        }else{
            echo 0;
        }


    }elseif($funcao == 3){
        $query = "delete from consulta where id = '$id'";
        if($valida= mysqli_query($con,$query)){
            echo 1;
            $query = "update controle set id = 1";
            $valida = mysqli_query($con,$query);
        }else{
            echo 0;
        }

    }



?>