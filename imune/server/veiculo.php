<?php
require_once "seguranca.php";
$funcao = $_POST['funcao'];
@$marca      = $_POST['marca'];
@$img      = "uploads/".$_POST['img'];
@$modelo     = $_POST['modelo'];
@$cor        = $_POST['cor'];
@$ano_fab    = $_POST['ano_fab'];
@$ano_mod    = $_POST['ano_mod'];
@$valor      = $_POST['valor'];
@$status     = $_POST['status'];
@$destaque   = $_POST['destaque'];
@$mostrarpreco=$_POST['mostrarpreco'];
@$placa      = $_POST['placa'];
@$chassi     = $_POST['chassi'];
@$obs        = $_POST['obs'];
@$id         = $_POST['id'];

$campos = "img,mar_id,mod_id,cor_id,ano_fab,ano_mod,valor,status,veiculodestaque,mostrapreco,placa,chassi,obs,";
$valores = "'".$img."','".$marca."','".$modelo."','".$cor."','".$ano_fab."','".$ano_mod."','".$valor."','".$status."','".$destaque."','".$mostrarpreco."','".$placa."','".$chassi."','".$obs."',";

@$opcionais  = $_POST['opcionais'];
@$fotos      = $_POST['fotos'];

if($funcao == 1){
    /*foreach($_POST as $key => $value)
    {
        @$campos .= $key.",";
        @$valores .= "'".$value."',";
    }*/

    $campos .= "grp_emp_id,dt_cad";
    $valores.= "'".$_SESSION['imunevacinas']['usuarioEmpresa']."','".date('Y-m-d H:i:s')."'";
    mysqli_set_charset($con,"utf8");
    $query = "insert ignore into veiculo($campos)values($valores)";
    //echo $query;
    if(strpos($query, 'drop ') !== false || strpos($query, 'alter ') !== false || strpos($query, 'delete ') !== false || strpos($query, 'replace ') !== false) {

    }else{
        if(mysqli_query($con,$query)){
            $ult_id = (int)mysqli_insert_id($con);

            $tab1 = 'veiculo_acessorios';
            $tab2 = 'veiculo_fotos';

            foreach($opcionais as $id){
                $quel = "insert into ". $tab1."(vei_id,ace_id)values('$ult_id','$id')";

                mysqli_query($con,$quel);
            }
            foreach($fotos as $id){
                $quel = "insert into ". $tab2."(vei_id,url)values('$ult_id','uploads/$id')";

                mysqli_query($con,$quel);
            }

            echo $ult_id;
        }else{
            echo mysqli_errno($con)." - ".mysqli_error($con);
        }
    }
}

 else if($funcao == 2){
     $campos .= "grp_emp_id,dt_cad,id";
     $valores.= "'".$_SESSION['imunevacinas']['usuarioEmpresa']."','".date('Y-m-d H:i:s')."','".$_POST['id']."'";
     mysqli_set_charset($con,"utf8");
     $query = "insert ignore into veiculo($campos)values($valores)";
     //echo $query;
     if(strpos($query, 'drop ') !== false || strpos($query, 'alter ') !== false || strpos($query, 'delete ') !== false || strpos($query, 'replace ') !== false) {

     }else{
         mysqli_query($con,"delete from veiculo where id = '".$_POST['id']."'");
         mysqli_query($con,"delete from veiculo_acessorios where vei_id = '".$_POST['id']."'");
         mysqli_query($con,"delete from veiculo_fotos where vei_id = '".$_POST['id']."'");
         if(mysqli_query($con,$query)){
             $ult_id = (int)mysqli_insert_id($con);

             $tab1 = 'veiculo_acessorios';
             $tab2 = 'veiculo_fotos';

             foreach($opcionais as $id){
                 $quel = "insert into ". $tab1."(vei_id,ace_id)values('$ult_id','$id')";

                 mysqli_query($con,$quel);
                 $quel = '';
             }
             foreach($fotos as $id2){
                 if(!empty($id2)){
                     $quel = "insert into ". $tab2."(vei_id,url)values('$ult_id','uploads/$id2')";
                     mysqli_query($con,$quel);
                     $quel = '';
                 }


             }

             echo $ult_id;
         }else{
             echo mysqli_errno($con)." - ".mysqli_error($con);
         }
     }
}

 elseif($funcao == 3)
 {
     $delete = "delete from veiculo where id = '".$_POST['id']."'";
     $valida = mysqli_query($con,$delete);
     if($valida)
     {
         mysqli_query($con,"delete from veiculo_acessorios where vei_id = '".$_POST['id']."'");
         mysqli_query($con,"delete from veiculo_fotos where vei_id = '".$_POST['id']."'");
         echo 1;
     }
     else
     {
         echo 0;
     }
 };
mysqli_close ( $con );

?>