<?php
function auditoria($pes_id,$modulo,$acao,$obs,$con,$grupoEmpresa){
    $query   = "insert into auditoria(grp_emp_id,pes_id,modulo,acao,obs)values('$grupoEmpresa','$pes_id','$modulo','$acao','$obs')";
    mysqli_query($con,$query);
    mysqli_close ( $con );
}
?>