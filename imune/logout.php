
<?php
require_once "server/seguranca.php";


// Initialize the session.
// If you are using session_name("something"), don't forget it now!
@session_start();
auditoria($_SESSION['imunevacinas']['usuarioID'],date('Y-m-d H:i:s'),"SISTEMA","LOGOUT",utf8_decode("O usuário: ".$_SESSION['imunevacinas']['usuarioNome']." se desconectou ao sistema."),$con);
// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()])) {
    @setcookie(session_name(), '', time()-42000, '/');
}

// Finally, destroy the session.
session_destroy();

?>
<script> location.replace('<?php echo "http://".$_SERVER['HTTP_HOST']."/".$pasta."/login.php";?>'); </script>
<?php
?>