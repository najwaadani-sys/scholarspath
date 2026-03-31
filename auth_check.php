<?php

function checkRole($required_role = null) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    
    if ($required_role && $_SESSION['role'] !== $required_role) {
        if ($_SESSION['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    }
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}
?>