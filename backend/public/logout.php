//<!-- archivo para cerrar sesión -->
<?php
session_start();
session_unset();
session_destroy();
header("Location: loginView.php");
exit;
