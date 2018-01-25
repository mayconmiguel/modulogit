<?php
    require_once "seguranca.php";

    // recebimento de variáveis metodo post apenas.
    @$funcao     = $_POST['funcao'];


    @$id         = $_POST['id'];
    @$pes_id         = $_POST['pes_id'];
    @$prefixo         = $_POST['prefixo'];
    @$minTime        = $_POST['minTime'];
    @$maxTime        = $_POST['maxTime'];
    @$slotDuration   = $_POST['slotDuration'];
    @$slotLabelInterval = $_POST['slotDuration'];
    @$almoco         = $_POST['almoco'];
    @$businessHours  = $_POST['businessHours'];
    $today       = date("Y-m-d H:i:s");

$empresa    = $_SESSION['imunevacinas']['usuarioEmpresa'];

// validando se é inclusão, exclusão ou edição de dados.

    if($funcao == 1)
    {
        $select = "select * from agenda where grp_emp_id = '$empresa' and pes_id='$pes_id'";
        $valida = mysqli_query($con,$select);
        if($row = mysqli_fetch_array($valida))
        {
            echo 2;
        }
        else
        {
            $insert = "insert ignore into agenda(prefixo,pes_id,almoco,minTime,maxTime,slotDuration,slotLabelInterval,businessHours,grp_emp_id)values('$prefixo','$pes_id','$almoco','$minTime','$maxTime','$slotDuration','$slotLabelInterval','$businessHours','$empresa')";

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
        $update = "update ignore agenda set pes_id = '$pes_id', prefixo = '$prefixo', slotDuration = '$slotDuration', slotLabelInterval = '$slotDuration', minTime = '$minTime', maxTime = '$maxTime',almoco = '$almoco',businessHours = '$businessHours' where id = '$id'";

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
        $delete = "delete from agenda where id = '$id'";
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