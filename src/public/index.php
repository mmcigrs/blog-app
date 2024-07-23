<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ./user/signin.php');
    exit();
}

require_once './components/header.php'; 

echo 'Welcome TECH QUEST!';
