<?php

// diretorios

$apikey = 'THMPV-77D6F-94376-8HGKG-VRDRQ';

$apiuser = 'imunevacinas';

$username =
$password =
$mod = NULL;
require_once "seguranca.php";
mysqli_set_charset($con,'utf8');
// Método para mod_php (Apache)
if ( isset( $_SERVER['PHP_AUTH_USER'] ) ):
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $mod = 'PHP_AUTH_USER';

// Método para demais servers
elseif ( isset( $_SERVER['HTTP_AUTHORIZATION'] ) ):

    if ( preg_match( '/^basic/i', $_SERVER['HTTP_AUTHORIZATION'] ) )
        list( $username, $password ) = explode( ':', base64_decode( substr( $_SERVER['HTTP_AUTHORIZATION'], 6 ) ) );

    $mod = 'HTTP_AUTHORIZATION';

endif;



if($username == $apiuser && $password == $apikey){
    $nome           = @$_POST['nome'];
    $funcao         = @$_POST['funcao'];
    $setor          = @$_POST['setor'];
    $categoria      = @$_POST['categoria'];
    $obs            = @$_POST['obs'];
    $status         = @$_POST['status'];
    $tipo           = @$_POST['tipo'];
    $dt_cad         = date('Y-m-d H:i:s');
    $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
    $usuario = $_SESSION['imunevacinas']['usuarioID'];


    if($funcao == 1){
        $query = "insert ignore into solicitacao(pes_id,dt_cad,set_id,cat_id,solicitacao,ope_id,status,grp_emp_id)values('$nome','$dt_cad','$setor','$categoria','$obs','".$usuario."','$status','$empresa')";
    }
    else if($funcao == 2){
        $update = "update solicitacao set status = $status where id = '".$_POST['sol_id']."'";
        mysqli_query($con,$update);
        $query = "insert ignore into solicitacao_ext(sol_id,obs,ope_id,tipo)value('".$_POST['sol_id']."','".$obs."','".$usuario."','".$tipo."')";
    }
    else if($funcao == 3){
        $dt_end = date('Y-m-d H:i:s');
        $update = "update solicitacao set status = '$status', dt_end = '$dt_end' where id = '".$_POST['sol_id']."'";
        mysqli_query($con,$update);
        if($obs == ""){
            $query = "update solicitacao set status = '$status', dt_end = '$dt_end' where id = '".$_POST['sol_id']."'";
        }else{

            $query = "insert ignore into solicitacao_ext(sol_id,obs,ope_id,tipo)value('".$_POST['sol_id']."','".$obs."','".$usuario."','".$tipo."')";
        }
    }


    if(mysqli_query($con,$query)){
        header('WWW-Authenticate: Basic realm="Bem-vindo"');
        header('HTTP/1.0 200 OK');
        echo 1;
    }else{
        header('HTTP/1.0 401 Unauthorized');
    }

}
else{
    header('WWW-Authenticate: Basic realm="Acesso negado!"');
    header('HTTP/1.0 401 Unauthorized');
    die('Acesso negado.');
}
?>