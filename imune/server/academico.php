<?php
    require_once "seguranca.php";
    $grp_emp_id     = $_SESSION['imunevacinas']['usuarioEmpresa'];
    @$id            = $_POST['id'];
    @$matricula     = $_POST['matricula'];
    @$empresa       = $_POST['empresa'];
    @$curso         = $_POST['curso'];
    @$turno         = $_POST['turno'];
    @$turma         = $_POST['turma'];
    @$modalidade    = $_POST['modalidade'];
    @$status        = $_POST['status'];
    @$convenio      = $_POST['convenio'];


    $select         = "select * from academico where pes_id = '$id' and matricula = '$matricula' and curso = '$curso'";
    $valida         = mysqli_query($con,$select);
    if(mysqli_num_rows($valida) > 0){
        echo 99999999999;
    }
    else{
        if($row = mysqli_fetch_array($valida)){

        }
        $query = "insert ignore into academico(pes_id,matricula,curso,turno,turma,convenio,modalidade,emp_id,status,grp_emp_id)values('$id','$matricula','$curso','$turno','$turma','$convenio','$modalidade','$empresa','$status','$grp_emp_id')";
        if(mysqli_query($con,$query)){
            echo mysqli_insert_id($con);
        }else{
            echo 0;
        }
    }
?>