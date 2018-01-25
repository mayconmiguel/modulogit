<?php
    require_once "seguranca.php";
    $grp_emp_id     = $_SESSION['imunevacinas']['usuarioEmpresa'];
    @$id            = $_POST['id'];
    @$numero     = $_POST['numero'];
    @$empresa       = $_POST['empresa'];
    @$especialidade         = $_POST['especialidade'];



    $select         = "select * from pasta where pes_id = '$id' and esp_id = '$especialidade' and emp_id = '$empresa'";
    $valida         = mysqli_query($con,$select);
    if(mysqli_num_rows($valida) > 0){
        echo 99999999999;
    }
    else{
        if($row = mysqli_fetch_array($valida)){

        }
        if($numero == 0){
            $query = "insert ignore into pasta(pes_id,esp_id,emp_id,grp_emp_id)values('$id','$especialidade','$empresa','$grp_emp_id')";
            if(mysqli_query($con,$query)){
                echo mysqli_insert_id($con);
                $last = mysqli_insert_id($con);
                $update = "update pasta set numero = concat(pes_id,'.',emp_id,'.',esp_id) where id = '$last'";
                mysqli_query($con,$update);
            }else{
                echo 0;
            }
        }
        else{
            $query = "insert ignore into pasta(pes_id,numero,esp_id,emp_id,grp_emp_id)values('$id','$numero','$especialidade','$empresa','$grp_emp_id')";
            if(mysqli_query($con,$query)){
                echo mysqli_insert_id($con);
            }else{
                echo 0;
            }
        }


    }

?>