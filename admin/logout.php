<?php
session_start();
session_unset();
session_destroy();

if (isset($_COOKIE['admin'])) {
    setcookie('admin', '', time() - 3600, "/");
}

header("Location: ../loginuser.php?logout=admin");
exit;
