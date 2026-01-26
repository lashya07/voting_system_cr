<?php
session_start();
session_destroy();
header("Location: ../htmll/login.html");
exit();
?>
